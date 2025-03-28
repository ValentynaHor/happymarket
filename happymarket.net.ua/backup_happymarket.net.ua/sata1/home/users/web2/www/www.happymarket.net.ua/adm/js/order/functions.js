<!--
function setNameCat(cat_alias,cat_name)
{
	var elem = document.getElementById('cat_check_' + cat_alias);
	var select_category = document.getElementById('select_category');
	var s = select_category.value;
	if(elem.checked)
	{
		s = s.replace('-выбрать-', '');
		s = s + cat_name + ', ';
		selectCategories = selectCategories + cat_alias + ',';
	}
	else
	{
		s = s.replace(cat_name + ', ', '');
		selectCategories = s.replace(cat_alias + ',', '');
	}
	if(s == '' || s.length < 4) s = '-выбрать-';
	select_category.value = s;
}

function popupVisible(a)
{
	var elem = document.getElementById('windowpopup'+a);
	elem.style.visibility = 'visible';
	elem.style.display    = 'block';
}

function popupExit(a)
{
	var elem = document.getElementById('windowpopup'+a);
	elem.style.visibility = 'hidden';
	elem.style.position   = 'absolute';
	elem.style.display    = 'none';
}
function event_image(evnt,key)
{
	var img_name = document.getElementById('img_' + key).src;
	img_name = img_name.substr(img_name.length-9, 9);

	if(img_name == '/open.gif' || img_name == 'open1.gif')
	{
		if(evnt == 1) document.getElementById('img_' + key).src  = 'img/icon/open1.gif'; else  document.getElementById('img_' + key).src  = 'img/icon/open.gif';
	}
	else
	{
		if(evnt == 1) document.getElementById('img_' + key).src  = 'img/icon/close1.gif'; else  document.getElementById('img_' + key).src  = 'img/icon/close.gif';
	}
}

function setFields() {
	if(document.order1.order_userCity.options[document.order1.order_userCity.selectedIndex].value == 'other')
	{
		//visible
		document.getElementById('other').style.visibility  = 'visible';
		document.getElementById('other').style.position  = 'relative';
	}
	else
	{
		//hidden
		document.getElementById('other').style.visibility  = 'hidden';
		document.getElementById('other').style.position  = 'absolute';
	}
}
//-->