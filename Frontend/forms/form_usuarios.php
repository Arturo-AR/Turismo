<?php
  // $title       = "INICIO | EXPLORING";
  // $needSession = true;
  // $home        = false;

  require_once("../global/header.php");
  // $tipoUsuario = $_SESSION['idTipoUsuario'];
  // $nombresUsuario = $_SESSION['nombreUsuario'];
  // $apellidosUsuario = $_SESSION['apellidoUsuario'];

?>
<!-- About-->
<section class="about-section text-center" id="about">
        <div class="container px-4 px-lg-5">
          <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8">
              <h2 class="text-white mb-4">Usuarios</h2>
              <!-- <p class="text-white-50">
                  Todos los usuarios registrados,
                <a href="https://startbootstrap.com/theme/grayscale/">the preview page.</a>
                  The theme is open source, and you can use it for any purpose, personal or commercial.
              </p> -->
            </div>
          </div>
          <!-- <img class="img-fluid" src="#" alt="..." /> -->
        </div>
      </section>
      <!-- Projects-->
      <section class="projects-section bg-light" id="projects">
        <div class="container px-4 px-lg-5">
          <!-- Featured Project Row-->
            <div class="row gx-0 mb-4 mb-lg-5 align-items-center">
                <div class="col-xl-8 col-lg-7">
                    <div class="text-center" style="margin-right: 30px;">
                        <div class="table-responsive tablaResultados">
                            <table id="usuarios" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="encabezados">Nombres</th>
                                        <th class="encabezados">Apellidos</th>
                                        <th class="encabezados">Número de teléfono</th>
                                        <th class="encabezados">Edad</th>
                                        <th class="encabezados">Editar</th>
                                        <th class="encabezados">Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        require_once("../../Backend/db_funciones/db_global.php");
                                        require_once("../../Backend/db_funciones/usuarios/db_usuarios.php");

                                        $dbConnect = comenzarConexion();
                                        $datos     = obtenerDatosTodosUsuarios($dbConnect);

                                        for($i = 0; $i < count($datos); $i++){
                                            echo '<tr>
                                                <td class="resultados">'.$datos[$i]["userFirstName"].'</td>
                                                <td class="resultados">'.$datos[$i]["userLastName"].'</td>
                                                <td class="resultados">'.$datos[$i]["userPhoneNumber"].'</td>
                                                <td class="resultados">'.$datos[$i]["userAge"].'</td>
                                                <td class="resultados">
                                                    <div class="operacionesTd">
                                                        <a href="#" onclick="abrirPopupActualizarUsuarios('.$datos[$i]["userID"].')"><i class="fa-solid fa-pencil"></i></a>
                                                    </div>
                                                </td>
                                                <td class="resultados">
                                                    <div class="operacionesTd">
                                                        <a href="#" onclick="abrirPopupConfirmarEliminacion('.$datos[$i]["userID"].')"><i class="fa-solid fa-trash-can"></i></a>
                                                    </div>
                                                </td>
                                            </tr>'; 
                                        }
                                        cerrarConexion($dbConnect);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="featured-text text-center text-lg-left">
                        <h4>Tabla Usuarios Registrados</h4>
                        <p class="text-black-50 mb-0">Aquí podrás editar sus datos, o eliminarlos si ya no los necesitas, como también podras darlos de alta dando click aqui.</p>
                        <br>
                        <i class="fa-solid fa-arrow-down fa-bounce"></i>
                        <br>
                        <div class="col-sm-12 btnAlta">
                            <button type="button" class="col-sm-6" onclick="abrirPopupRegistrarUsuario();"><i class="fa-solid fa-user-plus"></i> Usuario</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<script>
    // EVENTO READY ======================================================================================
    $(document).ready(function () {
        var tablaUsuarios = new DataTable('#usuarios', {language: {url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',},});
    });
    // ===================================================================================================
</script>
<?php
require_once("../global/footer.php");
?>