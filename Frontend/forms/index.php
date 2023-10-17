<?php
$title       = "INICIO | SEER";
$needSession = true;
$home        = false;

require_once("../global/header.php");
$tipoUsuario = $_SESSION['idTipoUsuario'];
$nombresUsuario = $_SESSION['nombreUsuario'];
$apellidosUsuario = $_SESSION['apellidoUsuario'];

?>
      <div class="container my-5">
        <div class="row p-4 align-items-center rounded-3 border shadow-lg">
          <div class="col-lg-7 p-3 p-lg-5 pt-lg-3">
            <h1 class="display-4 fw-bold lh-1 text-body-emphasis"><?=$nombresUsuario?> <?=$apellidosUsuario?> te damos la bienvenida al sistema.</h1>
            <br>
            <!-- <p class="lead">SEEER es un sistema de registros de solicitudes, ratificacioones, audiencias, para tener un control de los movimientos que se realizan y asi poder graficarlos y mostrarlos en el sitio web del Centro de Conciliación Laboral del Estado de Michoacán.</p> -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3 btnAltaSolicitante">
              <?php if ($tipoUsuario == 4) { ?>
                <button type="button" class="btn-lg px-4 me-md-2 fw-bold" onclick="abrirPopupAltaSolicitante();"><i class='bx bxs-user-plus'></i> Agregar Solicitante</button>
              <?php } ?>
              <!-- <button type="button" class="btn btn-outline-secondary btn-lg px-4">Default</button> -->
            </div>
          </div>
          <div class="col-lg-4 offset-lg-1 p-0 overflow-hidden imgInicio">
              <img class="rounded-lg-3" src="../images/logoSer.png">
          </div>
        </div>
      </div>

      <!-- <div class="row">
        <div><center> <h1>Movimietos de las sedes CCLMichoacán</h1> </center></div>
        <br><br><br><br>
        <div class="col-lg-4">
          <center><h2>Morelia</h1></center>
          <canvas id="graficaMorelia"></canvas>
        </div>
        <div class="col-lg-4">
          <center><h2>Zamora</h1></center>
          <canvas id="graficaZamora"></canvas>
        </div>
        <div class="col-lg-4">
          <center><h2>Uruapan</h1></center>
          <canvas id="graficaUruapan"></canvas>
        </div>
        <center>
          <div class="col-lg-4">
          <center><h2>Generos</h1></center>
          <canvas id="graficaGenero"></canvas>
        </div>
        </center>
      </div> -->

      <?php
        require_once("../db_functions/db_global.php");
        require_once("../db_functions/db_graficas_movimientos.php");

        $dbConnect = comenzarConexion();

        $solicitudMorelia     = mostrarSolicitudesMorelia($dbConnect);
        $audienciaMorelia     = mostrarAudienciasMorelia($dbConnect);
        $ratificacionMorelia  = mostrarRatificacionesMorelia($dbConnect);

        $solicitudUruapan     = mostrarSolicitudesUruapan($dbConnect);
        $audienciaUruapan     = mostrarAudienciasUruapan($dbConnect);
        $ratificacionUruapan  = mostrarRatificacionesUruapan($dbConnect);

        $solicitudZamora      = mostrarSolicitudesZamora($dbConnect);
        $audienciaZamora      = mostrarAudienciasZamora($dbConnect);
        $ratificacionZamora   = mostrarRatificacionesZamora($dbConnect);

        $hombres              = mostrarGeneroHombres($dbConnect);
        $mujeres              = mostrarGeneroMujeres($dbConnect);

        $ratificaciones       = mostrarTotalMontoRatificaciones($dbConnect);

        // MORELIA =================================================================
        for($i = 0; $i < count($solicitudMorelia); $i++){
          $totalSolicitudMorelia = $solicitudMorelia[$i]["totalSolicitud"];
        }

        for($i = 0; $i < count($audienciaMorelia); $i++){
          $totalAudienciaMorelia = $audienciaMorelia[$i]["totalAudiencia"];
        }

        for($i = 0; $i < count($ratificacionMorelia); $i++){
          $totalRatificacionMorelia = $ratificacionMorelia[$i]["totalRatificacion"];
        }
        // =========================================================================

        // URUAPAN =================================================================
        for($i = 0; $i < count($solicitudUruapan); $i++){
          $totalSolicitudUruapan = $solicitudUruapan[$i]["totalSolicitud"];
        }

        for($i = 0; $i < count($audienciaUruapan); $i++){
          $totalAudienciaUruapan = $audienciaUruapan[$i]["totalAudiencia"];
        }

        for($i = 0; $i < count($ratificacionUruapan); $i++){
          $totalRatificacionUruapan = $ratificacionUruapan[$i]["totalRatificacion"];
        }
        // =========================================================================

        // ZAMORA ==================================================================
        for($i = 0; $i < count($solicitudZamora); $i++){
          $totalSolicitudZamora = $solicitudZamora[$i]["totalSolicitud"];
        }

        for($i = 0; $i < count($audienciaZamora); $i++){
          $totalAudienciaZamora = $audienciaZamora[$i]["totalAudiencia"];
        }

        for($i = 0; $i < count($ratificacionZamora); $i++){
          $totalRatificacionZamora = $ratificacionZamora[$i]["totalRatificacion"];
        }
        // =========================================================================

        // GENERO ==================================================================
        for($i = 0; $i < count($hombres); $i++){
          $totalHombres = $hombres[$i]["totalHombres"];
        }

        for($i = 0; $i < count($mujeres); $i++){
          $totalMujeres = $mujeres[$i]["totalMujeres"];
        }
        // =========================================================================

        // RATIFICACIONES ==========================================================
        for($i = 0; $i < count($ratificaciones); $i++){
          $mesMontoRatificacion = $ratificaciones[$i]["mes"];
          $totalMontoRatificacion = $ratificaciones[$i]["promedio_mensual"];
        }
        // =========================================================================

        cerrarConexion($dbConnect);
        
      ?>
      

      <script>

        // const ctxMorelia                = document.getElementById('graficaMorelia');
        // const ctxZamora                 = document.getElementById('graficaZamora');
        // const ctxUruapan                = document.getElementById('graficaUruapan');
        // const ctxGenero                 = document.getElementById('graficaGenero');
        // const ctxTotalMontoRatificacion = document.getElementById('graficaMontoRatificacion');

        // // MORELIA =================================================================
        // new Chart(ctxMorelia, {
        //   type: 'bar',
        //   data: {
        //     labels: [''],
        //     datasets: [
        //       {
        //         label: 'Solicitudes',
        //         data: [<?=$totalSolicitudMorelia?>],
        //         backgroundColor: ['#d3a929'],
        //         borderWidth: 5
        //       },
        //       {
        //         label: 'Audiencias',
        //         data: [<?=$totalAudienciaMorelia?>],
        //         backgroundColor: ['#809798'],
        //         borderWidth: 5
        //       },
        //       {
        //         label: 'Ratificaciones',
        //         data: [<?=$totalRatificacionMorelia?>],
        //         backgroundColor: ['#476162'],
        //         borderWidth: 5
        //       }
        //     ]
        //   },
        //   options: {
        //     scales: {
        //       y: {
        //         beginAtZero: true
        //       }
        //     }
        //   }
        // });
        // // =========================================================================

        // // ZAMORA ==================================================================
        // new Chart(ctxZamora, {
        //   type: 'bar',
        //   data: {
        //     labels: [''],
        //     datasets: [
        //       {
        //         label: 'Solicitudes',
        //         data: [<?=$totalSolicitudZamora?>],
        //         backgroundColor: ['#6f1c46'],
        //         borderWidth: 5
        //       },
        //       {
        //         label: 'Audiencias',
        //         data: [<?=$totalAudienciaZamora?>],
        //         backgroundColor: ['#512d36'],
        //         borderWidth: 5
        //       },
        //       {
        //         label: 'Ratificaciones',
        //         data: [<?=$totalRatificacionZamora?>],
        //         backgroundColor: ['#f9c3d0'],
        //         borderWidth: 5
        //       }
        //     ]
        //   },
        //   options: {
        //     scales: {
        //       y: {
        //         beginAtZero: true
        //       }
        //     }
        //   }
        // });
        // // =========================================================================

        // // URUAPAN =================================================================
        // new Chart(ctxUruapan, {
        //   type: 'bar',
        //   data: {
        //     labels: [''],
        //     datasets: [
        //       {
        //         label: 'Solicitudes',
        //         data: [<?=$totalSolicitudUruapan?>],
        //         backgroundColor: ['#686667'],
        //         borderWidth: 5
        //       },
        //       {
        //         label: 'Audiencias',
        //         data: [<?=$totalAudienciaUruapan?>],
        //         backgroundColor: ['#d3a929'],
        //         borderWidth: 5
        //       },
        //       {
        //         label: 'Ratificaciones',
        //         data: [<?=$totalRatificacionUruapan?>],
        //         backgroundColor: ['#808798'],
        //         borderWidth: 5
        //       }
        //     ]
        //   },
        //   options: {
        //     scales: {
        //       y: {
        //         beginAtZero: true
        //       }
        //     }
        //   }
        // });
        // // =========================================================================

        // // GENEROS =================================================================
        // new Chart(ctxGenero, {
        //   type: 'bar',
        //   data: {
        //     labels: [''],
        //     datasets: [
        //       {
        //         label: 'Hombres',
        //         data: [<?=$totalHombres?>],
        //         backgroundColor: ['#686667'],
        //         borderWidth: 5
        //       },
        //       {
        //         label: 'Mujeres',
        //         data: [<?=$totalMujeres?>],
        //         backgroundColor: ['#6f1c46'],
        //         borderWidth: 5
        //       }
        //     ]
        //   },
        //   options: {
        //     scales: {
        //       y: {
        //         beginAtZero: true
        //       }
        //     }
        //   }
        // });
        // // =========================================================================
      </script>
<?php
require_once("../global/footer.php");
?>