<?php
session_start();
$idUsuario = $_SESSION['idUsuario'];
// $nombreUsuario = $_SESSION['nombreUsuario'];
include 'menu.php';
?>
<div class="panel panel-info">
    <div class="panel-heading">EDITAR COTIZACIÓN</div>
    <div class="panel-body">
        <div class="row">
            <!-- <div class="col-lg-4 selectClientesEditarCotz"></div> -->
            <div class="col-lg-4 selectProveedorEditarCotiz"></div>
            <div class="col-lg-2 selectCotizEncontradasEditar"></div>
            <div class="col-lg-3 fechaEditar"></div>
        </div>
        <div class="row">
            <div class="col-lg-3 selectEmpresaEditar"></div>
            <div class="col-lg-3 selectClienteEditar"></div>
            <div class="col-lg-3 telefonoEditar"></div>
            <div class="col-lg-2 botonAgregarProductoEditar"></div>
        </div>
        <div class="row">
            <div class="col-lg-5 listaProductosEditar"></div>
            <div class="col-lg-5 listaProductosClaveEditar"></div>
            <div class="col-lg-2 botonCancelarProductoEditar"></div>
        </div>
        <div class="row">
            <div class="col-lg-3 campoUnidadProductoEditar"></div>
            <div class="col-lg-2 campoClaveProductoEditar"></div>
            <div class="col-lg-3 campoDescripcionProductoEditar"></div>
        </div>
        <div class="row">
            <div class="col-lg-2 campoCantidadEditar"></div>
            <div class="col-lg-2 precioListaEditar"></div>
            <div class="col-lg-2 botonAgregarProductoNuevoEditar"></div>
        </div>
        <div class="table-responsive" id="tablaCotizEditProd">
            <table class="table table-primary bg-light tablaProductosTotalEditar" id="tablaProductosAnadidosEditar">
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
                <tbody class="prodCotizEditar">
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-lg-8 condicionesEditar">
            </div>
            <div class="text-center totalCantidadProductosEditar" style="font-size: 40px; color: #000;"></div>
            <div>
                <input type="hidden" class="cantidadTotalEditar">
            </div>
        </div>
        <div class="text-center botonActualizar"></div>
    </div>
</div>
<script>

//FUNCION OBTENER DATOS PROVEEDORES Y FOLIOS=======================================================================
function limpiar_datos(){
    $(".prodCotizEditar").html("");
    $(".selectClienteEditar").html("");
    $(".condicionesEditar").html("");
    $(".fechaEditar").html("");
    $(".selectEmpresaEditar").html("");
    $(".telefonoEditar").html("");
    $(".botonAgregarProductoEditar").html("");
    $(".botonActualizar").html("");
    $(".totalCantidadProductosEditar").html("");
}
//====================================================================================================

//FUNCION OBTENER DATOS PROVEEDORES Y FOLIOS=======================================================================
function obtener_datos_proveedor_editar(){

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_proveedores_mostrar.php",
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
                var resultados = resultadoMostrar["objetoRespuesta"]["proveedores"];
                var opcionesCotizacionesEditar = "<option value='-1' folio='' proveedor=''>Proveedor *</option>";

                for (i = 0; i < resultados.length; i++) {
                    var resultadosTotales = resultados[i];
                    var idProveedor = resultadosTotales["idProveedor"];
                    var folio   = resultadosTotales["folio"];
                    var proveedor = resultadosTotales["proveedor"];

                    opcionesCotizacionesEditar += "<option value='"+idProveedor+"' folio='"+folio+"' proveedor='"+proveedor+"'>"+proveedor+"</option>";
                }
                var htmlSelectCotizacionesProveedor =
                "<label>Proveedor</label>"+
                "<select name='proveedor_editar' class='form-control' id='proveedor_editar' onchange='selectFoliosEditar(this);'>"+opcionesCotizacionesEditar+"</select>";
                $(".selectProveedorEditarCotiz").html(htmlSelectCotizacionesProveedor);
                closeMessageOverlay();
            }
        }
    });
}
//====================================================================================================

