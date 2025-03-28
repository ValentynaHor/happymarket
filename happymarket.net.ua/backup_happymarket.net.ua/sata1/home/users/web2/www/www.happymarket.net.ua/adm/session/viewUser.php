<center>
<br>
<table width="80%" cellpadding="3" cellspacing="1">
  <tr>
	<td  align="center">
	<p align="left">
	<? 
		echo '[ <a href="/adm/?manageUsers" >Назад</a> ]';	
	
	?>
	<table cellpadding="3" cellspacing="1" align="left">
    <tr>
	  <td></td>
      <td><b>Личная информация:</b></td>
    </tr>
	  <tr>
      <td valign="top" class="rowgreen">Фото:</td>
      <td> 
	  <? if(!empty($outputUser['userImage'])){ ?>
	 	 <img src="../images/uploaduser/<?=$outputUser['userImage']?>" >
	  <? } else { ?>
	  	-
	  <? } ?>
      </td>
    </tr>
    <tr> 
      <td width="110px" class="rowgreen">Ник (логин):</td>
      <td>
		<?=$outputUser['userNik']?>
        </td>
    </tr>
	<tr> 
      <td class="rowgreen">Имя:</td>
      <td>
        <?=$outputUser['userName']?>
	  </td>
    </tr>
	<tr> 
      <td class="rowgreen">Фамилия:</td>
      <td>
        <?=$outputUser['userFamily']?>
      </td>
    </tr>
	<tr> 
      <td class="rowgreen">Пол:</td>
      <td> 
		<?=getValueDropDown('ddGender',$outputUser['userGender'])?>
	  </td>
    </tr>
	<tr> 
      <td class="rowgreen">Дата рождения:
	  </td>
      <td> 
	   <?=formatDate($outputUser['userDateBirth'],'date')?>
	  </td>
    </tr>
	<tr> 
      <td valign="top"  class="rowgreen">О себе:<br>(Интересы,<br>занятия и т. п.)</td>
      <td> 
        <?=$outputUser['userDescription']?>
      </td>
    </tr>
	<tr>
      <td colspan="2">
	  	<hr color="#E4E4E4" width="100%">
		</td>
    </tr>
	<tr>
	  <td></td>
      <td align="center">
	  	<b>Kонтактная информация:</b>
	  </td>
    </tr>
	<tr> 
      <td class="rowgreen">Страна:</td>
      <td> 
        <?=$outputUser['userCountry']?>
	  </td>
    </tr>
	<tr> 
      <td class="rowgreen">Город:</td>
      <td> 
        <?=$outputUser['userCity']?>
	  </td>
    </tr>
    <tr> 
      <td class="rowgreen">Телефон:</td>
      <td> 
        <?=$outputUser['userPhone']?>
      </td>
    </tr>
    <tr> 
      <td class="rowgreen">E-mail:</td>
      <td> 
        <?=$outputUser['userEmail']?>
      </td>
    </tr>
    <tr> 
      <td class="rowgreen">#ICQ:</td>
      <td> 
        <?=$outputUser['userICQ']?>
      </td>
    </tr>
	 <tr> 
      <td class="rowgreen">www:</td>
      <td> 
        <?=$outputUser['userWWW']?>
      </td>
    </tr>
	<tr>
      <td colspan="2">
	  	<hr color="#E4E4E4" width="100%">
		</td>
    </tr>
</table>

     </td>
  </tr>
</table>