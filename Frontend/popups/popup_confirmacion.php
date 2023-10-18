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
  // // FUNCION ABRIR POPUP ========================================================
  // function abrirPopupConfirmarEliminacion(idMovimiento, operacion){
  //   $("#msjConfirmacion").modal("toggle");
  // }

  // // EVENTO READY ===============================================================
  // $(document).ready(function () {
  // });
  // // ============================================================================
</script>