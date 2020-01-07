		
		</section>
		<!-- js placed at the end of the document so the pages load faster -->
		<script src="assets/lib/jquery/jquery.min.js"></script>

		<script src="assets/lib/bootstrap/js/bootstrap.min.js"></script>

		<script src="assets/lib/jquery.dcjqaccordion.2.7.js" class="include" type="text/javascript"></script>
		<script src="assets/lib/jquery.scrollTo.min.js"></script>
		<script src="assets/lib/jquery.nicescroll.js" type="text/javascript"></script>
		<script src="assets/lib/jquery.sparkline.js"></script>
		<!--common script for all pages-->
		<script src="assets/lib/common-scripts.js"></script>
		<script src="assets/lib/gritter/js/jquery.gritter.js" type="text/javascript"></script>
		<script src="assets/lib/gritter-conf.js"type="text/javascript"></script>
		<!--script for this page-->
		<script src="assets/lib/sparkline-chart.js"></script>
		<script src="assets/lib/zabuto_calendar.js"></script>

		<!-- Datatables -->
		<script src="assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
		<script src="assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
		<script src="assets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
		<script src="assets/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
		<script src="assets/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
		<script src="assets/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
		<script src="assets/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
		<script src="assets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
		<script src="assets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
		<script src="assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
		<script src="assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
		<!-- <script src="assets/vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script> -->
		<script src="assets/vendors/jszip/dist/jszip.min.js"></script>
		<script src="assets/vendors/pdfmake/build/pdfmake.min.js"></script>
		<script src="assets/vendors/pdfmake/build/vfs_fonts.js"></script>
		<!-- / Datatables -->

		<!-- Select2 -->
		<script src="assets/vendors/select2/dist/js/select2.full.min.js"></script>
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


		<?php if ( isset($_SESSION['TituloMensagem']) ) { ?>

		<script src="assets/lib/iziToast-master/dist/js/iziToast.min.js" type="text/javascript"></script>

		<script type="text/javascript">
		  	$(document).ready(function() {

			    iziToast.show({
				    title: '<?php echo $_SESSION['TituloMensagem'];unset($_SESSION['TituloMensagem']); ?>',
    				image: '../assets/images/Foto/<?php if ( isset($_SESSION['usuarioFoto']) ){ echo $_SESSION['usuarioFoto']; } else { echo 'user.png'; } ?>',
    				// theme: 'dark', // dark, light
				    message: '<?php echo $_SESSION['Mensagem'];unset($_SESSION['Mensagem']); ?>',



				    // id: null, 
				    // class: '',
				    // titleColor: '',
				    // titleSize: '',
				    // titleLineHeight: '',
				    // messageColor: '',
				    // messageSize: '',
				    // messageLineHeight: '',
				    // backgroundColor: '',
        			color: '<?php echo $_SESSION['TipoMensagem'];unset($_SESSION['TipoMensagem']); ?>', // blue, red, green, yellow
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
		
	</body>

</html>
