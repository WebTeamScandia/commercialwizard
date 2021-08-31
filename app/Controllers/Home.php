<?php

namespace App\Controllers;

use App\Models\Room;

class Home extends BaseController
{

	public function index()
	{
		$data = [
			'meta_title' => 'Am-Finn Wizard',
			'passcode' => 'Daley09821'
		];

		return view('main_view', $data);
	}

	public function admin_panel()
	{
		return view('admin_panel');
	}

	public function createProposal() {
		if($this->request->getMethod()=='post') {
			echo '<pre>';
			print_r($_POST);
		  	echo '<pre>';
			$saunas = [];
			$steams = [];

			if(isset($_POST['sauna'])) {
				
				$num_saunas = intval($_POST['num-saunas']);

				if(isset($_POST['sauna-same-dims']) && isset($_POST['sauna-same-heater'])) {
					$width = intval($_POST['sauna-width'][0]);
					$lenght = intval($_POST['sauna-length'][0]);
					$height = intval($_POST['sauna-height'][0]);

					$shipping_cost = intval($_POST['saunas-shipping']);
					
					$heater_type = $_POST['heater'][0]; //missing validation.
					
					$width_ft = $width/12;
					$lenght_ft = $lenght/12;
					$height_ft = $height/12;
					$sauna_volume_ft3 =  $width_ft * $lenght_ft * $height_ft;
					
					$pc = 'PC' . inval($width_ft) . intval($lenght_ft) . '-' . intval($height_ft);

					$heater_info = getHeaterInfo($heater_type, $sauna_volume_ft3);

					$price = calculateSaunaInitPrice($width, $lenght, $height, $heater_info['price']);

					$sauna =  new Sauna($width, $length, $height, $pc, $heater_type, $heater_info['price'], $heater_info['watt'], $price, $shipping_cost);
					
					for($i=0; $i<($num_saunas-1); $i++) {
						array_push($saunas, $sauna);
					}
				}
				else if(isset($_POST['sauna-same-dims'])){ //same dims but different heaters
					$width = intval($_POST['sauna-width'][0]);
					$lenght = intval($_POST['sauna-length'][0]);
					$height = intval($_POST['sauna-height'][0]);
					
					$shipping_cost = intval($_POST['saunas-shipping']);
					
					$width_ft = $width/12;
					$lenght_ft = $lenght/12;
					$height_ft = $height/12;
					$sauna_volume_ft3 =  $width_ft * $lenght_ft * $height_ft;
					
					$pc = 'PC' . inval($width_ft) . intval($lenght_ft) . '-' . intval($height_ft);

					for($i=0; $i<($num_saunas-1); $i++) {
						$heater_type = $_POST['heater'][$i]; //missing validation.
					}
				}
				else if(isset($_POST['sauna-same-heater'])) { //same heater type but different dims

				}
				else { //different heaters and dims

				}

				//add sauna's accessories
				if(isset($_POST['sauna-same-accessories'])) {

				}
				else {
					
				}

				if(!empty($_POST['discount'])) {

				}

				if(!empty($_POST['tax'])) {

				}
				
			}
			
			if(isset($_POST['steam'])) {
				
			}
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

	public function calculateSaunaInitPrice($width, $lenght, $height, $heater_price) {

	}
}
