
function CancelarComanda(cod_comanda){
	location.href = "comanda.php?cancelar_comanda=" + cod_comanda;
}

function CalcularSubTotal(pValorUnitario, pQuantidade)
{

	console.log($("#ValorUnitario"));

	var valor_unitario 	= $("#ValorUnitario").val();
	var quantidade 		= $("#quantidade").val();

	console.log(valor_unitario + " - " + quantidade);

	$("#CarregandoSubTotal").hide();
	$("#SubTotal").hide();

	$.ajax({
	    type: "GET",
	    url: "ajaxCacularValorComanda.php?valor_unitario="+ valor_unitario +"&quantidade="+ quantidade +"&"+new Date().getTime(),
	    beforeSend: function () {
	        $("#CarregandoSubTotal").show();
	    },
	    success: function (data){
		
			$("#SubTotal").html(data);

			setInterval(function(){ 
				
				$("#CarregandoSubTotal").hide();			
				$("#SubTotal").show();
		
			}, 2000);	

	    },
	    error: function (xhr, ajaxOptions, thrownError) {
	        console.log("error: xhr: " + xhr.status + " - thrownError: " + thrownError);
	    },
	});
	
}

function CarregarValorServico(cod_empresa, cod_servico){

	$("#lblCarregandoValorUnitario").hide();
	$("#lblValorUnitario").hide();

	$.ajax({
	    type: "GET",
	    url: "ajaxRetornaValorServico.php?cod_empresa="+ cod_empresa +"&cod_servico="+cod_servico+"&"+new Date().getTime(),
	    beforeSend: function () {
	        $("#lblCarregandoValorUnitario").show();
	    },
	    success: function (data){
		
			$("#lblCarregandoValorUnitario").hide();

			$("#lblValorUnitario").html(data);
			$("#lblValorUnitario").show();

	    },
	    error: function (xhr, ajaxOptions, thrownError) {
	        console.log("error: xhr: " + xhr.status + " - thrownError: " + thrownError);
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
	*/
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

function SelecionarFormaPagamento()
{
	var forma  	= document.getElementById("cod_forma_pagamento").value;	
	var comanda = document.getElementById("cod_comanda").value;
	var cliente = document.getElementById("cod_cliente").value;
	var flg_divida = document.getElementById("flg_divida").value;
	var voltar = document.getElementById("voltar").value;

	//var voltar = "comanda_forma_pagamento.php?flg_divida="+flg_divida+"&cod_comanda="+comanda+"&cod_cliente="+cliente+"&voltar=" + document.getElementById("voltar").value;

	var pagina = "";

	switch(forma)
	{
		case "1":
			pagina = "comanda_pagamento_dinheiro.php";
			break;
		case "2":
			pagina = "comanda_pagamento_cartao_debito.php";
			break;
		case "3":
			pagina = "comanda_pagamento_cartao_credito.php";
			break;
		case "4": case "5":
			pagina = "comanda_pagamento_cheque.php";
			break;
		case "6":
			pagina = "comanda_pagamento_fiado.php";
			break;
		case "7":
			pagina = "comanda_pagamento_gorjeta.php";
			break;
		case "8":
			pagina = "comanda_pagamento_creditos.php";
			break;
	}

	pagina = pagina + "?cod_comanda=" + comanda + "&cod_cliente=" + cliente + "&cod_forma_pagamento=" + forma + "&flg_divida=" + flg_divida + "&voltar="+voltar;

	location.href = pagina;

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
	location.href = "../cliente/cliente_info.php?retorno=nova_comanda";
}

function NovoServico(){

	var cod_comanda = document.getElementById("cod_comanda").value;
	var cod_cliente = document.getElementById("cod_cliente").value;

	location.href = "../servico_info.php?retorno=novo_item_comanda&cod_comanda="+ cod_comanda +"&cod_cliente=" + cod_cliente;
}

function NovoProduto(){

	var cod_comanda = document.getElementById("cod_comanda").value;
	var cod_cliente = document.getElementById("cod_cliente").value;

	location.href = "../produto_info.php?retorno=novo_item_comanda&cod_comanda="+ cod_comanda +"&cod_cliente=" + cod_cliente;
}