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

<?php if ( !empty($_SESSION['tituloMensagem']) ) { ?>

	<script src="<?php echo base_url('assets/lib/iziToast-master/dist/js/iziToast.min.js') ?>" type="text/javascript"></script>

	<script type="text/javascript">
		$(document).ready(function() {

			iziToast.show({
				title: '<?php echo $_SESSION['tituloMensagem'];unset($_SESSION['tituloMensagem']); ?>',
				image: '<?php echo base_url("assets/images/Foto/{$_SESSION['usuarioFoto']}") ?>',
				// theme: 'dark', // dark, light
				message: '<?php echo $_SESSION['conteudoMensagem'];unset($_SESSION['conteudoMensagem']); ?>',



				// id: null,
				// class: '',
				// titleColor: '',
				// titleSize: '',
				// titleLineHeight: '',
				// messageColor: '',
				// messageSize: '',
				// messageLineHeight: '',
				// backgroundColor: '',
				color: '<?php echo $_SESSION['tipoMensagem'];unset($_SESSION['tipoMensagem']); ?>', // blue, red, green, yellow
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
			// ajax: {
			// 	url: "show_data.php?action=1",
			// 	modal: true
			// },
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
