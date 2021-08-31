<?php
class Steam {
    
    private $width;
    private $length;
    private $height;
    private $price;
    private $accesories;
    private $model;
    private $heater_type;
    private $heater_price;
    private $heater_model;
    private $upgrade;
    private $shipping_cost;
    
    /**
     * Required parameters:
     * @param number width: specify the width of the room in inches.
     * @param number length: specify the length of the room in inches.
     * @param number height: specify the height of the room in inches.
     * @param number price: the base price for the sauna room.
     * @param string model: the model for the steam room, it follows the sintax #(ASR-)[0-9]*-[0-9]*#
     * @param string heater_type [boiler | generator]: specifies if the room is a Boiler Steam Room or a Generator Steam room.
     * @param number heater_price
     * @param string heater_model: the model for the heater included in the steam room, it follows the sintax #A(K|I)-(\d\d|\d\.\d)# 
     * Optional parameters:
     * @param array[Accessory] accessories [Default value = empty array].
     * @param string upgrade:  currently Steam rooms only support one type of upgrades, but the field is taken
     *   as a string instead of a boolean for scalability.
     * @param number shipping_cost
     */
    public function __construct($width, $length, $height, $price, $model, $heater_type, $heater_price, $heater_model, $accesories = [], $upgrade = '', $shipping_cost = 0, ConnectionInterface &$database) {
        $this->database =& $database;
        
        $this->width = $width;
        $this->height = $height;
        $this->length = $length;
        $this->price = $price;
        $this->model = $model;
        $this->heater_price = $heater_price;
        $this->heater_type = $heater_type;
        $this->heater_model = $heater_model;
        $this->accessories = $accesories;
        $this->discount = $discount;
        $this->sales_tax = $sales_tax;
        $this->upgrade = $upgrade;
        $this->shipping_cost = $shipping_cost;
    }

    public function addAccessory($accessory) {
        array_push($this->accsessories, $accessory);
    }

    public function changeBasePrice($new_price) {
        //db stuff here
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

    /**
     * Get the value of width
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set the value of width
     *
     * @return  self
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get the value of length
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set the value of length
     *
     * @return  self
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Get the value of height
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set the value of height
     *
     * @return  self
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
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
     * Get the value of accesories
     */
    public function getAccesories()
    {
        return $this->accesories;
    }

    /**
     * Get the value of discount
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set the value of discount
     *
     * @return  self
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get the value of sales_tax
     */
    public function getSalesTax()
    {
        return $this->sales_tax;
    }

    /**
     * Set the value of sales_tax
     *
     * @return  self
     */
    public function setSalesTax($sales_tax)
    {
        $this->sales_tax = $sales_tax;

        return $this;
    }
}
?>