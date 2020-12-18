<?php

namespace App\CustomException;

class ExceptionsCustomModel
{
    function __construct($errorException, $errorMessage, $errorCode)
    {
        $this->errorException = $errorException;
        $this->errorMessage = $errorMessage;
        $this->errorCode = $errorCode;
    }

    public function raiseCustomException()
    {
        abort(Response()->json(["exception_error" => $this->errorException,
            "exception_message" => $this->errorMessage],
            $this->errorCode));
    }
}
