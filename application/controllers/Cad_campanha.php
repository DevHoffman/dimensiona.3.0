<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cad_campanha extends CI_Controller
{

	function __construct() {
		parent::__construct();
		$this->route = base_url('cad_campanha');
		$this->views = 'campanha';
		$this->load->model('Cadastros_model', 'insere');
		$this->load->model('Delete_model', 'remove');
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
				base_url('assets/js/jquery.validate.min.js'),
			]
		]);

		$data['url_update'] = $this->route . '/detalhes/';
		$data['url_cadastrar'] = $this->route . '/cadastrar/';
		$data['url_delete'] = $this->route . '/remover/';

		$this->load->view("{$this->views}/cad_campanha", $data);
	}

	public function datatables()
	{

		$datatables = $this->datatable->exec(
			$this->input->post(),
			'tbl_campanha',
			[
				['db' => 'CodiCampanha', 'dt' => 'CodiCampanha'],
				['db' => 'Campanha', 'dt' => 'Campanha'],
			]
		);

		$this->output->set_content_type('application/json')->set_output(json_encode($datatables));
	}

	public function cadastrar($campanha){

		$dados_form = $this->insere->cadastro_campanha($campanha);

		// if ( $dados_form == 1 ) {
		// 	$_SESSION['Mensagem'] = 'Campanha ' . $campanha . ' Cadastrada com Suceso';
		// }
		// else {
		// 	$_SESSION['Mensagem'] = 'Erro ao cadastrar campanha ' . $campanha . ', tente novamente';
		// }

		$this->output->set_content_type('application/json')->set_output(json_encode($dados_form));

	}

	public function remover($codicampanha){

		$dados_form = $this->remove->remove_campanha($codicampanha);
//		if ( $dados_form == 1 ) {
//			$_SESSION['Mensagem'] = 'Campanha ' . $campanha . ' Excluída com Suceso';
//		}
//		else {
//			$_SESSION['Mensagem'] = 'Erro ao remover campanha ' . $campanha . ', tente novamente';
//		}

		$this->output->set_content_type('application/json')->set_output(json_encode($dados_form));

	}
}
