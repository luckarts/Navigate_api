<?php

namespace App\Controllers;

use App\Collections\ItineraryCollection;



/**
 * Handles requests related to itinerary steps.
 */
class StepsController
{

    /**
     * Get the itinerary data from the JSON file
     * Create the itinerary collection
     * @return [type]
     */
    public function index()
    {
        $itineraryCollection = new ItineraryCollection($this->getItineraryData());
        return  $itineraryCollection->createItinerary();
    }

    /**
     * Load datas fake bdd
     * @return array
     */
    private function getItineraryData()
    {
        $datas = __DIR__ . "/../data/itineraires.json";
        if (!file_exists($datas)) {
            return [];
        }
        return json_decode(file_get_contents($datas), true);
    }

}