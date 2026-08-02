<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;

class Login extends BaseLogin
{
    /**
     * Override the view to use our custom split-screen login design
     */
    public function getView(): string
    {
        return 'filament.pages.auth.login';
    }
}
