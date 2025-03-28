var Netscape, MSIE, Opera, Unknown, NN1, NN2, Ffox=false;
var Win, Mac, Other;
var NetscapeVer, MSIEVer, OperaVer, NetscapeOK, AlertMsg;
var strOperaPos;

Netscape = navigator.appName == "Netscape";
MSIE = navigator.appName == "Microsoft Internet Explorer";
Opera = navigator.userAgent.indexOf("Opera") > -1;

Unknown = !(Netscape || MSIE || Opera);

function quote(name) 
{
		var valueFull;
		if(MSIE || Opera)
		{
			var text = document.selection.createRange().text;
			//valueFull = "<QUOTE NAME=\""+name+"\">" + text + "</QUOTE>";
			valueFull = "<QUOTE от <b>\""+name+"\"</b><br> " + text + "</QUOTE>";
			document.forms["edit"].elements[source].focus();
			document.selection.createRange().text = valueFull;
		}
		else
		{
			var text = valueFull = window.getSelection();
			valueFull = "<QUOTE от <b>\""+name+"\"</b><br> " + text + "</QUOTE>";
			document.forms["edit"].elements[source].focus();
			var oldSelectionStart = document.forms["edit"].elements[source].selectionStart;
			var oldSelectionEnd = document.forms["edit"].elements[source].selectionEnd;
			var selectedText = document.forms["edit"].elements[source].value.substring(oldSelectionStart, oldSelectionEnd);
			document.forms["edit"].elements[source].value = document.forms["edit"].elements[source].value.substring(0, oldSelectionStart) + valueFull + document.forms["edit"].elements[source].value.substring(oldSelectionEnd);
			document.forms["edit"].elements[source].setSelectionRange(oldSelectionStart + valueFull.length, oldSelectionStart + valueFull.length);
		}
}
function smile(value,format,source) 
{
 if(format == "imgOn")
 {
	var val = value.substr(0,6);
	if(val == "on")
 	{
		document.getElementById('image_upload').style.visibility  = 'visible';
		document.getElementById('image_upload').style.position  = 'relative';
	}
	else if(val == "upload")
	{
		var valnum = value.substr(6,1);
		document.forms["edit"].elements[source].focus();
		var valueFull;
		if(MSIE)
		{
			var text = document.selection.createRange().text;
			valueFull = "*IMAGE"+valnum+"*";
			document.selection.createRange().text = valueFull;
		}
		else
		{
			var oldSelectionStart = document.forms["edit"].elements[source].selectionStart;
			var oldSelectionEnd = document.forms["edit"].elements[source].selectionEnd;
			var selectedText = document.forms["edit"].elements[source].value.substring(oldSelectionStart, oldSelectionEnd);
			valueFull = "*IMAGE"+valnum+"*";
			document.forms["edit"].elements[source].value = document.forms["edit"].elements[source].value.substring(0, oldSelectionStart) + valueFull + document.forms["edit"].elements[source].value.substring(oldSelectionEnd);
			document.forms["edit"].elements[source].setSelectionRange(oldSelectionStart + valueFull.length, oldSelectionStart + valueFull.length);
		}

	}
 }
 else
 {
	document.forms["edit"].elements[source].focus();
	if(format == "decoration")
	{
		var valueFull;
		if(MSIE)
		{
			var text = document.selection.createRange().text;
			valueFull = "<"+value+">" + text + "</"+value+">";
			document.selection.createRange().text = valueFull;
		}
		else
		{
			var oldSelectionStart = document.forms["edit"].elements[source].selectionStart;
			var oldSelectionEnd = document.forms["edit"].elements[source].selectionEnd;
			var selectedText = document.forms["edit"].elements[source].value.substring(oldSelectionStart, oldSelectionEnd);
			valueFull = "<"+value+">" + selectedText + "</"+value+">";
			document.forms["edit"].elements[source].value = document.forms["edit"].elements[source].value.substring(0, oldSelectionStart) + valueFull + document.forms["edit"].elements[source].value.substring(oldSelectionEnd);
			document.forms["edit"].elements[source].setSelectionRange(oldSelectionStart + valueFull.length, oldSelectionStart + valueFull.length);
		}
	}
	if(format == "align")
	{
		var valueFull;
		if(MSIE)
		{
			var text = document.selection.createRange().text;
			valueFull = "<p align='"+value+"'>" + text + "</p>";
			document.selection.createRange().text = valueFull;
		}
		else
		{
			var oldSelectionStart = document.forms["edit"].elements[source].selectionStart;
			var oldSelectionEnd = document.forms["edit"].elements[source].selectionEnd;
			var selectedText = document.forms["edit"].elements[source].value.substring(oldSelectionStart, oldSelectionEnd);
			valueFull = "<p align='"+value+"'>" + selectedText + "</p>";
			document.forms["edit"].elements[source].value = document.forms["edit"].elements[source].value.substring(0, oldSelectionStart) + valueFull + document.forms["edit"].elements[source].value.substring(oldSelectionEnd);
			document.forms["edit"].elements[source].setSelectionRange(oldSelectionStart + valueFull.length, oldSelectionStart + valueFull.length);
		}
	}
	if(format == "link")
	{
		var valueFull;
		if(MSIE)
		{
			var text = document.selection.createRange().text;
			valueFull = "<URL>" + text + "</URL>";
			document.selection.createRange().text = valueFull;
		}
		else
		{
			var oldSelectionStart = document.forms["edit"].elements[source].selectionStart;
			var oldSelectionEnd = document.forms["edit"].elements[source].selectionEnd;
			var selectedText = document.forms["edit"].elements[source].value.substring(oldSelectionStart, oldSelectionEnd);
			valueFull = "<URL>" + selectedText + "</URL>";
			document.forms["edit"].elements[source].value = document.forms["edit"].elements[source].value.substring(0, oldSelectionStart) + valueFull + document.forms["edit"].elements[source].value.substring(oldSelectionEnd);
			document.forms["edit"].elements[source].setSelectionRange(oldSelectionStart + valueFull.length, oldSelectionStart + valueFull.length);
		}
	}
	if(format == "mail")
	{
		var valueFull;
		if(MSIE)
		{
			var text = document.selection.createRange().text;
			valueFull = "<MAIL>" + text + "</MAIL>";
			document.selection.createRange().text = valueFull;
		}
		else
		{
			var oldSelectionStart = document.forms["edit"].elements[source].selectionStart;
			var oldSelectionEnd = document.forms["edit"].elements[source].selectionEnd;
			var selectedText = document.forms["edit"].elements[source].value.substring(oldSelectionStart, oldSelectionEnd);
			valueFull = "<MAIL>" + selectedText + "</MAIL>";
			document.forms["edit"].elements[source].value = document.forms["edit"].elements[source].value.substring(0, oldSelectionStart) + valueFull + document.forms["edit"].elements[source].value.substring(oldSelectionEnd);
			document.forms["edit"].elements[source].setSelectionRange(oldSelectionStart + valueFull.length, oldSelectionStart + valueFull.length);
		}
	}
	if(format == "smileys")
	{
		var valueFull;
		if(MSIE)
		{
			var text = document.selection.createRange().text;
			document.selection.createRange().text = value;
		}
		else
		{
			var oldSelectionStart = document.forms["edit"].elements[source].selectionStart;
			var oldSelectionEnd = document.forms["edit"].elements[source].selectionEnd;
			var selectedText = document.forms["edit"].elements[source].value.substring(oldSelectionStart, oldSelectionEnd);
			document.forms["edit"].elements[source].value = document.forms["edit"].elements[source].value.substring(0, oldSelectionStart) + value + document.forms["edit"].elements[source].value.substring(oldSelectionEnd);
			document.forms["edit"].elements[source].setSelectionRange(oldSelectionStart + value.length, oldSelectionStart + value.length);
		}

	}
 }
}


