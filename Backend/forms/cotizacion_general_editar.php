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
            <div class="col-lg-2 selectCotizEncontradasEditarCotizGeneral"></div>
            <div class="col-lg-3 fechaEditarCotizGeneral"></div>
        </div>
        <div class="row">
            <div class="col-lg-3 selectEmpresaEditarCotizGeneral"></div>
            <div class="col-lg-3 selectClienteEditarCotizGeneral"></div>
            <div class="col-lg-3 telefonoEditarCotizGeneral"></div>
            <div class="col-lg-2 botonAgregarProductoEditarCotizGeneral"></div>
        </div>
        <div class="row">
            <div class="col-lg-5 listaProductosEditarCotizGeneral"></div>
            <div class="col-lg-5 listaProductosClaveEditarCotizGeneral"></div>
            <div class="col-lg-2 botonCancelarProductoEditarCotizGeneral"></div>
        </div>
        <div class="row">
            <div class="col-lg-3 campoUnidadProductoEditarCotizGeneral"></div>
            <div class="col-lg-2 campoClaveProductoEditarCotizGeneral"></div>
            <div class="col-lg-3 campoDescripcionProductoEditarCotizGeneral"></div>
        </div>
        <div class="row">
            <div class="col-lg-2 campoCantidadEditarCotizGeneral"></div>
            <div class="col-lg-2 precioListaEditarCotizGeneral"></div>
            <div class="col-lg-2 botonAgregarProductoNuevoEditarCotizGeneral"></div>
        </div> 
        <div class="table-responsive" id="tablaCotizEditProdCotizGeneral">
            <table class="table table-primary bg-light tablaProductosTotalEditarCotizGeneral" id="tablaProductosAnadidosEditarCotizGeneral">
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
                <tbody class="prodCotizEditarCotizGeneral">
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-lg-8 condicionesEditarCotizGeneral">
            </div>
            <div class="text-center totalCantidadProductosEditarCotizGeneral" style="font-size: 40px; color: #000;"></div>
            <div>
                <input type="hidden" class="cantidadTotalEditarCotizGeneral">
            </div>
        </div>
        <div class="text-center botonActualizarCotizGeneral"></div>
    </div>
</div>
<script>

//FUNCION OBTENER DATOS PROVEEDORES Y FOLIOS=======================================================================
function limpiar_datos_General(){
    $(".prodCotizEditarCotizGeneral").html("");
    $(".selectClienteEditarCotizGeneral").html("");
    $(".condicionesEditarCotizGeneral").html("");
    $(".fechaEditarCotizGeneral").html("");
    $(".selectEmpresaEditarCotizGeneral").html("");
    $(".telefonoEditarCotizGeneral").html("");
    $(".botonAgregarProductoEditarCotizGeneral").html("");
    $(".botonActualizarCotizGeneral").html("");
    $(".totalCantidadProductosEditarCotizGeneral").html("");
}
//====================================================================================================

//FUNCION OBTENER FOLIOS=======================================================================
function selectFoliosEditarGeneral(e){

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_cotizacion_unica_motrar_todas.php",
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
                var resultados = resultadoMostrar["objetoRespuesta"]["cotizaciones_unica"];
                // console.log(resultados);
                var opcionesCotizacionGeneralEditar = "<option value='-1' descripcion=''>Cotizaciones *</option>";

                for (i = 0; i < resultados.length; i++) {
                    var resultadosTotales = resultados[i];
                    // console.log(resultadosTotales);
                    var idCotizacionUnica = resultadosTotales["idCotizacionUnica"];
                    var descripcion   = resultadosTotales["descripcion"];

                    opcionesCotizacionGeneralEditar += "<option value='"+idCotizacionUnica+"' descripcion='"+descripcion+"'>"+descripcion+"</option>";
                }
                var htmlSelectCotizacionesProveedor =
                "<label>Cotizaciones Encontradas</label>"+
                "<select name='cotizEncontradaImprimirCotizGeneral' class='form-control' id='cotizEncontradaImprimirCotizGeneral' onchange='obtener_datos_cotizaciones_editar_general();'>"+opcionesCotizacionGeneralEditar+"</select>";
                $(".selectCotizEncontradasEditarCotizGeneral").html(htmlSelectCotizacionesProveedor);

                closeMessageOverlay();
            }
        }
    });

}
//====================================================================================================

