<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php echo $header ?>
    </head>
    <body>

        <?php echo $navbar ?>

        <div id="main-content">
            <div class="wrapper">
                <div class="row">

                    <div class="col-sm-12 mt">

                        <div class="row centered content-panel mt">
                            <h3>Pesquisa por Campanha</h3>
                            <hr />

                            <form id="formCampanha" role="form" class="form-horizontal col-xs-8 col-xs-offset-2" action="" method="POST" enctype="multipart/form-data">

                                <div class="form-group col-xs-10">
                                    <label class="control-label col-xs-4">Pesquise por datas</label>
                                    <div class="col-xs-7">
                                        <div class="input-large" data-date="01/01/2019" data-date-format="mm/dd/yyyy">
                                            <input type="text" name="Data_Campanha" id="reservation" class="form-control" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-xs-2 col-xs-offset-1">
                                    <button type="submit" class="btn btn-theme">Pesquisar</button>
                                </div>
                            </form>
                        </div>

                        <!-- Tabelas -->
                        <div class="row content-panel mt">
                            <div class="col-xs-12">

                                <div class="row centered">
                                    <h3>Visão por Campanha</h3>
                                    <hr />
                                </div>

                                <table id="table" data-url="<?php echo $datasource ?>" data-update="<?php echo $url_update; ?>" class="table table-hover datatable-buttons">
                                    <thead>
                                        <tr>
                                            <th>Campanha</th>
                                            <th>Escalados</th>
                                            <th>Absenteísmo</th>
                                            <th>%</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div><!-- /col-xs-12 -->
                        </div><!-- /row -->

                    </div>

                    <?php // echo $sidebar ?>

                </div> <!-- /row -->
            </div>
        </div><!--main content end-->

        <?php echo $footer ?>

        <?php echo $scripts ?>

        <script>

            var url_update = $('#table').data('update');
            // Datatables
            $(document).ready(function() {
                var handleDataTableButtons = function() {
                    if ($(".datatable-buttons").length) {
                        $("#table").DataTable({
                            // processing: true,
                            // serverSide: true,
                            dom: 'Bfrtip',
                            lengthChange: false,
                            responsive: true,
                            pageLength: 10,
                            ajax: {
                                url: $('#table').data('url'),
                                "dataSrc": "",
                                type: 'POST',
                                dataType: 'json'
                            },
                            columns: [
                                { data: 'Campanha', name: 'Campanha' },
                                { data: 'Escalado', name: 'Escalado' },
                                { data: 'ABS', name: 'ABS' },
                                { data: 'porcentagem', name: 'porcentagem' },
                            ],
                            columnDefs: [
                                { orderable: false, className: 'select-checkbox', targets: 0 }
                            ],
                            select: {
                                style: "multi",
                                selector: "td:first-child"
                            },
                            order: [[ 0, 'asc' ]],
                            rowCallback: function(row, data) {
                                $(row).data('id', data.id).css('cursor', 'pointer');

                                $('td', row).each(function() {
                                    $(this).on('click', function() {
                                        window.location.href = url_update + data.CodiCampanha;
                                    });
                                });
                            },
                            drawCallback: function() {

                                $('[data-toggle="tooltip"]').tooltip();
                            },

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

                            buttons: {
                                buttons: [
                                    {
                                        extend: 'collection',
                                        text: 'Exportar',
                                        buttons: [
                                            { extend: 'copy', text: 'Copiar Linhas' },
                                            { extend: 'excel', text: 'Savar em Excel' },
                                            { extend: 'csv', text: 'Savar em CSV' },
                                            { extend: 'pdf', text: 'Savar em PDF' },
                                            { extend: 'print', text: 'Imprimir' },
                                        ]
                                    }
                                ]
                            }
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
            // Datatables

            $('#formCampanha').validate({

                /* submit via ajax */
                submitHandler: function(form) {

                    var campanha = $("#reservation").val();
                    console.log(campanha);

                    $.ajax({

                        url: `/relatorios/relatorio_campanha/datatables_campanha/${campanha}`,
                        type: "POST",
                        data: $(form).serialize(),
                        contentType: false,
                        processData: false,
                        success: function() {
                            // Message was sent
                            alert("Campanha " + campanha + " pesquisada com sucesso!");
                            $("#table").DataTable().ajax.reload();
                        },
                        error: function(a,b) {
                            // console.log(a);
                            // console.log(b);

                            alert("Erro ao cadastrar a campanha " + campanha + "!");
                        }
                    });
                }
            });
        </script>

        <script>
          $(document).ready(function() {
            var cb = function(start, end, label) {
            };

            var optionSet1 = {
              opens: 'center',
              applyClass: 'btn-theme',
              cancelClass: 'btn-default',
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
            });
            $('#reservation').on('hide.daterangepicker', function() {
            });
            $('#reservation').on('cancel.daterangepicker', function(ev, picker) {
            });
          });
        </script>
        <!-- /bootstrap-daterangepicker -->

    </body>

</html>
