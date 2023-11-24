<?php
session_start();
$idUsuario = $_SESSION['idUsuario'];
// $nombreUsuario = $_SESSION['nombreUsuario'];
include 'menu.php';
?>
<div class="panel panel-info">
    <div class="panel-heading">EDITAR COTIZACIÓN RENTA</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-2 selectCotizEncontradasEditarRenta"></div>
            <div class="col-lg-2 descripcionCotizRenta"></div>
            <div class="col-lg-3 fechaEditarCotizRenta">
                <!-- <label>Fecha Registro</label>
                <input type='text' class='form-control datepicker' name='fecha_editarCotizRenta' id='fecha_editarCotizRenta' placeholder='AAAA-MM-DD' onchange="selectFoliosEditarRenta();" /> -->
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 selectEmpresaEditarCotizRenta"></div>
            <div class="col-lg-3 selectClienteEditarCotizRenta"></div>
            <div class="col-lg-3 telefonoEditarCotizRenta"></div>
            <div class="col-lg-2 botonAgregarProductoEditarCotizRenta"></div>
        </div>
        <div class="row">
            <div class="col-lg-4 listaProductosEditarCotizRenta"></div>
            <div class="col-lg-3 listaProductosClaveSatEditarCotizRenta"></div>
            <div class="col-lg-3 listaUnidadProductoEditarCotizRenta"></div>
            <div class="col-lg-2 botonCancelarProductoEditarCotizRenta"></div>
        </div>
        <div class="row">
            <div class="col-lg-2 listaProductosClaveEditarCotizRenta"></div>
            <div class="col-lg-6 campoDescripcionProductoEditarCotizRenta"></div>
        </div>
        <div class="row">
            <div class="col-lg-2 campoCantidadEditarCotizRenta"></div>
            <div class="col-lg-2 campoPrecioListaEditarCotizRenta"></div>


            <div class="col-lg-2 campoFechaInicioCotizRenta"></div>
            <div class="col-lg-2 campoFechaFinCotizRenta"></div>
            <div class="col-lg-2 campoDiasRentaCotizRenta"></div>


            <div class="col-lg-2 botonAgregarProductoTablaEditarCotizRenta"></div>
        </div>
        <div class="table-responsive" id="tablaCotizEditProdCotizRenta">
            <table class="table table-primary bg-light tablaProductosTotalEditarCotizRenta" id="tablaProductosAnadidosEditarCotizRenta">
                <thead>
                    <tr>
                        <th>Clave Productos</th>
                        <th>Clave SAT</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio por dia</th>
                        <th>Dias a prestamo</th>
                        <th>Importe</th>
                        <th>Eliminar</th>
                        <th style="visibility:collapse; display:none;"></th>
                    </tr>
                </thead>
                <tbody class="prodCotizEditarCotizRenta">
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-lg-8 condicionesEditarCotizRenta">
            </div>
            <div class="text-center totalCantidadProductosEditarCotizRenta" style="font-size: 40px; color: #000;"></div>
            <div>
                <input type="hidden" class="cantidadTotalEditarCotizRenta">
            </div>
        </div>
        <div class="text-center botonActualizarCotizRenta"></div>
    </div>
</div>
<script>

//FUNCION OBTENER DATOS PROVEEDORES Y FOLIOS=======================================================================
function limpiar_datos_renta(){
    $(".prodCotizEditarCotizRenta").html("");
    $(".selectClienteEditarCotizRenta").html("");
    $(".condicionesEditarCotizRenta").html("");
    $(".fechaEditarCotizRenta").html("");
    $(".selectEmpresaEditarCotizRenta").html("");
    $(".telefonoEditarCotizRenta").html("");
    $(".botonAgregarProductoEditarCotizRenta").html("");
    $(".botonActualizarCotizRenta").html("");
    $(".totalCantidadProductosEditarCotizRenta").html("");
}
//====================================================================================================

//FUNCION OBTENER FOLIOS=======================================================================
function selectFoliosEditarRenta(){

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_cotizacion_renta_mostrar_todas.php",
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
                var resultadosTotales = resultadoMostrar["objetoRespuesta"]["cotizaciones_renta"];
                // console.log(resultadosTotales);
                var opcionesCotizacionGeneralEditar = "<option value='' data-idcotizacion='' data-descripcion='' data-fecha='' data-cliente=''></option>";

                for (i = 0; i < resultadosTotales.length; i++) {
                    var resultadosUnica = resultadosTotales[i];
                    var idCotizacionRenta = resultadosUnica["idCotizacionRenta"];
                    var descripcion  = resultadosUnica["descripcion"];
                    var fechaCotiz   = resultadosUnica["fecha_registro"];
                    var clienteCotiz = resultadosUnica["idCliente"];

                    opcionesCotizacionGeneralEditar += "<option data-descripcion='"+descripcion+"' data-fecha='"+fechaCotiz+"' data-cliente='"+clienteCotiz+"' data-idcotizacion='"+idCotizacionRenta+"' value='"+idCotizacionRenta+"'>"+descripcion+"</option>";

                }

                var htmlSelectCotizacionesProveedor =
                "<label>Buscar Cotizaciones</label>"+
                "<input type='text' list='cotizRentaEditar' name='cotizEncontradaImprimirCotizRenta' id='cotizEncontradaImprimirCotizRenta' class='form-control' onchange='obtener_datos_cotizaciones_editar_renta();'>"+

                "<datalist id='cotizRentaEditar'>"+opcionesCotizacionGeneralEditar+"</datalist>";
                $(".selectCotizEncontradasEditarRenta").html(htmlSelectCotizacionesProveedor);

                closeMessageOverlay();
            }
        }
    });
}
//====================================================================================================

