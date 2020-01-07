<?php 
  
//Incluindo a conexão com banco de dados
require_once 'assets/includes/conexao.php';

$_SESSION['painel_administrativo'] = true;

if ( !isset($_SESSION['auth']) ){
  $_SESSION['auth'] = false;
}

if ( $_SESSION['auth'] == false ){
    require_once '../assets/includes/header.php';
    require_once '../administrativo/login.php';
    exit;
}
else{
    require_once 'assets/includes/header.php';
}


require_once 'assets/includes/menu_esquerdo.php';

require_once 'assets/includes/menu_topo.php';

$CodiUsuario = $_SESSION['usuarioId'];

if ( isset($_POST['Usuario']) ){

  $Usuario = strtoupper(mysqli_real_escape_string($ligacao, $_POST['Usuario']));
  $CodiNivelAcesso = mysqli_real_escape_string($ligacao, $_POST['CodiNivelAcesso']);
  $Login = mysqli_real_escape_string($ligacao, $_POST['Login']);
  $Senha = mysqli_real_escape_string($ligacao, $_POST['Senha']);

  $sql = "INSERT INTO tbl_auditoria (CodiUsuario, DataAcesso, HoraUltimoAcesso, Descricao) VALUES ('$CodiUsuario', NOW(), NOW(), 'Alteração de Perfil')";
  $ligacao->query($sql);

  if ( $Senha != '' ){

    $Senha = hash('sha512', $Senha);

    $sql = "UPDATE tbl_usuarios SET Usuario='$Usuario', CodiNivelAcesso='$CodiNivelAcesso', Login='$Login', Senha='$Senha' WHERE CodiUsuario='$CodiUsuario'";
    $altera = $ligacao->query($sql);

  }
  else{

      $sql = "UPDATE tbl_usuarios SET Usuario='$Usuario', CodiNivelAcesso='$CodiNivelAcesso', Login='$Login' WHERE CodiUsuario='$CodiUsuario'";
      $altera = $ligacao->query($sql);

  }

  if ($altera == true){
    $_SESSION['TituloMensagem'] = "Usuário " . $Usuario . " Alterado!";
    $_SESSION['TipoMensagem'] = "success";
    $_SESSION['Mensagem'] = "Usuário " . $Usuario . " Alterado com Sucesso!";
  }
  else {
    $_SESSION['TituloMensagem'] = "Informações Insuficientes!";
    $_SESSION['TipoMensagem'] = "error";
    $_SESSION['Mensagem'] = "Verifique as Informações e tente novamente.";
  }

}
                            
$query_nivelAcesso = "SELECT U.CodiNivelAcesso, N.NivelAcesso FROM tbl_usuarios U, tbl_nivelacesso N WHERE U.CodiNivelAcesso=N.CodiNivelAcesso GROUP BY N.NivelAcesso";
$query_nivelAcesso = $ligacao->query($query_nivelAcesso);

mysqli_close($ligacao);

?>

<link href="../assets/lib/bootstrap-fileupload/bootstrap-fileupload.css" rel="stylesheet" type="text/css" />

<!-- Select2 -->
<link href="../assets/lib/select2/dist/css/select2.min.css" rel="stylesheet">
<!-- / Select2 -->

