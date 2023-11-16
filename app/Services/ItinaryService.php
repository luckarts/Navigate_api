<?php
namespace App\Services;

use App\Exceptions\ApiException;

class ItinaryService {

    /**
     * @param mixed $itinary
     *
     * @return array
     */
    public function find_departure_itinary(array $itinary): array|string
    {
        $destinations = [];
        if(empty($itinary)){
            return [];
            $error = new ApiException(400, "Une erreur s'est produite. Veuillez vérifier votre requête.");
            $error->throwError();
        }

        foreach ($itinary as $step){
            if(isset($step["arrival"])) $destinations[] = $step["arrival"];
        }

        foreach ($itinary as $step){
            if(isset($step["departure"]) && !in_array($step["departure"], $destinations )) return $step;
        }

        $error = new ApiException(400, "Une erreur s'est produite. Veuillez vérifier votre requête.");
        return $error->throwError();
    }

    /**
    * @param mixed $departure
    * @param mixed $itinary
    *
    * @return array
    */
   public function find_next_step(array $departure, array $itinary): array
   {
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