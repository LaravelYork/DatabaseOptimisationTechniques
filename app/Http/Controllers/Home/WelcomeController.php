<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class WelcomeController extends Controller
{

    public function welcome(Request $r){
        return view('welcome');
    }

    public function user(Request $r){

        $userViewContext = User::first();
        
        return view('user', compact('userViewContext'));

    }

    public function seed(Request $r){

        factory(User::class, 20)->create();

        $userViewContext = User::orderBy('created_at', 'desc')->first();
        
        return view('user', compact('userViewContext'));

    }

}