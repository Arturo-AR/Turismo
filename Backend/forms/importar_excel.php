<?php
session_start();
$idUsuario = $_SESSION['idUsuario'];
include 'menu.php';
?>

<div class="panel panel-info">
    <div class="panel-heading">IMPORTAR COTIZACIÓN EXCEL</div>
    <div class="panel-body">
        <center>
            <div class="col-sm-12 col-xs-12">

                <button type="button" class="btn btn-secondary" onclick="mostrarFormularioExcelUnico();"><img src="../iconos/insertarExcel.png" style="width: 40px;"><br>Cotizacion Excel</button>

                <button type="button" class="btn btn-secondary" onclick="mostrarFormularioExcelMasivos();"><img src="../iconos/insertarExcel.png" style="width: 40px;"><br>Cotizacion Excel Masivos</button>

            </div>
        </center>
        <div class="col-sm-12 cotizacionMasivasExcel">
            <center>
                <br>
                <button type="button" class="btn btn-info" onclick="documentoInstrucciones(0);"><img src="../iconos/instrucciones.png" style="width: 30px;"><br>Instrucciones</button>
                <br><br>
                <button type="button" class="btn btn-success" onclick="formularioArchivoEncabezados();">Encabezados</button>

                <button type="button" class="btn btn-success" onclick="formularioArchivoProductos();">Productos</button>
            </center>
        </div>
        <div class="col-sm-12 excelEncabezados">
            <center>
                <br>
                <div class="col-sm-3 boxFile">
                    <div>
                        <label>Archivo Encabezados</label>
                        <br>
                        <button class='col-sm-12 cargarArchivo' onClick='clickCargarArchivoExcelEncabezados();'>Archivo<span class='btnCargar'></span></button>
                    </div>
                    <form class="formularioCamposOcultos" id="formArchivoExcelEncabezados" enctype="multipart/form-data">

                        <input type="file" name="encabezados" id="encabezados" accept=".xls,.xlsx" onChange="cambioArchivoExcelEncabezados();" />
                        <input type="text" name="idUsuario" id="idUsuarioEncabezados" value="<?=$idUsuario;?>;"/>

                    </form>
                </div>
                <div class="col-sm-3">
                    <br><br>
                    <button type="button" class="btn btn-success" onclick="enviarExcelMasivoEncabezados();"><img src="../iconos/excel.png" style="width: 30px;"><br>Importar</button>
                </div>
            </center>
        </div>
        <div class="col-sm-12 excelProductos">
            <center>
                <br>
                <div class="col-sm-3 boxFile">
                    <div>
                        <label>Archivo Productos</label>
                        <br>
                        <button class='col-sm-12 cargarArchivo' onClick='clickCargarArchivoExcelProductos();'>Archivo<span class='btnCargar'></span></button>
                    </div>
                    <form class="formularioCamposOcultos" id="formArchivoExcelProductos" enctype="multipart/form-data">

                        <input type="file" name="productos" id="productos" accept=".xls,.xlsx" onChange="cambioArchivoExcelProductos();" />

                    </form>
                </div>
                <div class="col-sm-3">
                    <br><br>
                    <button type="button" class="btn btn-success" onclick="enviarExcelMasivoProductos();"><img src="../iconos/excel.png" style="width: 30px;"><br>Importar</button>
                </div>
            </center>
        </div>
        <br><br>
        <div class="col-sm-12 cotizacionUnicasExcel">
            <center>
                <div class="row">
                    <div class="col-lg-4 selectEmpresasExcel"></div>
                    <div class="col-sm-4 selectClienteExcel"></div>
                    <div class="col-lg-3 campoTelefonoCliente">
                        <label>Teléfono</label>
                        <input type='text' name='telefonoExcelUnica' id='telefonoExcelUnica' class='form-control' maxlength="10">
                    </div>
                </div>
                <br>
                <div class="col-sm-3 boxFile">
                    <div>
                        <label>Archivo cotización</label>
                        <br>
                        <button class='col-sm-12 cargarArchivo' onClick='clickCargarArchivoExcelUnica();'>Archivo<span class='btnCargar'></span></button>
                    </div>
                    <form class="formularioCamposOcultos" id="formArchivosExcelUnicas" enctype="multipart/form-data">

                        <input type="file" name="excelUnico" id="excelUnico" accept=".xls,.xlsx" onChange="cambioArchivoExcelUnica();" />
                        <input type="text" name="idUsuario" id="idUsuarioUnico" value="<?=$idUsuario;?>;"/>
                        <input type="text" name="telefono" id="telefono"/>
                        <input type="text" name="empresa" id="empresa"/>
                        <input type="text" name="cliente" id="cliente"/>

                    </form>
                </div>
                <div class="col-sm-3">
                    <br><br>
                    <button type="button" class="btn btn-success" onclick="enviarExcelUnico();"><img src="../iconos/excel.png" style="width: 30px;"><br>Importar</button>
                    <button type="button" class="btn btn-info" onclick="documentoInstrucciones(1);"><img src="../iconos/instrucciones.png" style="width: 30px;"><br>Instrucciones</button>
                </div>
            </center>
        </div>
    </div>
