<?php
namespace App\Services;

use App\Exceptions\ApiException;


class ItinaryService {

    /**
     * @param mixed $chaine string
     *
     * @return string
     */
    public function extract_city(string $chaine)
    {
      return preg_replace('/Aéroport de /', '', $chaine);
    }

    /**
     * @param mixed $itinary
     *
     * @return array
     */
    public function find_departure_itinary(array $itinary)
    {
        $destinations = [];
        if(empty($itinary)){
            return [];
        }

        foreach ($itinary as $step){
            if(!isset($step['arrival']) || !isset($step["departure"])) throw  new ApiException("An error has occurred, wrong datas");
            $destinations[] = $step["arrival"];
        }

        foreach ($itinary as $step){
            if(!in_array($this->extract_city($step["departure"]), $destinations )) return $step;
        }

        return [];
    }

    /**
    * @param mixed $departure
    * @param mixed $itinary
    *
    * @return array
    */
   public function find_next_step(array $departure, array $itinary): array
   {
        if(empty($itinary) || empty($departure)){
            return [];
        }
        foreach($itinary as $step) {
            if($this->extract_city($step['departure']) === $this->extract_city($departure["arrival"])) {
                return $step;
            }
        };

        return [];
    }
   /**
    * @param mixed $itinary
    *
    * @return array
    */
   public function create_itirary(array $itinary): array
    {
        $order_itinary =[];
        $departure = $this->find_departure_itinary($itinary);
        //$next_departure = $this->find_next_step($departure, $itinary);

        while ($departure !== []) {

            $order_itinary[] = $departure;
            $next_departure = $this->find_next_step($departure, $itinary);
            $departure = $next_departure;
        }
        return  $order_itinary;
    }

}