<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use DateTime;

class AuthController extends BaseController
{
    public function index()
    {
        //
    }

    public function signup()
    {
        $userModel = new UserModel();

        $data = $this->request->getPost(); // Get POST data

        // Validation rules
        $validationRules = [
            'firstName'       => 'required',
            'lastName'        => 'required',
            'email'           => 'required|valid_email|is_unique[users.email]',
            'password'        => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
        ];

        if (!$this->validate($validationRules, $this->validationMessages())) {
            // Set validation errors in session flash data and redirect back
            return redirect()->back()
                ->with('errors', $this->validator->getErrors()) // Pass errors to the session
                ->withInput(); // Keep input values
        }

        $token = generateToken(64);
        $hashedToken = hashToken($token);

        // Insert user
        $userModel->save([
            'firstName' => $data['firstName'],
            'lastName'  => $data['lastName'],
            'email'     => $data['email'],
            'is_verified'     => 'N',
            'verification_token'  => $hashedToken,
            'token_expiration' => $this->generateExpiryDatetime(30),
            'password'  => $data['password'], // Password will be hashed by UserModel's beforeInsert
        ]);

        $this->sendVerificationEmail($data['email'], $token);

        $thank_you_token = bin2hex(random_bytes(16));
        session()->set('thank_you_token', $thank_you_token);
        session()->set('email', $data['email']);

        return redirect()->to('/thank-you?token='.$thank_you_token);
    }

