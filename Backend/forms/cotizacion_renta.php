<?php
session_start();
$idUsuario = $_SESSION['idUsuario'];
include 'menu.php';
?>
<div class="panel panel-info">
    <div class="panel-heading">GENERAR COTIZACIÓN RENTA</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-4 selectEmpresasRenta"></div>
            <div class="col-sm-4 clientesCotizacionSelectRenta"></div>
            <div class="col-lg-3 campoTelefonoClienteRenta">
                <label>Teléfono</label>
                <input type='text' name='telefonoRenta' id='telefonoRenta' class='form-control' maxlength="10">
            </div>
            <div class="col-sm-4 campoRfcEmpresasRenta">
                <input type='text' name='rfcEmpresaCotizRenta' id='rfcEmpresaCotizRenta' class='form-control' placeholder="RFC Empresa">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 listaProductosRenta"></div>
            <div class="col-lg-4 listaProductosClaveSatRenta"></div>
            <div class="col-lg-2 campoUnidadProductoRenta">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 listaProductosClaveRenta"></div>
            <div class="col-lg-6 campoDescripcionProductoRenta">
                <label>Descripción Producto</label>
                <textarea class="form-control" name="descProductoRenta" id="descProductoRenta" rows="4" onchange="selectProductosCombinarRenta(this, 1)"></textarea>
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
                        <tbody class="cotizAnterioresRenta"></tbody>
                    </thead>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <label for="cantidad">Cantidad</label>
                <input type="text" id="cantidadProductoRenta" class="form-control" onKeypress="soloNumeros(this);">
            </div>
            <div class="col-lg-2">
                <label for="importe">Precio por dia</label>
                <input type="text" id="precioDiaRenta" class="form-control" onKeypress="soloNumeros(this);">
            </div>
            <div class="col-lg-2">
                <label for="cantidad">Fecha Inicio</label>
                <input type="date" id="fechaInicioCotizRenta" class="form-control">
            </div>
            <div class="col-lg-2">
                <label for="importe">Fecha Fin</label>
                <input type="date" id="fechaFinCotizRenta" class="form-control" onchange="calcularDiasRenta();">
            </div>
            <div class="col-lg-2">
                <label for="cantidad">Dias totales</label>
                <input type="text" id="diasTotalRenta" class="form-control" disabled>
            </div>
            <div class="col-lg-2 botonAgregarProductoRenta"></div>
        </div>
        <div class="table-responsive">
            <table class="table table-primary bg-light tablaProductosTotalRenta" id="tablaProductosAnadidosRenta">
                <thead>
                    <tr>
                        <th>Clave Productos</th>
                        <th>Clave SAT</th>
                        <th>Descripción</th>
                        <th>Precio de Lista</th>
                        <th>Cantidad</th>
                        <th>Dias a prestamo</th>
                        <th>Importe</th>
                        <th>Eliminar</th>
                        <th style="visibility:collapse; display:none;"></th>
                    </tr>
                </thead>
                <tbody class="prodCotizRenta">
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <label for="condiciones" style="font-size: 40px;">CONDICIONES COMERCIALES</label>
                <textarea class="form-control" id="condicionesRenta" rows="4" name="descripcion">A partir de la confirmación del pedido SE DARA UN CONTRATO Y UN PAGARE AVALANDO EL COSTO LA COTIZACIÓN TENDRÁ UNA VIGENCIA DE 60 días habiles. 50% DE ANTICIPO AL CONFIRMAR PEDIDO Y EL RESTO A LA ENTREGA DE FACTURA O SERVICIO SERVICIO A DOMICILIO INCLUIDO DENTRO DE MORELIA.
                </textarea>
                <br>
                <div class="col-sm-6">
                    <label>Referencia Cotización</label>
                    <input type="text" id="descCotizacionRenta" class="form-control" maxlength="30" placeholder="Ingresa una descripcion">
                </div>
                                
            </div>
            <div class="text-center totalCantidadProductosRenta" style="font-size: 40px; color: #000;"></div>
            <div>
                <input type="hidden" class="cantidadTotalRenta">
            </div>
            
        </div>
        <div class="text-center">
            <label>GENERAR COTIZACIÓN</label>
        </div>
        <div class="text-center">
            <button type="button" class="btn btn-success generarCotizacionRenta" onclick="generarCotizacionRenta();" style="width: 20%;"><img src="../iconos/cotizacion.png" style="width: 40px;"></button>
        </div>
    </div>
