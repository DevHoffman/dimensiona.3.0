<!-- js placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url('assets/lib/jquery/jquery.min.js') ?>"></script>

<script src="<?php echo base_url('assets/lib/bootstrap/js/bootstrap.min.js') ?>"></script>

<script src="<?php echo base_url('assets/lib/jquery.dcjqaccordion.2.7.js') ?>" class="include" type="text/javascript"></script>
<script src="<?php echo base_url('assets/lib/jquery.scrollTo.min.js') ?>"></script>
<script src="<?php echo base_url('assets/lib/jquery.nicescroll.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/lib/jquery.sparkline.js') ?>"></script>
<!--common script for all pages-->
<script src="<?php echo base_url('assets/lib/common-scripts.js') ?>"></script>
<script src="<?php echo base_url('assets/lib/gritter/js/jquery.gritter.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/lib/gritter-conf.js') ?>" type="text/javascript"></script>
<!--script for this page-->
<script src="<?php echo base_url('assets/lib/sparkline-chart.js') ?>"></script>
<script src="<?php echo base_url('assets/lib/zabuto_calendar.js') ?>"></script>

<!-- Select2 -->
<script src="<?php echo base_url('assets/vendors/select2/dist/js/select2.full.min.js') ?>"></script>
<!-- / Select2 -->

<!-- Select2 -->
<script>
	$(document).ready(function() {

		$(".select2_NivelAcesso").select2({
			placeholder: "Selecione o Nível de Acesso",
			allowClear: true
		});

		$(".select2_Usuarios").select2({
			placeholder: "Selecione o Usuário",
			allowClear: true
		});

		$(".select2_group").select2({});
		$(".select2_multiple").select2({
			maximumSelectionLength: 4,
			placeholder: "With Max Selection limit 4",
			allowClear: true
		});
	});
</script>
<!-- /Select2 -->


<?php if ( !empty($tituloMensagem) ) { ?>

	<script src="<?php echo base_url('assets/lib/iziToast-master/dist/js/iziToast.min.js') ?>" type="text/javascript"></script>

	<script type="text/javascript">
		$(document).ready(function() {

			iziToast.show({
				title: '<?php echo $tituloMensagem;unset($tituloMensagem); ?>',
				image: '<?php echo base_url("assets/images/Foto/{$usuarioFoto}") ?>',
				// theme: 'dark', // dark, light
				message: '<?php echo $mensagem;unset($mensagem); ?>',



				// id: null,
				// class: '',
				// titleColor: '',
				// titleSize: '',
				// titleLineHeight: '',
				// messageColor: '',
				// messageSize: '',
				// messageLineHeight: '',
				// backgroundColor: '',
				color: '<?php echo $tipoMensagem;unset($tipoMensagem); ?>', // blue, red, green, yellow
				// iconText: '',
				// iconColor: '',
				iconUrl: null,
				// image: '',
				imageWidth: 50,
				maxWidth: null,
				zindex: null,
				layout: 1,
				balloon: false,
				close: true,
				closeOnEscape: false,
				closeOnClick: false,
				displayMode: 0, // once, replace
				position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
				// target: '',
				targetFirst: true,
				timeout: 5000,
				rtl: false,
				animateInside: true,
				drag: true,
				pauseOnHover: true,
				progressBar: true,
				// progressBarColor: '',
				progressBarEasing: 'linear',
				overlay: false,
				overlayClose: false,
				overlayColor: 'rgba(0, 0, 0, 0.6)',
				transitionInMobile: 'fadeInUp',
				transitionOutMobile: 'fadeOutDown',
				// buttons: {},
				// inputs: {},
				// onOpened: function () {},
				// onClosed: function () {}
				timeout: 10000,
				// resetOnHover: true,
				icon: 'material-icons',
				transitionIn: 'flipInX',
				transitionOut: 'flipOutX',
				onOpening: function(){
					console.log('callback abriu!');
				},
				onClosing: function(){
					console.log("callback fechou!");
				},

			});

		});
	</script>

<?php } ?>

<script type="application/javascript">
	$(document).ready(function() {
		$("#date-popover").popover({
			html: true,
			trigger: "manual"
		});
		$("#date-popover").hide();
		$("#date-popover").click(function(e) {
			$(this).hide();
		});

		$("#my-calendar").zabuto_calendar({
			action: function() {
				return myDateFunction(this.id, false);
			},
			action_nav: function() {
				return myNavFunction(this.id);
			},
			ajax: {
				url: "show_data.php?action=1",
				modal: true
			},
			legend: [{
				type: "text",
				label: "Special event",
				badge: "00"
			},
			{
				type: "block",
				label: "Regular event",
			}]
		});
	});

	function myNavFunction(id) {
		$("#date-popover").hide();
		var nav = $("#" + id).data("navigation");
		var to = $("#" + id).data("to");
		console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
	}
</script>

<?php

if ( !empty($scripts)) {
	foreach ($scripts as $script) {
		echo "<script src='{$script}'></script>";
	}
}
?>

<!-- Datatables -->
<script src="<?php echo base_url('assets/vendors/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendors/datatables.net-buttons/js/buttons.flash.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendors/datatables.net-buttons/js/buttons.html5.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendors/datatables.net-buttons/js/buttons.print.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') ?>"></script>
<!-- <script src="assets/vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script> -->
<script src="<?php echo base_url('assets/vendors/jszip/dist/jszip.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendors/pdfmake/build/pdfmake.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendors/pdfmake/build/vfs_fonts.js') ?>"></script>
<!-- / Datatables -->

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