//FUNCION OBTENER FOLIOS=======================================================================
function selectFoliosEditar(e){
    limpiar_datos();
    var idProveedorSeleccionadaEditar = $(e).val();

    var folioSeleccionadoEditar = $("#proveedor_editar option:selected").attr("folio");

    var jsonData = {
        "folioCotizacion": folioSeleccionadoEditar,
        }

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_proveedores_mostrar_folios.php",
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
                var resultados = resultadoMostrar["objetoRespuesta"]["folios"];
                var opcionesFolioCotizacionesEditar = "<option value='-1' folio=''>Cotizaciones *</option>";

                for (i = 0; i < resultados.length; i++) {
                    var resultadosTotales = resultados[i];
                    var idCotizacionEncontrada = resultadosTotales["idCotizacion"];
                    var folioCotizacion   = resultadosTotales["folioCotizacion"];

                    opcionesFolioCotizacionesEditar += "<option value='"+idCotizacionEncontrada+"' folio='"+folioCotizacion+"'>"+folioCotizacion+"</option>";
                }
                var htmlSelectCotizacionesProveedor =
                "<label>Cotizaciones Encontradas</label>"+
                "<select name='cotizEncontradaImprimir' class='form-control' id='cotizEncontradaImprimir' onchange='obtener_datos_cotizaciones_editar();'>"+opcionesFolioCotizacionesEditar+"</select>";
                $(".selectCotizEncontradasEditar").html(htmlSelectCotizacionesProveedor);

                closeMessageOverlay();
            }
        }
    });

}
//====================================================================================================

//FUNCION OBTENER DATOS COTIZACIONES=======================================================================
function obtener_datos_cotizaciones_editar(){
    limpiar_datos();
    var folioCotizacionDetalle = $("#cotizEncontradaImprimir option:selected").attr("folio");

    jsonData = {
        "folioCotizacionDetalle": folioCotizacionDetalle
    }

  showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
  $.ajax({
    method: "POST",
    url: "../backend/backend_cotizacion_completa_mostrar.php",
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
        var resultadosTablaCotizaciones= resultadoMostrar["objetoRespuesta"]["cotizaciones"];
        // console.log(resultadosTablaCotizaciones);

        for (i = 0; i < resultadosTablaCotizaciones.length; i++) {
            var resultadosTotales = resultadosTablaCotizaciones[i];
            var cantidadEditar               = resultadosTotales["cantidad"];
            var claveEditar                  = resultadosTotales["clave"];
            var clienteEditar                = resultadosTotales["cliente"];
            var condicionesEditar            = resultadosTotales["condiciones"];
            var descripcionEditar            = resultadosTotales["descripcion"];
            var fechaRegistroEditar          = resultadosTotales["fechaRegistro"];
            var folioCotizacionEditar        = resultadosTotales["folioCotizacion"];
            var folioCotizacionDetalleEditar = resultadosTotales["folioCotizacionDetalle"];
            var idDetalleEditar              = resultadosTotales["idDetalle"];
            var idProducto                   = resultadosTotales["idProducto"];
            var importeEditar                = resultadosTotales["importe"];
            var nombreEditar                 = resultadosTotales["nombre"];
            var precioUnitarioEditar         = resultadosTotales["precioUnitario"];
            var telefonoEditar               = resultadosTotales["telefono"];
            totalEditar                      = resultadosTotales["total"];

            var tabla = document.querySelectorAll("#tablaProductosAnadidosEditar tbody tr");
            var ref = tabla.length + 1;
            var num = ref;
            var columna2 = 2;
            var columna3 = 3;
            var columna4 = 4;
            var columna5 = 5;

            var htmlProdCotizEditar =
            "<tr class='resultados' fila='"+num+"'>"+
                "<td class='clavesProductos'>"+claveEditar+"</td>"+
                "<td class='desProductos'>"+descripcionEditar+"</td>"+
                "<td class='cantProductos' columna='"+columna2+"'>"+cantidadEditar+"</td>"+
                "<td class='precioProductos' columna='"+columna3+"'>"+precioUnitarioEditar+"</td>"+
                "<td class='totalImporteProductos' columna='"+columna4+"'>"+importeEditar+"</td>"+
                "<td class='' columna='"+columna5+"'><button type='button' class='btn btn-outline-danger botonEliminar' onclick='eliminarProductoEditar(this, "+idProducto+","+importeEditar+", "+idDetalleEditar+")' style='width: 50%;'><img src='../iconos/eliminar.png' style='width: 20px;'></button><br><button type='button' class='btn btn-outline-warning botonEditarProducto' onclick='abrirPopupActualizarProductos("+cantidadEditar+", "+precioUnitarioEditar+", "+idProducto+", "+idDetalleEditar+", "+num+", "+columna2+", "+columna3+", "+columna4+", "+columna5+");' style='width: 50%;'><img src='../iconos/editar.png' style='width: 20px;'></button><input type='hidden' class='totalProductosEditar' value='"+importeEditar+"'/></td>"+
                "<td class='idProductos' style='visibility:collapse; display:none;'>"+idProducto+"</td>"+
            "</tr>";
            $(".prodCotizEditar").append(htmlProdCotizEditar);

            actualizarTotalCotizacion();
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
                    "<select name='cliente_cotiz_editar' class='form-control' id='cliente_cotiz_editar'>"+opcionesClientes+"</select>";
                    $(".selectClienteEditar").html(htmlSelectClientesEditar);

                    $("#cliente_cotiz_editar option:contains("+clienteEditar+")").attr('selected', true);
                    closeMessageOverlay();
                }
            }
        });

        var htmlCampoCondicionesEditar =
        "<label for='condiciones' style='font-size: 40px;'>CONDICIONES COMERCIALES</label>"+
        "<textarea class='form-control' name='condicionesEditar' id='condicionesEditar' rows='4'>"+condicionesEditar+"</textarea>";
        $(".condicionesEditar").html(htmlCampoCondicionesEditar);

        var htmlCampoFechaRegistroEditar =
        "<label>Fecha Registro</label>"+
        "<input type='date' name='fecha_editar' id='fecha_editar' class='form-control' value='"+fechaRegistroEditar+"'>";
        $(".fechaEditar").html(htmlCampoFechaRegistroEditar);

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
                "<select name='empresa_cotiz_editar' class='form-control' id='empresa_cotiz_editar'>"+opcionesEmpresas+"</select>";
                $(".selectEmpresaEditar").html(htmlSelectEmpresas);

                // $("#empresa_cotiz_editar option[value='"+ nombreEditar +"']").attr("selected",true);
                $("#empresa_cotiz_editar option:contains("+nombreEditar+")").attr('selected', true);

                closeMessageOverlay();
              }
            }
        });

        var htmlCampoTelefonoEditar =
        "<label>Teléfono</label>"+
        "<input type='text' name='campoTelefonoEditar' id='campoTelefonoEditar' class='form-control' value='"+telefonoEditar+"'>";
        $(".telefonoEditar").html(htmlCampoTelefonoEditar);

        var htmlBotonAgregarProducto =
        "<br>"+
        // "<label>Agregar Producto</label>"+
        "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacioneEditar()' style='width: 100%;'><img src='../iconos/mas.png' style='width: 30px;'>Agregar Producto</button>";
        $(".botonAgregarProductoEditar").html(htmlBotonAgregarProducto);

        var htmlBotonActualizar =
        "<div class='text-center'>"+
            "<label>ACTUALIZAR</label>"+
        "</div>"+
        "<div class='text-center'>"+
            "<button type='button' class='btn btn-outline-success' onclick='actualizarDatosCotizacion(0);' style='width: 20%;'><img src='../iconos/actualizar.png' style='width: 40px;'></button>"+
        "</div>";
        $(".botonActualizar").html(htmlBotonActualizar);

        closeMessageOverlay();
      }
    }
  });
}
//====================================================================================================

