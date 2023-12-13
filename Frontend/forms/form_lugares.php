<?php

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
              <h2 class="text-white mb-4">Registro Nuevo A Explorar</h2>
            </div>
          </div>
        </div>
    </section>
    <div class="shadow-lg p-3 mb-5 bg-body-tertiary rounded">
        <div class='container-fluid'>
            <div class='row'>
                <div class="container-fluid">
                    <center>
                        <div class="radio-container">
                            <label>
                                <input type="radio" name="option" class="ratificacionesPublico" value="0" onclick="continuarAltaLugar(this);"> País
                            </label>
                            <label>
                                <input type="radio" name="option" class="ratificacionesPublico" value="1" onclick="continuarAltaLugar(this);"> Estado
                            </label>
                            <label>
                                <input type="radio" name="option" class="ratificacionesPublico" value="2" onclick="continuarAltaLugar(this);"> Municipio
                            </label>
                            <label>
                                <input type="radio" name="option" class="ratificacionesPublico" value="3" onclick="continuarAltaLugar(this);"> Lugar
                            </label>
                        </div>
                    </center>
                </div>
            </div>
            <br><br>
            <div class="container-fluid">
                <div class='row g-3' id="inputPais" hidden>
                    <center>
                        <div class='col-sm-2'>
                            <label for='fechaInicioLaboralTrabajadorActualizar' class='form-label'>Escribe el País</label>
                            <div class='input-group mb-3'>
                                <span class='input-group-text' id='basic-addon1'><i class="fi fi-rs-map-marker"></i></span>
                                <input type='text' class='form-control' aria-describedby='basic-addon1' placeholder="País" name='fechaInicioLaboralTrabajadorActualizar' id='fechaInicioLaboralTrabajadorActualizar'>
                            </div>
                        </div>
                    </center>
                </div>
                <div class='row g-3' id="inputEstado" hidden>
                    <center>
                        <div class='col-sm-2'>
                            <label for='' class='form-label'>Escribe el País</label>
                            <div class='input-group mb-3'>
                                <span class='input-group-text' id='basic-addon1'><i class="fi fi-rs-map-marker"></i></span>
                                <input type='text' class='form-control' aria-describedby='basic-addon1' placeholder="País" name='' id=''>
                            </div>
                        </div>
                        <div class='col-sm-2'>
                            <label for='generoTrabajadorActualizar' class='form-label'>Genero del trabajador</label>
                            <div class='input-group mb-3'>
                                <label class='input-group-text' for='generoTrabajadorActualizar'><i class='bx bx-male-female'></i></label>
                                <select class='form-select formRatificacionActualizar' id='generoTrabajadorActualizar' disabled>
                                    <option value='-1'>Genero</option>
                                    <option value='Hombre'>Hombre</option>
                                    <option value='Mujer'>Mujer</option>
                                </select>
                            </div>
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </div>
<script>
    // FUNCION MOSTRAR FORMULARIOS ================================================
    function continuarAltaLugar(e){
        valorLugar = $(e).val();
        console.log(valorLugar);

        if (valorLugar == "0") {
            // $(".inputPais").hide();
            // $('#inputPais').show();
            document.getElementById("inputPais").hidden = false;
        }
        else if (valorLugar == "1"){
            document.getElementById("inputEstado").hidden = false;
        }

    }
     // ===================================================================================================   
    // EVENTO READY ======================================================================================
    $(document).ready(function () {
        // var tablaUsuarios = new DataTable('#usuarios', {language: {url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',},});
    });
    // ===================================================================================================
</script>
<?php
require_once("../global/footer.php");
?>