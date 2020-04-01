<?php

	$ambiente = "1";

	if ($ambiente == "1") 
	{
		define ("site", "http://localhost/belezasoft_site/");

		define ("sistema", "http://127.0.0.1/companysystem/");
	}
	 else 
	{
		define ("host_site", "https://companysystem.net.br/");

		define ("host", "https://www.companysystem.net.br/sistema/");
	}


	date_default_timezone_set('America/Sao_Paulo');

?>