<center>
<br>
<table width="80%" border="0" cellpadding="3" cellspacing="1">
  <tr>
	<td  align="center">
	<p align="left">
	<? 
		echo '[ <a href="/adm/?manageFacts" >Назад</a> ]';	
	
	?>
	<table border="0" cellpadding="3" cellspacing="1" align="left">
	<tr>
		<td width="110" class="rowgreen">Фото:</td>
		<td>
			<? if(!empty($outputFact['factImage'])) echo '<img src="../images/fact/'.$outputFact['factImage'].'">';?>
		</td>
	</tr>
	<tr> 
		<td class="rowgreen">Название:</td>
		<td>
			<strong><?=$outputFact['factTitle']?></strong>
		</td>
	</tr>
	<tr> 
		<td class="rowgreen">Текст:</td>
		<td>
			<div style="text-align:justify;padding:5px;"><?=$outputFact['factText']?></div>
		</td>
	</tr>
	<tr> 
		<td class="rowgreen">Краткое описание:</td>
		<td>
			<div style="text-align:justify;padding:5px;"><?=$outputFact['factDescription']?></div>
		</td>
	</tr>
	<tr> 
		<td width="110" class="rowgreen">Источник:</td>
		<td>
			<?=$outputFact['factSource']?>
		</td>
	</tr>
	</table>

    </td>
  </tr>
</table>