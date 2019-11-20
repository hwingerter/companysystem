var requip;
function loadXMLDoc(url){
	requip = null;
	if (window.XMLHttpRequest) {
		requip= new XMLHttpRequest();
		requip.onreadystatechange = ProcessEquip; // o req.  foi alterado para requip
		requip.open("POST", url, true); // o req.  foi alterado para requip
		requip.send(null); // o req.  foi alterado para requip

	} else if (window.ActiveXObject) {
		try {
			requip= new ActiveXObject("Msxml2.XMLHTTP.4.0");
		} catch(e) {
			try {
				requip= new ActiveXObject("Msxml2.XMLHTTP.3.0");
			} catch(e) {
				try {
					requip= new ActiveXObject("Msxml2.XMLHTTP");
				} catch(e) {
					try {
						requip= new ActiveXObject("Microsoft.XMLHTTP");
					} catch(e) {
						requip= false;
					}
				}
			}
		}
		if (requip) {
			requip.onreadystatechange = ProcessEquip;
			requip.open("POST", url, true);
			requip.send();
		}
	}
}


function ProcessEquip(){
	if (requip.readyState == 4) {
		if (requip.status == 200) {
			document.getElementById("city").innerHTML = requip.responseText;
		} else {
			alert("Houve um problema ao obter os dados:\n" + requip.statusText);
			//alert("Selecione uma UF!");
		}
	}
}
function atualizaCidade(valor){
	loadXMLDoc("../include/cidadeListaCombo.php?id="+valor);
}

function EditaCidade(estado,cidade){
	loadXMLDoc("../include/cidadeListaCombo.php?id="+estado+"&cidade="+cidade);
}