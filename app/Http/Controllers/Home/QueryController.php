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

        
        $value = User::count();
        //$value = User::max('id');
        //$value = User::avg(DB::raw('DATE_FORMAT(created_at,"%D")'));

        return view('value', compact('value'));

    }


    public function joinGrouping(Request $r){
   
        $query = User::query();

        $query->join('users as duplicateEmails', function ($join) {
            
            $join->on('users.id', '!=', 'duplicateEmails.id');
            $join->where('duplicateEmails.is_validated',1);

        });

        $query->whereColumn('duplicateEmails.email','=', 'users.email');

        $value = $query->pluck('users.id');

        return view('value', compact('value'));

    }

    public function subquery(Request $r){

        
        $latestValitedUserQuery = User::query();
        $latestValitedUserQuery->select('id', DB::raw('MAX(email_verified_at) as max_verified_at'));
        $latestValitedUserQuery->where('is_validated', 1)->groupBy('id');

        $userQuery = User::query();
        
        $userQuery->joinSub($latestValitedUserQuery, 'lv', function ($join) {
            $join->on('users.id', '=', 'lv.id');
        });

        $userViewContext = $userQuery->first();

        return view('user', compact('userViewContext'));

    }

}