<?php

namespace Controllers;

use Collections\ItinaryCollection;


/**
 * Handles requests related to itinerary steps.
 */
class StepsController
{

    public function index()
    {
         // Get the itinerary data from the JSON file
        $itineraryData = $this->getItineraryData();

        // Create the itinerary collection
        $itineraryCollection = new ItinaryCollection($itineraryData);

        return  $itineraryCollection->create_itirary();
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