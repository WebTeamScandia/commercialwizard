<?php

namespace App\Controllers;

use App\Models\Sauna;
use app\Models\Steam;
use app\Models\Proposal;
use app\Models\Accessory;

class Home extends BaseController
{

	public function index()
	{
		$data = [
			'meta_title' => 'Am-Finn Wizard',
			'passcode' => 'Daley09821'
		];

		if($this->request->getMethod()=='post') {
			createProposal();
		}

		return view('main_view', $data);
	}

	public function admin_panel()
	{
		return view('admin_panel');
	}

	public function createProposal() {
		echo '<pre>';
		  print_r($_POST);
		echo '<pre>';
		$saunas = [];
		$steams = [];

		//proposal discout info

		//proposal sales tax info

		if(isset($_POST['sauna'])) {

			$saunas = $this->createSaunas();
			
		}
		
		if(isset($_POST['steam'])) {
			
		}
	}

	private function createSaunas() {
		$saunas = [];

		$num_saunas = intval($_POST['num-saunas']);

		echo '<pre>';
		  print_r($num_saunas);
		echo '<pre>';

		if(isset($_POST['sauna-same-dims']) && isset($_POST['sauna-same-heater'])) {
			$width = intval($_POST['sauna-width'][0]);
			$length = intval($_POST['sauna-length'][0]);
			$height = intval($_POST['sauna-height'][0]);

			$shipping_cost = intval($_POST['saunas-shipping']);
			
			$heater_type = $_POST['heater'][0];
			
			$width_ft = $width/12;
			$length_ft = $length/12;
			$height_ft = $height/12;
			$sauna_volume_ft3 =  $width_ft * $length_ft * $height_ft;
			
			$pc = 'PC' . intval($width_ft) . intval($length_ft) . '-' . intval($height_ft);

			$heater_info = $this->getHeaterInfo($heater_type, $sauna_volume_ft3);

			$price = $this->calculateSaunaInitPrice($width, $length, $height, $heater_info['price']);

			$sauna =  new Sauna($width, $length, $height, $pc, $heater_type, $heater_info['price'], $heater_info['watt'], $price, $shipping_cost);
			
			for($i=0; $i<$num_saunas; $i++) {
				array_push($saunas, $sauna);
			}
		}
		else if(isset($_POST['sauna-same-dims'])){ //same dims but different heaters
			$width = intval($_POST['sauna-width'][0]);
			$length = intval($_POST['sauna-length'][0]);
			$height = intval($_POST['sauna-height'][0]);
			
			$shipping_cost = intval($_POST['saunas-shipping']);
			
			$width_ft = $width/12;
			$length_ft = $length/12;
			$height_ft = $height/12;
			$sauna_volume_ft3 =  $width_ft * $length_ft * $height_ft;
			
			$pc = 'PC' . intval($width_ft) . intval($length_ft) . '-' . intval($height_ft);

			for($i=0; $i<$num_saunas; $i++) {

				$heater_type = $_POST['heater'][$i];

				$heater_info = $this->getHeaterInfo($heater_type, $sauna_volume_ft3);

				$price = $this->calculateSaunaInitPrice($width, $length, $height, $heater_info['price']);

				$sauna =  new Sauna($width, $length, $height, $pc, $heater_type, $heater_info['price'], $heater_info['watt'], $price, $shipping_cost);

				array_push($saunas, $sauna);
			}
		}
		else if(isset($_POST['sauna-same-heater'])) { //same heater type but different dims
			$heater_type = $_POST['heater'][0];

			$shipping_cost = intval($_POST['saunas-shipping']);

			$heater_info = $this->getHeaterInfo($heater_type, $sauna_volume_ft3);

			for($i=0; $i<$num_saunas; $i++) {
				$width = intval($_POST['sauna-width'][$i]);
				$length = intval($_POST['sauna-length'][$i]);
				$height = intval($_POST['sauna-height'][$i]);

				$width_ft = $width/12;
				$length_ft = $length/12;
				$height_ft = $height/12;
				$sauna_volume_ft3 =  $width_ft * $length_ft * $height_ft;

				$pc = 'PC' . intval($width_ft) . intval($length_ft) . '-' . intval($height_ft);

				$price = $this->calculateSaunaInitPrice($width, $length, $height, $heater_info['price']);

				$sauna =  new Sauna($width, $length, $height, $pc, $heater_type, $heater_info['price'], $heater_info['watt'], $price, $shipping_cost);

				array_push($saunas, $sauna);
			}
		}
		else { //different heaters and dims
			for($i=0; $i<$num_saunas; $i++) {
				$width = intval($_POST['sauna-width'][$i]);
				$length = intval($_POST['sauna-length'][$i]);
				$height = intval($_POST['sauna-height'][$i]);

				$shipping_cost = intval($_POST['saunas-shipping']);
				
				$heater_type = $_POST['heater'][$i]; 
				
				$width_ft = $width/12;
				$length_ft = $length/12;
				$height_ft = $height/12;
				$sauna_volume_ft3 =  $width_ft * $length_ft * $height_ft;
				
				$pc = 'PC' . intval($width_ft) . intval($length_ft) . '-' . intval($height_ft);

				$heater_info = $this->getHeaterInfo($heater_type, $sauna_volume_ft3);

				$price = $this->calculateSaunaInitPrice($width, $length, $height, $heater_info['price']);

				$sauna =  new Sauna($width, $length, $height, $pc, $heater_type, $heater_info['price'], $heater_info['watt'], $price, $shipping_cost);

				array_push($saunas, $sauna);
			}
		}

		//add sauna's accessories
		if(isset($_POST['sauna-same-accessories'])) {
			foreach($saunas as $sauna) {

			}
		}
		else {
			
		}

		return $saunas;
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

	public function calculateSaunaInitPrice($width, $length, $height, $heater_price) {

	}
}
