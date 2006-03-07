<?
/*
OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures 
all the essential functionalities required for any enterprise. 
Copyright (C) 2006 hSenid Software International Pvt. Ltd, http://www.hsenid.com

OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
the GNU General Public License as published by the Free Software Foundation; either
version 2 of the License, or (at your option) any later version.

OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program;
if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
Boston, MA  02110-1301, USA
*/

session_start();
if(!isset($_SESSION['fname'])) { 

	header("Location: ./relogin.htm");
	exit();
}

define('OpenSourceEIM', dirname(__FILE__));
require_once OpenSourceEIM . '/lib/Models/bugs/Users.php';
require_once OpenSourceEIM . '/lib/Confs/sysConf.php';

	$users = new Users();
	$sysConst = new sysConf(); 
	$locRights=$_SESSION['localRights'];

	$lastRecord = $users ->getLastRecord();
	
if ((isset($_POST['sqlState'])) && ($_POST['sqlState'] == 'NewRecord')) {
	
	     $users->setUserID($_POST['txtUserID']);
		 $users->setUserName(trim($_POST['txtUserName']));
		 $users->setUserPassword(trim($_POST['txtUserPassword'])); 
		 $users->setUserFirstName(trim($_POST['txtUserFirstName'])); 
		 $users->setUserLastName(trim($_POST['txtUserLastName'])); 
		 $users->setUserReportsToID($_POST['cmbUserReportToID']); 
		 $users->setUserIsAdmin(isset($_POST['txtUserIsAdmin']) ? 'Yes' : 'No'); 
		 $users->setUserDesc(trim($_POST['txtUserDescription'])); 
		 $users->setUserDateEntered(date("Y-m-d")); 
		 $users->setUserCreatedBy($_SESSION['user']); 
		 $users->setUserDepartment(trim($_POST['txtUserDepartment'])); 
		 $users->setUserPhoneHome(trim($_POST['txtUserPhoneHome'])); 
		 $users->setUserPhoneMobile(trim($_POST['txtUserPhoneMobile'])); 
		 $users->setUserPhoneWork(trim($_POST['txtUserPhoneWork'])); 
		 $users->setUserEmail1(trim($_POST['txtUserEmail1'])); 
		 $users->setUserEmail2(trim($_POST['txtUserEmail2'])); 
		 $users->setUserStatus($_POST['cmbUserStatus']);
		 $users->setUserAddress(trim($_POST['txtUserAddress'])); 
		 $users->setUserDeleted(isset($_POST['txtUserDeleted']) ? '1' : '0'); 
		 $users->setUserGroupID($_POST['cmbUserGroupID']); 
		$message = $users ->addUsers();

		// Checking whether the $message Value returned is 1 or 0
	if ($message!=false) { 
		
		$showMsg = "Addition%Successful!"; //If $message is 1 setting up the 
		
		$bugcode = $_GET['bugcode'];
		$pageID = $_POST['pageID'];
		header("Location: ./bugview.php?message=$showMsg&bugcode=$bugcode&pageID=$pageID");
		
	} else {
		
		$showMsg = "UserName%Exists!";
		
		$bugcode = $_GET['bugcode'];
		$pageID = $_GET['pageid'];
		header("Location: ./users.php?msg=$showMsg&capturemode=addmode&bugcode=$bugcode&pageID=$pageID");
	}
	
} else if ((isset($_POST['sqlState'])) && ($_POST['sqlState'] == 'UpdateRecord')) {

	     $users->setUserID($_POST['txtUserID']);
		 $users->setUserName(trim($_POST['txtUserName']));
		 $users->setUserPassword(trim($_POST['txtUserPassword'])); 
		 $users->setUserFirstName(trim($_POST['txtUserFirstName'])); 
		 $users->setUserLastName(trim($_POST['txtUserLastName'])); 
		 $users->setUserReportsToID($_POST['cmbUserReportToID']); 
		 $users->setUserIsAdmin(isset($_POST['txtUserIsAdmin']) ? 'Yes' : 'No'); 
		 $users->setUserDesc(trim($_POST['txtUserDescription'])); 
		 $users->setUserDateModified(date("Y-m-d")); 
		 $users->setUserModifiedBy($_SESSION['user']); 
		 $users->setUserDepartment(trim($_POST['txtUserDepartment'])); 
		 $users->setUserPhoneHome(trim($_POST['txtUserPhoneHome'])); 
		 $users->setUserPhoneMobile(trim($_POST['txtUserPhoneMobile'])); 
		 $users->setUserPhoneWork(trim($_POST['txtUserPhoneWork'])); 
		 $users->setUserEmail1(trim($_POST['txtUserEmail1'])); 
		 $users->setUserEmail2(trim($_POST['txtUserEmail2'])); 
		 $users->setUserStatus($_POST['cmbUserStatus']);
		 $users->setUserAddress(trim($_POST['txtUserAddress'])); 
		 $users->setUserDeleted(isset($_POST['txtUserDeleted']) ? '1' : '0'); 
		 $users->setUserGroupID($_POST['cmbUserGroupID']); 
		$message = $users ->updateUsers();
	
	// Checking whether the $message Value returned is 1 or 0
	if ($message!=false) { 
		
		$showMsg = "Updation%Successful!"; //If $message is 1 setting up the 
		
		$bugcode = $_GET['bugcode'];
		$pageID = $_POST['pageID'];
		header("Location: ./bugview.php?message=$showMsg&bugcode=$bugcode&pageID=$pageID");
		
	} else {
		
		$showMsg = "UserName%Exists!";
		
		$bugcode = $_GET['bugcode'];
		$pageID = $_GET['pageid'];
		$id=$_GET['id'];
		header("Location: ./users.php?msg=$showMsg&id=$id&capturemode=updatemode&bugcode=$bugcode&pageID=$pageID");
	}

}
?>
<?
	if ((isset($_GET['capturemode'])) && ($_GET['capturemode'] == 'addmode')) {
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script>		

function echeck(str) {

		var lat=str.indexOf('@');
		var lstr=str.length;
		var ldot=str.indexOf('.');
		if (str.indexOf('@')==-1){
		   return false;
		}

		if (str.indexOf('@')==-1 || str.indexOf('@')==0 || str.indexOf('@')==lstr){
		   return false;
		}

		if (str.indexOf('.')==-1 || str.indexOf('.')==0 || str.indexOf('.')==lstr){
		    return false;
		}

		 if (str.indexOf('@',(lat+1))!=-1){
		    return false;
		 }

		 if (str.substring(lat-1,lat)=='.' || str.substring(lat+1,lat+2)=='.'){
		    return false;
		 }

		 if (str.indexOf('.',(lat+2))==-1){
		    return false;
		 }
		
		 if (str.indexOf(" ")!=-1){
		    return false;
		 }

 		 return true;
	}

function alpha(txt)
{
var flag=true;
var i,code;

if(txt.value=="")
   return false;

for(i=0;txt.value.length>i;i++)
	{
	code=txt.value.charCodeAt(i);
    if((code>=65 && code<=122) || code==32 || code==46)
	   flag=true;
	else
	   {
	   flag=false;
	   break;
	   }
	}
return flag;
}

function numeric(txt)
{
var flag=true;
var i,code;

if(txt.value=="")
   return false;

for(i=0;txt.value.length>i;i++)
	{
	code=txt.value.charCodeAt(i);
    if(code>=48 && code<=57)
	   flag=true;
	else
	   {
	   flag=false;
	   break;
	   }
	}
return flag;
}


function goBack() {
		location.href = "bugview.php?bugcode=<?=$_GET['bugcode']?>";
	}

	function addSave() {
		var frm=document.frmUsers;
		if (frm.txtUserName.value.length < 5 ) {
			alert ("UserName should be atleast five char. long!");
			frm.txtUserName.focus();
			return false;
		}
		
		if(frm.txtUserPassword.value.length < 4) {
			alert("Password should be atleast four char. long!");
			frm.txtUserPassword.focus();
			return;
		}
		
		if(frm.txtUserPassword.value != frm.txtUserConfirmPassword.value) {
			alert("Password Mismatch!");
			frm.txtUserPassword.focus();
			return;
		}
		
		if(!alpha(frm.txtUserFirstName)) {
			alert("Field should be Alphabetic!")
			frm.txtUserFirstName.focus();
			return;
		}
		
		if(!alpha(frm.txtUserLastName) && frm.txtUserLastName.value != '') {
			alert("Field should be Alphabetic!");
			frm.txtUserLastName.focus();
			return;
		}

		if(frm.cmbUserGroupID.value == '0') {
			alert("Field should be selected!");
			frm.cmbUserGroupID.focus();
			return;
		}
		
		if(!numeric(frm.txtUserPhoneHome) && frm.txtUserPhoneHome.value != '') {
			alert("Field should be Numeric!");
			frm.txtUserPhoneHome.focus();
			return;
		}

		if(!numeric(frm.txtUserPhoneMobile) && frm.txtUserPhoneMobile.value != '') {
			alert("Field should be Numeric!");
			frm.txtUserPhoneMobile.focus();
			return;
		}

		if(!numeric(frm.txtUserPhoneWork) && frm.txtUserPhoneWork.value != '') {
			alert("Field should be Numeric!");
			frm.txtUserPhoneWork.focus();
			return;
		}

		if(!echeck(frm.txtUserEmail1.value) && frm.txtUserEmail1.value != '') {
			alert("Invalid Email");
			frm.txtUserEmail1.focus();
			return;
		}

		if(!echeck(frm.txtUserEmail2.value) && frm.txtUserEmail2.value != '') {
			alert("Invalid Email");
			frm.txtUserEmail2.focus();
			return;
		}

		document.frmUsers.sqlState.value = "NewRecord";
		document.frmUsers.pageID.value = "<?=$_GET['pageID']?>";
		document.frmUsers.submit();		
	}			
	
</script>
<link href="./themes/beyondT/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">@import url("./themes/beyondT/css/style.css"); </style>
</head>
<body>
<table width='100%' cellpadding='0' cellspacing='0' border='0' class='moduleTitle'>
  <tr>
    <td valign='top'> </td>
    <td width='100%'><h2>Users</h2></td>
    <td valign='top' align='right' nowrap style='padding-top:3px; padding-left: 5px;'><A href='index.php?module=Contacts&action=index&return_module=Contacts&return_action=DetailView&&print=true' class='utilsLink'></td>
  </tr>
</table>
<p>
<p> 
<table width="431" border="0" cellspacing="0" cellpadding="0" ><td width="177">
<form name="frmUsers" method="post" action="./users.php?pageid=<?=$_GET['pageID']?>&bugcode=<?=$_GET['bugcode']?>">
<input type="hidden" name="pageID" value="">
  <tr> 
    <td height="27" valign='top'> <p> <img title="Back" onmouseout="this.src='./themes/beyondT/pictures/btn_back.jpg';" onmouseover="this.src='./themes/beyondT/pictures/btn_back_02.jpg';"  src="./themes/beyondT/pictures/btn_back.jpg" onclick="goBack();">
        <input type="hidden" name="sqlState" value="">
      </p></td>
    <td width="254" align='left' valign='bottom'> <font color="red" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; 
      <?
		if (isset($_GET['msg'])) {
			$expString  = $_GET['msg'];
			$expString = explode ("%",$expString);
			$length = sizeof($expString);
			for ($x=0; $x < $length; $x++) {		
				echo " " . $expString[$x];		
			}
		}		
		?>

    </font> </td>
  </tr><td width="177"><form name="frmUsers" method="post" action="./users.php">
</table>

              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="13"><img name="table_r1_c1" src="themes/beyondT/pictures/table_r1_c1.gif" width="13" height="12" border="0" alt=""></td>
                  <td width="339" background="themes/beyondT/pictures/table_r1_c2.gif"><img name="table_r1_c2" src="themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                  <td width="13"><img name="table_r1_c3" src="themes/beyondT/pictures/table_r1_c3.gif" width="13" height="12" border="0" alt=""></td>
                  <td width="11"><img src="themes/beyondT/pictures/spacer.gif" width="1" height="12" border="0" alt=""></td>
                </tr>
                <tr>
                  <td background="themes/beyondT/pictures/table_r2_c1.gif"><img name="table_r2_c1" src="themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                  <td><table width="100%" border="0" cellpadding="5" cellspacing="0" class="">
						  <tr> 
							    <td>Code</td>
							    <td> <input type="text" readonly="true" name="txtUserID" value=<?=$lastRecord; ?> > 
						  </tr>
						  <tr> 
							    <td>User Name</td>
							    <td><input type="text" name="txtUserName"></td>
						  </tr>
						  <tr>
							  <td>Password</td>
							  <td><input type="password" name="txtUserPassword"></td>
							  <td></td>
							  <td>Confirm Password</td>
							  <td><input type="password" name="txtUserConfirmPassword"></td> 
						  </tr>
						  <tr>
							  <td>First Name</td>
							  <td><input type="text" name="txtUserFirstName"></td>
							  <td></td>
							  <td>Last Name</td>
							  <td><input type="text" name="txtUserLastName"></td>
						  </tr>
						  <tr>
							  <td>Reports to ID</td>
							  <td><select name="cmbUserReportToID">
							  		<option value="0">--Select UserID--</option>
<?									$ulist=$users->getUsers();
									for($c=0;$ulist && count($ulist)>$c;$c++)
										echo "<option value='" . $ulist[$c][0] ."'>" .$ulist[$c][0]. "</option>";
?>							  
							  
							  </select></td> 
							  <td></td>
							  <td>User Group</td>
							  <td><select name="cmbUserGroupID">
							  		<option value="0">--Select UserGroup--</option>
<?									$uglist=$users->getUserGroupCodes();
									for($c=0;$uglist && count($uglist)>$c;$c++)
										echo "<option value='" . $uglist[$c][0] ."'>" .$uglist[$c][1]. "</option>";
?>							  
							  </select></td>
						   </tr>
						   <tr>
							   <td>Is Admin</td>
							   <td><input type="checkbox" name="chkUserIsAdmin"></td>
							   <td></td>
							   <td>Deleted</td>
							   <td><input type="checkbox" name="chkUserDeleted"></td>
						   </tr>
						   <tr>
							   <td>Department</td>
							   <td><input type="text" name="txtUserDepartment"></td>
							   <td></td>
							   <td>Phone (Home)</td>
							   <td><input type="text" name="txtUserPhoneHome"></td> 
						   </tr>
						   <tr>
							   <td>Phone (Mobile)</td>
							   <td><input type="text" name="txtUserPhoneMobile"></td> 
							   <td></td>
							   <td>Phone (Work)</td>
							   <td><input type="text" name="txtUserPhoneWork"></td> 
						   </tr>
						   <tr>
							   <td>Email 1</td>
							   <td><input type="text" name="txtUserEmail1"></td>
							   <td></td>
							   <td>Email 2</td>
							   <td><input type="text" name="txtUserEmail2"></td>
						   </tr>
						   <tr>
							   <td>Address</td>
							   <td><textarea name="txtUserAddress"></textarea></td>
							   <td></td>
							   <td>Description</td>
							   <td><textarea name="txtUserDescription"></textarea></td>
						   </tr>
						   <tr>
						   <td>Status</td>
						   <td><select name="cmbUserStatus">
						   			<option>Enabled</option>
						   			<option>Disabled</option>
						   </select></td>
						   </tr>
					  <tr><td></td><td align="right" width="100%"><img onClick="addSave();" onmouseout="this.src='./themes/beyondT/pictures/btn_save.jpg';" onmouseover="this.src='./themes/beyondT/pictures/btn_save_02.jpg';" src="./themes/beyondT/pictures/btn_save.jpg">
        <img onClick="document.frmUsers.reset();" onmouseout="this.src='./themes/beyondT/pictures/btn_clear.jpg';" onmouseover="this.src='./themes/beyondT/pictures/btn_clear_02.jpg';" src="./themes/beyondT/pictures/btn_clear.jpg"></td></tr>

                  </table></td>
                  <td background="themes/beyondT/pictures/table_r2_c3.gif"><img name="table_r2_c3" src="themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                  <td><img src="themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                </tr>
                <tr>
                  <td><img name="table_r3_c1" src="themes/beyondT/pictures/table_r3_c1.gif" width="13" height="16" border="0" alt=""></td>
                  <td background="themes/beyondT/pictures/table_r3_c2.gif"><img name="table_r3_c2" src="themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                  <td><img name="table_r3_c3" src="themes/beyondT/pictures/table_r3_c3.gif" width="13" height="16" border="0" alt=""></td>
                  <td><img src="themes/beyondT/pictures/spacer.gif" width="1" height="16" border="0" alt=""></td>
                </tr>
              </table>

</form> 
</form>
</body>
</html>
<? } else if ((isset($_GET['capturemode'])) && ($_GET['capturemode'] == 'updatemode')) {
	 $message = $users ->filterUsers($_GET['id']);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script>			
function echeck(str) {

		var lat=str.indexOf('@');
		var lstr=str.length;
		var ldot=str.indexOf('.');
		if (str.indexOf('@')==-1){
		   return false;
		}

		if (str.indexOf('@')==-1 || str.indexOf('@')==0 || str.indexOf('@')==lstr){
		   return false;
		}

		if (str.indexOf('.')==-1 || str.indexOf('.')==0 || str.indexOf('.')==lstr){
		    return false;
		}

		 if (str.indexOf('@',(lat+1))!=-1){
		    return false;
		 }

		 if (str.substring(lat-1,lat)=='.' || str.substring(lat+1,lat+2)=='.'){
		    return false;
		 }

		 if (str.indexOf('.',(lat+2))==-1){
		    return false;
		 }
		
		 if (str.indexOf(" ")!=-1){
		    return false;
		 }

 		 return true;
	}

function alpha(txt)
{
var flag=true;
var i,code;

if(txt.value=="")
   return false;

for(i=0;txt.value.length>i;i++)
	{
	code=txt.value.charCodeAt(i);
    if((code>=65 && code<=122) || code==32 || code==46)
	   flag=true;
	else
	   {
	   flag=false;
	   break;
	   }
	}
return flag;
}

function numeric(txt)
{
var flag=true;
var i,code;

if(txt.value=="")
   return false;

for(i=0;txt.value.length>i;i++)
	{
	code=txt.value.charCodeAt(i);
    if(code>=48 && code<=57)
	   flag=true;
	else
	   {
	   flag=false;
	   break;
	   }
	}
return flag;
}

	function goBack() {
		location.href = "bugview.php?bugcode=<?=$_GET['bugcode']?>";
	}

function mout() {
	if(document.Edit.title=='Save') 
		document.Edit.src='./themes/beyondT/pictures/btn_save.jpg'; 
	else
		document.Edit.src='./themes/beyondT/pictures/btn_edit.jpg'; 
}

function mover() {
	if(document.Edit.title=='Save') 
		document.Edit.src='./themes/beyondT/pictures/btn_save_02.jpg'; 
	else
		document.Edit.src='./themes/beyondT/pictures/btn_edit_02.jpg'; 
}
	
function edit()
{
	if(document.Edit.title=='Save') {
		addUpdate();
		return;
	}
	
	var frm=document.frmUsers;
//  alert(frm.elements.length);
	for (var i=0; i < frm.elements.length; i++)
		frm.elements[i].disabled = false;
	document.Edit.src="./themes/beyondT/pictures/btn_save.jpg";
	document.Edit.title="Save";
}

	function addUpdate() {
		
		var frm=document.frmUsers;
		if (frm.txtUserName.value.length < 5 ) {
			alert ("UserName should be atleast five char. long!");
			frm.txtUserName.focus();
			return false;
		}
		
		if(frm.txtUserPassword.value.length < 4) {
			alert("Password should be atleast four char. long!");
			frm.txtUserPassword.focus();
			return;
		}
		
		if(frm.txtUserPassword.value != frm.txtUserConfirmPassword.value) {
			alert("Password Mismatch!");
			frm.txtUserPassword.focus();
			return;
		}
		
		if(!alpha(frm.txtUserFirstName)) {
			alert("Field should be Alphabetic!")
			frm.txtUserFirstName.focus();
			return;
		}
		
		if(!alpha(frm.txtUserLastName) && frm.txtUserLastName.value != '') {
			alert("Field should be Alphabetic!");
			frm.txtUserLastName.focus();
			return;
		}

		if(frm.cmbUserGroupID.value == '0') {
			alert("Field should be selected!");
			frm.cmbUserGroupID.focus();
			return;
		}
		
		if(!numeric(frm.txtUserPhoneHome) && frm.txtUserPhoneHome.value != '') {
			alert("Field should be Numeric!");
			frm.txtUserPhoneHome.focus();
			return;
		}

		if(!numeric(frm.txtUserPhoneMobile) && frm.txtUserPhoneMobile.value != '') {
			alert("Field should be Numeric!");
			frm.txtUserPhoneMobile.focus();
			return;
		}

		if(!numeric(frm.txtUserPhoneWork) && frm.txtUserPhoneWork.value != '') {
			alert("Field should be Numeric!");
			frm.txtUserPhoneWork.focus();
			return;
		}

		if(!echeck(frm.txtUserEmail1.value) && frm.txtUserEmail1.value != '') {
			alert("Invalid Email");
			frm.txtUserEmail1.focus();
			return;
		}

		if(!echeck(frm.txtUserEmail2.value) && frm.txtUserEmail2.value != '') {
			alert("Invalid Email");
			frm.txtUserEmail2.focus();
			return;
		}

		
		document.frmUsers.sqlState.value = "UpdateRecord";
		document.frmUsers.pageID.value = "<?=$_GET['pageID']?>";
		document.frmUsers.submit();		
	}			

</script>
<link href="./themes/beyondT/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">@import url("./themes/beyondT/css/style.css"); </style>
</head>
<body>
<table width='100%' cellpadding='0' cellspacing='0' border='0' class='moduleTitle'>
  <tr>
    <td valign='top'> </td>
    <td width='100%'><h2>Users</h2></td>
    <td valign='top' align='right' nowrap style='padding-top:3px; padding-left: 5px;'><A href='index.php?module=Contacts&action=index&return_module=Contacts&return_action=DetailView&&print=true' class='utilsLink'></td>
  </tr>
</table>
<p>
<p> 
<table width="431" border="0" cellspacing="0" cellpadding="0" ><td width="177">
<form name="frmUsers" method="post" action="./users.php?pageid=<?=$_GET['pageID']?>&bugcode=<?=$_GET['bugcode']?>">
<input type="hidden" name="pageID" value="">
  <tr> 
    <td height="27" valign='top'> <p>  <img title="Back" onmouseout="this.src='./themes/beyondT/pictures/btn_back.jpg';" onmouseover="this.src='./themes/beyondT/pictures/btn_back_02.jpg';" src="./themes/beyondT/pictures/btn_back.jpg" onclick="goBack();">
        <input type="hidden" name="sqlState" value="">
      </p></td>
    <td width="254" align='left' valign='bottom'> <font color="red" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; 
      <?
		if (isset($_GET['msg'])) {
			$expString  = $_GET['msg'];
			$expString = explode ("%",$expString);
			$length = sizeof($expString);
			for ($x=0; $x < $length; $x++) {		
				echo " " . $expString[$x];		
			}
		}		
		?>
    </font> </td>
  </tr><td width="177"><form name="frmUsers" method="post" action="./users.php">
</table>

              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="13"><img name="table_r1_c1" src="themes/beyondT/pictures/table_r1_c1.gif" width="13" height="12" border="0" alt=""></td>
                  <td width="339" background="themes/beyondT/pictures/table_r1_c2.gif"><img name="table_r1_c2" src="themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                  <td width="13"><img name="table_r1_c3" src="themes/beyondT/pictures/table_r1_c3.gif" width="13" height="12" border="0" alt=""></td>
                  <td width="11"><img src="themes/beyondT/pictures/spacer.gif" width="1" height="12" border="0" alt=""></td>
                </tr>
                <tr>
                  <td background="themes/beyondT/pictures/table_r2_c1.gif"><img name="table_r2_c1" src="themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                  <td><table width="100%" border="0" cellpadding="5" cellspacing="0" class="">
						  <tr> 
							    <td>Code</td>
							    <td> <input type="text" readonly="true" name="txtUserID" value=<?=$_GET['id']?> > 
						  </tr>
						  <tr> 
							    <td>User Name</td>
							    <td><input type="text" name="txtUserName" disabled value="<?=$message[0][1]?>"></td>
						  </tr>
						  <tr>
							  <td>Password</td>
							  <td><input type="password" name="txtUserPassword" disabled value="<?=$message[0][2]?>"></td>
							  <td></td>
							  <td>Confirm Password</td>
							  <td><input type="password" name="txtUserConfirmPassword" disabled value="<?=$message[0][2]?>"></td> 
						  </tr>
						  <tr>
							  <td>First Name</td>
							  <td><input type="text" name="txtUserFirstName" disabled value="<?=$message[0][3]?>"></td>
							  <td></td>
							  <td>Last Name</td>
							  <td><input type="text" name="txtUserLastName" disabled value="<?=$message[0][4]?>"></td>
						  </tr>
						  <tr>
							  <td>Reports to ID</td>
							  <td><select name="cmbUserReportToID" disabled>
							  		<option value="0">--Select UserID--</option>
<?									$ulist=$users->getUsers();
									for($c=0;$ulist && count($ulist)>$c;$c++)
										if($message[0][5]==$ulist[$c][0])
											echo "<option selected value='" . $ulist[$c][0] ."'>" .$ulist[$c][0]. "</option>";
										else
											echo "<option value='" . $ulist[$c][0] ."'>" .$ulist[$c][0]. "</option>";
?>							  
							  </select></td> 
							  <td></td>
							  <td>User Group</td>
							  <td><select name="cmbUserGroupID" disabled>
							  		<option value="0">--Select UserGroup--</option>
<?									$uglist=$users->getUserGroupCodes();
									for($c=0;$uglist && count($uglist)>$c;$c++)
										if($message[0][21]==$uglist[$c][0])
											echo "<option selected value='" . $uglist[$c][0] ."'>" .$uglist[$c][1]. "</option>";
										else
											echo "<option value='" . $uglist[$c][0] ."'>" .$uglist[$c][1]. "</option>";
?>							  
							  </select></td>
						   </tr>
						   <tr>
							   <td>Is Admin</td>
							   <td><input type="checkbox" name="chkUserIsAdmin" disabled <?=$message[0][6]=='Yes' ? 'checked' : ''?>></td>
							   <td></td>
							   <td>Deleted</td>
							   <td><input type="checkbox" name="chkUserDeleted" disabled <?=$message[0][20]=='1' ? 'checked' : ''?>></td>
						   </tr>
						   <tr>
							   <td>Department</td>
							   <td><input type="text" name="txtUserDepartment" disabled value="<?=$message[0][12]?>"></td>
							   <td></td>
							   <td>Phone (Home)</td>
							   <td><input type="text" name="txtUserPhoneHome" disabled value="<?=$message[0][13]?>"></td> 
						   </tr>
						   <tr>
							   <td>Phone (Mobile)</td>
							   <td><input type="text" name="txtUserPhoneMobile" disabled value="<?=$message[0][14]?>"></td> 
							   <td></td>
							   <td>Phone (Work)</td>
							   <td><input type="text" name="txtUserPhoneWork" disabled value="<?=$message[0][15]?>"></td> 
						   </tr>
						   <tr>
							   <td>Email 1</td>
							   <td><input type="text" name="txtUserEmail1" disabled value="<?=$message[0][16]?>"></td>
							   <td></td>
							   <td>Email 2</td>
							   <td><input type="text" name="txtUserEmail2" disabled value="<?=$message[0][17]?>"></td>
						   </tr>
						   <tr>
							   <td>Address</td>
							   <td><textarea disabled name="txtUserAddress"><?=$message[0][19]?></textarea></td>
							   <td></td>
							   <td>Description</td>
							   <td><textarea disabled name="txtUserDescription"><?=$message[0][7]?></textarea></td>
						   </tr>
						   <tr>
							   <td>Status</td>
							   <td><select name="cmbUserStatus" disabled>
							   			<option>Enabled</option>
							   			<option <?=$message[0][18]=='Disabled' ? 'selected' : ''?>>Disabled</option>
							   	</select></td>
						   </tr>
					  <tr><td></td><td align="right" width="100%">
<?			if($locRights['edit']) { ?>
			        <img src="./themes/beyondT/pictures/btn_edit.jpg" title="Edit" onmouseout="mout();" onmouseover="mover();" name="Edit" onClick="edit();">
<?			} else { ?>
			        <img src="./themes/beyondT/pictures/btn_edit.jpg" onClick="alert('<?=$sysConst->accessDenied?>');">
<?			}  ?>
									  <img src="./themes/beyondT/pictures/btn_clear.jpg" onmouseout="this.src='./themes/beyondT/pictures/btn_clear.jpg';" onmouseover="this.src='./themes/beyondT/pictures/btn_clear_02.jpg';" onClick="clearAll();" >

                  </table></td>
                  <td background="themes/beyondT/pictures/table_r2_c3.gif"><img name="table_r2_c3" src="themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                  <td><img src="themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                </tr>
                <tr>
                  <td><img name="table_r3_c1" src="themes/beyondT/pictures/table_r3_c1.gif" width="13" height="16" border="0" alt=""></td>
                  <td background="themes/beyondT/pictures/table_r3_c2.gif"><img name="table_r3_c2" src="themes/beyondT/pictures/spacer.gif" width="1" height="1" border="0" alt=""></td>
                  <td><img name="table_r3_c3" src="themes/beyondT/pictures/table_r3_c3.gif" width="13" height="16" border="0" alt=""></td>
                  <td><img src="themes/beyondT/pictures/spacer.gif" width="1" height="16" border="0" alt=""></td>
                </tr>
              </table>

</form> 
</form>
</body>
</html>
<? } ?>