</div>

<script>

//FUNCION LIMPIAR CAMPOS===========================================================================
function limpiarCampos(){
    $("#seleccionRenta").val("");
    $("#seleccionClaveRenta").val("");
    $("#clave_productoRenta").val("");
    $("#descProductoRenta").val("");
    $("#unidad_productoRenta").val("");
    $("#cantidadProductoRenta").val("");
    $("#precioDiaRenta").val("");
    $("#fechaInicioCotizRenta").val("");
    $("#fechaFinCotizRenta").val("");
    $("#diasTotalRenta").val("");
}
//====================================================================================================

//FUNCION OBTENER DATOS EMPRESAS=======================================================================
function obtener_datos_empresas_renta(){

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_mostrar_empresa.php",
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
                "<input list='listaEmpresasRenta' name='empresaSelectRenta' id='empresaSelectRenta' class='form-control' onchange='empresasCombinarRenta(this);'>"+

                "<datalist id='listaEmpresasRenta'>"+opcionesEmpresas+"</datalist>";
                $(".selectEmpresasRenta").html(htmlSelectEmpresas);
            }
        }
    });
    closeMessageOverlay();
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS=========================================================================
function empresasCombinarRenta(e){
    var nombreEmpresa = $(e).val();

    idEmpresaGlobal = $('#listaEmpresasRenta').find('option[value="'+nombreEmpresa+'"]').data('id');

    if (idEmpresaGlobal == undefined) {

        $("#rfcEmpresaCotizRenta").show();
        
    }else{

        $("#rfcEmpresaCotizRenta").hide();
    } 
}
//====================================================================================================

//FUNCION OBTENER DATOS PRODUCTOS=======================================================================
function obtenerDatosProdutosPropios(){

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_productos_propios_mostrar.php",
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


                    opcionesListaProductosClave += "<option data-unidad='"+unidadProductos+"' data-existencia='"+existenciaProductos+"' data-clave='"+claveProducto+"' data-sat='"+claveSat+"' data-descripcion='"+descripcionProducto+"' data-id='"+idProducto+"' value='"+claveProducto+"'>"+descripcionProducto+"</option>";

                    opcionesListaProductosClaveSat += "<option data-unidad='"+unidadProductos+"' data-existencia='"+existenciaProductos+"' data-clave='"+claveProducto+"' data-sat='"+claveSat+"' data-id='"+idProducto+"' data-descripcion='"+descripcionProducto+"' value='"+claveSat+"'>"+descripcionProducto+"</option>";

                }
                var htmlDivListasProductos =
                "<label for='seleccionRenta'>Buscar Productos:</label>"+
                "<input type='text' list='listaRenta' name='seleccionRenta' id='seleccionRenta' class='form-control' onchange='selectProductosCombinarRenta(this, 0);'>"+

                "<datalist id='listaRenta'>"+opcionesListaProductos+"</datalist>";
                $(".listaProductosRenta").html(htmlDivListasProductos);

                var htmlDivListasProductosClave =
                "<label for='clave_productoRenta'>Buscar Clave Producto:</label>"+
                "<input type='text' list='listaClaveRenta' name='clave_productoRenta' id='clave_productoRenta' class='form-control' onchange='selectProductosCombinarClaveRenta(this, 0);'>"+

                "<datalist id='listaClaveRenta'>"+opcionesListaProductosClave+"</datalist>";
                $(".listaProductosClaveRenta").html(htmlDivListasProductosClave);

                var htmlDivListasProductosClaveSat =
                "<label for='seleccionClaveRenta'>Buscar Clave SAT:</label>"+
                "<input type='text' list='listaClaveSatRenta' name='seleccionClaveRenta' id='seleccionClaveRenta' class='form-control' onchange='selectProductosCombinarClaveSatRenta(this, 0);'>"+

                "<datalist id='listaClaveSatRenta'>"+opcionesListaProductosClaveSat+"</datalist>";
                $(".listaProductosClaveSatRenta").html(htmlDivListasProductosClaveSat);

                obtener_unidad_clave_sat_renta();
            }
        }
    });
    closeMessageOverlay();
}
//====================================================================================================

