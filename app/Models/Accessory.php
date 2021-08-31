<?php 
    namespace App\Models;

    use CodeIgniter\Model;
    use CodeIgniter\Database\ConnectionInterface;

    class Accessory {
        protected $database;

        protected $allowed_fields = ['name','description','price','price_is_base'];

        private $name;
        private $qty;
        private $description;
        private $price;
        private $room_type;

        /**
         * @param String $name: the name of the accessory.
         * @param String $room_type ["sauna" | "steam"]: indicates if the accessory belongs to a Sauna room or a Steam room.
         * @param Number $qty [default value = 1]: number of accessories of the same type included in a single room.
         */
        public function __construct($name, $room_type, $qty = 1) {

            $this->name = $name;
            $this->qty = $qty;

            switch(strtolower($room_type)) {
                case 'sauna':
                    $this->$room_type = strtolower($room_type);
                break;
                case 'steam':
                    $this->$room_type = strtolower($room_type);
                    break;
                default:
                    throw new UnexpectedValueException('Error: Invalid accessory room type.');
                break;
            }

            $this->description = $this->get_db_description();
            
            $this->price = $this->get_db_price();
        }

        private function get_db_description() {
            if($this->room_type == 'sauna') {
                //"SELECT description FROM scandiawizard.sauna_accessories WHERE name =" . $this->name;
                return $this->database->table('sauna_accessories')->select('description')->where(['name' => $this->name])->get()->getRow();
            }
            else {
                return $this->database->table('steam_accessories')->select('description')->where(['name' => $this->name])->get()->getRow();
            }
        }

        private function get_db_price() {
            if($this->room_type == 'sauna') {
                return $this->database->table('sauna_accessories')->select('price')->where(['name' => $this->name])->get()->getRow();
            }
            else {
                return $this->database->table('steam_accessories')->select('price')->where(['name' => $this->name])->get()->getRow();
            }
        }


        /**
         * Get the value of name
         */
        public function getName()
        {
                return $this->name;
        }

        /**
         * Get the value of qty
         */
        public function getQty()
        {
                return $this->qty;
        }

        /**
         * Set the value of qty
         *
         * @return  self
         */
        public function setQty($qty)
        {
                $this->qty = $qty;

                return $this;
        }

        /**
         * Get the value of description
         */
        public function getDescription()
        {
                return $this->description;
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
    }
?>