//FUNCION OBTENER DATOS PRODUCTOS=======================================================================
function agregarProductoCotizacioneEditar(){

    $(".campoClaveProductoEditar").show();
    $(".campoDescripcionProductoEditar").show();
    $(".campoUnidadProductoEditar").show();
    $(".listaProductosEditar").show();
    $(".listaProductosClaveEditar").show();
    $(".botonCancelarProductoEditar").show();

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
                "<input list='lista' name='claveDelParámetro' id='selecciónEditar' class='form-control' onchange='selectProductosCombinarEditar(this);'>"+

                "<datalist id='lista'>"+opcionesListaProductos+"</datalist>";
                $(".listaProductosEditar").html(htmlDivListasProductos);

                var htmlDivListasProductosClave =
                "<label for='selección'>Buscar Productos por clave:</label>"+
                "<input list='listaClave' name='claveDelParámetros' id='selecciónClaveEditar' class='form-control' onchange='selectProductosCombinarClaveEditar(this);'>"+

                "<datalist id='listaClave'>"+opcionesListaProductosClave+"</datalist>";
                $(".listaProductosClaveEditar").html(htmlDivListasProductosClave);

                var htmlBotonCancelarProducto =
                "<br>"+
                "<button class='btn btn-outline-danger' type='button' onclick='cancelarProductoCotizacioneEditar()' style='width: 100%;'><img src='../iconos/desactivado.png' style='width: 30px;'>Cancelar</button>";
                $(".botonCancelarProductoEditar").html(htmlBotonCancelarProducto);

                closeMessageOverlay();
            }
        }
    });
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS===============================================================
function selectProductosCombinarEditar(e){
    descripcionProductosSeleccionada = $(e).val();

    claveProducto = $('#lista').find('option[value="'+descripcionProductosSeleccionada+'"]').data('clave');
    idProductoLista = $('#lista').find('option[value="'+descripcionProductosSeleccionada+'"]').data('id');
    existenciaProductoLista = $('#lista').find('option[value="'+descripcionProductosSeleccionada+'"]').data('existencia');
    unidadProductoLista = $('#lista').find('option[value="'+descripcionProductosSeleccionada+'"]').data('unidad');

    var htmlCampoClaveProducto =
    "<label for='clave_producto'>Clave</label>"+
    "<input type='text' name='clave_producto_editar' id='clave_producto_editar' class='form-control' value='"+claveProducto+"'>";
    $(".campoClaveProductoEditar").html(htmlCampoClaveProducto);

    var htmlCampoDescripcionProducto =
    "<label>Descripción</label>"+
    "<input type='text' name='descProductoEditar' id='descProductoEditar' class='form-control' value='"+descripcionProductosSeleccionada+"'>";
    $(".campoDescripcionProductoEditar").html(htmlCampoDescripcionProducto);

    var htmlCampoUnidadProducto =
    "<label for='clave_producto'>Unidad</label>"+
    "<input type='text' name='unidad_producto_editar' id='unidad_producto_editar' class='form-control' value='"+unidadProductoLista+"'>";
    $(".campoUnidadProductoEditar").html(htmlCampoUnidadProducto);

    var htmlCampoCantidadProductosEditar =
    "<label>Cantidad</label>"+
    "<input type='text' id='cantidadProductoEditar' class='form-control' onKeypress='soloNumeros(this);' placeholder='Ingresa cantidad'>";
    $(".campoCantidadEditar").html(htmlCampoCantidadProductosEditar);

    var htmlCampoPrecioProductosEditar =
    "<label>Precio de lista</label>"+
    "<input type='text' id='precioListaEditar' class='form-control' onKeypress='soloNumeros(this);' style='text-align: right;' placeholder='Ingresa importe'>";
    $(".precioListaEditar").html(htmlCampoPrecioProductosEditar);

    var htmlBotonAgregarNuevoProducto =
    "<br>"+
    // "<label>Agregar Producto</label>"+
    "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacionEditar("+idProductoLista+")' style='width: 100%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'>Agregar Producto</button>";
    $(".botonAgregarProductoNuevoEditar").html(htmlBotonAgregarNuevoProducto);

}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS===============================================================
function selectProductosCombinarClaveEditar(e){
    claveProducto = $(e).val();

    descripcionProductosSeleccionada = $('#listaClave').find('option[value="'+claveProducto+'"]').data('descripcion');
    idProductoLista = $('#listaClave').find('option[value="'+claveProducto+'"]').data('id');
    existenciaProductoLista = $('#listaClave').find('option[value="'+claveProducto+'"]').data('existencia');
    unidadProductoLista = $('#listaClave').find('option[value="'+claveProducto+'"]').data('unidad');

    var htmlCampoClaveProducto =
    "<label for='clave_producto'>Clave</label>"+
    "<input type='text' name='clave_producto_editar' id='clave_producto_editar' class='form-control' value='"+claveProducto+"'>";
    $(".campoClaveProductoEditar").html(htmlCampoClaveProducto);

    var htmlCampoDescripcionProducto =
    "<label>Descripción</label>"+
    "<input type='text' name='descProductoEditar' id='descProductoEditar' class='form-control' value='"+descripcionProductosSeleccionada+"'>";
    $(".campoDescripcionProductoEditar").html(htmlCampoDescripcionProducto);

    var htmlCampoUnidadProducto =
    "<label for='clave_producto'>Unidad</label>"+
    "<input type='text' name='unidad_producto_editar' id='unidad_producto_editar' class='form-control' value='"+unidadProductoLista+"'>";
    $(".campoUnidadProductoEditar").html(htmlCampoUnidadProducto);

    var htmlCampoCantidadProductosEditar =
    "<label>Cantidad</label>"+
    "<input type='text' id='cantidadProductoEditar' class='form-control' onKeypress='soloNumeros(this);' placeholder='Ingresa cantidad'>";
    $(".campoCantidadEditar").html(htmlCampoCantidadProductosEditar);

    var htmlCampoPrecioProductosEditar =
    "<label>Precio de lista</label>"+
    "<input type='text' id='precioListaEditar' class='form-control' onKeypress='soloNumeros(this);' style='text-align: right;' placeholder='Ingresa importe'>";
    $(".precioListaEditar").html(htmlCampoPrecioProductosEditar);

    var htmlBotonAgregarNuevoProducto =
    "<br>"+
    "<label>Agregar Producto</label>"+
    "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacionEditar("+idProductoLista+")' style='width: 30%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'></button>";
    $(".botonAgregarProductoNuevoEditar").html(htmlBotonAgregarNuevoProducto);
}
//====================================================================================================