<section id="main-content">
  <section class="wrapper">
    <div class="row">
      <div class="col-xs-9 mt">

        <!--CUSTOM CHART START -->
        <div class="border-head">
          <h3>Perfil</h3>
        </div>

        <!-- BASIC FORM ELELEMNTS -->

        <div class="row content-panel mt">
          <div class="col-xs-12">
            <div class="panel-heading">
              <ul class="nav nav-tabs nav-justified">

                <li class="active">
                  <a data-toggle="tab" href="#overview">Visualizar Perfil</a>
                </li>

                <li>
                  <a data-toggle="tab" href="#edit">Editar Perfil</a>
                </li>

              </ul>
            </div>
            <!-- /panel-heading -->
            <div class="panel-body">
              <div class="tab-content">
                <div id="overview" class="tab-pane active">
                  <div class="row">
                    <div class="right-divider col-md-7 col-md-offset-1 profile-text">
                      <div class="row centered">
                        <h3><?php echo $Usuario; ?></h3>
                        <h6><?php echo $NivelAcesso; ?></h6>
                      </div>
                      <br>
                      <h5 class="no-margin">Login: <?php echo $Login; ?></h5>
                      <br>
                      <h5 class="no-margin">Nível de Acesso: <?php echo $NivelAcesso; ?></h5>
                      <br>
                      <br>
                    </div>

                    <!-- /col-md-4 -->
                    <div class="col-md-4 centered">
                      <div class="profile-pic">
                        <p><img src="../assets/images/ui-sam.jpg" class="img-circle"></p>
                      </div>
                    </div>
                    <!-- /col-md-4 -->
                  </div>
                  <!-- /OVERVIEW -->
                </div>

                <!-- /tab-pane -->
                <div id="edit" class="tab-pane">
                  <div class="row">
                    <div class="col-xs-8 col-xs-offset-2 detailed">
                      <h4 class="mb">Informações Pessoais</h4>
                      <form role="form" class="form-horizontal" action="perfil.php" method="POST" enctype="multipart/form-data">

                        <div class="form-group last">
                          <label class="control-label col-xs-4">Foto de Perfil</label>
                          <div class="col-xs-8">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                              <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=Sem+Imagem" alt="" />
                              </div>
                              <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                              <div>
                                <span class="btn btn-theme02 btn-file">
                                  <span class="fileupload-new"><i class="fa fa-paperclip"></i> Selecione o Arquivo </span>
                                <span class="fileupload-exists"><i class="fa fa-undo"></i>&nbsp;&nbsp; Tentar Novamente</span>
                                <input type="file" class="default" />
                                </span>
                                <a href="perfil.php" class="btn btn-theme04 fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i>&nbsp;&nbsp; Cancelar</a>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-4 control-label">Nome Completo</label>
                            <div class="col-xs-8">
                              <input type="text" name="Usuario" class="form-control" required placeholder="" value="<?php echo $Usuario; ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                          <label class="col-xs-4 control-label">Nível de Acesso</label>
                          <div class="col-xs-8">
                            <?php

                            echo "<select class='select2_NivelAcesso form-control' name='CodiNivelAcesso'>";
                            echo "<option value=''></option>";

                            while($row = mysqli_fetch_array($query_nivelAcesso)){
                              $CodiNivelAcessoC = $row[0]; 
                              $NivelAcesso = $row[1];
                      
                              if ( $CodiNivelAcessoC == $CodiNivelAcesso ){

                                echo "<option value='$CodiNivelAcessoC' selected>$NivelAcesso</option>";
                              
                              }
                              else{
                                  echo "<option value='$CodiNivelAcesso'>$NivelAcesso</option>";
                              }
                            }

                            echo "</select>";

                            ?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-xs-4 control-label">Login</label>
                          <div class="col-xs-8">
                            <input type="text" name="Login" class="form-control" required placeholder="" value="<?php echo $Login; ?>" />
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-xs-4 control-label">Senha</label>
                          <div class="col-xs-8">
                            <input type="password" name="Senha" class="form-control" placeholder="" value="" />
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-xs-9">
                            <button class="btn btn-default" type="reset">Cancelar</button>
                          </div>
                          <div class="col-xs-3">
                            <button class="btn btn-theme centered" type="submit"><i class="fa fa-pencil"></i>&nbsp;&nbsp; Alterar Dados</button>
                          </div>
                        </div>

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

      <!-- /col-xs-9 END SECTION MIDDLE -->

      <?php require_once '../assets/includes/menu_direito.php' ?>
          
    </div>
    <!-- /row -->
  </section>
</section>
<!--main content end-->

<style type="text/css">
  .select2-container{
    width: 100% !important;
  }

  .select2-container--default .select2-selection--single .select2-selection__rendered{
    line-height: 35px;
  }

  .select2-container .select2-selection--single{
    height: 35px;
  }
</style>

<?php require_once 'assets/includes/footer.php'; ?>

<!-- Select2 -->
<script src="../assets/lib/select2/dist/js/select2.full.min.js"></script>
<!-- / Select2 -->
    
<!-- Select2 -->
<script>
    $(document).ready(function() {

        $(".select2_NivelAcesso").select2({
            placeholder: "Selecione o Nível de Acesso",
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

<script type="text/javascript" src="lib/bootstrap-fileupload/bootstrap-fileupload.js"></script>
