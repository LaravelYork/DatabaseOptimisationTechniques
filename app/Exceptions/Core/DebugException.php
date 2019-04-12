<?php

namespace App\Exceptions\Core;

use Exception;
use App\Exceptions\Handler;

class DebugException extends Exception
{

    public static function stack(){

        try {
            throw new DebugException();
        } catch(DebugException $e){
            $stack = Handler::traceStack($e);
        }

        array_shift($stack); //remove this throw
        array_shift($stack); //remove this method

        return $stack;

    }
}
