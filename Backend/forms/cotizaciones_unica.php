<?php
session_start();
$idUsuario = $_SESSION['idUsuario'];
include 'menu.php';
?>
<div class="panel panel-info">
    <div class="panel-heading">GENERAR COTIZACIÓN</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-4 selectEmpresas"></div>
            <div class="col-sm-4 clientesCotizacionSelect"></div>
            <div class="col-lg-3 campoTelefonoCliente">
                <label>Teléfono</label>
                <input type='text' name='telefono' id='telefono' class='form-control' maxlength="10">
            </div>
            <div class="col-sm-4 campoRfcEmpresas">
                <input type='text' name='rfcEmpresaCotiz' id='rfcEmpresaCotiz' class='form-control' placeholder="RFC Empresa">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 listaProductos"></div>
            <div class="col-lg-4 listaProductosClaveSat"></div>
            <div class="col-lg-2 campoUnidadProducto">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 listaProductosClave"></div>
            <div class="col-lg-6 campoDescripcionProducto">
                <label>Descripción Producto</label>
                <textarea class="form-control" name="descProducto" id="descProducto" rows="4" onchange="selectProductosCombinar(this, 1)"></textarea>
            </div>
            <div class="col-lg-4 table-responsive" style="height: 150px; overflow: auto;">
                <label>Precios anteriores</label>
                <table class="table table-primary bg-light">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Folio</th>
                            <th>Precio</th>
                            <th style="visibility:collapse; display:none;"></th>
                        </tr>
                        <tbody class="cotizAnteriores"></tbody>
                    </thead>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <label for="cantidad">Cantidad</label>
                <input type="text" id="cantidadProducto" class="form-control" onKeypress="soloNumeros(this);" placeholder="Ingresa cantidad">
            </div>
            <div class="col-lg-2">
                <label for="importe">Precio de lista</label>
                <input type="text" id="precioLista" class="form-control" onKeypress="soloNumeros(this);" placeholder="Ingresa importe">
            </div>
            <div class="col-lg-2 botonAgregarProducto"></div>
        </div>
        <div class="table-responsive">
            <table class="table table-primary bg-light tablaProductosTotal" id="tablaProductosAnadidos">
                <thead>
                    <tr>
                        <th>Clave Productos</th>
                        <th>Clave SAT</th>
                        <th>Descripción</th>
                        <th>Precio de Lista</th>
                        <th>Cantidad</th>
                        <th>Importe</th>
                        <th>Eliminar</th>
                        <th style="visibility:collapse; display:none;"></th>
                    </tr>
                </thead>
                <tbody class="prodCotiz">
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <label for="condiciones" style="font-size: 40px;">CONDICIONES COMERCIALES</label>
                <textarea class="form-control" id="condiciones" rows="4" name="descripcion">A partir de la confirmación del pedido SE DARA UN CONTRATO Y UN PAGARE AVALANDO EL COSTO LA COTIZACIÓN TENDRÁ UNA VIGENCIA DE 60 días habiles. 50% DE ANTICIPO AL CONFIRMAR PEDIDO Y EL RESTO A LA ENTREGA DE FACTURA O SERVICIO SERVICIO A DOMICILIO INCLUIDO DENTRO DE MORELIA.
                </textarea>
                <br>
                <div class="col-sm-6">
                    <label>Referencia Cotización</label>
                    <input type="text" id="descCotizacion" class="form-control" maxlength="20" placeholder="Ingresa una descripcion">
                </div>
                                
            </div>
            <div class="text-center totalCantidadProductos" style="font-size: 40px; color: #000;"></div>
            <div>
                <input type="hidden" class="cantidadTotal">
            </div>
            
        </div>
        <div class="text-center">
            <label>GENERAR COTIZACIÓN</label>
        </div>
        <div class="text-center">
            <button type="button" class="btn btn-success generarCotizacion" onclick="generarCotizacion();" style="width: 20%;"><img src="../iconos/cotizacion.png" style="width: 40px;"></button>
        </div>
    </div>
