
function MostrarCaixaDataVencimento(TipoCheque){

	var caixa = "caixa_dt_vencimento";

	if(TipoCheque == "4")
	{
		document.getElementById(caixa).style.display = "none";
	}
	else if(TipoCheque == "5")
	{
		document.getElementById(caixa).style.display = "block";
	}

}