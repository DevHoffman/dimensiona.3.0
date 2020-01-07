<?php

// Dia de Ontem Até amanhã de Hoje
$DataZona = new DateTimeZone('America/Sao_Paulo');
$data = new DateTime('NOW');
$data->setTimezone($DataZona);
$data_Hoje = date_format($data, 'Y-m-d');
$hora_agora = date_format($data, 'H:i');

//Conectando ao Banco
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

if ( isset($_GET['CodiCoordenador']) ){

	$CodiCoordenador = trim(addslashes($_GET['CodiCoordenador']));

    $sql = "SELECT E.CodiCoordenador,
        U.Usuario,
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
             JOIN tbl_ausencia A ON A.CodiUsuario = E.CodiUsuario AND A.DataAusencia = E.DataEscalaUsuario
    WHERE E.DataEscalaUsuario = '2019-11-21'
      AND E.HorarioEscalaUsuario < '12:00'
      AND E.HorarioEscalaUsuario NOT IN ('F')
      AND E.CodiCoordenador NOT IN (2)
      AND E.CodiCoordenador = '$CodiCoordenador'
    GROUP BY U.Usuario;";
    $query = $ligacao->query($sql);

}
else{

    $sql = "SELECT E.CodiCoordenador,
       (SELECT tu.Usuario
        FROM tbl_coordenador C
                 JOIN tbl_usuarios tu on C.CodiUsuario = tu.CodiUsuario
        WHERE C.CodiCoordenador = E.CodiCoordenador
          AND C.CodiUsuario = tu.CodiUsuario) as Coordenador,

       COUNT(U.CodiUsuario) as Escalado,
       (SELECT COUNT(*)
        FROM tbl_ausencia A
                 JOIN tbl_escala ES ON ES.CodiUsuario = A.CodiUsuario AND ES.DataEscalaUsuario = A.DataAusencia
                 JOIN tbl_coordenador C ON ES.CodiCoordenador = C.CodiCoordenador
        WHERE A.CodiUsuario = ES.CodiUsuario
          AND A.DataAusencia = ES.DataEscalaUsuario
          AND A.DataAusencia = E.DataEscalaUsuario
          AND ES.CodiCoordenador = E.CodiCoordenador
          AND ES.HorarioEscalaUsuario < '12:00'
        GROUP BY C.CodiCoordenador) as ABS
    FROM tbl_escala E
             JOIN tbl_campanha C ON C.CodiCampanha = E.CodiCampanha
             JOIN tbl_usuarios U ON U.CodiUsuario = E.CodiUsuario
    WHERE E.DataEscalaUsuario = '2019-11-21'
      AND E.HorarioEscalaUsuario < '12:00'
      AND E.HorarioEscalaUsuario NOT IN ('F')
      AND E.CodiCoordenador NOT IN (2)
    GROUP BY E.CodiCoordenador;";
    $query = $ligacao->query($sql);

}

mysqli_close($ligacao);
 
while ( $rows_dimensiona[] = mysqli_fetch_array($query) ){ 
}

?>

<section id="main-content">
  	<section class="wrapper">
	    <div class="row">
	      	<div class="col-xs-9 mt">

		        <!-- BASIC FORM ELELEMNTS -->
                <div class="row content-panel mt">
                    <div class="col-xs-12">

			        	<div class="row centered">
			        		<?php if ( isset($_GET['CodiCoordenador']) ) { ?>
			        		<h3>Visão do Coordenador - <?php echo $rows_dimensiona[0]['Coordenador']; ?></h3>
			        		<?php } else { ?>
			        		<h3>Visão por Coordenador</h3>
			        		<?php } ?>
				        	<hr />
			        	</div>

		              	<table class="table table-hover datatable-buttons">
			                <thead>
						        <tr>
						            <?php if ( isset($_GET['CodiCoordenador']) ) { ?>
						            <th>Nome</th>
						            <th>Supervisor</th>
						            <th>Campanha</th>
						            <?php } else { ?>
						            <th>Coordenador</th>
						            <th>Escalados</th>
						            <th>Absenteísmo</th>
						            <th>%</th>
						            <?php } ?>
						        </tr>
						    </thead>

						    <tbody>
						        <?php

                      foreach ( $rows_dimensiona as $valor) {

                        if ( isset($valor['Coordenador']) ) {

                            printf('<tr>');

                            if ( isset($CodiCoordenador) ){
                                printf('<td>' . $valor['Usuario'] . '</td>');
                                printf('<td>' . $valor['Supervisor'] . '</td>');
                                printf('<td>' . $valor['Campanha'] . '</td>');
                            }
                            else{

                                $Absenteismo_Porcentagem = 0;

                                if ($valor['ABS'] != 0) {
                                    $Absenteismo_Porcentagem = ( $valor['ABS'] * 100) / $valor['Escalado'];
                                    $Absenteismo_Porcentagem = number_format($Absenteismo_Porcentagem, 2, ',', '.');
                                }

                                printf('<td><a href="coordenador.php?CodiCoordenador=' . $valor['CodiCoordenador'] . '">' . $valor['Coordenador'] . '</a></td>');
                                printf('<td>' . $valor['Escalado'] . '</td>');                                
                                print('<td> ' . $valor['ABS'] . ' </td>');
                                print('<td> ' . $Absenteismo_Porcentagem . '% </td>');
                            }
                            
                            printf('</tr>');
                        }
                        
                      }

						        ?>
						    </tbody>
		              	</table>

	              	</div>
		        </div><!-- /col-xs-12 -->

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