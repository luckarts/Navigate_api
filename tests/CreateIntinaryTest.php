I<?php

use PHPUnit\Framework\TestCase;
use App\Exceptions\ApiException;
use App\Services\ItinaryService;

class CreateIntinaryTest extends TestCase
{
// Use Case 1 Valid
// Use Case 2 No Itinary
// Use Case 4 Donnée Incorrect

    /**
     * Provides valid datas to service test.
     */
    public static function valid_itinary_provider():array
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
     * Use Case find first step in the itinary
     * @covers \App\Services\ItinaryService::create_itirary
     * @valid_itinary_provider
     */
    public function test_create_valid_itinerary($datas):void
    {
        $itinaryService = new ItinaryService();
        $itinerarySteps = $itinaryService->create_itirary($datas);
        $this->assertIsArray($itinerarySteps);
    }

    /**
     * Provides empty datas to service test.
     */
    public static function empty_itinary_provider():array
    {
        return  [['datas' => [] ]];
    }
     /**
     * @test
     * Use Case provider send empty datas
     * @covers \App\Services\ItinaryService::create_itirary
     * @empty_itinary_provider
     * @expectedException : possibilité de renvoyer une erreur là ou dans une autre fonction
     */
    public function test_create_intinary_with_empty_datas($datas)
    {
        $itinaryService = new ItinaryService();
        $itinerarySteps = $itinaryService->create_itirary($datas);
        $this->assertIsArray($itinerarySteps);
        $this->assertEmpty($itinerarySteps);
    }

    /**
     * Provides null datas to service test.
     */
    public static function no_itinary_provider()
    {
        return  [['datas' => null ]];
    }
     /**
     * @test
     * Use Case provider send null datas
     * @covers \App\Services\ItinaryService::create_itirary
     * @no_itinary_provider
     * @expectedException : possibilité de renvoyer une erreur là ou dans une autre fonction
     */
    public function test_create_intinary_with_null_datas($datas) : void
    {
        $itinaryService = new ItinaryService();
        $itinerarySteps = $itinaryService->create_itirary($datas);
        $this->assertNull($itinerarySteps);
        //$this->expectException();

    }


     /**
     * Provides incorrect datas to service test.
     */
    public static function wrong_datas_provider()
    {
        return  [['datas' => [
                                [
                                'id'=> 2,
                                "depart" => "Madrid",
                                "arrive" => "Barcelone",
                                "transport" => "Train 78A",
                                "seat" => "45B"
                                ],
                            ]
                 ]];
    }
     /**
     * @test
     * Use Case
     * @covers \App\Services\ItinaryService::create_itirary
     * @incorrect_datas_provider
     * @expectedException : An error has occurred, wrong datas
     */
    public function test_create_intinary_with_wrong_datas($datas) : void
    {
        $itinaryService = new ItinaryService();
        $itinerarySteps = $itinaryService->create_itirary($datas);
        $this->assertIsArray($itinerarySteps);
        $this->expectException(ApiException::class);
    }
}