//FUNCION OBTENER DATOS COTIZACIONES=======================================================================
function obtener_datos_cotizaciones_editar_renta(){
    limpiar_datos_renta();

    var idCotizRenta  = $("#cotizEncontradaImprimirCotizRenta").val();

    var descCotizEditar = $('#cotizRentaEditar').find('option[value="'+idCotizRenta+'"]').data('descripcion');

    var htmlDescripcionCotizacion =
    "<label>Descripción Cotización</label>"+
    "<input type='text' class='form-control' name='descCotizRenta' id='descCotizRenta' value='"+descCotizEditar+"' disabled>";
    $(".descripcionCotizRenta").html(htmlDescripcionCotizacion);

    jsonData = {
        "idCotizacionRenta": idCotizRenta
    }

  showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
  $.ajax({
    method: "POST",
    url: "../backend/backend_cotizacion_renta_mostrar.php",
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
            var resultadosTablaCotizaciones= resultadoMostrar["objetoRespuesta"]["cotizacion_renta"];

            for (i = 0; i < resultadosTablaCotizaciones.length; i++) {
                var resultadosTotales = resultadosTablaCotizaciones[i];
                var diasRentaEditar       = resultadosTotales["diasRenta"];
                var claveEditar          = resultadosTotales["clave"];
                var claveSatEditar       = resultadosTotales["claveSat"];
                var clienteEditar        = resultadosTotales["cliente"];
                var condicionesEditar    = resultadosTotales["condiciones"];
                var descripcionEditar    = resultadosTotales["descripcion"];
                var fechaRegistroEditar  = resultadosTotales["fecha_registro"];
                idCotizacionRentaGlobal  = resultadosTotales["idCotizacionRenta"];
                var idSubCotizacionRenta = resultadosTotales["idSubcotizRenta"];
                var idProducto           = resultadosTotales["idProducto"];
                var importeEditar        = resultadosTotales["importe"];
                var nombreEditar         = resultadosTotales["nombre"];
                var precioDiaEditar      = resultadosTotales["precioDia"];
                var telefonoEditar       = resultadosTotales["telefono"];
                var cantidadEditar       = resultadosTotales["cantidad"];
                // totalEditar              = resultadosTotales["total"];

                var tabla = document.querySelectorAll("#tablaProductosAnadidosEditarCotizRenta tbody tr");
                var ref = tabla.length + 1;
                var num = ref;
                var columna0 = 0;
                var columna1 = 1;
                var columna2 = 2;
                var columna3 = 3;
                var columna4 = 4;
                var columna5 = 5;
                var columna6 = 6;
                var columna7 = 7;

                var htmlProdCotizEditar =
                "<tr fila='"+num+"'>"+
                    "<td class='clavesProductos' columna='"+columna0+"'>"+claveEditar+"</td>"+
                    "<td class='clavesSatProductos' columna='"+columna1+"'>"+claveSatEditar+"</td>"+
                    "<td class='desProductos' columna='"+columna2+"'>"+descripcionEditar+"</td>"+
                    "<td class='cantProductos' columna='"+columna4+"'>"+cantidadEditar+"</td>"+
                    "<td class='precioProductos' columna='"+columna3+"'>"+precioDiaEditar+"</td>"+
                    "<td class='diasRenta' columna='"+columna5+"'>"+diasRentaEditar+"</td>"+
                    "<td class='totalImporteProductos' columna='"+columna6+"'>"+importeEditar+"</td>"+
                    "<td class='columna='"+columna7+"''><button type='button' class='btn btn-outline-danger botonEliminar' onclick='eliminarProductoEditarRenta(this, "+idProducto+","+importeEditar+", "+idCotizacionRentaGlobal+", "+idSubCotizacionRenta+")' style='width: 50%;'><img src='../iconos/eliminar.png' style='width: 20px;'></button><br><button type='button' class='btn btn-outline-warning botonEditarProducto' onclick='abrirPopupEditarCotizRenta("+cantidadEditar+", "+precioDiaEditar+", "+diasRentaEditar+", "+idProducto+", "+idCotizacionRentaGlobal+", "+num+", "+columna0+", "+columna1+", "+columna2+", "+columna3+", "+columna4+", "+columna5+", "+columna6+", "+columna7+", "+idSubCotizacionRenta+");' style='width: 50%;'><img src='../iconos/editar.png' style='width: 20px;'></button><input type='hidden' class='totalProductosEditarRenta'  value='"+importeEditar+"'/></td>"+
                    "<td class='idProductos' style='visibility:collapse; display:none;'>"+idProducto+"</td>"+
                "</tr>";


                $(".prodCotizEditarCotizRenta").append(htmlProdCotizEditar);

                actualizarTotalCotizacionRenta();
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

                            opcionesClientes += "<option value='"+idCliente+"' cliente='"+nombreCliente+"' rfc='"+rfcCliente+"' telefono='"+telefonoCliente+"'>"+nombreCliente+"</option>";
                        }
                        var htmlSelectClientesEditar =
                        "<label>Cliente Cotización</label>"+
                        "<select name='cliente_cotiz_editarCotizRenta' class='form-control' id='cliente_cotiz_editarCotizRenta'>"+opcionesClientes+"</select>";
                        $(".selectClienteEditarCotizRenta").html(htmlSelectClientesEditar);

                        $("#cliente_cotiz_editarCotizRenta option:contains("+clienteEditar+")").attr('selected', true);

                        var htmlCampoTelefonoEditar =
                        "<label>Teléfono</label>"+
                        "<input type='text' name='campoTelefonoEditar' id='campoTelefonoEditar' class='form-control' value='"+telefonoCliente+"'>";
                        $(".telefonoEditarCotizRenta").html(htmlCampoTelefonoEditar);
                        closeMessageOverlay();
                    }
                }
            });

            var htmlCampoCondicionesEditar =
            "<label for='condiciones' style='font-size: 40px;'>CONDICIONES COMERCIALES</label>"+
            "<textarea class='form-control' name='condicionesEditarCotizRenta' id='condicionesEditarCotizRenta' rows='4'>"+condicionesEditar+"</textarea>";
            $(".condicionesEditarCotizRenta").html(htmlCampoCondicionesEditar);

            var htmlCampoFechaRegistroEditar =
            "<label>Fecha Registro</label>"+
            "<input type='date' name='fecha_editarCotizRenta' id='fecha_editarCotizRenta' class='form-control' value='"+fechaRegistroEditar+"'>";
            $(".fechaEditarCotizRenta").html(htmlCampoFechaRegistroEditar);

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
                    "<select name='empresa_cotiz_editarRenta' class='form-control' id='empresa_cotiz_editarRenta'>"+opcionesEmpresas+"</select>";
                    $(".selectEmpresaEditarCotizRenta").html(htmlSelectEmpresas);

                    // $("#empresa_cotiz_editarRenta option[value='"+ nombreEditar +"']").attr("selected",true);
                    $("#empresa_cotiz_editarRenta option:contains("+nombreEditar+")").attr('selected', true);

                    closeMessageOverlay();
                  }
                }
            });

            var htmlBotonAgregarProducto =
            "<br>"+
            // "<label>Agregar Producto</label>"+
            "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacioneEditarRenta()' style='width: 100%;'><img src='../iconos/mas.png' style='width: 30px;'>Agregar Producto</button>";
            $(".botonAgregarProductoEditarCotizRenta").html(htmlBotonAgregarProducto);

            var htmlBotonActualizar =
            "<div class='text-center'>"+
                "<label>ACTUALIZAR</label>"+
            "</div>"+
            "<div class='text-center'>"+
                "<button type='button' class='btn btn-outline-success' onclick='actualizarDatosCotizacionRenta(0);' style='width: 20%;'><img src='../iconos/actualizar.png' style='width: 40px;'></button>"+
            "</div>";
            $(".botonActualizarCotizRenta").html(htmlBotonActualizar);

            closeMessageOverlay();
        }
    }
  });
}
//====================================================================================================

