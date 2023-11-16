<?php
namespace App\Services;

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
    public function find_departure_itinary(array $itinary): array
    {
        $destinations = [];
        if(empty($itinary)){
            return [];
        }

        foreach ($itinary as $step){
            if(isset($step["arrival"])) $destinations[] = $step["arrival"];
        }

        foreach ($itinary as $step){
            if(isset($step["departure"]) && !in_array($step["departure"], $destinations )) return $step;
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
            if($this->extract_city(isset($step['departure'])) === $this->extract_city(isset($departure["arrival"]))) {
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
        return [];
    }

}