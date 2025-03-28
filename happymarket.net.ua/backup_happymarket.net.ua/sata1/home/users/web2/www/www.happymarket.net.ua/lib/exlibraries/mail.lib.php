<?

function queMail($template, $mailArray, $parameters)
{			
		//global $outputTemplate;
		//if($parameters['repet'] != 1)
		//{
			$inputTemplate['tableName'] = 'template';
			$inputTemplate['filter_templateID'] = $template;
			$inputTemplate['filter'] = getFilter($inputTemplate);
			$outputTemplate = getData($inputTemplate);
			$outputTemplate = $outputTemplate[0];
			$inputTemplate='';	
		//}
		
		$mailArray['URLdecline'] = '<a href="'.$mailArray['URLdecline'].'">'.$mailArray['URLdecline'].'</a>';
		$mailArray['URLmore'] = '<a href="'.$mailArray['URLmore'].'">'.$mailArray['URLmore'].'</a>';
		$mailArray['URLsite'] = '<a style="color:green" href="http://'.host.'">'.host.'</a>';
		
		$outputTemplate['templateText'] = str_replace("{UserName}", $mailArray['name'], $outputTemplate['templateText']);
		$outputTemplate['templateText'] = str_replace("{UserNik}", $mailArray['nik'], $outputTemplate['templateText']);
		$outputTemplate['templateText'] = str_replace("{UserPass}", $mailArray['password'], $outputTemplate['templateText']);
		$outputTemplate['templateText'] = str_replace("{UserEmail}", $mailArray['email'], $outputTemplate['templateText']);
		$outputTemplate['templateText'] = str_replace("{Content}", $mailArray['content'], $outputTemplate['templateText']);
		$outputTemplate['templateText'] = str_replace("{URLdecline}", $mailArray['URLdecline'], $outputTemplate['templateText']);
		$outputTemplate['templateText'] = str_replace("{URLmore}", $mailArray['URLmore'], $outputTemplate['templateText']);
		$outputTemplate['templateText'] = str_replace("{URLsite}", $mailArray['URLsite'], $outputTemplate['templateText']);
	
		$body = $outputTemplate['templateText'];
			$input['tableName'] = 'sendque';
			$input['sendque_toadress'] = $mailArray['email'];
			$input['sendque_subject'] = $mailArray['subject'];
			$input['sendque_file'] = $mailArray['file'];
			$input['sendque_template'] = $template;
			$input['sendque_body'] = $body;
			saveData($input);
			$input = '';
}

function sendMail($template, $mailArray)
{			
		$inputTemplate['tableName'] = 'template';
		$inputTemplate['filter_templateID'] = $template;
		$inputTemplate['filter'] = getFilter($inputTemplate);
		$outputTemplate = getData($inputTemplate);
		$outputTemplate = $outputTemplate[0];
		$inputTemplate='';		
		
		$mailArray['URLdecline'] = '<a href="'.$mailArray['URLdecline'].'">'.$mailArray['URLdecline'].'</a>';
		$mailArray['URLmore'] = '<a href="'.$mailArray['URLmore'].'">'.$mailArray['URLmore'].'</a>';
		$mailArray['URLsite'] = '<a style="color:green" href="http://'.host.'">'.host.'</a>';
				
		$outputTemplate['templateText'] = str_replace("{UserName}", $mailArray['name'], $outputTemplate['templateText']);
		$outputTemplate['templateText'] = str_replace("{UserNik}", $mailArray['nik'], $outputTemplate['templateText']);
		$outputTemplate['templateText'] = str_replace("{UserPass}", $mailArray['password'], $outputTemplate['templateText']);
		$outputTemplate['templateText'] = str_replace("{UserEmail}", $mailArray['email'], $outputTemplate['templateText']);
		$outputTemplate['templateText'] = str_replace("{AuthorName}", $mailArray['AuthorName'], $outputTemplate['templateText']);
		$outputTemplate['templateText'] = str_replace("{AuthorEmail}", $mailArray['AuthorEmail'], $outputTemplate['templateText']);
		$outputTemplate['templateText'] = str_replace("{Content}", $mailArray['content'], $outputTemplate['templateText']);
		$outputTemplate['templateText'] = str_replace("{Info}", $mailArray['Info'], $outputTemplate['templateText']);
		$outputTemplate['templateText'] = str_replace("{URLdecline}", $mailArray['URLdecline'], $outputTemplate['templateText']);
		$outputTemplate['templateText'] = str_replace("{URLmore}", $mailArray['URLmore'], $outputTemplate['templateText']);
		$outputTemplate['templateText'] = str_replace("{URLsite}", $mailArray['URLsite'], $outputTemplate['templateText']);
	
		$body = $outputTemplate['templateText'];
		$toadress = $mailArray['email'];
		$contenttype = "Content-type: text/html; charset=utf-8";
		$subject = $mailArray['subject'];
		$subject = '=?utf-8?b?'.base64_encode($subject).'?=';
		$fromadress = "From: Deshevshe.net.ua <message@deshevshe.net.ua>\n".
					"Return-path: message@deshevshe.net.ua\n".$contenttype;
		if (mail($toadress, $subject, $body, $fromadress)) { $systemMessage = 'ok';} 
		else { $systemMessage = 'error'; }
}

