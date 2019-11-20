function Parcela(numero){

	for(i=1; i<=12; i++){

		var item = "Parcela_" + i;

		document.getElementById(item).style.display = "none";

	}

	for(i=1; i<=numero; i++){

		var item = "Parcela_" + i;

		document.getElementById(item).style.display = "block";

	}

}

function ContaPaga(parcela, foiPaga){

	var elemento = "UsouDaGaveta_" + parcela;
	var elemento2 = "quitacao_" + parcela;
	var elemento3 = "dt_quitacao_" + parcela;

	if(foiPaga == "S"){
		document.getElementById(elemento).style.display = "block";
		document.getElementById(elemento2).style.display = "block";
	}else{
		document.getElementById(elemento).style.display = "none";
		document.getElementById(elemento2).style.display = "none";

		document.getElementById(elemento3).value = "";
	}

}


function CarregaDataCaixa(div, parcela, cod_empresa, valor, cod_caixa){

	var divData = "#IdCaixaDia_" + parcela;
	var Caixa = "#CaixaDia_" + parcela;

	if (valor == "S"){

		$.ajax({
		    type: "GET",
		    url: "ajaxCaixaDias.php?cod_empresa="+ cod_empresa +"&parcela="+parcela+"&cod_caixa="+cod_caixa+"&"+new Date().getTime(),
		    beforeSend: function () {
		        console.log("carregando...")
		    },
		    success: function (data){

		        $(divData).html(data);
		        $(Caixa).show();

		    },
		    error: function (xhr, ajaxOptions, thrownError) {
		        console.log("error: xhr: " + xhr.status + " - thrownError: " + thrownError)
		    },
		});

	}else{
		$(Caixa).hide();
	}



}

/*
function Parcela(numero){

	texto = "";
	texto = "<div class='form-group'>";
	texto = "		<label class='col-md-2 control-label'><b>"+ numero +"a Parcela</b></label>";
	texto = "	</div>";

	texto = "	<div class='form-group'>";
	texto = "		<label class='col-sm-2 control-label'><b>Valor(R$)</b></label>";
	texto = "		<div class='col-sm-8'>";
	texto = "			<input type='text' class='form-control' value='<?php echo $descricao;?>' name='descricao' maxlength='200'>";
	texto = "		</div>";
	texto = "	</div>";
	texto = "	<div class='form-group'>";
	texto = "		<label class='col-sm-2 control-label'><b>Vencimento</b></label>";
	texto = "		<div class='col-sm-8'>";
	texto = "			<input type='text' class='form-control' value='<?php echo $descricao;?>' name='descricao' maxlength='200'>";
	texto = "		</div>";
	texto = "	</div>";
	texto = "	<div class='form-group'>";
	texto = "		<label class='col-sm-2 control-label'><b>Parcela já paga</b></label>";
	texto = "		<div class='col-sm-8'>";
	texto = "			<input type='text' class='form-control' value='<?php echo $descricao;?>' name='descricao' maxlength='200'>";
	texto = "		</div>";
	texto = "	</div>";
	texto = "	<div class='form-group'>";
	texto = "		<label class='col-sm-2 control-label'><b>Quitar automaticamente</b></label>";
	texto = "		<div class='col-sm-8'>";
	texto = "			<input type='text' class='form-control' value='<?php echo $descricao;?>' name='descricao' maxlength='200'>";
	texto = "		</div>";
	texto = "	</div>";

	$("#Parcelas").append(texto);

}
*/