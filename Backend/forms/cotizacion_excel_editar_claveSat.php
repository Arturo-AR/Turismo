<?php
session_start();
$idUsuario = $_SESSION['idUsuario'];
// $nombreUsuario = $_SESSION['nombreUsuario'];
include 'menu.php';
?>
<div class="panel panel-info">
    <div class="panel-heading">EDITAR COTIZACIÓN EXCEL</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-4">
                <label>Selecciona el tipo de excel</label>
                <select class="form-control" id="tipoCotizacionExcel" onchange="tipoCotizacionSelectExcel();">
                    <option value="-1">Tipos</option>
                    <option value="0">Excel única</option>
                    <option value="1">Excel multiple</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 selectCotizEncontradasEditarCotizExcel"></div>
            <div class="col-lg-3 fechaEditarCotizExcel"></div>
        </div>
        <div class="row">
            <div class="col-lg-3 selectEmpresaEditarCotizExcel"></div>
            <div class="col-lg-3 selectClienteEditarCotizExcel"></div>
            <div class="col-lg-3 telefonoEditarCotizExcel"></div>
            <div class="col-lg-2 botonAgregarProductoEditarCotizExcel"></div>
        </div>

        <div class="row">
            <div class="col-lg-4 listaProductosEditarCotizExcel"></div>
            <div class="col-lg-3 listaProductosClaveSatEditarCotizExcel"></div>
            <div class="col-lg-3 listaUnidadProductoEditarCotizExcel"></div>
            <div class="col-lg-2 botonCancelarProductoEditarCotizExcel"></div>
        </div>

        <div class="row">
            <div class="col-lg-2 listaProductosClaveEditarCotizExcel"></div>
            <div class="col-lg-6 campoDescripcionProductoEditarCotizExcel"></div>
        </div>

        <div class="row">
            <div class="col-lg-2 campoCantidadEditarCotizExcel"></div>
            <div class="col-lg-2 campoPrecioListaEditarCotizExcel"></div>
            <div class="col-lg-2 botonAgregarProductoNuevoEditarCotizExcel"></div>
        </div> 
        <div class="table-responsive" id="tablaCotizEditProdCotizExcel">
            <table class="table table-primary bg-light tablaProductosTotalEditarCotizExcel" id="tablaProductosAnadidosEditarCotizExcel">
                <thead>
                    <tr>
                        <th>Clave</th>
                        <th>Clave Sat</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Importe</th>
                        <th>Operación</th>
                        <th style="visibility:collapse; display:none;"></th>
                    </tr>
                </thead>
                <tbody class="prodCotizEditarCotizExcel">
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-lg-8 condicionesEditarCotizExcel"></div>
            <div class="text-center totalCantidadProductosEditarCotizExcel" style="font-size: 40px; color: #000;"></div>
            <div><input type="hidden" class="cantidadTotalEditarCotizExcel"></div>
        </div>
        <div class="text-center botonActualizarCotizExcel"></div>
    </div>
</div>
<script>
//FUNCION OBTENER DATOS PROVEEDORES Y FOLIOS=======================================================================
function tipoCotizacionSelectExcel(){
    tipoExcel = $("#tipoCotizacionExcel").val();

    if (tipoExcel == 0) {
        selectFoliosEditarExcelUnica();
        limpiar_datos_excel();
    }
    else if(tipoExcel == 1){
        selectFoliosEditarExcel();
        limpiar_datos_excel();
    }
}
//====================================================================================================

//FUNCION OBTENER DATOS PROVEEDORES Y FOLIOS=======================================================================
function limpiar_datos_excel(){
    $(".prodCotizEditarCotizExcel").html("");
    $(".selectClienteEditarCotizExcel").html("");
    $(".condicionesEditarCotizExcel").html("");
    $(".fechaEditarCotizExcel").html("");
    $(".selectEmpresaEditarCotizExcel").html("");
    $(".telefonoEditarCotizExcel").html("");
    $(".botonAgregarProductoEditarCotizExcel").html("");
    $(".botonActualizarCotizExcel").html("");
    $(".totalCantidadProductosEditarCotizExcel").html("");
    $(".listaProductosEditarCotizExcel").html("");
    $(".listaProductosClaveEditarCotizExcel").html("");
    $(".botonCancelarProductoEditarCotizExcel").html("");
    $(".campoUnidadProductoEditarCotizExcel").html("");
    $(".campoClaveProductoEditarCotizExcel").html("");
    $(".campoDescripcionProductoEditarCotizExcel").html("");
    $(".campoCantidadEditarCotizExcel").html("");
    $(".precioListaEditarCotizExcel").html("");
    $(".botonAgregarProductoNuevoEditarCotizExcel").html("");
    $(".cantidadTotalEditarCotizExcel").html("");
}
//====================================================================================================

//FUNCION OBTENER FOLIOS=======================================================================
function selectFoliosEditarExcel(e){

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_cotizacion_excel_mostrar_todas.php",
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
                var resultados = resultadoMostrar["objetoRespuesta"]["cotizaciones_excel"];
                // console.log(resultados);
                var opcionesCotizacionExcelEditar = "<option value='-1' cliente='' empresa='' fecha='' telefono=''>Cotizaciones *</option>";

                for (i = 0; i < resultados.length; i++) {
                    var resultadosTotales = resultados[i];
                    // console.log(resultadosTotales);
                    var idCotizacionExcel = resultadosTotales["idCotizacionExcel"];
                    var cliente           = resultadosTotales["cliente"];
                    var condiciones       = resultadosTotales["condiciones"];
                    var empresa           = resultadosTotales["empresa"];
                    var fecha_registro    = resultadosTotales["fecha_registro"];
                    var telefono          = resultadosTotales["telefono"];

                    opcionesCotizacionExcelEditar += "<option value='"+idCotizacionExcel+"' cliente='"+cliente+"' empresa='"+empresa+"' fecha='"+fecha_registro+"' telefono='"+telefono+"'>"+idCotizacionExcel+"</option>";
                }
                var htmlSelectCotizacionesProveedor =
                "<label>Cotizaciones Encontradas</label>"+
                "<select name='cotizEncontradaImprimirCotizExcel' class='form-control' id='cotizEncontradaImprimirCotizExcel' onchange='obtener_datos_cotizaciones_editar_excel(1);'>"+opcionesCotizacionExcelEditar+"</select>";
                $(".selectCotizEncontradasEditarCotizExcel").html(htmlSelectCotizacionesProveedor);

                closeMessageOverlay();
            }
        }
    });

}
//====================================================================================================