//FUNCION OBTENER DATOS COTIZACIONES=======================================================================
function obtener_datos_cotizaciones_editar_general(){
    limpiar_datos_General();
    var idCotizGeneral = $("#cotizEncontradaImprimirCotizGeneral option:selected").val();

    jsonData = {
        "idCotizacionUnica": idCotizGeneral
    }

  showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
  $.ajax({
    method: "POST",
    url: "../backend/backend_cotizacion_unica_mostrar.php",
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
        var resultadosTablaCotizaciones= resultadoMostrar["objetoRespuesta"]["cotizacion_unica"];
        // console.log(resultadosTablaCotizaciones);

        for (i = 0; i < resultadosTablaCotizaciones.length; i++) {
            var resultadosTotales = resultadosTablaCotizaciones[i];
            var cantidadEditar               = resultadosTotales["cantidad"];
            var claveEditar                  = resultadosTotales["clave"];
            var clienteEditar                = resultadosTotales["cliente"];
            var condicionesEditar            = resultadosTotales["condiciones"];
            var descripcionEditar            = resultadosTotales["descripcion"];//
            var fechaRegistroEditar          = resultadosTotales["fecha_registro"];
            idCotizacionUnica            = resultadosTotales["idCotizacionUnica"];
            var idSubCotizacionUnica         = resultadosTotales["idSubcotizUnica"];//
            var idProducto                   = resultadosTotales["idProducto"];
            var importeEditar                = resultadosTotales["importe"];
            var nombreEditar                 = resultadosTotales["nombre"];
            var precioUnitarioEditar         = resultadosTotales["precioUnitario"];
            var telefonoEditar               = resultadosTotales["telefono"];
            totalEditar                      = resultadosTotales["total"];
            // console.log(idSubCotizacionUnica);

            var tabla = document.querySelectorAll("#tablaProductosAnadidosEditarCotizGeneral tbody tr");
            var ref = tabla.length + 1;
            var num = ref;
            var columna0 = 0;
            var columna1 = 1;
            var columna2 = 2;
            var columna3 = 3;
            var columna4 = 4;
            var columna5 = 5;

            var htmlProdCotizEditar =
            "<tr fila='"+num+"'>"+
                "<td class='clavesProductos'>"+claveEditar+"</td>"+
                "<td class='desProductos' descripcion='"+descripcionEditar+"'>"+descripcionEditar+"</td>"+
                "<td class='cantProductos' columna='"+columna2+"'>"+cantidadEditar+"</td>"+
                "<td class='precioProductos' columna='"+columna3+"'>"+precioUnitarioEditar+"</td>"+
                "<td class='totalImporteProductos' columna='"+columna4+"'>"+importeEditar+"</td>"+
                "<td><button type='button' class='btn btn-outline-danger botonEliminar' onclick='eliminarProductoEditarGeneral(this, "+idProducto+","+importeEditar+", "+idCotizacionUnica+", "+idSubCotizacionUnica+")' style='width: 50%;'><img src='../iconos/eliminar.png' style='width: 20px;'></button><br><button type='button' class='btn btn-outline-warning botonEditarProducto' onclick='abrirPopupEditarCotizGeneral("+cantidadEditar+", "+precioUnitarioEditar+", "+idProducto+", "+idCotizacionUnica+", "+num+", "+columna0+", "+columna1+", "+columna2+", "+columna3+", "+columna4+", "+columna5+", "+idSubCotizacionUnica+");' style='width: 50%;'><img src='../iconos/editar.png' style='width: 20px;'></button><input type='hidden' class='totalProductosEditar' columna='"+columna5+"' value='"+importeEditar+"'/></td>"+
                "<td class='idProductos' style='visibility:collapse; display:none;'>"+idProducto+"</td>"+
            "</tr>";

            $(".prodCotizEditarCotizGeneral").append(htmlProdCotizEditar);

            var trs=document.querySelectorAll("#tablaProductosAnadidosEditarCotizGeneral tbody tr").forEach(function(e){
                produAgreNvo = {
                    descripcion: e.querySelector('.desProductos').innerText,
                    precioUnitario: e.querySelector('.precioProductos').innerText,
                    cantidad: e.querySelector('.cantProductos').innerText,
                    importe: e.querySelector('.totalImporteProductos').innerText,
                    idProducto: e.querySelector('.idProductos').innerText
                };
            });
            productosTabla.push(produAgreNvo);
            // console.log(productosTabla);

            actualizarTotalCotizacionGeneral();
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
                    "<select name='cliente_cotiz_editarCotizGeneral' class='form-control' id='cliente_cotiz_editarCotizGeneral'>"+opcionesClientes+"</select>";
                    $(".selectClienteEditarCotizGeneral").html(htmlSelectClientesEditar);

                    $("#cliente_cotiz_editarCotizGeneral option:contains("+clienteEditar+")").attr('selected', true);
                    closeMessageOverlay();
                }
            }
        });

        var htmlCampoCondicionesEditar =
        "<label for='condiciones' style='font-size: 40px;'>CONDICIONES COMERCIALES</label>"+
        "<textarea class='form-control' name='condicionesEditarCotizGeneral' id='condicionesEditarCotizGeneral' rows='4'>"+condicionesEditar+"</textarea>";
        $(".condicionesEditarCotizGeneral").html(htmlCampoCondicionesEditar);

        var htmlCampoFechaRegistroEditar =
        "<label>Fecha Registro</label>"+
        "<input type='date' name='fecha_editarCotizGeneral' id='fecha_editarCotizGeneral' class='form-control' value='"+fechaRegistroEditar+"'>";
        $(".fechaEditarCotizGeneral").html(htmlCampoFechaRegistroEditar);

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
                $(".selectEmpresaEditarCotizGeneral").html(htmlSelectEmpresas);

                // $("#empresa_cotiz_editar option[value='"+ nombreEditar +"']").attr("selected",true);
                $("#empresa_cotiz_editar option:contains("+nombreEditar+")").attr('selected', true);

                closeMessageOverlay();
              }
            }
        });

        var htmlCampoTelefonoEditar =
        "<label>Teléfono</label>"+
        "<input type='text' name='campoTelefonoEditar' id='campoTelefonoEditar' class='form-control' value='"+telefonoEditar+"'>";
        $(".telefonoEditarCotizGeneral").html(htmlCampoTelefonoEditar);

        var htmlBotonAgregarProducto =
        "<br>"+
        // "<label>Agregar Producto</label>"+
        "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacioneEditarGeneral()' style='width: 100%;'><img src='../iconos/mas.png' style='width: 30px;'>Agregar Producto</button>";
        $(".botonAgregarProductoEditarCotizGeneral").html(htmlBotonAgregarProducto);

        var htmlBotonActualizar =
        "<div class='text-center'>"+
            "<label>ACTUALIZAR</label>"+
        "</div>"+
        "<div class='text-center'>"+
            "<button type='button' class='btn btn-outline-success' onclick='actualizarDatosCotizacionGeneral(0);' style='width: 20%;'><img src='../iconos/actualizar.png' style='width: 40px;'></button>"+
        "</div>";
        $(".botonActualizarCotizGeneral").html(htmlBotonActualizar);

        closeMessageOverlay();
      }
    }
  });
}
//====================================================================================================

