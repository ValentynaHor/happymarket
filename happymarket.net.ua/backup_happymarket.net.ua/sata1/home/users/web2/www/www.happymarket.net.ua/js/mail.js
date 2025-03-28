	function SendMail(num,name,ind)
	{
		sep = '@';
		if(ind == 1) dom = 'deshevshe.net.ua'
		else if (ind == 2) dom = 'deshevshe.lviv.ua'
		else if (ind == 3) dom = 'ukr.net'
		document.getElementById('mail_'+num).href = 'mailto:'+name+sep+dom;
	}
	function mail_encoding(num,text)
	{
		i = 0;
		res = '';
		while(text.length > i)
		{
			if(i%2 == 0)
			{
				res = res+text.charAt(i);
			}
			i++;
		}
		document.getElementById('mail_'+num).href = 'mailto:'+res;
	}