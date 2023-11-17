<?php

namespace Controllers;

use App\Services\ItinaryService;


class StepsController
{
    private $itineraireService;

    public function __construct() {
        $this->itineraireService = new ItinaryService();
    }

    public function index() {
        $datas = __DIR__."/../data/itineraires.json";
        if (!file_exists($datas)) {
             echo json_encode([]);
        }
       return  $this->itineraireService->create_itirary(json_decode(file_get_contents($datas), true));

    }

}