//FUNCION OBTENER DATOS PRODUCTOS=======================================================================
function agregarProductoCotizacioneEditarGeneral(){

    $(".campoClaveProductoEditarCotizGeneral").show();
    $(".campoDescripcionProductoEditarCotizGeneral").show();
    $(".campoUnidadProductoEditarCotizGeneral").show();
    $(".listaProductosEditarCotizGeneral").show();
    $(".listaProductosClaveEditarCotizGeneral").show();
    $(".botonCancelarProductoEditarCotizGeneral").show();

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
                "<input list='lista' name='claveDelParámetro' id='selecciónEditar' class='form-control' onchange='selectProductosCombinarEditarGeneral(this);'>"+

                "<datalist id='lista'>"+opcionesListaProductos+"</datalist>";
                $(".listaProductosEditarCotizGeneral").html(htmlDivListasProductos);

                var htmlDivListasProductosClave =
                "<label for='selección'>Buscar Productos por clave:</label>"+
                "<input list='listaClave' name='claveDelParámetros' id='selecciónClaveEditar' class='form-control' onchange='selectProductosCombinarClaveEditarGeneral(this);'>"+

                "<datalist id='listaClave'>"+opcionesListaProductosClave+"</datalist>";
                $(".listaProductosClaveEditarCotizGeneral").html(htmlDivListasProductosClave);

                var htmlBotonCancelarProducto =
                "<br>"+
                "<button class='btn btn-outline-danger' type='button' onclick='cancelarProductoCotizacioneEditarGeneral()' style='width: 100%;'><img src='../iconos/desactivado.png' style='width: 30px;'>Cancelar</button>";
                $(".botonCancelarProductoEditarCotizGeneral").html(htmlBotonCancelarProducto);

                closeMessageOverlay();
            }
        }
    });
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS===============================================================
function selectProductosCombinarEditarGeneral(e){
    descripcionProductosSeleccionada = $(e).val();
    
    claveProducto = $('#lista').find('option[value="'+descripcionProductosSeleccionada+'"]').data('clave');
    idProductoLista = $('#lista').find('option[value="'+descripcionProductosSeleccionada+'"]').data('id');
    existenciaProductoLista = $('#lista').find('option[value="'+descripcionProductosSeleccionada+'"]').data('existencia');
    unidadProductoLista = $('#lista').find('option[value="'+descripcionProductosSeleccionada+'"]').data('unidad');

    var htmlCampoClaveProducto =
    "<label for='clave_producto'>Clave</label>"+
    "<input type='text' name='clave_producto_editar' id='clave_producto_editar' class='form-control' value='"+claveProducto+"'>";
    $(".campoClaveProductoEditarCotizGeneral").html(htmlCampoClaveProducto);

    var htmlCampoDescripcionProducto =
    "<label>Descripción</label>"+
    "<input type='text' name='descProductoEditar' id='descProductoEditar' class='form-control' value='"+descripcionProductosSeleccionada+"'>";
    $(".campoDescripcionProductoEditarCotizGeneral").html(htmlCampoDescripcionProducto);

    var htmlCampoUnidadProducto =
    "<label for='clave_producto'>Unidad</label>"+
    "<input type='text' name='unidad_producto_editar' id='unidad_producto_editar' class='form-control' value='"+unidadProductoLista+"'>";
    $(".campoUnidadProductoEditarCotizGeneral").html(htmlCampoUnidadProducto);

    var htmlCampoCantidadProductosEditar =
    "<label>Cantidad</label>"+
    "<input type='text' id='cantidadProductoEditar' class='form-control' onKeypress='soloNumeros(this);' placeholder='Ingresa cantidad'>";
    $(".campoCantidadEditarCotizGeneral").html(htmlCampoCantidadProductosEditar);

    var htmlCampoPrecioProductosEditar =
    "<label>Precio de lista</label>"+
    "<input type='text' id='precioListaEditarCotizGeneral' class='form-control' onKeypress='soloNumeros(this);' style='text-align: right;' placeholder='Ingresa importe'>";
    $(".precioListaEditarCotizGeneral").html(htmlCampoPrecioProductosEditar);

    var htmlBotonAgregarNuevoProducto =
    "<br>"+
    // "<label>Agregar Producto</label>"+
    "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacionEditarGeneral("+idProductoLista+")' style='width: 100%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'>Agregar Producto</button>";
    $(".botonAgregarProductoNuevoEditarCotizGeneral").html(htmlBotonAgregarNuevoProducto);

}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS===============================================================
function selectProductosCombinarClaveEditarGeneral(e){
    claveProducto = $(e).val();
    
    descripcionProductosSeleccionada = $('#listaClave').find('option[value="'+claveProducto+'"]').data('descripcion');
    idProductoLista = $('#listaClave').find('option[value="'+claveProducto+'"]').data('id');
    existenciaProductoLista = $('#listaClave').find('option[value="'+claveProducto+'"]').data('existencia');
    unidadProductoLista = $('#listaClave').find('option[value="'+claveProducto+'"]').data('unidad');

    var htmlCampoClaveProducto =
    "<label for='clave_producto'>Clave</label>"+
    "<input type='text' name='clave_producto_editar' id='clave_producto_editar' class='form-control' value='"+claveProducto+"'>";
    $(".campoClaveProductoEditarCotizGeneral").html(htmlCampoClaveProducto);

    var htmlCampoDescripcionProducto =
    "<label>Descripción</label>"+
    "<input type='text' name='descProductoEditar' id='descProductoEditar' class='form-control' value='"+descripcionProductosSeleccionada+"'>";
    $(".campoDescripcionProductoEditarCotizGeneral").html(htmlCampoDescripcionProducto);

    var htmlCampoUnidadProducto =
    "<label for='clave_producto'>Unidad</label>"+
    "<input type='text' name='unidad_producto_editar' id='unidad_producto_editar' class='form-control' value='"+unidadProductoLista+"'>";
    $(".campoUnidadProductoEditarCotizGeneral").html(htmlCampoUnidadProducto);

    var htmlCampoCantidadProductosEditar =
    "<label>Cantidad</label>"+
    "<input type='text' id='cantidadProductoEditar' class='form-control' onKeypress='soloNumeros(this);' placeholder='Ingresa cantidad'>";
    $(".campoCantidadEditarCotizGeneral").html(htmlCampoCantidadProductosEditar);

    var htmlCampoPrecioProductosEditar =
    "<label>Precio de lista</label>"+
    "<input type='text' id='precioListaEditarCotizGeneral' class='form-control' onKeypress='soloNumeros(this);' style='text-align: right;' placeholder='Ingresa importe'>";
    $(".precioListaEditarCotizGeneral").html(htmlCampoPrecioProductosEditar);

    var htmlBotonAgregarNuevoProducto =
    "<br>"+
    "<label>Agregar Producto</label>"+
    "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacionEditarGeneral("+idProductoLista+")' style='width: 30%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'></button>";
    $(".botonAgregarProductoNuevoEditarCotizGeneral").html(htmlBotonAgregarNuevoProducto);
}
//====================================================================================================

