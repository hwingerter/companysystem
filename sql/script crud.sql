/*SELECT		concat('$',column_name,' = $_POST["',column_name,'"]') as Campos*/
SELECT		column_name
FROM 		information_schema.columns 
WHERE 		table_name = 'estoque';

/*BANCO PARA PAGINA*/
SELECT		concat('$',column_name,' = $rs["',column_name,'"];') as Campos
FROM 		information_schema.columns 
WHERE 		table_name = 'empresas_preferencias';


/*PAGINA PARA BANCO*/
SELECT		concat('if (isset($_REQUEST["',column_name,'"])) { $',column_name,' = $_REQUEST["',column_name,'"]; } else { $',column_name,' = "NULL"; }') as Campos
FROM 		information_schema.columns 
WHERE 		table_name = 'empresas_preferencias';



SELECT		concat(","
					, column_name
                    ," = "
                    ,"'"".$"
                    ,column_name
                    ,".""'"
				) as Campos
FROM 		information_schema.columns 
WHERE 		table_name = 'empresas_preferencias';


