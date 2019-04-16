<?php

namespace App\Http\Controllers\Home;

use Exception;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use App\Models\User;

class TransactionController extends Controller
{

    public function transact(Request $r){
        
        $sucessfullyCreatedTwoUsers = false;
        $factory = factory(User::class, 2);

        $newUsers = $factory->make();
        $emails = $newUsers->pluck('email')->toArray();

        DB::beginTransaction();

        try {

            $newUsers->each(function ($user) {

                $user->save();
            });

            //throw new Exception("Some thing exceptional happened");

            DB::commit();

            $sucessfullyCreatedTwoUsers = true;

        } catch (Exception $e) {

            DB::rollBack();

            $sucessfullyCreatedTwoUsers = false;
        }

        $emailsFound = User::whereIn('email', $emails)->count();
        
        return view('transaction', compact('emailsFound', 'sucessfullyCreatedTwoUsers'));

    }

    public function retryWithDeadlocks(Request $r){

        DB::transaction(function(){

            User::where('id',18)->update(['updated_At' => now()]);
            User::where('id',19)->update(['updated_At' => now()]);

        }, 5);

    }

}