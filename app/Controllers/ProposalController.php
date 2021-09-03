<?php

namespace App\Controllers;

use App\Models\Sauna;
use App\Models\Steam;
use App\Models\Accessory;
use App\Models\Proposal;

class ProposalController extends BaseController {

    private $user_inputs;
    private $saunas;
    private $steams;
    private $proposal_model;

    public function __construct($user_inputs) {
        $this->user_inputs = $user_inputs;
    }

    public function createProposal() {

        $prj_name = $this->user_inputs['prj-name'];
        $prj_date = $this->user_inputs['date'];
        $shipping_address = $this->user_inputs['prj-address'];
        $zip = $this->user_inputs['prj-zip'];
        $author = $this->user_inputs['prj-author'];
		$discount = intval($this->user_inputs['discount']);
		$sales_tax = intval($this->user_inputs['tax']);

        if(isset($this->user_inputs['sauna'])) {
            
			$this->create_saunas();
			
		}

        if(isset($this->user_inputs['steam'])) {
			
		}

        $this->proposal_model = new Proposal($prj_name, $prj_date, $shipping_address, $zip, $author, $discount, $sales_tax, $this->saunas, $this->steams);
        
    }

    private function create_saunas() {
        $this->saunas = [];

		$num_saunas = intval($this->user_inputs['num-saunas']);

		if(isset($this->user_inputs['sauna-same-dims']) && isset($this->user_inputs['sauna-same-heater'])) {
			$width = intval($this->user_inputs['sauna-width'][$sauna_index]);
			$length = intval($this->user_inputs['sauna-length'][$sauna_index]);
			$height = intval($this->user_inputs['sauna-height'][$sauna_index]);

			$shipping_cost = intval($this->user_inputs['saunas-shipping']);
			
			$heater_type = $this->user_inputs['heater'][$sauna_index];
			
			$width_ft = $width/12;
			$length_ft = $length/12;
			$height_ft = $height/12;
			$sauna_volume_ft3 =  $width_ft * $length_ft * $height_ft;
			
			$pc = 'PC' . intval($width_ft) . intval($length_ft) . '-' . intval($height_ft);

			$heater_info = $this->getHeaterInfo($heater_type, $sauna_volume_ft3);

			$price = $this->calculateSaunaInitPrice($width, $length, $height, $heater_info['price']);

			$sauna =  new Sauna($width, $length, $height, $pc, $heater_type, $heater_info['price'], $heater_info['watt'], $price, $price, $shipping_cost);
			
			for($i=0; $i<$num_saunas; $i++) {
				array_push($this->saunas, $sauna);
			}
		}
		else if(isset($this->user_inputs['sauna-same-dims'])){ //same dims but different heaters
			$width = intval($this->user_inputs['sauna-width'][$sauna_index]);
			$length = intval($this->user_inputs['sauna-length'][$sauna_index]);
			$height = intval($this->user_inputs['sauna-height'][$sauna_index]);
			
			$shipping_cost = intval($this->user_inputs['saunas-shipping']);
			
			$width_ft = $width/12;
			$length_ft = $length/12;
			$height_ft = $height/12;
			$sauna_volume_ft3 =  $width_ft * $length_ft * $height_ft;
			
			$pc = 'PC' . intval($width_ft) . intval($length_ft) . '-' . intval($height_ft);

			for($i=0; $i<$num_saunas; $i++) {

				$heater_type = $this->user_inputs['heater'][$i];

				$heater_info = $this->getHeaterInfo($heater_type, $sauna_volume_ft3);

				$price = $this->calculateSaunaInitPrice($width, $length, $height, $heater_info['price']);

				$sauna =  new Sauna($width, $length, $height, $pc, $heater_type, $heater_info['price'], $heater_info['watt'], $price, $price, $shipping_cost);

				array_push($this->saunas, $sauna);
			}
		}
		else if(isset($this->user_inputs['sauna-same-heater'])) { //same heater type but different dims
			$heater_type = $this->user_inputs['heater'][$sauna_index];

			$shipping_cost = intval($this->user_inputs['saunas-shipping']);

			$heater_info = $this->getHeaterInfo($heater_type, $sauna_volume_ft3);

			for($i=0; $i<$num_saunas; $i++) {
				$width = intval($this->user_inputs['sauna-width'][$i]);
				$length = intval($this->user_inputs['sauna-length'][$i]);
				$height = intval($this->user_inputs['sauna-height'][$i]);

				$width_ft = $width/12;
				$length_ft = $length/12;
				$height_ft = $height/12;
				$sauna_volume_ft3 =  $width_ft * $length_ft * $height_ft;

				$pc = 'PC' . intval($width_ft) . intval($length_ft) . '-' . intval($height_ft);

				$price = $this->calculateSaunaInitPrice($width, $length, $height, $heater_info['price']);

				$sauna =  new Sauna($width, $length, $height, $pc, $heater_type, $heater_info['price'], $heater_info['watt'], $price, $price, $shipping_cost);

				array_push($this->saunas, $sauna);
			}
		}
		else { //different heaters and dims
			for($i=0; $i<$num_saunas; $i++) {
				$width = intval($this->user_inputs['sauna-width'][$i]);
				$length = intval($this->user_inputs['sauna-length'][$i]);
				$height = intval($this->user_inputs['sauna-height'][$i]);

				$shipping_cost = intval($this->user_inputs['saunas-shipping']);
				
				$heater_type = $this->user_inputs['heater'][$i]; 
				
				$width_ft = $width/12;
				$length_ft = $length/12;
				$height_ft = $height/12;
				$sauna_volume_ft3 =  $width_ft * $length_ft * $height_ft;
				
				$pc = 'PC' . intval($width_ft) . intval($length_ft) . '-' . intval($height_ft);

				$heater_info = $this->getHeaterInfo($heater_type, $sauna_volume_ft3);

				$price = $this->calculateSaunaInitPrice($width_ft, $length_ft, $height_ft, $heater_info['price']);

				$sauna =  new Sauna($width, $length, $height, $pc, $heater_type, $heater_info['price'], $heater_info['watt'], $price, $price);

                if($shipping_cost > 0) {
                    $sauna->setShippingCost($shipping_cost);
                }

				array_push($this->saunas, $sauna);
			}
		}

        if(isset($this->user_inputs['sauna-same-accessories'])) {
		    foreach($this->saunas as $sauna) {
                $this->addAccessoriesSauna($sauna, 0);
            }
        }
        else {
            for($i=0; $i<count($this->saunas); $i++) {
                $this->addAccessoriesSauna($this->saunas[$i], $i);
            }
        }

    }

