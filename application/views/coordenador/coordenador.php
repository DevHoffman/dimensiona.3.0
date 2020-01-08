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

			<div class="col-sm-9 mt">

				<!-- Tabelas -->
				<div class="row content-panel mt">
					<div class="col-xs-12">

						<div class="row centered">
							<h3>Visão por Coordenador</h3>
							<hr />
						</div>

						<table id="table" data-url="<?php echo $datasource ?>" data-update="<?php echo $url_update; ?>" class="table table-hover datatable-buttons">
							<thead>
							<tr>
								<th>Coordenador</th>
								<th>Escalados</th>
								<th>Absenteísmo</th>
								<th>%</th>
								<th></th>
							</tr>
							</thead>
						</table>
					</div><!-- /col-xs-12 -->
				</div><!-- /row -->

			</div>

			<?php echo $sidebar ?>

		</div> <!-- /row -->
	</div>
</div><!--main content end-->

<?php echo $footer ?>

<?php echo $scripts ?>

<script>
	// Datatables
	$(document).ready(function() {
		var handleDataTableButtons = function() {
			if ($(".datatable-buttons").length) {
				$("#table").DataTable({
					// processing: true,
					// serverSide: true,
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
						{ data: 'Coordenador', name: 'Coordenador' },
						{ data: 'Escalado', name: 'Escalado' },
						{ data: 'ABS', name: 'ABS' },
						{ data: 'porcentagem', name: 'porcentagem' },
						{ data: 'CodiCoordenador', name: 'CodiCoordenador', visible: false }
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
								window.location.href = "coordenador/detalhes/" + data.CodiCoordenador;
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

					buttons: [
						{
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
						}
					]
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

</script>

</body>

</html>
