<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Log;

use Exception;

class CustomException extends Exception
{

    public function report()
    {
        // Enviar para um controle de erros (Sentry)
        Log::info($this->getMessage());
    }
    
    public function render($request)
    {
        return '<h1>Route ' . $request->path() . ' message ' . $this->getMessage() . '</h1>';
    }
} 