</div>
<script>
//FUNCION MOSTRAR DOCUMENTO DE INSTRUCCIONES ======================================================
function documentoInstrucciones(operacion){

    if (operacion == 0) {
        window.open("../assets/manual/SubirCotizExcelMasiva.pdf", "Instrucciones Para Creación De Excel", "width=2000, height=1000");
    }
    else if (operacion == 1){
        window.open("../assets/manual/SubirCotizExcel.pdf", "Instrucciones Para Creación De Excel", "width=2000, height=1000");
    }
    
}
//==================================================================================================

//FUNCION OCULTAR FORMULARIO MASIVO ================================================================
function mostrarFormularioExcelUnico(){
    $(".cotizacionMasivasExcel").hide();
    $(".cotizacionUnicasExcel").show();
    $(".excelEncabezados").hide();
    $(".excelProductos").hide();
}
//===================================================================================================

//FUNCION OCULTAR FORMULARIO MASIVO ================================================================
function mostrarFormularioExcelMasivos(){
    $(".cotizacionMasivasExcel").show();
    $(".cotizacionUnicasExcel").hide();
}
//===================================================================================================

//FUNCION ARCHIVO EXCEL MASIVO PRODUCTOS=============================================================
function formularioArchivoProductos(){
    $(".excelEncabezados").hide();
    $(".excelProductos").show();
}
//===================================================================================================

//FUNCION ARCHIVO EXCEL MASIVO ENCABEZADOS===========================================================
function formularioArchivoEncabezados(){
    $(".excelEncabezados").show();
    $(".excelProductos").hide();
}
//===================================================================================================

//FUNCION CLIC CARGAR ARCHIVO=========================================================================
function clickCargarArchivoExcelUnica(){
    $("#excelUnico").click();
}
//====================================================================================================

//FUNCION CAMBIO ARCHIVO==============================================================================
function cambioArchivoExcelUnica(){
    $(".cargarArchivo").html("Cargado<span class='btnCargado'></span>");
}
//====================================================================================================

//FUNCION CLIC CARGAR ARCHIVO=========================================================================
function clickCargarArchivoExcelEncabezados(){
    $("#encabezados").click();
}
//====================================================================================================

//FUNCION CAMBIO ARCHIVO==============================================================================
function cambioArchivoExcelEncabezados(){
    $(".cargarArchivo").html("Cargado<span class='btnCargado'></span>");
}
//====================================================================================================

//FUNCION CLIC CARGAR ARCHIVO=========================================================================
function clickCargarArchivoExcelProductos(){
    $("#productos").click();
}
//====================================================================================================

//FUNCION CAMBIO ARCHIVO==============================================================================
function cambioArchivoExcelProductos(){
    $(".cargarArchivo").html("Cargado<span class='btnCargado'></span>");
}
//====================================================================================================

// //FUNCION CAMBIO ARCHIVO==============================================================================
// function cambioArchivoExcelMasivos(e){
// var archivo = $(e).attr("id");
// $(".cargarArchivo[archivo='"+archivo+"']").html("Cargado<span class='btnCargado'></span>");
// }
// //====================================================================================================

// //FUNCION CLIC CARGAR ARCHIVO=========================================================================
//   function clickCargarArchivoExcelMasivos(e){
//     var archivo = $(e).attr("archivo");
//     var guardar = $(e).attr("guardar");

//     if(guardar == "true"){ $("#"+archivo).click(); }
    
//   }
// //====================================================================================================

