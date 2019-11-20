
function CalcularCustoTotal()
{
	var quantidade = parseInt(document.getElementById("quantidade").value);

	var custo_medio = document.getElementById("custo_medio").value.replace(",", ".");

	var valor_total = quantidade * custo_medio;

	 document.getElementById("custo_total").value = parseFloat(valor_total);

}

function EstoqueAtual(cod_produto)
{

    $.ajax({
        type: "GET",
        url: "ajaxUltimoSaldoEstoque.php?cod_produto="+ cod_produto +"&"+new Date().getTime(),
        beforeSend: function () {
            console.log("carregando...")
        },
        success: function (data){
        
            if(data != "")
            {
                data = data.split("|||");
                $("#quadro_estoque_atual").html("<input type='text' class='form-control' name='estoque_atual' id='estoque_atual' readonly value='"+data[0]+"' >");
                $("#devolucao_venda").val(data[1]);
                
            }

            

        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log("error: xhr: " + xhr.status + " - thrownError: " + thrownError)
        },
    });

}

function EstoqueAposMovimentacao(quantidade)
{

    var produto = document.getElementById("cod_produto").value;

    $.ajax({
        type: "GET",
        url: "ajaxAposMovimentacao.php?cod_produto="+ produto +"&quantidade="+ quantidade +"&"+new Date().getTime(),
        beforeSend: function () {
            console.log("carregando...")
        },
        success: function (data){
        
            if(data != "")
            {
                $("#quadro_estoque_apos_compra").html("<input type='text' class='form-control' name='estoque_atual' id='estoque_atual' readonly value='"+data+"' >");
            }

        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log("error: xhr: " + xhr.status + " - thrownError: " + thrownError)
        },
    });

}

function  LancarCompra()
{

    if(document.frm.gera_conta_pagamento[0].checked == true)
    {
        document.frm.action = "../conta_info.php";
        document.frm.submit();

    }
    else if (document.frm.gera_conta_pagamento[1].checked == true)
    {
        document.frm.action = "lancar_compra.php";
        document.frm.submit();
    }

}

function InfoGeraConta(opcao)
{
    if(opcao == "2")
    {
        document.getElementById("BoxInfoGerarConta").style.display = "block";
    }
    else
    {
        document.getElementById("BoxInfoGerarConta").style.display = "none";
    }
}

function SelecionarTipoMovimentacao(tipo)
{

    switch(tipo)
    {
        case "1":
            document.frm.action = "../conta_info.php";
            document.getElementById("BoxGerarConta").style.display = "block";
            document.getElementById("BoxCliente").style.display = "none";
            document.getElementById("BoxFornecedor").style.display = "block";
            document.getElementById("BoxNotaFiscal").style.display = "block";
            document.getElementById("BoxCustoMedioCompra").style.display = "block";
            document.getElementById("BoxCustoTotal").style.display = "block";
            break;

        case "2":
            document.getElementById("BoxGerarConta").style.display = "block";
            document.getElementById("BoxCliente").style.display = "none";
            document.getElementById("BoxFornecedor").style.display = "block";
            document.getElementById("BoxNotaFiscal").style.display = "block";
            document.getElementById("custo_medio").value = "0.00";
            document.getElementById("BoxCustoMedioCompra").style.display = "block";
            document.getElementById("BoxCustoTotal").style.display = "block";
            break;

        case "3":
            document.getElementById("BoxGerarConta").style.display = "none";
            document.getElementById("BoxCliente").style.display = "block";
            document.getElementById("BoxFornecedor").style.display = "none";
            document.getElementById("BoxNotaFiscal").style.display = "none";
            document.getElementById("BoxInfoGerarConta").style.display = "none";
            document.getElementById("custo_medio").value = document.getElementById("devolucao_venda").value;
            document.frm.gera_conta_pagamento[1].checked = true;
            document.frm.action = "lancar_compra.php";
            break;

        case "4":
            document.getElementById("BoxGerarConta").style.display = "none";
            document.getElementById("BoxCliente").style.display = "none";
            document.getElementById("BoxFornecedor").style.display = "block";
            document.getElementById("BoxNotaFiscal").style.display = "block";
            document.getElementById("BoxInfoGerarConta").style.display = "none";
            document.getElementById("custo_medio").value = document.getElementById("devolucao_venda").value;
            document.frm.gera_conta_pagamento[1].checked = true;
            document.frm.action = "lancar_compra.php";
            break;

        case "5":
            document.getElementById("BoxGerarConta").style.display = "none";
            document.getElementById("BoxCliente").style.display = "none";
            document.getElementById("BoxFornecedor").style.display = "none";
            document.getElementById("BoxNotaFiscal").style.display = "none";
            document.getElementById("BoxCustoMedioCompra").style.display = "none";
            document.getElementById("BoxCustoTotal").style.display = "none";
            document.getElementById("BoxInfoGerarConta").style.display = "none";
            document.frm.gera_conta_pagamento[1].checked = true;
            document.frm.action = "lancar_compra.php";
            break;

        case "6":
        case "7":
            document.getElementById("BoxGerarConta").style.display = "none";
            document.getElementById("BoxCliente").style.display = "block";
            document.getElementById("BoxFornecedor").style.display = "none";
            document.getElementById("BoxNotaFiscal").style.display = "none";
            document.getElementById("BoxCustoMedioCompra").style.display = "block";
            document.getElementById("BoxCustoTotal").style.display = "none";
            document.getElementById("BoxInfoGerarConta").style.display = "none";
            document.getElementById("custo_medio").value = document.getElementById("devolucao_venda").value;
            document.frm.gera_conta_pagamento[1].checked = true;
            document.frm.action = "lancar_compra.php";
            break;

    }    

}