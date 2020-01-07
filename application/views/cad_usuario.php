<?php

// Conectando ao Banco
require_once 'assets/includes/conexao.php';

$_SESSION['painel_administrativo'] = true;

if ( !isset($_SESSION['auth']) ){
  $_SESSION['auth'] = false;
}

if ( $_SESSION['auth'] == false ){
  	header('location: ../');
  	exit;
}
else{
    require_once 'assets/includes/header.php';
}


require_once 'assets/includes/menu_esquerdo.php';

require_once 'assets/includes/menu_topo.php';

if ( isset($_POST['CodiUsuario']) ){

	$CodiUsuario = strtoupper(mysqli_real_escape_string($ligacao, $_POST['CodiUsuario']));

	$Usuario = strtoupper(mysqli_real_escape_string($ligacao, $_POST['Usuario']));
	$CodiNivelAcesso = mysqli_real_escape_string($ligacao, $_POST['CodiNivelAcesso']);
	$Login = mysqli_real_escape_string($ligacao, $_POST['Login']);
	$Senha = mysqli_real_escape_string($ligacao, $_POST['Senha']);

    $sql = sprintf("SELECT Usuario, CodiNivelAcesso, Login, Senha, CodiUsuario FROM tbl_usuarios WHERE CodiUsuario='$CodiUsuario' LIMIT 1;");
	$query = $ligacao->query($sql);		
 	$row = mysqli_fetch_array($query);

	$CodiUsuario = $row[4];
	
	if ( !isset($CodiUsuario) ){

	    $sql = "INSERT INTO tbl_usuarios (Usuario, CodiNivelAcesso, Login, Senha) VALUES ('$Usuario', '$CodiNivelAcesso', '$Login', '$Senha')";
	    $insere = $ligacao->query($sql);
	    
	    if ( $CodiNivelAcesso == '6' ){
	        $sql_usuario = "SELECT * FROM tbl_usuarios WHERE CodiUsuario='$CodiUsuario' LIMIT 1;";
	        $query_usuario = $ligacao->query($sql_usuario);
	        
	        if ( $row_usuario = mysqli_fetch_array($query_usuario) ){

	            $CodiSupervisor = $row_usuario[0];

	            $sql_usuario = "INSERT INTO tbl_supervisor (CodiUsuario) VALUES ('$CodiSupervisor');";
	            $insere_usuario = $ligacao->query($sql_usuario);

	        }
	    }
	    
	    if ( $CodiNivelAcesso == '4' ){
	        $sql_usuario = sprintf("SELECT * FROM tbl_usuarios WHERE CodiUsuario='$CodiUsuario' LIMIT 1;");
	        $query_usuario = $ligacao->query($sql_usuario);
	        
	        if ( $row_usuario = mysqli_fetch_array($query_usuario) ){

	            $CodiCoordenador = $row_usuario[0];

	            $sql_usuario = "INSERT INTO tbl_coordenador (CodiUsuario) VALUES ('$CodiCoordenador');";
	            $insere_usuario = $ligacao->query($sql_usuario);

	        }
	    }

		if ( $insere == true ){

		    $_SESSION['TituloMensagem'] = "Sucesso!";
		    $_SESSION['TipoMensagem'] = "green";
		    $_SESSION['Mensagem'] = "Usuário " . $Usuario . " Cadastrado com Sucesso!";

		}
		else{

	        $_SESSION['TituloMensagem'] = "Erro!";
	        $_SESSION['TipoMensagem'] = "red";
	        $_SESSION['Mensagem'] = "Verifique as Informações e tente novamente.";

		}

	}
	else {

		// Dia de Ontem Até amanhã de Hoje
		$DataZona = new DateTimeZone('America/Sao_Paulo');
		$Data = new DateTime('NOW');
		$Data->setTimezone($DataZona);
		$Data = date_format($Data, 'Y-m-d');

		$sql = "INSERT INTO tbl_auditoria (CodiUsuario, DataAcesso, HoraUltimoAcesso, Descricao) VALUES ('$CodiUsuario', '$Data', NOW(), 'Alteração de Usuário')";
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

	        $_SESSION['TituloMensagem'] = "Sucesso!";
	        $_SESSION['TipoMensagem'] = "green";
	        $_SESSION['Mensagem'] = "Usuário " . $Usuario . " Alterado com Sucesso!";

	    }
	    else {

	        $_SESSION['TituloMensagem'] = "Erro!";
	        $_SESSION['TipoMensagem'] = "red";
	        $_SESSION['Mensagem'] = "Verifique as Informações e tente novamente.";

	    }
	}
}

if ( isset($_GET['CodiUsuario']) ) {

	$CodiUsuario = trim(addslashes($_GET['CodiUsuario']));

    $sql = "SELECT U.CodiUsuario, U.Usuario, U.Login, N.NivelAcesso, U.Foto
	FROM tbl_usuarios U
	         JOIN tbl_nivelacesso N on U.CodiNivelAcesso = N.CodiNivelAcesso
	WHERE U.CodiNivelAcesso = N.CodiNivelAcesso
	AND U.CodiUsuario='$CodiUsuario';";
	$query = $ligacao->query($sql);

    while ( $rows_dados_usuario[] = mysqli_fetch_array($query) ){
    	$CodiUsuario = $rows_dados_usuario[0]['CodiUsuario'];
    	$Usuario = $rows_dados_usuario[0]['Usuario'];
    	$Login = $rows_dados_usuario[0]['Login'];
    	$NivelAcesso = $rows_dados_usuario[0]['NivelAcesso'];
    	$Foto = $rows_dados_usuario[0]['Foto'];
 	}

 	if ( !isset($Foto) ){
 		$Foto = "user.png";
 	}

}

