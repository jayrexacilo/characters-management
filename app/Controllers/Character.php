<?php

namespace App\Controllers;

class Character extends BaseController
{
    public function index(): string
    {
        return view('pages/list-characters');
    }

    public function viewCharacter($charID): string
    {
        return view('pages/view-character', [
            'charID' => $charID
        ]);
    }

}
