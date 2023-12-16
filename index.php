<?php
    $title       = "LOGIN | EXPLORING";
    $needSession = false;
    $home        = true;

    require_once("Frontend/popups/popup_mensaje.php");
    require_once("Frontend/popups/popup_message_overlay.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <link rel="stylesheet" href="Frontend/css/login.css">
    <link rel="stylesheet" href="Frontend/css/style.css">

    <script src="Frontend/js/jquery-3.6.0.min.js"></script>
    <script src="Frontend/js/jquery-ui.js"></script>
    <script src="Frontend/js/md5.js"></script>
    <script src="Frontend/js/message_overlay.js"></script>
    <script src="Frontend/js/utilidades.js"></script>
    <script src="Frontend/js/validaciones.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script> -->


    <style>
        .swal2-popup .swal2-confirm{
            background-color: #0B5345 !important;
            border-color: #000 !important;
        }

        .swal2-confirm:hover {
            background-color: #154360 !important;
        }
    </style>

</head>

<body>
<section class="h-100 gradient-form" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center">
                  <img src="Frontend/images/G_de_explorin_sin_fondo.png"
                    style="width: 185px;" alt="logo">
                  <h4 class="mt-1 mb-5 pb-1">Login</h4>
                </div>

                <form>
                  <p>Inicia Sesión</p>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="correoUsuarioAlta">Correo Electrónico</label>
                    <input type="email" name="correoUsuarioAlta" id="correoUsuarioAlta" class="form-control" placeholder="Ingresa tu correo electronico" />
                  </div>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="passwordUsuarioAlta">Contraseña</label>
                    <input type="password" name="passwordUsuarioAlta" id="passwordUsuarioAlta" class="form-control" placeholder="Ingresa tu contraseña"/>
                  </div>

                  <div class="text-center pt-1 mb-5 pb-1">
                    <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" id="submit" type="button" onclick="loginUsuario();">Acceder</button>
                    <!-- <a class="text-muted" href="#!">¿Olvidaste tu contraseña?</a> -->
                  </div>

                  <!-- <div class="d-flex align-items-center justify-content-center pb-4">
                    <p class="mb-0 me-2">Crear Cuenta</p>
                    <button type="button" class="btn btn-outline-danger">Registrate</button>
                  </div> -->

                </form>

              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                    <h4 class="mb-4">Explorando Rincones</h4>
                    <p class="small mb-0">Adéntrate en el mundo de la búsqueda y de la diversión, explorando lugares los cuales no conoces. 
                      Exploring hace que tus visitas turísticas sean más divertidas, 
                      descubriendo nuevos lugares y mostrarte un poco de su historia.
                    </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>

</html>
<script>
    // EEVENTO PARA PRESIONAR ENTER DESPUES DE LA CONTRASEÑA =====================
    $("#passwordUsuarioAlta").keypress(function(event) {
          if (event.keyCode === 13) {
              $("#submit").click();
          }
      });
    // ===========================================================================

    // FUNCION LOGIN =============================================================
    function loginUsuario(){
      var correo = $("#correoUsuarioAlta").val();
      var password = $("#passwordUsuarioAlta").val();

      if (correo == "") {
          Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Correo electronico no puede ir vacio',
              // footer: '<a href="">Why do I have this issue?</a>'
          })
          return false;
      }

      var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

      if (!emailPattern.test(correo)) {
          Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Formato del correo electronico incorrecto.',
              // footer: '<a href="">Why do I have this issue?</a>'
          })
          return false;
      }

      if (password == "") {
          Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Contraseña no puede ir vacio',
              // footer: '<a href="">Why do I have this issue?</a>'
          })
          return false;
      }

      json_data = {
        "userEmail": correo,
        "userPassword": calcMD5(password),
        "platformType": "web"
      }

      showMessageOverlay("VALIDANDO USUARIO...", "Frontend/images/cargando.gif", "200", "200", "sending");
      $.ajax({
        method:"POST",
        url:"Backend/backend/usuarios/backend_login.php",
        data:json_data,
        success:function(data){
          var respuesta = JSON.parse(data);
          if(respuesta["codigo"] == "fallo"){
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: respuesta["mensaje"],
                // footer: '<a href="">Why do I have this issue?</a>'
            })
            $("#correoUsuarioAlta").val("");
            $("#passwordUsuarioAlta").val("");
            closeMessageOverlay()
          }
          else if(respuesta["codigo"] == "exito"){
            window.location = ("Frontend/forms/");
            $("#correoUsuarioAlta").val("");
            $("#passwordUsuarioAlta").val("");
            closeMessageOverlay();
          }
        }
      });
    }
    // ===========================================================================
</script>