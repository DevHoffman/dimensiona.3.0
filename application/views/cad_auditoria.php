<?php

// Conectando ao Banco
require_once 'assets/includes/conexao.php';

$_SESSION['painel_administrativo'] = true;

if ( !isset($_SESSION['auth']) ){
  $_SESSION['auth'] = false;
}

if ( $_SESSION['auth'] == false ){
  	header('location: ../');
	exit;
}
else{
    require_once 'assets/includes/header.php';
}


require_once 'assets/includes/menu_esquerdo.php';

require_once 'assets/includes/menu_topo.php';

if ( isset($_POST['CodiUsuario']) ){

	$CodiUsuario = mysqli_real_escape_string($ligacao, $_POST['CodiUsuario']);
	$DataUltimoAcesso = mysqli_real_escape_string($ligacao, $_POST['DataUltimoAcesso']);

	$DataUltimoAcesso = new DateTime($DataUltimoAcesso);
	$DataUltimoAcesso = date_format($DataUltimoAcesso, 'Y-m-d');

	$sql_verifica_auditoria = "SELECT A.CodiUsuario, U.Usuario, A.DataAcesso, A.HoraUltimoAcesso, A.Ip, A.Descricao
		FROM tbl_usuarios U, tbl_auditoria A
		WHERE U.CodiUsuario=A.CodiUsuario AND A.CodiUsuario='$CodiUsuario' AND A.DataAcesso='$DataUltimoAcesso' LIMIT 1";
	$query_verifica_auditoria = $ligacao->query($sql_verifica_auditoria);
	$row = mysqli_fetch_array($query_verifica_auditoria);
	
	echo $CodiUsuario . ' - ' . $DataUltimoAcesso;
	
	if ( !isset($row[0]) or $row['Descricao'] != 'Alteração de Auditoria' ){

		$sql = "DELETE FROM tbl_ausencia WHERE CodiUsuario='$CodiUsuario' AND DataAusencia='$DataUltimoAcesso';";
		$deleta = $ligacao->query($sql);

		$sql = "INSERT INTO tbl_auditoria (CodiUsuario, DataAcesso, HoraUltimoAcesso, Descricao) VALUES ('$CodiUsuario', '$DataUltimoAcesso', NOW(), 'Alteração de Auditoria')";
		$insere = $ligacao->query($sql);

		if ( $insere == true ){

		    $_SESSION['TituloMensagem'] = "Sucesso!";
        	$_SESSION['TipoMensagem'] = "green";
		    $_SESSION['Mensagem'] = "A auditoria foi cadastrada manualmente.";

		}
		else{

	        $_SESSION['TituloMensagem'] = "Erro!";
        	$_SESSION['TipoMensagem'] = "red";
	        $_SESSION['Mensagem'] = "Verifique as informações cadastradas e tente novamente.";

		}

	}
	else{

		$sql = "DELETE FROM tbl_ausencia WHERE CodiUsuario='$CodiUsuario' AND DataAusencia='$DataUltimoAcesso';";
		$deleta = $ligacao->query($sql);

        $_SESSION['TituloMensagem'] = "Erro!";
    	$_SESSION['TipoMensagem'] = "red";
        $_SESSION['Mensagem'] = "Verifique as informações cadastradas, principalmente a DATA.";

	}

}

if ( isset($_GET['CodiUsuario']) ) {

	// Dia de Ontem Até amanhã de Hoje
	$DataZona = new DateTimeZone('America/Sao_Paulo');
	$Data = new DateTime('NOW');
	$Data->setTimezone($DataZona);
	$Mes = date_format($Data, '-m-');

	$CodiUsuario = mysqli_real_escape_string($ligacao, $_GET['CodiUsuario']);

	$sql_lista_auditoria_ = "SELECT A.CodiUsuario, U.Usuario, A.DataAcesso, A.HoraUltimoAcesso, A.Ip, A.Descricao
		FROM tbl_usuarios U, tbl_auditoria A
		WHERE U.CodiUsuario=A.CodiUsuario AND A.CodiUsuario='$CodiUsuario' AND A.DataAcesso LIKE '%$Mes%' ORDER BY A.DataAcesso DESC";
	$query_lista_auditoria_ = $ligacao->query($sql_lista_auditoria_);
	$query_lista_auditoria_2 = $ligacao->query($sql_lista_auditoria_);
	
	if ($row = mysqli_fetch_array($query_lista_auditoria_2)){

		$Usuario = $row[1];

		$DataAcesso = $row[2];
			
	    $DataAcesso = new DateTime($DataAcesso);
	    $DataAcesso = date_format($DataAcesso, 'd-m-Y');

		$HoraUltimoAcesso = $row[3];

	}

}

