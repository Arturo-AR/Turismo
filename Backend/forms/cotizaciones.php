<?php
session_start();
$idUsuario = $_SESSION['idUsuario'];
require '../principal/menu.php';
?>
<div class="panel panel-info">
    <div class="panel-heading">GENERAR COTIZACIÓN</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-4 selectEmpresas"></div>

            <div class="col-sm-4 clientesCotizacionSelect"></div>
            <div class="col-lg-3 campoTelefonoCliente"></div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <label>Fecha Cotización</label>
                <input type="date" name="fecha_presentada" class="form-control" id="fecha_cotizacion">
            </div>
            <div class="col-sm-3">
                <label>Descripción Cotización</label>
                <input type="text" id="descCotizacion" class="form-control" maxlength="20" placeholder="Ingresa una descripcion *">
            </div>

        </div>
        <div class="row">
            <div class="col-lg-5 listaProductos"></div>
            <div class="col-lg-5 listaProductosClave"></div>
        </div>
        <div class="row">
            <div class="col-lg-2 campoUnidadProducto"></div>
            <div class="col-lg-2 campoClaveProducto"></div>
            <div class="col-lg-4 campoDescripcionProducto"></div>
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
            <div class="col-lg-2">
                <br>
                <!-- <label>Alta Producto</label> -->
                <button type="button" class="btn btn-outline-primary" onclick="abrirPopupAltaProductos();" style="width: 100%;"><img src="../iconos/paquete.png" style="width: 30px;">Alta Producto</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-primary bg-light tablaProductosTotal" id="tablaProductosAnadidos">
                <thead>
                    <tr>
                        <th>Clave</th>
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

            </div>
            <div class="text-center totalCantidadProductos" style="font-size: 40px; color: #000;"></div>
            <div>
                <input type="hidden" class="cantidadTotal">
            </div>
        </div>
        <div class="text-center">
            <label>GENERAR</label>
        </div>
        <div class="text-center">
            <button type="button" class="btn btn-outline-success generarCotizacion" onclick="generarCotizacion();" style="width: 20%;"><img src="../iconos/cotizacion.png" style="width: 40px;"></button>
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
                "<select name='empresa_cotiz' class='form-control' id='empresaSelect'>"+opcionesEmpresas+"</select>";
                $(".selectEmpresas").html(htmlSelectEmpresas);
            }
        }
    });
    closeMessageOverlay();
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
                "<label for='seleccion'>Buscar Productos:</label>"+
                "<input list='lista' name='claveDelParámetro' id='seleccion' class='form-control' onchange='selectProductosCombinar(this);'>"+

                "<datalist id='lista'>"+opcionesListaProductos+"</datalist>";
                $(".listaProductos").html(htmlDivListasProductos);

                var htmlDivListasProductosClave =
                "<label for='seleccion'>Buscar Productos por clave:</label>"+
                "<input list='listaClave' name='claveDelParámetros' id='seleccionClave' class='form-control' onchange='selectProductosCombinarClave(this);'>"+

                "<datalist id='listaClave'>"+opcionesListaProductosClave+"</datalist>";
                $(".listaProductosClave").html(htmlDivListasProductosClave);
            }
        }
    });
    closeMessageOverlay();
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS===============================================================
function selectProductosCombinar(e){
    descripcionProductosSeleccionadoGlobal = $(e).val();

    claveProductoGlobal = $('#lista').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('clave');
    idProductoGlobal = $('#lista').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('id');
    existenciaProductoGlobal = $('#lista').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('existencia');
    unidadProductoGlobal = $('#lista').find('option[value="'+descripcionProductosSeleccionadoGlobal+'"]').data('unidad');

    var htmlCampoClaveProducto =
    "<label for='clave_producto'>Clave</label>"+
    "<input type='text' name='clave_producto' id='clave_producto' class='form-control' value='"+claveProductoGlobal+"' placeholder='Ingresa clave del producto o selecciona alguno'>";
    $(".campoClaveProducto").html(htmlCampoClaveProducto);

    var htmlCampoDescripcionProducto =
    "<label>Descripción</label>"+
    "<input type='text' name='descProducto' id='descProducto' class='form-control' value='"+descripcionProductosSeleccionadoGlobal+"' placeholder='Ingresa descripción'>";
    $(".campoDescripcionProducto").html(htmlCampoDescripcionProducto);

    var htmlCampoUnidadProducto =
    "<label for='clave_producto'>Unidad</label>"+
    "<input type='text' name='unidad_producto' id='unidad_producto' class='form-control' value='"+unidadProductoGlobal+"' placeholder='Ingresa clave del producto o selecciona alguno'>";
    $(".campoUnidadProducto").html(htmlCampoUnidadProducto);

    var htmlBotonAgregarProducto =
    "<br>"+
    // "<label>Agregar Producto</label>"+
    "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacion("+idProductoGlobal+")' style='width: 100%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'>Agregar Producto</button>";
    $(".botonAgregarProducto").html(htmlBotonAgregarProducto);

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
                // var resultados = resultadoMostrar["mensaje"];
                // $(".texto-mensaje").text(resultados);
                // $("#msj").modal("toggle");
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

//FUNCION OBTENER DATOS INPUT PRODUCTOS=========================================================================
function selectProductosCombinarClave(e){
    claveProductoGlobal = $(e).val();

    descripcionProductosSeleccionadoGlobal = $('#listaClave').find('option[value="'+claveProductoGlobal+'"]').data('descripcion');
    idProductoGlobal = $('#listaClave').find('option[value="'+claveProductoGlobal+'"]').data('id');
    existenciaProductoGlobal = $('#listaClave').find('option[value="'+claveProductoGlobal+'"]').data('existencia');
    unidadProductoGlobal = $('#listaClave').find('option[value="'+claveProductoGlobal+'"]').data('unidad');

    var htmlCampoClaveProducto =
    "<label>Clave</label>"+
    "<input type='text' name='clave_producto' id='clave_producto' class='form-control' value='"+claveProductoGlobal+"' placeholder='Ingresa clave del producto o selecciona alguno'>";
    $(".campoClaveProducto").html(htmlCampoClaveProducto);

    var htmlCampoDescripcionProducto =
    "<label>Descripción</label>"+
    "<input type='text' name='descProducto' id='descProducto' class='form-control' value='"+descripcionProductosSeleccionadoGlobal+"' placeholder='Ingresa descripción'>";
    $(".campoDescripcionProducto").html(htmlCampoDescripcionProducto);

    var htmlCampoUnidadProducto =
    "<label>Unidad</label>"+
    "<input type='text' name='unidad_producto' id='unidad_producto' class='form-control' value='"+unidadProductoGlobal+"' placeholder='Ingresa clave del producto o selecciona alguno'>";
    $(".campoUnidadProducto").html(htmlCampoUnidadProducto);

    var htmlBotonAgregarProducto =
    "<br>"+
    "<label>Agregar Producto</label>"+
    "<button class='btn btn-outline-success' type='button' onclick='agregarProductoCotizacion("+idProductoGlobal+")' style='width: 30%;'><img src='../iconos/agregar_producto.png' style='width: 30px;'></button>";
    $(".botonAgregarProducto").html(htmlBotonAgregarProducto);

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
                // var resultados = resultadoMostrar["mensaje"];
                // $(".texto-mensaje").text(resultados);
                // $("#msj").modal("toggle");
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
                        "<td><label>"+fechaRegistro+"</label></td>"+
                        "<td><label>"+folioCotizacionDetalle+"</label></td>"+
                        "<td><label>"+precioUnitario+"</label></td>"+
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
                var htmlSelectClientes =
                "<label>Cliente Cotización</label>"+
                "<select name='cliente_cotiz' class='form-control' id='clienteCotizacion' onchange='selectClienteCombinar(this);'>"+opcionesClientes+"</select>";
                $(".clientesCotizacionSelect").html(htmlSelectClientes);
                closeMessageOverlay();
            }
        }
    });
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT EMPRESAS================================================================
function selectClienteCombinar(e){
    var idClienteSeleccionada = $(e).val();

    var telefonoClienteSeleccionado   = $("#clienteCotizacion option:selected").attr("telefono");

    var htmlCampoTelefonoCliente =
    "<label>Teléfono</label>"+
    "<input type='text' name='telefono' id='telefono' class='form-control' value='"+telefonoClienteSeleccionado+"'>";
    $(".campoTelefonoCliente").html(htmlCampoTelefonoCliente);

}
//======================================================================================================

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
                // console.log(resultados);
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

    var precioLista = $("#precioLista").val();
    var catidadProducto = $("#cantidadProducto").val();

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

    if(precioLista == ""){
      $(".texto-mensaje").text("PRECIO ES REQUERIDO.");
      $("#msj").modal("toggle");
      return false;
    }

    var total = 0;

    total = catidadProducto;
    var importe = total * precioLista;

    var htmlProdCotiz =
    "<tr>"+
        "<td class='clavesProductos'>"+claveProductoGlobal+"</td>"+
        "<td class='desProductos'>"+descripcionProductosSeleccionadoGlobal+"</td>"+
        // "<td class='exisProductos'>"+existenciaProductoGlobal+"</td>"+
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

    var total = 0;

    $('.totalProductos').each(function(){

        if (!isNaN($(this).val())) {
          total += Number($(this).val());
          $(".totalCantidadProductos").text(moneda+total.toLocaleString('es-MX'));
          $(".cantidadTotal").val(total);
        }else{alert("si es nan");}
    });
    limpiarCampos();
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
    // btn.prop("disabled", "disabled");

    var idEmpresaSeleccionada = $("#empresaSelect").val();
    var idClienteSeleccionado = $("#clienteCotizacion").val();
    var idUsuario = <?=$idUsuario;?>;
    var fechaRegistro = $("#fecha_cotizacion").val();
    var totalCotiz = $(".cantidadTotal").val();
    var descripcionCotiz = $("#descCotizacion").val();
    var condiciones = $("#condiciones").val();
    var totalCotizacion = $(".cantidadTotal").val();
    var foliosArray = folioEmpresas;

    // var nombreProductoSeleccionado = $("#seleccion").val();
    // var claveProductoSeleccionado = $("#seleccionClave").val();
    // var cantidadProducto = $("#cantidadProducto").val();
    // var precioLista = $("#precioLista").val();
    // var tablaProductos = document.getElementById("tablaProductosAnadidos");

    //VALIDACIONES DE CAMPOS A MANDAR

    if(idClienteSeleccionado == "-1"){
      $(".texto-mensaje").text("CLIENTE ES REQUERIDO.");
      $("#msj").modal("toggle");
      return false;
    }

    if(fechaRegistro == ""){
      $(".texto-mensaje").text("FECHA DE REGISTRO ES REQUERIDO.");
      $("#msj").modal("toggle");
      return false;
    }

    if(descripcionCotiz == ""){
      $(".texto-mensaje").text("LA DESCRIPCIÓN DE LA COTIZACIÓN ES REQUERIDO.");
      $("#msj").modal("toggle");
      return false;
    }

    // if(nombreProductoSeleccionado == "" && claveProductoSeleccionado == ""){
    //   $(".texto-mensaje").text("SE NECESITA MINIMO UN PRODUCTO PARA GENERAR UNA COTIZACIÓN.");
    //   $("#msj").modal("toggle");
    //   return false;
    // }

    // if(cantidadProducto == ""){
    //   $(".texto-mensaje").text("INGRESA LA CANTIDAD DEL PRODUCTO.");
    //   $("#msj").modal("toggle");
    //   return false;
    // }

    // if(precioLista == ""){
    //   $(".texto-mensaje").text("INGRESA EL PRECIO DEL PRODUCTO.");
    //   $("#msj").modal("toggle");
    //   return false;
    // }

    // if(tablaProductos.firstChild){
    //   $(".texto-mensaje").text("INGRESA EL PRODUCTO A LA TABLA EN EL BOTÓN DE AGREGAR PRODUCTOS.");
    //   $("#msj").modal("toggle");
    //   return false;
    // }

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

    var productosArray = productosTotal;

    var jsonData = {
        "idEmpresa": idEmpresaSeleccionada,
        "idCliente": idClienteSeleccionado,
        "idUsuario": idUsuario,
        "fechaRegistro": fechaRegistro,
        "total": totalCotiz,
        "descripcion": descripcionCotiz,
        "condiciones": condiciones,
        "folios": JSON.stringify(foliosArray),
        "productos": JSON.stringify(productosArray)
        }

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_cotizacion_registro.php",
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
    resultadosTotales = "";
    descripcionProductosSeleccionadoGlobal = "";
    claveProductoGlobal = "";
    idProductoGlobal = "";
    existenciaProductoGlobal = "";
    unidadProductoGlobal = "";
    folioEmpresas = new Array();
    productosTotal = new Array();
    moneda = "TOTAL $";
    empresaAtencionSeleccionada = "";
    empresaTelefonoSeleccionada = "";

});
//====================================================================================================

</script>

