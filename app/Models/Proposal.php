<?php namespace App\Models;

use CodeIgniter\Model;

class Proposal {

    private $discount;
    private $sales_tax;
    private $saunas;
    private $steams;

    /**
     * @param number discount: percentage to be discounted to the room price.
     * @param number sales_tax: tax percentage to be added to the room price.
     * @param Sauna[] saunas
     * @param Steam[] steams
     */
    public function __construct($discount, $sales_tax, $saunas, $steams) {
        $this->discount = $discount;
        $this->sales_tax = $sales_tax;
        $this->saunas = $saunas;
        $this->steams = $steams;
    }

    /**
     * Get the value of discount
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Get the value of sales_tax
     */
    public function getSalesTax()
    {
        return $this->sales_tax;
    }

    /**
     * Get the value of saunas
     */
    public function getSaunas()
    {
        return $this->saunas;
    }

    /**
     * Set the value of saunas
     *
     * @return  self
     */
    public function setSaunas($saunas)
    {
        $this->saunas = $saunas;

        return $this;
    }

    /**
     * Get the value of steams
     */
    public function getSteams()
    {
        return $this->steams;
    }

    /**
     * Set the value of steams
     *
     * @return  self
     */
    public function setSteams($steams)
    {
        $this->steams = $steams;

        return $this;
    }
}
?>