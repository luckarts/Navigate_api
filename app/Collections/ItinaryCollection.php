<?php
namespace Collections;

use App\Model\Step;
use App\Exceptions\ApiException;

/**
 * Represents a collection of ititnary.
 * @property array $values Array of `step` objects representing the itinary.
 */
class ItinaryCollection implements \ArrayAccess {

    protected $collection;
    private $values = [];

    /**
     * @param array $values
     */
    public function __construct($values)
    {
        $this->values = $values;
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
        $destinations = [];
        if(empty($this->values)){
            return [];
        }

        foreach ($this->values as $step){

            // Check if the departure city exists
            if (!isset($step['departure'])) {
                throw new ApiException("An error has occurred, missing departure city");
            }

            // Check if the arrival city exists
            if (!isset($step['arrival'])) {
                throw new ApiException("An error has occurred, missing departure city");
            }

            // Return the current step if it's the departure itinerary
            if (!in_array($this->extract_city($step['departure']), $destinations)) {
                return $step;
            }

            $destinations[] = $step["arrival"];
        }

        return [];
    }

    /**
    * Finds the next step of itinerary
    * @param Step|array $departure
    * @return Step
    */
   public function find_next_step(array $departure): Step|array
   {

        // Check if the itinary or departure is not empty
        if(empty($this->values) || empty($departure)){
            return [];
        }

        // Return the next of itinerary
        foreach($this->values as $step ) {
            if($this->extract_city($step['departure']) === $this->extract_city($departure["arrival"])) {
                return $step;
            }
        };

        return [];
    }
   /**
    * Create the ititanry
    * @return ItinaryCollection
    */
   public function create_itirary()
    {
        $order_itinary =[];

        // find departure of itinary
        $departure = $this->find_departure_itinary($this->values);

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