//FUNCION OBTENER DATOS COTIZACIONES=======================================================================
function obtener_datos_cotizaciones_editar_excel(operacion){
    limpiar_datos_excel();
    // $(".contenidoCotizacionExcel").html("");

    var idCotizExcel = $("#cotizEncontradaImprimirCotizExcel option:selected").val();

    if (operacion == 0) {
         jsonData = {
            "idCotizacionExcelUnica": idCotizExcel
        }

      showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
      $.ajax({
        method: "POST",
        url: "../backend/backend_cotizacion_excel_unica_mostrar.php",
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
            var resultadosTablaCotizaciones= resultadoMostrar["objetoRespuesta"]["folios"];
            // console.log(resultadosTablaCotizaciones);

            for (i = 0; i < resultadosTablaCotizaciones.length; i++) {
                var resultadosTotales = resultadosTablaCotizaciones[i];
                var cantidadEditar               = resultadosTotales["cantidad"];//
                var claveEditar                  = resultadosTotales["clave"];//
                var clienteEditar                = resultadosTotales["cliente"];//
                var condicionesEditar            = resultadosTotales["condiciones"];//
                var descripcionEditar            = resultadosTotales["descripcion"];//
                var fechaRegistroEditar          = resultadosTotales["fecha_registro"];//
                var idCotizacionExcel            = resultadosTotales["idCotizacionExcel"];//
                // var idSubCotizacionUnica         = resultadosTotales["idSubcotizUnica"];
                // var idProducto                   = resultadosTotales["idProducto"];
                var importeEditar                = resultadosTotales["importe"];//
                var empresaEditar                 = resultadosTotales["empresa"];
                var precioUnitarioEditar         = resultadosTotales["precioUnitario"];//
                var telefonoEditar               = resultadosTotales["telefono"];//
                // totalEditar                      = resultadosTotales["total"];

                var tabla = document.querySelectorAll("#tablaProductosAnadidosEditarCotizExcel tbody tr");
                var ref = tabla.length + 1;
                var num = ref;
                var columna0 = 0;
                var columna1 = 1;
                var columna2 = 2;
                var columna3 = 3;
                var columna4 = 4;
                var columna5 = 5;
                var columna6 = 6;
                // console.log(num);

                var htmlProdCotizEditar =
                "<tr fila='"+num+"'>"+
                    "<td class='clavesProductos' columna='"+columna0+"'>"+claveEditar+"</td>"+
                    "<td class='clavesSatProductos' columna='"+columna1+"'></td>"+
                    "<td class='desProductos' columna='"+columna2+"'>"+descripcionEditar+"</td>"+
                    "<td class='cantProductos' columna='"+columna3+"'>"+cantidadEditar+"</td>"+
                    "<td class='precioProductos' columna='"+columna4+"'>"+precioUnitarioEditar+"</td>"+
                    "<td class='totalImporteProductos' columna='"+columna5+"'>"+importeEditar+"</td>"+
                    "<td><button type='button' class='btn btn-outline-danger botonEliminar' onclick='eliminarProductoEditarExcel(this,"+importeEditar+", "+num+", "+columna0+")' style='width: 50%;'><img src='../iconos/eliminar.png' style='width: 20px;'></button><br><button type='button' class='btn btn-outline-warning botonEditarProducto' onclick='abrirPopupEditarCotizExcel("+cantidadEditar+", "+precioUnitarioEditar+", "+num+", "+columna0+", "+columna1+", "+columna2+", "+columna3+", "+columna4+", "+columna5+", "+columna6+");' style='width: 50%;'><img src='../iconos/editar.png' style='width: 20px;'></button><input type='hidden' class='totalProductosEditar' columna='"+columna6+"' value='"+importeEditar+"'/></td>"+
                    "<td class='idProductos' style='visibility:collapse; display:none;'></td>"+
                "</tr>";

                $(".prodCotizEditarCotizExcel").append(htmlProdCotizEditar);

                actualizarTotalCotizacionExcel();
            }

            var htmlCampoTelefonoEditar =
            "<label>Teléfono</label>"+
            "<input type='text' name='campoTelefonoEditar' id='campoTelefonoEditar' class='form-control' value='"+telefonoEditar+"'>";
            $(".telefonoEditarCotizExcel").html(htmlCampoTelefonoEditar);

            showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
            $.ajax({
                method: "POST",
                url: "../backend/backend_cliente_mostrar.php",
                data: "",
                success:function(data){
                  var resultadoMostrar = JSON.parse(data);
                  if(resultadoMostrar["codigo"] == "fallo"){
                        // var resultados = resultadoMostrar["mensaje"];
                        // $(".texto-mensaje").text(resultados);
                        // $("#msj").modal("toggle");
                        closeMessageOverlay();
                    }
                    else if(resultadoMostrar["codigo"] == "exito"){
                        var resultados = resultadoMostrar["objetoRespuesta"]["cliente"];

                        var opcionesClientes = "<option value='-1' cliente='' rfc='' telefono=''>Clientes *</option>";

                        for (i = 0; i < resultados.length; i++) {
                            var resultadosTotales = resultados[i];
                            // console.log(resultadosTotales);
                            var nombreCliente   = resultadosTotales["cliente"];
                            var idCliente = resultadosTotales["idCliente"];
                            var rfcCliente = resultadosTotales["rfc"];
                            var telefonoCliente = resultadosTotales["telefono"];
                            // console.log(nombreCliente);

                            opcionesClientes += "<option value='"+idCliente+"' cliente='"+nombreCliente+"' rfc='"+rfcCliente+"' telefono='"+telefonoCliente+"'>"+nombreCliente+"</option>";
                        }
                        var htmlSelectClientesEditar =
                        "<label>Cliente Cotización</label>"+
                        "<select name='cliente_cotiz_editarCotizExcel' class='form-control' id='cliente_cotiz_editarCotizExcel'>"+opcionesClientes+"</select>";
                        $(".selectClienteEditarCotizExcel").html(htmlSelectClientesEditar);

                        $("#cliente_cotiz_editarCotizExcel option:contains("+clienteEditar+")").attr('selected', true);
                        closeMessageOverlay();
                    }
                }
            });

            var htmlCampoCondicionesEditar =
            "<label for='condiciones' style='font-size: 40px;'>CONDICIONES COMERCIALES</label>"+
            "<textarea class='form-control' name='condicionesEditarCotizExcel' id='condicionesEditarCotizExcel' rows='4'>"+condicionesEditar+"</textarea>";
            $(".condicionesEditarCotizExcel").html(htmlCampoCondicionesEditar);

            var htmlCampoFechaRegistroEditar =
            "<label>Fecha Registro</label>"+
            "<input type='date' name='fecha_editarCotizExcel' id='fecha_editarCotizExcel' class='form-control' value='"+fechaRegistroEditar+"'>";
            $(".fechaEditarCotizExcel").html(htmlCampoFechaRegistroEditar);

            // var htmlTotalEditar = moneda+totalEditar;
            
            // $(".totalCantidadProductosEditar").html(htmlTotalEditar);

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

                    var opcionesEmpresas = "<option value='-1' nombre=''>EMPRESA *</option>";

                    for (i = 0; i < resultados.length; i++) {
                        var resultadosTotales = resultados[i];
                        // console.log(resultadosTotales);
                        var idEmpresa = resultadosTotales["id_empresa"];
                        // var atencion = resultadosTotales["atencion"];
                        var empresa   = resultadosTotales["nombre"];
                        // var telefono  = resultadosTotales["telefono"];

                        opcionesEmpresas += "<option value='"+idEmpresa+"' nombre='"+empresa+"'>"+empresa+"</option>";
                    }
                    var htmlSelectEmpresas =
                    "<label>Empresa</label>"+
                    "<select name='empresa_cotiz_editar_excel' class='form-control' id='empresa_cotiz_editar_excel'>"+opcionesEmpresas+"</select>";
                    $(".selectEmpresaEditarCotizExcel").html(htmlSelectEmpresas);

                    // $("#empresa_cotiz_editar_excel option[value='"+ nombreEditar +"']").attr("selected",true);
                    $("#empresa_cotiz_editar_excel option:contains("+empresaEditar+")").attr('selected', true);

                    closeMessageOverlay();
                  }
                }
            });

            var htmlBotonAgregarProducto =
            "<br>"+
            // "<label>Agregar Producto</label>"+
            "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacioneEditarExcel()' style='width: 100%;'><img src='../iconos/mas.png' style='width: 30px;'>Agregar Producto</button>";
            $(".botonAgregarProductoEditarCotizExcel").html(htmlBotonAgregarProducto);

            var htmlBotonActualizar =
            "<div class='text-center'>"+
                "<label>ACTUALIZAR</label>"+
            "</div>"+
            "<div class='text-center'>"+
                "<button type='button' class='btn btn-outline-success' onclick='actualizarDatosCotizacion(0);' style='width: 20%;'><img src='../iconos/actualizar.png' style='width: 40px;'></button>"+
            "</div>";
            $(".botonActualizarCotizExcel").html(htmlBotonActualizar);

            closeMessageOverlay();
          }
        }
      });
    }
    else if (operacion == 1){
        

        jsonData = {
            "idCotizacionExcel": idCotizExcel
        }

      showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
      $.ajax({
        method: "POST",
        url: "../backend/backend_cotizacion_excel_mostrar.php",
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
            var resultadosTablaCotizaciones= resultadoMostrar["objetoRespuesta"]["folios"];
            // console.log(resultadosTablaCotizaciones);

            for (i = 0; i < resultadosTablaCotizaciones.length; i++) {
                var resultadosTotales = resultadosTablaCotizaciones[i];
                var cantidadEditar               = resultadosTotales["cantidad"];//
                var claveEditar                  = resultadosTotales["clave"];//
                var clienteEditar                = resultadosTotales["cliente"];//
                var condicionesEditar            = resultadosTotales["condiciones"];//
                var descripcionEditar            = resultadosTotales["descripcion"];//
                var fechaRegistroEditar          = resultadosTotales["fecha_registro"];//
                var idCotizacionExcel            = resultadosTotales["idCotizacionExcel"];//
                // var idSubCotizacionUnica         = resultadosTotales["idSubcotizUnica"];
                // var idProducto                   = resultadosTotales["idProducto"];
                var importeEditar                = resultadosTotales["importe"];//
                var empresaEditar                 = resultadosTotales["empresa"];
                var precioUnitarioEditar         = resultadosTotales["precioUnitario"];//
                var telefonoEditar               = resultadosTotales["telefono"];//
                // totalEditar                      = resultadosTotales["total"];
                // console.log(clienteEditar, empresaEditar);

                var tabla = document.querySelectorAll("#tablaProductosAnadidosEditarCotizExcel tbody tr");
                var ref = tabla.length + 1;
                var num = ref;
                var columna0 = 0;
                var columna1 = 1;
                var columna2 = 2;
                var columna3 = 3;
                var columna4 = 4;
                var columna5 = 5;
                var columna6 = 6;
                // console.log(num);

                var htmlProdCotizEditar =
                "<tr fila='"+num+"'>"+
                    "<td class='clavesProductos' columna='"+columna0+"'>"+claveEditar+"</td>"+
                    "<td class='clavesSatProductos' columna='"+columna1+"'></td>"+
                    "<td class='desProductos' columna='"+columna2+"'>"+descripcionEditar+"</td>"+
                    "<td class='cantProductos' columna='"+columna3+"'>"+cantidadEditar+"</td>"+
                    "<td class='precioProductos' columna='"+columna4+"'>"+precioUnitarioEditar+"</td>"+
                    "<td class='totalImporteProductos' columna='"+columna5+"'>"+importeEditar+"</td>"+
                    "<td><button type='button' class='btn btn-outline-danger botonEliminar' onclick='eliminarProductoEditarExcel(this,"+importeEditar+", "+num+", "+columna0+")' style='width: 50%;'><img src='../iconos/eliminar.png' style='width: 20px;'></button><br><button type='button' class='btn btn-outline-warning botonEditarProducto' onclick='abrirPopupEditarCotizExcel("+cantidadEditar+", "+precioUnitarioEditar+", "+num+", "+columna0+", "+columna1+", "+columna2+", "+columna3+", "+columna4+", "+columna5+", "+columna6+");' style='width: 50%;'><img src='../iconos/editar.png' style='width: 20px;'></button><input type='hidden' class='totalProductosEditar' columna='"+columna6+"' value='"+importeEditar+"'/></td>"+
                    "<td class='idProductos' style='visibility:collapse; display:none;'></td>"+
                "</tr>";

                $(".prodCotizEditarCotizExcel").append(htmlProdCotizEditar);

                actualizarTotalCotizacionExcel();
            }

            showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
            $.ajax({
                method: "POST",
                url: "../backend/backend_cliente_mostrar.php",
                data: "",
                success:function(data){
                  var resultadoMostrar = JSON.parse(data);
                  if(resultadoMostrar["codigo"] == "fallo"){
                        // var resultados = resultadoMostrar["mensaje"];
                        // $(".texto-mensaje").text(resultados);
                        // $("#msj").modal("toggle");
                        closeMessageOverlay();
                    }
                    else if(resultadoMostrar["codigo"] == "exito"){
                        var resultados = resultadoMostrar["objetoRespuesta"]["cliente"];

                        var opcionesClientes = "<option value='-1' cliente='' rfc='' telefono=''>Clientes *</option>";

                        for (i = 0; i < resultados.length; i++) {
                            var resultadosTotales = resultados[i];
                            // console.log(resultadosTotales);
                            var nombreCliente   = resultadosTotales["cliente"];
                            var idCliente = resultadosTotales["idCliente"];
                            var rfcCliente = resultadosTotales["rfc"];
                            var telefonoCliente = resultadosTotales["telefono"];
                            // console.log(nombreCliente);

                            opcionesClientes += "<option value='"+idCliente+"' cliente='"+nombreCliente+"' rfc='"+rfcCliente+"' telefono='"+telefonoCliente+"'>"+nombreCliente+"</option>";
                        }
                        var htmlSelectClientesEditar =
                        "<label>Cliente Cotización</label>"+
                        "<select name='cliente_cotiz_editarCotizExcel' class='form-control' id='cliente_cotiz_editarCotizExcel'>"+opcionesClientes+"</select>";
                        $(".selectClienteEditarCotizExcel").html(htmlSelectClientesEditar);

                        $("#cliente_cotiz_editarCotizExcel option:contains("+clienteEditar+")").attr('selected', true);
                        closeMessageOverlay();
                    }
                }
            });

            var htmlCampoCondicionesEditar =
            "<label for='condiciones' style='font-size: 40px;'>CONDICIONES COMERCIALES</label>"+
            "<textarea class='form-control' name='condicionesEditarCotizExcel' id='condicionesEditarCotizExcel' rows='4'>"+condicionesEditar+"</textarea>";
            $(".condicionesEditarCotizExcel").html(htmlCampoCondicionesEditar);

            var htmlCampoFechaRegistroEditar =
            "<label>Fecha Registro</label>"+
            "<input type='date' name='fecha_editarCotizExcel' id='fecha_editarCotizExcel' class='form-control' value='"+fechaRegistroEditar+"'>";
            $(".fechaEditarCotizExcel").html(htmlCampoFechaRegistroEditar);

            // var htmlTotalEditar = moneda+totalEditar;
            
            // $(".totalCantidadProductosEditar").html(htmlTotalEditar);

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

                    var opcionesEmpresas = "<option value='-1' nombre=''>EMPRESA *</option>";

                    for (i = 0; i < resultados.length; i++) {
                        var resultadosTotales = resultados[i];
                        // console.log(resultadosTotales);
                        var idEmpresa = resultadosTotales["id_empresa"];
                        // var atencion = resultadosTotales["atencion"];
                        var empresa   = resultadosTotales["nombre"];
                        // var telefono  = resultadosTotales["telefono"];

                        opcionesEmpresas += "<option value='"+idEmpresa+"' nombre='"+empresa+"'>"+empresa+"</option>";
                    }
                    var htmlSelectEmpresas =
                    "<label>Empresa</label>"+
                    "<select name='empresa_cotiz_editar_excel' class='form-control' id='empresa_cotiz_editar_excel'>"+opcionesEmpresas+"</select>";
                    $(".selectEmpresaEditarCotizExcel").html(htmlSelectEmpresas);

                    // $("#empresa_cotiz_editar_excel option[value='"+ nombreEditar +"']").attr("selected",true);
                    $("#empresa_cotiz_editar_excel option:contains("+empresaEditar+")").attr('selected', true);

                    closeMessageOverlay();
                  }
                }
            });

            var htmlCampoTelefonoEditar =
            "<label>Teléfono</label>"+
            "<input type='text' name='campoTelefonoEditar' id='campoTelefonoEditar' class='form-control' value='"+telefonoEditar+"'>";
            $(".telefonoEditarCotizExcel").html(htmlCampoTelefonoEditar);

            var htmlBotonAgregarProducto =
            "<br>"+
            // "<label>Agregar Producto</label>"+
            "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacioneEditarExcel()' style='width: 100%;'><img src='../iconos/mas.png' style='width: 30px;'>Agregar Producto</button>";
            $(".botonAgregarProductoEditarCotizExcel").html(htmlBotonAgregarProducto);

            var htmlBotonActualizar =
            "<div class='text-center'>"+
                "<label>ACTUALIZAR</label>"+
            "</div>"+
            "<div class='text-center'>"+
                "<button type='button' class='btn btn-outline-success' onclick='actualizarDatosCotizacion(0);' style='width: 20%;'><img src='../iconos/actualizar.png' style='width: 40px;'></button>"+
            "</div>";
            $(".botonActualizarCotizExcel").html(htmlBotonActualizar);

            closeMessageOverlay();
          }
        }
      });
    }

    
}
//====================================================================================================

