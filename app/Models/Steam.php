<?php
class Steam {
    private $room;
    private $model;
    private $heater_type;
    private $heater_price;
    private $heater_model;
    private $upgrade;
    private $shipping_cost;
    
    /**
     * Required parameters:
     * @param Room room: 
     * - model (string): the model for the steam room, it follows the sintax #(ASR-)[0-9]*-[0-9]*#
     * - heater_type (string): specifies if the room is a Boiler Steam Room or a Generator Steam room.
     *   Possible values [boiler | generator]
     * - heater_model (string): the model for the heater included in the steam room, it follows the 
     *   sintax #A(K|I)-(\d\d|\d\.\d)#
     * Optional parameters:
     * - upgrade (string): currently Steam rooms only support one type of upgrades, but the field is taken
     *   as a string instead of a boolean for scalability.
     * - shipping_cost (numeric): additional cost for shipping, specified by the user.
     */
    public function __construct($room, $model, $heater_type, $heater_price, $heater_model, $upgrade = '', $shipping_cost = 0) {
        $this->database = new Database;
        
        $this->model = $model;
        $this->heater_price = $heater_price;
        $this->heater_type = $heater_type;
        $this->heater_model = $heater_model;
        $this->upgrade = $upgrade;
        $this->shipping_cost = $shipping_cost;
    }

    /**
     * Get the value of model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set the value of model
     *
     * @return  self
     */
    public function setModel($model)
    {
        $this->model = $model;

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
     * Get the value of heater_model
     */
    public function getHeaterModel()
    {
        return $this->heater_model;
    }

    /**
     * Set the value of heater_model
     *
     * @return  self
     */
    public function setHeaterModel($heater_model)
    {
        $this->heater_model = $heater_model;

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