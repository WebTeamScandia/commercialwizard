<?php
public class Proposal {

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
    public function __construct($discount = 0, $sales_tax = 0, $saunas = [], $steams = []) {

    }
}
?>