<?php
namespace App\Collections;

use App\Model\Step;
use App\Exceptions\ApiException;

/**
 * Represents a collection of ititnerary.
 * @property array $values Array of `step` objects representing the itinerary.
 */
class ItineraryCollection implements \ArrayAccess {

    protected $collection;
    private $values = [];
    private $stepsDict = [];
    private $departureCities = [];
    private $arrivalCities = [];
    private $startingPoint = null ;
    private $itinerary = [];


    /**
     * @param array $values
     */
    public function __construct($values)
    {
        // Check if the itinerary or departure is not empty
        if (!is_array($values)) {
            $values = [];
        }
        $this->values = $values;

        foreach ($values as $step) {

            $this->populateDictionaries($step);
        }
    }

    private function populateDictionaries($initStep) {


        // Check if the departure city exists
        if (!isset($initStep['departure'])) {
            throw new ApiException("An error has occurred, missing departure city");
        }

        // Check if the arrival city exists
        if (!isset($initStep['arrival'])) {
            throw new ApiException("An error has occurred, missing arrival city");
        }
        if(!isset($initStep["baggages"])) $initStep["baggages"] = '' ;
        if(!isset($initStep["seat"])) $initStep["seat"] = '' ;

        $step = new Step($initStep["id"], $this->extract_city($initStep["departure"]), $this->extract_city($initStep["arrival"]), $initStep["seat"], $initStep["baggages"] );

        $this->arrivalCities[] = $step->getArrival();
        $this->departureCities[] = $step->getDeparture();

        $this->stepsDict[$step->getDeparture()] = $step;
        // check if startingPoint exist
        if (in_array( $step->getDeparture(), $this->departureCities)) {
            $this->startingPoint = $step->getDeparture();
        }elseif ($this->startingPoint === $step->getArrival()){
            $this->startingPoint = null;
        }
        $this->itinerary[] = $step;
    }

     /**
     * extract only the city of the text
     * @param string $chaine
     * @return string
     */
    public function extract_city(string|null $chaine) :string
    {
      return preg_replace('/Aéroport de /', '', $chaine);
    }

    /**
     * Finds the departure itinerary
     * $itineraryCollection->findDepartureItinerary()
     * @return Step|array
     */
    public function findDepartureItinerary(): Step|null
    {
        return $this->startingPoint != null ? $this->stepsDict[$this->startingPoint] : null;
    }

    /**
    * Finds the next step of itinerary
    * @param Step $departure
    * @return Step|null
    */
   public function findNextStep(Step $departure): Step|null
   {
        $arrivalCity = $departure->getArrival() ?? '';
        return $this->stepsDict[$arrivalCity] ?? null;
    }

   /**
    * Create the itinerary
    * @return ItineraryCollection
    */
   public function createItinerary()
    {
        $orderItinary =[];

        // find departure of itinerary
       $departure = $this->findDepartureItinerary();
       $nextDeparture = $this->findNextStep($departure, $this->values);
        // Add all next Step of itinerary in order_itinary
        while ($departure != null) {
            $orderItinary[] = $departure;
            $nextDeparture = $this->findNextStep($departure, $this->values);
            $departure = $nextDeparture;
        }
        return $orderItinary;
    }

    /**
     * @param int $offset
     *
     * @return bool
     */
    public function offsetExists($offset):bool
    {
        return isset($this->values[$offset]);
    }

    public function offsetGet($offset): array
    {
        return $this->values[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        $this->values[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->values[$offset]);
    }

}
