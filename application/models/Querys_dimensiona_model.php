<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Querys_dimensiona_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public function abs_tempo_real($data, $hora) {
		$query = $this->db->query("SELECT E.CodiCampanha,
		   C.Campanha,
		   (SELECT tu.Usuario
			FROM tbl_supervisor S
					 JOIN tbl_usuarios tu on S.CodiUsuario = tu.CodiUsuario
			WHERE S.CodiSupervisor = E.CodiSupervisor
			  AND S.CodiUsuario = tu.CodiUsuario) as Supervisor,
		   (SELECT tu.Usuario
			FROM tbl_coordenador C
					 JOIN tbl_usuarios tu on C.CodiUsuario = tu.CodiUsuario
			WHERE C.CodiCoordenador = E.CodiCoordenador
			  AND C.CodiUsuario = tu.CodiUsuario) as Coordenador,
		
		   COUNT(*) as Escalado,
		   (SELECT COUNT(*)
			FROM tbl_ausencia A
					 JOIN tbl_escala ES ON ES.CodiUsuario = A.CodiUsuario AND ES.DataEscalaUsuario = A.DataAusencia
					 JOIN tbl_campanha C ON ES.CodiCampanha = C.CodiCampanha
			WHERE ES.DataEscalaUsuario = '{$data}'
			  AND ES.HorarioEscalaUsuario <= '{$hora}'
			  AND ES.CodiCampanha = E.CodiCampanha
			GROUP BY C.Campanha) as ABS
		FROM tbl_escala E
				 JOIN tbl_campanha C ON C.CodiCampanha = E.CodiCampanha
				 JOIN tbl_usuarios U ON U.CodiUsuario = E.CodiUsuario
		WHERE E.DataEscalaUsuario = '{$data}'
			  AND E.HorarioEscalaUsuario <= '{$hora}'
		  AND E.HorarioEscalaUsuario <> 'F'
		  AND E.CodiCoordenador  <> 2
		GROUP BY C.Campanha;");

		return $query->result_array();
	}

	public function abs_tempo_real_campanha($data, $hora, $id_campanha) {
		$query = $this->db->query("SELECT E.CodiUsuario,
	   U.Usuario,
	   C.Campanha,
	   E.HorarioEscalaUsuario Horario,
	   (SELECT tu.Usuario
		FROM tbl_supervisor S
				 JOIN tbl_usuarios tu on S.CodiUsuario = tu.CodiUsuario
		WHERE S.CodiSupervisor = E.CodiSupervisor
		  AND S.CodiUsuario = tu.CodiUsuario) as Supervisor,
	   (SELECT tu.Usuario
		FROM tbl_coordenador C
				 JOIN tbl_usuarios tu on C.CodiUsuario = tu.CodiUsuario
		WHERE C.CodiCoordenador = E.CodiCoordenador
		  AND C.CodiUsuario = tu.CodiUsuario) as Coordenador
		FROM tbl_escala E
				 JOIN tbl_campanha C ON C.CodiCampanha = E.CodiCampanha
				 JOIN tbl_usuarios U ON U.CodiUsuario = E.CodiUsuario
		WHERE E.DataEscalaUsuario = '2019-11-21'
		  AND E.HorarioEscalaUsuario <= '12:00'
		  AND E.HorarioEscalaUsuario <> 'F'
		  AND E.CodiCampanha = '{$id_campanha}'
		  AND E.CodiCoordenador  <> 2
		GROUP BY U.CodiUsuario;");

		return $query->result_array();
	}
}
