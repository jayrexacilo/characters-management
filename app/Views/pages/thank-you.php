<?= $this->extend('main_layout') ?>

<?= $this->section('page_title'); ?>Login<?= $this->endSection(); ?>

<?= $this->section('content') ?>

    <div class="thank-you-container w-50 mx-auto mt-5">
        <div class="thank-you-icon">
            <i class="bi bi-envelope-check-fill"></i>
        </div>
        <h1 class="mb-3">Thank You!</h1>
        <p class="text-muted mb-4">
            A verification link has been sent to your email address.  
            Please check your inbox and click the link to verify your account.
        </p>
        <button class="thank-you-button" onclick="window.location.href='/login'">
            Go to Log-In page
        </button>
        <div class="thank-you-footer">
            Didn't receive an email? Check your spam folder or <a href="/resend-verification?email=<?= $email ?>">resend the verification email</a>.
        </div>
    </div>

<?= $this->endSection() ?>