//FUNCION OBTENER DATOS PRODUCTOS=======================================================================
function agregarProductoCotizacioneEditarExcel(){

    $(".campoClaveProductoEditarCotizExcel").show();
    $(".campoDescripcionProductoEditarCotizExcel").show();
    $(".campoUnidadProductoEditarCotizExcel").show();
    $(".listaProductosEditarCotizExcel").show();
    $(".listaProductosClaveEditarCotizExcel").show();
    $(".botonCancelarProductoEditarCotizExcel").show();
    

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_productos_mostrar.php",
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
                resultadosTotales = resultadoMostrar["objetoRespuesta"]["productos"];
                // console.log(resultadosTotales);

                var opcionesListaProductos = "<option value='' data-unidad='' data-existencia='' data-clave='' data-sat='' data-descripcion='' data-id=''></option>";
                var opcionesListaProductosClave = "<option value=''  data-unidad='' data-existencia='' data-clave='' data-sat='' data-descripcion='' data-id=''></option>";
                var opcionesListaProductosClaveSat = "<option value=''  data-unidad='' data-existencia='' data-clave='' data-sat='' data-descripcion='' data-id=''></option>";


                for (i = 0; i < resultadosTotales.length; i++) {
                    var resultadosProductos = resultadosTotales[i];
                    // console.log(resultadosProductos);
                    var idProducto = resultadosProductos["idProducto"];
                    var claveProducto = resultadosProductos["clave"];
                    var claveSat = resultadosProductos["claveSat"];
                    var descripcionProducto   = resultadosProductos["descripcion"];
                    var existenciaProductos   = resultadosProductos["existencia"];
                    var unidadProductos   = resultadosProductos["unidad"];

                    opcionesListaProductos += "<option data-unidad='"+unidadProductos+"' data-existencia='"+existenciaProductos+"' data-clave='"+claveProducto+"' data-sat='"+claveSat+"' data-descripcion='"+descripcionProducto+"' data-id='"+idProducto+"' value='"+descripcionProducto+"'>"+claveSat+"</option>";

                    opcionesListaProductosClaveSat += "<option data-unidad='"+unidadProductos+"' data-existencia='"+existenciaProductos+"' data-clave='"+claveProducto+"' data-sat='"+claveSat+"' data-id='"+idProducto+"' data-descripcion='"+descripcionProducto+"' value='"+claveSat+"'>"+descripcionProducto+"</option>";

                }
                var htmlDivListasProductos =
                "<label for='selección'>Buscar Productos:</label>"+
                "<input list='lista' name='claveDelParámetro' id='selecciónEditar' class='form-control' onchange='selectProductosCombinarEditarExcel(this, 0);'>"+

                "<datalist id='lista'>"+opcionesListaProductos+"</datalist>";
                $(".listaProductosEditarCotizExcel").html(htmlDivListasProductos);

                var htmlDivListasProductosClave =
                "<label for='selección'>Buscar Productos por clave:</label>"+
                "<input list='listaClave' name='claveDelParámetros' id='selecciónClaveEditar' class='form-control' onchange='selectProductosCombinarClaveEditarExcel(this, 0);'>"+

                "<datalist id='listaClave'>"+opcionesListaProductosClave+"</datalist>";
                $(".listaProductosClaveEditarCotizExcel").html(htmlDivListasProductosClave);

                var htmlDivListasProductosClaveSat =
                "<label for='seleccionClave'>Buscar Clave SAT:</label>"+
                "<input type='text' list='listaClaveSat' name='claveDelParámetroSat' id='seleccionClave' class='form-control' onchange='selectProductosCombinarClaveSat(this, 0);'>"+

                "<datalist id='listaClaveSat'>"+opcionesListaProductosClaveSat+"</datalist>";
                $(".listaProductosClaveSatEditarCotizExcel").html(htmlDivListasProductosClaveSat);

                var htmlBotonCancelarProducto =
                "<br>"+
                "<button class='btn btn-outline-danger' type='button' onclick='cancelarProductoCotizacioneEditarExcel()' style='width: 100%;'><img src='../iconos/desactivado.png' style='width: 30px;'>Cancelar</button>";
                $(".botonCancelarProductoEditarCotizExcel").html(htmlBotonCancelarProducto);

                var htmlDescripcionProductoEditar = 
                "<label>Descripción Producto</label>"+
                "<textarea class='form-control' name='descProducto' id='descProducto' rows='4' onchange='selectProductosCombinar(this, 1)'></textarea>";
                $(".campoDescripcionProductoEditarCotizExcel").html(htmlDescripcionProductoEditar);

                var htmlCampoCantidadEditar =
                "<label for='cantidad'>Cantidad</label>"+
                "<input type='text' id='cantidadProductoEditar' class='form-control' onKeypress='soloNumeros(this);' placeholder='Ingresa cantidad'>";
                $(".campoCantidadEditarCotizExcel").html(htmlCampoCantidadEditar);

                var htmlCampoPrecioditar =
                "<label for='importe'>Precio de lista</label>"+
                "<input type='text' id='precioListaEditar' class='form-control' onKeypress='soloNumeros(this);' placeholder='Ingresa importe'>";
                $(".campoPrecioListaEditarCotizExcel").html(htmlCampoPrecioditar);

                obtener_unidad_clave_sat_editar();
                obtener_datos_unidades_editar();
                closeMessageOverlay();
            }
        }
    });
}
//====================================================================================================

