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
									<h3>Visão da Campanha - <?php echo $rows_dimensiona[0]['Campanha']; ?></h3>
									<hr />
								</div>

								<table class="table table-hover datatable-buttons">
									<thead>
									<tr>
										<th>Nome</th>
										<th>Supervisor</th>
										<th>Coordenador</th>
										<th> Horário </th>
									</tr>
									</thead>

									<tbody>

									<?php

									foreach ( $rows_dimensiona as $valor) {
										printf('<tr>');
										printf('<td>' . $valor['Usuario'] . '</td>');
										printf('<td>' . $valor['Supervisor'] . '</td>');
										printf('<td>' . $valor['Coordenador'] . '</td>');
										printf('<td>' . $valor['Horario'] . '</td>');
										printf('</tr>');
									}

									?>
									</tbody>
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

	</body>
</html>
