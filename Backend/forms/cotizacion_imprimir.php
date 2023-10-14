<?php
session_start();
include 'menu.php';
?>

<div class="panel panel-info">
	<div class="panel-heading">IMPRIMIR COTIZACIÓN</div>
	<br>
	<div class="panel-body">
		<div class="titulosh3"><h3>BUSQUEDA DE COTIZACIONES</h3></div>
		<div class="row">
			<div class="col-lg-4 selectTipoCotizImprimir">
				<label>Tipo de cotizaciones</label>
				<select class="form-control" id="tipoCotizacionImprimir" onchange="tipoCotizacionSelect();">
					<option value="-1">Tipos</option>
					<option value="0">Cotizaciones</option>
					<option value="1">Cotizaciones Multiples</option>
					<option value="2">Cotizaciones Excel Multiple</option>
					<option value="3">Cotizaciones Excel</option>
				</select>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-lg-3 listaEmpresasImprimir"></div>
			<div class="col-lg-3 listaClientesImprimir"></div>
			<div class="col-lg-2 botonBuscarCotizacion"></div>
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
				<input type="text" class="form-control" maxlength="2" onKeypress="soloNumeros(this);" placeholder="Ingresa utilidad" id="utilidad_cotiz">
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
						<input type="checkbox" name="firmaCotizImprimir" id="firmaCotizImprimir">Firma
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
function tipoCotizacionSelect(){
	idSelectTipoGlobal = $('#tipoCotizacionImprimir').val();

	if ((idSelectTipoGlobal == 0) || (idSelectTipoGlobal == 1)) {
		var htmlBotonBuscarCotizacion =
	    "<button type='button' class='btn btn-primary'  onclick='consultarFiltrosBusqueda(0);' style='width: 100%;'><img src='../iconos/buscar.png' style='width: 40px;'>Buscar cotización</button>";
	    $(".botonBuscarCotizacion").html(htmlBotonBuscarCotizacion);

	    nombreEmpresaGlobal = "";
		idEmpresaGlobal = "";
		nombreClienteGlobal = "";
		idClienteGlobal = "";
	}
	else if ((idSelectTipoGlobal == 2) || (idSelectTipoGlobal == 3)){
		var htmlBotonBuscarCotizacion =
	    "<button type='button' class='btn btn-primary'  onclick='consultarFiltrosBusqueda(1);' style='width: 100%;'><img src='../iconos/buscar.png' style='width: 40px;'>Buscar cotización</button>";
	    $(".botonBuscarCotizacion").html(htmlBotonBuscarCotizacion);

	    nombreEmpresaGlobal = "";
		idEmpresaGlobal = "";
		nombreClienteGlobal = "";
		idClienteGlobal = "";
	}

    obtener_datos_proveedor_excel_masivos_imprimir();
	obtener_datos_empresas_excel_masivos_imprimir();
	obtener_datos_clientes_excel_masivos_imprimir();

}
//====================================================================================================

