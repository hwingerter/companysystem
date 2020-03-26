



//Função Fade Out em alert ou qualquer outra div em 4 segundos
	function AutoCloseAlert(id_alert, reload)
	{
		window.setTimeout(function() {
		    $(id_alert).fadeOut(500, 0).slideUp(500, function(){
		       // $(this).remove();
			   if(reload === 1)
			   {
					window.location.reload(1);
			   }
		    });
		}, 2000);//em 4 segundos
		

	}

	//Chama-la: AutoCloseAlert("#loading_submit_login");

//Função Fade Out em alert ou qualquer outra div em 4 segundos



//Função Fade In em alert ou qualquer outra div em 3 segundos
	function AutoOpenAlert(id_alert)
	{
        $(id_alert).fadeIn();
        $(id_alert).fadeIn("slow");
        $(id_alert).fadeIn(3000);
	}

	//Chama-la: AutoOpenAlert("#loading_submit_login");

//Função Fade In em alert ou qualquer outra div em 4 segundos





 
 
	///Notification
	function notifica(titulo, mensagem, tipo)
	{
		if(tipo=='success')
		{
			toastr.success(mensagem,titulo);
		}
		else if(tipo=='info')
		{
			toastr.info(mensagem,titulo);
		}
		else if(tipo=='warning')
		{
			toastr.warning(mensagem,titulo);
		}
		else if(tipo=='error')
		{
			toastr.error(mensagem,titulo);
		}
		toastr.options = {
		  "closeButton": true,
		  "debug": false,
		  "newestOnTop": true,
		  "progressBar": true,
		  "positionClass": "toast-top-right",
		  "preventDuplicates": false,
		  "onclick": null,
		  "showDuration": "300",
		  "hideDuration": "1000",
		  "timeOut": "3000",
		  "extendedTimeOut": "1000",
		  "showEasing": "swing",
		  "hideEasing": "linear",
		  "showMethod": "fadeIn",
		  "hideMethod": "fadeOut"
		}
	}
	///Notification
 
 
 
  
/* Máscaras TELEFONE */
	function mascara(o,f){
		v_obj=o
		v_fun=f
		setTimeout("execmascara()",1)
	}
	function execmascara(){
		v_obj.value=v_fun(v_obj.value)
	}
	function mtel(v){
		v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
		v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
		v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
		return v;
	}
		function id( el ){
			return document.getElementById( el );
		}

		
	function mdata(v){
		v=v.replace(/\D/g,"");                    //Remove tudo o que não é dígito
		v=v.replace(/(\d{2})(\d)/,"$1/$2");
		v=v.replace(/(\d{2})(\d)/,"$1/$2");

		v=v.replace(/(\d{2})(\d{2})$/,"$1$2");
		return v;
	}
/* Máscaras TELEFONE */

 