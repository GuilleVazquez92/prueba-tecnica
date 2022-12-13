<?php

namespace App\Exceptions;

use Exception;

class NoParamsException  extends Exception
{
    public function errorMessage()
    {
        $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile()
        .': <b>'.$this->getMessage();
        return json_encode([ 'errors' => $errorMsg, ], 500);

    }
}
