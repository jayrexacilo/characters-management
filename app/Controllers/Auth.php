<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function signup(): string
    {
        return view('pages/auth/signup');
    }

    public function login(): string
    {
        return view('pages/auth/login');
    }
}
