<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    public $clinicaId;
    public function __construct()
    {
        $this->clinicaId = Auth::user()->clinica_id;
    }
    //
}
