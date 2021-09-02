<?php namespace App\Models;

use CodeIgniter\Model;

class Proposal {

    private $prj_name;
    private $date;
    private $shipping_address;
    private $zip;
    private $author;
    private $discount;
    private $sales_tax;
    private $saunas;
    private $steams;

    /**
     * @param string prj_name
     * @param string date
     * @param number zip
     * @param string author
     * @param number discount: percentage to be discounted to the room price.
     * @param number sales_tax: tax percentage to be added to the room price.
     * @param Sauna[] saunas
     * @param Steam[] steams
     */
    public function __construct($prj_name, $date, $shipping_address, $zip, $author, $discount, $sales_tax, $saunas, $steams) {
        $this->prj_name = $prj_name;
        $this->date = $date;
        $this->shipping_address = $shipping_address;
        $this->zip = $zip;
        $this->author = $author;
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
     * Get the value of steams
     */
    public function getSteams()
    {
        return $this->steams;
    }

    /**
     * Get the value of prj_name
     */
    public function getPrjName()
    {
        return $this->prj_name;
    }

    /**
     * Set the value of prj_name
     *
     * @return  self
     */
    public function setPrjName($prj_name)
    {
        $this->prj_name = $prj_name;

        return $this;
    }

    /**
     * Get the value of date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of shipping_address
     */
    public function getShippingAddress()
    {
        return $this->shipping_address;
    }

    /**
     * Set the value of shipping_address
     *
     * @return  self
     */
    public function setShippingAddress($shipping_address)
    {
        $this->shipping_address = $shipping_address;

        return $this;
    }

    /**
     * Get the value of zip
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set the value of zip
     *
     * @return  self
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get the value of author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set the value of author
     *
     * @return  self
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

}
?>