//FUNCION OBTENER DATOS PRODUCTOS=======================================================================
function agregarProductoCotizacioneEditarRenta(){

    $(".campoClaveProductoEditarCotizRenta").show();
    $(".campoDescripcionProductoEditarCotizRenta").show();
    $(".campoUnidadProductoEditarCotizRenta").show();
    $(".listaProductosEditarCotizRenta").show();
    $(".listaProductosClaveEditarCotizRenta").show();
    $(".botonCancelarProductoEditarCotizRenta").show();

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_productos_propios_mostrar.php",
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

                    var idProducto = resultadosProductos["idProductoPropio"];
                    var claveProducto = resultadosProductos["clave"];
                    var claveSat = resultadosProductos["claveSat"];
                    var descripcionProducto   = resultadosProductos["descripcion"];
                    var existenciaProductos   = resultadosProductos["existencia"];
                    var unidadProductos   = resultadosProductos["idUnidad"];


                    opcionesListaProductos += "<option data-unidad='"+unidadProductos+"' data-existencia='"+existenciaProductos+"' data-clave='"+claveProducto+"' data-sat='"+claveSat+"' data-descripcion='"+descripcionProducto+"' data-id='"+idProducto+"' value='"+descripcionProducto+"'>"+claveSat+"</option>";

                    opcionesListaProductosClaveSat += "<option data-unidad='"+unidadProductos+"' data-existencia='"+existenciaProductos+"' data-clave='"+claveProducto+"' data-sat='"+claveSat+"' data-id='"+idProducto+"' data-descripcion='"+descripcionProducto+"' value='"+claveSat+"'>"+descripcionProducto+"</option>";

                }

                var htmlDivListasProductos =
                "<label for='seleccionRenta'>Buscar Productos:</label>"+
                "<input type='text' list='listaRenta' name='seleccionRenta' id='seleccionRenta' class='form-control' onchange='selectProductosCombinarRenta(this, 0);'>"+

                "<datalist id='listaRenta'>"+opcionesListaProductos+"</datalist>";
                $(".listaProductosEditarCotizRenta").html(htmlDivListasProductos);

                var htmlDivListasProductosClave =
                "<label for='clave_productoRenta'>Buscar Clave Producto:</label>"+
                "<input type='text' list='listaClaveRenta' name='clave_productoRenta' id='clave_productoRenta' class='form-control' onchange='selectProductosCombinarClaveRenta(this, 0);'>"+

                "<datalist id='listaClaveRentaRenta'>"+opcionesListaProductosClave+"</datalist>";
                $(".listaProductosClaveEditarCotizRenta").html(htmlDivListasProductosClave);

                var htmlDivListasProductosClaveSat =
                "<label for='seleccionClaveRenta'>Buscar Clave SAT:</label>"+
                "<input type='text' list='listaClaveSatRenta' name='seleccionClaveRenta' id='seleccionClaveRenta' class='form-control' onchange='selectProductosCombinarClaveSatRenta(this, 0);'>"+

                "<datalist id='listaClaveSatRenta'>"+opcionesListaProductosClaveSat+"</datalist>";
                $(".listaProductosClaveSatEditarCotizRenta").html(htmlDivListasProductosClaveSat);

                var htmlBotonCancelarProducto =
                "<br>"+
                "<button class='btn btn-outline-danger' type='button' onclick='cancelarProductoCotizacioneEditarRenta()' style='width: 100%;'><img src='../iconos/desactivado.png' style='width: 30px;'>Cancelar</button>";
                $(".botonCancelarProductoEditarCotizRenta").html(htmlBotonCancelarProducto);

                var htmlDescripcionProductoEditar =
                "<label>Descripción Producto</label>"+
                "<textarea class='form-control' name='descProductoRenta' id='descProductoRenta' rows='4' onchange='selectProductosCombinarRenta(this, 1)'></textarea>";
                $(".campoDescripcionProductoEditarCotizRenta").html(htmlDescripcionProductoEditar);

                var htmlCampoCantidadEditar =
                "<label for='cantidad'>Cantidad</label>"+
                "<input type='text' id='cantidadProductoEditarRenta' class='form-control' onKeypress='soloNumeros(this);' placeholder='Ingresa cantidad'>";
                $(".campoCantidadEditarCotizRenta").html(htmlCampoCantidadEditar);

                var htmlCampoPrecioditar =
                "<label for='importe'>Precio por dia</label>"+
                "<input type='text' id='precioListaEditarRenta' class='form-control' onKeypress='soloNumeros(this);' placeholder='Ingresa importe'>";
                $(".campoPrecioListaEditarCotizRenta").html(htmlCampoPrecioditar);

                var htmlCampoFechaInicioEditar =
                "<label>Fecha Inicio</label>"+
                "<input type='date' id='fechaInicioCotizRenta' class='form-control'>";
                $(".campoFechaInicioCotizRenta").html(htmlCampoFechaInicioEditar);

                var htmlCampoFechaFinEditar =
                "<label>Fecha Fin</label>"+
                "<input type='date' id='fechaFinCotizRenta' class='form-control' onchange='calcularDiasRenta();'>";
                $(".campoFechaFinCotizRenta").html(htmlCampoFechaFinEditar);

                var htmlCampoDiasRentaEditar =
                "<label>Dias totales</label>"+
                "<input type='text' id='diasTotalRenta' class='form-control' disabled>";
                $(".campoDiasRentaCotizRenta").html(htmlCampoDiasRentaEditar);

                obtener_unidad_clave_sat_editar_renta();
                obtener_datos_unidades_editar_renta();
                closeMessageOverlay();
            }
        }
    });
}
//====================================================================================================

