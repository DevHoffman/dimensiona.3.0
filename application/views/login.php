
<div id="login-page">
  <div class="container">
    <form class="form-login" action="/administrativo/valida.php" method="POST">
      <h2 class="form-login-heading">Atualize-se</h2>
      <div class="login-wrap">
        <div class="form-group">
          <input type="text" name="Login" class="form-control" placeholder="Usuario" autofocus>
        </div>
        <div class="form-group">
          <input type="password" name="Senha" class="form-control" placeholder="Senha">
        </div>
        <button type="submit" class="btn btn-theme btn-block"><i class="fa fa-lock"></i>&nbsp; Authenticar</button>
        <hr>
        <p>Lorem ipsum dolor sit amet, consectetur</p>
      </div>
      <!-- Modal -->
      <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Forgot Password ?</h4>
            </div>
            <div class="modal-body">
              <p>Enter your e-mail address below to reset your password.</p>
              <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
            </div>
            <div class="modal-footer">
              <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
              <button class="btn btn-theme" type="button">Submit</button>
            </div>
          </div>
        </div>
      </div>
      <!-- modal -->
    </form>
  </div>
</div>
<!-- js placed at the end of the document so the pages load faster -->
<script src="../assets/lib/jquery/jquery.min.js"></script>
<!--BACKSTRETCH-->
<!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
<script type="text/javascript" src="../assets/lib/jquery.backstretch.min.js"></script>
<script>
  $.backstretch("../assets/images/login-bg.jpg", {
    speed: 500
  });
</script>

<?php if ( isset($_SESSION['TituloMensagem']) ) { ?>

<script src="../assets/lib/iziToast-master/dist/js/iziToast.min.js" type="text/javascript"></script>

<script type="text/javascript">
  $(document).ready(function() {

    iziToast.show({
      title: '<?php echo $_SESSION['TituloMensagem'];unset($_SESSION['TituloMensagem']); ?>',
      image: '../assets/images/ui-sam.jpg',
      message: '<?php echo $_SESSION['Mensagem'];unset($_SESSION['Mensagem']); ?>',
      color: '<?php echo $_SESSION['TipoMensagem'];unset($_SESSION['TipoMensagem']); ?>', // blue, red, green, yellow
      iconUrl: null,
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
      targetFirst: true,
      timeout: 5000,
      rtl: false,
      animateInside: true,
      drag: true,
      pauseOnHover: true,
      progressBar: true,
      progressBarEasing: 'linear',
      overlay: false,
      overlayClose: false,
      overlayColor: 'rgba(0, 0, 0, 0.6)',
      transitionInMobile: 'fadeInUp',
      transitionOutMobile: 'fadeOutDown',
      timeout: 10000,
      resetOnHover: true,
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