</div>

<script>

//FUNCION LIMPIAR CAMPOS===========================================================================
function limpiarCampos(){
    $("#seleccion").val("");
    $("#seleccionClave").val("");
    $("#clave_producto").val("");
    $("#descProducto").val("");
    $("#unidad_producto").val("");
    $("#cantidadProducto").val("");
    $("#precioLista").val("");
}
//====================================================================================================

//FUNCION OBTENER DATOS EMPRESAS=======================================================================
function obtener_datos_empresas(){

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_mostrar_empresa.php",
        data: "",
        success:function(data){
          var resultadoMostrar = JSON.parse(data);
            if(resultadoMostrar["codigo"] == "fallo"){
              //   var resultados = resultadoMostrar["mensaje"];
              // $(".texto-mensaje").text(resultados);
              //   $("#msj").modal("toggle");
                var htmlSelectEmpresas =
                "<label for='seleccionEmpresa'>Buscar Empresas:</label>"+
                "<input list='listaEmpresas' name='empresa_cotiz' id='empresaSelect' class='form-control' onchange='empresasCombinar(this);'>";
                $(".selectEmpresas").html(htmlSelectEmpresas);
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
                "<input list='listaEmpresas' name='empresa_cotiz' id='empresaSelect' class='form-control' onchange='empresasCombinar(this);'>"+

                "<datalist id='listaEmpresas'>"+opcionesEmpresas+"</datalist>";
                $(".selectEmpresas").html(htmlSelectEmpresas);
            }
        }
    });
    closeMessageOverlay();
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS=========================================================================
function empresasCombinar(e){
    var nombreEmpresa = $(e).val();

    idEmpresaGlobal = $('#listaEmpresas').find('option[value="'+nombreEmpresa+'"]').data('id');

    if (idEmpresaGlobal == undefined) {

        $("#rfcEmpresaCotiz").show();
        
    }else{

        $("#rfcEmpresaCotiz").hide();
    } 
}
//====================================================================================================

