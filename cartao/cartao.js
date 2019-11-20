
function SelecioneTipoOperacao(tipo_operacao){

	if(tipo_operacao == 1){

		document.getElementById("QuadroDebito").style.display = "block";
		document.getElementById("QuadroCredito").style.display = "block";
		document.getElementById("QuadroDescontar").style.display = "block";

	}else if(tipo_operacao == 2){

		document.getElementById("QuadroDebito").style.display = "none";
		document.getElementById("QuadroCredito").style.display = "block";
		document.getElementById("QuadroDescontar").style.display = "block";

	}else if(tipo_operacao == 3){

		document.getElementById("QuadroDebito").style.display = "block";
		document.getElementById("QuadroCredito").style.display = "none";
		document.getElementById("QuadroDescontar").style.display = "block";
	
	}else{
		document.getElementById("QuadroDebito").style.display = "block";
		document.getElementById("QuadroCredito").style.display = "block";
		document.getElementById("QuadroDescontar").style.display = "block";
	}

}