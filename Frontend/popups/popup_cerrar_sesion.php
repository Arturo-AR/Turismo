<!-- Modal -->
<div class="modal fade" id="msjCerrarSesion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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

        <button type="button" class="popupBtnCancelar btnCancelarSolicitud" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="popupBtnContinuar" onclick="cerrarSesion();">Continuar</button>

      </div>
    </div>
  </div>
</div>
<script>
  // FUNCION ABRIR POPUP ========================================================
  function abrirPopupCerrarSesion(){

    $(".iconoMensaje").html("<i class='bx bx-error-circle bx-tada bx-lg' style='color:#ffc300'></i>");
    $(".textoMensaje").html("¿Deseas cerrar sesión?");

    $("#msjCerrarSesion").modal("toggle");
  }
  // ============================================================================

  // FUNCION CERRAR SESION ======================================================
  function cerrarSesion(){
    window.location = ("../");
  }
  // ============================================================================
</script>