//FUNCION OCULTAR DATOS INPUT PRODUCTOS===============================================================
function cancelarProductoCotizacioneEditar(){
    $(".campoClaveProductoEditar").hide();
    $(".campoDescripcionProductoEditar").hide();
    $(".campoUnidadProductoEditar").hide();
    $(".listaProductosEditar").hide();
    $(".listaProductosClaveEditar").hide();
    $(".botonCancelarProductoEditar").hide();
    $(".campoCantidadEditar").hide();
    $(".precioListaEditar").hide();
    $(".botonAgregarProductoNuevoEditar").hide();

    $("#clave_producto_editar").val("");
    $("#descProductoEditar").val("");
    $("#unidad_producto_editar").val("");
    $("#selecciónEditar").val("");
    $("#selecciónClaveEditar").val("");
    $("#cantidadProductoEditar").val("");
    $("#precioListaEditar").val("");
}
//====================================================================================================

// //FUNCION AGREGAR NUEVO PRODUCTOS=======================================================================
function agregarProductoCotizacionEditar(idProductoLista){

    var precioLista = $("#precioListaEditar").val();
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
        "<td><button type='button' class='btn btn-outline-danger botonEliminar' onclick='eliminarProductoNvoEditar(this, "+idProductoLista+","+importe+")' style='width: 50%;'><img src='../iconos/eliminar.png' style='width: 20px;'></button><br><input type='hidden' class='totalProductosEditar' value='"+importe+"'/></td>"+
        "<td class='idProductos' style='visibility:collapse; display:none;' posicion='"+contadorProductos+"'>"+idProductoLista+"</td>"+
    "</tr>";
    $(".prodCotizEditar").append(htmlProdCotizEditarInsertar);

    contadorProductos++;

    $("#selecciónEditar").val("");
    $("#selecciónClaveEditar").val("");
    $("#unidad_producto_editar").val("");
    $("#clave_producto_editar").val("");
    $("#descProductoEditar").val("");
    $("#cantidadProductoEditar").val("");
    $("#precioListaEditar").val("");

    actualizarTotalCotizacion();
}
//====================================================================================================

