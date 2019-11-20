
function MudarTipoComissao(valor){

	if (valor == "1"){
		document.getElementById("caixa_percentual").style.display = "block";
		document.getElementById("caixa_fixo").style.display = "none";	

	}else if(valor== "2"){
		document.getElementById("caixa_percentual").style.display = "none";
		document.getElementById("caixa_fixo").style.display = "block";	

	}

}

function RestaurarComissao(cod_profissional, cod_servico)
{
	location.href="personalizar_comissao.php?acao=restaurar_comissao&cod_profissional=" + cod_profissional + "&cod_servico=" + cod_servico;
}




/*
function CaixaAberto()
{
	var forma  		= document.getElementById("caixa_aberto").value;
	var cod_caixa	= document.getElementById("cod_caixa").value;
	var pagina;

	switch(forma)
	{
		case "1":
			pagina = "sangria.php";
			break;
		case "2":
			pagina = "reforco.php";
			break;
		case "3":
			pagina = "emitir_vale.php";
			break;
		case "4": case "5":
			pagina = "caixa_cliente.php";
			break;
		case "6":
			pagina = "comanda_pagamento_fiado.php";
		case "7":
			pagina = "informacoes_caixa.php";
			break;
		case "8":
			pagina = "caixa_gaveta_caixa.php?acao=fechar_caixa&cod_caixa=" + cod_caixa;
			break;
	}

	location.href = pagina;

}


function CaixaFechado()
{
	var forma  	= document.getElementById("caixa_fechado").value;	
	var pagina;

	switch(forma)
	{
		case "1":
			pagina = "caixa_abrir_novo_caixa.php";
			break;
		case "2":
			pagina = "caixa_gaveta_caixa.php?acao=abrir_ultimo_caixa";
			break;
		case "3":
			pagina = "caixa_reabrir_caixa_antigo.php";
			break;
		case "4":
			pagina = "caixa_cadastrar_caixa_antigo.php";
			break;
		case "5":
			pagina = "visualizar_caixas_fechados.php";
			break;

	}

	location.href = pagina;

}


function CancelarComanda(cod_comanda){
	location.href = "comanda.php?cancelar_comanda=" + cod_comanda;
}

function CarrregarValorServico(cod_empresa, cod_servico){

	$.ajax({
	    type: "GET",
	    url: "ajaxRetornaValorServico.php?cod_empresa="+ cod_empresa +"&cod_servico="+cod_servico+"&"+new Date().getTime(),
	    beforeSend: function () {
	        console.log("carregando...")
	    },
	    success: function (data){
		
			$("#IdValor").html("");

	        $("#IdValor").html(data);

	    },
	    error: function (xhr, ajaxOptions, thrownError) {
	        console.log("error: xhr: " + xhr.status + " - thrownError: " + thrownError)
	    },
	});


}

function Ultimos10(cod_empresa){

	$.ajax({
	    type: "GET",
	    url: "ajaxUltimos10Caixas.php?cod_empresa="+ cod_empresa +"&"+new Date().getTime(),
	    beforeSend: function () {
	        //console.log("carregando...")
	    },
	    success: function (data){
		
			$("#divAjax").html("");

	        $("#divAjax").html(data);

	    },
	    error: function (xhr, ajaxOptions, thrownError) {
	        console.log("error: xhr: " + xhr.status + " - thrownError: " + thrownError)
	    },
	});


}



function CarrregarValorProduto(cod_empresa, cod_produto){

	$.ajax({
	    type: "GET",
	    url: "ajaxRetornaValorProduto.php?cod_empresa="+ cod_empresa +"&cod_produto="+cod_produto+"&"+new Date().getTime(),
	    beforeSend: function () {
	        console.log("carregando...")
	    },
	    success: function (data){
		
			$("#IdValor").html("");

	        $("#IdValor").html(data);

	    },
	    error: function (xhr, ajaxOptions, thrownError) {
	        console.log("error: xhr: " + xhr.status + " - thrownError: " + thrownError)
	    },
	});


}

function AbreTipoItem(TipoItem){

	document.getElementById("CaixaServico").style.display = "none";
	document.getElementById("CaixaProduto").style.display = "none";

	if (TipoItem == "1"){
		document.getElementById("CaixaServico").style.display = "block";
		document.getElementById("CaixaProduto").style.display = "none";		
	}else{
		document.getElementById("CaixaServico").style.display = "none";
		document.getElementById("CaixaProduto").style.display = "block";		
	}

}


function SelecionaDescAcres(TipoItem){

	document.getElementById("caixa_desconto").style.display = "none";
	document.getElementById("caixa_acrescimo").style.display = "none";

	if (TipoItem == "1"){
		document.getElementById("caixa_desconto").style.display = "block";
		document.getElementById("caixa_acrescimo").style.display = "none";		
	}else{
		document.getElementById("caixa_desconto").style.display = "none";
		document.getElementById("caixa_acrescimo").style.display = "block";		
	}

}

function RemoverDescontoEAcrescimo(id, cod_comanda, cod_cliente){

	location.href = "comanda_item_info.php?acao=alterar&id="+ id +"&pergunta_remover=" + id + "&cod_comanda=" +cod_comanda + "&cod_cliente=" + cod_cliente;

	/*
	document.frm.flg_desconto_acrescimo[0].checked = false;
	document.frm.flg_desconto_acrescimo[1].checked = false;

	document.frm.percentual_desconto.value = "";
	document.frm.valor_desconto.value = "";
	document.frm.valor_ascrescimo.value = "";

}

function Calcular()
{

	var total 		= document.getElementById("total").value;
	var dinheiro 	= document.getElementById("dinheiro").value;
	
	document.getElementById("soma").innerHTML = dinheiro;

	var troco;

	troco = parseFloat(dinheiro) - parseFloat(total);

	document.getElementById("troco").value = troco;

}

function AbrirPagamentoCartaoDebito(numero){

	for(i=1; i<=12; i++){

		var item = "cartao_debito_" + i;

		document.getElementById(item).style.display = "none";

	}

	for(i=1; i<=numero; i++){

		var item = "cartao_debito_" + i;

		document.getElementById(item).style.display = "block";

	}

}

function AbrirPagamentoCartaoCredito(numero){

	for(i=1; i<=12; i++){

		var item = "cartao_credito_" + i;

		document.getElementById(item).style.display = "none";

	}

	for(i=1; i<=numero; i++){

		var item = "cartao_credito_" + i;

		document.getElementById(item).style.display = "block";

	}

}

function AbrirPagamentoCheque(numero){

	for(i=1; i<=12; i++){

		var item = "cheque_" + i;

		document.getElementById(item).style.display = "none";

	}

	for(i=1; i<=numero; i++){

		var item = "cheque_" + i;

		document.getElementById(item).style.display = "block";

	}

}



function Troco(dinheiro){

	comanda = parseFloat(document.getElementById("comanda").value);

	dinheiro = parseFloat(dinheiro.value);

	troco = document.getElementById("valor_troco");

	var valor_troco = comanda - dinheiro;

	if (dinheiro > comanda){
		console.log("1 comanda = " + comanda + " dinheiro: " + dinheiro + " troco: " + Math.abs(valor_troco));
		troco.value = Math.abs(valor_troco);

	}else{
		console.log("2 comanda = " + comanda + " dinheiro: " + dinheiro + " troco: " + valor_troco);
		troco.value = valor_troco;
	}
	

}

function formatReal( int )
{
        var tmp = int+'';
        tmp = tmp.replace(/([0-9]{2})$/g, ",$1");
        if( tmp.length > 6 )
                tmp = tmp.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");

        return tmp;
}


function NovoCliente(){
	location.href = "cliente_info.php?retorno=nova_comanda";
}

function NovoServico(){

	var cod_comanda = document.getElementById("cod_comanda").value;
	var cod_cliente = document.getElementById("cod_cliente").value;

	location.href = "servico_info.php?retorno=novo_item_comanda&cod_comanda="+ cod_comanda +"&cod_cliente=" + cod_cliente;
}

function NovoProduto(){

	var cod_comanda = document.getElementById("cod_comanda").value;
	var cod_cliente = document.getElementById("cod_cliente").value;

	location.href = "produto_info.php?retorno=novo_item_comanda&cod_comanda="+ cod_comanda +"&cod_cliente=" + cod_cliente;
}

function SelecionaClienteDivida(){
	
	var cod_cliente = document.getElementById("cod_cliente").value;
	location.href = "lista_dividas.php?cod_cliente=" + cod_cliente;
}

function SelecionarTodasDividas(){

	var form = document.getElementById("frm");

	for(i=0; i<form.length; i++){

		if(form[i].id=="cod_comanda"){

			form[i].checked = true;

		}

	}
}

function NenhumaDividas(){

	var form = document.getElementById("frm");

	for(i=0; i<form.length; i++){

		if(form[i].id=="cod_comanda"){

			form[i].checked = false;

		}

	}

}

function PagarDividas(){

	var form = document.getElementById("frm");
	var cod_cliente = document.getElementById("cod_cliente").value;
	var voltar = document.getElementById("voltar").value;
	var dividas = "";

	for(i=0; i<form.length; i++){

		if(form[i].id=="cod_comanda"){

			if(form[i].checked){

				if(dividas == ""){
					dividas = form[i].value;
				}else{
					dividas = dividas+ "," +form[i].value;
				}

			}

		}

	}

	location.href = "../comanda/comanda_pagamentos.php?flg_divida=1&cod_comanda="+dividas+"&cod_cliente=" + cod_cliente + "&voltar=" + voltar;
}


/*

function SelecionarTodasDividas(){

	var form = document.getElementById("frm");
	var dividas = "";

	for(i=0; i<form.length; i++){

		if(form[i].id=="cod_comanda"){

			if(form[i].checked){

				if(dividas == ""){
					dividas = form[i].value;
				}else{
					dividas = dividas+ "," +form[i].value;
				}

			}

		}

	}
}
*/