<!-- Modal -->
<div class="modal fade" id="cambiarContrasenia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">CAMBIA TU CONTRASEÑA</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- <div class="iconoMensaje">
                    <i class='bx bx-key bx-lg' undefined ></i><i class='bx bx-lock-open-alt bx-lg' ></i>
                </div> -->
                <br>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class='bx bxs-lock'></i></span>
                                <input type="password" class="form-control" placeholder="Contraseña Nueva" aria-label="Contraseña Nueva" aria-describedby="basic-addon1" name="contrasenaUsuarioCambiar" id="contrasenaUsuarioCambiar">
                                <span class="input-group-text" id="basic-addon1" onclick="ocultarMostrarContrasenaCambiar();" style="cursor: pointer;"><i class='bx bx-hide icon1'></i></span>
                            </div>
                        </div>
                        <div class="col-md-6 ms-auto">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class='bx bxs-lock'></i></span>
                                <input type="password" class="form-control" placeholder="Confirmar Contraseña" aria-label="Confirmar Contraseña" aria-describedby="basic-addon1" name="contrasenaUsuarioConfirmar" id="contrasenaUsuarioConfirmar">
                                <span class="input-group-text" id="basic-addon1" onclick="ocultarMostrarContrasenaConfirmacion();" style="cursor: pointer;"><i class='bx bx-hide icon2'></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="popupBtnCancelar btnContrasenaCambio" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="popupBtnContinuar" onclick="cambiarConrasena();">Continuar</button>
            </div>
        </div>
    </div>
</div>
<script>
// FUNCION ABRIR POPUP ========================================================
function abrirPopupCambiarContrasenia(idUsuarioSesion){

    // $(".iconoMensaje").html("<i class='bx bx-error-circle bx-tada bx-lg' style='color:#ffc300'></i>");

    // $(".textoMensaje").html("¿Estas seguro de realizar esta acción?");

    idUsuarioSesionGlobal = idUsuarioSesion;

    $("#cambiarContrasenia").modal("toggle");
}
// ============================================================================

// FUNCION OULTAR Y MOSTRAR CONTRASEÑA ========================================
function ocultarMostrarContrasenaCambiar(){
    var cambio = document.getElementById("contrasenaUsuarioCambiar");
    if(cambio.type == "password"){
        cambio.type = "text";
        $('.icon1').removeClass('bx bx-hide').addClass('bx bx-show');
    }else{
        cambio.type = "password";
        $('.icon1').removeClass('bx bx-show').addClass('bx bx-hide');
    }
}
// ============================================================================

// FUNCION OULTAR Y MOSTRAR CONTRASEÑA ========================================
function ocultarMostrarContrasenaConfirmacion(){
    var cambio = document.getElementById("contrasenaUsuarioConfirmar");
    if(cambio.type == "password"){
        cambio.type = "text";
        $('.icon2').removeClass('bx bx-hide').addClass('bx bx-show');
    }else{
        cambio.type = "password";
        $('.icon2').removeClass('bx bx-show').addClass('bx bx-hide');
    }
}
// ============================================================================

// FUNCION DAR DE ALTA USUARIO ================================================
function cambiarConrasena(){

    var contrasenaNueva    = $("#contrasenaUsuarioCambiar").val();
    var contrasenaConfirmada  = $("#contrasenaUsuarioConfirmar").val();

    if (contrasenaNueva == "") {
        $(".iconoMensaje").html("<i class='bx bx-x-circle bx-tada bx-lg' style='color:#f90707'></i>");
        $(".textoMensaje").text("La contraseña no puede ir vacía.");
        $("#msj").modal("toggle");
        return false;
    }

    if (contrasenaConfirmada == "") {
        $(".iconoMensaje").html("<i class='bx bx-x-circle bx-tada bx-lg' style='color:#f90707'></i>");
        $(".textoMensaje").text("Confirma tu contraseña.");
        $("#msj").modal("toggle");
    return false;
    }

    if (contrasenaNueva != contrasenaConfirmada) {
        $(".iconoMensaje").html("<i class='bx bx-x-circle bx-tada bx-lg' style='color:#f90707'></i>");
        $(".textoMensaje").text("Las contraseñas no son las mismas favor de verificar.");
        $("#msj").modal("toggle");
    return false;
    }

    var json_data = {
        "password": calcMD5(contrasenaConfirmada),
        "idUsuario": idUsuarioSesionGlobal
    }

    showMessageOverlay("CARGANDO...", "../images/cargando.gif", "200", "200", "sending");
    $.ajax({
        method:"POST",
        url:"../backend/backend_cambiar_password.php",
        data:json_data,
        success:function(data){
            var respuesta = JSON.parse(data);

            if(respuesta["codigo"] == "fallo"){
                $(".btnContrasenaCambio").click();
                $(".iconoMensaje").html("<i class='bx bx-x-circle bx-tada bx-lg' style='color:#f90707'></i>");
                $(".textoMensaje").text(respuesta["mensaje"]);
                $("#msj").modal("toggle");
                $("#contrasenaUsuarioCambiar").val("");
                $("#contrasenaUsuarioConfirmar").val("");
                closeMessageOverlay();
            }
            else if(respuesta["codigo"] == "exito"){
                $(".btnContrasenaCambio").click();
                $(".iconoMensaje").html("<i class='bx bx-check-circle bx-tada bx-lg' style='color:#0ea202' ></i>");
                $(".textoMensaje").text(respuesta["mensaje"]);
                $("#msjRec").modal("toggle");
                $("#contrasenaUsuarioCambiar").val("");
                $("#contrasenaUsuarioConfirmar").val("");
                closeMessageOverlay();
            }
        }
    });
}
// ======================================================================================

// EVENTO READY ===============================================================
$(document).ready(function () {
    idUsuarioSesionGlobal = "";
});
// ============================================================================
</script>