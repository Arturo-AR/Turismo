<!-- Modal -->
<div class="modal fade" id="msjRec" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
        <button type="button" class="popupBtn" data-bs-dismiss="modal" onclick="recargarPagina();">Aceptar</button>
      </div>
    </div>
  </div>
</div>
<script>
  // FUNCION PARA RECARGAR LA PAGINA ======================================================
  function recargarPagina(){
    location.reload();
  }
  // ======================================================================================
</script>