function AbrirAgenda()
{
	location.href = "agenda.php?acao=abrir_agenda";
}

function MostrarAgenda(data)
{
	var data = document.getElementById("datepicker").value;
	var cod_profissional = document.getElementById("cod_profissional").value;

	//location.href = "agenda_profissional.php?data=" + data + "&cod_profissional=" + cod_profissional;

	$.ajax({
	    type: "GET",
	    url: "ajaxCarregaAgenda.php?data="+ data +"&cod_profissional="+ cod_profissional +"&"+new Date().getTime(),
	    beforeSend: function () {
	        console.log("carregando...")
	    },
	    success: function (data){
		
	        $("#Quadro").html(data);

	    },
	    error: function (xhr, ajaxOptions, thrownError) {
	        console.log("error: xhr: " + xhr.status + " - thrownError: " + thrownError)
	    },
	});

}

function Reservar(data, horario, cod_profissional)
{
	location.href = "reservar.php?data="+ data +"&cod_profissional=" + cod_profissional + "&hora=" + horario;
}

function EfeturarReserva()
{
	document.frm.submit();
}

function CancelarReserva(data, hora, cod_profissional, cod_cliente)
{
	location.href = "reservar.php?acao=cancelar_reserva&data="+ data +"&hora="+hora+"&cod_profissional=" + cod_profissional + "&cod_cliente=" + cod_cliente;	
}

function ConsultarAgenda(data, hora, cod_profissional, cod_cliente)
{
	var cod_cliente = document.getElementById("cod_cliente").value;
	location.href = "lista_reservas.php?cod_cliente=" + cod_cliente;	
}

function ExibirAgendaReservacliente(data_agenda, cod_profissional, cod_cliente)
{

	$.ajax({
	    type: "GET",
	    url: "ajaxCarregaAgenda.php?data=" + data_agenda + "&cod_profissional=" + cod_profissional + "&cod_cliente=" + cod_cliente + "&t="+new Date().getTime(),
	    beforeSend: function () {
	        console.log("carregando...")
	    },
	    success: function (data){
		
	        $("#Quadro").html(data);

	    },
	    error: function (xhr, ajaxOptions, thrownError) {
	        console.log("error: xhr: " + xhr.status + " - thrownError: " + thrownError)
	    },
	});

}