//FUNCION CALCULAR DIAS FECHAS=========================================================================
function calcularDiasRenta(){

    var fechaInicio = new Date(document.getElementById("fechaInicioCotizRenta").value);
    var fechaFin = new Date(document.getElementById("fechaFinCotizRenta").value);
    var actualDate = new Date();
    if (fechaFin > fechaInicio)
    {
        var diferencia = fechaFin.getTime() - fechaInicio.getTime();
        document.getElementById("diasTotalRenta").value = Math.round(diferencia / (1000 * 60 * 60 * 24));
    }
    else if (fechaFin != null && fechaFin < fechaInicio) {
        $(".texto-mensaje").text("La fecha final debe ser mayor a la fecha inicial");
        $("#msj").modal("toggle");
        $("#fechaInicioCotizRenta").val("");
        $("#fechaFinCotizRenta").val("");
        document.getElementById("diasTotalRenta").value = 0;
    }

}
//====================================================================================================

//FUNCION OBTENER DATOS PROVEEDORES Y FOLIOS==========================================================
function obtener_unidad_clave_sat_editar_renta(){
    var lista = document.querySelectorAll("#listaClaveSatRenta");

    for (var lis of lista) {
        var listaResultados=lis.querySelectorAll("option");
        // console.log(listaResultados);
        var valorUnidad = listaResultados[1].value;
        // console.log(valorUnidad);
        $("#seleccionClaveRenta").val(valorUnidad);
    }
    var idUni = $("#listaClaveSatRenta").val(valorUnidad);

    var resultadoUnidad = $("#listaClaveSatRenta").val();

    var selectIdUnidad = $('#listaClaveSatRenta').find('option[value="'+resultadoUnidad+'"]').data('id');
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS===============================================================
function obtener_datos_unidades_editar_renta(){
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
                "<label for='seleccionUnidadRenta'>Unidad SAT:</label>"+
                "<input type='text' list='listaUnidadSatRenta' name='unidadesSat' id='seleccionUnidadRenta' class='form-control'onchange='selectProductosCombinarUnidadEditarRenta(this);'>"+

                "<datalist id='listaUnidadSatRenta'>"+opcionesListaUnidades+"</datalist>";
                $(".listaUnidadProductoEditarCotizRenta").html(htmlDivListasUnidadSat);

                obtener_unidad_pieza_editar_renta();
            }
        }
    });
    closeMessageOverlay();
}
//====================================================================================================