// //FUNCION OBTENER DATOS PRODUCTOS=======================================================================
// function obtener_datos_productosRenta(){

//     showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
//     $.ajax({
//         method: "POST",
//         url: "../backend/backend_productos_mostrar.php",
//         data: "",
//         success:function(data){
//           var resultadoMostrar = JSON.parse(data);
//             if(resultadoMostrar["codigo"] == "fallo"){
//                 // var resultados = resultadoMostrar["mensaje"];
//                 // $(".texto-mensaje").text(resultados);
//                 // $("#msj").modal("toggle");
//                 closeMessageOverlay();
//             }
//             else if(resultadoMostrar["codigo"] == "exito"){
//                 resultadosTotales = resultadoMostrar["objetoRespuesta"]["productos"];

//                 var opcionesListaProductos = "<option value='' data-unidad='' data-existencia='' data-clave='' data-sat='' data-descripcion='' data-id=''></option>";
//                 var opcionesListaProductosClave = "<option value=''  data-unidad='' data-existencia='' data-clave='' data-sat='' data-descripcion='' data-id=''></option>";
//                 var opcionesListaProductosClaveSat = "<option value=''  data-unidad='' data-existencia='' data-clave='' data-sat='' data-descripcion='' data-id=''></option>";

//                 for (i = 0; i < resultadosTotales.length; i++) {
//                     var resultadosProductos = resultadosTotales[i];
//                     var idProducto = resultadosProductos["idProducto"];
//                     var claveProducto = resultadosProductos["clave"];
//                     var claveSat = resultadosProductos["claveSat"];
//                     var descripcionProducto   = resultadosProductos["descripcion"];
//                     var existenciaProductos   = resultadosProductos["existencia"];
//                     var unidadProductos   = resultadosProductos["unidad"];

//                     opcionesListaProductos += "<option data-unidad='"+unidadProductos+"' data-existencia='"+existenciaProductos+"' data-clave='"+claveProducto+"' data-sat='"+claveSat+"' data-descripcion='"+descripcionProducto+"' data-id='"+idProducto+"' value='"+descripcionProducto+"'>"+claveSat+"</option>";


//                     opcionesListaProductosClave += "<option data-unidad='"+unidadProductos+"' data-existencia='"+existenciaProductos+"' data-clave='"+claveProducto+"' data-sat='"+claveSat+"' data-descripcion='"+descripcionProducto+"' data-id='"+idProducto+"' value='"+claveProducto+"'>"+descripcionProducto+"</option>";

//                     opcionesListaProductosClaveSat += "<option data-unidad='"+unidadProductos+"' data-existencia='"+existenciaProductos+"' data-clave='"+claveProducto+"' data-sat='"+claveSat+"' data-id='"+idProducto+"' data-descripcion='"+descripcionProducto+"' value='"+claveSat+"'>"+descripcionProducto+"</option>";

//                 }
//                 var htmlDivListasProductos =
//                 "<label for='seleccionRenta'>Buscar Productos:</label>"+
//                 "<input type='text' list='listaRenta' name='seleccionRenta' id='seleccionRenta' class='form-control' onchange='selectProductosCombinarRenta(this, 0);'>"+

//                 "<datalist id='listaRenta'>"+opcionesListaProductos+"</datalist>";
//                 $(".listaProductosRenta").html(htmlDivListasProductos);

//                 var htmlDivListasProductosClave =
//                 "<label for='clave_productoRenta'>Buscar Clave Producto:</label>"+
//                 "<input type='text' list='listaClaveRenta' name='clave_productoRenta' id='clave_productoRenta' class='form-control' onchange='selectProductosCombinarClaveRenta(this, 0);'>"+

