<?php

$CodiUsuario = $_SESSION['usuarioId'];

$sql = sprintf("SELECT Usuario, Login, Senha, U.CodiNivelAcesso, NivelAcesso FROM tbl_usuarios U, tbl_nivelacesso N WHERE U.CodiNivelAcesso=N.CodiNivelAcesso AND U.CodiUsuario='$CodiUsuario';");
$query = $ligacao->query($sql);

if ( $row = mysqli_fetch_array($query) ) {
  $Usuario = $row['Usuario'];
  $Login = $row['Login'];
  $CodiNivelAcesso = $row['CodiNivelAcesso'];
  $NivelAcesso = $row['NivelAcesso'];
}

$Nome = explode(" ",$Usuario);

// if ( isset($Nome[1]) ){
//   $Nome = $Nome[0] . ' ' . $Nome[1];
// }
// else{
//   $Nome = $Nome[0];
// }

$Nome = 'Olá, ' . $Nome[0];

?>
<!--sidebar start-->
<aside>
  <div id="sidebar" class="nav-collapse ">
    <!-- sidebar menu start-->
    <ul class="sidebar-menu" id="nav-accordion">
      <p class="centered"><a href="../Dimensiona/perfil.php"><img src="/assets/images/ui-sam.jpg" class="img-circle" width="80"></a></p>
      <h5 class="centered"><?php echo $Nome; ?></h5>

      <?php 

      if ( $_SESSION['usuarioNivelAcesso'] == 1 ){ 

        ?>

        <li class="sub-menu">
          <a href="javascript:;">
            <i class="fa fa-search"></i>
            <span> Consulta </span>
          </a>
          <ul class="sub">
            <li><a href="cad_campanha.php"> Campanha </a></li>
            <li><a href="cad_usuario.php"> Usuários </a></li>
            <li><a href="cad_auditoria.php"> Presença </a></li>
          </ul>
        </li>

        <?php 
      } 

      ?>

      <li class="sub-menu">
        <a href="javascript:;">
          <i class="fa fa-bar-chart"></i>
          <span> Tempo Real </span>
        </a>
        <ul class="sub">
          <li><a href="campanha.php"> Campanha </a></li>
          <li><a href="coordenador.php"> Coordenador </a></li>
          <li><a href="supervisor.php"> Supervisor </a></li>
          <li><a href="operador.php"> Operador </a></li>
        </ul>
      </li>

      <li class="sub-menu">
        <a href="javascript:;">
          <i class="fa fa-search"></i>
          <span> Relatório </span>
        </a>
        <ul class="sub">
          <li><a href="relatorio_campanha.php"> Campanha </a></li>
          <li><a href="relatorio_coordenador.php"> Coordenador </a></li>
          <li><a href="relatorio_supervisor.php"> Supervisor </a></li>
          <li><a href="relatorio_operador_sintetico.php"> Operador Sintético </a></li>
          <li><a href="relatorio_operador_analitico.php"> Operador Analítico </a></li>
        </ul>
      </li>
    
      <li>
        <a href="/Dimensiona/escala.php">
          <i class="fa fa-calendar"></i>
          <span> Escala </span>
        </a>
      </li>

      <li>
        <a href="/Dimensiona/desenho_global.php">
          <i class="fa fa-sitemap"></i>
          <span> Desenho Global </span>
        </a>
      </li>

    </ul>
    <!-- sidebar menu end-->
  </div>
</aside>
<!--sidebar end-->