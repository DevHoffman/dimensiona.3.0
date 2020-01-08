<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Desenho_global extends CI_Controller
{

	function __construct() {
		parent::__construct();
		$this->route = base_url('desenho_global');
		$this->views = 'desenho_global';
		$this->load->helper('date');
		$this->load->model('Querys_dimensiona_model', 'query');
	}

	public function index()
	{

		$data['datasource'] = "{$this->route}/datatables";
		$page_title = "Dimensiona";
		$data['header'] = $this->template->header([
			'title' 	=> $page_title,
			'header'	=> [
				base_url('assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css'),
				base_url('assets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css'),
				base_url('assets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css'),
				base_url('assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css'),
				base_url('assets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')
			]
		]);
		$data['navbar']  = $this->template->navbar();
		$data['sidebar']  = $this->template->sidebar();
		$data['footer'] = $this->template->footer();
		$data['scripts'] = $this->template->scripts([
			'scripts' => [
				base_url('assets/vendors/datatables.net/js/jquery.dataTables.min.js'),
				base_url('assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js'),
				base_url('assets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js'),
				base_url('assets/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js'),
				base_url('assets/vendors/datatables.net-buttons/js/buttons.flash.min.js'),
				base_url('assets/vendors/datatables.net-buttons/js/buttons.html5.min.js'),
				base_url('assets/vendors/datatables.net-buttons/js/buttons.print.min.js'),
				base_url('assets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js'),
				base_url('assets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js'),
				base_url('assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js'),
				base_url('assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js'),
				base_url('assets/vendors/datatables.net-scroller/js/dataTables.scroller.min.js'),
				base_url('assets/vendors/jszip/dist/jszip.min.js'),
				base_url('assets/vendors/pdfmake/build/pdfmake.min.js'),
				base_url('assets/vendors/pdfmake/build/vfs_fonts.js'),
			]
		]);

		$data['url_update'] = $this->route . '/detalhes/';

		$this->load->view("{$this->views}/desenho_global", $data);

	}

	public function datatables()
	{

		$datatables = $this->query->lista_operadores();

		$this->output->set_content_type('application/json')->set_output(json_encode($datatables));

	}

}
