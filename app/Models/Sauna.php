<?php
class Sauna extends Room {
    private $database;

    private $price;
    private $heater_type;
    private $heater_price;
    private $heater_watt;
    private $pc;
    private $is_condominium;
    private $has_full_length_board;
    private $upgrade;
    private $shipping_cost;

    /**
     * Required params
     * --- width, length and height: parent's required params.
     * @param Room room
     * @param number price: the base price for the sauna room.
     * @param String heater_type [electric | gas]: specifies the heater type for the sauna room.
     * @param number heater_price
     * @param String heater_watt: the amont of power required for the sauna room.
     * @param String pc: the name of the PC model for the sauna room. This value follows the sintax #(pc)[0-9]*-[0-9]*#.
     *   
     * Optional params
     * --- accessories, discount, sales_tax: parent's optional params.
     * @param boolean is_condominium: Saunas for condominiums must have this value set as true. Other type of sauna projects (LA Fitness, Gold's gym, YMCA, etc.) must have this value set as false.
     * @param boolean has_full_length_board: includes the full length board accessory.
     * @param string upgrade [eco-sauna | modular | handfinish]: specifies if the Sauna has any upgrade selected.
     * @param number shipping_cost: additional cost for shipping, specified by the user.
     */
    public function __construct($room, $price, $heater_type, $heater_price, $heater_watt, $pc, $is_condominium = false, $has_full_length_board = false, $upgrade = '', $shipping_cost = 0) {
        $this->database = new Database;
        
        $this->price = $price;
        $this->heater_type = $heater_type;
        $this->heater_price = $heater_price;
        $this->$heater_watt = $heater_watt;
        $this->$pc = $pc;
        $this->is_condominium = $is_condominium;
        $this->has_full_length_board = $has_full_length_board;
        $this->upgrade = $upgrade = $upgrade;
        $this->shipping_cost = $shipping_cost;
    }

    /**
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of heater_type
     */
    public function getHeaterType()
    {
        return $this->heater_type;
    }

    /**
     * Set the value of heater_type
     *
     * @return  self
     */
    public function setHeaterType($heater_type)
    {
        $this->heater_type = $heater_type;

        return $this;
    }

    /**
     * Get the value of heater_price
     */
    public function getHeaterPrice()
    {
        return $this->heater_price;
    }

    /**
     * Set the value of heater_price
     *
     * @return  self
     */
    public function setHeaterPrice($heater_price)
    {
        $this->heater_price = $heater_price;

        return $this;
    }

    /**
     * Get the value of heater_watt
     */
    public function getHeaterWatt()
    {
        return $this->heater_watt;
    }

    /**
     * Set the value of heater_watt
     *
     * @return  self
     */
    public function setHeaterWatt($heater_watt)
    {
        $this->heater_watt = $heater_watt;

        return $this;
    }

    /**
     * Get the value of pc
     */
    public function getPc()
    {
        return $this->pc;
    }

    /**
     * Set the value of pc
     *
     * @return  self
     */
    public function setPc($pc)
    {
        $this->pc = $pc;

        return $this;
    }

    /**
     * Get the value of is_condominium
     */
    public function getIsCondominium()
    {
        return $this->is_condominium;
    }

    /**
     * Set the value of is_condominium
     *
     * @return  self
     */
    public function setIsCondominium($is_condominium)
    {
        $this->is_condominium = $is_condominium;

        return $this;
    }

    /**
     * Get the value of has_full_length_board
     */
    public function getHasFullLengthBoard()
    {
        return $this->has_full_length_board;
    }

    /**
     * Set the value of has_full_length_board
     *
     * @return  self
     */
    public function setHasFullLengthBoard($has_full_length_board)
    {
        $this->has_full_length_board = $has_full_length_board;

        return $this;
    }

    /**
     * Get the value of upgrade
     */
    public function getUpgrade()
    {
        return $this->upgrade;
    }

    /**
     * Set the value of upgrade
     *
     * @return  self
     */
    public function setUpgrade($upgrade)
    {
        $this->upgrade = $upgrade;

        return $this;
    }

    /**
     * Get the value of shipping_cost
     */
    public function getShippingCost()
    {
        return $this->shipping_cost;
    }

    /**
     * Set the value of shipping_cost
     *
     * @return  self
     */
    public function setShippingCost($shipping_cost)
    {
        $this->shipping_cost = $shipping_cost;

        return $this;
    }
}
?>