//FUNCION OBTENER DATOS PRODUCTOS=======================================================================
function obtener_datos_productos(){

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

                var opcionesListaProductos = "<option value='' data-unidad='' data-existencia='' data-clave='' data-sat='' data-descripcion='' data-id=''></option>";
                var opcionesListaProductosClave = "<option value=''  data-unidad='' data-existencia='' data-clave='' data-sat='' data-descripcion='' data-id=''></option>";
                var opcionesListaProductosClaveSat = "<option value=''  data-unidad='' data-existencia='' data-clave='' data-sat='' data-descripcion='' data-id=''></option>";

                for (i = 0; i < resultadosTotales.length; i++) {
                    var resultadosProductos = resultadosTotales[i];
                    var idProducto = resultadosProductos["idProducto"];
                    var claveProducto = resultadosProductos["clave"];
                    var claveSat = resultadosProductos["claveSat"];
                    var descripcionProducto   = resultadosProductos["descripcion"];
                    var existenciaProductos   = resultadosProductos["existencia"];
                    var unidadProductos   = resultadosProductos["unidad"];

                    opcionesListaProductos += "<option data-unidad='"+unidadProductos+"' data-existencia='"+existenciaProductos+"' data-clave='"+claveProducto+"' data-sat='"+claveSat+"' data-descripcion='"+descripcionProducto+"' data-id='"+idProducto+"' value='"+descripcionProducto+"'>"+claveSat+"</option>";


                    opcionesListaProductosClave += "<option data-unidad='"+unidadProductos+"' data-existencia='"+existenciaProductos+"' data-clave='"+claveProducto+"' data-sat='"+claveSat+"' data-descripcion='"+descripcionProducto+"' data-id='"+idProducto+"' value='"+claveProducto+"'>"+descripcionProducto+"</option>";

                    opcionesListaProductosClaveSat += "<option data-unidad='"+unidadProductos+"' data-existencia='"+existenciaProductos+"' data-clave='"+claveProducto+"' data-sat='"+claveSat+"' data-id='"+idProducto+"' data-descripcion='"+descripcionProducto+"' value='"+claveSat+"'>"+descripcionProducto+"</option>";

                }
                var htmlDivListasProductos =
                "<label for='seleccion'>Buscar Productos:</label>"+
                "<input type='text' list='lista' name='claveDelParámetro' id='seleccion' class='form-control' onchange='selectProductosCombinar(this, 0);'>"+

                "<datalist id='lista'>"+opcionesListaProductos+"</datalist>";
                $(".listaProductos").html(htmlDivListasProductos);

                var htmlDivListasProductosClave =
                "<label for='clave_producto'>Buscar Clave Producto:</label>"+
                "<input type='text' list='listaClave' name='claveDelParámetros' id='clave_producto' class='form-control' onchange='selectProductosCombinarClave(this, 0);'>"+

                "<datalist id='listaClave'>"+opcionesListaProductosClave+"</datalist>";
                $(".listaProductosClave").html(htmlDivListasProductosClave);

                var htmlDivListasProductosClaveSat =
                "<label for='seleccionClave'>Buscar Clave SAT:</label>"+
                "<input type='text' list='listaClaveSat' name='claveDelParámetroSat' id='seleccionClave' class='form-control' onchange='selectProductosCombinarClaveSat(this, 0);'>"+

                "<datalist id='listaClaveSat'>"+opcionesListaProductosClaveSat+"</datalist>";
                $(".listaProductosClaveSat").html(htmlDivListasProductosClaveSat);

                obtener_unidad_clave_sat();
            }
        }
    });
    closeMessageOverlay();
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS===============================================================
function selectProductosCombinar(e, operacion){
    descripcionProductosSeleccionadoGlobal = $(e).val();

    if (operacion == 0) {
        claveProductoGlobal = $('#lista').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('clave');
        claveProductoSatGlobal = $('#lista').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('sat');
        idProductoGlobal = $('#lista').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('id');
        existenciaProductoGlobal = $('#lista').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('existencia');
        unidadProductoGlobal = $('#lista').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('unidad');

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
            obtenerDatosTablaChiquita();
        }
    }
    else if (operacion == 1) {
        idProductoGlobal = $('#lista').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('id');
        if (idProductoGlobal == undefined) {
            $("#seleccion").val(descripcionProductosSeleccionadoGlobal);
            $("#clave_producto").val("");
            obtener_unidad_pieza();
            obtener_unidad_clave_sat();
        }
    }
    
    var htmlBotonAgregarProducto =
    "<br>"+
    "<button class='btn btn-success' type='button' onclick='agregarProductoCotizacion("+idProductoGlobal+")' style='width: 100%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'>Agregar Producto</button>";
    $(".botonAgregarProducto").html(htmlBotonAgregarProducto);

}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS=========================================================================
function selectProductosCombinarClaveSat(e, operacion){
    claveProductoSatGlobal = $(e).val();

    if (operacion == 0) {
        descripcionProductosSeleccionadoGlobal = $('#listaClaveSat').find('option[value="'+claveProductoSatGlobal+'"]').data('descripcion');
        idProductoGlobal = $('#listaClaveSat').find('option[value="'+claveProductoSatGlobal+'"]').data('id');
        existenciaProductoGlobal = $('#listaClaveSat').find('option[value="'+claveProductoSatGlobal+'"]').data('existencia');
        unidadProductoGlobal = $('#listaClaveSat').find('option[value="'+claveProductoSatGlobal+'"]').data('unidad');
        claveProductoGlobal = $('#listaClaveSat').find('option[value="'+claveProductoSatGlobal+'"]').data('clave');

        if (idProductoGlobal == undefined) {
            $("#unidad_producto").val("");
            $("#clave_producto").val("");
            $("#descProducto").val("");
        }else{
            $("#seleccionUnidad").val(unidadProductoGlobal);
            $("#clave_producto").val(claveProductoGlobal);
            $("#descProducto").val(descripcionProductosSeleccionadoGlobal);
            $("#seleccion").val(descripcionProductosSeleccionadoGlobal);
            obtenerDatosTablaChiquita();
        }
    }
    else if (operacion == 1) {
        idProductoGlobal = $('#listaClaveSat').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('id');
        if (idProductoGlobal == undefined) {
            $("#seleccion").val(descripcionProductosSeleccionadoGlobal);
            $("#clave_producto").val("");
        }
    }

    var htmlBotonAgregarProducto =
    "<br>"+
    "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacion("+idProductoGlobal+")' style='width: 100%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'>Agregar Producto</button>";
    $(".botonAgregarProducto").html(htmlBotonAgregarProducto);
    
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

        if (idProductoGlobal == undefined) {
            console.log(idProductoGlobal);
        }else{
            $("#seleccionClave").val(claveProductoSatGlobal);
            $("#seleccionUnidad").val(unidadProductoGlobal);
            $("#descProducto").val(descripcionProductosSeleccionadoGlobal);
            $("#seleccion").val(descripcionProductosSeleccionadoGlobal);
            obtenerDatosTablaChiquita();
        }
    }
    else if (operacion == 1) {
        idProductoGlobal = $('#listaClave').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('id');
        if (idProductoGlobal == undefined) {
            $("#seleccion").val(descripcionProductosSeleccionadoGlobal);
            $("#clave_producto").val("");
        }
    }

    var htmlBotonAgregarProducto =
    "<br>"+
    "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacion("+idProductoGlobal+")' style='width: 100%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'>Agregar Producto</button>";
    $(".botonAgregarProducto").html(htmlBotonAgregarProducto);
    
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS===============================================================
function obtener_datos_unidades(){
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

                var opcionesListaUnidades = "<option value=''></option>";

                for (i = 0; i < resultadosTotales.length; i++) {
                    var resultadosUnidades = resultadosTotales[i];
                    // console.log(resultadosUnidades);
                    var idUnidad = resultadosUnidades["idUnidad"];
                    var unidadSat = resultadosUnidades["unidadSat"];
                    var unidad = resultadosUnidades["unidad"];

                    opcionesListaUnidades += "<option data-unidad='"+unidad+"' data-unidadsat='"+unidadSat+"' data-idunidad='"+idUnidad+"' value='"+unidad+"'>"+idUnidad+"</option>";
                }

                var htmlDivListasUnidadSat =
                "<label for='seleccionUnidad'>Unidad SAT:</label>"+
                "<input type='text' list='listaUnidadSat' name='unidadesSat' id='seleccionUnidad' class='form-control'onchange='selectProductosCombinarUnidad(this, 0);'>"+

                "<datalist id='listaUnidadSat'>"+opcionesListaUnidades+"</datalist>";
                $(".campoUnidadProducto").html(htmlDivListasUnidadSat);

                obtener_unidad_pieza();
            }
        }
    });
    closeMessageOverlay();
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS=========================================================================
function selectProductosCombinarUnidad(e, operacion){
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
    "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacion("+idProductoGlobal+")' style='width: 100%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'>Agregar Producto</button>";
    $(".botonAgregarProducto").html(htmlBotonAgregarProducto);
    
}
//====================================================================================================