$sql_usuario = "SELECT U.CodiUsuario, U.Usuario, U.Login, N.NivelAcesso
FROM tbl_usuarios U
         JOIN tbl_nivelacesso N on U.CodiNivelAcesso = N.CodiNivelAcesso
WHERE U.CodiNivelAcesso = N.CodiNivelAcesso
  AND U.CodiUsuario <> '2'
ORDER BY U.Usuario";
$query_usuario = $ligacao->query($sql_usuario);

$sql_nivelAcesso = "SELECT N.CodiNivelAcesso, N.NivelAcesso
FROM tbl_usuarios U
         JOIN tbl_nivelacesso N on U.CodiNivelAcesso = N.CodiNivelAcesso
WHERE U.CodiNivelAcesso = N.CodiNivelAcesso
  AND U.CodiUsuario <> '2'
GROUP BY N.CodiNivelAcesso";
$query_nivelAcesso = $ligacao->query($sql_nivelAcesso);

mysqli_close($ligacao);

?>

<link href="assets/vendors/bootstrap-fileupload/bootstrap-fileupload.css" rel="stylesheet" type="text/css" />

<section id="main-content">
  	<section class="wrapper">
	    <div class="row">
	      	<div class="col-xs-9 mt">

		        <!--CUSTOM CHART START -->
		        <div class="border-head">
		          <h3>Usuários</h3>
		        </div>

		        <?php


    	// var_dump($rows_dados_usuario); exit();


		        ?>

		        <!-- BASIC FORM ELELEMNTS -->

                <div class="row content-panel mt">
                    <div class="col-xs-12">

			            <div class="panel-heading">
			              <ul class="nav nav-tabs nav-justified">

			                <li class="active">
			                  <a data-toggle="tab" href="#overview">Visualizar Usuários</a>
			                </li>

			                <li>
			                  <a data-toggle="tab" href="#edit"><?php if ( isset($_GET['CodiUsuario']) ) { echo 'Alterar Usuário'; } else { echo 'Cadastrar Usuários'; } ?> </a>
			                </li>

			              </ul>
			            </div><!-- /panel-heading -->
			            
			            <div class="panel-body">
			              	<div class="tab-content">
				                <div id="overview" class="tab-pane active">
				                	
				                	<?php if ( isset($_GET['CodiUsuario']) ) { ?>
				                  	
			                      	<br>
			                      	<br>
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
					                        	<p><img src="../assets/images/<?php echo $Foto; ?>" class="img-circle"></p>
					                      	</div>
					                    </div>
					                    <!-- /col-md-4 -->
				                  	</div>
			                      	<br>
			                      	<br>
				                  	
				                  	<?php } ?>
			                		
			                		<hr>
				                  	
				                  	<div class="row">
					                    <div class="col-md-12 profile-text">
							              	<table class="table table-hover datatable-buttons">
								                <!-- <h4><i class="fa fa-angle-right"></i> Hover Table</h4> -->
								                <thead>
								                  	<tr>
								                    	<th> Nome do Usuário </th>
								                    	<th> Login </th>
								                    	<th> Nível de Acesso </th>
								                  	</tr>
								                </thead>
								                <tbody>

											    	<?php
										    		
											    	while ( $row = mysqli_fetch_array($query_usuario) ) {
											    		echo '<tr>';
											    		echo '<td><a href="cad_usuario.php?CodiUsuario='. $row[0] . '">' . $row['Usuario'] . '</a></td>';
											    		echo '<td>' . $row['Login'] . '</td>';
											    		echo '<td>' . $row['NivelAcesso'] . '</td>';
											    		echo '</tr>';
											    	}
										    		
											    	?>

								                </tbody>
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
				                      <h4 class="mb">Informações Pessoais</h4>
				                      <form role="form" class="form-horizontal" action="cad_usuario.php" method="POST" enctype="multipart/form-data">

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
				                              <input type="hidden" name="CodiUsuario" class="form-control" required placeholder="" value="<?php if ( isset($_GET['CodiUsuario']) ) { echo $CodiUsuario; } ?>" />
				                              <input type="text" name="Usuario" class="form-control" required placeholder="" value="<?php if ( isset($_GET['CodiUsuario']) ) { echo $Usuario; } ?>" />
				                            </div>
				                        </div>

				                        <div class="form-group">
				                          <label class="col-xs-4 control-label">Nível de Acesso</label>
				                          <div class="col-xs-8">
				                            <?php

				                            echo "<select class='select2_NivelAcesso form-control' name='CodiNivelAcesso'>";
				                            echo "<option value=''></option>";

				                            while($row = mysqli_fetch_array($query_nivelAcesso)){

				                              $CodiNivelAcessoC = $row['CodiNivelAcesso']; 
				                              $NivelAcesso = $row['NivelAcesso'];
				                      
				                              if ( $CodiNivelAcessoC == $CodiNivelAcesso and isset($_GET['CodiUsuario']) ){

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
				                            <input type="text" name="Login" class="form-control" required placeholder="" value="<?php if ( isset($_GET['CodiUsuario']) ) { echo $Login; } ?>" />
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
			            </div><!-- /panel-body -->

		          	</div>
		          	<!-- /col-xs-12 -->
		        </div>
		        <!-- /col-xs-12 -->

	      	</div>
	      	<!-- /row -->

	      	<?php require_once 'assets/includes/menu_direito.php' ?>

	    </div>
	    <!-- /row -->
  	</section>
</section>
<!--main content end-->


<?php require_once 'assets/includes/footer.php'; ?>

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

<script type="text/javascript" src="assets/vendors/bootstrap-fileupload/bootstrap-fileupload.js"></script>
