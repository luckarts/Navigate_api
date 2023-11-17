<?php

use PHPUnit\Framework\TestCase;
use App\Exceptions\ApiException;
use App\Services\ItinaryService;
use Collections\ItinaryCollection;

class GetNextStepItinaryTest extends TestCase
{
// Use Case 1 Valid
// Use Case 2 No Itinary
// Use Case 4 Donnée Incorrect

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
     * @covers \App\Collections\ItinaryCollection::find_next_step
     * @dataProvider valid_itinary_provider
     */
    public function test_get_valid_next_step(array $datas): void
    {
        $itinaryCollection = new ItinaryCollection($datas);
        $step_departure = $itinaryCollection->find_departure_itinary();
        $next_step = $itinaryCollection->find_next_step($step_departure);
        $this->assertIsArray($next_step);
        $this->assertEquals("Barcelone", $next_step["departure"]);

    }


    /**
     * Provides valid datas but departure or arrival can be write with different transit point to service test.
     */
    public static function valid_next_step_with_extract_city_provider(): array
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
     * @covers \App\Collections\ItinaryCollection::find_next_step
     * @dataProvider valid_next_step_with_extract_city_provider
     */
    public function  test_get_step_next_with_extract_city($datas): void
    {
        $itinaryCollection = new ItinaryCollection($datas);
        $step_departure = $itinaryCollection->find_departure_itinary();
        $next_step = $itinaryCollection->find_next_step($step_departure);
        $this->assertIsArray($next_step);
    }

    /**
     * Provides empty datas to service test.
     */
    public static function empty_itinary_provider(): array
    {
        return  [['datas' => [] ]];
    }
     /**
     * @test
     * Use Case provider send empty datas
     * @covers \App\Collections\ItinaryCollection::find_next_step
     * @dataProvider empty_itinary_provider
     * @expectedException : possibilité de renvoyer une erreur là ou dans une autre fonction
     */
    public function test_get_step_next_intinary_with_empty_datas($datas): void
    {
        $itinaryCollection = new ItinaryCollection($datas);
        $step_departure = $itinaryCollection->find_departure_itinary();
        $next_step = $itinaryCollection->find_next_step($step_departure);
        $this->assertIsArray($next_step);
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
     * @covers \App\Collections\ItinaryCollection::find_next_step
     * @dataProvider wrong_datas_provider
     * @expectedException : An error has occurred, wrong datas
     */
    public function test_get_next_step_intinary_with_wrong_datas($datas)
    {
        $this->expectException(ApiException::class);

        $itinaryCollection = new ItinaryCollection($datas);
        $step_departure = $itinaryCollection->find_departure_itinary();
        $itinaryCollection->find_next_step($step_departure);

    }


}