//FUNCION OBTENER DATOS PROVEEDORES Y FOLIOS==========================================================
function obtener_unidad_clave_sat_editar(){
    var lista = document.querySelectorAll("#listaClaveSat");

    for (var lis of lista) {
        var listaResultados=lis.querySelectorAll("option");
        // console.log(listaResultados);
        var valorUnidad = listaResultados[1].value;
        // console.log(valorUnidad);
        $("#seleccionClave").val(valorUnidad);
    }
    var idUni = $("#listaClaveSat").val(valorUnidad);

    var resultadoUnidad = $("#listaClaveSat").val();

    var selectIdUnidad = $('#listaClaveSat').find('option[value="'+resultadoUnidad+'"]').data('id');
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS===============================================================
function obtener_datos_unidades_editar(){
    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_unidad_medida_mostrar.php",
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
                resultadosTotales = resultadoMostrar["objetoRespuesta"]["unidades"];
                // console.log(resultadosTotales);

                var opcionesListaUnidades = "<option value=''></option>";

                for (i = 0; i < resultadosTotales.length; i++) {
                    var resultadosUnidades = resultadosTotales[i];
                    // console.log(resultadosUnidades);
                    var idUnidad = resultadosUnidades["idUnidad"];
                    var unidadSat = resultadosUnidades["unidadSat"];
                    var unidad = resultadosUnidades["unidad"];

                    opcionesListaUnidades += "<option data-unidad='"+unidad+"' data-unidadsat='"+unidadSat+"' data-idunidad='"+idUnidad+"' value='"+unidad+"'>"+idUnidad+"</option>";
                    // console.log(opcionesListaUnidades);
                }

                var htmlDivListasUnidadSat =
                "<label for='seleccionUnidad'>Unidad SAT:</label>"+
                "<input type='text' list='listaUnidadSat' name='unidadesSat' id='seleccionUnidad' class='form-control'onchange='selectProductosCombinarUnidadEditar(this);'>"+

                "<datalist id='listaUnidadSat'>"+opcionesListaUnidades+"</datalist>";
                $(".listaUnidadProductoEditarCotizExcel").html(htmlDivListasUnidadSat);

                obtener_unidad_pieza_editar();
            }
        }
    });
    closeMessageOverlay();
}
//====================================================================================================

