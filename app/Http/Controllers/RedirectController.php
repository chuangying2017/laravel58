<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectController extends Controller
{

    public function index()
    {
        return view('point.redirect_alert');
    }
}