//FUNCION OBTENER DATOS EMPRESAS=======================================================================
function obtener_datos_empresas_excel(){

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_mostrar_empresa.php",
        data: "",
        success:function(data){
          var resultadoMostrar = JSON.parse(data);
            if(resultadoMostrar["codigo"] == "fallo"){
                var resultados = resultadoMostrar["mensaje"];
              $(".texto-mensaje").text(resultados);
                $("#msj").modal("toggle");
               closeMessageOverlay();
            }
            else if(resultadoMostrar["codigo"] == "exito"){
                var resultados = resultadoMostrar["objetoRespuesta"]["empresas"];

                var opcionesEmpresas = "<option value='-1'>Buscar Empresas ...</option>";

                for (i = 0; i < resultados.length; i++) {
                    var resultadosTotales = resultados[i];
                    var idEmpresa = resultadosTotales["id_empresa"];
                    var empresa   = resultadosTotales["nombre"];

                    opcionesEmpresas += "<option data-id='"+idEmpresa+"' value='"+empresa+"'>"+empresa+"</option>";
                }
                
                var htmlSelectEmpresas =
                "<label for='seleccionEmpresa'>Buscar Empresas:</label>"+
                "<input list='listaEmpresas' name='empresa' id='empresa' class='form-control' onchange='empresasCombinar(this);'>"+

                "<datalist id='listaEmpresas'>"+opcionesEmpresas+"</datalist>";
                $(".selectEmpresasExcel").html(htmlSelectEmpresas);
            }
        }
    });
    closeMessageOverlay();
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS=========================================================================
function empresasCombinar(e){
    nombreEmpresaExcelGlobal = $(e).val();

    idEmpresaExcelGlobal = $('#listaEmpresas').find('option[value="'+nombreEmpresaExcelGlobal+'"]').data('id');
}
//====================================================================================================

//FUNCION OBTENER DATOS CLIENTES======================================================================
function obtener_datos_clientes_excel(){

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_cliente_mostrar.php",
        data: "",
        success:function(data){
          var resultadoMostrar = JSON.parse(data);
          if(resultadoMostrar["codigo"] == "fallo"){
                var htmlSelectClientes =
                "<label for='seleccionCliente'>Buscar Clientes:</label>"+
                "<input type='text' name='cliente' id='cliente' class='form-control'>";

                $(".selectClienteExcel").html(htmlSelectClientes);
                closeMessageOverlay();
            }
            else if(resultadoMostrar["codigo"] == "exito"){
                var resultados = resultadoMostrar["objetoRespuesta"]["cliente"];

                var opcionesClientes = "<option value=''>Buscar Clientes ...</option>";

                for (i = 0; i < resultados.length; i++) {
                    var resultadosTotales = resultados[i];
                    var nombreCliente   = resultadosTotales["cliente"];
                    var idCliente = resultadosTotales["idCliente"];
                    var rfcCliente = resultadosTotales["rfc"];
                    var telefonoCliente = resultadosTotales["telefono"];

                    opcionesClientes += "<option data-id='"+idCliente+"' data-rfc='"+rfcCliente+"' data-telefono='"+telefonoCliente+"' value='"+nombreCliente+"'>"+nombreCliente+"</option>";
                }

                var htmlSelectClientes =
                "<label for='seleccionCliente'>Buscar Clientes:</label>"+
                "<input list='listaClientes' name='cliente' id='cliente' class='form-control' onchange='clientesCombinar(this);'>"+

                "<datalist id='listaClientes'>"+opcionesClientes+"</datalist>";
                $(".selectClienteExcel").html(htmlSelectClientes);

                closeMessageOverlay();
            }
        }
    });
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS=========================================================================
function clientesCombinar(e){
    nombreClienteExcelGlobal = $(e).val();

    idClienteExcelGlobal = $('#listaClientes').find('option[value="'+nombreClienteExcelGlobal+'"]').data('id');
    var telefonoCliente = $('#listaClientes').find('option[value="'+nombreClienteExcelGlobal+'"]').data('telefono');


    if (idClienteExcelGlobal == undefined) {
        $("#telefonoExcelUnica").val("");
    }else{
        $("#telefonoExcelUnica").val(telefonoCliente);
    } 
}
//====================================================================================================

