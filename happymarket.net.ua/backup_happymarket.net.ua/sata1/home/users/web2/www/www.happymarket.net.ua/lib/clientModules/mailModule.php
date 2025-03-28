<?php
$input = $_POST;
if ($url == 'contact')
{
	if ($input['viewMode'] == 'sendMail' AND !empty($input['name']) AND !empty($input['message']))
	{
		$messageBegin = '<html>';
		$messageBegin .='<head>';
		$messageBegin .='<title>Сообщение от '.date("d.m.Y H:i:s").'</title>';
		$messageBegin .='<style>';
			$messageBegin .='div {font-family: Verdana, Helvetica; color:#262626; font-size:12px; text-align:left;}';
			$messageBegin .='a {font-family: Verdana, Helvetica; font-size:12; color:#e93900; text-decoration:none;}';
		$messageBegin .='</style>';
		$messageBegin .='</head>';
		$messageBegin .='<body>';
			$body = '<div style="color:#6B778A; font-size:11px; font-family:Arial;"> <br /> Имя: &#160;<b>'.$input['name']."</b><br /> Телефон: &#160;<b>".$input['phone']."</b><br /> Е-мейл: &#160;<b>".$input['email']."</b><br /><br /> Cообщение: &#160;<b>".$input['message']
			 .'</b></div><br /><br /><br /><table bgcolor="#FF8500" width="100%"><tr><td align="center"><div style="font-size:10px; font-family:Arial;">Интернет-Супермаркет Happymarket.net.ua</td></tr></table>';
			$body .= '</div>';
		$messageEnd = '</body>';
		$messageEnd .='</html>';

		$messageHTML = $messageBegin.$body.$messageEnd;

		$messagePlain = "Имя: {$input['name']}\n";
		$messagePlain .= "Телефон: {$input['phone']}\n";
		$messagePlain .= "Е-мейл: {$input['email']}\n\n";
		$messagePlain .= "{$input['message']}";

		$semi_rand = md5(time());
		$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

		$toadress = 'shop@happymarket.net.ua';
		$subject = "Message from happymarket.net.ua!";
		$headers = "From: message@happymarket.net.ua\n".
					"Return-path: message@happymarket.net.ua\n".
					"MIME-Version: 1.0\n".
					"Content-Type: multipart/alternative; boundary=\"{$mime_boundary}\"";

		//multipart message
		$message = "--{$mime_boundary}\n".
             "Content-Type: text/plain; charset=utf-8\n\n".
             $messagePlain."\n\n";
		$message .= "--{$mime_boundary}\n".
             "Content-Type: text/html; charset=utf-8\n\n".
             $messageHTML."\n\n";
		$message .= "--{$mime_boundary}--\n";

		if (mail($toadress, $subject, $message, $headers)) { $systemMessage = 'ok';}
		else { $systemMessage = 'error'; }
	}
}
?>
