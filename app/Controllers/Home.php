<?php

namespace App\Controllers;

class Home extends BaseController
{

	public function index()
	{
		$data = [
			'meta_title' => 'Am-Finn Wizard',
			'passcode' => 'holi'
		];

		if($this->request->getMethod()=='post') {
			$proposal = new ProposalController($_POST);
			//create and redirect to PDF models/views/controllers
		}

		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Cache-Control: no-cache");
		header("Pragma: no-cache");
		return view('main_view', $data);
	}

	public function admin_panel()
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Cache-Control: no-cache");
		header("Pragma: no-cache");
		return view('admin_panel');
	}

}
