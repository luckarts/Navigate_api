<?php

namespace App\Tests;


use PHPUnit\Framework\TestCase;
use App\Exceptions\ApiException;
use App\Services\ItinaryService;
use Collections\ItinaryCollection;

class FindDepartureIntinaryTest extends TestCase
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
     * Use Case find first step in the itinary
     * @covers \App\Collections\ItinaryCollection::find_departure_itinary
     * @dataProvider valid_itinary_provider
     */
    public function test_find_departure_intinary(array $datas): void
    {
        $itinaryCollection = new ItinaryCollection($datas);
        $step_departure = $itinaryCollection->find_departure_itinary($datas);
        $this->assertIsArray($step_departure);
        $this->assertEquals("Madrid", $step_departure["departure"]);
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
     * @covers \App\Collections\ItinaryCollection::find_departure_itinary
     * @dataProvider empty_itinary_provider
     * @expectedException : possibilité de renvoyer une erreur là ou dans une autre fonction
     */
    public function test_find_departure_intinary_with_empty_datas(array $datas): void
    {
        $itinaryCollection = new ItinaryCollection($datas);
        $step_departure = $itinaryCollection->find_departure_itinary($datas);
        $this->assertIsArray($step_departure);
        $this->assertEmpty($step_departure);
    }


     /**
     * Provides wrong datas to service test.
     */
    public static function wrong_datas_provider(): array
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
     * @covers \App\Collections\ItinaryCollection::find_departure_itinary
     * @dataProvider wrong_datas_provider
     * @expectedException : An error has occurred, wrong datas
     */
    public function test_find_departure_itinary_with_wrong_datas(array $datas): void
    {
        $this->expectException(ApiException::class);

        $itinaryCollection = new ItinaryCollection($datas);
        $itinaryCollection->find_departure_itinary($datas);

     }
}