//FUNCION ELIMINAR PRODUCTO NUEVO===========================================================================
function eliminarProductoNvoEditar(valor, idProducto, importe){
    var total = $(".cantidadTotalEditar").val();

    var eliminarProd = total - importe;
    $(".totalCantidadProductosEditar").text(moneda+eliminarProd.toFixed(2));
    valor.closest('tr').remove();

}
//====================================================================================================

//FUNCION ELIMINAR PRODUCTO DE BASE===========================================================================
function eliminarProductoEditar(valor, idProducto, importe, idDetalleEditar){
    var total = $(".cantidadTotalEditar").val();
    folioCotizacionElim = $("#cotizEncontradaImprimir option:selected").attr("folio");
    idProductoEli = idProducto;
    idDetalleEli = idDetalleEditar;

    var eliminarProd = total - importe;
    $(".totalCantidadProductosEditar").text(moneda+eliminarProd.toFixed(2));
    valor.closest('tr').remove();
    actualizarDatosCotizacion(1);
}
//====================================================================================================

//FUNCION ACTUALIZAR DATOS TABLA==========================================================================
function actualizarProductos(e){
    cantidad = $("#cantidadEditar").val();
    precioUnitario  = $("#precioUnitarioEditar").val();

    importe = cantidad * precioUnitario;

    if ((fila >= 1) && (col2 == 2) && (col3 == 3) && (col4 == 4) && (col5 == 5)) {
    celdas = document.getElementById('tablaProductosAnadidosEditar').rows[fila].cells;

    celdas[col2].innerHTML = cantidad;
    celdas[col3].innerHTML = precioUnitario;
    celdas[col4].innerHTML = importe;

    var datosActualizadosCotiz = {
        cantidad: cantidad,
        precioUnitario: precioUnitario
    }

    actualizarDatos.push(datosActualizadosCotiz);
    // console.log(actualizarDatos);

    var inputTotal =  celdas[col5];
    var totalInp = inputTotal.querySelectorAll("input");
    var totalCotiz = totalInp[0].value = importe;

    actualizarTotalCotizacion();
  }
}
//====================================================================================================

