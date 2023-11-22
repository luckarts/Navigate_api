<?php

use PHPUnit\Framework\TestCase;
use App\Exceptions\ApiException;
use Collections\itineraryCollection;

class CreateItineraryTest extends TestCase
{
// Use Case 1 Valid
// Use Case 2 No itinerary
// Use Case 4 Donnée Incorrect

    /**
     * Provides valid datas to service test.
     */
    public static function valid_itinerary_provider(): array
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
     * @covers \App\Collections\ItineraryCollection::createItinerary
     * @dataProvider valid_itinerary_provider
     */
    public function test_create_valid_itinerary(array $datas): void
    {
        $itineraryCollection = new ItineraryCollection($datas);
        $itinerarySteps = $itineraryCollection->createItinerary();
        $this->assertIsArray($itinerarySteps);
    }

    /**
     * Provides empty datas to service test.
     */
    public static function empty_itinerary_provider(): array
    {
        return  [['datas' => [] ]];
    }
     /**
     * @test
     * Use Case provider send empty datas
     * @covers \App\Collections\itineraryCollection::createItinerary
     * @dataProvider empty_itinerary_provider
     * @expectedException : possibilité de renvoyer une erreur là ou dans une autre fonction
     */
    public function test_create_intinerary_with_empty_datas(array $datas): void
    {
        $itineraryCollection = new itineraryCollection($datas);
        $itinerarySteps = $itineraryCollection->createItinerary();
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
     * @covers \App\Collections\itineraryCollection::createItinerary
     * @dataProvider wrong_datas_provider
     * @expectedException : An error has occurred, wrong datas
     */
    public function test_create_intinerary_with_wrong_datas(array $datas): void
    {
        $this->expectException(ApiException::class);

        $itineraryCollection = new itineraryCollection($datas);
        $itinerarySteps = $itineraryCollection->createItinerary();
    }
}