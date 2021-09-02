<?php 
    namespace App\Models;

    use CodeIgniter\Model;

    class Accessory extends Model{
        //----- CODEIGNITER REQUIRED ATTRIBUTES -----
        protected $table      = 'sauna_accessories';
        protected $primaryKey = 'id';
    
        protected $useAutoIncrement = true;
    
        protected $returnType     = 'array';
        protected $useSoftDeletes = true;
    
        protected $allowedFields = ['accessory', 'description', 'price', 'price_is_base'];
    
        protected $useTimestamps = false;
        # protected $createdField  = 'created_at';
        # protected $updatedField  = 'updated_at';
        # protected $deletedField  = 'deleted_at';
    
        protected $validationRules    = [];
        protected $validationMessages = [];
        protected $skipValidation     = false;
        //-------------------------------------------
        
        private $name;
        private $qty;
        private $description;
        private $base_price;
        private $room_type;
        
        /*the real price of the accessory will be calculated in the controller as it depends on 
        the room dimensons and other accessories included in the sauna.*/
        private $price;

        /**
         * @param String $name: the name of the accessory.
         * @param String $room_type ["sauna" | "steam"]: indicates if the accessory belongs to a Sauna room or a Steam room.
         * @param Number $qty [default value = 1]: number of accessories of the same type included in a single room.
         */
        public function __construct($name, $room_type, $qty) {

            $this->name = $name;
            $this->qty = $qty;
            $this->room_type = $room_type;

            $this->description = $this->get_db_description();
            
            $this->base_price = $this->get_db_price();

            $this->price = $this->base_price;
        }

        private function get_db_description() {
            $db = \Config\Database::connect();
            $description = '';
            if($this->room_type == 'sauna') {
                $builder = $db->table('sauna_accessories');
                $result = $builder->where('accessory',$this->name)->get()->getResult();
                $description = $result[0]->description;
                $this->description = $description;
            }
            else {
                /*$builder = $db->table('steam_accessories');
                $result = $builder->where('accessory',$this->name)->get()->getResult();
                $description = $result[0]->description;
                $this->description = $description;*/
            }
            return $description;

        }

        private function get_db_price() {
            $db = \Config\Database::connect();
            $price = 0;
            if($this->room_type == 'sauna') {
                $builder = $db->table('sauna_accessories');
                $result = $builder->where('accessory',$this->name)->get()->getResult();
                $price = $result[0]->price;
                $this->base_price = $price;
            }
            else {
                /*$builder = $db->table('steam_accessories');
                $result = $builder->where('accessory',$this->name)->get()->getResult();
                $price = $result[0]->price;
                $this->base_price = $price;*/
            }
            return $price;
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

        /**
         * Get the value of base_price
         */
        public function getBasePrice()
        {
                return $this->base_price;
        }
    }
?>