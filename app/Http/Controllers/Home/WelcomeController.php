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

        $firstUser = User::first();
        
        return view('user', compact('firstUser'));

    }

    public function seed(Request $r){

        factory(User::class, 20)->create();

        $firstUser = User::orderBy('created_at', 'desc')->first();
        
        return view('user', compact('firstUser'));

    }

}