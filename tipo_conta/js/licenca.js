
function SelecionaTodos(area, valor)
{

	var form = document.frm;
	var objArea = "area_" + area;

	if (valor == true)
	{
		for(i=0; i < form.length; i++)
		{
			if(form[i].id == objArea)
			{
				form[i].checked = true;
			}
		}
	}
	else
	{
		for(i=0; i < form.length; i++)
		{
			if(form[i].id == objArea)
			{
				form[i].checked = false;
			}
		}
	}

}