//                 "<datalist id='listaClaveRenta'>"+opcionesListaProductosClave+"</datalist>";
//                 $(".listaProductosClaveRenta").html(htmlDivListasProductosClave);

//                 var htmlDivListasProductosClaveSat =
//                 "<label for='seleccionClaveRenta'>Buscar Clave SAT:</label>"+
//                 "<input type='text' list='listaClaveSatRenta' name='seleccionClaveRenta' id='seleccionClaveRenta' class='form-control' onchange='selectProductosCombinarClaveSatRenta(this, 0);'>"+

//                 "<datalist id='listaClaveSatRenta'>"+opcionesListaProductosClaveSat+"</datalist>";
//                 $(".listaProductosClaveSatRenta").html(htmlDivListasProductosClaveSat);

//                 obtener_unidad_clave_sat_renta();
//             }
//         }
//     });
//     closeMessageOverlay();
// }
// //====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS===============================================================
function selectProductosCombinarRenta(e, operacion){
    descripcionProductosSeleccionadoGlobal = $(e).val();

    if (operacion == 0) {
        claveProductoGlobal = $('#listaRenta').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('clave');
        claveProductoSatGlobal = $('#listaRenta').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('sat');
        idProductoGlobal = $('#listaRenta').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('id');
        existenciaProductoGlobal = $('#listaRenta').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('existencia');
        unidadProductoGlobal = $('#listaRenta').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('unidad');

        if (unidadProductoGlobal == 0) {
            obtener_unidad_pieza_renta();
        }

        if (idProductoGlobal == undefined) {
            // $("#clave_productoRenta").val("");
            // $("#descProductoRenta").val(descripcionProductosSeleccionadoGlobal);
            $(".texto-mensaje").text("El producto no se encuentra dentro del stock.");
            $("#msj").modal("toggle");
            $("#seleccionRenta").val("");

            obtener_unidad_pieza_renta();
            obtener_unidad_clave_sat_renta();
            
        }else{
            $("#seleccionClaveRenta").val(claveProductoSatGlobal);
            // $("#seleccionUnidadRenta").val(unidadProductoGlobal);
            $("#clave_productoRenta").val(claveProductoGlobal);
            $("#descProductoRenta").val(descripcionProductosSeleccionadoGlobal);
            $("#seleccionRenta").val(descripcionProductosSeleccionadoGlobal);
            obtenerDatosTablaChiquitaRenta();

            var htmlBotonAgregarProducto =
            "<br>"+
            "<button class='btn btn-success' type='button' onclick='agregarProductoCotizacionRenta("+idProductoGlobal+")' style='width: 100%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'>Agregar Producto</button>";
            $(".botonAgregarProductoRenta").html(htmlBotonAgregarProducto);

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
            obtener_unidad_pieza_renta();
            obtener_unidad_clave_sat_renta();
            
        }else{
            $("#seleccionClaveRenta").val(claveProductoSatGlobal);
            // $("#seleccionUnidadRenta").val(unidadProductoGlobal);
            $("#clave_productoRenta").val(claveProductoGlobal);
            $("#descProductoRenta").val(textAreaProductoRenta);
            $("#seleccionRenta").val(textAreaProductoRenta);
            obtenerDatosTablaChiquitaRenta();

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

    if (operacion == 0) {
        descripcionProductosSeleccionadoGlobal = $('#listaClaveSatRenta').find('option[value="'+claveProductoSatGlobal+'"]').data('descripcion');
        idProductoGlobal = $('#listaClaveSatRenta').find('option[value="'+claveProductoSatGlobal+'"]').data('id');
        existenciaProductoGlobal = $('#listaClaveSatRenta').find('option[value="'+claveProductoSatGlobal+'"]').data('existencia');
        unidadProductoGlobal = $('#listaClaveSatRenta').find('option[value="'+claveProductoSatGlobal+'"]').data('unidad');
        claveProductoGlobal = $('#listaClaveSatRenta').find('option[value="'+claveProductoSatGlobal+'"]').data('clave');

        if (idProductoGlobal == undefined) {
            // $("#unidad_productoRenta").val("");
            // $("#clave_productoRenta").val("");
            // $("#descProductoRenta").val("");
            $(".texto-mensaje").text("El producto no se encuentra dentro del stock.");
            $("#msj").modal("toggle");
            obtener_unidad_pieza_renta();
            obtener_unidad_clave_sat_renta();
        }else{
            $("#seleccionUnidadRenta").val(unidadProductoGlobal);
            $("#clave_productoRenta").val(claveProductoGlobal);
            $("#descProductoRenta").val(descripcionProductosSeleccionadoGlobal);
            $("#seleccionRenta").val(descripcionProductosSeleccionadoGlobal);
            obtenerDatosTablaChiquitaRenta();
        }
    }
    else if (operacion == 1) {
        idProductoGlobal = $('#listaClaveSatRenta').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('id');
        if (idProductoGlobal == undefined) {
            $("#seleccionRenta").val(descripcionProductosSeleccionadoGlobal);
            $("#clave_productoRenta").val("");
        }
    }

    var htmlBotonAgregarProducto =
    "<br>"+
    "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacionRenta("+idProductoGlobal+")' style='width: 100%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'>Agregar Producto</button>";
    $(".botonAgregarProductoRenta").html(htmlBotonAgregarProducto);
    
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

        if (idProductoGlobal == undefined) {
            console.log(idProductoGlobal);
        }else{
            $("#seleccionClaveRenta").val(claveProductoSatGlobal);
            $("#seleccionUnidadRenta").val(unidadProductoGlobal);
            $("#descProductoRenta").val(descripcionProductosSeleccionadoGlobal);
            $("#seleccionRenta").val(descripcionProductosSeleccionadoGlobal);
            obtenerDatosTablaChiquitaRenta();
        }
    }
    else if (operacion == 1) {
        idProductoGlobal = $('#listaClaveRenta').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('id');
        if (idProductoGlobal == undefined) {
            $("#seleccionRenta").val(descripcionProductosSeleccionadoGlobal);
            $("#clave_productoRenta").val("");
        }
    }

    var htmlBotonAgregarProducto =
    "<br>"+
    "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacionRenta("+idProductoGlobal+")' style='width: 100%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'>Agregar Producto</button>";
    $(".botonAgregarProductoRenta").html(htmlBotonAgregarProducto);
    
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS===============================================================
function obtener_datos_unidades_renta(){
    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_unidad_medida_mostrar.php",
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
                "<label for='seleccionUnidadRenta'>Unidad SAT:</label>"+
                "<input type='text' list='listaUnidadSatRenta' name='seleccionUnidadRenta' id='seleccionUnidadRenta' class='form-control'onchange='selectProductosCombinarUnidadRenta(this, 0);'>"+

                "<datalist id='listaUnidadSatRenta'>"+opcionesListaUnidades+"</datalist>";
                $(".campoUnidadProductoRenta").html(htmlDivListasUnidadSat);

                obtener_unidad_pieza_renta();
            }
        }
    });
    closeMessageOverlay();
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS=========================================================================
function selectProductosCombinarUnidadRenta(e, operacion){
    unidadProductoGlobal = $(e).val();

    console.log(unidadProductoGlobal);

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
    "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacionRenta("+idProductoGlobal+")' style='width: 100%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'>Agregar Producto</button>";
    $(".botonAgregarProductoRenta").html(htmlBotonAgregarProducto);
    
}
//====================================================================================================

