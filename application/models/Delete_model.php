<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Delete_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function remove_campanha($codicampanha)
	{
		$query = $this->db->delete('tbl_campanha', array('CodiCampanha' => $codicampanha));
		if ( $query == true ) {
			return 'Campanha removida com sucesso!';
		}
		else {
			return 'Erro ao remover!';
		}
	}

}
