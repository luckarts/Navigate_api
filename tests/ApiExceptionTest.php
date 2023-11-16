<?php

use PHPUnit\Framework\TestCase;
use App\Exceptions\ApiException;

class ApiExceptionTest extends TestCase
{


    public function test_throwError(): void
    {
        $error = new ApiException(400, "Une erreur s'est produite. Veuillez vérifier votre requête.");
        $response =["status"=> 400,
        "message"=> "Une erreur s'est produite. Veuillez vérifier votre requête."];
        $this->assertEquals(json_encode($response),$error->throwError());

    }

}
