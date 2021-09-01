<?php

namespace App\Controllers;

class Home extends BaseController
{

	public function index()
	{
		$data = [
			'meta_title' => 'Am-Finn Wizard',
			'passcode' => 'Daley09821'
		];

		if($this->request->getMethod()=='post') {
			echo '<pre>';
			echo print_r($_POST);
			echo '<pre>';
			$proposal = new ProposalController($_POST);
			//create and redirect to PDF models/views/controllers
		}

		return view('main_view', $data);
	}

	public function admin_panel()
	{
		return view('admin_panel');
	}

}
