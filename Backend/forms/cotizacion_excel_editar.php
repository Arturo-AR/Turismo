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
            <div class="col-lg-5 listaProductosEditarCotizExcel"></div>
            <div class="col-lg-5 listaProductosClaveEditarCotizExcel"></div>
            <div class="col-lg-2 botonCancelarProductoEditarCotizExcel"></div>
        </div>
        <div class="row">
            <div class="col-lg-3 campoUnidadProductoEditarCotizExcel"></div>
            <div class="col-lg-2 campoClaveProductoEditarCotizExcel"></div>
            <div class="col-lg-3 campoDescripcionProductoEditarCotizExcel"></div>
        </div>
        <div class="row">
            <div class="col-lg-2 campoCantidadEditarCotizExcel"></div>
            <div class="col-lg-2 precioListaEditarCotizExcel"></div>
            <div class="col-lg-2 botonAgregarProductoNuevoEditarCotizExcel"></div>
        </div> 
        <div class="table-responsive" id="tablaCotizEditProdCotizExcel">
            <table class="table table-primary bg-light tablaProductosTotalEditarCotizExcel" id="tablaProductosAnadidosEditarCotizExcel">
                <thead>
                    <tr>
                        <th>Clave</th>
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
                // console.log(num);

                var htmlProdCotizEditar =
                "<tr fila='"+num+"'>"+
                    "<td class='clavesProductos' columna='"+columna0+"'>"+claveEditar+"</td>"+
                    "<td class='desProductos' columna='"+columna1+"'>"+descripcionEditar+"</td>"+
                    "<td class='cantProductos' columna='"+columna2+"'>"+cantidadEditar+"</td>"+
                    "<td class='precioProductos' columna='"+columna3+"'>"+precioUnitarioEditar+"</td>"+
                    "<td class='totalImporteProductos' columna='"+columna4+"'>"+importeEditar+"</td>"+
                    "<td><button type='button' class='btn btn-outline-danger botonEliminar' onclick='eliminarProductoEditarExcel(this,"+importeEditar+", "+num+", "+columna0+")' style='width: 50%;'><img src='../iconos/eliminar.png' style='width: 20px;'></button><br><button type='button' class='btn btn-outline-warning botonEditarProducto' onclick='abrirPopupEditarCotizExcel("+cantidadEditar+", "+precioUnitarioEditar+", "+num+", "+columna0+", "+columna1+", "+columna2+", "+columna3+", "+columna4+", "+columna5+");' style='width: 50%;'><img src='../iconos/editar.png' style='width: 20px;'></button><input type='hidden' class='totalProductosEditar' columna='"+columna5+"' value='"+importeEditar+"'/></td>"+
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
                // console.log(num);

                var htmlProdCotizEditar =
                "<tr fila='"+num+"'>"+
                    "<td class='clavesProductos' columna='"+columna0+"'>"+claveEditar+"</td>"+
                    "<td class='desProductos' columna='"+columna1+"'>"+descripcionEditar+"</td>"+
                    "<td class='cantProductos' columna='"+columna2+"'>"+cantidadEditar+"</td>"+
                    "<td class='precioProductos' columna='"+columna3+"'>"+precioUnitarioEditar+"</td>"+
                    "<td class='totalImporteProductos' columna='"+columna4+"'>"+importeEditar+"</td>"+
                    "<td><button type='button' class='btn btn-outline-danger botonEliminar' onclick='eliminarProductoEditarExcel(this,"+importeEditar+", "+num+", "+columna0+")' style='width: 50%;'><img src='../iconos/eliminar.png' style='width: 20px;'></button><br><button type='button' class='btn btn-outline-warning botonEditarProducto' onclick='abrirPopupEditarCotizExcel("+cantidadEditar+", "+precioUnitarioEditar+", "+num+", "+columna0+", "+columna1+", "+columna2+", "+columna3+", "+columna4+", "+columna5+");' style='width: 50%;'><img src='../iconos/editar.png' style='width: 20px;'></button><input type='hidden' class='totalProductosEditar' columna='"+columna5+"' value='"+importeEditar+"'/></td>"+
                    "<td class='idProductos' style='visibility:collapse; display:none;'></td>"+
                "</tr>";

                $(".prodCotizEditarCotizExcel").append(htmlProdCotizEditar);

                var trs=document.querySelectorAll("#tablaProductosAnadidosEditarCotizExcel tbody tr").forEach(function(e){
                    produAgreNvo = {
                        descripcion: e.querySelector('.desProductos').innerText,
                        precioUnitario: e.querySelector('.precioProductos').innerText,
                        cantidad: e.querySelector('.cantProductos').innerText,
                        importe: e.querySelector('.totalImporteProductos').innerText,
                        // idProducto: e.querySelector('.idProductos').innerText
                    };
                });
                productosTabla.push(produAgreNvo);
                // console.log(productosTabla);

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

                var opcionesListaProductos = "<option value='-1'>Buscar Productos ...</option>";
                var opcionesListaProductosClave = "<option value='-1'>Buscar Productos Por Clave ...</option>";

                for (i = 0; i < resultadosTotales.length; i++) {
                    var resultadosProductos = resultadosTotales[i];
                    // console.log(resultadosProductos);
                    var idProducto = resultadosProductos["idProducto"];
                    var claveProducto = resultadosProductos["clave"];
                    var descripcionProducto   = resultadosProductos["descripcion"];
                    var existenciaProductos   = resultadosProductos["existencia"];
                    var unidadProductos   = resultadosProductos["unidad"];

                    opcionesListaProductosClave += "<option data-unidad='"+unidadProductos+"' data-existencia='"+existenciaProductos+"' data-descripcion='"+descripcionProducto+"' data-id='"+idProducto+"' value='"+claveProducto+"'>"+descripcionProducto+"</option>";

                    opcionesListaProductos += "<option data-unidad='"+unidadProductos+"' data-existencia='"+existenciaProductos+"' data-clave='"+claveProducto+"' data-id='"+idProducto+"' value='"+descripcionProducto+"'>"+claveProducto+"</option>";

                }
                var htmlDivListasProductos =
                "<label for='selección'>Buscar Productos:</label>"+
                "<input list='lista' name='claveDelParámetro' id='selecciónEditar' class='form-control' onchange='selectProductosCombinarEditarExcel(this);'>"+

                "<datalist id='lista'>"+opcionesListaProductos+"</datalist>";
                $(".listaProductosEditarCotizExcel").html(htmlDivListasProductos);

                var htmlDivListasProductosClave =
                "<label for='selección'>Buscar Productos por clave:</label>"+
                "<input list='listaClave' name='claveDelParámetros' id='selecciónClaveEditar' class='form-control' onchange='selectProductosCombinarClaveEditarExcel(this);'>"+

                "<datalist id='listaClave'>"+opcionesListaProductosClave+"</datalist>";
                $(".listaProductosClaveEditarCotizExcel").html(htmlDivListasProductosClave);

                var htmlBotonCancelarProducto =
                "<br>"+
                "<button class='btn btn-outline-danger' type='button' onclick='cancelarProductoCotizacioneEditarExcel()' style='width: 100%;'><img src='../iconos/desactivado.png' style='width: 30px;'>Cancelar</button>";
                $(".botonCancelarProductoEditarCotizExcel").html(htmlBotonCancelarProducto);

                closeMessageOverlay();
            }
        }
    });
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS===============================================================
function selectProductosCombinarEditarExcel(e){
    descripcionProductosSeleccionada = $(e).val();
    
    claveProducto = $('#lista').find('option[value="'+descripcionProductosSeleccionada+'"]').data('clave');
    idProductoLista = $('#lista').find('option[value="'+descripcionProductosSeleccionada+'"]').data('id');
    existenciaProductoLista = $('#lista').find('option[value="'+descripcionProductosSeleccionada+'"]').data('existencia');
    unidadProductoLista = $('#lista').find('option[value="'+descripcionProductosSeleccionada+'"]').data('unidad');

    var htmlCampoClaveProducto =
    "<label for='clave_producto'>Clave</label>"+
    "<input type='text' name='clave_producto_editar' id='clave_producto_editar' class='form-control' value='"+claveProducto+"'>";
    $(".campoClaveProductoEditarCotizExcel").html(htmlCampoClaveProducto);

    var htmlCampoDescripcionProducto =
    "<label>Descripción</label>"+
    "<input type='text' name='descProductoEditar' id='descProductoEditar' class='form-control' value='"+descripcionProductosSeleccionada+"'>";
    $(".campoDescripcionProductoEditarCotizExcel").html(htmlCampoDescripcionProducto);

    var htmlCampoUnidadProducto =
    "<label for='clave_producto'>Unidad</label>"+
    "<input type='text' name='unidad_producto_editar' id='unidad_producto_editar' class='form-control' value='"+unidadProductoLista+"'>";
    $(".campoUnidadProductoEditarCotizExcel").html(htmlCampoUnidadProducto);

    var htmlCampoCantidadProductosEditar =
    "<label>Cantidad</label>"+
    "<input type='text' id='cantidadProductoEditar' class='form-control' onKeypress='soloNumeros(this);' placeholder='Ingresa cantidad'>";
    $(".campoCantidadEditarCotizExcel").html(htmlCampoCantidadProductosEditar);

    var htmlCampoPrecioProductosEditar =
    "<label>Precio de lista</label>"+
    "<input type='text' id='precioListaEditarCotizExcel' class='form-control' onKeypress='soloNumeros(this);' style='text-align: right;' placeholder='Ingresa importe'>";
    $(".precioListaEditarCotizExcel").html(htmlCampoPrecioProductosEditar);

    var htmlBotonAgregarNuevoProducto =
    "<br>"+
    // "<label>Agregar Producto</label>"+
    "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacionEditarExcel("+idProductoLista+")' style='width: 100%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'>Agregar Producto</button>";
    $(".botonAgregarProductoNuevoEditarCotizExcel").html(htmlBotonAgregarNuevoProducto);

}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS===============================================================
function selectProductosCombinarClaveEditarExcel(e){
    claveProducto = $(e).val();
    
    descripcionProductosSeleccionada = $('#listaClave').find('option[value="'+claveProducto+'"]').data('descripcion');
    idProductoLista = $('#listaClave').find('option[value="'+claveProducto+'"]').data('id');
    existenciaProductoLista = $('#listaClave').find('option[value="'+claveProducto+'"]').data('existencia');
    unidadProductoLista = $('#listaClave').find('option[value="'+claveProducto+'"]').data('unidad');

    var htmlCampoClaveProducto =
    "<label for='clave_producto'>Clave</label>"+
    "<input type='text' name='clave_producto_editar' id='clave_producto_editar' class='form-control' value='"+claveProducto+"'>";
    $(".campoClaveProductoEditarCotizExcel").html(htmlCampoClaveProducto);

    var htmlCampoDescripcionProducto =
    "<label>Descripción</label>"+
    "<input type='text' name='descProductoEditar' id='descProductoEditar' class='form-control' value='"+descripcionProductosSeleccionada+"'>";
    $(".campoDescripcionProductoEditarCotizExcel").html(htmlCampoDescripcionProducto);

    var htmlCampoUnidadProducto =
    "<label for='clave_producto'>Unidad</label>"+
    "<input type='text' name='unidad_producto_editar' id='unidad_producto_editar' class='form-control' value='"+unidadProductoLista+"'>";
    $(".campoUnidadProductoEditarCotizExcel").html(htmlCampoUnidadProducto);

    var htmlCampoCantidadProductosEditar =
    "<label>Cantidad</label>"+
    "<input type='text' id='cantidadProductoEditar' class='form-control' onKeypress='soloNumeros(this);' placeholder='Ingresa cantidad'>";
    $(".campoCantidadEditarCotizExcel").html(htmlCampoCantidadProductosEditar);

    var htmlCampoPrecioProductosEditar =
    "<label>Precio de lista</label>"+
    "<input type='text' id='precioListaEditarCotizExcel' class='form-control' onKeypress='soloNumeros(this);' style='text-align: right;' placeholder='Ingresa importe'>";
    $(".precioListaEditarCotizExcel").html(htmlCampoPrecioProductosEditar);

    var htmlBotonAgregarNuevoProducto =
    "<br>"+
    "<label>Agregar Producto</label>"+
    "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacionEditarExcel("+idProductoLista+")' style='width: 30%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'></button>";
    $(".botonAgregarProductoNuevoEditarCotizExcel").html(htmlBotonAgregarNuevoProducto);
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
        "<td class='desProductos' posicion='"+contadorProductos+"'>"+descripcionProductosSeleccionada+"</td>"+
        "<td class='cantProductos' posicion='"+contadorProductos+"'>"+catidadProducto+"</td>"+
        "<td class='precioProductos' posicion='"+contadorProductos+"'>"+precioLista+"</td>"+
        "<td class='totalImporteProductos' posicion='"+contadorProductos+"'>"+importe+"</td>"+
        "<td><button type='button' class='btn btn-outline-danger botonEliminar' onclick='eliminarProductoNvoEditarExcel(this, "+idProductoLista+","+importe+")' style='width: 50%;'><img src='../iconos/eliminar.png' style='width: 20px;'></button><br><input type='hidden' class='totalProductosEditar' value='"+importe+"'/></td>"+
        "<td class='idProductos' style='visibility:collapse; display:none;' posicion='"+contadorProductos+"'>"+idProductoLista+"</td>"+
    "</tr>";
    $(".prodCotizEditarCotizExcel").append(htmlProdCotizEditarInsertar);

    contadorProductos++;

    actualizarTotalCotizacionExcel();

    $("#seleccionEditar").val("");
    $("#selecciónClaveEditar").val("");
    $("#unidad_producto_editar").val("");
    $("#clave_producto_editar").val("");
    $("#descProductoEditar").val("");
    $("#cantidadProductoEditar").val("");
    $("#precioListaEditarCotizExcel").val("");

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

    if ((fila >= 1) && (col1 == 1) && (col2 == 2) && (col3 == 3) && (col4 == 4) && (col5 == 5)) {
    celdas = document.getElementById('tablaProductosAnadidosEditarCotizExcel').rows[fila].cells;
    // console.log(fila,col1, col2, col3, col4);

    celdas[col0].innerHTML = claveProdExcel;
    celdas[col1].innerHTML = descripcionExcel;
    celdas[col2].innerHTML = cantidad;
    celdas[col3].innerHTML = precioUnitario;
    celdas[col4].innerHTML = importe;

    var inputTotal =  celdas[col5];
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
        
        var claveProdu = $(".clavesProductos"+"[posicion='"+posicion+"']").text();
        var descProdu = $(".desProductos"+"[posicion='"+posicion+"']").text();
        var cantidadProdu = $(".cantProductos"+"[posicion='"+posicion+"']").text();
        var precioProdu = $(".precioProductos"+"[posicion='"+posicion+"']").text();

        var jsonTempProductosAgregados = {
          "clave": claveProdu,
          "descripcion": descProdu,
          "cantidad": cantidadProdu,
          "precioUnitario": precioProdu
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
