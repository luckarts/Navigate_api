<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Controllers\StepsController;


class ApiStepsControllerTest extends TestCase
{
    public  function test_api_controller()
    {
        $controller = new StepsController();
        $response =  $controller->index();
        $this->assertIsArray($response);
      // $this->assertJson($response->getContent());


    }
}