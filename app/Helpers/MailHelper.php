<?php
namespace App\Helpers;
use App\Models\User;

class MailHelper
{
    public static function adminBcc(): ?string
    {
        $admin = User::where('role', 'admin')->first();
        return $admin?->email;
    }
}
