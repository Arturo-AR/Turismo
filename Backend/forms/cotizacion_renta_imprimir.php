<?php
session_start();
include 'menu.php';
?>

<div class="panel panel-info">
	<div class="panel-heading">IMPRIMIR COTIZACIÓN RENTA</div>
	<br>
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-3 listaEmpresasImprimirRenta"></div>
			<div class="col-lg-3 listaClientesImprimirRenta"></div>
			<div class="col-lg-2 botonBuscarCotizacionRenta"></div>
		</div>
		<div class="row">
			<div class="col-lg-2 selectCotizImprimir"></div>
			<div class="col-lg-2 selectFoliosImprimir"></div>
			<div class="col-lg-2 checkNombreEmpresa"></div>
		</div>
		<div class="row">
			<div class="col-lg-3 campoNombreEmpresa"></div>
		</div>

		<br><br>
		<div class="titulosh3"><h3>IMPRIMIR COTIZACIÓN</h3></div>
		<div class="row">
			<div class="col-lg-2">
				<label for="folio_cotiz"> Porcentaje de Utilidad </label>
				<input type="text" class="form-control" maxlength="2" onKeypress="soloNumeros(this);" placeholder="Ingresa utilidad" id="utilidad_cotiz_renta">
			</div>
			<div class="col-lg-2 fechaCotizacionImprimir">
				<label>Fecha cotización</label>
				<input type='date' align='center' size='8' name='fecha' id='fecha_cotiz' class='form-control'>
			</div>
			<div class="col-lg-2">
				<label for="no_requisision">Número de requisición</label>
				<input type="text" align="center" size="8" name="no_requisicion" id="no_requisicion" class="form-control">
			</div>
			<div class="col-lg-1">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="firmaCotizImprimirRenta" id="firmaCotizImprimirRenta">Firma
					</label>
				</div>
			</div>
		</div>
		<br><br>
		<div class="row">
			<div class="col-lg-2 botonImprimirCotiz">

            	<button type='button' class='btn btn-outline-success'  onclick='generarPdfCotizacionExcelMasivo();' style='width: 80%;'><img src='../iconos/imprimir.png' style='width: 40px;'>Imprimir</button>
			</div>
			<div class="col-lg-2 botonEnviarCorreoCotiz"></div>
		</div>
	</div>
</div>
<script>
//FUNCION OBTENER DATOS CLIENTES=========================================================================
function crearBusquedaCotizacionRenta(){

	var htmlBotonBuscarCotizacion =
    "<button type='button' class='btn btn-primary'  onclick='consultarFiltrosBusqueda();' style='width: 100%;'><img src='../iconos/buscar.png' style='width: 40px;'>Buscar cotización</button>";
    $(".botonBuscarCotizacionRenta").html(htmlBotonBuscarCotizacion);

    nombreEmpresaGlobal = "";
	idEmpresaGlobal = "";
	nombreClienteGlobal = "";
	idClienteGlobal = "";
	
	obtener_datos_empresas_cotizacion_renta_imprimir();
	obtener_datos_clientes_cotizacion_renta_imprimir();
	obtener_datos_proveedor_cotizacion_renta_imprimir();

}
//====================================================================================================

//FUNCION OBTENER DATOS EMPRESAS=======================================================================
function obtener_datos_empresas_cotizacion_renta_imprimir(){

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
                "<label for='seleccionEmpresa'>Buscar por Empresas:</label>"+
                "<input list='listaEmpresas' name='empresa_cotiz' id='empresaSelect' class='form-control' onchange='seleccionarEmpresaImprimir(this);'>"+

                "<datalist id='listaEmpresas'>"+opcionesEmpresas+"</datalist>";
                $(".listaEmpresasImprimirRenta").html(htmlSelectEmpresas);
            }
        }
    });
    closeMessageOverlay();
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS=========================================================================
function seleccionarEmpresaImprimir(e){
    nombreEmpresaGlobal = $(e).val();

    idEmpresaGlobal = $('#listaEmpresas').find('option[value="'+nombreEmpresaGlobal+'"]').data('id');

}
//====================================================================================================