/* <[CDATA[ */
var pathtoicon = '../images/icon/';

var bold_out = new Image();
var bold_on = new Image();
var italic_on = new Image();
var italic_out = new Image();
var underline_on = new Image();
var underline_out = new Image();
var right_on = new Image();
var right_out = new Image();
var center_on = new Image();
var center_out = new Image();
var left_on = new Image();
var left_out = new Image();
var email_on = new Image();
var email_out = new Image();
var url_on = new Image();
var url_out = new Image();
var picture_on = new Image();
var picture_out = new Image();

bold_out.src = pathtoicon + 'bold1.gif';
bold_on.src = pathtoicon + 'bold.gif';
italic_on.src = pathtoicon + 'italic.gif';
italic_out.src = pathtoicon + 'italic1.gif';
underline_on.src = pathtoicon + 'underline.gif';
underline_out.src = pathtoicon + 'underline1.gif';
right_on.src = pathtoicon + 'right.gif';
right_out.src = pathtoicon + 'right1.gif';
center_on.src = pathtoicon + 'center.gif';
center_out.src = pathtoicon + 'center1.gif';
left_on.src = pathtoicon + 'left.gif';
left_out.src = pathtoicon + 'left1.gif';
email_on.src = pathtoicon + 'e-mail.gif';
email_out.src = pathtoicon + 'e-mail1.gif';
url_on.src = pathtoicon + 'url.gif';
url_out.src = pathtoicon + 'url1.gif';
picture_on.src = pathtoicon + 'picture.gif';
picture_out.src = pathtoicon + 'picture1.gif';

/* ]]> */