    /**
     * Login a user.
     */
    public function login()
    {
        $userModel = new UserModel();

        $data = $this->request->getPost(); // Get POST data

        // Validation rules
        $validationRules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (!$this->validate($validationRules, $this->validationMessages())) {
            // Return validation errors
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        // Find user by email
        $user = $userModel->where('email', $data['email'])->first();

        if (!$user) {
            return redirect()->back()
                ->with('errors', ['login' => 'Invalid email or password.'])
                ->withInput();
        }
        

        // Verify password
        if (!password_verify($data['password'], $user['password'])) {
            return redirect()->back()
                ->with('errors', ['login' => 'Invalid email or password.'])
                ->withInput();
        }

        if ($user['is_verified'] !== 'Y') {
            return redirect()->back()
                ->with('errors', ['verification_error' => 'Account not verified'])
                ->withInput();
        }


        // Set session (or generate token)
        session()->set([
            'user_id'    => $user['id'],
            'firstName'  => $user['firstName'],
            'lastName'   => $user['lastName'],
            'email'      => $user['email'],
            'is_logged_in' => true,
        ]);

       // return $this->response->setJSON(['message' => 'Login successful!']);
        // Redirect to a dashboard or home page
        return redirect()->to('/characters');
    }

    /**
     * Logout a user.
     */
    public function logout()
    {
        session()->destroy(); // Destroy the session
        return redirect()->to('/login')->with('message', 'Logout successful!');
    }

    public function verifyUser()
    {
        //return view('pages/verify-user');
        $token = $this->request->getGet('token');
        $email = $this->request->getGet('email');

        $validationRules = [
            'email'    => 'required|valid_email',
            'token' => 'required',
        ];

        if (!$this->validate($validationRules)) {
            // Return validation errors
            return view('pages/verify-user', [
                'status' => 'invalid',
            ]);
        }
        ///if(!$email) {
        ///    return redirect()->to('/login');
        ///}

        $userModel = new UserModel();

        $user = $userModel->where('email', $email)
                          ->where('token_expiration >=', date('Y-m-d H:i:s'))
                          ->first();
        
        if ($user && password_verify($token, $user['verification_token'])) {
            // Mark user as verified
            $userModel->update($user['id'], [
                'verification_token' => null,
                'token_expiration' => null,
                'is_verified' => 'Y',
            ]);

            return view('pages/verify-user', [
                'status' => 'success',
                'email' => $email
            ]);
            //return redirect()->to('/login')->with('message', 'Your email has been verified! You can now log in.');
        }

        return view('pages/verify-user', [
            'status' => 'error',
            'email' => $email
        ]);
        //return redirect()->to('/sign-up')->with('errors', ['verification_error' => 'Invalid or expired verification link.']);
    }

    public function thankYou()
    {
        $token = $this->request->getGet('token');
        $sessionToken = session()->get('thank_you_token');

        if (!$token || $token !== $sessionToken) {
            return redirect()->to('/login'); // Redirect if the token is invalid
        }

        $email = session()->get('email');
        // Clear the token to prevent re-accessing
        session()->remove('thank_you_token');
        session()->remove('email');

        return view('pages/thank-you', ['email' => $email]);
    }

    private function validationMessages() {
        return [
            'firstName' => [
                'required' => 'The first name is required.',
            ],
            'lastName' => [
                'required' => 'The last name is required.',
            ],
            'email' => [
                'required'    => 'The email is required.',
                'valid_email' => 'The email format is invalid.',
                'is_unique'   => 'The email is already registered.',
            ],
            'password' => [
                'required'   => 'The password is required.',
                'min_length' => 'The password must be at least 6 characters long.',
            ],
            'confirm_password' => [
                'required' => 'Please confirm your password.',
                'matches'  => 'The password confirmation does not match.',
            ],
        ];
    }

    private function generateExpiryDatetime(int $minutes = 30): string
    {
        // Get the current time
        $currentTime = new DateTime();

        // Add the specified number of minutes (default: 30 minutes)
        $currentTime->modify("+{$minutes} minutes");

        // Format the datetime for MySQL DATETIME format (YYYY-MM-DD HH:MM:SS)
        return $currentTime->format('Y-m-d H:i:s');
    }

    private function sendVerificationEmail($email, $token)
    {
        helper('email');
        $recipient = $email; // Change this to the recipient's email
        $subject = 'Verify Your Email';
        $message = '
            <p>Thank you for signing up!</p>
            <p>Please verify your email by clicking the link below:</p>
            <p><a href="' . site_url('verify-user?token='.$token.'&email='.$email) . '">Verify Email</a></p>
            <p>If you didn\'t sign up, please ignore this email.</p>
        ';

        $result = sendEmail($recipient, $subject, $message);

        if ($result === true) {
            echo "Verification email sent successfully!";
        } else {
            echo "Failed to send verification email: " . $result;
        }
    }


    public function resendVerificationLink()
    {
        helper('email');

        $email = $this->request->getGet('email'); // Email input from form or AJAX request

        // Validate the email
        if (!$this->validate(['email' => 'required|valid_email'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid email address provided.',
            ]);
        }

        // Load the User model
        $userModel = new \App\Models\UserModel();

        // Find the user by email
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Email address not found.',
                'emailtest' => $email
            ]);
        }

        // Check if the user is already verified
        if ($user['is_verified'] == 'Y') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'This account is already verified.',
            ]);
        }

        // Generate a new verification token and expiration
        $tokenExpiration = date('Y-m-d H:i:s', strtotime('+30 minutes'));
        $token = generateToken(64);
        $hashedToken = hashToken($token);

        // Update the user record with the new token and expiration
        $userModel->update($user['id'], [
            'verification_token' => $hashedToken,
            'token_expiration' => $tokenExpiration,
        ]);

        // Send the verification email
        $subject = 'Resend: Verify Your Email';
        $message = '
            <p>Click the link below to verify your email:</p>
            <p><a href="' . site_url('verify-user?token=' . $token.'&email='.$email) . '">Verify Email</a></p>
            <p>This link will expire in 30 minutes.</p>
        ';

        $result = sendEmail($email, $subject, $message);

        if ($result === true) {
            return view('pages/resend-verification', ['status' => 'success']);
            //return $this->response->setJSON([
            //    'status' => 'success',
            //    'message' => 'Verification link has been resent. Please check your email.',
            //]);
        } else {
            return view('pages/resend-verification', ['status' => 'error', 'email' => $email]);
            //return $this->response->setJSON([
            //    'status' => 'error',
            //    'message' => 'Failed to send verification email: ' . $result,
            //]);
        }
    }
}
