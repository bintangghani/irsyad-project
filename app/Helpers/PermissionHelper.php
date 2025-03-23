<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('haveAccessTo')) {
    function haveAccessTo($permissionName)
    {
        $user = Auth::user();

        if (!$user || !$user->role) {
            return false;
        }

        return $user->role->permissions->contains('nama', $permissionName);
    }
}
