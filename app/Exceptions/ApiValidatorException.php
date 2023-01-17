<?php

namespace App\Exceptions;

use Exception;

/**
 * Definir una clase de excepción personalizada
 */
class ApiValidatorException extends Exception
{

    public $error;
    public $message;
    public $code;

    public function __construct($error,$message,$code)
    {
        $this->error = $error;
        $this->message = $message;
        $this->code = $code;
    }
    
    
    // representación de cadena personalizada del objeto
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    public function getError(){
        return $this->error;
    }
}