//FUNCION OBTENER DATOS PROVEEDORES Y FOLIOS==========================================================
function obtener_unidad_pieza_editar(){
    var lista = document.querySelectorAll("#listaUnidadSat");
    

    for (var lis of lista) {
        var listaResultados=lis.querySelectorAll("option");
        
        var valorUnidad = listaResultados[1070].value;
        $("#seleccionUnidad").val(valorUnidad);
    }

    var idUni = $("#listaUnidadSat").val(valorUnidad);

    var resultadoUnidad = $("#listaUnidadSat").val();

    idUnidadesTodos = $('#listaUnidadSat').find('option[value="'+resultadoUnidad+'"]').data('idunidad');
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS=========================================================================
function selectProductosCombinarUnidadEditar(e){
    unidadProductoLista = $(e).val();

    var lista = document.querySelectorAll("#listaClaveSat");
    for (var lis of lista) {
        var listaResultados=lis.querySelectorAll("option");
        var valorUnidad = listaResultados[1].value;
        $("#seleccionClave").val(valorUnidad);
    }
    var idUni = $("#listaClaveSat").val(valorUnidad);
    var resultadoUnidad = $("#listaClaveSat").val();
    var selectIdUnidad = $('#listaClaveSat').find('option[value="'+resultadoUnidad+'"]').data('id');


    var unirDescripcion = $("#descProducto").val();
    var desProductos = $("#selecciónEditar").val();
    var descripcionNuevaUnidad = $("#descProducto").val(unirDescripcion+ "|" +unidadProductoLista);
    var unirProductos = $("#selecciónEditar").val(desProductos+ "|" +unidadProductoLista);

    descripcionProductosSeleccionada = $("#descProducto").val();

    idProductoLista = $('#lista').find('option[value="'+descripcionProductosSeleccionada+'"]').data('id');

    if (idProductoLista == undefined) {
        $("#selecciónClaveEditar").val("");
    }


    var htmlBotonAgregarProducto =
    "<br>"+
    "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacionEditarGeneral("+idProductoLista+")' style='width: 100%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'>Agregar Producto</button>";
    $(".botonAgregarProductoNuevoEditarCotizExcel").html(htmlBotonAgregarProducto);
    
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS===============================================================
function selectProductosCombinarEditarExcel(e, operacion){
    descripcionProductosSeleccionada = $(e).val();
    if (operacion == 0) {
        claveProducto = $('#lista').find('option[value="'+descripcionProductosSeleccionada+'"]').data('clave');
        claveProductoSatGlobal = $('#lista').find('option[value="'+descripcionProductosSeleccionada+'"]').data('sat');
        idProductoLista = $('#lista').find('option[value="'+descripcionProductosSeleccionada+'"]').data('id');
        existenciaProductoLista = $('#lista').find('option[value="'+descripcionProductosSeleccionada+'"]').data('existencia');
        unidadProductoLista = $('#lista').find('option[value="'+descripcionProductosSeleccionada+'"]').data('unidad');

        if (idProductoLista == undefined) {
            $("#selecciónClaveEditar").val("");
            $("#descProducto").val(descripcionProductosSeleccionada);
            obtener_unidad_pieza_editar();
            obtener_unidad_clave_sat_editar();
        }else{
            $("#seleccionClave").val(claveProductoSatGlobal);
            $("#seleccionUnidad").val(unidadProductoLista);
            $("#selecciónClaveEditar").val(claveProducto);
            $("#descProducto").val(descripcionProductosSeleccionada);
            $("#seleccion").val(descripcionProductosSeleccionada);
        }
    }
    else if (operacion == 1) {
        idProductoLista = $('#lista').find('option[value="'+descripcionProductosSeleccionada+'"]').data('id');

        if (idProductoLista == undefined) {
            $("#seleccion").val(descripcionProductosSeleccionada);
            $("#selecciónClaveEditar").val("");
            obtener_unidad_pieza_editar();
            obtener_unidad_clave_sat_editar();
        }
    }

    var htmlBotonAgregarNuevoProducto =
    "<br>"+
    // "<label>Agregar Producto</label>"+
    "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacionEditarExcel("+idProductoLista+")' style='width: 100%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'>Agregar Producto</button>";
    $(".botonAgregarProductoNuevoEditarCotizExcel").html(htmlBotonAgregarNuevoProducto);

}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS===============================================================
function selectProductosCombinarClaveEditarExcel(e, operacion){
    claveProducto = $(e).val();
    if (operacion == 0) {

        descripcionProductosSeleccionada = $('#listaClave').find('option[value="'+claveProducto+'"]').data('descripcion');
        idProductoLista = $('#listaClave').find('option[value="'+claveProducto+'"]').data('id');
        claveProductoSatGlobal = $('#listaClave').find('option[value="'+claveProducto+'"]').data('sat');
        existenciaProductoLista = $('#listaClave').find('option[value="'+claveProducto+'"]').data('existencia');
        unidadProductoLista = $('#listaClave').find('option[value="'+claveProducto+'"]').data('unidad');

        if (idProductoLista == undefined) {
                // $("#descProducto").val(descripcionProductosSeleccionada);
                console.log(idProductoLista);
            }else{
                $("#seleccionClave").val(claveProductoSatGlobal);
                $("#seleccionUnidad").val(unidadProductoLista);
                $("#descProducto").val(descripcionProductosSeleccionada);
                $("#seleccion").val(descripcionProductosSeleccionada);
            }
        }
    else if (operacion == 1) {
        idProductoLista = $('#listaClave').find('option[value="'+descripcionProductosSeleccionada+'"]').data('id');
        // console.log(idProductoLista);
        if (idProductoLista == undefined) {
            $("#seleccion").val(descripcionProductosSeleccionada);
            $("#selecciónClaveEditar").val("");
        }
    }

    var htmlBotonAgregarNuevoProducto =
    "<br>"+
    "<label>Agregar Producto</label>"+
    "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacionEditarExcel("+idProductoLista+")' style='width: 30%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'></button>";
    $(".botonAgregarProductoNuevoEditarCotizExcel").html(htmlBotonAgregarNuevoProducto);
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS=========================================================================
function selectProductosCombinarClaveSat(e, operacion){
    claveProductoSatGlobal = $(e).val();
    // console.log(claveProductoSatGlobal);

    if (operacion == 0) {
        descripcionProductosSeleccionada = $('#listaClaveSat').find('option[value="'+claveProductoSatGlobal+'"]').data('descripcion');
        idProductoLista = $('#listaClaveSat').find('option[value="'+claveProductoSatGlobal+'"]').data('id');
        claveProductoSatGlobal = $('#listaClaveSat').find('option[value="'+claveProducto+'"]').data('sat');
        existenciaProductoLista = $('#listaClaveSat').find('option[value="'+claveProductoSatGlobal+'"]').data('existencia');
        unidadProductoLista = $('#listaClaveSat').find('option[value="'+claveProductoSatGlobal+'"]').data('unidad');
        claveProducto = $('#listaClaveSat').find('option[value="'+claveProductoSatGlobal+'"]').data('clave');

        if (idProductoLista == undefined) {
            $("#unidad_producto").val("");
            $("#clave_producto").val("");
            $("#descProducto").val("");
        }else{
            // $("#seleccionClave").val(claveProductoSatGlobal);
            $("#seleccionUnidad").val(unidadProductoLista);
            $("#clave_producto").val(claveProducto);
            $("#descProducto").val(descripcionProductosSeleccionada);
            $("#seleccion").val(descripcionProductosSeleccionada);
        }
    }
    else if (operacion == 1) {
        idProductoLista = $('#listaClaveSat').find('option[value="'+descripcionProductosSeleccionada+'"]').data('id');
        // console.log(idProductoLista);
        if (idProductoLista == undefined) {
            $("#seleccion").val(descripcionProductosSeleccionada);
            $("#clave_producto").val("");
        }
    }


    var htmlBotonAgregarProducto =
    "<br>"+
    "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacionEditarGeneral("+idProductoLista+")' style='width: 100%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'>Agregar Producto</button>";
    $(".botonAgregarProductoNuevoEditarCotizExcel").html(htmlBotonAgregarProducto);
    
}
//====================================================================================================

//FUNCION OCULTAR DATOS INPUT PRODUCTOS===============================================================
function cancelarProductoCotizacioneEditarExcel(){
    $(".campoClaveProductoEditarCotizExcel").hide();
    $(".campoDescripcionProductoEditarCotizExcel").hide();
    $(".campoUnidadProductoEditarCotizExcel").hide();
    $(".listaProductosEditarCotizExcel").hide();
    $(".listaProductosClaveEditarCotizExcel").hide();
    $(".botonCancelarProductoEditarCotizExcel").hide();
    $(".campoCantidadEditarCotizExcel").hide();
    $(".precioListaEditarCotizExcel").hide();
    $(".botonAgregarProductoNuevoEditarCotizExcel").hide();

    $("#clave_producto_editar").val("");
    $("#descProductoEditar").val("");
    $("#unidad_producto_editar").val("");
    $("#selecciónEditar").val("");
    $("#selecciónClaveEditar").val("");
    $("#cantidadProductoEditar").val("");
    $("#precioListaEditarCotizExcel").val("");
}
//====================================================================================================

// //FUNCION AGREGAR NUEVO PRODUCTOS=======================================================================
function agregarProductoCotizacionEditarExcel(idProductoLista){

    var precioLista = $("#precioListaEditarCotizExcel").val();
    var catidadProducto = $("#cantidadProductoEditar").val();

    if (catidadProducto == "") {
        $(".texto-mensaje").text("La cantidad es obligatorio");
        $("#msj").modal("toggle");
        return false;
    }

    if (precioLista == "") {
        $(".texto-mensaje").text("El precio es obligatorio");
        $("#msj").modal("toggle");
        return false;
    }

    var total = 0;

    total = catidadProducto;
    var importe = total * precioLista;

   var htmlProdCotizEditarInsertar =
    "<tr class='productosAgregadosCotizEditar' posicion='"+contadorProductos+"'>"+
        "<td class='clavesProductos' posicion='"+contadorProductos+"'>"+claveProducto+"</td>"+
        "<td class='clavesSatProductos' posicion='"+contadorProductos+"'>"+claveProductoSatGlobal+"</td>"+
        "<td class='desProductos' posicion='"+contadorProductos+"'>"+descripcionProductosSeleccionada+"</td>"+
        "<td class='cantProductos' posicion='"+contadorProductos+"'>"+catidadProducto+"</td>"+
        "<td class='precioProductos' posicion='"+contadorProductos+"'>"+precioLista+"</td>"+
        "<td class='totalImporteProductos' posicion='"+contadorProductos+"'>"+importe+"</td>"+
        "<td><button type='button' class='btn btn-outline-danger botonEliminar' onclick='eliminarProductoNvoEditarGeneral(this, "+idProductoLista+","+importe+")' style='width: 50%;'><img src='../iconos/eliminar.png' style='width: 20px;'></button><br><input type='hidden' class='totalProductosEditar' value='"+importe+"'/></td>"+
        "<td class='idProductos' style='visibility:collapse; display:none;' posicion='"+contadorProductos+"'>"+idProductoLista+"</td>"+
    "</tr>";
    $(".prodCotizEditarCotizGeneral").append(htmlProdCotizEditarInsertar);

    contadorProductos++;

    actualizarTotalCotizacionExcel();

    $("#seleccionEditar").val("");
    $("#selecciónClaveEditar").val("");
    $("#unidad_producto_editar").val("");
    $("#clave_producto_editar").val("");
    $("#descProductoEditar").val("");
    $("#cantidadProductoEditar").val("");
    $("#precioListaEditarCotizExcel").val("");

    obtener_unidad_clave_sat_editar();
    obtener_datos_unidades_editar();

}
//====================================================================================================

//FUNCION ELIMINAR PRODUCTO NUEVO===========================================================================
function eliminarProductoNvoEditarExcel(valor, idProducto, importe){
    var total = $(".cantidadTotalEditarCotizExcel").val();

    var eliminarProd = total - importe;
    $(".totalCantidadProductosEditarCotizExcel").text(moneda+eliminarProd.toFixed(2));
    valor.closest('tr').remove();

}
//====================================================================================================

//FUNCION ELIMINAR PRODUCTO DE BASE===========================================================================
function eliminarProductoEditarExcel(valor, importe, num, columna0){
    var total = $(".cantidadTotalEditarCotizExcel").val();

    if ((num >= 1) && (columna0 == 0)){
        celdas = document.getElementById('tablaProductosAnadidosEditarCotizExcel').rows[num].cells;
        claveProductoElim = celdas[columna0].innerText;
        // console.log(claveProducto);
    }

    var eliminarProd = total - importe;
    $(".totalCantidadProductosEditarCotizExcel").text(moneda+eliminarProd.toFixed(2));
    valor.closest('tr').remove();
    actualizarDatosCotizacion(1);
}
//====================================================================================================

//FUNCION ACTUALIZAR DATOS TABLA==========================================================================
function actualizarProductosExcel(e){
    cantidad = $("#cantidadEditarCotizExcel").val();
    precioUnitario  = $("#precioUnitarioEditarCotizExcel").val();
    descripcionExcel = $("#descripcionEditarCotizExcel").val();
    claveProdExcel = $("#claveEditarCotizExcel").val();
    // console.log(claveProdExcel);
    importe = cantidad * precioUnitario;

    if ((fila >= 1) && (col0 == 0) && (col2 == 2) && (col3 == 3) && (col4 == 4) && (col5 == 5) && (col6 == 6)) {
    celdas = document.getElementById('tablaProductosAnadidosEditarCotizExcel').rows[fila].cells;
    

    celdas[col0].innerHTML = claveProdExcel;
    celdas[col2].innerHTML = descripcionExcel;
    celdas[col3].innerHTML = cantidad;
    celdas[col4].innerHTML = precioUnitario;
    celdas[col5].innerHTML = importe;


    var inputTotal =  celdas[col6];
    var totalInp = inputTotal.querySelectorAll("input");
    var totalCotiz = totalInp[0].value = importe;
    
    actualizarTotalCotizacionExcel();
  }
}
//====================================================================================================

//FUNCION SUMAR IMPORTE MOSTRAR TOTAL===========================================================================
function actualizarTotalCotizacionExcel(){
    var total = 0;
    
    $('.totalProductosEditar').each(function(){
        if (!isNaN($(this).val())) {
          total += Number($(this).val());
          $(".totalCantidadProductosEditarCotizExcel").text(moneda+total.toLocaleString('es-MX'));
          $(".cantidadTotalEditarCotizExcel").val(total);
        }else{alert("si es nan");}
    });
}
//====================================================================================================

//FUNCION ACTUALIZAR DATOS PRODUCTO===========================================================================
function actualizarDatosCotizacion(operacion){

    $(".productosAgregadosCotizEditar").each(function(){
        var posicion = $(this).attr("posicion");
        
        var claveProd = $(".clavesProductos"+"[posicion='"+posicion+"']").text();
        var descripcionProd = $(".desProductos"+"[posicion='"+posicion+"']").text();
        var cantidadProducto = $(".cantProductos"+"[posicion='"+posicion+"']").text();
        var totalImporte = $(".precioProductos"+"[posicion='"+posicion+"']").text();

        var jsonTempProductosAgregados = {
          "clave": claveProd,
          "descripcion": descripcionProd,
          "cantidad": cantidadProducto,
          "importe": totalImporte
        }

        productosTotalEditar.push(jsonTempProductosAgregados);

    });


    var actualizar = 1;
    var idCotizacionExcel = $("#cotizEncontradaImprimirCotizExcel option:selected").val();
    var cantidadNueva = cantidad;
    var precioUnitarioNueva = precioUnitario;
    var descripcionProd = descripcionExcel;
    var claveProducto = claveProdExcel;
    var idUsuarioEdit = <?=$idUsuario;?>;
    var empresaEditar = $("#empresa_cotiz_editar_excel option:selected").attr("nombre");
    var fechaEditar = $("#fecha_editarCotizExcel").val();
    var clienteEditar = $("#cliente_cotiz_editarCotizExcel option:selected").attr("cliente");
    var totalTablaEditar =$(".cantidadTotalEditarCotizExcel").val();
    var condisionesEditar = $("#condicionesEditarCotizExcel").val();
    var telefonoEditar = $("#campoTelefonoEditar").val();
    var productosArrayEditar = productosTotalEditar;


    if (tipoExcel == 0) {
        if (operacion == 0) {
            eliminado = 0;//
            actualizar;
            idCotizacionExcel;
            cantidadNueva;
            precioUnitarioNueva;
            descripcionProd;
            claveProducto;
            idUsuarioEdit;
            empresaEditar;
            fechaEditar;
            clienteEditar;
            totalTablaEditar;
            condisionesEditar;
            telefonoEditar;
            productosArrayEditar;

            var jsonData = {
                "idUsuario" : idUsuarioEdit,
                "idCotizacionExcelUnica" : idCotizacionExcel,
                "fecha_registro" : fechaEditar,
                "empresa" : empresaEditar,
                "cliente" : clienteEditar,
                "telefono" : telefonoEditar,
                "condiciones" : condisionesEditar,
                "productos" : JSON.stringify(productosArrayEditar),
                "actualizar" : actualizar,
                "clave" : claveProducto,
                "eliminado" : eliminado,
                "descripcion" : descripcionProd,
                "cantidad" : cantidadNueva,
                "precioUnitario" : precioUnitarioNueva
            }
            
        }
        else if (operacion == 1){
            eliminado = 1;
            actualizar;
            idCotizacionExcel;
            claveProductoElim;
            idUsuarioEdit;

            var jsonData = {
                "idUsuario" : idUsuarioEdit,
                "idCotizacionExcelUnica" : idCotizacionExcel,
                "actualizar" : actualizar,
                "clave" : claveProductoElim,
                "eliminado" : eliminado
            }

        }

        showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
        $.ajax({
            method: "POST",
            url: "../backend/backend_cotizacion_excel_unica_actualizar.php",
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
                    // console.log(resultados);
                    $(".texto-mensaje").text(resultados);
                    $("#msjRec").modal("toggle");
                    limpiarCampos();
                    closeMessageOverlay();
                }
            }
        });
    }
    else if(tipoExcel == 1){
        if (operacion == 0) {
            eliminado = 0;//
            actualizar;
            idCotizacionExcel;
            cantidadNueva;
            precioUnitarioNueva;
            descripcionProd;
            claveProducto;
            idUsuarioEdit;
            empresaEditar;
            fechaEditar;
            clienteEditar;
            totalTablaEditar;
            condisionesEditar;
            telefonoEditar;
            productosArrayEditar;

            var jsonData = {
                "idUsuario" : idUsuarioEdit,
                "idCotizacionExcel" : idCotizacionExcel,
                "fecha_registro" : fechaEditar,
                "empresa" : empresaEditar,
                "cliente" : clienteEditar,
                "telefono" : telefonoEditar,
                "condiciones" : condisionesEditar,
                "productos" : JSON.stringify(productosArrayEditar),
                "actualizar" : actualizar,
                "clave" : claveProducto,
                "eliminado" : eliminado,
                "descripcion" : descripcionProd,
                "cantidad" : cantidadNueva,
                "precioUnitario" : precioUnitarioNueva
            }
            
        }
        else if (operacion == 1){
            eliminado = 1;
            actualizar;
            idCotizacionExcel;
            claveProductoElim;
            idUsuarioEdit;

            var jsonData = {
                "idUsuario" : idUsuarioEdit,
                "idCotizacionExcel" : idCotizacionExcel,
                "actualizar" : actualizar,
                "clave" : claveProductoElim,
                "eliminado" : eliminado
            }

        }

        showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
        $.ajax({
            method: "POST",
            url: "../backend/backend_cotizacion_excel_actualizar.php",
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
                    // console.log(resultados);
                    $(".texto-mensaje").text(resultados);
                    $("#msjRec").modal("toggle");
                    limpiarCampos();
                    closeMessageOverlay();
                }
            }
        });
    }
}
//====================================================================================================