function fileMail($mail, $to, $subject, $message, $filename)
{
    $uniqid   = md5(uniqid(time));
    $headers  = 'From: '.$mail."\n";
    $headers .= 'Reply-to: '.$mail."\n";
    $headers .= 'Return-Path: '.$mail."\n";
    $headers .= 'Message-ID: <'.$uniqid.'@'.$_SERVER['SERVER_NAME'].">\n";
    $headers .= 'MIME-Version: 1.0'."\n";
    $headers .= 'Date: '.gmdate('D, d M Y H:i:s', time())."\n";
   // $headers .= 'X-Priority: 3'."\n";
   // $headers .= 'X-MSMail-Priority: Normal'."\n";
   // $headers .= 'X-Mailer: '.$config['version_name'].' '.$config['version_id']."\n";
    //$headers .= 'X-MimeOLE: '.$config['version_name'].' '.$config['version_id']."\n";
    $headers .= 'Content-Type: multipart/mixed; boundary="----------'.$uniqid.'"'."\n\n";
    $headers .= '------------'.$uniqid."\n";
    $headers .= 'Content-type: text/html; charset=UTF-8'."\n";
    $headers .= 'Content-transfer-encoding: 7bit';

    if (!empty($filename)){
        $file     = fopen($filename, 'rb');
        $message .= "\n".'------------'.$uniqid."\n";
        $message .= 'Content-Type: application/octet-stream;';
	$message .= "name=\"".basename($filename)."\"\n";
        $message .= "Content-Transfer-Encoding:base64\n";
	//$message .= "Content-ID: <part1.09050509.04090501@".$_SERVER['SERVER_NAME'].">\n";	
	$message .= "Content-Disposition:inline;";
	$message .= "filename=\"".basename($filename)."\"\n\n";
	$message .= chunk_split(base64_encode(fread($file,filesize($filename))))."\n";
	$message .= "------------".$uniqid."--\n";
    }
   return  @mail($to, $subject, $message, $headers);
}


function fileMail2($from, $to, $subj, $text, $filename) 
{    
 		$file         = fopen($filename,"rb");     
 		$un        = strtoupper(uniqid(time()));     
		$head      = "From: $from\n";     
		//$head     .= "To: $to\n";     
		//$head     .= "Subject: $subj\n";     
		//$head     .= "X-Mailer: PHPMail Tool\n";     
		$head     .= "Reply-To: $from\n";     
		$head     .= "Mime-Version: 1.0\n";     
		$head     .= "Content-Type:multipart/mixed;";     
		$head     .= "boundary=\"----------".$un."\"\n\n";     
		$zag       = "------------".$un."\nContent-Type:text/html; charset=utf-8\n";
		$zag      .= "Content-Transfer-Encoding: 8bit\n\n$text\n\n";  
		$zag      .= "------------".$un."\n";  
		$zag      .= "Content-Type: application/octet-stream;";     
		$zag      .= "name=\"".basename($filename)."\"\n";   
		$zag      .= "Content-Transfer-Encoding:base64\n";     
		$zag      .= "Content-Disposition:attachment;";     
		$zag      .= "filename=\"".basename($filename)."\"\n\n";     
		$zag      .= chunk_split(base64_encode(fread($file,filesize($filename))))."\n";  
		$zag      .= "------------".$un."--\n"; 
		
		$subj = '=?utf-8?b?'.base64_encode($subj).'?=';
		return @mail($to, $subj, $zag, $head);
		
		// Пример использования
		//fileMail($fromadress, $toadress, $subject, $body, pathcore.'content/deshevshe.xls');
} 
?>