// Query Lista
$sql_lista_auditoria = "SELECT E.CodiUsuario, U.Usuario, U.Login
	FROM tbl_usuarios U, tbl_escala E WHERE U.CodiUsuario=E.CodiUsuario GROUP BY U.Usuario";
$query_lista_auditoria = $ligacao->query($sql_lista_auditoria);

$sql_auditoria = "SELECT U.CodiUsuario, U.Usuario, A.DataAcesso, A.HoraUltimoAcesso, A.Ip, A.Descricao 
FROM dimensiona.tbl_usuarios U, dimensiona.tbl_auditoria A WHERE U.CodiUsuario=A.CodiUsuario ORDER BY A.CodiAuditoria DESC LIMIT 30";
$query_auditoria = $ligacao->query($sql_auditoria);

mysqli_close($ligacao);

?>

<link rel="stylesheet" type="text/css" href="../assets/lib/bootstrap-datepicker/css/datepicker.css" />
<link rel="stylesheet" type="text/css" href="../assets/lib/bootstrap-daterangepicker/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="../assets/lib/bootstrap-timepicker/compiled/timepicker.css" />
<link rel="stylesheet" type="text/css" href="../assets/lib/bootstrap-datetimepicker/datertimepicker.css" />

<section id="main-content">
  	<section class="wrapper">
	    <div class="row">
	      	<div class="col-xs-9 mt">

		        <!--CUSTOM CHART START -->
		        <div class="border-head">
		          <h3>Presença</h3>
		        </div>

		        <!-- BASIC FORM ELELEMNTS -->
                <div class="row content-panel mt">
                    <div class="col-xs-12">

			            <div class="panel-heading">
			              <ul class="nav nav-tabs nav-justified">

			                <li class="active">
			                  <a data-toggle="tab" href="#overview">Visualizar Registros</a>
			                </li>

			                <li>
			                  <a data-toggle="tab" href="#edit">Cadastrar Registros</a>
			                </li>

			              </ul>
			            </div><!-- /panel-heading -->
			            
			            <div class="panel-body">
			              	<div class="tab-content">
				                <div id="overview" class="tab-pane active">
				                  	<div class="row">
					                    <div class="col-xs-12 profile-text">
							              	<table class="table table-hover datatable-buttons" id="DataTables">
								                <hr>
								                <thead>
								                  	<tr>
								                    	<th> Nome do Usuário </th>
								                    	<th> Data do Registro </th>
								                    	<th> Horário </th>
								                    	<th> IP </th>
								                    	<th> Descrição </th>
								                  	</tr>
								                </thead>
								                <tbody>

											    	<?php
										    		
											    	while ( $row = mysqli_fetch_array($query_auditoria) ) {

														$row['DataAcesso'] = new DateTime($row['DataAcesso']);
														$row['DataAcesso'] = date_format($row['DataAcesso'], 'd-m-Y');

											    		echo '<tr>';
											    		echo '<td>' . $row['Usuario'] . '</td>';
											    		echo '<td>' . $row['DataAcesso'] . '</td>';
											    		echo '<td>' . $row['HoraUltimoAcesso'] . '</td>';
											    		echo '<td>' . $row['Ip'] . '</td>';
											    		echo '<td>' . $row['Descricao'] . '</td>';
											    		echo '</tr>';
											    	}
										    		
											    	?>

								                </tbody>
							              	</table>
					                    </div>
					                    <!-- /col-xs-4 -->
				                  	</div>
				                  	<!-- /OVERVIEW -->
				                </div>

				                <!-- /tab-pane -->
				                <div id="edit" class="tab-pane">
				                  	<div class="row">
					                    <div class="col-xs-8 col-xs-offset-2 detailed">
					                      	<h4 class="mb">Cadastro de Registros</h4>
					                      	<form role="form" class="form-horizontal" action="cad_auditoria.php" method="POST" enctype="multipart/form-data">
				                      			
				                      			<br />

						                        <div class="form-group">
						                          	<label class="col-xs-4 control-label">Nome do Usuário</label>
						                          	<div class="col-xs-8">
							                            <?php

							                            echo "<select class='select2_Usuarios form-control' name='CodiUsuario'>";
							                            echo "<option value=''></option>";

							                            while($row = mysqli_fetch_array($query_lista_auditoria)){

							                              $CodiUsuarioC = $row['CodiUsuario']; 
							                              $Usuario = $row['Usuario'];
							                      
							                              if ( $CodiUsuarioC == $CodiUsuario and isset($_GET['CodiUsuario']) ){

							                                echo "<option value='$CodiUsuarioC' selected>$Usuario</option>";
							                              
							                              }
							                              else{
							                                  echo "<option value='$CodiUsuarioC'>$Usuario</option>";
							                              }
							                            }

							                            echo "</select>";

							                            ?>
						                          	</div>
						                        </div>

										        <div class="form-group">
										          	<label class="control-label col-xs-4"> Data do Registro </label>
										          	<div class="col-xs-7">
											            <div data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="01-01-2019" class="input-append date dpYears">
											              	<input type="text" readonly="" value="01-01-2019" name="DataUltimoAcesso" size="16" class="form-control">
											              	<span class="input-group-btn add-on">
											                	<button class="btn btn-theme" type="button"><i class="fa fa-calendar"></i></button>
											                </span>
											            </div>
										          	</div>
										        </div>

						                      	<br />
						                      	<br />

						                        <div class="form-group">
						                          	<div class="col-xs-9">
					                            		<button class="btn btn-default" type="reset">Cancelar</button>
						                          	</div>
						                          	<div class="col-xs-3">
						                            	<button class="btn btn-theme centered" type="submit"><i class="fa fa-pencil"></i>&nbsp;&nbsp; Alterar Dados</button>
						                          	</div>
						                        </div>

					                      	</form>
					                    </div>
				                  	</div>
				                  	<!-- /row -->
				                </div>
				                <!-- /tab-pane -->
			              	</div>
			              	<!-- /tab-content -->
			            </div><!-- /panel-body -->

		          	</div>
		          	<!-- /col-xs-12 -->
		        </div>
		        <!-- /col-xs-12 -->

	      	</div>
	      	<!-- /row -->

	      	<?php require_once 'assets/includes/menu_direito.php' ?>

	    </div>
	    <!-- /row -->
  	</section>