//FUNCION OBTENER DATOS CLIENTES======================================================================
function obtener_datos_clientes_cotizacion_renta_imprimir(){

    showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_cliente_mostrar.php",
        data: "",
        success:function(data){
          var resultadoMostrar = JSON.parse(data);
          if(resultadoMostrar["codigo"] == "fallo"){
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
                "<label for='seleccionCliente'>Buscar por Clientes:</label>"+
                "<input list='listaClientes' name='cliente' id='cliente' class='form-control' onchange='seleccionarClienteImprimir(this);'>"+

                "<datalist id='listaClientes'>"+opcionesClientes+"</datalist>";
                $(".listaClientesImprimirRenta").html(htmlSelectClientes);

                closeMessageOverlay();
            }
        }
    });
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS=========================================================================
function seleccionarClienteImprimir(e){
    nombreClienteGlobal = $(e).val();

    idClienteGlobal = $('#listaClientes').find('option[value="'+nombreClienteGlobal+'"]').data('id');

}
//====================================================================================================

//FUNCION CONSULTAR FILTROS DE BUSQUEDA===============================================================
function consultarFiltrosBusqueda(){
	
   	var jsonData = "";

	showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
    $.ajax({
        method: "POST",
        url: "../backend/backend_cotizacion_renta_mostrar_todas.php",
        data: jsonData,
        success:function(data){
          var resultadoMostrar = JSON.parse(data);
            if(resultadoMostrar["codigo"] == "fallo"){
                var resultados = resultadoMostrar["mensaje"];
              	$(".texto-mensaje").text(resultados);
                $("#msj").modal("toggle");
               closeMessageOverlay();
               $("#cotizacionesEncontradasImprimirRenta").val(-1);
               $(".selectFoliosImprimir").html("");

            }
            else if(resultadoMostrar["codigo"] == "exito"){
                var resultadosTotales = resultadoMostrar["objetoRespuesta"]["cotizaciones_renta"];
                console.log(resultadosTotales);

                var opcionesCotizaciones = "<option value='-1'>Cotizaciones *</option>";

                for (i = 0; i < resultadosTotales.length; i++) {
                    var resultado = resultadosTotales[i];
                    var idCliente = resultado["idCliente"];
                    var idEmpresa   = resultado["idEmpresa"];
                    var fecha_registro  = resultado["fecha_registro"];
                    var idCotizacionRenta   = resultado["idCotizacionRenta"];
                    var descripcion  = resultado["descripcion"];

                    opcionesCotizaciones += "<option value='"+idCotizacionRenta+"'>COTZ00"+idCotizacionRenta+"</option>";
                }
                var htmlSelectCotizacionesEncontradas =

                "<label>Cotizaciones</label>"+
                "<select class='form-control' name='cotizacionesEncontradasImprimirRenta' id='cotizacionesEncontradasImprimirRenta'>"+opcionesCotizaciones+"</select>";
                $(".selectFoliosImprimir").html(htmlSelectCotizacionesEncontradas);

            }
            closeMessageOverlay();
        }
    });
	
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS=========================================================================
function seleccionarClienteImprimir(e){
    nombreClienteGlobal = $(e).val();

    idClienteGlobal = $('#listaClientes').find('option[value="'+nombreClienteGlobal+'"]').data('id');

}
//====================================================================================================

//FUNCION OBTENER DATOS PROVEEDORES Y FOLIOS=======================================================================
function obtener_datos_proveedor_cotizacion_renta_imprimir(){

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
                var opcionesCotizacionesImprimirExcel = "<option value='-1' folio='' proveedor=''>Proveedor *</option>";

                for (i = 0; i < resultados.length; i++) {
                    var resultadosTotales = resultados[i];
                    // console.log(resultadosTotales);
                    var idProveedor = resultadosTotales["idProveedor"];
                    var folio   = resultadosTotales["folio"];
                    var proveedor = resultadosTotales["proveedor"];

                    opcionesCotizacionesImprimirExcel += "<option value='"+idProveedor+"' folio='"+folio+"' proveedor='"+proveedor+"'>"+proveedor+"</option>";
                }
                var htmlSelectCotizacionesExcel =
                "<label>Proveedor</label>"+
                "<select class='form-control' name='proveedor_imprimir_renta' id='proveedor_imprimir_renta' onchange='selectFoliosImprimir(this);'>"+opcionesCotizacionesImprimirExcel+"</select>";
                $(".selectCotizImprimir").html(htmlSelectCotizacionesExcel);
                closeMessageOverlay();
            }
        }
    });
}
//====================================================================================================