//FUNCION OCULTAR DATOS INPUT PRODUCTOS===============================================================
function cancelarProductoCotizacioneEditarGeneral(){
    $(".campoClaveProductoEditarCotizGeneral").hide();
    $(".campoDescripcionProductoEditarCotizGeneral").hide();
    $(".campoUnidadProductoEditarCotizGeneral").hide();
    $(".listaProductosEditarCotizGeneral").hide();
    $(".listaProductosClaveEditarCotizGeneral").hide();
    $(".botonCancelarProductoEditarCotizGeneral").hide();
    $(".campoCantidadEditarCotizGeneral").hide();
    $(".precioListaEditarCotizGeneral").hide();
    $(".botonAgregarProductoNuevoEditarCotizGeneral").hide();

    $("#clave_producto_editar").val("");
    $("#descProductoEditar").val("");
    $("#unidad_producto_editar").val("");
    $("#selecciónEditar").val("");
    $("#selecciónClaveEditar").val("");
    $("#cantidadProductoEditar").val("");
    $("#precioListaEditarCotizGeneral").val("");
}
//====================================================================================================

// //FUNCION AGREGAR NUEVO PRODUCTOS=======================================================================
function agregarProductoCotizacionEditarGeneral(idProductoLista){

    var precioLista = $("#precioListaEditarCotizGeneral").val();
    var catidadProducto = $("#cantidadProductoEditar").val();
    var total = 0;

    total = catidadProducto;
    var importe = total * precioLista;

   var htmlProdCotizEditarInsertar =
    "<tr>"+
        "<td class='clavesProductos'>"+claveProducto+"</td>"+
        "<td class='desProductos'>"+descripcionProductosSeleccionada+"</td>"+
        "<td class='cantProductos'>"+catidadProducto+"</td>"+
        "<td class='precioProductos'>"+precioLista+"</td>"+
        "<td class='totalImporteProductos'>"+importe+"</td>"+
        "<td><button type='button' class='btn btn-outline-danger botonEliminar' onclick='eliminarProductoNvoEditarGeneral(this, "+idProductoLista+","+importe+")' style='width: 50%;'><img src='../iconos/eliminar.png' style='width: 20px;'></button><br><input type='hidden' class='totalProductosEditar' value='"+importe+"'/></td>"+
        "<td class='idProductos' style='visibility:collapse; display:none;'>"+idProductoLista+"</td>"+
    "</tr>";
    $(".prodCotizEditarCotizGeneral").append(htmlProdCotizEditarInsertar);

    var trs=document.querySelectorAll("#tablaProductosAnadidosEditarCotizGeneral tbody tr").forEach(function(e){
        produAgreNvo = {
            clave: e.querySelector('.clavesProductos').innerText,
            descripcion: e.querySelector('.desProductos').innerText,
            precioUnitario: e.querySelector('.precioProductos').innerText,
            cantidad: e.querySelector('.cantProductos').innerText,
            idProducto: e.querySelector('.idProductos').innerText
        };
    });
    productosTotalEditar.push(produAgreNvo);

    actualizarTotalCotizacionGeneral();
}
//====================================================================================================