    private function addAccessoriesSauna($sauna, $sauna_index) {
        $sauna_width_ft = round($sauna->getWidth() / 12);
        $sauna_length_ft = round($sauna->getLength() / 12);
        $sauna_height_ft = round($sauna->getHeight() / 12);

        //-------------- dropdown menu accessories --------------
        $upgrade = $this->user_inputs['upgrade'][$sauna_index];
        if($upgrade != 0) {
            $sauna->setUpgrade($upgrade);
            switch($upgrade) {
                case 'ecosauna':
                    $extra_price = $sauna->getInitPrice() * 0.45;
                    $new_price = round($sauna->getPrice() + $extra_price);
                    $sauna->setPrice($new_price);
                break;
                case 'modular':
                    $extra_price = $sauna->getInitPrice() * 0.6;
                    $new_price = round($sauna->getPrice() + $extra_price);
                    $sauna->setPrice($new_price);
                break;
            }
        }

        $project_type = $this->user_inputs['project'][$sauna_index];
        if($project_type == 'condominums') {
            $sauna->setIsCondominium(true);
            $extra_price = $sauna->getInitPrice() * 0.15;
            $new_price = round($sauna->getPrice() + $extra_price);
            $sauna->setPrice($new_price);
        }

        //---------- checkbox/switch selected accessories ----------
        if(isset($this->user_inputs['backwall-bench'][$sauna_index])) {
            $backwall_bench = new Accessory('Upper Bench Back Wall','sauna', 1);

            $accessory_price = $sauna_width_ft * $backwall_bench->getBasePrice();
            if($upgrade == 'ecosauna'){
                $accessory_price += $accessory_price * 0.1875;
            }
            if(isset($this->user_inputs['sloped-backrest'][$sauna_index])) {
                $sloped = new Accessory('Sloped Backrest','sauna',1);
                $accessory_price += $sauna_width_ft * $sloped->getBasePrice();
            }
            $accessory_price = round($accessory_price);

            $backwall_bench->setPrice($accessory_price);
            $sauna->add_accessory($backwall_bench);
        }

        if(isset($this->user_inputs['sidewall-bench'][$sauna_index])) {
            $sidewall_bench = new Accessory('Upper Bench Side Wall', 'sauna', 1);
            $accessory_price = $sauna_length_ft * $sidewall_bench->getBasePrice();
            if($upgrade == 'ecosauna') {
                $accessory_price += $accessory_price * 0.15;
            }
            if(isset($sloped)) {
                $accessory_price += $sauna_length_ft * $sloped->getBasePrice() * 1.25;
            }
            $accessory_price = round($accessory_price);

            $sidewall_bench->setPrice($accessory_price);
            $sauna->add_accessory($sidewall_bench);
        }
        
        if(isset($this->user_inputs['sidewall-extra-bench'][$sauna_index])) {
            $sidewall_extra_bench = new Accessory('Upper Bench Extra Side Wall', 'sauna', 1);
            $accessory_price = $sauna_width_ft * $sidewall_extra_bench->getBasePrice();
            if($upgrade == 'ecosauna') {
                $backwall_bench = (isset($backwall_bench)) ? $backwall_bench : new Accessory('Upper Bench Back Wall','sauna', 1);
                $accessory_price += $sauna_width_ft * $backwall_bench->getBasePrice() * 0.1875;
            }
            if(isset($sloped)) {
                $accessory_price += $sauna_width_ft * $sloped->getBasePrice() * 1.25;
            }
            $accessory_price = round($accessory_price);

            $sidewall_extra_bench->setPrice($accessory_price);
            $sauna->add_accessory($sidewall_extra_bench);
        }

        if(isset($this->user_inputs['cedar-walls'][$sauna_index])) {
            $accessory = new Accessory('Exterior Wall Cedar','sauna',1);
            $accessory_price = $sauna_width_ft * $sauna_height_ft * $accessory->getBasePrice() * 1.15;
            $accessory_price = round($accessory_price);
            $accessory->setPrice($accessory_price);
            $sauna->add_accessory($accessory);
        }

        if(isset($this->user_inputs['glassdoor'][$sauna_index])) {
            $accessory = new Accessory('Full Glass Door','sauna',1);
            $sauna->add_accessory($accessory);
        }

        if(isset($this->user_inputs['timer'][$sauna_index])) {
            $accessory = new Accessory('24 HR Digital Timer','sauna',1);
            $sauna->add_accessory($accessory);
        }

        if(isset($this->user_inputs['duckboard'][$sauna_index])) {
            $accessory = new Accessory('Cedar Duckboard','sauna',1);
            
            $length_reduction = 20;
            $width_reduction = 20;
            if(isset($backwall_bench)) {
                $width_reduction += 20;
            }
            if(isset($sidewall_bench)) {
                $length_reduction += 20;
            }
            if(isset($sidewall_extra_bench)) {
                $length_reduction += 20;
            }
            $accessory_price = ($sauna->getLength() - $length_reduction) * (($sauna->getWidth() - $width_reduction) / 144) * $accessory->getBasePrice();
            if($upgrade == 'ecosauna') {
                $accessory_price += $sauna_length_ft * $sauna_width_ft * 3.1875;
            }
            $accessory_price = round($accessory_price);

            $accessory->setPrice($accessory_price);
            $sauna->add_accessory($accessory);
        }

        if(isset($this->user_inputs['cedar-backrest'][$sauna_index])) {
            $accessory = new Accessory('Cedar Backrest','sauna',1);
            $sauna->add_accessory($accessory);
        }

        /* this 'if' is different because we had to check for the sloped backrest switch to calculate 
        the price of the backwall bench. We stored and used the value for data access optimization. */
        if(isset($sloped)) {
            $accessory = new Accessory('Sloped Backrest','sauna',1);
            $accessory_price = round($accessory->getBasePrice() * ($sauna_width_ft + $sauna_length_ft));
            $accessory->setPrice($accessory_price);
            $sauna->add_accessory($accessory);
        }

        if(isset($this->user_inputs['fl-board'][$sauna_index])) {
            $accessory = new Accessory('Full Length Board','sauna',1);
            $sauna->add_accessory($accessory);
            $sauna->setHasFullLengthBoard(true);
        }

        if(isset($this->user_inputs['glassfront'][$sauna_index])) {
            $accessory = new Accessory('Glass Store Front Vision Panel','sauna',1);
            $accessory_price = round(($sauna_width_ft * $sauna_height_ft - 21) * $accessory->getBasePrice());
            $accessory->setPrice($accessory_price);
            $sauna->add_accessory($accessory);
        }

        if(isset($this->user_inputs['cove-lighting'][$sauna_index])) {
            $accessory = new Accessory('Perimeter Cove Lighting','sauna',1);
            $sauna->add_accessory($accessory);
        }

        if(isset($this->user_inputs['wifi-controller'][$sauna_index])) {
            $accessory = new Accessory('Wi-Fi App Heater Controller','sauna',1);
            $sauna->add_accessory($accessory);
        }

        if(isset($this->user_inputs['trutile'][$sauna_index])) {
            $accessory = new Accessory('Tru Tile Black','sauna',1);
            
            $length_reduction = 20;
            $width_reduction = 20;
            if(isset($backwall_bench)) {
                $width_reduction += 20;
            }
            if(isset($sidewall_bench)) {
                $length_reduction += 20;
            }
            if(isset($sidewall_extra_bench)) {
                $length_reduction += 20;
            }
            $accessory_price = ($sauna->getLength() - $length_reduction) * (($sauna->getWidth() - $width_reduction) / 144) * $accessory->getBasePrice();
            if($upgrade == 'ecosauna') {
                $accessory_price += $sauna_width_ft * $sauna_height_ft * 3.1875;
            }
            $accessory_price = round($accessory_price);
            $accessory->setPrice($accessory_price);
            $sauna->add_accessory($accessory);
        }

        if(isset($this->user_inputs['warranty'][$sauna_index])) {
            $accessory = new Accessory('Warranty', 'sauna', 1);
            $sauna->add_accessory($accessory);
        }
        
        //--------------------------- number input accessories ---------------------------
        $num_salt = intval($this->user_inputs['salt-panel'][$sauna_index]);
        if($num_salt > 0) {
            /*
            For one of the wizards, there is an additional cost for the shipping of each salt panel.
            Consider adding an attribute to the Sauna model for this and setting its value here.
            */
            $accessory = new Accessory('Himalayan Salt Panels', 'sauna', $num_salt);
            $sauna->add_accessory($accessory);
        }

        $num_lg_salt = intval($this->user_inputs['salt-sconce-lg'][$sauna_index]);
        if($num_lg_salt > 0) {
            $accessory = new Accessory('Himalayan Salt Sconce Large','sauna',$num_lg_salt);
            $sauna->add_accessory($accessory);
        }

        $num_sm_salt = intval($this->user_inputs['salt-sconce-sm'][$sauna_index]);
        if($num_sm_salt > 0) {
            $accessory = new Accessory('Himalayan Salt Sconce Small','sauna',$num_sm_salt);
            $sauna->add_accessory($accessory);
        }

        $num_headrest = intval($this->user_inputs['headrest'][$sauna_index]);
        if($num_headrest > 0) {
            $accessory = new Accessory('Sauna Head Rest','sauna',$num_headrest);
            $accessory_price = $accessory->getBasePrice();
            if($upgrade == 'ecosauna') {
                $accessory_price += $accessory_price * 0.1875;
            }
            $accessory_price = round($accessory_price);

            $accessory->setPrice($accessory_price);
            $sauna->add_accessory($accessory);
        }

        $num_ssd = intval($this->user_inputs['ssd-bench'][$sauna_index]);
        if($num_ssd > 0) {
            $accessory = new Accessory('SSD Bench','sauna',$num_ssd);
            $sauna->add_accessory($accessory);
        }

        $num_custom_bench = intval($this->user_inputs['custom-bench'][$sauna_index]);
        if($num_custom_bench > 0) {
            $accessory = new Accessory('Custom Bench','sauna',$num_custom_bench);
            $sauna->add_accessory($accessory);
        }
    }

