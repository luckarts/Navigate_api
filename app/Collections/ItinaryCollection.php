<?php
namespace Collections;

use App\Model\Step;
use App\Exceptions\ApiException;
use PhpParser\Node\Expr\NullsafePropertyFetch;

/**
 * Represents a collection of ititnary.
 * @property array $values Array of `step` objects representing the itinary.
 */
class ItinaryCollection implements \ArrayAccess {

    protected $collection;
    private $values = [];
    private $stepsDict = [];
    private $departureCities = [];
    private $arrivalCities = [];
    private $startingPoint = null ;
    private $itinary = [];


    /**
     * @param array $values
     */
    public function __construct($values)
    {
        // Check if the itinary or departure is not empty
        if (!is_array($values)) {
            $values = [];
        }
        $this->values = $values;

        foreach ($values as $step) {
            $this->populateDictionaries($step);
        }
    }
    private function populateDictionaries($step) {


        // Check if the departure city exists
        if (!isset($step['departure'])) {
            throw new ApiException("An error has occurred, missing departure city");
        }

        // Check if the arrival city exists
        if (!isset($step['arrival'])) {
            throw new ApiException("An error has occurred, missing departure city");
        }
        $step['arrival'] = $this->extract_city($step['arrival']);
        $step['departure'] = $this->extract_city($step['departure']);

        $this->arrivalCities[] = $step["arrival"];
        $this->departureCities[] = $step["departure"];
        $this->stepsDict[$step['departure']] = $step;

        // check if startingPoint exist
        if (!isset($this->departureCities[$step['departure']])) {
            $this->startingPoint = $step['departure'];
        } elseif ($this->startingPoint === $step['arrival']){
            $this->startingPoint = null;
        }

        $this->itinary[] = $step;
    }

     /**
     * extract only the city of the text
     * @param string $chaine
     * @return string
     */
    public function extract_city(string|null $chaine)
    {
      return preg_replace('/Aéroport de /', '', $chaine);
    }

    /**
     * Finds the departure itinerary
     * $ItinaryCollection->find_departure_itinary()
     * @return Step|array
     */
    public function find_departure_itinary(): step|array
    {
        return $this->startingPoint != null ? $this->stepsDict[$this->startingPoint] : [];
    }

    /**
    * Finds the next step of itinerary
    * @param Step|array $departure
    * @return Step
    */
   public function find_next_step(array $departure): Step|array
   {
        $arrivalCity = $departure['arrival'] ?? '';
        return $this->stepsDict[$arrivalCity] ?? [];
    }

   /**
    * Create the ititanry
    * @return ItinaryCollection
    */
   public function create_itirary()
    {
        $order_itinary =[];

        // find departure of itinary
       $departure = $this->find_departure_itinary();
        // Add all next Step of itinary in order_itinary
        while ($departure !== []) {
            $order_itinary[] = $departure;
            $next_departure = $this->find_next_step($departure, $this->values);
            $departure = $next_departure;
        }

        return $order_itinary;
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
