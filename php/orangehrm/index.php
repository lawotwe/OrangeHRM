<?
/*
OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures 
all the essential functionalities required for any enterprise. 
Copyright (C) 2006 hSenid Software, http://www.hsenid.com

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

define('Admin', 'MOD001');
define('PIM', 'MOD002');
define('MT', 'MOD003');
define('OpenSourceEIM', dirname(__FILE__));
require_once OpenSourceEIM . '/lib/Rights.php';
$_SESSION['path'] = OpenSourceEIM;

	$rights = new Rights();

	$arrRights=array('add'=> false , 'edit'=> false , 'delete'=> false, 'view'=> false);
//	$arrRights=array('add'=> true , 'edit'=> true, 'delete'=> true, 'view'=> true);

if ((isset($_GET['menu_no_top'])) && ($_GET['menu_no_top']=="eim"))   
	$arrRights=$rights->getRights($_SESSION['userGroup'],Admin);

if ((isset($_GET['menu_no_top'])) && ($_GET['menu_no_top']=="hr")) 
	$arrRights=$rights->getRights($_SESSION['userGroup'],PIM);

if ((isset($_GET['menu_no_top'])) && ($_GET['menu_no_top']=="mt")) 
	$arrRights=$rights->getRights($_SESSION['userGroup'],MT);
	
	$_SESSION['localRights']=$arrRights;


if (isset($_POST['styleSheet'])) {
	   	$styleSheet = $_POST['styleSheet'];
	} else {
		$styleSheet = "beyondT";
	}
	if (($styleSheet == '') && (!isset($styleSheet))) {
	
		$styleSheet = "beyondT";
	} else {
		$styleSheet = $styleSheet;
		session_register($styleSheet);
	}

if(isset($_GET['ACT']) && $_GET['ACT']=='logout') {

	session_destroy();
	header("Location: ./login.php");
}


?>
<html>
<head>
<title>OrangeHRM</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link href="themes/beyondT/pictures/styles.css" rel="stylesheet" type="text/css">
<link href="themes/beyondT/css/style.css" rel="stylesheet" type="text/css">
<link REL="SHORTCUT ICON" HREF="include/images/sugar_icon.ico">
<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-cold-1.css">
<script language=javascript src="scripts/ypSlideOutMenus.js"></script>
<script  src="include/javascript/sugar.js"></script>
<script type="text/javascript" src="jscalendar/calendar.js"></script>
<script type="text/javascript" src="jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="jscalendar/calendar-setup.js"></script>
<!DOCTYPE html PUBLIC "-//W3C//DTD html 4.01 Transitional//EN">
<script>



</script>
<SCRIPT language=javascript>
	<!--
	  var yPosition = 108;

		new ypSlideOutMenu("menu1", "right", 151, yPosition, 146, 230)
		new ypSlideOutMenu("menu2", "right", 151, yPosition + 22, 146, 360)
		new ypSlideOutMenu("menu3", "right", 151, yPosition + 44, 146, 220)
		new ypSlideOutMenu("menu4", "right", 151, yPosition + 66, 146, 130)
		new ypSlideOutMenu("menu5", "right", 151, yPosition + 88, 146, 80)
		new ypSlideOutMenu("menu6", "right", 151, yPosition + 110, 146, 140)
		new ypSlideOutMenu("menu7", "right", 151, yPosition + 132, 146, 205)
		new ypSlideOutMenu("menu8", "right", 151, yPosition + 154, 146, 130)
		new ypSlideOutMenu("menu9", "right", 151, yPosition + 176, 146, 80)
		new ypSlideOutMenu("menu10", "right", 151, yPosition + 198, 146, 120)
		new ypSlideOutMenu("menu11", "right", 151, yPosition + 220, 146, 205)		
	//-->
</SCRIPT>
<SCRIPT language=JavaScript type=text/javascript>
<!--
function swapImgRestore() { 
  var i,x,a=document.sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function preloadImages() { 
  var d=document; if(d.images){ if(!d.p) d.p=new Array();
    var i,j=d.p.length,a=preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.p[j]=new Image; d.p[j++].src=a[i];}}
}
function findObj(n, d) { 
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}
function swapImage() { 
  var i,j=0,x,a=swapImage.arguments; document.sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=findObj(a[i]))!=null){document.sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function showHideLayers() {
  var i,p,v,obj,args=showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style	; v=(v=='show')?'visible':(v='hide')?'hidden':v; }
    obj.visibility=v; }
}
//-->
</SCRIPT>
</head>
<body onload="preloadImages('themes/beyondT/pictures/buttons01_on.gif','themes/beyondT/pictures/buttons02_on.gif','themes/beyondT/pictures/buttons03_on.gif','themes/beyondT/pictures/buttons04_on.gif','themes/beyondT/pictures/buttons05_on.gif',
     'themes/beyondT/pictures/buttons06_on.gif','themes/beyondT/pictures/buttons07_on.gif','themes/beyondT/pictures/buttons08_on.gif','themes/beyondT/pictures/buttons09_on.gif','themes/beyondT/pictures/buttons10_on.gif','themes/beyondT/pictures/buttons11_on.gif')">
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<form name="indexForm" action="./menu.php?TEST=1111" method="post">
<input type="hidden" name="tabnumber" value="1">
<a name="a"></a>
<tr>
  <td colspan="2"><table cellspacing="0" cellpadding="0" border="0" width="100%">
      <tr height="50">
        <td width="23%"><img src=<? echo '"' . "themes/" . $styleSheet . "/pictures/orange3.png" . '"'; ?>  width="264" height="62" alt="Company Logo" border="0" style="margin-left: 10px;"></td>
        <td width="77%" align="right" nowrap class="myArea"><img src="themes/beyondT/pictures/top_img.jpg" width="300" height="62">
        </td>
      </tr>
      <tr>
        <? 
	if (!isset($_GET['menu_no_top'])) {
		$_GET['menu_no_top'] = "home";
	} 

	if ((isset($_GET['menu_no_top'])) && ($_GET['menu_no_top']=="home")) {  
	?>
        <td colspan="2"><table cellspacing="0" cellpadding="0" border="0" width="100%">
          <tr height="20">
            <td><img src="include/images/blank.gif" width="8" height="1" border="0" alt="Home"></td>
            <td style="background-image : url(themes/beyondT/pictures/pictures/currentTab_left.png);" ></td>
            <td style="padding-left:7px; background-image :url(themes/beyondT/pictures/nCurrentTab_left.gif);"></td>
            <td><table cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #E5E5E5;">
                <tr height="20">
                  <td style="background-image : url(themes/beyondT/pictures/nCurrentTab_left.gif);" ></td>
                  <td style="background-image : url(themes/beyondT/pictures/nCurrentTab_middle.gif);" nowrap><a class="currentTab"  href="./index.php?module=Home&menu_no=0&menu_no_top=home&submenutop=home1" >Home</a></td>
                  <td style="background-image : url(themes/beyondT/pictures/nCurrentTab_right.gif);"><img src="include/images/blank.gif" width="8" height="1" border="0" alt="Home"></td>
                  <td style="background-image : url(themes/beyondT/pictures/emptyTabSpace.png);"><img src="include/images/blank.gif" width="1" height="1" border="0" alt=""></td>
                </tr>
            </table></td>
            <? } else { ?>
            <td colspan="2"><table cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr height="20">
                  <td><img src="include/images/blank.gif" width="8" height="1" border="0" alt="Home"></td>
                  <td><table cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #E5E5E5;">
                      <tr height="20">
                        <td style="background-image : url(themes/beyondT/pictures/otherTab_left.png);" ><img src="include/images/blank.gif" width="8" height="1" border="0" alt="Dashboard"></td>
                        <td style="background-image : url(themes/beyondT/pictures/otherTab_middle.png);" class="otherTab" nowrap><a class="otherTab"  href="./index.php?module=Home&menu_no=0&menu_no_top=home&submenutop=home1">Home </a></td>
                        <td style="background-image : url(themes/beyondT/pictures/otherTab_right.png);"><img src="include/images/blank.gif" width="8" height="1" border="0" alt="Dashboard"></td>
                        <td style="background-image : url(themes/beyondT/pictures/emptyTabSpace.png);"><img src="include/images/blank.gif" width="1" height="1" border="0" alt=""></td>
                      </tr>
                  </table></td>
                  <? } ?>
                  <? 
						if ((isset($_GET['menu_no_top'])) && ($_GET['menu_no_top']=="eim") && $arrRights['view']) {  
									
					?>
                  <td style="background-image : url(themes/beyondT/pictures/pictures/currentTab_left.png);" ></td>
                  <td style="padding-left:7px; background-image :url(themes/beyondT/pictures/nCurrentTab_left.gif);"></td>
                  <td><table cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #E5E5E5;">
                      <tr height="20">
                        <td style="background-image : url(themes/beyondT/pictures/nCurrentTab_left.gif);" ></td>
                        <td style="background-image : url(themes/beyondT/pictures/nCurrentTab_middle.gif);" class="currentTab" nowrap><a   class="currentTab"  href="./index.php?module=Home&menu_no=1&submenutop=EIMModule&menu_no_top=eim" >Admin Module</a></td>
                        <td style="background-image : url(themes/beyondT/pictures/nCurrentTab_right.gif);"><img src="include/images/blank.gif" width="8" height="1" border="0" alt="Home"></td>
                        <td style="background-image : url(themes/beyondT/pictures/emptyTabSpace.png);"><img src="include/images/blank.gif" width="1" height="1" border="0" alt=""></td>
                      </tr>
                  </table></td>
                  <? } else { ?>
                  <td><table cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #E5E5E5;">
                      <tr height="20">
                        <td style="background-image : url(themes/beyondT/pictures/otherTab_left.png);" ><img src="include/images/blank.gif" width="8" height="1" border="0" alt="My Portal"></td>
                        <td style="background-image : url(themes/beyondT/pictures/otherTab_middle.png);" class="otherTab" nowrap><a class="otherTab" href="index.php?module=Home&menu_no=1&submenutop=EIMModule&menu_no_top=eim">Admin Module</a></td>
                        <td style="background-image : url(themes/beyondT/pictures/otherTab_right.png);"><img src="include/images/blank.gif" width="8" height="1" border="0" alt="My Portal"></td>
                        <td style="background-image : url(themes/beyondT/pictures/emptyTabSpace.png);"><img src="include/images/blank.gif" width="1" height="1" border="0" alt=""></td>
                      </tr>
                  </table></td>
                  <? } ?>
                  <? 
						if ((isset($_GET['menu_no_top'])) && ($_GET['menu_no_top']=="hr") && $arrRights['view']) {  
					?>
                  <td style="background-image : url(themes/beyondT/pictures/pictures/currentTab_left.png);" ></td>
                  <td style="padding-left:7px; background-image :url(themes/beyondT/pictures/nCurrentTab_left.gif);"></td>
                  <td><table cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #E5E5E5;">
                      <tr height="20">
                        <td style="background-image : url(themes/beyondT/pictures/nCurrentTab_left.gif);" ></td>
                        <td style="background-image : url(themes/beyondT/pictures/nCurrentTab_middle.gif);" class="currentTab" nowrap><a   class="currentTab"  href="./index.php?module=Home&menu_no=12&submenutop=home1&menu_no_top=hr" >PIM Module</a></td>
                        <td style="background-image : url(themes/beyondT/pictures/nCurrentTab_right.gif);"><img src="include/images/blank.gif" width="8" height="1" border="0" alt="Home"></td>
                        <td style="background-image : url(themes/beyondT/pictures/emptyTabSpace.png);"><img src="include/images/blank.gif" width="1" height="1" border="0" alt=""></td>
                      </tr>
                  </table></td>
                  <? } else { ?>
                  <td><table cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #E5E5E5;">
                      <tr height="20">
                        <td style="background-image : url(themes/beyondT/pictures/otherTab_left.png);" ><img src="include/images/blank.gif" width="8" height="1" border="0" alt="My Portal"></td>
                        <td style="background-image : url(themes/beyondT/pictures/otherTab_middle.png);" class="otherTab" nowrap><a   class="otherTab"  href="./index.php?module=Home&menu_no=12&submenutop=home1&menu_no_top=hr">PIM Module</a></td>
                        <td style="background-image : url(themes/beyondT/pictures/otherTab_right.png);"><img src="include/images/blank.gif" width="8" height="1" border="0" alt="My Portal"></td>
                        <td style="background-image : url(themes/beyondT/pictures/emptyTabSpace.png);"><img src="include/images/blank.gif" width="1" height="1" border="0" alt=""></td>
                      </tr>
                  </table></td>
                  <? } ?>
                  <? 
						if ((isset($_GET['menu_no_top'])) && ($_GET['menu_no_top']=="mt") && $arrRights['view']) {  
					?>
                  <td style="background-image : url(themes/beyondT/pictures/pictures/currentTab_left.png);" ></td>
                  <td style="padding-left:7px; background-image :url(themes/beyondT/pictures/nCurrentTab_left.gif);"></td>
                  <td><table cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #E5E5E5;">
                      <tr height="20">
                        <td style="background-image : url(themes/beyondT/pictures/nCurrentTab_left.gif);" ></td>
                        <td style="background-image : url(themes/beyondT/pictures/nCurrentTab_middle.gif);" class="currentTab" nowrap><a class="currentTab"  href="./index.php?module=Home&menu_no=1&submenutop=EIMModule&menu_no_top=mt" >Maintenance</a></td>
                        <td style="background-image : url(themes/beyondT/pictures/nCurrentTab_right.gif);"><img src="include/images/blank.gif" width="8" height="1" border="0" alt="Home"></td>
                        <td style="background-image : url(themes/beyondT/pictures/emptyTabSpace.png);"><img src="include/images/blank.gif" width="1" height="1" border="0" alt=""></td>
                      </tr>
                  </table></td>
                  <? } else { ?>
                  <td><table cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #E5E5E5;">
                      <tr height="20">
                        <td style="background-image : url(themes/beyondT/pictures/otherTab_left.png);" ><img src="include/images/blank.gif" width="8" height="1" border="0" alt="My Portal"></td>
                        <td style="background-image : url(themes/beyondT/pictures/otherTab_middle.png);" class="otherTab" nowrap><a   class="otherTab"  href="index.php?module=Home&menu_no=3&menu_no_top=mt">Maintenance</a></td>
                        <td style="background-image : url(themes/beyondT/pictures/otherTab_right.png);"><img src="include/images/blank.gif" width="8" height="1" border="0" alt="My Portal"></td>
                        <td style="background-image : url(themes/beyondT/pictures/emptyTabSpace.png);"><img src="include/images/blank.gif" width="1" height="1" border="0" alt=""></td>
                      </tr>
                  </table></td>
                  <? } ?>
                  <? 
						if ((isset($_GET['menu_no_top'])) && ($_GET['menu_no_top']=="bug")) {  
									
					?>
                  <td style="background-image : url(themes/beyondT/pictures/pictures/currentTab_left.png);" ></td>
                  <td style="padding-left:7px; background-image :url(themes/beyondT/pictures/nCurrentTab_left.gif);"></td>
                  <td><table cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #E5E5E5;">
                      <tr height="20">
                        <td style="background-image : url(themes/beyondT/pictures/nCurrentTab_left.gif);" ></td>
                        <td style="background-image : url(themes/beyondT/pictures/nCurrentTab_middle.gif);" class="currentTab" nowrap><a   class="currentTab"  href="./index.php?module=Home&menu_no=1&submenutop=EIMModule&menu_no_top=bug" >Bug Tracker</a></td>
                        <td style="background-image : url(themes/beyondT/pictures/nCurrentTab_right.gif);"><img src="include/images/blank.gif" width="8" height="1" border="0" alt="Home"></td>
                        <td style="background-image : url(themes/beyondT/pictures/emptyTabSpace.png);"><img src="include/images/blank.gif" width="1" height="1" border="0" alt=""></td>
                      </tr>
                  </table></td>
                  <? } else { ?>
                  <td><table cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #E5E5E5;">
                      <tr height="20">
                        <td style="background-image : url(themes/beyondT/pictures/otherTab_left.png);" ><img src="include/images/blank.gif" width="8" height="1" border="0" alt="My Portal"></td>
                        <td style="background-image : url(themes/beyondT/pictures/otherTab_middle.png);" class="otherTab" nowrap><a class="otherTab" href="index.php?module=Home&menu_no=1&submenutop=EIMModule&menu_no_top=bug">Bug Tracker</a></td>
                        <td style="background-image : url(themes/beyondT/pictures/otherTab_right.png);"><img src="include/images/blank.gif" width="8" height="1" border="0" alt="My Portal"></td>
                        <td style="background-image : url(themes/beyondT/pictures/emptyTabSpace.png);"><img src="include/images/blank.gif" width="1" height="1" border="0" alt=""></td>
                      </tr>
                  </table></td>
                  <? } ?>
                  <td width="100%" style="background-image : url(themes/beyondT/pictures/emptyTabSpace.png);"><img src="include/images/blank.gif" width="1" height="1" border="0" alt=""></td>
                </tr>
            </table></td>
          </tr>
          <tr height="20">
            <input type="hidden" name="action" value="UnifiedSearch">
            <input type="hidden" name="module" value="Home">
            <input type="hidden" name="search_form" value="false">
            <td class="subTabBar" colspan="2"><table width="100%" cellspacing="0" cellpadding="0" border="0" height="20">
                <tr>
                  <td class="welcome" width="100%">Welcome <?=(isset($_SESSION['fname'])) ? $_SESSION['fname'] : '' ?></td>
                  <td class="search" align="right"><a href="./index.php?ACT=logout"><strong>Logout</strong></a></td>
                  <td class="search" style="padding: 0px" align="right" width="11"><img src="themes/beyondT/pictures/nSearchSeparator.gif" width="12" height="20" border="0" alt="Search"></td>
                  <td class="search" style="padding: 0px" align="right">&nbsp;</td>
                  <td class="search" nowrap>&nbsp;&nbsp; </td>
                </tr>
            </table></td>
          </tr>
        </table>        
      </table>
	  <table border="0" align="top" cellpadding="0" cellspacing="0">
          <tr>
            <td width="200" valign="top"><!-- Rollover buttons -->
              <TABLE cellSpacing=0 cellPadding=0 border=0>
                <TBODY>
                  <TR vAlign=top>
<?			if ((isset($_GET['menu_no_top'])) && ($_GET['menu_no_top']=="eim") && $arrRights['view']) {  ?>
                    <TD width=158><P><A onmouseover="swapImage('Button1','','themes/beyondT/pictures/buttons01_on.gif',1);ypSlideOutMenu.showMenu('menu1');" onmouseout="swapImgRestore();ypSlideOutMenu.hideMenu('menu1');"> <IMG height=22 src="themes/beyondT/pictures/buttons01.gif" width=150 border=0 name=Button1></A><BR>
                        <A onmouseover="swapImage('Button2','','themes/beyondT/pictures/buttons02_on.gif',1);ypSlideOutMenu.showMenu('menu2');" onmouseout="swapImgRestore();ypSlideOutMenu.hideMenu('menu2');"> <IMG height=22 src="themes/beyondT/pictures/buttons02.gif" width=150 border=0 name=Button2></A><BR>
                        <A onmouseover="swapImage('Button3','','themes/beyondT/pictures/buttons03_on.gif',1);ypSlideOutMenu.showMenu('menu3');" onmouseout="swapImgRestore();ypSlideOutMenu.hideMenu('menu3');"> <IMG height=22 src="themes/beyondT/pictures/buttons03.gif" width=150 border=0 name=Button3></A><BR>
                        <A onmouseover="swapImage('Button4','','themes/beyondT/pictures/buttons04_on.gif',1);ypSlideOutMenu.showMenu('menu4');" onmouseout="swapImgRestore();ypSlideOutMenu.hideMenu('menu4');"> <IMG height=22 src="themes/beyondT/pictures/buttons04.gif" width=150 border=0 name=Button4></A><BR>
                        <A onmouseover="swapImage('Button5','','themes/beyondT/pictures/buttons05_on.gif',1);ypSlideOutMenu.showMenu('menu5');" onmouseout="swapImgRestore();ypSlideOutMenu.hideMenu('menu5');"> <IMG height=22 src="themes/beyondT/pictures/buttons05.gif" width=150 border=0 name=Button5></A><BR>
                        <A onmouseover="swapImage('Button6','','themes/beyondT/pictures/buttons06_on.gif',1);ypSlideOutMenu.showMenu('menu6');" onmouseout="swapImgRestore();ypSlideOutMenu.hideMenu('menu6');"> <IMG height=22 src="themes/beyondT/pictures/buttons06.gif" width=150 border=0 name=Button6></A><BR>
                        <A onmouseover="swapImage('Button7','','themes/beyondT/pictures/buttons07_on.gif',1);ypSlideOutMenu.showMenu('menu7');" onmouseout="swapImgRestore();ypSlideOutMenu.hideMenu('menu7');"> <IMG height=22 src="themes/beyondT/pictures/buttons07.gif" width=150 border=0 name=Button7></A><BR>
                        <A onmouseover="swapImage('Button8','','themes/beyondT/pictures/buttons08_on.gif',1);ypSlideOutMenu.showMenu('menu8');" onmouseout="swapImgRestore();ypSlideOutMenu.hideMenu('menu8');"> <IMG height=22 src="themes/beyondT/pictures/buttons08.gif" width=150 border=0 name=Button8></A><BR>
                        <A onmouseover="swapImage('Button9','','themes/beyondT/pictures/buttons09_on.gif',1);ypSlideOutMenu.showMenu('menu9');" onmouseout="swapImgRestore();ypSlideOutMenu.hideMenu('menu9');"> <IMG height=22 src="themes/beyondT/pictures/buttons09.gif" width=150 border=0 name=Button9></A><BR>
                        <A onmouseover="swapImage('Button10','','themes/beyondT/pictures/buttons10_on.gif',1);ypSlideOutMenu.showMenu('menu10');" onmouseout="swapImgRestore();ypSlideOutMenu.hideMenu('menu10');"> <IMG height=22 src="themes/beyondT/pictures/buttons10.gif" width=150 border=0 name=Button10></A><BR>
                        <A onmouseover="swapImage('Button11','','themes/beyondT/pictures/buttons11_on.gif',1);ypSlideOutMenu.showMenu('menu11');" onmouseout="swapImgRestore();ypSlideOutMenu.hideMenu('menu11');"> <IMG height=22 src="themes/beyondT/pictures/buttons11.gif" width=150 border=0 name=Button11></A><BR>
                      </P></TD>
<?			} elseif ((isset($_GET['menu_no_top'])) && ($_GET['menu_no_top']=="hr") && $arrRights['view']) {  ?>
                    <TD width=158><P>
                    	<A href="index.php?reqcode=EMP&menu_no=1&submenutop=HR&menu_no_top=hr" onmouseover="swapImage('Button1','','themes/beyondT/pictures/buttons21_on.gif',1);" onmouseout="swapImgRestore();"> <IMG height=22 src="themes/beyondT/pictures/buttons21.gif" width=150 border=0 name=Button1></A><BR>
                        <A href="index.php?reqcode=QUA&menu_no=1&submenutop=HR&menu_no_top=hr" onmouseover="swapImage('Button2','','themes/beyondT/pictures/buttons03_on.gif',1);" onmouseout="swapImgRestore();"> <IMG height=22 src="themes/beyondT/pictures/buttons03.gif" width=150 border=0 name=Button2></A><BR>
                        <A href="index.php?reqcode=EXP&menu_no=1&submenutop=HR&menu_no_top=hr" onmouseover="swapImage('Button3','','themes/beyondT/pictures/buttons12_on.gif',1);" onmouseout="swapImgRestore();"> <IMG height=22 src="themes/beyondT/pictures/buttons12.gif" width=150 border=0 name=Button3></A><BR>
                        <A href="index.php?reqcode=MEM&menu_no=1&submenutop=HR&menu_no_top=hr" onmouseover="swapImage('Button4','','themes/beyondT/pictures/buttons04_on.gif',1);" onmouseout="swapImgRestore();"> <IMG height=22 src="themes/beyondT/pictures/buttons04.gif" width=150 border=0 name=Button4></A><BR>
                        <A href="index.php?reqcode=CBN&menu_no=1&submenutop=HR&menu_no_top=hr" onmouseover="swapImage('Button5','','themes/beyondT/pictures/buttons13_on.gif',1);" onmouseout="swapImgRestore();"> <IMG height=22 src="themes/beyondT/pictures/buttons13.gif" width=150 border=0 name=Button5></A><BR>
                        <A href="index.php?reqcode=NBN&menu_no=1&submenutop=HR&menu_no_top=hr" onmouseover="swapImage('Button6','','themes/beyondT/pictures/buttons14_on.gif',1);" onmouseout="swapImgRestore();"> <IMG height=22 src="themes/beyondT/pictures/buttons14.gif" width=150 border=0 name=Button6></A><BR>
                        <A href="index.php?reqcode=JSP&menu_no=1&submenutop=HR&menu_no_top=hr" onmouseover="swapImage('Button7','','themes/beyondT/pictures/buttons15_on.gif',1);" onmouseout="swapImgRestore();"> <IMG height=22 src="themes/beyondT/pictures/buttons15.gif" width=150 border=0 name=Button7></A><BR>
                        <A href="index.php?reqcode=SAL&menu_no=1&submenutop=HR&menu_no_top=hr" onmouseover="swapImage('Button8','','themes/beyondT/pictures/buttons16_on.gif',1);" onmouseout="swapImgRestore();"> <IMG height=22 src="themes/beyondT/pictures/buttons16.gif" width=150 border=0 name=Button8></A><BR>
                        <A href="index.php?reqcode=LAN&menu_no=1&submenutop=HR&menu_no_top=hr" onmouseover="swapImage('Button9','','themes/beyondT/pictures/buttons17_on.gif',1);" onmouseout="swapImgRestore();"> <IMG height=22 src="themes/beyondT/pictures/buttons17.gif" width=150 border=0 name=Button9></A><BR>
                        <A href="index.php?reqcode=EXC&menu_no=1&submenutop=HR&menu_no_top=hr" onmouseover="swapImage('Button10','','themes/beyondT/pictures/buttons18_on.gif',1);" onmouseout="swapImgRestore();"> <IMG height=22 src="themes/beyondT/pictures/buttons18.gif" width=150 border=0 name=Button10></A><BR>
                        <A href="index.php?reqcode=CXT&menu_no=1&submenutop=HR&menu_no_top=hr" onmouseover="swapImage('Button11','','themes/beyondT/pictures/buttons19_on.gif',1);" onmouseout="swapImgRestore();"> <IMG height=22 src="themes/beyondT/pictures/buttons19.gif" width=150 border=0 name=Button11></A><BR>
                      </P></TD>
<?			} elseif ((isset($_GET['menu_no_top'])) && ($_GET['menu_no_top']=="mt") && $arrRights['view']) {  ?>
                    <TD width=158><P>
                    	<A href="index.php?bugcode=USR&menu_no=1&submenutop=HR&menu_no_top=mt" onmouseover="swapImage('Button1','','themes/beyondT/pictures/buttons22_on.gif',1);" onmouseout="swapImgRestore();"> <IMG height=22 src="themes/beyondT/pictures/buttons22.gif" width=150 border=0 name=Button1></A><BR>
                    	<A href="index.php?bugcode=USG&menu_no=1&submenutop=BR&menu_no_top=mt" onmouseover="swapImage('Button2','','themes/beyondT/pictures/buttons23_on.gif',1);" onmouseout="swapImgRestore();"> <IMG height=22 src="themes/beyondT/pictures/buttons23.gif" width=150 border=0 name=Button2></A><BR>
                    	<A href="index.php?bugcode=MOD&menu_no=1&submenutop=BR&menu_no_top=mt" onmouseover="swapImage('Button3','','themes/beyondT/pictures/buttons24_on.gif',1);" onmouseout="swapImgRestore();"> <IMG height=22 src="themes/beyondT/pictures/buttons24.gif" width=150 border=0 name=Button3></A><BR>
                    	<A href="index.php?bugcode=VER&menu_no=1&submenutop=BR&menu_no_top=mt" onmouseover="swapImage('Button4','','themes/beyondT/pictures/buttons25_on.gif',1);" onmouseout="swapImgRestore();"> <IMG height=22 src="themes/beyondT/pictures/buttons25.gif" width=150 border=0 name=Button4></A><BR>
                    	<A href="index.php?bugcode=DVR&menu_no=1&submenutop=BR&menu_no_top=mt" onmouseover="swapImage('Button5','','themes/beyondT/pictures/buttons26_on.gif',1);" onmouseout="swapImgRestore();"> <IMG height=22 src="themes/beyondT/pictures/buttons26.gif" width=150 border=0 name=Button5></A><BR>
                    	<A href="index.php?bugcode=FVR&menu_no=1&submenutop=BR&menu_no_top=mt" onmouseover="swapImage('Button6','','themes/beyondT/pictures/buttons27_on.gif',1);" onmouseout="swapImgRestore();"> <IMG height=22 src="themes/beyondT/pictures/buttons27.gif" width=150 border=0 name=Button6></A><BR>
                      </P></TD>
<?			} elseif ((isset($_GET['menu_no_top'])) && ($_GET['menu_no_top']=="bug")) {  ?>
                    <TD height="800" bgcolor="#FFB121" width=158><p><br>
                    </p></TD>
<? } ?>                   
                </TR>
                </TBODY>
              </TABLE>
              <!-- End Rollover buttons -->
              <!--------------------- Menu start --------------------->
              <!-- Begin SubMenu1 -->
              <DIV id=menu1Container>
                <DIV id=menu1Content>
                  <TABLE cellSpacing=0 cellPadding=0 width=142 border=0>
                    <TBODY>
                      <TR>
                        <TD onmouseover="ypSlideOutMenu.showMenu('menu1')" onmouseout="ypSlideOutMenu.hideMenu('menu1')" vAlign=center align=left width=142 height=17><A class="rollmenu" href="index.php?uniqcode=DEF&menu_no=1&submenutop=EIMModule&menu_no_top=eim">Hierarchy Definition</A></TD>
                      </TR>
                      <TR>
                        <TD onmouseover="ypSlideOutMenu.showMenu('menu1')" onmouseout="ypSlideOutMenu.hideMenu('menu1')" vAlign=center align=left width=142 height=17><A class="rollmenu" href="index.php?uniqcode=CHI&menu_no=1&submenutop=EIMModule&menu_no_top=eim">Company Hierarchy</A></TD>
                      </TR>
                      <TR>
                        <TD onmouseover="ypSlideOutMenu.showMenu('menu1')" onmouseout="ypSlideOutMenu.hideMenu('menu1')" vAlign=center align=left width=142 height=17><A href="index.php?uniqcode=COS&menu_no=1&submenutop=EIMModule&menu_no_top=eim" class="rollmenu">Cost Centers</A></TD>
                      </TR>
                      <TR>
                        <TD onmouseover="ypSlideOutMenu.showMenu('menu1')" onmouseout="ypSlideOutMenu.hideMenu('menu1')" vAlign=center align=left width=142 height=17><A class="rollmenu" href="index.php?uniqcode=LOC&menu_no=1&submenutop=EIMModule&menu_no_top=eim">Locations</A></TD>
                      </TR>									
                    </TBODY>
                  </TABLE>
                </DIV>
              </DIV>
              <!-- End SubMenu1 -->
              <!-- Begin SubMenu2 -->
              <DIV id=menu2Container>
                <DIV id=menu2Content>
                  <TABLE cellSpacing=0 cellPadding=0 width=142 border=0>
                    <TBODY>
                      <TR>
                        <TD width=142 height=17 align=left vAlign=center class="#menuhead" id="menuhead" onmouseover="ypSlideOutMenu.showMenu('menu2')" onmouseout="ypSlideOutMenu.hideMenu('menu2')"> Job Information</TD>
                      </TR>
                      <TR>
                        <TD onmouseover="ypSlideOutMenu.showMenu('menu2')" onmouseout="ypSlideOutMenu.hideMenu('menu2')" vAlign=center align=left width=142 height=17><A class="rollmenu" href="index.php?uniqcode=SGR&menu_no=2&submenutop=EIMModule&menu_no_top=eim">Salary Grade</A></TD>
                      </TR>
                      <TR>
                        <TD onmouseover="ypSlideOutMenu.showMenu('menu2');ypSlideOutMenu.showMenu('menu21')" onmouseout="ypSlideOutMenu.hideMenu('menu2');ypSlideOutMenu.hideMenu('menu21')" vAlign=center align=left width=142 height=17><A class="rollmenu" href="index.php?uniqcode=CTT&menu_no=2&submenutop=EIMModule&menu_no_top=eim">Corporate Titles</A></TD>
                      </TR>
                      <TR>
                        <TD onmouseover="ypSlideOutMenu.showMenu('menu2')" onmouseout="ypSlideOutMenu.hideMenu('menu2')" vAlign=center align=left width=142 height=17><A class="rollmenu" href="index.php?uniqcode=DSG&menu_no=2&submenutop=EIMModule&menu_no_top=eim">Designations</A></TD>
                      </TR>
                      <TR>
                        <TD onmouseover="ypSlideOutMenu.showMenu('menu2')" onmouseout="ypSlideOutMenu.hideMenu('menu2')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=CUR&menu_no=2&submenutop=EIMModule&menu_no_top=eim">Currency Types</A></TD>
                      </TR>
                      <TR>
                        <TD width=142 height=17 align=left vAlign=center class=#menuhead id="menuhead" onmouseover="ypSlideOutMenu.showMenu('menu2')" onmouseout="ypSlideOutMenu.hideMenu('menu2')">Job Profile</TD>
                      </TR>
                      <TR>
                        <TD onmouseover="ypSlideOutMenu.showMenu('menu2')" onmouseout="ypSlideOutMenu.hideMenu('menu2')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=JDC&menu_no=2&submenutop=EIMModule&menu_no_top=eim">JD Category</A></TD>
                      </TR>
                      <TR>
                        <TD onmouseover="ypSlideOutMenu.showMenu('menu2');ypSlideOutMenu.showMenu('menu21')" onmouseout="ypSlideOutMenu.hideMenu('menu2');ypSlideOutMenu.hideMenu('menu21')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=JDT&menu_no=2&submenutop=EIMModule&menu_no_top=eim">JD Types</A></TD>
                      </TR>
                      <TR>
                        <TD onmouseover="ypSlideOutMenu.showMenu('menu2')" onmouseout="ypSlideOutMenu.hideMenu('menu2')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=JDK&menu_no=2&submenutop=EIMModule&menu_no_top=eim">JD Key result Area</A> </TD>
                      </TR>
                      <TR>
                        <TD width=142 height=17 align=left vAlign=center class=#menuhead id="menuhead" onmouseover="ypSlideOutMenu.showMenu('menu2')" onmouseout="ypSlideOutMenu.hideMenu('menu2')">Designation Profile</TD>
                      </TR>
                      <TR>
                        <TD onmouseover="ypSlideOutMenu.showMenu('menu2')" onmouseout="ypSlideOutMenu.hideMenu('menu2')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=DDI&menu_no=2&submenutop=EIMModule&menu_no_top=eim">Designation Description</A></TD>
                      </TR>
                      <TR>
                        <TD onmouseover="ypSlideOutMenu.showMenu('menu2');ypSlideOutMenu.showMenu('menu21')" onmouseout="ypSlideOutMenu.hideMenu('menu2');ypSlideOutMenu.hideMenu('menu21')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=DQA&menu_no=2&submenutop=EIMModule&menu_no_top=eim">Designation Qualification</A></TD>
                      </TR>
                      <!--<TR>
                        <TD onmouseover="ypSlideOutMenu.showMenu('menu2')" onmouseout="ypSlideOutMenu.hideMenu('menu2')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?module=dsgworkview&group=admin/eimadmin&menu_no=2&submenutop=EIMModule&menu_no_top=eim">Designation Work Experience</A></TD>
                      </TR>-->
                    </TBODY>
                  </TABLE>
                </DIV>
              </DIV>
              <!-- End SubMenu2  -->
              <!-- Begin SubMenu3 -->
              <DIV id=menu3Container>
                <DIV id=menu3Content>
                  <TABLE cellSpacing=0 cellPadding=0 width=142 border=0>
                    <TBODY>
                    <TD onmouseover="ypSlideOutMenu.showMenu('menu3')" onmouseout="ypSlideOutMenu.hideMenu('menu3')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=QLF&menu_no=3&submenutop=EIMModule&menu_no_top=eim">Qualification Types</A></TD>
                    </TR>
                    <TR>
                      <TD onmouseover="ypSlideOutMenu.showMenu('menu3')" onmouseout="ypSlideOutMenu.hideMenu('menu3')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=QQL&menu_no=3&submenutop=EIMModule&menu_no_top=eim">Qualifications</A> </TD>
                    </TR>
                    <TR>
                      <TD onmouseover="ypSlideOutMenu.showMenu('menu3')" onmouseout="ypSlideOutMenu.hideMenu('menu3')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=RTM&menu_no=3&submenutop=EIMModule&menu_no_top=eim">Rating Methods</A></TD>
                    </TR>
                    <TR>
                      <TD onmouseover="ypSlideOutMenu.showMenu('menu3')" onmouseout="ypSlideOutMenu.hideMenu('menu3')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=SBJ&menu_no=3&submenutop=EIMModule&menu_no_top=eim">Subjects</A></TD>
                    </TR>
                    <TR>
                      <TD onmouseover="ypSlideOutMenu.showMenu('menu3')" onmouseout="ypSlideOutMenu.hideMenu('menu3')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=SKI&menu_no=3&submenutop=EIMModule&menu_no_top=eim">Skills</A></TD>
                    </TR>
                    <TR>
                      <TD onmouseover="ypSlideOutMenu.showMenu('menu3')" onmouseout="ypSlideOutMenu.hideMenu('menu3')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=LAN&menu_no=3&submenutop=EIMModule&menu_no_top=eim">Languages</A></TD>
                    </TR>
                    <TR>
                      <TD onmouseover="ypSlideOutMenu.showMenu('menu3')" onmouseout="ypSlideOutMenu.hideMenu('menu3')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=SSK&menu_no=3&submenutop=EIMModule&menu_no_top=eim">Sub Skills</A></TD>
                    </TR>
                    <TR>
                      <TD onmouseover="ypSlideOutMenu.showMenu('menu3')" onmouseout="ypSlideOutMenu.hideMenu('menu3')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=EXC&menu_no=3&submenutop=EIMModule&menu_no_top=eim">Extra Curricular Activity Category</A></TD>
                    </TR>
                    <TR>
                      <TD onmouseover="ypSlideOutMenu.showMenu('menu3')" onmouseout="ypSlideOutMenu.hideMenu('menu3')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=EXA&menu_no=3&submenutop=EIMModule&menu_no_top=eim">Extra Curricular Activity Type</A></TD>
                    </TR>
                    </TBODY>
                    
                  </TABLE>
                </DIV>
              </DIV>
              <!-- End SubMenu3 -->
              <!-- Begin SubMenu4 -->
              <DIV id=menu4Container>
                <DIV id=menu4Content>
                  <TABLE cellSpacing=0 cellPadding=0 width=142 border=0>
                    <TBODY>
                      <TR>
                        <TD onmouseover="ypSlideOutMenu.showMenu('menu4')" onmouseout="ypSlideOutMenu.hideMenu('menu4')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=MEM&menu_no=4&submenutop=EIMModule&menu_no_top=eim">Membership Types</A></TD>
                      </TR>
                      <TR>
                        <TD onmouseover="ypSlideOutMenu.showMenu('menu4')" onmouseout="ypSlideOutMenu.hideMenu('menu4')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=MME&menu_no=4&submenutop=EIMModule&menu_no_top=eim">Memberships</A></TD>
                      </TR>
                    </TBODY>
                  </TABLE>
                </DIV>
              </DIV>
              <!-- End SubMenu4 -->
              <!-- Begin SubMenu5 -->
              <DIV id=menu5Container>
                <DIV id=menu5Content>
                  <TABLE cellSpacing=0 cellPadding=0 width=142 border=0>
                    <TBODY>
                      <TR>
                        <TD onmouseover="ypSlideOutMenu.showMenu('menu5')" onmouseout="ypSlideOutMenu.hideMenu('menu5')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=BNK&menu_no=5&submenutop=EIMModule&menu_no_top=eim">Banks</A></TD>
                      </TR>
                      <TR>
                        <TD onmouseover="ypSlideOutMenu.showMenu('menu5')" onmouseout="ypSlideOutMenu.hideMenu('menu5')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=BCH&menu_no=5&submenutop=EIMModule&menu_no_top=eim">Branches</A></TD>
                      </TR>
                    </TBODY>
                  </TABLE>
                </DIV>
              </DIV>
              <!-- End SubMenu5 -->
              <!-- Begin SubMenu6 -->
              <DIV id=menu6Container>
                <DIV id=menu6Content>
                  <TABLE cellSpacing=0 cellPadding=0 width=142 border=0>
                    <TBODY>
                    <TD onmouseover="ypSlideOutMenu.showMenu('menu6')" onmouseout="ypSlideOutMenu.hideMenu('menu6')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=CCB&menu_no=6&submenutop=EIMModule&menu_no_top=eim">Cash Benefits</A></TD>
                    </TR>
                    <TR>
                      <TD onmouseover="ypSlideOutMenu.showMenu('menu6')" onmouseout="ypSlideOutMenu.hideMenu('menu6')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=NCB&menu_no=6&submenutop=EIMModule&menu_no_top=eim">Non-Cash Benefits</A> </TD>
                    </TR>
                    <TR>
                      <TD onmouseover="ypSlideOutMenu.showMenu('menu6')" onmouseout="ypSlideOutMenu.hideMenu('menu6')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=UNI&menu_no=6&submenutop=EIMModule&menu_no_top=eim">Uniform Types</A> </TD>
                    </TR>
                    <TR>
                      <TD onmouseover="ypSlideOutMenu.showMenu('menu6')" onmouseout="ypSlideOutMenu.hideMenu('menu6')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=BBS&menu_no=6&submenutop=EIMModule&menu_no_top=eim">Cash Benefits Assigned to Salary &nbsp;Grade</A></TD>
                    </TR>
                    <TR>
                      <TD onmouseover="ypSlideOutMenu.showMenu('menu6')" onmouseout="ypSlideOutMenu.hideMenu('menu6')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=NBS&menu_no=6&submenutop=EIMModule&menu_no_top=eim">Non - Cash Benefits Assigned to Salary &nbsp;Grade</A> </TD>
                    </TR>
                    </TBODY>
                    
                  </TABLE>
                </DIV>
              </DIV>
              <!-- End SubMenu7 -->
              <!-- Begin SubMenu7 -->
              <DIV id=menu7Container>
                <DIV id=menu7Content>
                  <TABLE cellSpacing=0 cellPadding=0 width=142 border=0>
                    <TBODY>
                    <TD onmouseover="ypSlideOutMenu.showMenu('menu7')" onmouseout="ypSlideOutMenu.hideMenu('menu7')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=ETY&menu_no=7&submenutop=EIMModule&menu_no_top=eim">Employee Type</A></TD>
                    </TR>
                    <TR>
                      <TD onmouseover="ypSlideOutMenu.showMenu('menu7')" onmouseout="ypSlideOutMenu.hideMenu('menu7')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=SAT&menu_no=7&submenutop=EIMModule&menu_no_top=eim">Statutory Classification</A></TD>
                    </TR>
                    <TR>
                      <TD onmouseover="ypSlideOutMenu.showMenu('menu7')" onmouseout="ypSlideOutMenu.hideMenu('menu7')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=EMC&menu_no=7&submenutop=EIMModule&menu_no_top=eim">Employee Category</A></TD>
                    </TR>
                    <TR>
                      <TD onmouseover="ypSlideOutMenu.showMenu('menu7')" onmouseout="ypSlideOutMenu.hideMenu('menu7')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=EMG&menu_no=7&submenutop=EIMModule&menu_no_top=eim">Employee Groups</A></TD>
                    </TR>
                    </TBODY>
                  </TABLE>
                </DIV>
              </DIV>
              <!-- End SubMenu7 -->
              <!-- Begin SubMenu8 -->
              <DIV id=menu8Container>
                <DIV id=menu8Content>
                  <TABLE cellSpacing=0 cellPadding=0 width=142 border=0>
                    <TBODY>
                      <TR>
                        <TD onmouseover="ypSlideOutMenu.showMenu('menu8')" onmouseout="ypSlideOutMenu.hideMenu('menu8')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=RTE&menu_no=8&submenutop=EIMModule&menu_no_top=eim">Route Information</A></TD>
                      </TR>
                      <TR>
                        <TD onmouseover="ypSlideOutMenu.showMenu('menu8')" onmouseout="ypSlideOutMenu.hideMenu('menu8')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=DWT&menu_no=8&submenutop=EIMModule&menu_no_top=eim">Dwelling Type</A></TD>
                      </TR>
                    </TBODY>
                  </TABLE>
                </DIV>
              </DIV>
              <!-- End SubMenu8 -->
              <!-- Begin SubMenu9 -->
              <DIV id=menu9Container>
                <DIV id=menu9Content>
                  <TABLE cellSpacing=0 cellPadding=0 width=142 border=0>
                    <TBODY>
                      <TR>
                        <TD onmouseover="ypSlideOutMenu.showMenu('menu9')" onmouseout="ypSlideOutMenu.hideMenu('menu9')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=NAT&submenutop=EIMModule&menu_no_top=eim">Nationalities</A></TD>
                      </TR>
                      <TR>
                        <TD onmouseover="ypSlideOutMenu.showMenu('menu9')" onmouseout="ypSlideOutMenu.hideMenu('menu9')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=RLG&menu_no=9&submenutop=EIMModule&menu_no_top=eim">Religions</A></TD>
                      </TR>
                    </TBODY>
                  </TABLE>
                </DIV>
              </DIV>
              <!-- End SubMenu9 -->
              <!-- Begin SubMenu10 -->
              <DIV id=menu10Container>
                <DIV id=menu10Content>
                  <TABLE cellSpacing=0 cellPadding=0 width=142 border=0>
                    <TBODY>
                    <TD onmouseover="ypSlideOutMenu.showMenu('menu10')" onmouseout="ypSlideOutMenu.hideMenu('menu10')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=COU&menu_no=10&submenutop=EIMModule&menu_no_top=eim">Country</A></TD>
                    </TR>
                    <TR>
                      <TD onmouseover="ypSlideOutMenu.showMenu('menu10')" onmouseout="ypSlideOutMenu.hideMenu('menu10')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=PRO&menu_no=10&submenutop=EIMModule&menu_no_top=eim">State</A></TD>
                    </TR>
                    <TR>
                      <TD onmouseover="ypSlideOutMenu.showMenu('menu10')" onmouseout="ypSlideOutMenu.hideMenu('menu10')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=DIS&menu_no=10&submenutop=EIMModule&menu_no_top=eim">County</A></TD>
                    </TR>
                    <TR>
                      <TD onmouseover="ypSlideOutMenu.showMenu('menu10')" onmouseout="ypSlideOutMenu.hideMenu('menu10')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=ELE&menu_no=10&submenutop=EIMModule&menu_no_top=eim">Electorate</A></TD>
                    </TR>
                    </TBODY>
                    
                  </TABLE>
                </DIV>
              </DIV>
              <!-- End SubMenu10 -->
              <!-- Begin SubMenu11 -->
              <DIV id=menu11Container>
                <DIV id=menu11Content>
                  <TABLE cellSpacing=0 cellPadding=0 width=142 border=0>
                    <TBODY>
                      <TR>
                        <TD onmouseover="ypSlideOutMenu.showMenu('menu11')" onmouseout="ypSlideOutMenu.hideMenu('menu11')" vAlign=center align=left width=142 height=17><A class=rollmenu href="index.php?uniqcode=TAX&menu_no=11&submenutop=EIMModule&menu_no_top=eim">Define Tax</A></TD>
                      </TR>
                    </TBODY>
                  </TABLE>
                </DIV>
              </DIV>
              <!-- End SubMenu11 -->
              <!--------------------- End Menu --------------------->
            </td>
<?			if ((isset($_GET['menu_no_top'])) && ($_GET['menu_no_top']=="home")) {  ?>
			<tr>
			<td>
              <iframe src="home.html" name="rightMenu" width="100%" height="600" frameborder="0"> </iframe>
			</td>
			</tr>
<?			}   ?>
            <td width="779" valign="top"><table width='100%' cellpadding='0' cellspacing='0' border='0' class='moduleTitle'>
              <tr>
                <td>
            <td width="78%" valign="top">
<?			if ((isset($_GET['menu_no_top'])) && ($_GET['menu_no_top']=="eim") && $arrRights['view']) {  ?>
              <iframe src="view.php?uniqcode=<?=(isset($_GET['uniqcode'])) ? $_GET['uniqcode'] : 'DEF'?>" name="rightMenu" width="100%" height="600" frameborder="0"> </iframe>
<?			} elseif ((isset($_GET['menu_no_top'])) && ($_GET['menu_no_top']=="hr") && $arrRights['view']) {  ?>
              <iframe src="empview.php?reqcode=<?=(isset($_GET['reqcode'])) ? $_GET['reqcode'] : 'EMP'?>" name="rightMenu" width="100%" height="800" frameborder="0"> </iframe>
<?			} elseif ((isset($_GET['menu_no_top'])) && ($_GET['menu_no_top']=="mt") && $arrRights['view']) {  ?>
              <iframe src="bugview.php?bugcode=<?=(isset($_GET['bugcode'])) ? $_GET['bugcode'] : 'USR'?>" name="rightMenu" width="100%" height="800" frameborder="0"> </iframe>
<?			} elseif ((isset($_GET['menu_no_top'])) && ($_GET['menu_no_top']=="bug")) {  ?>
              <iframe src="bugview.php?bugcode=BUG" name="rightMenu" width="100%" height="800" frameborder="0"> </iframe>
         <? } ?>
              
            </td>
          </tr>
</table>
</body>
</html>