//FUNCION OBTENER DATOS PROVEEDORES Y FOLIOS==========================================================
function obtener_unidad_pieza(){
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

//FUNCION OBTENER DATOS PROVEEDORES Y FOLIOS==========================================================
function obtener_unidad_clave_sat(){
    var lista = document.querySelectorAll("#listaClaveSat");

    for (var lis of lista) {
        var listaResultados=lis.querySelectorAll("option");
        // console.log(listaResultados);
        var valorUnidad = listaResultados[1].value;
        $("#seleccionClave").val(valorUnidad);
    }
    var idUni = $("#listaClaveSat").val(valorUnidad);

    var resultadoUnidad = $("#listaClaveSat").val();

    var selectIdUnidad = $('#listaClaveSat').find('option[value="'+resultadoUnidad+'"]').data('id');
}
//====================================================================================================

//FUNCION OBTENER DATOS TABLA CHIQUITA======================================================================
function obtenerDatosTablaChiquita(){

    var jsonData = {
        "idProducto": idProductoGlobal,
        }

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_cotizacion_tabla_chiquita_mostrar.php",
        data: jsonData,
        success:function(data){
          var resultadoMostrar = JSON.parse(data);
            if(resultadoMostrar["codigo"] == "fallo"){
                closeMessageOverlay();
            }
            else if(resultadoMostrar["codigo"] == "exito"){
                var resultados = resultadoMostrar["objetoRespuesta"]["cotizacionesAnteriores"];

                for (i = 0; i < resultados.length; i++) {
                    var resultadosTotales = resultados[i];
                    // console.log(resultadosTotales);
                    var idDetalle              = resultadosTotales["idDetalle"];
                    var fechaRegistro          = resultadosTotales["fechaRegistro"];
                    var folioCotizacionDetalle = resultadosTotales["folioCotizacionDetalle"];
                    var precioUnitario         = resultadosTotales["precioUnitario"];
                    
                    var htmlCotizAnterior =
                    "<tr>"+
                        "<td>"+fechaRegistro+"</td>"+
                        "<td>"+folioCotizacionDetalle+"</td>"+
                        "<td>"+precioUnitario+"</td>"+
                        "<td style='visibility:collapse; display:none;'>"+idDetalle+"</td>"+
                    "</tr>";
                    $(".cotizAnteriores").append(htmlCotizAnterior);
                }
                
                closeMessageOverlay();
            }
        }
    });
}
//====================================================================================================

