<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cadastros_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function cadastro_campanha($nome_campanha){

		$query = $this->db->insert('tbl_campanha', array('Campanha' => $nome_campanha));
		if ( $query == true ){
			return 1;
		}
	}

}
