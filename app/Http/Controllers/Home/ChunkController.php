<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class ChunkController extends Controller
{

    public function chunk(Request $r){

        User::chunk(100, function($users) 
        {
            foreach ($users as $user)
            {   

                $user->touch();
                
            }

        });

        $userViewContext = User::orderBy('updated_at', 'desc')->first();
        
        return view('user', compact('userViewContext'));

    }

    public function chunkBetter(Request $r){

        User::chunk(100, function($users) 
        {   

            $ids = $users->pluck('id');

            User::whereIn('id',$ids->toArray())->update(['updated_at'=>now()]);
            

        });

        $userViewContext = User::orderBy('updated_at', 'desc')->first();
        
        return view('user', compact('userViewContext'));

    }

    public function chunkGotcha(Request $r){

        $verifiedEmailCountBefore = User::whereNotNull('email_verified_at')->count();

        $chunks = [];
        User::whereNotNull('email_verified_at')->chunk(100, function($users) use (&$chunks)
        {   
            
           

            $ids = $users->pluck('id');

            $chunks[] = count($ids);

            $randomIds = $ids->random(2);

            User::whereIn('id',$randomIds->toArray())->update(['email_verified_at'=>null]);
            

        });

        $verifiedEmailCountAfter = User::whereNotNull('email_verified_at')->count();
        
        return view('emailCount', compact('verifiedEmailCountBefore','verifiedEmailCountAfter', 'chunks'));

    }

}