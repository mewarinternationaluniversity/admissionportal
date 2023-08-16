<?php

use App\Models\Session;
use Illuminate\Support\Facades\Auth;


function getCurrentSession()
{
    return Session::where('status', 1)->first();
}

function enforceReadOnly()
{
    $user = Auth::user();
    if ($user->hasRole('admin')) {
        if ($user->type == 'readonly') {
            abort(404, 'This action is not available to you');
        }
    }
}


