<?php
session_start();
$usuario = $_SESSION['usuario'];
$idUsuarioOperador = $_SESSION['idUsuario'];
if ($usuario == null || $usuario == '') {
    header('Location: ../');
    die();
}
include 'menu.php';
?>

<br>
    <center>
        <div id="main-container">
            <!-- <button type="button" class="btn btn-success" id="btnNuevo"><img src="../iconos/usuario.png" style="width: 30px;">Usuario Nuevo</button> -->
            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#popupAltaEmpresa"><img src="../iconos/empresas.png" style="width: 30px;">Empresa Nueva</button>
            <br><br><br>
            <div class="table-responsive">
                <table id="example" class="bg-light">
                  <thead>
                    <tr>
                      <th scope="col">IdEmpresa</th>
                      <th scope="col">Nombre</th>
                      <th scope="col"></th>
                      <th scope="col"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                            require_once "../db_funciones/db_global.php";
                            require_once "../db_funciones/administracion/empresas/db_empresa.php";

                            $dbConnect = comenzarConexion();
                            $datos = mostrarEmpresa($dbConnect);
                            for ($i = 0; $i < count($datos); $i++) {
                                echo '<tr>
                                    <td class="idEmpresa">'.$datos[$i]["id_empresa"].'</td>
                                    <td class="nombreEmpresa">'.$datos[$i]["nombre"].'</td>
                                    <input type="hidden" class="clienteEliminado" value="'.$datos[$i]["eliminado"].'">';

                                    if ($datos[$i]["eliminado"] == 0) {
                                        echo'<td><div class="divBotones"><button class="btn btn-success" id="btnActivar" value="'.$datos[$i]["id_empresa"].'"><img src="../iconos/activado.png" style="width: 30px"></button></div></td>';
                                    }
                                    else if($datos[$i]["eliminado"] == 1){
                                        echo'<td><button class="btn btn-danger" id="btnDesactivar" value="'.$datos[$i]["id_empresa"].'"><img src="../iconos/desactivado.png" style="width: 30px"></button></td>';
                                    }

                                    echo '<td><button class="btn btn-warning" id="btnEditarEmpresa" value="'.$datos[$i]["id_empresa"].'"><img src="../iconos/editar.png" style="width: 30px"></button></td>
                                </tr>';
                            }
                            cerrarConexion($dbConnect);
                        ?>
                  </tbody>
                </table>
            </div>
        </div>
    </center>
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#popupEditarEmpresa" id="editarEmpresaPopup" hidden></button>
<script>
//Funcion activar tabla===================================================
$(document).ready(function() {
    $('#example').DataTable();
} );
//========================================================================

//Boton Editar Empresa====================================================
    $(document).on("click", "#btnEditarEmpresa", function(e){
        var idEmpresa = $(this).val();
        $("#editarEmpresaPopup").click();

        var jsonData = {
        "id_empresa": idEmpresa
        }

      $.ajax({
        method: "POST",
        url: "../backend/backend_empresa_mostrar_editar.php",
        data: jsonData,
        success:function(data){
          var resultadoMostrar = JSON.parse(data);
          if(resultadoMostrar["codigo"] == "fallo"){
                var resultados = resultadoMostrar["mensaje"];
              $(".texto-mensaje").text(resultados);
                $("#msj").modal("toggle");
               closeMessageOverlay();
            }
          else if(resultadoMostrar["codigo"] == "exito"){
            var resultados = resultadoMostrar["objetoRespuesta"]["datos"];
            // console.log(resultados);
            var nombre = resultados["nombre"];
                        var rfc = resultados["rfc"];
                        var idCliente = resultados["idCliente"];


                        $("#nombreEmpresaEditar").val(nombre);

            closeMessageOverlay();
          }
        }
      });

        var idUsuarioOper =  <?=$idUsuarioOperador;?>;

        $(document).on("click", "#btnActualizarEmpresa", function(e){

            nombre = $("#nombreEmpresaEditar").val();

        showMessageOverlay("ACTUALIZANDO EMPRESA...", "../iconos/cargando.gif", "150", "150", "sending");

            var jsonData = {
        "idUsuarioOper": idUsuarioOper,
        "idEmpresa": idEmpresa,
        "nombre": nombre
        }

      $.ajax({
        method: "POST",
        url: "../backend/backend_empresa_editar.php",
        data: jsonData,
        success:function(data){
          var resultadoMostrar = JSON.parse(data);
          if(resultadoMostrar["codigo"] == "fallo"){
                var resultados = resultadoMostrar["mensaje"];
            $(".texto-mensaje").text(resultados);
              $("#msj").modal("toggle");
               closeMessageOverlay();
            }
          else if(resultadoMostrar["codigo"] == "exito"){
            var resultados = resultadoMostrar["mensaje"];
            $(".texto-mensaje").text(resultados);
              $("#msjRec").modal("toggle");
            closeMessageOverlay();
          }
        }
      });
        });
    });
    //========================================================================

