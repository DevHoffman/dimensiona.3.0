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

if ( isset($_POST['Campanha']) ){

	$Campanha = mysqli_real_escape_string($ligacao, $_POST['Campanha']);

	$sql = sprintf("SELECT * FROM tbl_campanha WHERE Campanha='$Campanha'");
	$query = $ligacao->query($sql);

	if ($query->num_rows == 0){
		$sql = sprintf("INSERT INTO tbl_campanha (Campanha) VALUES ('$Campanha')");
		$ligacao->query($sql);

	    $_SESSION['TituloMensagem'] = "Sucesso!";
        $_SESSION['TipoMensagem'] = "green";
	    $_SESSION['Mensagem'] = "Campanha " . $Campanha . " adicionada a lista de campanhas.";
	}
	else{
	    $_SESSION['TituloMensagem'] = "Erro!";
        $_SESSION['TipoMensagem'] = "red";
	    $_SESSION['Mensagem'] = "Verifique se a Campanha " . $Campanha . " existe antes de cadastrar.";
	}

}
                            
$query_nivelAcesso = "SELECT U.CodiNivelAcesso, N.NivelAcesso FROM tbl_usuarios U, tbl_nivelacesso N WHERE U.CodiNivelAcesso=N.CodiNivelAcesso GROUP BY N.NivelAcesso";
$query_nivelAcesso = $ligacao->query($query_nivelAcesso);

$sql = "SELECT CodiCampanha, Campanha FROM tbl_campanha C GROUP BY Campanha";
$query_campanha = $ligacao->query($sql);

mysqli_close($ligacao);

?>

<section id="main-content">
  	<section class="wrapper">
	    <div class="row">
	      	<div class="col-xs-9 mt">

		        <!--CUSTOM CHART START -->
		        <div class="border-head">
		          <h3>Campanha</h3>
		        </div>

		        <!-- BASIC FORM ELELEMNTS -->
                <div class="row content-panel mt">
                    <div class="col-xs-12">
			            <div class="panel-heading">
			              <ul class="nav nav-tabs nav-justified">

			                <li class="active">
			                  <a data-toggle="tab" href="#overview">Visualizar Campanhas</a>
			                </li>

			                <li>
			                  <a data-toggle="tab" href="#edit">Cadastrar Campanhas</a>
			                </li>

			              </ul>
			            </div>
			            <!-- /panel-heading -->
			            <div class="panel-body">
			              	<div class="tab-content">
				                <div id="overview" class="tab-pane active">
				                  	<div class="row">
					                    <div class="col-md-12 profile-text">
							              	<table class="table table-hover datatable-buttons">
								                <hr>
								                <thead>
								                  	<tr>
								                    	<th>Nome da Campanha</th>
								                  	</tr>
								                </thead>
								                <tbody>

											    	<?php
										    		
											    	while ( $row = mysqli_fetch_array($query_campanha) ) {
											    		echo '<tr>';
											    		echo '<td>' . $row['Campanha'] . '</td>';
											    		echo '</tr>';
											    	}
										    		
											    	?>

								                </tbody>
							              	</table>
					                    </div>
					                    <!-- /col-md-4 -->
				                  	</div>
				                  	<!-- /OVERVIEW -->
				                </div>

				                <!-- /tab-pane -->
				                <div id="edit" class="tab-pane">
				                  	<div class="row">
					                    <div class="col-xs-8 col-xs-offset-2 detailed">
					                      	<h4 class="mb">Cadastro de Campanhas</h4>
					                      	<form role="form" class="form-horizontal" action="cad_campanha.php" method="POST" enctype="multipart/form-data">
					                      	<br />
					                        <div class="form-group">
					                            <label class="col-xs-4 control-label">Nome da Campanha</label>
					                            <div class="col-xs-8">
					                              	<input type="text" name="Campanha" class="form-control" required placeholder="" value="" />
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
					                      	<br />

					                      </form>
					                    </div>
				                  	</div>
				                  	<!-- /row -->
				                </div>
				                <!-- /tab-pane -->
			              	</div>
			              	<!-- /tab-content -->
			            </div>
			            <!-- /panel-body -->
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