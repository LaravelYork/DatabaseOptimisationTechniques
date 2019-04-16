<?php

namespace App\Http\Controllers\Home;

use Exception;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use App\Models\User;
use App\Models\Email;

class RelationshipController extends Controller
{

    public function seed(Request $r){

        factory(Email::class, 20)->create();

        $userViewContext = User::orderBy('created_at', 'desc')->first();
        
        return view('user', compact('userViewContext'));
    
    }

    public function emails(Request $r){

        $userViewContext = User::has('emails')->get();
        
        return view('emails', compact('userViewContext'));
    
    }

    public function eagerEmails(Request $r){

        $userViewContext = User::has('emails')->with('emails')->get();
        
        return view('emails', compact('userViewContext'));
    
    }

    public function eagerJoin(Request $r){

        $userViewContext = User::hasEmails()->with('emails')->get();
        
        return view('emails', compact('userViewContext'));
    
    }

}