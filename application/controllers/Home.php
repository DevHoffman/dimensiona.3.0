<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{

	function __construct() {
		parent::__construct();
		$this->load->helper('date');
		$this->load->model('Querys_dimensiona_model', 'query');
	}

	public function index()
	{

		$page_title = "Dimensiona";
		$data['header'] = $this->template->header([ 'title' => $page_title ]);
		$data['navbar']  = $this->template->navbar();
		$data['footer'] = $this->template->footer();
		$data['scripts'] = $this->template->scripts();

		$data_agora = date('Y-m-d', time());
		$hora_agora = date('H:i', time());

		$data['rows_dimensiona'] = $this->query->abs_tempo_real_churisley('2019-11-21', '12:00');

		$this->load->view('home', $data);
	}
}
