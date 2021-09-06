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
			/*echo '<pre>';
			print_r($_POST);
			echo '<pre>';*/
			
			$proposal_controller = new ProposalController($_POST);
			$proposal_controller->createProposal();
			$proposal_model = $proposal_controller->getProposalModel();
			$pdf_generator = new PdfGenerator($proposal_model);
			$this->response->setHeader('Content-Type', 'application/pdf');
			$pdf_generator->printpDF();
		}

		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Cache-Control: no-cache");
		header("Pragma: no-cache");
		return view('main_view', $data);
	}

	public function admin_panel()
	{
		$data = [
			'meta_title' => 'Admin Panel',
		];

		if($this->request->getMethod()=='post') {

		}

		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Cache-Control: no-cache");
		header("Pragma: no-cache");
		return view('admin_panel', $data);
	}

	public function changeBaseRoomPrice() {

	}

	public function changeAccessoryPrice() {

	}

}
