<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Controllers\StepsController;


/**
 * [Description ApiStepsControllerTest]
 */
class ApiStepsControllerTest extends TestCase
{


    /**
     * Provides valid datas to service test.
     */
    public static function valid_itinary_provider(): array
    {
      return  [
          [
              'datas' => [
                    [
                    'id'=> 2,
                    "departure" => "Madrid",
                    "arrival" => "Barcelone",
                    "transport" => "Train 78A",
                    "seat" => "45B"
                    ],
                    [
                        'id'=> 1,
                        "departure" => "Aéroport de Barcelone",
                        "arrival" => "Aéroport de Gérone",
                        "transport" => "Bus",
                        "seat" => "N/A"
                    ],
                    [
                        'id'=> 3,
                        "departure" => "Aéroport de Gérone",
                        "arrival" => "Stockholm",
                        "transport" => "Vol SK455",
                        "seat" => "3A",
                        "baggages"=> "Guichet 344"
                    ]
                ]
          ]
      ];
    }


  /**
   * @test
   * Use Case find first step in the itinerary
   * @covers \App\Controllers\itineraryCollection::create_itirary
   * @dataProvider valid_itinary_provider
   */
  public function test_api_controller($datas)
    {
        $controller = new StepsController($datas);
        $response =  $controller->index();
        $this->assertIsArray($response);


    }
}