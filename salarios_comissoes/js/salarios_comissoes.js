
function SelecionarDataPagamento()
{
	var dt_pagamento = document.getElementById("dt_inicial").value;
	location.href = "realizar_pagamento.php?cod_profissional=20&data=23/02/2019";
}

function PagarSelecionados()
{
	var form 			= document.frmListaComissoes;
	var selecionados 	= "";
	var data_busca 		= document.getElementById("data_busca").value;
	var data_pagamento 	= document.getElementById("data_pagamento").value;

	for(i=0; i<form.length;i++)
	{
		if (form[i].id == "profissional" && form[i].checked)
		{
			if(selecionados == "")
			{
				selecionados = form[i].value;
			}
			else
			{
				selecionados = selecionados + "," + form[i].value;	
			}
		}
	}

	//console.log(selecionados) + "<br>";	

	location.href = "realizar_pagamento.php?lista_profissional="+selecionados+"&data_busca="+data_busca+"&data_pagamento="+data_pagamento;
}

function CarregaDataCaixaPagamentoComissao(div, parcela, cod_empresa, flgValor)
{

	var Caixa = "#CaixaDia";
	var divData = "#IdCaixaDia";
	cod_caixa = "";

	if (flgValor == "S") 
	{
		$.ajax({
			type: "GET",
			url: "../ajaxCaixaDias.php?cod_empresa="+ cod_empresa +"&parcela="+parcela+"&cod_caixa="+cod_caixa+"&"+new Date().getTime(),
			beforeSend: function () {
				console.log("carregando...")
			},
			success: function (data){
						
				$(Caixa).show();
				$(divData).html(data);

	
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log("error: xhr: " + xhr.status + " - thrownError: " + thrownError)
			},
		});

	}
	else
	{
		$(Caixa).hide();
	}

}

function DesfazerUltimoPagamento()
{
	location.href = "realizar_pagamento.php?acao=desfazer_ultimo_pagamento";
}