//FUNCION OBTENER DATOS CLIENTES======================================================================
function obtener_datos_clientes(){

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
                "<input type='text' name='cliente_cotiz' id='clienteCotizacion' class='form-control'>";

                $(".clientesCotizacionSelect").html(htmlSelectClientes);
                closeMessageOverlay();
            }
            else if(resultadoMostrar["codigo"] == "exito"){
                var resultados = resultadoMostrar["objetoRespuesta"]["cliente"];

                var opcionesClientes = "<option value='-1'>Buscar Clientes ...</option>";

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
                "<input list='listaClientes' name='cliente_cotiz' id='clienteCotizacion' class='form-control' onchange='clientesCombinar(this);'>"+

                "<datalist id='listaClientes'>"+opcionesClientes+"</datalist>";
                $(".clientesCotizacionSelect").html(htmlSelectClientes);

                closeMessageOverlay();
            }
        }
    });
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS=========================================================================
function clientesCombinar(e){
    var nombreCliente = $(e).val();

    idClienteGlobal = $('#listaClientes').find('option[value="'+nombreCliente+'"]').data('id');
    var telefonoCliente = $('#listaClientes').find('option[value="'+nombreCliente+'"]').data('telefono');


    if (idClienteGlobal == undefined) {
        console.log(idClienteGlobal);
        $("#telefono").val("");
    }else{
        $("#telefono").val(telefonoCliente);
    } 
}
//====================================================================================================

//FUNCION OBTENER DATOS PROVEEDORES Y FOLIOS==========================================================
function obtener_datos_proveedor_imprimir(){

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
                var opcionesCotizacionesImprimir = "<option value='-1' folio='' proveedor=''>Proveedor *</option>";

                for (i = 0; i < resultados.length; i++) {
                    var resultadosTotales = resultados[i];
                    // console.log(resultadosTotales);
                    var idProveedor = resultadosTotales["idProveedor"];
                    var folio   = resultadosTotales["folio"];
                    var proveedor = resultadosTotales["proveedor"];
                    folioEmpresas.push(folio);
                }
                closeMessageOverlay();
            }
        }
    });
}
//====================================================================================================