// //FUNCION OCULTAR FORMULARIO MASIVO ================================================================
// function enviarExcelMasivo(){
//     var archivoProductos   = $("#productos").val();
//     var archivoEncabezados = $("#encabezados").val();
//     var idUsuario          = $("#idUsuarioMasivo").val();

//     // VALIDACION
//   if(validacionCamposInput(archivoProductos, "", ".texto-mensaje", "", 0, "El archivo de productos es obligatoria.") == false){
//     $("#msj").modal("toggle");
//     return false;
//   }

//   if(validacionCamposInput(archivoEncabezados, "", ".texto-mensaje", "", 0, "El archivo de encabezados es obligatoria.") == false){
//     $("#msj").modal("toggle");
//     return false;
//   }

//   $("#idUsuario").val(idUsuario);
//   $("#formArchivosExcelMasivos").submit();
// }
// //===================================================================================================

// //EVENTO ALTA DISTRIBUIDOR============================================================================
// $("#formArchivosExcelMasivos").on("submit", function(e){
//     e.preventDefault();

//     var formData = new FormData(document.getElementById("formArchivosExcelMasivos"));

//     showMessageOverlay("ENVIANDO...", "../iconos/cargando.gif", "200", "200", "sending");

//     $.ajax({
//       url: "../backend/backend_cotizaciones_excel_masivo_registro.php",
//       type: "POST",
//       dataType: "html",
//       data: formData,
//       cache: false,
//       contentType: false,
//       processData: false,
//       success:function(data){
//         var resultado = JSON.parse(data);
        
//         if(resultado["codigo"] == "fallo"){
//           if(resultado["mensaje"] == ""){
//             $(".texto-mensaje").text("ERROR.");
//           }
//           else{
//             $(".texto-mensaje").text(resultado["mensaje"]);
//           }
//           $("#msj").modal("toggle");
//           closeMessageOverlay();
//         }
//         else if(resultado["codigo"] == "exito"){
//           $(".texto-mensaje").text("Cotizaciones guardadas correctamente.");
//           $("#msjRec").modal("toggle");
//           closeMessageOverlay();
//         }
//       }
//     });
// });
// //====================================================================================================

//FUNCION ENVIAR EXCEL MASIVO ENCABEZADOS ============================================================================
function enviarExcelMasivoEncabezados(){
    var archivoEncabezados = $("#encabezados").val();
    var idUsuario          = $("#idUsuarioEncabezados").val();

    // VALIDACION
      if(validacionCamposInput(archivoEncabezados, "", ".texto-mensaje", "", 0, "El archivo de la cotizacion es obligatoria.") == false){
        $("#msj").modal("toggle");
        return false;
      }

      $("#formArchivoExcelEncabezados #idUsuarioUnico").val(idUsuario);

      $("#formArchivoExcelEncabezados").submit();
}
//===================================================================================================

//EVENTO ENVIAR EXCEL MASIVO ENCABEZADOS============================================================================
$("#formArchivoExcelEncabezados").on("submit", function(e){
    e.preventDefault();

    var formData = new FormData(document.getElementById("formArchivoExcelEncabezados"));

    showMessageOverlay("ENVIANDO...", "../iconos/cargando.gif", "200", "200", "sending");

    $.ajax({
      url: "../backend/backend_cotizaciones_excel_masivo_registro.php",
      type: "POST",
      dataType: "html",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success:function(data){
        var resultado = JSON.parse(data);
        
        if(resultado["codigo"] == "fallo"){
          if(resultado["mensaje"] == ""){
            $(".texto-mensaje").text("ERROR.");
          }
          else{
            $(".texto-mensaje").text(resultado["mensaje"]);
          }
          $("#msj").modal("toggle");
          closeMessageOverlay();
        }
        else if(resultado["codigo"] == "exito"){
          $(".texto-mensaje").text("Encabezados guardados correctamente.");
          $("#msjRec").modal("toggle");
          closeMessageOverlay();
        }
      }
    });
});
//====================================================================================================

//FUNCION ENVIAR EXCEL MASIVO PRODUCTOS ============================================================================
function enviarExcelMasivoProductos(){
    var archivoProductos = $("#productos").val();
    // var idUsuario          = $("#idUsuarioProductos").val();

    // VALIDACION
      if(validacionCamposInput(archivoProductos, "", ".texto-mensaje", "", 0, "El archivo de la cotizacion es obligatoria.") == false){
        $("#msj").modal("toggle");
        return false;
      }

      // $("#formArchivoExcelEncabezados #idUsuarioUnico").val(idUsuario);

      $("#formArchivoExcelProductos").submit();
}
//===================================================================================================

