<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Querys_dimensiona_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function abs_tempo_real_churisley_campanha($data, $hora)
	{
		$query = $this->db->query("SELECT x.Campanha, 
											x.CodiCampanha, 
											x.ABS,
											x.Coordenador, 
											x.Escalado,
											IFNULL(round(((x.ABS * 100) / x.Escalado),2), 0) as porcentagem,
											x.Supervisor 
											from (SELECT E.CodiCampanha,
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
		   IFNULL((SELECT COUNT(*)
			FROM tbl_ausencia A
					 JOIN tbl_escala ES ON ES.CodiUsuario = A.CodiUsuario AND ES.DataEscalaUsuario = A.DataAusencia
					 JOIN tbl_campanha C ON ES.CodiCampanha = C.CodiCampanha
			WHERE ES.DataEscalaUsuario = '{$data}'
			  AND ES.HorarioEscalaUsuario <= '{$hora}'
			  AND ES.CodiCampanha = E.CodiCampanha
			GROUP BY C.Campanha), 0) as ABS
		FROM tbl_escala E
				 JOIN tbl_campanha C ON C.CodiCampanha = E.CodiCampanha
				 JOIN tbl_usuarios U ON U.CodiUsuario = E.CodiUsuario
		WHERE E.DataEscalaUsuario = '{$data}'
			  AND E.HorarioEscalaUsuario <= '{$hora}'
		  AND E.HorarioEscalaUsuario <> 'F'
		  AND E.CodiCoordenador  <> 2
		GROUP BY C.Campanha) AS x;");

		return $query->result_array();
	}

	public function abs_tempo_real_churisley_codicampanha($data, $hora, $id_campanha)
	{
		$query = $this->db->query("SELECT E.CodiUsuario,
			   U.Usuario,
			   E.HorarioEscalaUsuario as Horario,
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
				  C.Campanha
		FROM tbl_escala E
				 JOIN tbl_campanha C ON C.CodiCampanha = E.CodiCampanha
				 JOIN tbl_usuarios U ON U.CodiUsuario = E.CodiUsuario
				 JOIN tbl_ausencia A ON E.CodiUsuario = A.CodiUsuario AND E.DataEscalaUsuario = A.DataAusencia
		WHERE E.DataEscalaUsuario = '{$data}'
		  AND E.HorarioEscalaUsuario <= '{$hora}'
		  AND E.HorarioEscalaUsuario <> 'F'
		  AND E.CodiCoordenador  <> 2
		  AND E.CodiCampanha = '{$id_campanha}'
		GROUP BY U.Usuario;");

		return $query->result_array();
	}

	public function abs_tempo_real_churisley_coordenador($data, $hora)
	{
		$query = $this->db->query("SELECT x.CodiCoordenador,
			   x.Coordenador,
			   x.Escalado,
			   x.ABS,
			   IFNULL(round(((x.ABS * 100) / x.Escalado),2), 0) as porcentagem
			from (SELECT E.CodiCoordenador,
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
				 IFNULL((SELECT COUNT(*)
					 FROM tbl_ausencia A
							  JOIN tbl_escala ES ON ES.CodiUsuario = A.CodiUsuario AND ES.DataEscalaUsuario = A.DataAusencia
							  JOIN tbl_campanha C ON ES.CodiCampanha = C.CodiCampanha
					 WHERE ES.DataEscalaUsuario = '{$data}'
					   AND ES.HorarioEscalaUsuario <= '{$hora}'
					   AND ES.CodiCoordenador = E.CodiCoordenador
					 GROUP BY E.CodiCoordenador), 0) as ABS
			  FROM tbl_escala E
					   JOIN tbl_campanha C ON C.CodiCampanha = E.CodiCampanha
					   JOIN tbl_usuarios U ON U.CodiUsuario = E.CodiUsuario
			  WHERE E.DataEscalaUsuario = '{$data}'
				AND E.HorarioEscalaUsuario <= '{$hora}'
				AND E.HorarioEscalaUsuario <> 'F'
				AND E.CodiCoordenador  <> 2
			  GROUP BY E.CodiCoordenador) AS x;");

		return $query->result_array();
	}

	public function abs_tempo_real_churisley_codicoordenador($data, $hora, $id_coordenador)
	{
		$query = $this->db->query("SELECT E.CodiUsuario,
			   U.Usuario,
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
				  AND C.CodiUsuario = tu.CodiUsuario) as Coordenador,
			   C.Campanha
		FROM tbl_escala E
				 JOIN tbl_campanha C ON C.CodiCampanha = E.CodiCampanha
				 JOIN tbl_usuarios U ON U.CodiUsuario = E.CodiUsuario
				 JOIN tbl_ausencia A ON E.CodiUsuario = A.CodiUsuario AND E.DataEscalaUsuario = A.DataAusencia
		WHERE E.DataEscalaUsuario = '{$data}'
		  AND E.HorarioEscalaUsuario <= '{$hora}'
		  AND E.HorarioEscalaUsuario <> 'F'
		  AND E.CodiCoordenador  <> 2
		  AND E.CodiCoordenador = '{$id_coordenador}'
		GROUP BY U.Usuario;");

		return $query->result_array();
	}

	public function abs_tempo_real_churisley_supervisor($data, $hora)
	{
		$query = $this->db->query("SELECT x.CodiSupervisor,
			   x.Supervisor,
			   x.Escalado,
			   x.ABS,
			   IFNULL(round(((x.ABS * 100) / x.Escalado),2), 0) as porcentagem
			from (SELECT E.CodiSupervisor,
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
				 IFNULL((SELECT COUNT(*)
					 FROM tbl_ausencia A
							  JOIN tbl_escala ES ON ES.CodiUsuario = A.CodiUsuario AND ES.DataEscalaUsuario = A.DataAusencia
							  JOIN tbl_campanha C ON ES.CodiCampanha = C.CodiCampanha
					 WHERE ES.DataEscalaUsuario = '{$data}'
					   AND ES.HorarioEscalaUsuario <= '{$hora}'
					   AND ES.CodiSupervisor = E.CodiSupervisor
					 GROUP BY E.CodiSupervisor), 0) as ABS
			  FROM tbl_escala E
					   JOIN tbl_campanha C ON C.CodiCampanha = E.CodiCampanha
					   JOIN tbl_usuarios U ON U.CodiUsuario = E.CodiUsuario
			  WHERE E.DataEscalaUsuario = '{$data}'
				AND E.HorarioEscalaUsuario <= '{$hora}'
				AND E.HorarioEscalaUsuario <> 'F'
				AND E.CodiCoordenador  <> 2
			  GROUP BY E.CodiSupervisor) AS x;");

		return $query->result_array();
	}

	public function abs_tempo_real_churisley_codisupervisor($data, $hora, $id_supervisor)
	{
		$query = $this->db->query("SELECT E.CodiUsuario,
			   U.Usuario,
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
				  AND C.CodiUsuario = tu.CodiUsuario) as Coordenador,
			   C.Campanha
		FROM tbl_escala E
				 JOIN tbl_campanha C ON C.CodiCampanha = E.CodiCampanha
				 JOIN tbl_usuarios U ON U.CodiUsuario = E.CodiUsuario
				 JOIN tbl_ausencia A ON E.CodiUsuario = A.CodiUsuario AND E.DataEscalaUsuario = A.DataAusencia
		WHERE E.DataEscalaUsuario = '{$data}'
		  AND E.HorarioEscalaUsuario <= '{$hora}'
		  AND E.HorarioEscalaUsuario <> 'F'
		  AND E.CodiCoordenador  <> 2
		  AND E.CodiSupervisor = '{$id_supervisor}'
		GROUP BY U.Usuario;");

		return $query->result_array();
	}

	public function abs_tempo_real_churisley_operador($data, $hora)
	{
		$query = $this->db->query("SELECT E.CodiUsuario,
			   U.Usuario,
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
				  AND C.CodiUsuario = tu.CodiUsuario) as Coordenador,
			   C.Campanha
		FROM tbl_escala E
				 JOIN tbl_campanha C ON C.CodiCampanha = E.CodiCampanha
				 JOIN tbl_usuarios U ON U.CodiUsuario = E.CodiUsuario
				 JOIN tbl_ausencia A ON E.CodiUsuario = A.CodiUsuario AND E.DataEscalaUsuario = A.DataAusencia
		WHERE E.DataEscalaUsuario = '{$data}'
		  AND E.HorarioEscalaUsuario <= '{$hora}'
		  AND E.HorarioEscalaUsuario <> 'F'
		  AND E.CodiCoordenador  <> 2
		GROUP BY U.Usuario;");

		return $query->result_array();
	}

	public function lista_operadores() {
		$query = $this->db->query("SELECT E.CodiUsuario,
			   U.Usuario,
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
				  AND C.CodiUsuario = tu.CodiUsuario) as Coordenador,
			   C.Campanha
		FROM tbl_escala E
				 JOIN tbl_campanha C ON C.CodiCampanha = E.CodiCampanha
				 JOIN tbl_usuarios U ON U.CodiUsuario = E.CodiUsuario
		WHERE E.HorarioEscalaUsuario <> 'F'
		  AND E.CodiCoordenador  <> 2
		GROUP BY U.Usuario;");
		return $query->result_array();
	}

	public function findCampanhaById($id_campanha)
	{
		$query = $this->db->where('CodiCampanha', $id_campanha)
			->get('tbl_campanha', 1);
		return $query->result_array();
	}

	public function findSupervisorById($id_supervisor)
	{
		$query = $this->db->where('CodiSupervisor', $id_supervisor)
			->join('tbl_usuarios U', "U.CodiUsuario = S.CodiUsuario")
			->get('tbl_supervisor S', 1);
		return $query->result_array();
	}

	public function findCoordenadorById($id_coordenador)
	{
		$query = $this->db->select('Usuario')
		->from('tbl_usuarios U' , 1)
		->join('tbl_coordenador C', "C.CodiUsuario = U.CodiUsuario AND C.CodiCoordenador = '{$id_coordenador}'")
		->get();
		return $query->result_array();
	}

}