//FUNCION OBTENER DATOS EMPRESAS=======================================================================
function obtener_datos_empresas_excel_masivos_imprimir(){

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
                $(".listaEmpresasImprimir").html(htmlSelectEmpresas);
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
function obtener_datos_clientes_excel_masivos_imprimir(){

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
                $(".listaClientesImprimir").html(htmlSelectClientes);

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
function consultarFiltrosBusqueda(operacion){
	
	

	if (operacion == 0) {
		$("#empresaSelect").val();
		$("#cliente").val();

		if ((idEmpresaGlobal != "") && (idClienteGlobal != "")) {
	    	var jsonData = {
		    	"idEmpresa": idEmpresaGlobal,
		    	"idCliente": idClienteGlobal,
		    }
	    }
	    else if (idEmpresaGlobal != ""){
	    	var jsonData = {
		    	"idEmpresa": idEmpresaGlobal,
		    }
	    }
	    else if (idClienteGlobal != ""){
	    	var jsonData = {
		    	"idCliente": idClienteGlobal,
		    }
	    }
	    else{

	    	var jsonData = "";
	    }
	    

	    if (idSelectTipoGlobal == 0) {
			showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
		    $.ajax({
		        method: "POST",
		        url: "../backend/backend_cotizacion_unica_motrar_todas.php",
		        data: jsonData,
		        success:function(data){
		          var resultadoMostrar = JSON.parse(data);
		            if(resultadoMostrar["codigo"] == "fallo"){
		                var resultados = resultadoMostrar["mensaje"];
		              	$(".texto-mensaje").text(resultados);
		                $("#msj").modal("toggle");
		               closeMessageOverlay();
		               $("#cotizacionesEncontradasImprimir").val(-1);
		               $(".selectFoliosImprimir").html("");

		            }
		            else if(resultadoMostrar["codigo"] == "exito"){
		                var resultadosTotales = resultadoMostrar["objetoRespuesta"]["cotizaciones_unica"];

		                var opcionesCotizaciones = "<option value='-1'>Cotizaciones *</option>";

		                for (i = 0; i < resultadosTotales.length; i++) {
		                    var resultado = resultadosTotales[i];
		                    var idCliente = resultado["idCliente"];
		                    var idEmpresa   = resultado["idEmpresa"];
		                    var fecha_registro  = resultado["fecha_registro"];
		                    var idCotizacionUnica   = resultado["idCotizacionUnica"];
		                    var descripcion  = resultado["descripcion"];

		                    opcionesCotizaciones += "<option value='"+idCotizacionUnica+"'>COTZ00"+idCotizacionUnica+"</option>";
		                }
		                var htmlSelectCotizacionesEncontradas =

		                "<label>Cotizaciones</label>"+
		                "<select class='form-control' name='cotizacionesEncontradasImprimir' id='cotizacionesEncontradasImprimir'>"+opcionesCotizaciones+"</select>";
		                $(".selectFoliosImprimir").html(htmlSelectCotizacionesEncontradas);

		            }
		            closeMessageOverlay();
		        }
		    });
	    }
	    else if(idSelectTipoGlobal == 1){

	    	var selectProvedor = $("#proveedor_imprimir").val();

	    	if (selectProvedor == -1) {
	    		$(".texto-mensaje").text("Selecciona un proveedor.");
		        $("#msj").modal("toggle");
		        return false;
	    	}
	    	
            var folioSeleccionado = $("#proveedor_imprimir option:selected").attr("folio");
            console.log(folioSeleccionado);

		    var jsonData = {
		        "folioCotizacion": folioSeleccionado,
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
		                // console.log(resultados);
		                var opcionesFolioCotizacionesImprimir = "<option value='-1' folio=''>Cotizaciones *</option>";

		                for (i = 0; i < resultados.length; i++) {
		                    var resultadosTotales = resultados[i];
		                    // console.log(resultadosTotales);
		                    var idCotizacionEncontrada = resultadosTotales["idCotizacion"];
		                    var folioCotizacion   = resultadosTotales["folioCotizacion"];

		                    opcionesFolioCotizacionesImprimir += "<option value='"+idCotizacionEncontrada+"' folio='"+folioCotizacion+"'>"+folioCotizacion+"</option>";
		                }
		                var htmlSelectCotizacionesProveedor =
		                "<label>Cotizaciones Encontradas</label>"+
		                "<select name='cotizEncontradaImprimir' class='form-control' id='cotizacionesEncontradasImprimir'>"+opcionesFolioCotizacionesImprimir+"</select>";
		                $(".selectFoliosImprimir").html(htmlSelectCotizacionesProveedor);

		            }
		            closeMessageOverlay();
		        }
		    });
	    }
	}
	else if (operacion == 1){

		$("#empresaSelect").val();
		$("#cliente").val();

		if ((nombreEmpresaGlobal != "") && (nombreClienteGlobal != "")) {
	    	var jsonData = {
		    	"empresa": nombreEmpresaGlobal,
		    	"cliente": nombreClienteGlobal,
		    }
	    }
	    else if (nombreEmpresaGlobal != ""){
	    	var jsonData = {
		    	"empresa": nombreEmpresaGlobal,
		    }
	    }
	    else if (nombreClienteGlobal != ""){
	    	var jsonData = {
		    	"cliente": nombreClienteGlobal,
		    }
	    }
	    else{

	    	var jsonData = "";
	    }


		if (idSelectTipoGlobal == 2) {
			showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
		    $.ajax({
		        method: "POST",
		        url: "../backend/backend_cotizacion_excel_mostrar_todas.php",
		        data: jsonData,
		        success:function(data){
		          var resultadoMostrar = JSON.parse(data);
		            if(resultadoMostrar["codigo"] == "fallo"){
		                var resultados = resultadoMostrar["mensaje"];
		              	$(".texto-mensaje").text(resultados);
		                $("#msj").modal("toggle");
		               closeMessageOverlay();
		               $("#cotizacionesEncontradasImprimir").val(-1);
		               $(".selectFoliosImprimir").html("");

		            }
		            else if(resultadoMostrar["codigo"] == "exito"){
		                var resultadosTotales = resultadoMostrar["objetoRespuesta"]["cotizaciones_excel"];

		                var opcionesCotizaciones = "<option value='-1'>Cotizaciones *</option>";

		                for (i = 0; i < resultadosTotales.length; i++) {
		                    var resultado = resultadosTotales[i];
		                    var cliente = resultado["cliente"];
		                    var empresa   = resultado["empresa"];
		                    var fecha_registro  = resultado["fecha_registro"];
		                    var idCotizacionExcel   = resultado["idCotizacionExcel"];
		                    var telefono  = resultado["telefono"];

		                    opcionesCotizaciones += "<option value='"+idCotizacionExcel+"'>"+idCotizacionExcel+"</option>";
		                }
		                var htmlSelectCotizacionesEncontradas =

		                "<label>Cotizaciones</label>"+
		                "<select class='form-control' name='cotizacionesEncontradasImprimir' id='cotizacionesEncontradasImprimir'>"+opcionesCotizaciones+"</select>";
		                $(".selectFoliosImprimir").html(htmlSelectCotizacionesEncontradas);

		            }
		            closeMessageOverlay();
		        }
		    });
		}
		else if(idSelectTipoGlobal == 3){
			showMessageOverlay("CARGANDO...", "../iconos/cargando.gif", "200", "200", "sending");
		    $.ajax({
		        method: "POST",
		        url: "../backend/backend_cotizacion_excel_unica_mostrar_todas.php",
		        data: jsonData,
		        success:function(data){
		          var resultadoMostrar = JSON.parse(data);
		            if(resultadoMostrar["codigo"] == "fallo"){
		                var resultados = resultadoMostrar["mensaje"];
		              	$(".texto-mensaje").text(resultados);
		                $("#msj").modal("toggle");
		               closeMessageOverlay();
		               $("#cotizacionesEncontradasImprimir").val(-1);
		               $(".selectFoliosImprimir").html("");

		            }
		            else if(resultadoMostrar["codigo"] == "exito"){
		                var resultadosTotales = resultadoMostrar["objetoRespuesta"]["cotizaciones_excel_unica"];

		                var opcionesCotizaciones = "<option value='-1'>Cotizaciones *</option>";

		                for (i = 0; i < resultadosTotales.length; i++) {
		                    var resultado = resultadosTotales[i];
		                    var cliente = resultado["cliente"];
		                    var empresa   = resultado["empresa"];
		                    var fecha_registro  = resultado["fecha_registro"];
		                    var idCotizacionExcel   = resultado["idCotizacionExcel"];
		                    var telefono  = resultado["telefono"];

		                    opcionesCotizaciones += "<option value='"+idCotizacionExcel+"'>COTIEX00"+idCotizacionExcel+"</option>";
		                }
		                var htmlSelectCotizacionesEncontradas =

		                "<label>Cotizaciones</label>"+
		                "<select class='form-control' name='cotizacionesEncontradasImprimir' id='cotizacionesEncontradasImprimir'>"+opcionesCotizaciones+"</select>";
		                $(".selectFoliosImprimir").html(htmlSelectCotizacionesEncontradas);

		            }
		            closeMessageOverlay();
		        }
		    });
	    }

	}

	
}
//====================================================================================================

