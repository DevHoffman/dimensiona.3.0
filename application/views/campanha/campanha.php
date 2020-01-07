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

<!--									<tbody>-->
<!---->
<!--									--><?php
//
////									foreach ( $rows_dimensiona as $valor) {
////
////										if ( !empty($valor['ABS']) ) {
////
////											printf('<tr>');
////
////											$Absenteismo_Porcentagem = 0;
////
////											if ($valor['ABS'] != 0) {
////												$Absenteismo_Porcentagem = ( $valor['ABS'] * 100) / $valor['Escalado'];
////												$Absenteismo_Porcentagem = number_format($Absenteismo_Porcentagem, 2, ',', '.');
////											}
////
////											printf('<td><a href="campanha/detalhes/' . $valor['CodiCampanha'] . '">' . $valor['Campanha'] . '</a></td>');
////											printf('<td>' . $valor['Escalado'] . '</td>');
////											print('<td> ' . $valor['ABS'] . ' </td>');
////											print('<td> ' . $Absenteismo_Porcentagem . '% </td>');
////
////											printf('</tr>');
////										}
////									}
//
//									?>
<!--									</tbody>-->
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
