<!-- Modal -->
<div class="modal fade" id="popupAltaUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">Registro de usuarios</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-address-card"></i></span>
                        <input type="text" class="form-control" placeholder="Nombres" aria-label="Nombres" aria-describedby="basic-addon1" name="nombresUsuarioAlta" id="nombresUsuarioAlta">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-address-card"></i></span>
                        <input type="text" class="form-control" placeholder="Apellidos" aria-label="Apellidos" aria-describedby="basic-addon1" name="apellidosUsuarioAlta" id="apellidosUsuarioAlta">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-address-card"></i></span>
                        <input type="text" class="form-control" placeholder="Edad" aria-label="Edad" aria-describedby="basic-addon1" name="edadUsuarioAlta" id="edadUsuarioAlta" maxlength="3" onKeypress="return soloNumeros(event);">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-phone"></i></span>
                        <input type="text" class="form-control" placeholder="Número de teléfono" aria-describedby="basic-addon1" name="telefonoUsuarioAlta" id="telefonoUsuarioAlta" maxlength="10">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-at"></i></span>
                        <input type="email" class="form-control" placeholder="Correo electrónico" aria-describedby="basic-addon1" name="correoUsuarioAlta" id="correoUsuarioAlta">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-key"></i></span>
                        <input type="password" class="form-control" placeholder="Contraseña" aria-describedby="basic-addon1" name="passwordUsuarioAlta" id="passwordUsuarioAlta">
                        <span class="input-group-text" id="showPassword" onclick="togglePassword('passwordUsuarioAlta')" style="cursor: pointer;">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-key"></i></span>
                        <input type="password" class="form-control" placeholder="Confirmar Contraseña" aria-describedby="basic-addon1" name="passwordConfirmacionUsuarioAlta" id="passwordConfirmacionUsuarioAlta">
                        <span class="input-group-text" id="showPasswordConfirmation" onclick="togglePassword('passwordConfirmacionUsuarioAlta')" style="cursor: pointer;">
                            <i class="fas fa-eye" id="eyeIconConfirmation"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">

        <button type="button" class="popupBtnCancelar btnCancelarUsuarioAlta" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="popupBtnContinuar" onclick="registrarUsuario();">Continuar</button>

      </div>
    </div>
  </div>
</div>
<script>
    // FUNCION ABRIR POPUP ========================================================
    function abrirPopupRegistrarUsuario(){
    $("#popupAltaUsuario").modal("toggle");
    }
    // ============================================================================

    // FUNCION MOSTRAR CONTRASEÑA =================================================
    function togglePassword(inputId) {
        
        var passwordInput = document.getElementById(inputId);
        

        if (inputId == "passwordUsuarioAlta") {
            var eyeIcon = document.getElementById('eyeIcon');
        } else if (inputId == "passwordConfirmacionUsuarioAlta") {
            var eyeIcon = document.getElementById('eyeIconConfirmation');
        } 

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
    // ============================================================================

    // FUNCION ABRIR POPUP ========================================================
    function registrarUsuario(){
        var nombresUsuarioAlta              = $("#nombresUsuarioAlta").val();
        var apellidosUsuarioAlta            = $("#apellidosUsuarioAlta").val();
        var edadUsuarioAlta                 = $("#edadUsuarioAlta").val();
        var telefonoUsuarioAlta             = $("#telefonoUsuarioAlta").val();
        var correoUsuarioAlta               = $("#correoUsuarioAlta").val();
        var passwordUsuarioAlta             = $("#passwordUsuarioAlta").val();
        var passwordConfirmacionUsuarioAlta = $("#passwordConfirmacionUsuarioAlta").val();

        if (nombresUsuarioAlta == "") {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Nombres no puede ir vacio',
                // footer: '<a href="">Why do I have this issue?</a>'
            })
            return false;
        }

        if (apellidosUsuarioAlta == "") {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Apellidos no puede ir vacio',
                // footer: '<a href="">Why do I have this issue?</a>'
            })
            return false;
        }

        if (edadUsuarioAlta == "") {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Edad no puede ir vacio',
                // footer: '<a href="">Why do I have this issue?</a>'
            })
            return false;
        }

        if (telefonoUsuarioAlta == "") {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Teléfono no puede ir vacio',
                // footer: '<a href="">Why do I have this issue?</a>'
            })
            return false;
        }

        if (correoUsuarioAlta == "") {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Correo electronico no puede ir vacio',
                // footer: '<a href="">Why do I have this issue?</a>'
            })
            return false;
        }

        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

        if (!emailPattern.test(correoUsuarioAlta)) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Formato del correo electronico incorrecto.',
                // footer: '<a href="">Why do I have this issue?</a>'
            })
            return false;
        }

        if (passwordUsuarioAlta == "") {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Contraseña no puede ir vacio',
                // footer: '<a href="">Why do I have this issue?</a>'
            })
            return false;
        }

        if (passwordConfirmacionUsuarioAlta == "") {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Confirma la contraseña.',
                // footer: '<a href="">Why do I have this issue?</a>'
            })
            return false;
        }

        if (passwordUsuarioAlta != passwordConfirmacionUsuarioAlta) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Las contraseñas no coinciden, favor de revisarlas.',
                // footer: '<a href="">Why do I have this issue?</a>'
            })
            return false;
        }

        var jsonData = {
            "userFirstName": nombresUsuarioAlta,
            "userLastName": apellidosUsuarioAlta,
            "userEmail": correoUsuarioAlta,
            "userPassword": calcMD5(passwordConfirmacionUsuarioAlta),
            "userPhoneNumber": telefonoUsuarioAlta,
            "userAge": edadUsuarioAlta
        }

        showMessageOverlay("CARGANDO...", "../images/cargando.gif", "200", "200", "sending");
        $.ajax({
            method:"POST",
            url:"../../Backend/backend/usuarios/backend_usuario_registrar.php",
            data:jsonData,
            success:function(data){
                var respuesta = JSON.parse(data);
                
                if(respuesta["codigo"] == "fallo"){
                    $(".btnCancelarUsuarioAlta").click();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: respuesta["mensaje"],
                        // footer: '<a href="">Why do I have this issue?</a>'
                    })
                    closeMessageOverlay();
                }
                else if(respuesta["codigo"] == "exito"){
                    $(".btnCancelarUsuarioAlta").click();
                    // Swal.fire({
                    //     icon: 'success',
                    //     title: 'Exito',
                    //     text: respuesta["mensaje"],
                    //     // footer: '<a href="">Why do I have this issue?</a>'
                    // })
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: respuesta["mensaje"],
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload(); // Recarga la página actual
                        }
                    });
                    closeMessageOverlay();
                }
            }
        });
    }
    // ============================================================================

    // EVENTO READY ===============================================================
    $(document).ready(function () {
    });
    // ============================================================================
</script>