// //FUNCION OBTENER DATOS PRODUCTOS=======================================================================
function agregarProductoCotizacion(idProductoGlobal){

    if ((idProductoGlobal == undefined) || (idProductoGlobal == "")) {
        var idUsuario = <?=$idUsuario;?>;
        idProductoGlobal = "";
        var precioLista = $("#precioLista").val();
        var catidadProducto = $("#cantidadProducto").val();
        var claveSatProducto = $("#seleccionClave").val();
        var claveProducto = $("#clave_producto").val();
        descripcionProductosSeleccionadoGlobal = $("#descProducto").val();

        if(claveProducto == ""){
          $(".texto-mensaje").text("CLAVE DEL PRODUCTO ES REQUERIDO.");
          $("#msj").modal("toggle");
          return false;
        }

        var jsonData = {
            "idUsuarioOper": idUsuario,
            "idProductoPropio": idProductoGlobal,
            "clave": claveProducto,
            "claveSat": claveSatProducto,
            "descripcion": descripcionProductosSeleccionadoGlobal,
            "idUnidad": idUnidadesTodos
        }

        showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
        $.ajax({
            method: "POST",
            url: "../backend/backend_productos_propios_registrar.php",
            data: jsonData,
            success:function(data){
              var resultadoMostrar = JSON.parse(data);
                if(resultadoMostrar["codigo"] == "fallo"){
                    closeMessageOverlay();
                }
                else if(resultadoMostrar["codigo"] == "exito"){
                    var resultados = resultadoMostrar["mensaje"];
                    $(".texto-mensaje").text(resultados);
                    $("#msjProd").modal("toggle");
                    closeMessageOverlay();
                }
            }
        });
    }
    else{

        var idUsuario = <?=$idUsuario;?>;
        var precioLista = $("#precioLista").val();
        var catidadProducto = $("#cantidadProducto").val();
        var claveSatProducto = $("#seleccionClave").val();
        var claveProducto = $("#clave_producto").val();
        descripcionProductosSeleccionadoGlobal = $("#descProducto").val();

        if(precioLista == ""){
          $(".texto-mensaje").text("PRECIO ES REQUERIDO.");
          $("#msj").modal("toggle");
          return false;
        }

        if(catidadProducto == ""){
          $(".texto-mensaje").text("CANTIDAD ES REQUERIDO.");
          $("#msj").modal("toggle");
          return false;
        }

        var importe = catidadProducto * precioLista;

        var htmlProdCotiz =
        "<tr>"+
            "<td class='clavesProductos'>"+claveProducto+"</td>"+
            "<td class='clavesProductosSat'>"+claveSatProducto+"</td>"+
            "<td class='desProductos'>"+descripcionProductosSeleccionadoGlobal+"</td>"+
            "<td class='precioListaProductos'>"+precioLista+"</td>"+
            "<td class='cantProductos'>"+catidadProducto+"</td>"+
            "<td class='totalImporteProductos'>"+importe+"</td>"+
            "<td><button type='button' class='btn btn-outline-danger botonEliminar' onclick='eliminarFila(this, "+idProductoGlobal+","+importe+")' style='width: 100%;'><img src='../iconos/eliminar.png' style='width: 20px;'><input type='hidden' class='totalProductos' value='"+importe+"'/></td>"+
            "<td class='idProductoTabla' style='visibility:collapse; display:none;'>"+idProductoGlobal+"</td>"+
        "</tr>";
        $(".prodCotiz").append(htmlProdCotiz);

        var trs=document.querySelectorAll("#tablaProductosAnadidos tbody tr").forEach(function(e){
            produAgre = {
                descripcion: e.querySelector('.desProductos').innerText,
                precioUnitario: e.querySelector('.precioListaProductos').innerText,
                cantidad: e.querySelector('.cantProductos').innerText,
                idProducto: e.querySelector('.idProductoTabla').innerText
            };
        });
        productosTotal.push(produAgre);
        sumarTotalCotizacion();
        limpiarCampos();
    }
}
//====================================================================================================

