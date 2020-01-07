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

						<!--CUSTOM CHART START -->
						<div class="border-head">
							<h3>Visão por Campanha</h3>
						</div>

						<div class="custom-bar-chart">

							<?php

							foreach ( $rows_dimensiona as $valor ){

								if ( !empty($valor['ABS']) ){

									$Absenteismo_Porcentagem = 0;

									$Absenteismo_Porcentagem = ( $valor['ABS'] * 100) / $valor['Escalado'];
									$Absenteismo_Porcentagem2 = number_format($Absenteismo_Porcentagem, 2, ',', '.');

									?>

									<div class="bar">
										<div class="title"><?php echo $valor['Campanha']; ?></div>
										<div class="value tooltips" data-original-title="<?php echo $Absenteismo_Porcentagem2 ?>%" data-toggle="tooltip" data-placement="top"><?php echo $Absenteismo_Porcentagem ?>%</div>
									</div>

									<?php

								}
							}

							?>

						</div>
					</div>

					<?php require_once 'assets/includes/menu_direito.php' ?>

				</div> <!-- /row -->
			</div>
		</div><!--main content end-->

		<?php echo $footer ?>

		<?php echo $scripts ?>
	</body>
</html>