//FUNCION OBTENER DATOS PROVEEDORES Y FOLIOS==========================================================
function obtener_unidad_pieza_editar_renta(){
    var lista = document.querySelectorAll("#listaUnidadSatRenta");

    console.log(lista);

    for (var lis of lista) {
        var listaResultados=lis.querySelectorAll("option");

        var valorUnidad = listaResultados[1070].value;
        $("#seleccionUnidadRenta").val(valorUnidad);
    }

    var idUni = $("#listaUnidadSatRenta").val(valorUnidad);

    var resultadoUnidad = $("#listaUnidadSatRenta").val();

    idUnidadesTodos = $('#listaUnidadSatRenta').find('option[value="'+resultadoUnidad+'"]').data('idunidad');
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS=========================================================================
function selectProductosCombinarUnidadEditarRenta(e){
    unidadProductoGlobal = $(e).val();

    var lista = document.querySelectorAll("#listaClaveSatRenta");
    for (var lis of lista) {
        var listaResultados=lis.querySelectorAll("option");
        var valorUnidad = listaResultados[1].value;
        $("#seleccionClaveRenta").val(valorUnidad);
    }
    var idUni = $("#listaClaveSatRenta").val(valorUnidad);
    var resultadoUnidad = $("#listaClaveSatRenta").val();
    var selectIdUnidad = $('#listaClaveSatRenta').find('option[value="'+resultadoUnidad+'"]').data('id');


    var unirDescripcion = $("#descProductoRenta").val();
    var desProductos = $("#seleccionRenta").val();
    var descripcionNuevaUnidad = $("#descProductoRenta").val(unirDescripcion+ "|" +unidadProductoGlobal);
    var unirProductos = $("#seleccionRenta").val(desProductos+ "|" +unidadProductoGlobal);

    descripcionProductosSeleccionadoGlobal = $("#descProductoRenta").val();

    idProductoGlobal = $('#listaRenta').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('id');

    if (idProductoGlobal == undefined) {
        $("#clave_productoRenta").val("");
    }


    var htmlBotonAgregarProducto =
    "<br>"+
    "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacionEditarRenta("+idProductoGlobal+")' style='width: 100%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'>Agregar Producto</button>";
    $(".botonAgregarProductoTablaEditarCotizRenta").html(htmlBotonAgregarProducto);

}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS===============================================================
function selectProductosCombinarRenta(e, operacion){
    descripcionProductosSeleccionadoGlobal = $(e).val();
    // console.log(descripcionProductosSeleccionadoGlobal, operacion);

    if (operacion == 0) {
        claveProductoGlobal = $('#listaRenta').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('clave');
        claveProductoSatGlobal = $('#listaRenta').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('sat');
        idProductoGlobal = $('#listaRenta').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('id');
        existenciaProductoGlobal = $('#listaRenta').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('existencia');
        unidadProductoGlobal = $('#listaRenta').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('unidad');
        // console.log(unidadProductoGlobal);

        if (unidadProductoGlobal == 0) {
            obtener_unidad_pieza_editar_renta();
        }

        if (idProductoGlobal == undefined) {
            $(".texto-mensaje").text("El producto no se encuentra dentro del stock.");
            $("#msj").modal("toggle");
            $("#seleccionRenta").val("");
            obtener_unidad_pieza_editar_renta();
            obtener_unidad_clave_sat_editar_renta();
        }else{
            $("#seleccionClaveRenta").val(claveProductoSatGlobal);
            // $("#seleccionUnidadRenta").val(unidadProductoGlobal);
            $("#clave_productoRenta").val(claveProductoGlobal);
            $("#descProductoRenta").val(descripcionProductosSeleccionadoGlobal);
            $("#seleccionRenta").val(descripcionProductosSeleccionadoGlobal);

            var htmlBotonAgregarProducto =
            "<br>"+
            "<button class='btn btn-success' type='button' onclick='agregarProductoCotizacionEditarRenta("+idProductoGlobal+")' style='width: 100%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'>Agregar Producto</button>";
            $(".botonAgregarProductoTablaEditarCotizRenta").html(htmlBotonAgregarProducto);
        }
    }

    else if (operacion == 1) {
        var textAreaProductoRenta = $("#descProductoRenta").val();

        claveProductoGlobal = $('#listaRenta').find('option[value="'+textAreaProductoRenta+'"]').data('clave');
        claveProductoSatGlobal = $('#listaRenta').find('option[value="'+textAreaProductoRenta+'"]').data('sat');
        idProductoGlobal = $('#listaRenta').find('option[value="'+textAreaProductoRenta+'"]').data('id');
        existenciaProductoGlobal = $('#listaRenta').find('option[value="'+textAreaProductoRenta+'"]').data('existencia');
        unidadProductoGlobal = $('#listaRenta').find('option[value="'+textAreaProductoRenta+'"]').data('unidad');

        if (unidadProductoGlobal == 0) {
            obtener_unidad_pieza_renta();
        }

        if (idProductoGlobal == undefined) {
            // $("#clave_productoRenta").val("");
            // $("#descProductoRenta").val(textAreaProductoRenta);
            $(".texto-mensaje").text("El producto no se encuentra dentro del stock.");
            $("#msj").modal("toggle");
            $("#descProductoRenta").val("");
            obtener_unidad_pieza_editar_renta();
            obtener_unidad_clave_sat_editar_renta();

        }else{
            $("#seleccionClaveRenta").val(claveProductoSatGlobal);
            // $("#seleccionUnidadRenta").val(unidadProductoGlobal);
            $("#clave_productoRenta").val(claveProductoGlobal);
            $("#descProductoRenta").val(textAreaProductoRenta);
            $("#seleccionRenta").val(textAreaProductoRenta);

            var htmlBotonAgregarProducto =
            "<br>"+
            "<button class='btn btn-success' type='button' onclick='agregarProductoCotizacionRenta("+idProductoGlobal+")' style='width: 100%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'>Agregar Producto</button>";
            $(".botonAgregarProductoRenta").html(htmlBotonAgregarProducto);

        }
    }

}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS=========================================================================
function selectProductosCombinarClaveSatRenta(e, operacion){
    claveProductoSatGlobal = $(e).val();
    // console.log(claveProductoSatGlobal);

    if (operacion == 0) {
        descripcionProductosSeleccionadoGlobal = $('#listaClaveSatRenta').find('option[value="'+claveProductoSatGlobal+'"]').data('descripcion');
        idProductoGlobal = $('#listaClaveSatRenta').find('option[value="'+claveProductoSatGlobal+'"]').data('id');
        existenciaProductoGlobal = $('#listaClaveSatRenta').find('option[value="'+claveProductoSatGlobal+'"]').data('existencia');
        unidadProductoGlobal = $('#listaClaveSatRenta').find('option[value="'+claveProductoSatGlobal+'"]').data('unidad');
        claveProductoGlobal = $('#listaClaveSatRenta').find('option[value="'+claveProductoSatGlobal+'"]').data('clave');

        // console.log(descripcionProductosSeleccionadoGlobal,claveProductoGlobal, idProductoGlobal, existenciaProductoGlobal, unidadProductoGlobal);

        if (idProductoGlobal == undefined) {
            $("#unidad_producto_editarRenta").val("");
            $("#clave_productoRenta").val("");
            $("#descProductoRenta").val("");
        }else{
            // $("#seleccionClaveRenta").val(claveProductoSatGlobal);
            $("#seleccionUnidadRenta").val(unidadProductoGlobal);
            $("#clave_productoRenta").val(claveProductoGlobal);
            $("#descProductoRenta").val(descripcionProductosSeleccionadoGlobal);
            $("#seleccionRenta").val(descripcionProductosSeleccionadoGlobal);
        }
    }
    else if (operacion == 1) {
        idProductoGlobal = $('#listaClaveSatRenta').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('id');
        // console.log(idProductoGlobal);
        if (idProductoGlobal == undefined) {
            $("#seleccionRenta").val(descripcionProductosSeleccionadoGlobal);
            $("#clave_productoRenta").val("");
        }
    }

    var htmlBotonAgregarProducto =
    "<br>"+
    "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacionEditarRenta("+idProductoGlobal+")' style='width: 100%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'>Agregar Producto</button>";
    $(".botonAgregarProductoTablaEditarCotizRenta").html(htmlBotonAgregarProducto);

}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS=========================================================================
function selectProductosCombinarClaveRenta(e, operacion){
    claveProductoGlobal = $(e).val();

    if (operacion == 0) {
        descripcionProductosSeleccionadoGlobal = $('#listaClaveRenta').find('option[value="'+claveProductoGlobal+'"]').data('descripcion');
        idProductoGlobal = $('#listaClaveRenta').find('option[value="'+claveProductoGlobal+'"]').data('id');
        claveProductoSatGlobal = $('#listaClaveRenta').find('option[value="'+claveProductoGlobal+'"]').data('sat');
        existenciaProductoGlobal = $('#listaClaveRenta').find('option[value="'+claveProductoGlobal+'"]').data('existencia');
        unidadProductoGlobal = $('#listaClaveRenta').find('option[value="'+claveProductoGlobal+'"]').data('unidad');

        // console.log(descripcionProductosSeleccionadoGlobal, claveProductoSatGlobal, idProductoGlobal, existenciaProductoGlobal, unidadProductoGlobal);

        if (idProductoGlobal == undefined) {
            // $("#descProductoRenta").val(descripcionProductosSeleccionadoGlobal);
            console.log(idProductoGlobal);
        }else{
            $("#seleccionClaveRenta").val(claveProductoSatGlobal);
            $("#seleccionUnidadRenta").val(unidadProductoGlobal);
            $("#descProductoRenta").val(descripcionProductosSeleccionadoGlobal);
            $("#seleccionRenta").val(descripcionProductosSeleccionadoGlobal);
        }
    }
    else if (operacion == 1) {
        idProductoGlobal = $('#listaClaveRenta').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('id');
        // console.log(idProductoGlobal);
        if (idProductoGlobal == undefined) {
            $("#seleccionRenta").val(descripcionProductosSeleccionadoGlobal);
            $("#clave_productoRenta").val("");
        }
    }

    var htmlBotonAgregarProducto =
    "<br>"+
    "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacionEditarRenta("+idProductoGlobal+")' style='width: 100%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'>Agregar Producto</button>";
    $(".botonAgregarProductoTablaEditarCotizRenta").html(htmlBotonAgregarProducto);

}
//====================================================================================================

//FUNCION OCULTAR DATOS INPUT PRODUCTOS===============================================================
function cancelarProductoCotizacioneEditarRenta(){

    $(".listaProductosEditarCotizRenta").hide();
    $(".listaProductosClaveEditarCotizRenta").hide();
    $(".listaProductosClaveSatEditarCotizRenta").hide();
    $(".campoDescripcionProductoEditarCotizRenta").hide();
    $(".campoCantidadEditarCotizRenta").hide();
    $(".campoPrecioListaEditarCotizRenta").hide();
    $(".campoFechaInicioCotizRenta").hide();
    $(".campoFechaFinCotizRenta").hide();
    $(".campoDiasRentaCotizRenta").hide();
    $(".botonCancelarProductoEditarCotizRenta").hide();
    $(".listaUnidadProductoEditarCotizRenta").hide();

    $("#seleccionRenta").val("");
    $("#clave_productoRenta").val("");
    $("#seleccionClaveRenta").val("");
    $("#descProductoRenta").val("");
    $("#cantidadProductoEditarRenta").val("");
    $("#precioListaEditarRenta").val("");
    $("#fechaInicioCotizRenta").val("");
    $("#fechaFinCotizRenta").val("");
    $("#diasTotalRenta").val("");
    $("#seleccionUnidadRenta").val("");
}
//====================================================================================================

// //FUNCION AGREGAR NUEVO PRODUCTOS=======================================================================
function agregarProductoCotizacionEditarRenta(idProductoGlobal){

    var precioLista = $("#precioListaEditarRenta").val();
    var catidadProducto = $("#cantidadProductoEditarRenta").val();
    var diasRenta = $("#diasTotalRenta").val();

    if (precioLista == "") {
        $(".texto-mensaje").text("El precio es obligatorio");
        $("#msj").modal("toggle");
        return false;
    }

    if (catidadProducto == "") {
        $(".texto-mensaje").text("La cantidad es obligatorio");
        $("#msj").modal("toggle");
        return false;
    }

    if (diasRenta == "") {
        $(".texto-mensaje").text("Fecha inicio y la fecha fin es obligatorio");
        $("#msj").modal("toggle");
        return false;
    }

    var total = 0;

    total = catidadProducto;
    var importe = total * precioLista;

    var htmlProdCotizEditarInsertar =
    "<tr class='productosAgregadosCotizRentaEditar' posicion='"+contadorProductos+"'>"+
        "<td class='clavesProductos' posicion='"+contadorProductos+"'>"+claveProductoGlobal+"</td>"+
        "<td class='clavesSatProductos' posicion='"+contadorProductos+"'>"+claveProductoSatGlobal+"</td>"+
        "<td class='desProductos' posicion='"+contadorProductos+"'>"+descripcionProductosSeleccionadoGlobal+"</td>"+
        "<td class='cantProductos' posicion='"+contadorProductos+"'>"+catidadProducto+"</td>"+
        "<td class='precioProductos' posicion='"+contadorProductos+"'>"+precioLista+"</td>"+
        "<td class='diasRenta' posicion='"+contadorProductos+"'>"+diasRenta+"</td>"+
        "<td class='totalImporteProductos' posicion='"+contadorProductos+"'>"+importe+"</td>"+
        "<td><button type='button' class='btn btn-outline-danger botonEliminar' onclick='eliminarProductoNvoEditarGeneral(this, "+idProductoGlobal+","+importe+", "+contadorProductos+")' style='width: 50%;'><img src='../iconos/eliminar.png' style='width: 20px;'></button><br><input type='hidden' class='totalProductosEditar' value='"+importe+"'/></td>"+
        "<td class='idProductos' style='visibility:collapse; display:none;' posicion='"+contadorProductos+"'>"+idProductoGlobal+"</td>"+
    "</tr>";
    $(".prodCotizEditarCotizRenta").append(htmlProdCotizEditarInsertar);

    contadorProductos++;

    actualizarTotalCotizacionRenta();

    $("#seleccionRenta").val("");
    $("#clave_productoRenta").val("");
    $("#descProductoRenta").val("");
    $("#cantidadProductoEditarRenta").val("");
    $("#precioListaEditarRenta").val("");

    obtener_unidad_clave_sat_editar_renta();
    obtener_datos_unidades_editar_renta();

}
//====================================================================================================

//FUNCION ELIMINAR PRODUCTO NUEVO===========================================================================
function eliminarProductoNvoEditarGeneral(valor, idProducto, importe, posicion){
    var total = $(".cantidadTotalEditarCotizRenta").val();

    var eliminarProd = total - importe;
    $(".totalCantidadProductosEditarCotizRenta").text(moneda+eliminarProd.toFixed(2));
    valor.closest('tr').remove();

}
//====================================================================================================

//FUNCION ELIMINAR PRODUCTO DE BASE===========================================================================
function eliminarProductoEditarRenta(valor, idProducto, importe, idCotizacionRentaGlobal, idSubCotizacionRenta){
    var total = $(".cantidadTotalEditarCotizRenta").val();
    idProductoEli = idProducto;
    idCotizRenta = idCotizacionRentaGlobal;
    subCotizRenta = idSubCotizacionRenta;

    var eliminarProd = total - importe;
    $(".totalCantidadProductosEditarCotizRenta").text(moneda+eliminarProd.toFixed(2));
    valor.closest('tr').remove();
    actualizarDatosCotizacionRenta(1);
}
//====================================================================================================

//FUNCION ACTUALIZAR DATOS TABLA==========================================================================
function actualizarProductosRenta(e){
    cantidad = $("#cantidadEditarCotizRenta").val();
    precioDia  = $("#precioUnitarioEditarCotizRenta").val();
    diasRenta  = $("#diasPrestamoEditarCotizRenta").val();
    descripcionProductosSeleccionada = $("#descripcionProductoCotizRenta").val();

    importe = ((cantidad * precioDia) * diasRenta);

    if ((fila >= 1) && (col2 == 2) && (col3 == 3) && (col4 == 4) && (col5 == 5) && (col6 == 6)) {

    celdas = document.getElementById('tablaProductosAnadidosEditarCotizRenta').rows[fila].cells;

    celdas[col2].innerHTML = descripcionProductosSeleccionada;
    celdas[col3].innerHTML = cantidad;
    celdas[col4].innerHTML = precioDia;
    celdas[col5].innerHTML = diasRenta;
    celdas[col6].innerHTML = importe;

    var inputTotal =  celdas[col7];
    var totalInp = inputTotal.querySelectorAll("input");
    // var totalCotiz = totalInp[0].value;
    var totalCotiz = totalInp[0].value = importe;

    actualizarTotalCotizacionRenta();

  }
}
//====================================================================================================

//FUNCION SUMAR IMPORTE MOSTRAR TOTAL===========================================================================
function actualizarTotalCotizacionRenta(){
    var total = 0;

    $('.totalProductosEditarRenta').each(function(){
        if (!isNaN($(this).val())) {
          total += Number($(this).val());
          $(".totalCantidadProductosEditarCotizRenta").text(moneda+total.toLocaleString('es-MX'));
          $(".cantidadTotalEditarCotizRenta").val(total);
        }else{alert("si es nan");}
    });
}
//====================================================================================================

//FUNCION ACTUALIZAR DATOS PRODUCTO===========================================================================
function actualizarDatosCotizacionRenta(operacion){

    $(".productosAgregadosCotizRentaEditar").each(function(){
        var posicion = $(this).attr("posicion");

        var diasRentaCotiz = $(".diasRenta"+"[posicion='"+posicion+"']").text();
        var precioDiaCotiz = $(".precioProductos"+"[posicion='"+posicion+"']").text();
        var caatidadProducto = $(".cantProductos"+"[posicion='"+posicion+"']").text();
        var totalImporte = $(".totalImporteProductos"+"[posicion='"+posicion+"']").text();
        var idProductos = $(".idProductos"+"[posicion='"+posicion+"']").text();

        var jsonTempProductosAgregados = {
          "diasRenta": diasRentaCotiz,
          "precioDia": precioDiaCotiz,
          "cantidad": caatidadProducto,
          "importe": totalImporte,
          "idProducto": idProductos
        }

        productosTotalEditar.push(jsonTempProductosAgregados);

    });


    cantidad = $("#cantidadEditarCotizRenta").val();
    precioDia  = $("#precioUnitarioEditarCotizRenta").val();
    diasRenta  = $("#diasPrestamoEditarCotizRenta").val();
    descripcionProductosSeleccionada = $("#descripcionProductoCotizRenta").val();


    if (operacion == 0) {
        eliminado = 0;
        var actualizar = 1;
        var idProductoEdit = productoId;
        var idCotizacionRenta = idCotizacionRentaGlobal;
        var descripcionProducto = descripcionProductosSeleccionada;
        var idUsuarioEdit = <?=$idUsuario;?>;
        var idEmpresaEditar = $("#empresa_cotiz_editarRenta option:selected").val();
        var fechaEditar = $("#fecha_editarCotizRenta").val();
        var idClienteEditar = $("#cliente_cotiz_editarCotizRenta").val();
        var totalTablaEditar =$(".cantidadTotalEditarCotizRenta").val();
        var condisionesEditar = $("#condicionesEditarCotizRenta").val();
        var cantidadProducto = cantidad;
        var precioDiaRenta = precioDia;
        var diasRentaProducto = diasRenta;
        var idSubCotizRentaEditar = subCotizRenta;
        var productosArrayEditar = productosTotalEditar;
        var importeProducto = (cantidadProducto * precioDiaRenta * (diasRentaProducto));

        var jsonData = {

            "idUsuario": idUsuarioEdit,
            "idCotizacionRenta": idCotizacionRenta,
            "descripcion": descripcionProducto,
            "idCliente": idClienteEditar,
            "fecha_registro": fechaEditar,
            "idEmpresa": idEmpresaEditar,
            "condiciones": condisionesEditar,
            "total": totalTablaEditar,
            "productos": JSON.stringify(productosArrayEditar),
            "actualizar": actualizar,
            "idSubcotizRenta": idSubCotizRentaEditar,
            "eliminado": eliminado,
            "idProducto": idProductoEdit,
            "precioDia": precioDiaRenta,
            "diasRenta": diasRentaProducto,
            "importe": importeProducto
        }

        console.log(jsonData);

    }
    else if (operacion == 1){
        eliminado = 1;
        var actualizar = 1;
        var idProductoEdit = idProductoEli;
        var idCotizacionRenta = idCotizRenta;
        var idUsuarioEdit = <?=$idUsuario;?>;

        var jsonData = {
          "idCotizacionRenta": idCotizacionRenta,
          "idProducto": idProductoEdit,
          "idUsuario": idUsuarioEdit,
          "actualizar": actualizar,
          "eliminado": eliminado,
          "idSubcotizUnica": subCotizRenta
        }
        console.log(jsonData);
    }

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_cotizacion_renta_actualizar.php",
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
//====================================================================================================

//EVENTO READY========================================================================================
$(document).ready(function(){
    selectFoliosEditarRenta();

    descripcionProductosSeleccionada = "";
    claveProducto = "";
    idProductoLista = "";
    existenciaProductoLista = "";
    unidadProductoLista = "";
    moneda = "TOTAL $";
    productosTotalEditar = new Array();
    productosTabla = new Array();
    numFilaArray = new Array();
    totalEditar = 0;
    precioTablaArray = new Array();
    celdas = "";
    cantidad = "";
    precioDia = "";
    descripcion = "";
    importe = "";
    eliminado = 0
    idProductoEli = "";
    idDetalleEli = "";
    idCotizRenta = "";
    idCotizacionRentaGlobal = "";
    contadorProductos = 0;
});
//====================================================================================================
</script>