    private function getHeaterInfo($heater_type, $room_volume) {
		if($heater_type == "electric") {
			if ($room_volume <= 140) {
	            $watt = "3 KW";
	            $price = 450;
	        }
	        else if ($room_volume <= 210) {
	            $watt = "4.5 KW";
	            $price = 450;
	        }
	        else if ($room_volume <= 294) {
	            $watt = "6 KW";
	            $price = 593.75;
	        }
	        else if ($room_volume <= 448) {
	            $watt = "7.5 KW";
	            $price = 685;
	        }
	        else if ($room_volume <= 616) {
	            $watt = "9 KW";
	            $price = 718.75;
	        }
	        else if ($room_volume <= 980) {
	            $watt = "12 KW";
	            $price = 1143.75;
	        }
	        else if ($room_volume <= 1428) {
	            $watt = "15 KW";
	            $price = 1281.25;
	        }
	        else if ($room_volume <= 1680) {
	            $watt = "18 KW";
	            $price = 1450;
	        }
	        else {
	            $watt = "Custom Heater Size, Contact Am-Finn for details";
	            $price = 2500;
	        }
		}
		else {
			if ($room_volume <= 600) {
	            $watt = "240-40K BTU";
	            $price = 2962.5;
	        }
	        else {
	            $watt = "280-80K BTU";
	            $price = 4743.75;
	        }
		}

		$heater_info = [
			'price' => $price,
			'watt' => $watt
		];

		return $heater_info;
	}

    /* This could be part of the Sauna Model or smth, but I will leave it like this because of time reasons */
    public function calculateSaunaInitPrice($width, $length, $height, $heater_price) {
		$init_price = 0;
		$area = $width * $length;
		$wall_cost = ($width * $height * 2 + $length * $height * 2 + $width * $length) * 15;
		$bench_cost = ($width - 1 + $length) * 125;
		$trim_cost = $width * $length * 3.75;
		$door_cost = 375;
        $init_price = $wall_cost + $bench_cost + $trim_cost + $door_cost;
		if($area >= 16 && $area <= 25) {
			$init_price += 250;
		}
		return $init_price;
	}


    /**
     * Get the value of proposal_model
     */
    public function getProposalModel()
    {
        return $this->proposal_model;
    }
}