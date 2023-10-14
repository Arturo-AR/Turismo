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
            <div class="col-lg-2 descripcionCotizUnica"></div>
            <div class="col-lg-3 fechaEditarCotizGeneral">
                <!-- <label>Fecha Registro</label>
                <input type='text' class='form-control datepicker' name='fecha_editarCotizGeneral' id='fecha_editarCotizGeneral' placeholder='AAAA-MM-DD' onchange="selectFoliosEditarGeneral();" /> -->
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 selectEmpresaEditarCotizGeneral"></div>
            <div class="col-lg-3 selectClienteEditarCotizGeneral"></div>
            <div class="col-lg-3 telefonoEditarCotizGeneral"></div>
            <div class="col-lg-2 botonAgregarProductoEditarCotizGeneral"></div>
        </div>
        <div class="row">
            <div class="col-lg-4 listaProductosEditarCotizGeneral"></div>
            <div class="col-lg-3 listaProductosClaveSatEditarCotizGeneral"></div>
            <div class="col-lg-3 listaUnidadProductoEditarCotizGeneral"></div>
            <div class="col-lg-2 botonCancelarProductoEditarCotizGeneral"></div>
        </div>
        <div class="row">
            <div class="col-lg-2 listaProductosClaveEditarCotizGeneral"></div>
            <div class="col-lg-6 campoDescripcionProductoEditarCotizGeneral"></div>
        </div>
        <div class="row">
            <div class="col-lg-2 campoCantidadEditarCotizGeneral"></div>
            <div class="col-lg-2 campoPrecioListaEditarCotizGeneral"></div>
            <div class="col-lg-2 botonAgregarProductoTablaEditarCotizGeneral"></div>
        </div>
        <div class="table-responsive" id="tablaCotizEditProdCotizGeneral">
            <table class="table table-primary bg-light tablaProductosTotalEditarCotizGeneral" id="tablaProductosAnadidosEditarCotizGeneral">
                <thead>
                    <tr>
                        <th>Clave</th>
                        <th>Clave SAT</th>
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
function selectFoliosEditarGeneral(){

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
                var resultadosTotales = resultadoMostrar["objetoRespuesta"]["cotizaciones_unica"];
                
                var opcionesCotizacionGeneralEditar = "<option value='' data-idcotizacion='' data-descripcion='' data-fecha='' data-cliente=''></option>";

                for (i = 0; i < resultadosTotales.length; i++) {
                    var resultadosUnica = resultadosTotales[i];
                    var idCotizacionUnica = resultadosUnica["idCotizacionUnica"];
                    var descripcion  = resultadosUnica["descripcion"];
                    var fechaCotiz   = resultadosUnica["fecha_registro"];
                    var clienteCotiz = resultadosUnica["idCliente"];

                    opcionesCotizacionGeneralEditar += "<option data-descripcion='"+descripcion+"' data-fecha='"+fechaCotiz+"' data-cliente='"+clienteCotiz+"' data-idcotizacion='"+idCotizacionUnica+"' value='"+idCotizacionUnica+"'>"+descripcion+"</option>";

                }

                var htmlSelectCotizacionesProveedor =
                "<label>Buscar Cotizaciones</label>"+
                "<input type='text' list='cotizEditar' name='cotizEncontradaImprimirCotizGeneral' id='cotizEncontradaImprimirCotizGeneral' class='form-control' onchange='obtener_datos_cotizaciones_editar_general();'>"+

                "<datalist id='cotizEditar'>"+opcionesCotizacionGeneralEditar+"</datalist>";
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

    var idCotizGeneral  = $("#cotizEncontradaImprimirCotizGeneral").val();

    var descCotizEditar = $('#cotizEditar').find('option[value="'+idCotizGeneral+'"]').data('descripcion');

    var htmlDescripcionCotizacion =
    "<label>Descripción Cotización</label>"+
    "<input type='text' class='form-control' name='descVotizUnica' id='descVotizUnica' value='"+descCotizEditar+"' disabled>";
    $(".descripcionCotizUnica").html(htmlDescripcionCotizacion);

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
            console.log(resultadosTablaCotizaciones);

            for (i = 0; i < resultadosTablaCotizaciones.length; i++) {
                var resultadosTotales = resultadosTablaCotizaciones[i];
                var cantidadEditar       = resultadosTotales["cantidad"];
                var claveEditar          = resultadosTotales["clave"];
                var claveSatEditar       = resultadosTotales["claveSat"];
                var clienteEditar        = resultadosTotales["cliente"];
                var condicionesEditar    = resultadosTotales["condiciones"];
                var descripcionEditar    = resultadosTotales["descripcion"];
                var fechaRegistroEditar  = resultadosTotales["fecha_registro"];
                idCotizacionUnica        = resultadosTotales["idCotizacionUnica"];
                var idSubCotizacionUnica = resultadosTotales["idSubcotizUnica"];
                var idProducto           = resultadosTotales["idProducto"];
                var importeEditar        = resultadosTotales["importe"];
                var nombreEditar         = resultadosTotales["nombre"];
                var precioUnitarioEditar = resultadosTotales["precioUnitario"];
                var telefonoEditar       = resultadosTotales["telefono"];
                totalEditar              = resultadosTotales["total"];
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
                var columna6 = 6;

                var htmlProdCotizEditar =
                "<tr fila='"+num+"'>"+
                    "<td class='clavesProductos' columna='"+columna0+"'>"+claveEditar+"</td>"+
                    "<td class='clavesSatProductos' columna='"+columna1+"'>"+claveSatEditar+"</td>"+
                    "<td class='desProductos' columna='"+columna2+"'>"+descripcionEditar+"</td>"+
                    "<td class='cantProductos' columna='"+columna3+"'>"+cantidadEditar+"</td>"+
                    "<td class='precioProductos' columna='"+columna4+"'>"+precioUnitarioEditar+"</td>"+
                    "<td class='totalImporteProductos' columna='"+columna5+"'>"+importeEditar+"</td>"+
                    "<td><button type='button' class='btn btn-outline-danger botonEliminar' onclick='eliminarProductoEditarGeneral(this, "+idProducto+","+importeEditar+", "+idCotizacionUnica+", "+idSubCotizacionUnica+")' style='width: 50%;'><img src='../iconos/eliminar.png' style='width: 20px;'></button><br><button type='button' class='btn btn-outline-warning botonEditarProducto' onclick='abrirPopupEditarCotizGeneral("+cantidadEditar+", "+precioUnitarioEditar+", "+idProducto+", "+idCotizacionUnica+", "+num+", "+columna0+", "+columna1+", "+columna2+", "+columna3+", "+columna4+", "+columna5+", "+columna6+", "+idSubCotizacionUnica+");' style='width: 50%;'><img src='../iconos/editar.png' style='width: 20px;'></button><input type='hidden' class='totalProductosEditar' columna='"+columna6+"' value='"+importeEditar+"'/></td>"+
                    "<td class='idProductos' style='visibility:collapse; display:none;'>"+idProducto+"</td>"+
                "</tr>";

                $(".prodCotizEditarCotizGeneral").append(htmlProdCotizEditar);

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

                        var htmlCampoTelefonoEditar =
                        "<label>Teléfono</label>"+
                        "<input type='text' name='campoTelefonoEditar' id='campoTelefonoEditar' class='form-control' value='"+telefonoCliente+"'>";
                        $(".telefonoEditarCotizGeneral").html(htmlCampoTelefonoEditar);
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
                    // console.log(idProducto);

                    opcionesListaProductos += "<option data-unidad='"+unidadProductos+"' data-existencia='"+existenciaProductos+"' data-clave='"+claveProducto+"' data-sat='"+claveSat+"' data-descripcion='"+descripcionProducto+"' data-id='"+idProducto+"' value='"+descripcionProducto+"'>"+claveSat+"</option>";

                    opcionesListaProductosClaveSat += "<option data-unidad='"+unidadProductos+"' data-existencia='"+existenciaProductos+"' data-clave='"+claveProducto+"' data-sat='"+claveSat+"' data-id='"+idProducto+"' data-descripcion='"+descripcionProducto+"' value='"+claveSat+"'>"+descripcionProducto+"</option>";

                }

                var htmlDivListasProductos =
                "<label for='seleccion'>Buscar Productos:</label>"+
                "<input type='text' list='lista' name='claveDelParámetro' id='seleccion' class='form-control' onchange='selectProductosCombinar(this, 0);'>"+

                "<datalist id='lista'>"+opcionesListaProductos+"</datalist>";
                $(".listaProductosEditarCotizGeneral").html(htmlDivListasProductos);

                var htmlDivListasProductosClave =
                "<label for='clave_producto'>Buscar Clave Producto:</label>"+
                "<input type='text' list='listaClave' name='claveDelParámetros' id='clave_producto' class='form-control' onchange='selectProductosCombinarClave(this, 0);'>"+

                "<datalist id='listaClave'>"+opcionesListaProductosClave+"</datalist>";
                $(".listaProductosClaveEditarCotizGeneral").html(htmlDivListasProductosClave);

                var htmlDivListasProductosClaveSat =
                "<label for='seleccionClave'>Buscar Clave SAT:</label>"+
                "<input type='text' list='listaClaveSat' name='claveDelParámetroSat' id='seleccionClave' class='form-control' onchange='selectProductosCombinarClaveSat(this, 0);'>"+

                "<datalist id='listaClaveSat'>"+opcionesListaProductosClaveSat+"</datalist>";
                $(".listaProductosClaveSatEditarCotizGeneral").html(htmlDivListasProductosClaveSat);

                var htmlBotonCancelarProducto =
                "<br>"+
                "<button class='btn btn-outline-danger' type='button' onclick='cancelarProductoCotizacioneEditarGeneral()' style='width: 100%;'><img src='../iconos/desactivado.png' style='width: 30px;'>Cancelar</button>";
                $(".botonCancelarProductoEditarCotizGeneral").html(htmlBotonCancelarProducto);

                var htmlDescripcionProductoEditar = 
                "<label>Descripción Producto</label>"+
                "<textarea class='form-control' name='descProducto' id='descProducto' rows='4' onchange='selectProductosCombinar(this, 1)'></textarea>";
                $(".campoDescripcionProductoEditarCotizGeneral").html(htmlDescripcionProductoEditar);

                var htmlCampoCantidadEditar =
                "<label for='cantidad'>Cantidad</label>"+
                "<input type='text' id='cantidadProductoEditar' class='form-control' onKeypress='soloNumeros(this);' placeholder='Ingresa cantidad'>";
                $(".campoCantidadEditarCotizGeneral").html(htmlCampoCantidadEditar);

                var htmlCampoPrecioditar =
                "<label for='importe'>Precio de lista</label>"+
                "<input type='text' id='precioListaEditar' class='form-control' onKeypress='soloNumeros(this);' placeholder='Ingresa importe'>";
                $(".campoPrecioListaEditarCotizGeneral").html(htmlCampoPrecioditar);

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
                $(".listaUnidadProductoEditarCotizGeneral").html(htmlDivListasUnidadSat);

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
    unidadProductoGlobal = $(e).val();

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
    var desProductos = $("#seleccion").val();
    var descripcionNuevaUnidad = $("#descProducto").val(unirDescripcion+ "|" +unidadProductoGlobal);
    var unirProductos = $("#seleccion").val(desProductos+ "|" +unidadProductoGlobal);

    descripcionProductosSeleccionadoGlobal = $("#descProducto").val();

    idProductoGlobal = $('#lista').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('id');

    if (idProductoGlobal == undefined) {
        $("#clave_producto").val("");
    }


    var htmlBotonAgregarProducto =
    "<br>"+
    "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacionEditarGeneral("+idProductoGlobal+")' style='width: 100%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'>Agregar Producto</button>";
    $(".botonAgregarProductoTablaEditarCotizGeneral").html(htmlBotonAgregarProducto);
    
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS===============================================================
function selectProductosCombinar(e, operacion){
    descripcionProductosSeleccionadoGlobal = $(e).val();
    // console.log(descripcionProductosSeleccionadoGlobal, operacion);

    if (operacion == 0) {
        claveProductoGlobal = $('#lista').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('clave');
        claveProductoSatGlobal = $('#lista').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('sat');
        idProductoGlobal = $('#lista').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('id');
        existenciaProductoGlobal = $('#lista').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('existencia');
        unidadProductoGlobal = $('#lista').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('unidad');

        // console.log(claveProductoGlobal, claveProductoSatGlobal, idProductoGlobal, existenciaProductoGlobal, unidadProductoGlobal);

        console.log(idProductoGlobal);

        if (idProductoGlobal == undefined) {
            $("#clave_producto").val("");
            $("#descProducto").val(descripcionProductosSeleccionadoGlobal);
            obtener_unidad_pieza();
            obtener_unidad_clave_sat();
        }else{
            $("#seleccionClave").val(claveProductoSatGlobal);
            $("#seleccionUnidad").val(unidadProductoGlobal);
            $("#clave_producto").val(claveProductoGlobal);
            $("#descProducto").val(descripcionProductosSeleccionadoGlobal);
            $("#seleccion").val(descripcionProductosSeleccionadoGlobal);
        }
    }
    else if (operacion == 1) {
        idProductoGlobal = $('#lista').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('id');
        // console.log(idProductoGlobal);
        if (idProductoGlobal == undefined) {
            $("#seleccion").val(descripcionProductosSeleccionadoGlobal);
            $("#clave_producto").val("");
            obtener_unidad_pieza();
            obtener_unidad_clave_sat();
        }
    }
    
    var htmlBotonAgregarProducto =
    "<br>"+
    "<button class='btn btn-success' type='button' onclick='agregarProductoCotizacionEditarGeneral("+idProductoGlobal+")' style='width: 100%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'>Agregar Producto</button>";
    $(".botonAgregarProductoTablaEditarCotizGeneral").html(htmlBotonAgregarProducto);

}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS=========================================================================
function selectProductosCombinarClaveSat(e, operacion){
    claveProductoSatGlobal = $(e).val();
    // console.log(claveProductoSatGlobal);

    if (operacion == 0) {
        descripcionProductosSeleccionadoGlobal = $('#listaClaveSat').find('option[value="'+claveProductoSatGlobal+'"]').data('descripcion');
        idProductoGlobal = $('#listaClaveSat').find('option[value="'+claveProductoSatGlobal+'"]').data('id');
        existenciaProductoGlobal = $('#listaClaveSat').find('option[value="'+claveProductoSatGlobal+'"]').data('existencia');
        unidadProductoGlobal = $('#listaClaveSat').find('option[value="'+claveProductoSatGlobal+'"]').data('unidad');
        claveProductoGlobal = $('#listaClaveSat').find('option[value="'+claveProductoSatGlobal+'"]').data('clave');

        // console.log(descripcionProductosSeleccionadoGlobal,claveProductoGlobal, idProductoGlobal, existenciaProductoGlobal, unidadProductoGlobal);

        if (idProductoGlobal == undefined) {
            $("#unidad_producto").val("");
            $("#clave_producto").val("");
            $("#descProducto").val("");
        }else{
            // $("#seleccionClave").val(claveProductoSatGlobal);
            $("#seleccionUnidad").val(unidadProductoGlobal);
            $("#clave_producto").val(claveProductoGlobal);
            $("#descProducto").val(descripcionProductosSeleccionadoGlobal);
            $("#seleccion").val(descripcionProductosSeleccionadoGlobal);
        }
    }
    else if (operacion == 1) {
        idProductoGlobal = $('#listaClaveSat').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('id');
        // console.log(idProductoGlobal);
        if (idProductoGlobal == undefined) {
            $("#seleccion").val(descripcionProductosSeleccionadoGlobal);
            $("#clave_producto").val("");
        }
    }

    var htmlBotonAgregarProducto =
    "<br>"+
    "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacionEditarGeneral("+idProductoGlobal+")' style='width: 100%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'>Agregar Producto</button>";
    $(".botonAgregarProductoTablaEditarCotizGeneral").html(htmlBotonAgregarProducto);
    
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS=========================================================================
function selectProductosCombinarClave(e, operacion){
    claveProductoGlobal = $(e).val();

    if (operacion == 0) {
        descripcionProductosSeleccionadoGlobal = $('#listaClave').find('option[value="'+claveProductoGlobal+'"]').data('descripcion');
        idProductoGlobal = $('#listaClave').find('option[value="'+claveProductoGlobal+'"]').data('id');
        claveProductoSatGlobal = $('#listaClave').find('option[value="'+claveProductoGlobal+'"]').data('sat');
        existenciaProductoGlobal = $('#listaClave').find('option[value="'+claveProductoGlobal+'"]').data('existencia');
        unidadProductoGlobal = $('#listaClave').find('option[value="'+claveProductoGlobal+'"]').data('unidad');

        // console.log(descripcionProductosSeleccionadoGlobal, claveProductoSatGlobal, idProductoGlobal, existenciaProductoGlobal, unidadProductoGlobal);

        if (idProductoGlobal == undefined) {
            // $("#descProducto").val(descripcionProductosSeleccionadoGlobal);
            console.log(idProductoGlobal);
        }else{
            $("#seleccionClave").val(claveProductoSatGlobal);
            $("#seleccionUnidad").val(unidadProductoGlobal);
            $("#descProducto").val(descripcionProductosSeleccionadoGlobal);
            $("#seleccion").val(descripcionProductosSeleccionadoGlobal);
        }
    }
    else if (operacion == 1) {
        idProductoGlobal = $('#listaClave').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('id');
        // console.log(idProductoGlobal);
        if (idProductoGlobal == undefined) {
            $("#seleccion").val(descripcionProductosSeleccionadoGlobal);
            $("#clave_producto").val("");
        }
    }

    var htmlBotonAgregarProducto =
    "<br>"+
    "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacionEditarGeneral("+idProductoGlobal+")' style='width: 100%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'>Agregar Producto</button>";
    $(".botonAgregarProductoTablaEditarCotizGeneral").html(htmlBotonAgregarProducto);
    
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
function agregarProductoCotizacionEditarGeneral(idProductoGlobal){

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
        "<td class='clavesProductos' posicion='"+contadorProductos+"'>"+claveProductoGlobal+"</td>"+
        "<td class='clavesSatProductos' posicion='"+contadorProductos+"'>"+claveProductoSatGlobal+"</td>"+
        "<td class='desProductos' posicion='"+contadorProductos+"'>"+descripcionProductosSeleccionadoGlobal+"</td>"+
        "<td class='cantProductos' posicion='"+contadorProductos+"'>"+catidadProducto+"</td>"+
        "<td class='precioProductos' posicion='"+contadorProductos+"'>"+precioLista+"</td>"+
        "<td class='totalImporteProductos' posicion='"+contadorProductos+"'>"+importe+"</td>"+
        "<td><button type='button' class='btn btn-outline-danger botonEliminar' onclick='eliminarProductoNvoEditarGeneral(this, "+idProductoGlobal+","+importe+", "+contadorProductos+")' style='width: 50%;'><img src='../iconos/eliminar.png' style='width: 20px;'></button><br><input type='hidden' class='totalProductosEditar' value='"+importe+"'/></td>"+
        "<td class='idProductos' style='visibility:collapse; display:none;' posicion='"+contadorProductos+"'>"+idProductoGlobal+"</td>"+
    "</tr>";
    $(".prodCotizEditarCotizGeneral").append(htmlProdCotizEditarInsertar);

    contadorProductos++;

    actualizarTotalCotizacionGeneral();

    $("#seleccion").val("");
    $("#clave_producto").val("");
    $("#descProducto").val("");
    $("#cantidadProductoEditar").val("");
    $("#precioListaEditar").val("");

    obtener_unidad_clave_sat_editar();
    obtener_datos_unidades_editar();

}
//====================================================================================================

//FUNCION ELIMINAR PRODUCTO NUEVO===========================================================================
function eliminarProductoNvoEditarGeneral(valor, idProducto, importe, posicion){
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
    descripcion  = $("#descripcionEditarCotizGeneral").val();

    importe = cantidad * precioUnitario;

    if ((fila >= 1) && (col1 == 1) && (col2 == 2) && (col3 == 3) && (col4 == 4) && (col5 == 5)) {
    celdas = document.getElementById('tablaProductosAnadidosEditarCotizGeneral').rows[fila].cells;

    celdas[col2].innerHTML = descripcion;
    celdas[col3].innerHTML = cantidad;
    celdas[col4].innerHTML = precioUnitario;
    celdas[col5].innerHTML = importe;

    var inputTotal =  celdas[col6];
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
          "importe": totalImporte,
          "idProducto": idProductos
        }

        productosTabla.push(jsonTempProductosAgregados);

    });

    var actualizar = 1;
    var idProductoEdit = productoId;
    var idCotizUnica = idCotizacionUnica;
    var cantidadNueva = cantidad;
    var precioUnitarioNueva = precioUnitario;
    var descripcionProducto = descripcion;
    var idUsuarioEdit = <?=$idUsuario;?>;
    var idEmpresaEditar = $("#empresa_cotiz_editar option:selected").val();
    var descripcionCotizUnica = $("#cotizEncontradaImprimirCotizGeneral").val();
    var fechaEditar = $("#fecha_editarCotizGeneral").val();
    var idClienteEditar = $("#cliente_cotiz_editarCotizGeneral").val();
    var totalTablaEditar =$(".cantidadTotalEditarCotizGeneral").val();
    var condisionesEditar = $("#condicionesEditarCotizGeneral").val();
    var idSubCotizUnicaEditar = subCotizUnica;
    var productosArrayEditar = productosTabla;

    if (operacion == 0) {
        eliminado = 0;
        actualizar;
        idProductoEdit;
        idCotizUnica;
        cantidadNueva;
        precioUnitarioNueva;
        descripcionProducto;
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
          "descripcionProd": descripcionProducto,
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
    // productosTotalEditar = new Array();
    productosTabla = new Array();
    numFilaArray = new Array();
    totalEditar = 0;
    precioTablaArray = new Array();
    celdas = "";
    cantidad = "";
    precioUnitario = "";
    descripcion = "";
    importe = "";
    eliminado = 0
    idProductoEli = "";
    idDetalleEli = "";
    idCotizUnic = "";
    idCotizacionUnica = "";

    contadorProductos = 0;

    // $(".datepicker").datepicker({
    //   dateFormat: "yy-mm-dd",
    //   dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
    //   dayNamesMin: [ "D", "L", "M", "M", "J", "V", "S" ],
    //   monthNames: [ "ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE" ],
    //   // maxDate: 0
    // });
});
//====================================================================================================
</script>
