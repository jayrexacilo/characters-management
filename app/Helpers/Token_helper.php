<?php

if (!function_exists('generateToken')) {
    /**
     * Generate a secure token
     *
     * @param int $length The desired length of the token (default: 32)
     * @return string The generated token
     */
    function generateToken(int $length = 32): string
    {
        return bin2hex(random_bytes($length / 2));
    }
}

if (!function_exists('hashToken')) {
    /**
     * Hash a token for secure storage in the database
     *
     * @param string $token The plain token to hash
     * @return string The hashed token
     */
    function hashToken(string $token): string
    {
        return password_hash($token, PASSWORD_DEFAULT);
    }
}

if (!function_exists('verifyToken')) {
    /**
     * Verify a plain token against a hashed token
     *
     * @param string $plainToken The plain token to verify
     * @param string $hashedToken The hashed token to verify against
     * @return bool True if the token matches, false otherwise
     */
    function verifyToken(string $plainToken, string $hashedToken): bool
    {
        return password_verify($plainToken, $hashedToken);
    }
}
