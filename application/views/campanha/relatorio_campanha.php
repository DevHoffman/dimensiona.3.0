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

if ( isset($_GET['Data_Campanha']) ) {

    $Data_Campanha = trim(addslashes($_GET['Data_Campanha']));

    $Data_1 = substr($Data_Campanha, 0, 10);

    $Data_1 = date('Y-m-d', strtotime($Data_1));

    $Data_2 = substr($Data_Campanha, -10);

    $Data_2 = date('Y-m-d', strtotime($Data_2));

    $data = $Data_1 . ' - ' . $Data_2;

    if ( isset($_GET['CodiCampanha']) ) {

        $CodiCampanha = trim(addslashes($_GET['CodiCampanha']));

        $sql = "SELECT U.Usuario,
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
            WHERE ES.DataEscalaUsuario BETWEEN '$Data_1' AND '$Data_2'
              AND ES.CodiCoordenador <> 2
              AND ES.HorarioEscalaUsuario <> 'F'
              AND ES.CodiUsuario = E.CodiUsuario
            GROUP BY C.Campanha, U.Usuario) as ABS
        FROM tbl_escala E
                 JOIN tbl_campanha C ON C.CodiCampanha = E.CodiCampanha
                 JOIN tbl_usuarios U ON U.CodiUsuario = E.CodiUsuario
        WHERE E.DataEscalaUsuario BETWEEN '$Data_1' AND '$Data_2'
          AND E.HorarioEscalaUsuario <> 'F'
          AND E.CodiCampanha = '$CodiCampanha'
          AND E.CodiCoordenador <> 2
        GROUP BY C.Campanha, U.Usuario;";
        $query = $ligacao->query($sql);

    }
    else{ // Se não houver o GET

        $sql = "SELECT E.CodiCampanha,
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
            WHERE ES.DataEscalaUsuario BETWEEN '$Data_1' AND '$Data_2'
              AND ES.CodiCampanha = E.CodiCampanha
            GROUP BY C.Campanha) as ABS
        FROM tbl_escala E
                 JOIN tbl_campanha C ON C.CodiCampanha = E.CodiCampanha
                 JOIN tbl_usuarios U ON U.CodiUsuario = E.CodiUsuario
        WHERE E.DataEscalaUsuario BETWEEN '$Data_1' AND '$Data_2'
          AND E.HorarioEscalaUsuario <> 'F'
          AND E.CodiCoordenador  <> 2
        GROUP BY C.Campanha;";
        $query = $ligacao->query($sql);

    }
 
    mysqli_close($ligacao);

    while ( $rows_dimensiona[] = mysqli_fetch_array($query) ){ }

}
else{

    // Dia de Ontem Até amanhã de Hoje
    $DataZona = new DateTimeZone('America/Sao_Paulo');
    $data = new DateTime('today');
    $data->setTimezone($DataZona);
    $Data_Campanha = date_format($data, 'd-m-Y');

    $Data_Campanha = $Data_Campanha . ' - ' . $Data_Campanha;

}

require_once 'assets/includes/header.php';

?>

<!-- bootstrap-daterangepicker -->
<link href="assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<!-- / bootstrap-daterangepicker -->