//FUNCION ELIMINAR PRODUCTO===========================================================================
function sumarTotalCotizacion(){
    var total = 0;
    
    $('.totalProductos').each(function(){
        if (!isNaN($(this).val())) {
          total += Number($(this).val());
          $(".totalCantidadProductos").text(moneda+total.toLocaleString('es-MX'));
          $(".cantidadTotal").val(total);
        }else{alert("si es nan");}
    });
}
//====================================================================================================

//FUNCION ELIMINAR PRODUCTO===========================================================================
function eliminarFila(valor, idProducto, importe){
    var total = $(".cantidadTotal").val();

    var eliminarProd = total - importe;
    $(".totalCantidadProductos").text(moneda+eliminarProd.toFixed(2));
    valor.closest('tr').remove();

}
//====================================================================================================

//FUNCION GENERAR COTIZACION===========================================================================
function generarCotizacion(e){
    var btn = $(e);

    var idEmpresaSeleccionada = $("#empresaSelect").val();
    var idUsuario = <?=$idUsuario;?>;
    var totalCotiz = $(".cantidadTotal").val();
    var descripcionCotiz = $("#descCotizacion").val();
    var condiciones = $("#condiciones").val();
    var totalCotizacion = $(".cantidadTotal").val();
    var nombreCliente = $("#clienteCotizacion").val();
    var telefonoCliente = $("#telefono").val();
    var nombreEmpresa = $("#empresaSelect").val();
    var rfcEmpresa = $("#rfcEmpresaCotiz").val();
    var productosArray = productosTotal;

    //VALIDACIONES DE CAMPOS A MANDAR

    if(totalCotizacion == "" || totalCotizacion == 0){
      $(".texto-mensaje").text("INGRESA EL PRODUCTO A LA TABLA EN EL BOTÓN DE AGREGAR PRODUCTOS.");
      $("#msj").modal("toggle");
      return false;
    }

    if(condiciones == ""){
      $(".texto-mensaje").text("LAS CONDICIONES DE LA COTIZACIÓN ES REQUERIDO.");
      $("#msj").modal("toggle");
      return false;
    }

    if ((idClienteGlobal == undefined) || (idClienteGlobal == "")) {
        idClienteGlobal = "";
    }

    if ((idEmpresaGlobal == undefined)||(idEmpresaGlobal == "")) {
        idEmpresaGlobal = "";
    }

    var jsonData = {
        "idUsuario": idUsuario,
        "descripcion":  descripcionCotiz,
        "idEmpresa":  idEmpresaGlobal,
        "idCliente":  idClienteGlobal,
        "condiciones":  condiciones,
        "total":  totalCotiz,
        "cliente":  nombreCliente,
        "telefono":  telefonoCliente,
        "nombre": nombreEmpresa,
        "rfc": rfcEmpresa,
        "productos": JSON.stringify(productosArray)
    }

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_cotizacion_unica_registro.php",
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
    obtener_datos_empresas();
    obtener_datos_productos();
    obtener_datos_clientes();
    obtener_datos_proveedor_imprimir();
    obtener_datos_unidades();
    resultadosTotales = "";
    descripcionProductosSeleccionadoGlobal = "";
    claveProductoGlobal = "";
    claveProductoSatGlobal = "";
    idProductoGlobal = "";
    existenciaProductoGlobal = "";
    unidadProductoGlobal = "";
    folioEmpresas = new Array();
    productosTotal = new Array();
    moneda = "TOTAL $";
    empresaAtencionSeleccionada = "";
    empresaTelefonoSeleccionada = "";
    idUnidadesTodos = "";
    idClienteGlobal = "";
    idEmpresaGlobal = "";
    idProductoNuevo = "";
    $("#rfcEmpresaCotiz").hide();
});
//====================================================================================================

</script>

