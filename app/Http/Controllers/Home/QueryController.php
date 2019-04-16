<?php

namespace App\Http\Controllers\Home;

use Exception;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use App\Models\User;

class QueryController extends Controller
{

    public function single(Request $r){
        
        $value = User::where('id', 18)->value('email');
        
        return view('value', compact('value'));

    }

    public function aggregate(Request $r){

        
        //$value = User::count();
        //$value = User::max('id');
        //$value = User::avg(DB::raw('DATE_FORMAT(created_at,"%D")'));

        return view('value', compact('value'));

    }

}