//FUNCION OBTENER DATOS PROVEEDORES Y FOLIOS==========================================================
function obtener_unidad_pieza_renta(){
    var lista = document.querySelectorAll("#listaUnidadSatRenta");
    
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

//FUNCION OBTENER DATOS PROVEEDORES Y FOLIOS==========================================================
function obtener_unidad_clave_sat_renta(){
    var lista = document.querySelectorAll("#listaClaveSatRenta");

    for (var lis of lista) {
        var listaResultados=lis.querySelectorAll("option");
        var valorUnidad = listaResultados[1].value;

        $("#seleccionClaveRenta").val(valorUnidad);
    }

    var idUni = $("#listaClaveSatRenta").val(valorUnidad);

    var resultadoUnidad = $("#listaClaveSatRenta").val();

    var selectIdUnidad = $('#listaClaveSatRenta').find('option[value="'+resultadoUnidad+'"]').data('id');
}
//====================================================================================================

//FUNCION OBTENER DATOS TABLA CHIQUITA======================================================================
function obtenerDatosTablaChiquitaRenta(){

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
                    $(".cotizAnterioresRenta").append(htmlCotizAnterior);
                }
                
                closeMessageOverlay();
            }
        }
    });
}
//====================================================================================================

//FUNCION OBTENER DATOS CLIENTES======================================================================
function obtener_datos_clientes_renta(){

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_cliente_mostrar.php",
        data: "",
        success:function(data){
          var resultadoMostrar = JSON.parse(data);
          if(resultadoMostrar["codigo"] == "fallo"){
                var htmlSelectClientes =
                "<label for='seleccionClienteRenta'>Buscar Clientes:</label>"+
                "<input type='text' name='clienteCotizacionRenta' id='clienteCotizacionRenta' class='form-control'>";

                $(".clientesCotizacionSelectRenta").html(htmlSelectClientes);
                closeMessageOverlay();
            }
            else if(resultadoMostrar["codigo"] == "exito"){
                var resultados = resultadoMostrar["objetoRespuesta"]["cliente"];

                // console.log(resultados);

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
                "<label for='seleccionClienteRenta'>Buscar Clientes:</label>"+
                "<input list='listaClientesRenta' name='clienteCotizacionRenta' id='clienteCotizacionRenta' class='form-control' onchange='clientesCombinarRenta(this);'>"+

                "<datalist id='listaClientesRenta'>"+opcionesClientes+"</datalist>";
                $(".clientesCotizacionSelectRenta").html(htmlSelectClientes);

                closeMessageOverlay();
            }
        }
    });
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS=========================================================================
function clientesCombinarRenta(e){
    var nombreCliente = $(e).val();

    idClienteGlobal = $('#listaClientesRenta').find('option[value="'+nombreCliente+'"]').data('id');
    var telefonoCliente = $('#listaClientesRenta').find('option[value="'+nombreCliente+'"]').data('telefono');


    if (idClienteGlobal == undefined) {
        console.log(idClienteGlobal);
        $("#telefonoRenta").val("");
    }else{
        $("#telefonoRenta").val(telefonoCliente);
    } 
}
//====================================================================================================

