I<?php

use PHPUnit\Framework\TestCase;
use App\Exceptions\ApiException;
use Collections\ItinaryCollection;

class CreateItinaryTest extends TestCase
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
     * @covers \App\Collections\ItinaryCollection::create_itirary
     * @dataProvider valid_itinary_provider
     */
    public function test_create_valid_itinerary(array $datas): void
    {
        $itinaryCollection = new ItinaryCollection($datas);
        $itinerarySteps = $itinaryCollection->create_itirary();
        $this->assertIsArray($itinerarySteps);
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
     * @covers \App\Collections\ItinaryCollection::create_itirary
     * @dataProvider empty_itinary_provider
     * @expectedException : possibilité de renvoyer une erreur là ou dans une autre fonction
     */
    public function test_create_intinary_with_empty_datas(array $datas): void
    {
        $itinaryCollection = new ItinaryCollection($datas);
        $itinerarySteps = $itinaryCollection->create_itirary();
        $this->assertIsArray($itinerarySteps);
        $this->assertEmpty($itinerarySteps);
    }


     /**
     * Provides incorrect datas to service test.
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
     * @covers \App\Collections\ItinaryCollection::create_itirary
     * @dataProvider wrong_datas_provider
     * @expectedException : An error has occurred, wrong datas
     */
    public function test_create_intinary_with_wrong_datas(array $datas): void
    {
        $this->expectException(ApiException::class);

        $itinaryCollection = new ItinaryCollection($datas);
        $itinerarySteps = $itinaryCollection->create_itirary();
    }
}