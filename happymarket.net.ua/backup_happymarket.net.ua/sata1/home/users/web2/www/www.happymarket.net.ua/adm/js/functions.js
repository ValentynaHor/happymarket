function generation_alias(val, res)
{
	if(val != "")
	{
		val = val.toLowerCase();
		val=val.replace(/а/g,"a");
		val=val.replace(/б/g,"b");
		val=val.replace(/в/g,"v");
		val=val.replace(/г/g,"g");
		val=val.replace(/д/g,"d");
		val=val.replace(/е/g,"e");
		val=val.replace(/ё/g,"yo");
		val=val.replace(/ж/g,"zh");
		val=val.replace(/з/g,"z");
		val=val.replace(/и/g,"i");
		val=val.replace(/й/g,"j");
		val=val.replace(/к/g,"k");
		val=val.replace(/л/g,"l");
		val=val.replace(/м/g,"m");
		val=val.replace(/н/g,"n");
		val=val.replace(/о/g,"o");
		val=val.replace(/п/g,"p");
		val=val.replace(/р/g,"r");
		val=val.replace(/с/g,"s");
		val=val.replace(/т/g,"t");
		val=val.replace(/у/g,"u");
		val=val.replace(/ф/g,"f");
		val=val.replace(/х/g,"h");
		val=val.replace(/ц/g,"c");
		val=val.replace(/ч/g,"ch");
		val=val.replace(/ш/g,"sh");
		val=val.replace(/щ/g,"ssh");
		val=val.replace(/ы/g,"y");
		val=val.replace(/э/g,"eh");
		val=val.replace(/ю/g,"yu");
		val=val.replace(/я/g,"ya");

		val=val.replace(/і/g,"i");
		val=val.replace(/ї/g,"yi");
		val=val.replace(/є/g,"e");

		//alert(val);
		val = val.replace(/[\,\.\:\;\!\_\=\@\%\^\&]/g, " ");
		val = val.replace(/[^a-z0-9\-\s]/g, "");
		val = val.replace(/^\s+/, "");
		val = val.replace(/\s+$/, "");
		val = val.replace(/\s\s+/g, " ");
		val = val.replace(/\s* /g,"-");
		//alert(val);

		var i=prompt('Внимание! Псевдоним будет создан в соответствии с названием.',val);
		if(i != '' && i != null && i != 'undefined')
		{
			document.getElementById(res).value = i;
			//registration.article_articleAlias.value = i;
		}
		else
		{
			return false;
		}
	}
	else
	{
		alert('Поле "Название" не заполнено.');
		return false;
	}
}
/*
	Copyright 2009 Finesse.com.ua All rights reserved.
*/