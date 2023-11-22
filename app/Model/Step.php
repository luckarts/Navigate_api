<?PHP
namespace App\Model;

/**
 * Represents the model Step of ititnary.
 */
class Step {
    public $id;
    public $departure;
    public $arrival;
    public $transport;
    public $seat;
    public $baggages;

    /**
     * @param int $id
     * @param string $departure
     * @param string $arrival
     * @param string $transport
     * @param string $seat
     * @param string $baggages
     */
    public function __construct($id, $departure, $arrival, $seat, $baggages) {
        $this->id = $id;
        $this->departure = $departure;
        $this->arrival = $arrival;
        $this->seat = $seat;
        $this->baggages = $baggages;
    }
    /**
     * @return int
     */
    function getId()
    {
        return $this->id;
    }
    /**
     * @param int $id
     *
     * @return int
     */
    function setId($id)
    {
        return $this->id = $id;
    }

    /**
     * @return string
     */
    function getDeparture()
    {
        return $this->departure;
    }

    /**
     * @param string $departure
     *
     * @return string
     */
    function setDeparture($departure): string
    {
        return $this->departure = $departure;
    }

    function getArrival(): string
    {
        return $this->arrival;
    }

    /**
     * @param string $arrival
     *
     * @return string
     */
    function setArrival($arrival): string
    {
        return $this->arrival = $arrival;
    }

    /**
     * @return string
     */
    function getSeat(): string
    {
        return $this->seat;
    }

    /**
     * @param string $seat
     *
     * @return string
     */
    function setSeat($seat): string
    {
        return $this->seat = $seat;
    }

    /**
     * @return string
     */
    function getBaggages(): string
    {
        return $this->baggages;
    }

    /**
     * @param string $baggages
     *
     * @return string
     */
    function setBaggages($baggages): string
    {
        return $this->baggages = $baggages;
    }
}