//FUNCION OBTENER FOLIOS=======================================================================
function selectFoliosImprimir(e){
	var idProveedorSeleccionada = $(e).val();

	var general = "";

	if (idProveedorSeleccionada == 2) {

		// var htmlCheckLogoEmpresa =
		// "<div class='checkbox'><label><input type='checkbox' name='logoEmpresaCheck' id='logoEmpresaCheck'>Logo</label></div>";
		// $(".checkLogoEmpresa").html(htmlCheckLogoEmpresa);

		var htmlCheckNombreEmpresa =
		"<div class='checkbox'><label><input type='checkbox' name='nombreEmpresaCheck' id='nombreEmpresaCheck'>Nombre</label></div>";
		$(".checkNombreEmpresa").html(htmlCheckNombreEmpresa);

	}
	else{
		$(".checkLogoEmpresa").html("");
		$(".checkNombreEmpresa").html("");
	}

	// $('#logoEmpresaCheck').on('change', function() {
	//     var checked = this.checked
	//     if (checked == true) {
	//     	general = 1;
	//     	var htmlCampoLogoEmpresa =
	// 		"<label>Logo de Empresa</label>"+
	// 		"<button class='botonLogoEmpresa'>";
	// 		$(".campoLogoEmpresa").html(htmlCampoLogoEmpresa);

	// 		var htmlBotonImprimirCotiz =
 //            "<button type='button' class='btn btn-outline-success'  onclick='generarPdfCotizacionExcelMasivo("+general+");' style='width: 80%;'><img src='../iconos/imprimir.png' style='width: 40px;'>Imprimir</button>";
 //            $(".botonImprimirCotiz").html(htmlBotonImprimirCotiz);
	//     }
	//     else{
	//     	$(".campoLogoEmpresa").html("");
	//     }
	// });

	$('#nombreEmpresaCheck').on('change', function() {
	    var checked = this.checked
	    if (checked == true) {
	    	general = 2
	    	var htmlCampoNombreEmpresa =
			"<label>Nombre de Empresa</label>"+
			"<input type='text' value name='nombreEmpresa' id='nombreEmpresa' class='form-control'>";
			$(".campoNombreEmpresa").html(htmlCampoNombreEmpresa);

			var htmlBotonImprimirCotiz =
            "<button type='button' class='btn btn-outline-success'  onclick='generarPdfCotizacionExcelMasivo("+general+");' style='width: 80%;'><img src='../iconos/imprimir.png' style='width: 40px;'>Imprimir</button>";
            $(".botonImprimirCotiz").html(htmlBotonImprimirCotiz);
	    }
	    else{
	    	$(".campoNombreEmpresa").html("");
	    }
	});

}
//====================================================================================================

//FUNCION IMPRIMIR COTIZACION=======================================================================
function generarPdfCotizacionExcelMasivo(general){

	var idProveedor =  $("#proveedor_imprimir_renta").val();

	var proveedor =  $("#proveedor_imprimir_renta option:selected").attr("proveedor");
	var utilidad = $("#utilidad_cotiz_renta").val();
	var firma = $("#firmaCotizImprimirRenta").prop("checked");
	var logoEmpresa = $("#logoEmpresa").val();
	var nombreEmpresa = $("#nombreEmpresa").val();

	if(validacionCamposSelect(idProveedor, ".texto-mensaje", 0, "Seleccione un proveedor para generar cotización.") == false){
	    $("#msj").modal("toggle");
	    return false;
	}

	var idCotizacionRenta = $("#cotizacionesEncontradasImprimirRenta").val();

	if(validacionCamposSelect(idCotizacionRenta, ".texto-mensaje", 0, "Seleccione un folio para generar cotización.") == false){
	    $("#msj").modal("toggle");
	    return false;
	}

	if(validacionCamposInput(utilidad, "soloNumeros", ".texto-mensaje", "Utilidad solo permite numeros.", 0, "La utilidad es obligatorio.") == false){
        $("#msj").modal("toggle");
        return false;
    }

	if (general == 1) {

		window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+proveedor+'&&idCotizacionRenta='+idCotizacionRenta+'&&utilidad='+utilidad+'&&firma='+firma+'&&logo='+logoEmpresa);
	}
	else if (general == 2){

		window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+proveedor+'&&idCotizacionRenta='+idCotizacionRenta+'&&utilidad='+utilidad+'&&firma='+firma+'&&nombreEmpresa='+nombreEmpresa);
	}

    window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+proveedor+'&&idCotizacionRenta='+idCotizacionRenta+'&&utilidad='+utilidad+'&&firma='+firma);

}

//====================================================================================================

//EVENTO READY========================================================================================
$(document).ready(function(){
	crearBusquedaCotizacionRenta();
	idSelectTipoGlobal = "";
	nombreEmpresaGlobal = "";
	idEmpresaGlobal = "";
	nombreClienteGlobal = "";
	idClienteGlobal = "";
});
//====================================================================================================
</script>
