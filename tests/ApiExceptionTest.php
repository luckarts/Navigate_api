<?php

use PHPUnit\Framework\TestCase;
use App\Exceptions\ApiException;

class ApiExceptionTest extends TestCase
{


    /**
     * @test
     * Use Case return error message
     * $error = new ApiException(int $code, string $message)
     * @return void
     */
    public function test_valid_throwError(): void
    {
        $error = new ApiException(400, "Une erreur s'est produite. Veuillez vérifier votre requête.");

        $response =["error"=>true,
        "message"=> "Une erreur s'est produite. Veuillez vérifier votre requête."];

        $this->assertEquals(json_encode($response),$error->throwError());

    }

}