//FUNCION OBTENER DATOS PROVEEDORES Y FOLIOS==========================================================
function obtener_datos_proveedor_imprimir_renta(){

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_proveedores_mostrar.php",
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
function agregarProductoCotizacionRenta(idProductoGlobal){

    if ((idProductoGlobal == undefined) || (idProductoGlobal == "")) {
        var idUsuario = <?=$idUsuario;?>;
        idProductoGlobal = "";
        var precioLista = $("#precioDiaRenta").val();
        var catidadProducto = $("#cantidadProductoRenta").val();
        var claveSatProducto = $("#seleccionClaveRenta").val();
        var claveProducto = $("#clave_productoRenta").val();
        descripcionProductosSeleccionadoGlobal = $("#descProductoRenta").val();

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
        var precioDia = $("#precioDiaRenta").val();
        var diasProductoRenta = $("#diasTotalRenta").val();
        var catidadProducto = $("#cantidadProductoRenta").val();
        var claveSatProducto = $("#seleccionClaveRenta").val();
        var claveProducto = $("#clave_productoRenta").val();
        descripcionProductosSeleccionadoGlobal = $("#descProductoRenta").val();

        if(precioDia == ""){
          $(".texto-mensaje").text("PRECIO ES REQUERIDO.");
          $("#msj").modal("toggle");
          return false;
        }

        if(catidadProducto == ""){
          $(".texto-mensaje").text("CANTIDAD ES REQUERIDO.");
          $("#msj").modal("toggle");
          return false;
        }

        var importe = (catidadProducto * precioDia * (diasProductoRenta));

        var htmlProdCotiz =
        "<tr>"+
            "<td class='clavesProductos'>"+claveProducto+"</td>"+
            "<td class='clavesProductosSat'>"+claveSatProducto+"</td>"+
            "<td class='desProductos'>"+descripcionProductosSeleccionadoGlobal+"</td>"+
            "<td class='precioDiaProductos'>"+precioDia+"</td>"+
            "<td class='cantProductos'>"+catidadProducto+"</td>"+
            "<td class='diasProductoRenta'>"+diasProductoRenta+"</td>"+
            "<td class='totalImporteProductosRenta'>"+importe+"</td>"+
            "<td><button type='button' class='btn btn-outline-danger botonEliminar' onclick='eliminarFilaRenta(this, "+idProductoGlobal+","+importe+")' style='width: 100%;'><img src='../iconos/eliminar.png' style='width: 20px;'><input type='hidden' class='totalProductosRenta' value='"+importe+"'/></td>"+
            "<td class='idProductoTabla' style='visibility:collapse; display:none;'>"+idProductoGlobal+"</td>"+
        "</tr>";
        $(".prodCotizRenta").append(htmlProdCotiz);

        var trs=document.querySelectorAll("#tablaProductosAnadidosRenta tbody tr").forEach(function(e){
            produAgre = {
                diasRenta: e.querySelector('.diasProductoRenta').innerText,
                precioDia: e.querySelector('.precioDiaProductos').innerText,
                importe: e.querySelector('.totalImporteProductosRenta').innerText,
                idProducto: e.querySelector('.idProductoTabla').innerText,
                cantidad: e.querySelector('.cantProductos').innerText
            };
        });
        productosTotal.push(produAgre);
        sumarTotalCotizacionRenta();
        limpiarCampos();
    }
}
//====================================================================================================

//FUNCION ELIMINAR PRODUCTO===========================================================================
function sumarTotalCotizacionRenta(){
    var total = 0;
    
    $('.totalProductosRenta').each(function(){
        if (!isNaN($(this).val())) {
          total += Number($(this).val());
          $(".totalCantidadProductosRenta").text(moneda+total.toLocaleString('es-MX'));
          $(".cantidadTotalRenta").val(total);
        }else{alert("si es nan");}
    });
}
//====================================================================================================

//FUNCION ELIMINAR PRODUCTO===========================================================================
function eliminarFilaRenta(valor, idProducto, importe){
    var total = $(".cantidadTotalRenta").val();

    var eliminarProd = total - importe;
    $(".totalCantidadProductosRenta").text(moneda+eliminarProd.toFixed(2));
    valor.closest('tr').remove();

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

//FUNCION GENERAR COTIZACION===========================================================================
function generarCotizacionRenta(){

    var idEmpresaSeleccionada = $("#empresaSelectRenta").val();
    var idUsuario = <?=$idUsuario;?>;
    var totalCotiz = $(".cantidadTotalRenta").val();
    var descripcionCotiz = $("#descCotizacionRenta").val();
    var condiciones = $("#condicionesRenta").val();
    var totalCotizacion = $(".cantidadTotalRenta").val();
    var nombreCliente = $("#clienteCotizacionRenta").val();
    var telefonoCliente = $("#telefonoRenta").val();
    var nombreEmpresa = $("#empresaSelectRenta").val();
    var rfcEmpresa = $("#rfcEmpresaCotizRenta").val();
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

    console.log(jsonData);

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_cotizacion_renta_registro.php",
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
    obtener_datos_empresas_renta();
    // obtener_datos_productosRenta();
    obtener_datos_clientes_renta();
    obtener_datos_proveedor_imprimir_renta();
    obtener_datos_unidades_renta();
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
    $("#rfcEmpresaCotizRenta").hide();

    obtenerDatosProdutosPropios();
});
//====================================================================================================

</script>