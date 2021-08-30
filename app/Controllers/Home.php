<?php

namespace App\Controllers;

use App\Models\Room;

class Home extends BaseController
{
	public function index()
	{
		$data = [
			'meta_title' => 'Am-Finn Wizard',
			'user' => 'Kristen',
			'passcode' => '1Tamfinn47'
		];

		return view('main_view', $data);
	}

	public function admin_panel()
	{
		return view('admin_panel');
	}

	public function createProposal() {
		if($this->request->getMethod()=='post') {
			$saunas = [];
			$steams = [];

			if(isset($_POST['sauna'])) {
				
				$sauna_rooms = [];

				if(isset($_POST['sauna_same_dims'])) {
					
					//instantiate Room class with $_POST info
					//add instance of Room to $sauna_rooms
				}
				else {
					for($i=0; $i<$_POST['num_saunas']; $i++) {
						//instantiate Room class with $_POST info
						//add instance of Room to $sauna_rooms
					}
				}

				//add heater type for proposal's sauna(s)
				if(isset($_POST['sauna_same_heater'])) {
					
				}
				else {
					for($i=0; $i<$_POST['num_saunas']; $i++) {
						
					}
				}

				//add sauna's accessories
				if(isset($_POST['sauna-same-accessories'])) {

				}
				else {
					for($i=0; $i<$_POST['num_saunas']; $i++) {
						
					}
				}

				if(!empty($_POST['saunas-shipping'])) {
					foreach($sauna_rooms as $room) {
						//add $_POST['saunas-shipping'] to every Room instance 
					}
				}

				foreach($sauna_rooms as $room) {
					//Instantiate Sauna class with $room and $_POST info
					//add instance to $saunas array
				}

			}
			
			if(isset($_POST['steam'])) {
				
			}
		}
	}

}