</section>
<!--main content end-->

<?php require_once 'assets/includes/footer.php'; ?>

<script type="text/javascript" src="../assets/lib/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="../assets/lib/bootstrap-daterangepicker/date.js"></script>
<script type="text/javascript" src="../assets/lib/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="../assets/lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="../assets/lib/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="../assets/lib/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script src="../assets/lib/advanced-form-components.js"></script>

<!-- Datatables -->
<script>
    $(document).ready(function() {
        var handleDataTableButtons = function() {
            if ($(".datatable-buttons").length) {
                $(".datatable-buttons").DataTable({
                    
                    "language": {
                        "sProcessing":    "Procesando...",
                        "sLengthMenu":    "Mostrar _MENU_ registros",
                        "sZeroRecords":   "Nenhum registro encontrado",
                        "sEmptyTable":    "Nenhum registro encontrado",
                        "sInfo":          "Mostrando registros de _START_ à _END_ de um total de _TOTAL_ registros",
                        "sInfoEmpty":     "Mostrando registros de 0 à 0 de um total de 0 registros",
                        "sInfoFiltered":  "(filtrado de um total de _MAX_ registros)",
                        "sInfoPostFix":   "",
                        "sSearch":        "Buscar:",
                        "sUrl":           "",
                        "sInfoThousands":  ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst":    "Primero",
                            "sLast":    "Último",
                            "sNext":    "Próximo",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    },

                    buttons: [{
                            extend: 'copy',
                            text: 'Copiar', 
                            // className: 'btn-theme',
                            exportOptions: {
                                modifier: {
                                    page: 'current'
                                }
                            },
                        },
                        {
                            extend: 'excel',
                            text: 'Excel', 
                            // className: 'btn-theme',
                            exportOptions: {
                                modifier: {
                                    page: 'current'
                                }
                            },
                        },
                        {
                            extend: 'pdf',
                            text: 'PDF', 
                            // className: 'btn-theme',
                            exportOptions: {
                                modifier: {
                                    page: 'current'
                                }
                            },
                        },
                    ],
                    dom: "Bfrtip",
                    deferRender: true,
                    responsive: true,
					"order": [[ 1, 'desc' ]],
                    "pageLength": 15
                });
            }
        };

        TableManageButtons = function() {
            "use strict";
            return {
                init: function() {
                    handleDataTableButtons();
                }
            };
        }();

        TableManageButtons.init();
    });
</script>
<!-- /Datatables -->