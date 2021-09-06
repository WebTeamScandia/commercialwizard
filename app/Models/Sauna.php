<?php namespace App\Models;

use CodeIgniter\Model;

/**
 * The following params are set only through setter methods
 * @param array[Accessory] accessories [Default value = empty array].
 * @param boolean is_condominium: Saunas for condominiums must have this value set as true. Other type of sauna projects (LA Fitness, Gold's gym, YMCA, etc.) must have this value set as false.
 * @param boolean has_full_length_board: includes the full length board accessory.
 * @param string upgrade [ecosauna | modular | handfinish | none]: specifies if the Sauna has any upgrade selected.
 */
class Sauna extends Model{

    private $width;
    private $length;
    private $height;
    private $accesories;
    private $init_price;
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
     * @param number width: specify the width of the room in inches.
     * @param number length: specify the length of the room in inches.
     * @param number height: specify the height of the room in inches.
     * @param String pc: the name of the PC model for the sauna room. This value follows the sintax #(pc)[0-9]*-[0-9]*#.
     * @param String heater_type [electric | gas]: specifies the heater type for the sauna room.
     * @param number heater_price
     * @param String heater_watt: the amont of power required for the sauna room.
     * @param number price: the base price for the sauna room.
     * @param number shipping_cost: additional cost for shipping, specified by the user.
     */
    public function __construct($width, $length, $height, $pc, $heater_type, $heater_price, $heater_watt) { #remove prices and set them with setters in controller.
        
        $this->width = $width;
        $this->length = $length;
        $this->height = $height;
        $this->pc = $pc;
        $this->heater_type = $heater_type;
        $this->heater_price = $heater_price;
        $this->heater_watt = $heater_watt;
        
        $this->init_price = 0;
        $this->price = 0;
        $this->accessories = [];
        $this->is_condominium = false;
        $this->has_full_length_board = false;
        $this->upgrade = 'none';
        $this->shipping_cost = 1200;
    }

    public function add_accessory($accessory) {
        array_push($this->accessories, $accessory);
        $this->price += $accessory->getPrice() * $accessory->getQty();
    }

    /**
     * @param int change_percentage
     * @param string change_type [increase | decrease]
     */
    public function changeBasePrice($change_percentage, $change_type) {
        $db = \Config\Database::connect();
        $builder = $db->table('sauna_equipment');
        
        $result = $builder->where('equipment','bench')->get()->getResult();
        $bench_price = $result[0]->price;
        
        $builer->resetQuery();
        
        $result = $builder->where('equipment','wall')->get()->getResult();
        $wall_price = $result[0]->price;

        $builer->resetQuery();
        
        $result = $builder->where('equipment','door')->get()->getResult();
        $door_price = $result[0]->price;
        
        $builer->resetQuery();
        
        $result = $builder->where('equipment','trim')->get()->getResult();
        $trim_price = $result[0]->price;

        if($change_type == 'increase') {
            $new_bench_price = $bench_price;
            $new_bench_price += $bench_price * $change_percentage / 100;

            $new_wall_price = $wall_price;
            $new_wall_price += $wall_price * $change_percentage / 100;

            $new_door_price = $door_price;
            $new_door_price += $door_price * $change_percentage / 100;

            $new_trim_price = $trim_price;
            $new_trim_price += $trim_price * $change_percentage / 100;
        }
        else {
            $new_bench_price = $bench_price;
            $new_bench_price -= $bench_price * $change_percentage / 100;

            $new_wall_price = $wall_price;
            $new_wall_price -= $wall_price * $change_percentage / 100;

            $new_door_price = $door_price;
            $new_door_price -= $door_price * $change_percentage / 100;

            $new_trim_price = $trim_price;
            $new_trim_price -= $trim_price * $change_percentage / 100;
        }

        $builer->resetQuery();
        $data = [
            'price' => $new_bench_price;
        ];
        $builder->where('equipment','bench');
        $builder->update($data);

        $builer->resetQuery();
        $data = [
            'price' => $new_wall_price;
        ];
        $builder->where('equipment','wall');
        $builder->update($data);

        $builer->resetQuery();
        $data = [
            'price' => $new_door_price;
        ];
        $builder->where('equipment','door');
        $builder->update($data);

        $builer->resetQuery();
        $data = [
            'price' => $new_trim_price;
        ];
        $builder->where('equipment','bench');
        $builder->update($data);

    }

    public function getBenchBasePrice() { 
        $db = \Config\Database::connect();
        $builder = $db->table('sauna_equipment');
        $result = $builder->where('equipment','bench')->get()->getResult();
        $price = $result[0]->price;
    }

    public function getWallBasePrice() {
        $db = \Config\Database::connect();
        $builder = $db->table('sauna_equipment');
        $result = $builder->where('equipment','wall')->get()->getResult();
        $price = $result[0]->price;
    }

    public function getDoorBasePrice() {
        $db = \Config\Database::connect();
        $builder = $db->table('sauna_equipment');
        $result = $builder->where('equipment','door')->get()->getResult();
        $price = $result[0]->price;
    }

    public function getTrimBasePrice() {
        $db = \Config\Database::connect();
        $builder = $db->table('sauna_equipment');
        $result = $builder->where('equipment','trim')->get()->getResult();
        $price = $result[0]->price;
    }

    /**
     * Get the value of price
     */
    public function getPrice()
    {
        return round($this->price);
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
     * Get the value of accesories
     */
    public function getAccessories()
    {
        return $this->accessories;
    }


    /**
     * Get the value of init_price
     */
    public function getInitPrice()
    {
        return $this->init_price;
    }

    /**
     * Set the value of init_price
     *
     * @return  self
     */
    public function setInitPrice($init_price)
    {
        $this->init_price = $init_price;

        return $this;
    }
}
?>