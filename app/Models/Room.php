<?php
    class Room extends Model {
        /*
        To access data from the database within this class, a function like the following is needed:
        
        public function get_data() {
            $this->database->query("insert generic SQL query");
            $result = $this->database->result_set();
            return $result;
        }

        when specifying a table in the SQL query, we must also specify the db name,
        so instead of:
            SELECT * FROM table_name
        we do:
            SELECT * FROM database_name.table_name
        */
        
        private $database;

        private $width;
        private $length;
        private $height;
        private $accesories;
        private $discount;
        private $sales_tax;
        private $shipping_cost;

        /**
         * Required params: 
         * @param number width: specify the width of the room in inches.
         * @param number length: specify the length of the room in inches.
         * @param number height: specify the height of the room in inches.
         * 
         * Optional params:
         * @param array[Accessory] accessories [Default value = empty array].
         * @param number discount: percentage to be discounted to the room price.
         * @param number sales_tax: tax percentage to be added to the room price.
         */
        public function __construct($width, $length, $height, $accesories = [], $discount = 0, $sales_tax = 0) {
            $this->database = new Database;
            
            $this->width = $width;
            $this->height = $height;
            $this->length = $length;

            $this->accessories = $accesories;
            $this->discount = $discount;
            $this->sales_tax = $sales_tax;
        }

        public function add_accessory($accessory) {
            array_push($this->accessories, $accessory);
        }


        /**
         * Get the value of width
         */
        public function getWidth()
        {
            return $this->width;
        }

        /**
         * Get the value of length
         */
        public function getLength()
        {
                return $this->length;
        }

        /**
         * Get the value of height
         */
        public function getHeight()
        {
                return $this->height;
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