//FUNCION ELIMINAR PRODUCTO NUEVO===========================================================================
function eliminarProductoNvoEditarGeneral(valor, idProducto, importe){
    var total = $(".cantidadTotalEditarCotizGeneral").val();

    var eliminarProd = total - importe;
    $(".totalCantidadProductosEditarCotizGeneral").text(moneda+eliminarProd.toFixed(2));
    valor.closest('tr').remove();

}
//====================================================================================================

//FUNCION ELIMINAR PRODUCTO DE BASE===========================================================================
function eliminarProductoEditarGeneral(valor, idProducto, importe, idCotizacionUnica, idSubCotizacionUnica){
    var total = $(".cantidadTotalEditarCotizGeneral").val();
    idProductoEli = idProducto;
    idCotizUnic = idCotizacionUnica;
    idsubUnica = idSubCotizacionUnica;

    var eliminarProd = total - importe;
    $(".totalCantidadProductosEditarCotizGeneral").text(moneda+eliminarProd.toFixed(2));
    valor.closest('tr').remove();
    actualizarDatosCotizacionGeneral(1);
}
//====================================================================================================

//FUNCION ACTUALIZAR DATOS TABLA==========================================================================
function actualizarProductosGeneral(e){
    cantidad = $("#cantidadEditarCotizGeneral").val();
    precioUnitario  = $("#precioUnitarioEditarCotizGeneral").val();

    importe = cantidad * precioUnitario;

    if ((fila >= 1) && (col1 == 1) && (col2 == 2) && (col3 == 3) && (col4 == 4) && (col5 == 5)) {
    celdas = document.getElementById('tablaProductosAnadidosEditarCotizGeneral').rows[fila].cells;

    // celdas[col1].innerHTML = descripcionExcel;
    // celdas[col2].innerHTML = cantidad;
    // celdas[col3].innerHTML = precioUnitario;
    // celdas[col4].innerHTML = importe;

    celdas[col2].innerHTML = cantidad;
    celdas[col3].innerHTML = precioUnitario;
    celdas[col4].innerHTML = importe;

    var inputTotal =  celdas[col5];
    var totalInp = inputTotal.querySelectorAll("input");
    var totalCotiz = totalInp[0].value = importe;

    actualizarTotalCotizacionGeneral();

  }
}
//====================================================================================================