<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-xs-9 mt">
                
                <!-- BASIC FORM ELELEMNTS -->
                <div class="row content-panel mt">
                    <div class="col-xs-12">

                        <div class="row centered">
                            <h3>Gerar relatório por Campanha</h3>
                            <hr />
                        </div>

                        <div class="row centered">

                            <form role="form" class="form-horizontal" action="relatorio_campanha.php" method="GET" enctype="multipart/form-data">

                                <br />
                                <br />
                                
                                <div class="form-group">
                                    <label class="control-label col-xs-3 col-xs-offset-3">Pesquise por datas</label>
                                    <div class="col-xs-4">
                                        <div class="input-large" data-date="01/01/2019" data-date-format="mm/dd/yyyy">
                                            <input type="text" name="Data_Campanha" id="reservation" class="form-control" value="<?php echo $Data_Campanha; ?>" />
                                        </div>
                                    </div>
                                </div>

                                <br />
                                <br />
                                 
                                <div class="form-group">
                                    <button type="submit" class="btn btn-theme">Pesquisar</button>
                                </div>
                                
                                <br />
                                <br />
                                
                            </form>
                        </div>

                    </div>
                </div>
                
                <?php 

                if ( isset($_GET['Data_Campanha']) ) { ?>
                    
                    <!-- BASIC FORM ELELEMNTS -->
                    <div class="row content-panel mt">
                        <div class="col-xs-12">

                            <div class="row centered">
                                <?php if ( isset($_GET['CodiCampanha']) ) { ?>
                                <h3>Visão por Campanha - <?php echo $rows_dimensiona[0]['Campanha']; ?></h3>
                                <?php } else { ?>
                                <h3>Visão por Campanha</h3>
                                <?php } ?>
                                <hr />
                            </div>

                            <table class="table table-hover datatable-buttons">
                                <thead>
                                    <tr>
                                        <?php if ( isset($_GET['CodiCampanha']) ) { ?>
                                        <th>Nome</th>
                                        <th>Supervisor</th>
                                        <th>Coordenador</th>
                                        <th>Escalados</th>
                                        <th>Absenteísmo</th>
                                        <th>%</th>
                                        <?php } else { ?>
                                        <th>Campanha</th>
                                        <th>Escalados</th>
                                        <th>Absenteísmo</th>
                                        <th>%</th>
                                        <?php } ?>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php

                                    foreach ( $rows_dimensiona as $valor) {

                                        if ( isset($valor['Campanha']) ) {

                                            $Absenteismo_Porcentagem = 0;

                                            if ($valor['ABS'] != 0) {
                                                $Absenteismo_Porcentagem = ( $valor['ABS'] * 100) / $valor['Escalado'];
                                                $Absenteismo_Porcentagem = number_format($Absenteismo_Porcentagem, 2, ',', '.');
                                            }

                                            printf('<tr>');
                                          
                                            if ( isset($_GET['CodiCampanha']) ){
                                                printf('<td>' . $valor['Usuario'] . '</td>');
                                                printf('<td>' . $valor['Supervisor'] . '</td>');
                                                printf('<td>' . $valor['Coordenador'] . '</td>');
                                                printf('<td>' . $valor['Escalado'] . '</td>');
                                                printf('<td>' . $valor['ABS'] . '</td>');
                                                print('<td> ' . $Absenteismo_Porcentagem . '% </td>');
                                            }
                                            else{

                                                printf('<td><a href="relatorio_campanha.php?CodiCampanha=' . $valor['CodiCampanha'] . '&Data_Campanha=' . $Data_Campanha . '">' . $valor['Campanha'] . '</a></td>');
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
                    
                    <?php 
                } 

                ?>

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

<!-- bootstrap-daterangepicker -->
<script src="assets/vendors/moment/min/moment.min.js"></script>
<script src="assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

<script>
  $(document).ready(function() {
    var cb = function(start, end, label) {
      console.log(start.toISOString(), end.toISOString(), label);
    };

    var optionSet1 = {
      opens: 'center',
      buttonClasses: ['btn btn-default'],
      locale: {
        applyLabel: 'Selecionar',
        cancelLabel: 'Cancelar',
        format: 'DD-MM-YYYY',
        daysOfWeek: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        firstDay: 1
      }
    };
    $('#reservation').daterangepicker(optionSet1, cb);
    $('#reservation').on('show.daterangepicker', function() {
      console.log("show event fired");
    });
    $('#reservation').on('hide.daterangepicker', function() {
      console.log("hide event fired");
    });
    $('#reservation').on('cancel.daterangepicker', function(ev, picker) {
      console.log("cancel event fired");
    });
  });
</script>
<!-- /bootstrap-daterangepicker -->