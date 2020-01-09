<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<?php echo $header ?>
	</head>
	<body>

		<?php echo $navbar ?>

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
													<table id="table" data-url="<?php echo $datasource ?>" data-update="<?php echo $url_update ?>" data-delete="<?php echo $url_delete ?>" class="table table-hover datatable-buttons">
														<hr>
														<thead>
															<tr>
																<th>Nome da Campanha</th>
																<th></th>
															</tr>
														</thead>
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
													<form id="cadastro_campanha" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data"  data-cadastrar="<?php echo $url_cadastrar ?>">
														<br />
														<div class="form-group">
															<label class="col-xs-4 control-label">Nome da Campanha</label>
															<div class="col-xs-8">
																<input type="text" id="Campanha" name="Campanha" class="form-control" required placeholder="" value="" />
															</div>
														</div>
														<br />
														<br />

														<div class="form-group">
															<div class="col-xs-9">
																<button class="btn btn-default" type="reset"><i class="fa fa-trash"></i>&nbsp;&nbsp; Limpar</button>
															</div>
															<div class="col-xs-3">
																<button class="btn btn-theme centered submit-loader" type="submit"><i class="fa fa-pencil"></i>&nbsp;&nbsp; Cadastrar </button>
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

					<?php echo $sidebar ?>

				</div>
				<!-- /row -->
			</section>
		</section>
		<!--main content end-->

		<?php echo $footer ?>

		<?php echo $scripts ?>

		<script  type="text/javascript">
		// Datatables
		var url_delete = $('#table').data('delete');
		var url_cadastrar = $('#cadastro_campanha').data('cadastrar');

		$(document).ready(function() {
			var handleDataTableButtons = function() {
				if ($(".datatable-buttons").length) {
					var table = $("#table").DataTable({
						// processing: true,
						// serverSide: true,
						lengthChange: false,
						responsive: true,
						pageLength: 10,
						ajax: {
							url: $('#table').data('url'),
							type: 'POST',
							dataType: 'json'
						},
						columns: [
							{ data: 'Campanha', name: 'Campanha' },
							{ data: 'CodiCampanha', name: 'CodiCampanha' },
						],
						order: [[ 0, 'asc' ]],
						rowCallback: function(row, data) {
							$(row).css('cursor', 'pointer');
							var btnDelete = $(`<span href="${url_delete}${data.CodiCampanha}" class="text-danger"><i class="fa fa-trash"></i></span>`);
							$('td:eq(1)', row).html(btnDelete);
							var campanha = `${data.Campanha}`;

							$(btnDelete).click(function() {
								$.ajax({
									type: 'post',
									url: btnDelete.attr('href'),
									dataType: 'json',
									beforeSend: function() {
										confirm(`Deseja excluir a campanha ${data.Campanha}?`);
									},
									error: function() {
										alert(`Erro ao excluir a campanha ${data.Campanha}!`);
									},
									success: function(msg) {
										alert(`Campanha ${data.Campanha} excluída com sucesso!`);
										table.ajax.reload();
									}
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
			/* local validation */
			$('#cadastro_campanha').validate({

				/* submit via ajax */
				submitHandler: function(form) {

					var campanha = $("#Campanha").val();

					$.ajax({

						url: `${url_cadastrar}${campanha}`,
						type: "POST",
						data: $(form).serialize(),
						contentType: false,
						processData: false,
						success: function() {
							// Message was sent
							alert("Campanha " + campanha + " cadastrada com sucesso!");
							$("#table").DataTable().ajax.reload();
						},
						error: function(a,b) {
							console.log(a);
							console.log(b);
							// alert("Erro ao cadastrar a campanha " + campanha + "!");
						}
					});
				}

			});
		});
		// Datatables
	</script>

	</body>

</html>
