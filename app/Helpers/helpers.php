<?php

use App\Models\Session;


function getCurrentSession()
{
    return Session::where('status', 1)->first();
}