//FUNCION OBTENER DATOS INPUT PRODUCTOS=========================================================================
function seleccionarClienteImprimir(e){
    nombreClienteGlobal = $(e).val();

    idClienteGlobal = $('#listaClientes').find('option[value="'+nombreClienteGlobal+'"]').data('id');

}
//====================================================================================================

//FUNCION OBTENER DATOS PROVEEDORES Y FOLIOS=======================================================================
function obtener_datos_proveedor_excel_masivos_imprimir(){

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
                "<select class='form-control' name='proveedor_imprimir' id='proveedor_imprimir' onchange='selectFoliosImprimir(this);'>"+opcionesCotizacionesImprimirExcel+"</select>";
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
	console.log(idProveedorSeleccionada);

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

	var idProveedor =  $("#proveedor_imprimir").val();

	var proveedor =  $("#proveedor_imprimir option:selected").attr("proveedor");
	var utilidad = $("#utilidad_cotiz").val();
	var firma = $("#firmaCotizImprimir").prop("checked");
	var logoEmpresa = $("#logoEmpresa").val();
	var nombreEmpresa = $("#nombreEmpresa").val();

	if(validacionCamposSelect(idProveedor, ".texto-mensaje", 0, "Seleccione un proveedor para generar cotización.") == false){
	    $("#msj").modal("toggle");
	    return false;
	}

	if (idSelectTipoGlobal == 0) {
		var idCotizacionUnica = $("#cotizacionesEncontradasImprimir").val();

		if(validacionCamposSelect(idCotizacionUnica, ".texto-mensaje", 0, "Seleccione un folio para generar cotización.") == false){
		    $("#msj").modal("toggle");
		    return false;
		}

		if(validacionCamposInput(utilidad, "soloNumeros", ".texto-mensaje", "Utilidad solo permite numeros.", 0, "La utilidad es obligatorio.") == false){
	        $("#msj").modal("toggle");
	        return false;
	    }

		if (general == 1) {

			window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+proveedor+'&&idCotizacionUnica='+idCotizacionUnica+'&&utilidad='+utilidad+'&&firma='+firma+'&&logo='+logoEmpresa);
		}
		else if (general == 2){

			window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+proveedor+'&&idCotizacionUnica='+idCotizacionUnica+'&&utilidad='+utilidad+'&&firma='+firma+'&&nombreEmpresa='+nombreEmpresa);
		}

	    window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+proveedor+'&&idCotizacionUnica='+idCotizacionUnica+'&&utilidad='+utilidad+'&&firma='+firma);
	}
	else if (idSelectTipoGlobal == 1){
		// var idCotizacion = $("#cotizacionesEncontradasImprimir").val();
		var idCotizacion = $("#cotizacionesEncontradasImprimir option:selected").text();

		if(validacionCamposSelect(idCotizacion, ".texto-mensaje", 0, "Seleccione un folio para generar cotización.") == false){
		    $("#msj").modal("toggle");
		    return false;
		}

		if(validacionCamposInput(utilidad, "soloNumeros", ".texto-mensaje", "Utilidad solo permite numeros.", 0, "La utilidad es obligatorio.") == false){
	        $("#msj").modal("toggle");
	        return false;
	    }

		if (general == 1) {

			window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+proveedor+'&&folioCotizacionDetalle='+idCotizacion+'&&utilidad='+utilidad+'&&firma='+firma+'&&logo='+logoEmpresa);
		}
		else if (general == 2){

			window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+proveedor+'&&folioCotizacionDetalle='+idCotizacion+'&&utilidad='+utilidad+'&&firma='+firma+'&&nombreEmpresa='+nombreEmpresa);
		}

	    window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+proveedor+'&&folioCotizacionDetalle='+idCotizacion+'&&utilidad='+utilidad+'&&firma='+firma);
	}
	else if (idSelectTipoGlobal == 2){
		var idCotizacionExcel = $("#cotizacionesEncontradasImprimir").val();

		if(validacionCamposSelect(idCotizacionExcel, ".texto-mensaje", 0, "Seleccione un folio para generar cotización.") == false){
		    $("#msj").modal("toggle");
		    return false;
		}

		if(validacionCamposInput(utilidad, "soloNumeros", ".texto-mensaje", "Utilidad solo permite numeros.", 0, "La utilidad es obligatorio.") == false){
	        $("#msj").modal("toggle");
	        return false;
	    }

		if (general == 1) {

			window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+proveedor+'&&idCotizacionExcel='+idCotizacionExcel+'&&utilidad='+utilidad+'&&firma='+firma+'&&logo='+logoEmpresa);
		}
		else if (general == 2){

			window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+proveedor+'&&idCotizacionExcel='+idCotizacionExcel+'&&utilidad='+utilidad+'&&firma='+firma+'&&nombreEmpresa='+nombreEmpresa);
		}

	    window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+proveedor+'&&idCotizacionExcel='+idCotizacionExcel+'&&utilidad='+utilidad+'&&firma='+firma);

	}
	else if (idSelectTipoGlobal == 3){
		var idCotizacionExcelUnica = $("#cotizacionesEncontradasImprimir").val();

		if(validacionCamposSelect(idCotizacionExcelUnica, ".texto-mensaje", 0, "Seleccione un folio para generar cotización.") == false){
		    $("#msj").modal("toggle");
		    return false;
		}

		if(validacionCamposInput(utilidad, "soloNumeros", ".texto-mensaje", "Utilidad solo permite numeros.", 0, "La utilidad es obligatorio.") == false){
	        $("#msj").modal("toggle");
	        return false;
	    }

		if (general == 1) {

			window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+proveedor+'&&idCotizacionExcelUnica='+idCotizacionExcelUnica+'&&utilidad='+utilidad+'&&firma='+firma+'&&logo='+logoEmpresa);
		}
		else if (general == 2){

			window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+proveedor+'&&idCotizacionExcelUnica='+idCotizacionExcelUnica+'&&utilidad='+utilidad+'&&firma='+firma+'&&nombreEmpresa='+nombreEmpresa);
		}

	    window.open('../pdf_cotizaciones/cotizaciones.php?proveedor='+proveedor+'&&idCotizacionExcelUnica='+idCotizacionExcelUnica+'&&utilidad='+utilidad+'&&firma='+firma);
	}

}

//====================================================================================================

//EVENTO READY========================================================================================
$(document).ready(function(){
	idSelectTipoGlobal = "";
	nombreEmpresaGlobal = "";
	idEmpresaGlobal = "";
	nombreClienteGlobal = "";
	idClienteGlobal = "";
});
//====================================================================================================
</script>
