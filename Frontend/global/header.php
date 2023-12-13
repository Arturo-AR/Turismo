<?php
  require_once("../global/library.php");
  // $tipoUsuario = $_SESSION['idTipoUsuario'];
  // $idUsuario   = $_SESSION['idUsuario'];
  // $idCiudad   = $_SESSION['idCiudad'];
  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Exploring</title>
    <link rel="icon" type="image/x-icon" href="#" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.0.0/uicons-regular-straight/css/uicons-regular-straight.css'>

    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../css/style.css" rel="stylesheet" />

    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/jquery-ui.js"></script>
    <script src="../js/message_overlay.js"></script>
    <script src="../js/utilidades.js"></script>
    <script src="../js/validaciones.js"></script>
    <script src="../js/md5.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Se adjuntan los CDNS para la tabla paginada de resultados -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap5.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap5.min.js"></script>
    <!-- ========================================================= -->

  </head>
  <body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="./">Exploring</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ms-auto">
            <!-- <li class="nav-item"><a class="nav-link" href="#about">Usuarios</a></li> -->
            <!-- <li class="nav-item dropdown">
              <a class="nav-link menu dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Usuarios</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="form_usuarios.php">Usuarios</a></li>
              </ul>
            </li> -->
            <li class="nav-item"><a class="nav-link" href="form_usuarios.php">Usuarios</a></li>
            <li class="nav-item"><a class="nav-link" href="form_lugares.php">Lugares</a></li>
            <li class="nav-item"><a class="nav-link" href="#" onclick="abrirPopupCerrarSesion();">Cerrar sesión</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <div class="cuerpoPrincipal">
    