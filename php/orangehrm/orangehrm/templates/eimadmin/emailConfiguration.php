<?php
/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 *
 */

require_once($lan->getLangPath("full.php"));

$locRights=$_SESSION['localRights'];

$editArr = $this->popArr['editArr'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo $lang_Admin_EMX_MailConfiguration; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../themes/<?php echo $styleSheet;?>/css/style.css" rel="stylesheet" type="text/css">
<link href="../../themes/<?php echo $styleSheet;?>/css/leave.css" rel="stylesheet" type="text/css" />
<style type="text/css">
@import url("../../themes/<?php echo $styleSheet;?>/css/style.css"); .style1 {color: #FF0000}

.hide {
	display:none;
}

.show {
	display: table-row;
}
</style>
</head>
<script type="text/javascript" src="../../scripts/archive.js"></script>
<script type="text/javascript" >
	function changeMailType() {
 		value = $('txtMailType').value;
 		panels = ['sendmailDetails', 'smtpDetails1', 'smtpDetails2'];

 		for (i=0; i<panels.length; i++) {
 			$(panels[i]).className = 'hide';
 		}

 		switch (value) {
 			case '<?php echo EmailConfiguration::EMAILCONFIGURATION_TYPE_SENDMAIL; ?>' :$(panels[0]).className = 'show';
 																					 break;
 			case '<?php echo EmailConfiguration::EMAILCONFIGURATION_TYPE_SMTP; ?>' : $(panels[1]).className = 'show';
 																					 $(panels[2]).className = 'show';
 																					 break;
 		}
	}

	function validate() {
		var errors = new Array();
		var error = false;

		var email = $('txtMailAddress');
		if (!checkEmail(email.value)) {
			error = true;
			errors.push('<?php echo $lang_Error_InvalidEmail; ?>');
		}

		var port = $('txtSmtpPort');
		if ( !numbers(port) || ((port <= 0) || (port > 65535))) {
			error = true;
			errors.push('<?php echo $lang_Error_Invalid_Port; ?>');
		}

		if (error) {
			errStr = "<?php echo $lang_Common_EncounteredTheFollowingProblems; ?>\n";
			for (i in errors) {
				errStr += " - "+errors[i]+"\n";
			}
			alert(errStr);
			return false;

		} else  {
			$('sqlState').value = 'UpdateRecord';
			$('frmEmailConfig').submit();
			return true;
		}
	}

	function $(id) {
		return document.getElementById(id);
	}

	function mout() {
	var Edit = $("btnEdit");

	if(Edit.title=='Save')
		Edit.src='../../themes/beyondT/pictures/btn_save.gif';
	else
		Edit.src='../../themes/beyondT/pictures/btn_edit.gif';
}

function mover() {
	var Edit = $("btnEdit");

	if(Edit.title=='Save')
		Edit.src='../../themes/beyondT/pictures/btn_save_02.gif';
	else
		Edit.src='../../themes/beyondT/pictures/btn_edit_02.gif';
}
</script>
<body>
<h2><?php echo $lang_Admin_EMX_MailConfiguration; ?><hr/></h2>
<form id="frmEmailConfig" name="frmEmailConfig" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?uniqcode=EMX&id=1" onsubmit="validate(); return false;">
<input type="hidden" name="sqlState" id="sqlState" />
  <table border="0" cellpadding="0" cellspacing="0">
    <thead>
      <tr>
        <th class="tableTopLeft"></th>
        <th class="tableTopMiddle"></th>
        <th class="tableTopMiddle"></th>
        <th class="tableTopMiddle"></th>
        <th class="tableTopMiddle"></th>
		<th class="tableTopMiddle"></th>
		<th class="tableTopMiddle"></th>
		<th class="tableTopMiddle"></th>
		<th class="tableTopMiddle"></th>
        <th class="tableTopRight"></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="tableMiddleLeft"></td>
        <td><?php echo $lang_MailFrom; ?></td>
        <td width="25px">&nbsp;</td>
        <td><input type="text" name="txtMailAddress" id="txtMailAddress" value="<?php echo $editArr->getMailAddress();?>"/></td>
        <td width="25px">&nbsp;</td>
		<td><?php echo $lang_MailSendingMethod; ?></td>
		<td width="25px">&nbsp;</td>
		<td><select name="txtMailType" id="txtMailType" onchange="changeMailType();" onclick="changeMailType();">
				<option value="0">-- Select --</option>
				<option value="<?php echo EmailConfiguration::EMAILCONFIGURATION_TYPE_SENDMAIL; ?>" <?php echo ($editArr->getMailType() == EmailConfiguration::EMAILCONFIGURATION_TYPE_SENDMAIL )? 'selected': ''?> ><?php echo $lang_MailTypes_Sendmailer; ?></option>
				<option value="<?php echo EmailConfiguration::EMAILCONFIGURATION_TYPE_SMTP; ?>" <?php echo ($editArr->getMailType() == EmailConfiguration::EMAILCONFIGURATION_TYPE_SMTP)? 'selected': ''?> ><?php echo $lang_MailTypes_Smtp; ?></option>
		  </select></td>
        <td width="25px">&nbsp;</td>
        <td class="tableMiddleRight"></td>
      </tr>
	  <!-- Sendmail -->
	  <tr id="sendmailDetails">
        <td class="tableMiddleLeft"></td>
        <td><?php echo $lang_SendmailPath; ?></td>
        <td width="25px">&nbsp;</td>
        <td><input type="text" name="txtSendmailPath" id="txtSendmailPath" value="<?php echo $editArr->getSendmailPath();?>" /></td>
        <td width="25px">&nbsp;</td>
		<td>&nbsp;</td>
		<td width="25px">&nbsp;</td>
		<td>&nbsp;</td>
        <td width="25px">&nbsp;</td>
        <td class="tableMiddleRight"></td>
      </tr>
	  <!-- SMTP -->
	  <tr id="smtpDetails1">
        <td class="tableMiddleLeft"></td>
        <td><?php echo $lang_SmtpHost; ?></td>
        <td width="25px">&nbsp;</td>
        <td><input type="text" name="txtSmtpHost" id="txtSmtpHost" value="<?php echo $editArr->getSmtpHost();?>" /></td>
        <td width="25px">&nbsp;</td>
		<td><?php echo $lang_SmtpPort; ?></td>
		<td width="25px">&nbsp;</td>
		<td><input type="text" name="txtSmtpPort" id="txtSmtpPort" value="<?php echo $editArr->getSmtpPort();?>" size="4"/></td>
        <td width="25px">&nbsp;</td>
        <td class="tableMiddleRight"></td>
      </tr>
	  <tr id="smtpDetails2">
        <td class="tableMiddleLeft"></td>
        <td><?php echo $lang_SmtpUser; ?></td>
        <td width="25px">&nbsp;</td>
        <td><input type="text" name="txtSmtpUser" id="txtSmtpUser" value="<?php echo $editArr->getSmtpUser();?>" /></td>
        <td width="25px">&nbsp;</td>
		<td><?php echo $lang_SmtpPassword; ?></td>
		<td width="25px">&nbsp;</td>
		<td><input type="password" name="txtSmtpPass" id="txtSmtpPass" value="<?php echo $editArr->getSmtpPass();?>"/></td>
        <td width="25px">&nbsp;</td>
        <td class="tableMiddleRight"></td>
      </tr>
	  <tr>
        <td class="tableMiddleLeft"></td>
        <td>&nbsp;</td>
        <td width="25px">&nbsp;</td>
        <td>&nbsp;</td>
        <td width="25px">&nbsp;</td>
		<td>&nbsp;</td>
		<td width="25px">&nbsp;</td>
        <td>&nbsp;</td>
        <td width="25px">
			<?php
			   if($locRights['edit']) { ?>
			        <input type="image" class="button1" id="btnEdit" src="../../themes/beyondT/pictures/btn_save.gif" title="Save" onMouseOut="mout();" onMouseOver="mover();" name="Save" />
<?php			} else { ?>
			        <input type="image" class="button1" id="btnEdit" src="../../themes/beyondT/pictures/btn_edit.gif" onClick="alert('<?php echo $lang_Common_AccessDenied;?>'); return false;" />
<?php			}  ?></td>
        <td class="tableMiddleRight"></td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td class="tableBottomLeft"></td>
        <td class="tableBottomMiddle"></td>
        <td class="tableBottomMiddle"></td>
		<td class="tableBottomMiddle"></td>
        <td class="tableBottomMiddle"></td>
        <td class="tableBottomMiddle"></td>
        <td class="tableBottomMiddle"></td>
		<td class="tableBottomMiddle"></td>
        <td class="tableBottomMiddle"></td>
        <td class="tableBottomRight"></td>
      </tr>
    </tfoot>
  </table>
  <script type="text/javascript">
  	changeMailType();
  </script>
</form>
</body>
</html>
