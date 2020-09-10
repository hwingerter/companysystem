<?php

	$ambiente = "1";

	if ($ambiente == "1") 
	{
		define ("site", "http://localhost/belezasoft_site/");

		define ("sistema", "http://localhost/companysystem/");

		define ("flgEnviaEmail", "0");
	}
	 else 
	{
		define ("site", "https://companysystem.net.br/");

		define ("sistema", "https://www.companysystem.net.br/sistema/");

		define ("flgEnviaEmail", "1");
	}


	date_default_timezone_set('America/Sao_Paulo');

?>