<!-- Modal -->
<div class="modal fade" id="msjConfirmacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="iconoMensaje"></div>
        <p class="textoMensaje"></p>
      </div>
      <div class="modal-footer">

        <button type="button" class="popupBtnCancelar btnCancelarConfirmacion" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="popupBtnContinuar" onclick="procesarPeticion();">Continuar</button>

      </div>
    </div>
  </div>
</div>
<script>
  // FUNCION ABRIR POPUP ========================================================
  function abrirPopupConfirmarEliminacion(idMovimiento, operacion){

    idPeticionConfirmacion = idMovimiento;
    operacionConfirmacion = operacion;

    // console.log(idPeticionConfirmacion, operacionConfirmacion);

    // Eliminacion de Solicitudes = 0, audiencias = 1, usuarios = 2
    if ((operacionConfirmacion == 0) || (operacionConfirmacion == 1) || (operacionConfirmacion == 2) || (operacionConfirmacion == 4)) {
      $(".iconoMensaje").html("<i class='bx bx-error-circle bx-tada bx-lg' style='color:#ffc300'></i>");
      $(".textoMensaje").html("¿Estas seguro de eliminar?");
    }
    else if (operacionConfirmacion == 3) {
      $(".iconoMensaje").html("<i class='bx bx-error-circle bx-tada bx-lg' style='color:#ffc300'></i>");
      $(".textoMensaje").html("¿Deseas volver habilitar el formulario de la ratificación?");
    }

    $("#msjConfirmacion").modal("toggle");
  }
  // ============================================================================

  // FUNCION ELIMINAR DATOS =====================================================
  function procesarPeticion(){

    if (operacionConfirmacion == 0) {
      var json_data = {
        "idSolicitud":   idPeticionConfirmacion
      }

      showMessageOverlay("CARGANDO...", "../images/cargando.gif", "200", "200", "sending");
      $.ajax({
        method:"POST",
        url:"../backend/backend_eliminar_solicitudes.php",
        data:json_data,
        success:function(data){
          var respuesta = JSON.parse(data);

          if(respuesta["codigo"] == "fallo"){
            $(".btnCancelarConfirmacion").click();
            $(".iconoMensaje").html("<i class='bx bx-x-circle bx-tada bx-lg' style='color:#f90707'></i>");
            $(".textoMensaje").text(respuesta["mensaje"]);
            $("#msj").modal("toggle");
            closeMessageOverlay();
          }
          else if(respuesta["codigo"] == "exito"){
            $(".btnCancelarConfirmacion").click();
            $(".iconoMensaje").html("<i class='bx bx-check-circle bx-tada bx-lg' style='color:#0ea202' ></i>");
            $(".textoMensaje").text(respuesta["mensaje"]);
            $("#msjRec").modal("toggle");
            closeMessageOverlay();
          }
        }
      });
    }
    else if (operacionConfirmacion == 1) {
      var json_data = {
        "idAudiencia":   idPeticionConfirmacion
      }

      showMessageOverlay("CARGANDO...", "../images/cargando.gif", "200", "200", "sending");
      $.ajax({
        method:"POST",
        url:"../backend/backend_eliminar_audiencia.php",
        data:json_data,
        success:function(data){
          var respuesta = JSON.parse(data);

          if(respuesta["codigo"] == "fallo"){
            $(".btnCancelarConfirmacion").click();
            $(".iconoMensaje").html("<i class='bx bx-x-circle bx-tada bx-lg' style='color:#f90707'></i>");
            $(".textoMensaje").text(respuesta["mensaje"]);
            $("#msj").modal("toggle");
            closeMessageOverlay();
          }
          else if(respuesta["codigo"] == "exito"){
            $(".btnCancelarConfirmacion").click();
            $(".iconoMensaje").html("<i class='bx bx-check-circle bx-tada bx-lg' style='color:#0ea202' ></i>");
            $(".textoMensaje").text(respuesta["mensaje"]);
            $("#msjRec").modal("toggle");
            closeMessageOverlay();
          }
        }
      });
    }
    else if (operacionConfirmacion == 2) {
      var json_data = {
        "idUsuario":   idPeticionConfirmacion
      }

      showMessageOverlay("CARGANDO...", "../images/cargando.gif", "200", "200", "sending");
      $.ajax({
        method:"POST",
        url:"../backend/backend_eliminar_usuario.php",
        data:json_data,
        success:function(data){
          var respuesta = JSON.parse(data);

          if(respuesta["codigo"] == "fallo"){
            $(".btnCancelarConfirmacion").click();
            $(".iconoMensaje").html("<i class='bx bx-x-circle bx-tada bx-lg' style='color:#f90707'></i>");
            $(".textoMensaje").text(respuesta["mensaje"]);
            $("#msj").modal("toggle");
            closeMessageOverlay();
          }
          else if(respuesta["codigo"] == "exito"){
            $(".btnCancelarConfirmacion").click();
            $(".iconoMensaje").html("<i class='bx bx-check-circle bx-tada bx-lg' style='color:#0ea202' ></i>");
            $(".textoMensaje").text(respuesta["mensaje"]);
            $("#msjRec").modal("toggle");
            closeMessageOverlay();
          }
        }
      });
    }
    else if (operacionConfirmacion == 3) {
      visualizarRatificacion(idPeticionConfirmacion, 1);
      $(".btnCancelarConfirmacion").click();
    }
    else if (operacionConfirmacion == 4) {
      var json_data = {
        "idRatificacion":   idPeticionConfirmacion
      }

      showMessageOverlay("CARGANDO...", "../images/cargando.gif", "200", "200", "sending");
      $.ajax({
        method:"POST",
        url:"../backend/backend_eliminar_ratificacion.php",
        data:json_data,
        success:function(data){
          var respuesta = JSON.parse(data);

          if(respuesta["codigo"] == "fallo"){
            $(".btnCancelarConfirmacion").click();
            $(".iconoMensaje").html("<i class='bx bx-x-circle bx-tada bx-lg' style='color:#f90707'></i>");
            $(".textoMensaje").text(respuesta["mensaje"]);
            $("#msj").modal("toggle");
            closeMessageOverlay();
          }
          else if(respuesta["codigo"] == "exito"){
            $(".btnCancelarConfirmacion").click();
            $(".iconoMensaje").html("<i class='bx bx-check-circle bx-tada bx-lg' style='color:#0ea202' ></i>");
            $(".textoMensaje").text(respuesta["mensaje"]);
            $("#msjRec").modal("toggle");
            closeMessageOverlay();
          }
        }
      });
    }
  }
  // ============================================================================

  // EVENTO READY ===============================================================
  $(document).ready(function () {
    idPeticionConfirmacion = "";
    operacionConfirmacion = "";
  });
  // ============================================================================
</script>