//FUNCION SUMAR IMPORTE MOSTRAR TOTAL===========================================================================
function actualizarTotalCotizacionGeneral(){
    var total = 0;
    
    $('.totalProductosEditar').each(function(){
        if (!isNaN($(this).val())) {
          total += Number($(this).val());
          $(".totalCantidadProductosEditarCotizGeneral").text(moneda+total.toLocaleString('es-MX'));
          $(".cantidadTotalEditarCotizGeneral").val(total);
        }else{alert("si es nan");}
    });
}
//====================================================================================================

//FUNCION ACTUALIZAR DATOS PRODUCTO===========================================================================
function actualizarDatosCotizacionGeneral(operacion){
    var actualizar = 1;
    var idProductoEdit = productoId;
    var idCotizUnica = idCotizacionUnica;
    var cantidadNueva = cantidad;
    var precioUnitarioNueva = precioUnitario;
    var idUsuarioEdit = <?=$idUsuario;?>;
    var idEmpresaEditar = $("#empresa_cotiz_editar option:selected").val();
    var descripcionCotizUnica = $("#cotizEncontradaImprimirCotizGeneral option:selected").attr("descripcion");
    var fechaEditar = $("#fecha_editarCotizGeneral").val();
    var idClienteEditar = $("#cliente_cotiz_editarCotizGeneral").val();
    var totalTablaEditar =$(".cantidadTotalEditarCotizGeneral").val();
    var condisionesEditar = $("#condicionesEditarCotizGeneral").val();
    var idSubCotizUnicaEditar = subCotizUnica
    var productosArrayEditar = productosTotalEditar;

    if (operacion == 0) {
        eliminado = 0;
        actualizar;
        idProductoEdit;
        idCotizUnica;
        cantidadNueva;
        precioUnitarioNueva;
        idUsuarioEdit;
        idEmpresaEditar;
        fechaEditar;
        idClienteEditar;
        totalTablaEditar;
        condisionesEditar;
        idSubCotizUnicaEditar;
        productosArrayEditar;

        var jsonData = {
          "idCotizacionUnica": idCotizUnica,
          "idProducto": idProductoEdit,
          "idUsuario": idUsuarioEdit,
          "cantidad": cantidadNueva,
          "precioUnitario": precioUnitarioNueva,
          "actualizar": actualizar,
          "eliminado": eliminado,
          "idSubcotizUnica": idSubCotizUnicaEditar,
          "descripcion": descripcionCotizUnica,
          "idCliente": idClienteEditar,
          "fecha_registro": fechaEditar,
          "idEmpresa": idEmpresaEditar,
          "condiciones": condisionesEditar,
          "total": totalTablaEditar,
          "productos": JSON.stringify(productosArrayEditar)
        }
          console.log(jsonData);
    }
    else if (operacion == 1){
        eliminado = 1;
        var actualizar = 1;
        var idProductoEdit = idProductoEli;
        var idCotizUnica = idCotizUnic;
        var idUsuarioEdit = <?=$idUsuario;?>;

        var jsonData = {
          "idCotizacionUnica": idCotizUnica,
          "idProducto": idProductoEdit,
          "idUsuario": idUsuarioEdit,
          "actualizar": actualizar,
          "eliminado": eliminado,
          "idSubcotizUnica": idsubUnica
        }
        console.log(jsonData);
    }

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_cotizacion_unica_actualizar.php",
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
    selectFoliosEditarGeneral();
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
    precioUnitario = "";
    importe = "";
    eliminado = 0
    idProductoEli = "";
    idDetalleEli = "";
    idCotizUnic = "";
    idCotizacionUnica = "";
});
//====================================================================================================
</script>
