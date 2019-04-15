<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class ChunkController extends Controller
{

    public function chunk(Request $r){

        User::chunk(10, function($users) 
        {
            foreach ($users as $user)
            {   

                $user->touch();
                
            }

        });

        $userViewContext = User::orderBy('updated_at', 'desc')->first();
        
        return view('user', compact('userViewContext'));

    }

    public function seed(Request $r){

       // dont update inside chunk

    }

}