//EVENTO READY========================================================================================
$(document).ready(function(){
    descripcionProductosSeleccionada = "";
    claveProducto = "";
    idProductoLista = "";
    existenciaProductoLista = "";
    unidadProductoLista = "";
    moneda = "TOTAL $";
    productosTotalEditar = new Array();
    productosTabla = new Array();
    celdas = "";
    eliminado = 0
    cantidad = "";
    precioUnitario = "";
    descripcionExcel = "";
    claveProdExcel = "";
    importe = "";
    claveProductoElim = "";
    tipoExcel = "";
    claveProductoSatGlobal = "";
    contadorProductos = 0;
});
//====================================================================================================

//FUNCION OBTENER FOLIOS=======================================================================
function selectFoliosEditarExcelUnica(){

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_cotizacion_excel_unica_mostrar_todas.php",
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
                var resultados = resultadoMostrar["objetoRespuesta"]["cotizaciones_excel_unica"];
                // console.log(resultados);
                var opcionesCotizacionExcelEditar = "<option value='-1' cliente='' empresa='' fecha='' telefono=''>Cotizaciones *</option>";

                for (i = 0; i < resultados.length; i++) {
                    var resultadosTotales = resultados[i];
                    // console.log(resultadosTotales);
                    var idCotizacionExcel = resultadosTotales["idCotizacionExcel"];
                    var cliente           = resultadosTotales["cliente"];
                    var condiciones       = resultadosTotales["condiciones"];
                    var empresa           = resultadosTotales["empresa"];
                    var fecha_registro    = resultadosTotales["fecha_registro"];
                    var telefono          = resultadosTotales["telefono"];

                    opcionesCotizacionExcelEditar += "<option value='"+idCotizacionExcel+"' cliente='"+cliente+"' empresa='"+empresa+"' fecha='"+fecha_registro+"' telefono='"+telefono+"'>COT00"+idCotizacionExcel+"</option>";
                }
                var htmlSelectCotizacionesProveedor =
                "<label>Cotizaciones Encontradas</label>"+
                "<select name='cotizEncontradaImprimirCotizExcel' class='form-control' id='cotizEncontradaImprimirCotizExcel' onchange='obtener_datos_cotizaciones_editar_excel(0);'>"+opcionesCotizacionExcelEditar+"</select>";
                $(".selectCotizEncontradasEditarCotizExcel").html(htmlSelectCotizacionesProveedor);

                closeMessageOverlay();
            }
        }
    });

}
//====================================================================================================
</script>