//EVENTO ENVIAR EXCEL MASIVO PRODUCTOS ============================================================================
$("#formArchivoExcelProductos").on("submit", function(e){
    e.preventDefault();

    var formData = new FormData(document.getElementById("formArchivoExcelProductos"));

    showMessageOverlay("ENVIANDO...", "../iconos/cargando.gif", "200", "200", "sending");

    $.ajax({
      url: "../backend/backend_cotizaciones_excel_masivo_productos.php",
      type: "POST",
      dataType: "html",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success:function(data){
        var resultado = JSON.parse(data);
        
        if(resultado["codigo"] == "fallo"){
          if(resultado["mensaje"] == ""){
            $(".texto-mensaje").text("ERROR.");
          }
          else{
            $(".texto-mensaje").text(resultado["mensaje"]);
          }
          $("#msj").modal("toggle");
          closeMessageOverlay();
        }
        else if(resultado["codigo"] == "exito"){
          $(".texto-mensaje").text("Productos guardados correctamente.");
          $("#msjRec").modal("toggle");
          closeMessageOverlay();
        }
      }
    });
});
//====================================================================================================

//FUNCION ENVIAR EXCEL UNICO ============================================================================
function enviarExcelUnico(){
    var archivoExcelUnica   = $("#excelUnico").val();
    var idUsuario           = $("#idUsuarioUnico").val();
    var empresa             = nombreEmpresaExcelGlobal;
    var cliente             = nombreClienteExcelGlobal;
    var telefono            = $("#telefonoExcelUnica").val();

    // VALIDACION
      if(validacionCamposInput(archivoExcelUnica, "", ".texto-mensaje", "", 0, "El archivo de la cotizacion es obligatoria.") == false){
        $("#msj").modal("toggle");
        return false;
      }

      if(validacionCamposInput(empresa, "", ".texto-mensaje", "", 0, "La empresa es obligatoria.") == false){
        $("#msj").modal("toggle");
        return false;
      }

      if(validacionCamposInput(cliente, "", ".texto-mensaje", "", 0, "El cliente es obligatorio.") == false){
        $("#msj").modal("toggle");
        return false;
      }

      $("#formArchivosExcelUnicas #idUsuarioUnico").val(idUsuario);
      $("#formArchivosExcelUnicas #empresa").val(empresa);
      $("#formArchivosExcelUnicas #cliente").val(cliente);
      $("#formArchivosExcelUnicas #telefono").val(telefono);
      $("#formArchivosExcelUnicas").submit();
}
//===================================================================================================

//EVENTO ALTA DISTRIBUIDOR============================================================================
$("#formArchivosExcelUnicas").on("submit", function(e){
    e.preventDefault();

    var formData = new FormData(document.getElementById("formArchivosExcelUnicas"));

    showMessageOverlay("ENVIANDO...", "../iconos/cargando.gif", "200", "200", "sending");

    $.ajax({
      url: "../backend/backend_crear_id_excel.php",
      type: "POST",
      dataType: "html",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success:function(data){
        var resultado = JSON.parse(data);
        
        if(resultado["codigo"] == "fallo"){
          if(resultado["mensaje"] == ""){
            $(".texto-mensaje").text("ERROR.");
          }
          else{
            $(".texto-mensaje").text(resultado["mensaje"]);
          }
          $("#msj").modal("toggle");
          closeMessageOverlay();
        }
        else if(resultado["codigo"] == "exito"){
          $(".texto-mensaje").text("Cotizacion guardada correctamente.");
          $("#msjRec").modal("toggle");
          closeMessageOverlay();
        }
      }
    });
});
//====================================================================================================

//EVENTO READY========================================================================================
$(document).ready(function(){
    nombreEmpresaExcelGlobal = "";
    idEmpresaExcelGlobal = "";
    nombreClienteExcelGlobal = "";
    idClienteExcelGlobal = "";
    $(".cotizacionMasivasExcel").hide();
    $(".cotizacionUnicasExcel").hide();
    $(".excelEncabezados").hide();
    $(".excelProductos").hide();
    obtener_datos_empresas_excel();
    obtener_datos_clientes_excel();
});
//====================================================================================================
</script>