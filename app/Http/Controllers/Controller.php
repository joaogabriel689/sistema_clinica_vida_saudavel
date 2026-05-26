<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    public $clinicaId = null;
    public function __construct()
    {
        if (Auth::check()) {
            $this->clinicaId = Auth::user()->clinica_id;
        }
    }
    //
}
