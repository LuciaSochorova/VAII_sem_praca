<?php

namespace App\Helpers;

enum Role
{
    case ADMIN;
    case USER;

    public static function fromString(string $string): Role
    {
        switch (strtolower($string)) {
            case strtolower(Role::ADMIN->name):
                return Role::ADMIN;
            default:
                return Role::USER;

        }

    }

}
