<?php

use PHPUnit\Framework\TestCase;
use App\Services\ItinaryService;

class GetNextStepItinaryTest extends TestCase
{
// Use Case 1 Valid
// Use Case 2 No Itinary
// Use Case 4 Donnée Incorrect
    /**
     * Provides valid datas to service test.
     */
    public static function valid_itinary_provider()
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
                                    "departure" => "Barcelone",
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
     * Use Case find next step of departure
     * @covers \App\Services\ItinaryService::find_next_step
     * @valid_itinary_provider
     */
    public function test_get_valid_next_step($datas)
    {
        $itinaryService = new ItinaryService();
        $step_departure = $itinaryService->find_departure_itinary($datas);
        $next_step = $itinaryService->find_next_step($step_departure, $datas);
        $this->assertIsArray($$next_step);
    }


    /**
     * Provides valid datas but departure or arrival can be write with different transit point to service test.
     */
    public static function valid_next_step_with_extract_city_provider()
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
                                    "departure" => "Gérone",
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
     * Use Case get valid datas but departure or arrival can be write with different transit point
     * @covers \App\Services\ItinaryService::find_departure_itinary
     * @valid_next_step_with_extract_city_provider
     */
    public function  test_get_step_next_with_extract_city($datas)
    {
        $itinaryService = new ItinaryService();
        $step_departure = $itinaryService->find_departure_itinary($datas);
        $this->assertIsArray($step_departure);
        $this->assertEquals("Madrid", $step_departure["departure"]);
    }

    /**
     * Provides empty datas to service test.
     */
    public static function empty_itinary_provider()
    {
        return  [['datas' => [] ]];
    }
     /**
     * @test
     * Use Case provider send empty datas
     * @covers \App\Services\ItinaryService::find_next_step
     * @empty_itinary_provider
     * @expectedException : possibilité de renvoyer une erreur là ou dans une autre fonction
     */
    public function test_get_step_next_intinary_with_empty_datas($datas)
    {
        $itinaryService = new ItinaryService();
        $step_departure = $itinaryService->find_departure_itinary($datas);
        $this->assertIsArray($step_departure);
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
     * @covers \App\Services\ItinaryService::find_next_step
     * @no_itinary_provider
     * @expectedException : possibilité de renvoyer une erreur là ou dans une autre fonction
     */
    public function test_get_next_step_intinary_with_null_datas($datas)
    {
        $itinaryService = new ItinaryService();
        $step_departure = $itinaryService->find_departure_itinary($datas);
        $this->assertIsArray($step_departure);
        $this->expectException(ApiException::class);

    }

     /**
     * Provides wrong datas to service test.
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
     * Use Case get wrong datas to provider
     * @covers \App\Services\ItinaryService::find_next_step
     * @incorrect_datas_provider
     * @expectedException : An error has occurred, wrong datas
     */
    public function test_get_next_step_intinary_with_wrong_datas($datas)
    {
        $itinaryService = new ItinaryService();
        $itinaryService->find_departure_itinary($datas);
        $this->expectException(ApiException::class);
    }

}