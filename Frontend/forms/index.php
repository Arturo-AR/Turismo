<?php
  // $title       = "INICIO | EXPLORING";
  // $needSession = true;
  // $home        = false;

  require_once("../global/header.php");
  // $tipoUsuario = $_SESSION['idTipoUsuario'];
  // $nombresUsuario = $_SESSION['nombreUsuario'];
  // $apellidosUsuario = $_SESSION['apellidoUsuario'];

?>
      <!-- Masthead-->
      <header class="masthead">
        <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
          <div class="d-flex justify-content-center">
            <div class="text-center">
              <h1 class="mx-auto my-0 text-uppercase">EXPLORANDO RINCONES</h1>
              <h2 class="text-white-50 mx-auto mt-2 mb-5">Bienvenido explorador, estas listo para las nuevas aventuras.</h2>
              <a class="btn btn-primary" href="#" onclick="abrirPopup();">Iniciar</a>
            </div>
          </div>
        </div>
      </header>
      
<script>
  function abrirPopup(){
    $("#msj").modal("toggle");
  }
</script>
<?php
require_once("../global/footer.php");
?>