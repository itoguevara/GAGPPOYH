<?php

namespace App\Http\Controllers\generic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PublicFunctions;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class genericctrl extends Controller
{
    //
        public function show(int $opcionvar)
    {
      $message = 'Inicio Exitoso';
     return view('home', compact('opcionvar'));
     
     // return redirect()->route('home', [$opcionvar]);
     //return redirect()->route('home', compact('opcionvar'))->with('opcionvar', $opcionvar);;
     //return redirect()->route('home')->with('opcionvar', $opcionvar);;

    }
}