//Boton Activar Empresa=====================================================
    $(document).on("click", "#btnActivar", function(e){
        var idEmpresa = $(this).val();
        var estatus = 0;
        var idUsuarioOper =  <?=$idUsuarioOperador;?>;

        var jsonData = {
      "idUsuarioOper": idUsuarioOper,
      "idEmpresa": idEmpresa,
      "estatus": estatus
     }
    showMessageOverlay("DESACTIVANDO EMPRESA...", "../iconos/cargando.gif", "150", "150", "sending");
    $.ajax({
      method: "POST",
      url: "../backend/backend_empresa_eliminar.php",
      data: jsonData,
      success:function(data){
        var resultadoMostrar = JSON.parse(data);
        if(resultadoMostrar["codigo"] == "fallo"){
            var resultados = resultadoMostrar["mensaje"];
          $(".texto-mensaje").text(resultados);
            $("#msj").modal("toggle");
           closeMessageOverlay();
        }
        else if(resultadoMostrar["codigo"] == "exito"){
            var resultados = resultadoMostrar["mensaje"];
            $(".texto-mensaje").text(resultados);
          $("#msjRec").modal("toggle");
            closeMessageOverlay();
        }
      }
    });
    });
//========================================================================

//Boton Desactivar Empresa================================================
    $(document).on("click", "#btnDesactivar", function(e){
        var idEmpresa = $(this).val();
        var estatus = 1;

        var idUsuarioOper =  <?=$idUsuarioOperador;?>;

        var jsonData = {
      "idUsuarioOper": idUsuarioOper,
      "idEmpresa": idEmpresa,
      "estatus": estatus
    }

    showMessageOverlay("ACTIVANDO EMPRESA...", "../iconos/cargando.gif", "150", "150", "sending");
    $.ajax({
      method: "POST",
      url: "../backend/backend_empresa_eliminar.php",
      data: jsonData,
      success:function(data){
        var resultadoMostrar = JSON.parse(data);
        if(resultadoMostrar["codigo"] == "fallo"){
            var resultados = resultadoMostrar["mensaje"];
          $(".texto-mensaje").text(resultados);
            $("#msj").modal("toggle");
           closeMessageOverlay();
        }
        else if(resultadoMostrar["codigo"] == "exito"){
            var resultados = resultadoMostrar["mensaje"];
            $(".texto-mensaje").text(resultados);
          $("#msjRec").modal("toggle");
            closeMessageOverlay();
        }
      }
    });
    });
    //========================================================================

    //Boton Registrar Empresa================================================
    $(document).on("click", "#btnGuardarEmpresa", function(){
        var btn = $(this);
        var idUsuarioOper =  <?=$idUsuarioOperador;?>;
        var nombresEmpresa   = $("#nombreEmpresa").val();
      var rfcEmpresa = $("#rfcEmpresa").val();
      var clienteEmpresa   = $("#clienteEmpresa").val();

        var jsonData = {
          "idUsuarioOper": idUsuarioOper,
          "nombre": nombresEmpresa,
          "rfc": rfcEmpresa,
          "idCliente": clienteEmpresa,
      }

        showMessageOverlay("REGISTRANDO USUARIO...", "iconos/cargando.gif", "150", "150", "sending");
        $.ajax({
          method: "POST",
          url: "../backend/backend_empresa_registrar.php",
          data: jsonData,
          success:function(data){
            var resultadoMostrar = JSON.parse(data);
            if(resultadoMostrar["codigo"] == "fallo"){
                var resultados = resultadoMostrar["mensaje"];
              $(".texto-mensaje").text(resultados);
                $("#msj").modal("toggle");
               closeMessageOverlay();
            }
            else if(resultadoMostrar["codigo"] == "exito"){
                $("#nombreEmpresa").val("");
                    $("#rfcEmpresa").val("");
                    $("#clienteEmpresa").val("");
                  var resultados = resultadoMostrar["mensaje"];
                $(".texto-mensaje").text(resultados);
              $("#msjRec").modal("toggle");
              closeMessageOverlay();
            }
          }
        });
     });
    //==========================================================================

// //EVENTO READY==============================================================
//   $(document).ready(function(){
//     var idUsuarioOperGlobal = "";

//   });
//   //=========================================================================
</script>
