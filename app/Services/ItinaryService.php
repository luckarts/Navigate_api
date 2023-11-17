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



}