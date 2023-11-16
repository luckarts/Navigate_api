<?php

namespace App\Exceptions;

use App\Exceptions\ApiExceptionInterface;


class ApiException implements ApiExceptionInterface {

    private $codeError;
    private $message;

    /**
     * @param mixed $codeError : int
     * @param mixed $message : sring
     */
    public function __construct(int $codeError,string $message){
        $this->codeError = $codeError;
        $this->message = $message;
    }

    /**
     * *retourne une error json pour de l'api
     * @return string
     */
    public function throwError(): string
    {
        http_response_code($this->codeError);
        $response = [
            "error" => true,
            "message" => $this->message
        ];
        return json_encode($response);
    }
}