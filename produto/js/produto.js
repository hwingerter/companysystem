function MudarTipoComissao(valor){

	if (valor == "1"){
		document.getElementById("caixa_percentual").style.display = "block";
		document.getElementById("caixa_fixo").style.display = "none";	

	}else if(valor== "2"){
		document.getElementById("caixa_percentual").style.display = "none";
		document.getElementById("caixa_fixo").style.display = "block";	

	}

}