//FUNCION SUMAR IMPORTE MOSTRAR TOTAL===========================================================================
function actualizarTotalCotizacion(){
    var total = 0;

    $('.totalProductosEditar').each(function(){

        if (!isNaN($(this).val())) {
          total += Number($(this).val());
          $(".totalCantidadProductosEditar").text(moneda+total.toLocaleString('es-MX'));
          $(".cantidadTotalEditar").val(total);
        }else{alert("si es nan");}
    });
}
//====================================================================================================

//FUNCION ACTUALIZAR DATOS PRODUCTO===========================================================================
function actualizarDatosCotizacion(operacion){

    $(".productosAgregadosCotizEditar").each(function(){
        var posicion = $(this).attr("posicion");

        var descripcionProducto = $(".desProductos"+"[posicion='"+posicion+"']").text();
        var precioProductos = $(".precioProductos"+"[posicion='"+posicion+"']").text();
        var caatidadProducto = $(".cantProductos"+"[posicion='"+posicion+"']").text();
        var totalImporte = $(".totalImporteProductos"+"[posicion='"+posicion+"']").text();
        var idProductos = $(".idProductos"+"[posicion='"+posicion+"']").text();

        var jsonTempProductosAgregados = {
          "descripcion": descripcionProducto,
          "precioUnitario": precioProductos,
          "cantidad": caatidadProducto,
          "idProducto": idProductos
        }

        productosTotalEditar.push(jsonTempProductosAgregados);

    });

    if (operacion == 0) {
        eliminado = 0;
        var actualizar = 1;
        var idProductoEdit = productoId;
        var idDetalleEdit = detalleId;
        var cantidadNueva = cantidad;
        var precioUnitarioNueva = precioUnitario;
        var idUsuarioEdit = <?=$idUsuario;?>;
        var folioCotizacionDetalle = $("#cotizEncontradaImprimir option:selected").attr("folio");
        var fechaEditar = $("#fecha_editar").val();
        var idClienteEditar = $("#cliente_cotiz_editar").val();
        var totalTablaEditar =$(".cantidadTotalEditar").val();
        var condisionesEditar = $("#condicionesEditar").val();
        var productosArrayEditar = productosTotalEditar;

        var jsonData = {
          "idDetalle": idDetalleEdit,
          "idProducto": idProductoEdit,
          "idUsuarioOper": idUsuarioEdit,
          "cantidad": cantidadNueva,
          "precioUnitario": precioUnitarioNueva,
          "actualizar": actualizar,
          "eliminado": eliminado,
          "folioCotizacion": folioCotizacionDetalle,
          "fecha": fechaEditar,
          "productos": JSON.stringify(productosArrayEditar)
        }
    }
    else if (operacion == 1){
        eliminado = 1;
        var actualizar = 1;
        var idProductoEdit = idProductoEli;
        var idDetalleEdit = idDetalleEli;
        var idUsuarioEdit = <?=$idUsuario;?>;

        var jsonData = {
          "idDetalle": idDetalleEdit,
          "idProducto": idProductoEdit,
          "idUsuarioOper": idUsuarioEdit,
          "actualizar": actualizar,
          "eliminado": eliminado,
          "folioCotizacion": folioCotizacionElim
        }
    }

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_cotizacion_registro_misma_cotizacion.php",
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
    obtener_datos_proveedor_editar();
    descripcionProductosSeleccionada = "";
    claveProducto = "";
    idProductoLista = "";
    existenciaProductoLista = "";
    unidadProductoLista = "";
    moneda = "TOTAL $";
    productosTotalEditar = new Array();//
    productosTabla = new Array();//
    actualizarDatos = new Array();
    totalEditar = 0;
    celdas = "";
    cantidad = "";
    precioUnitario = "";
    importe = "";
    eliminado = 0
    idProductoEli = "";
    idDetalleEli = "";
    folioCotizacionElim = "";
    contadorProductos = 0;

});
//====================================================================================================
</script>
