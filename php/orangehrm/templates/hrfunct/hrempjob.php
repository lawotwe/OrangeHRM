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
?>
<?php
if ($locRights['edit']) {
    $saveLocBtnAction= "assignLocation()";
} else {
    $saveLocBtnAction="showAccessDeniedMsg()";
}
$picDir = '../../themes/'.$styleSheet.'/pictures/';
$iconDir = '../../themes/'.$styleSheet.'/icons/';

?>
<script type="text/javascript"><!--//--><![CDATA[//><!--

   var locationNames = new Array();
<?php
    $assignedList = $this->popArr['assignedlocationList'];
    foreach($assignedList as $empLoc) {
        print "\tlocationNames['{$empLoc->getLocation()}'] = \"" . stripslashes($empLoc->getLocationName()) . "\";\n";
    }

    $availableList = $this->popArr['availablelocationList'];
    foreach($availableList as $loc) {
        print "\tlocationNames['{$loc[0]}'] = \"" . stripslashes($loc[1]) . "\";\n";
    }

?>

	function returnLocDet(){
		var popup=window.open('CentralController.php?uniqcode=CST&VIEW=MAIN&esp=1','Locations','height=450,resizable=1,scrollbars=1');
        if(!popup.opener) popup.opener=self;
	}

    function toggleEmployeeJobHistory() {
        oLayer = document.getElementById("employeeJobHistoryLayer");
        oLink = document.getElementById("toggleJobHistoryLayerLink");

        if (oLayer.style.display == 'none') {
            oLayer.style.display = 'block';
        } else {
            oLayer.style.display = 'none';
        }
        toggleEmployeeJobHistoryText();
    }

    function toggleEmployeeJobHistoryText() {
        oLayer = document.getElementById("employeeJobHistoryLayer");
        oLink = document.getElementById("toggleJobHistoryLayerLink");

        if (oLayer.style.display == 'none') {
            oLink.innerHTML = "<?php echo $lang_hremp_ShowEmployeeJobHistory; ?>";
        } else {
            oLink.innerHTML = "<?php echo $lang_hremp_HideEmployeeJobHistory; ?>";
        }
    }

	function toggleEmployeeContracts() {
		oLayer = document.getElementById("employeeContractLayer");
		oLink = document.getElementById("toggleContractLayerLink");

		if (oLayer.style.display == 'none') {
			oLayer.style.display = 'block';
		} else {
			oLayer.style.display = 'none';
		}
		toggleEmployeeContractsText();
	}

	function toggleEmployeeContractsText() {
		oLayer = document.getElementById("employeeContractLayer");
		oLink = document.getElementById("toggleContractLayerLink");

		if (oLayer.style.display == 'none') {
			oLink.innerHTML = "<?php echo $lang_hremp_ShowEmployeeContracts; ?>";
		} else {
			oLink.innerHTML = "<?php echo $lang_hremp_HideEmployeeContracts; ?>";
		}
	}

	function cmbTypeChanged()
	{
		empStatusCmb = document.getElementById("cmbType");

		if(empStatusCmb.value!='EST000')
		{
			obj = document.getElementById("tdTermDateDisc");
			obj.style['visibility']='hidden';
			obj = document.getElementById("tdTermDateValue");
			obj.style['visibility']='hidden';
			obj = document.getElementById("tdTermReasonDisc");
			obj.style['visibility']='hidden';
			obj = document.getElementById("tdTermReasonValue");
			obj.style['visibility']='hidden';
		}
		else
		{
			obj = document.getElementById("tdTermReasonDisc");
			obj.style['visibility']='visible';
			obj = document.getElementById("tdTermReasonValue");
			obj.style['visibility']='visible';
			obj = document.getElementById("tdTermDateDisc");
			obj.style['visibility']='visible';
			obj = document.getElementById("tdTermDateValue");
			obj.style['visibility']='visible';

			// Set terminated date to today (if empty)
			var termDate = document.getElementById("txtTermDate");
			if (termDate.value == YAHOO.OrangeHRM.calendar.formatHint.format) {
				today = new Date();
				termDate.value = formatDate(today, YAHOO.OrangeHRM.calendar.format);
			}

		}
	}

    /**
     * Show acccess denied message.
     */
    function showAccessDeniedMsg() {
        alert("<?php echo $lang_Error_AccessDenied; ?>")
    }

    /**
     * Run when the "add" button is clicked.
     * Shows the employee select fields
     */
    function toggleLocAddLayer() {
        var layer = document.getElementById("addLocationLayer");

        if (layer.style.display == 'block') {
            layer.style.display = 'none';
        } else {
            layer.style.display = 'block';
        }
    }

    /**
     * Run when the cancel button is pressed
     */
    function cancelLocEdit() {
        document.getElementById("addLocationLayer").style.display = 'none';
        //document.frmActivity.activityName.value = "";
        //document.frmActivity.activityId.value = "";
        addMode = true;
    }

    /**
     * Assign the location to the employee
     */
    function assignLocation() {
        var cmbLocation = $('cmbNewLocationId');

        if (cmbLocation.selectedIndex <= 0) {
            alert('<?php echo $lang_hremp_PleaseSelectALocationFirst;?>')
        } else {
            var location = cmbLocation.options[cmbLocation.selectedIndex].value;
            xajax_assignLocation(location);
            disableLocationLinks();
        }
    }

    /**
     * Assign the location to the employee
     */
    function deleteLocation(link, location) {
        xajax_removeLocation(location);
        disableLocationLinks();
    }

    /**
     * Run when a location has been assigned successfully
     * Removes location from select box and adds to assigned location list
     */
    function onLocationAssign(location) {
        var cmbLocation = $('cmbNewLocationId');

        // Remove location from select box
        var option = removeOption(cmbLocation, location);

        // add location to list
        var tbl = $('assignedLocationsTable');
        var lastRow = tbl.rows.length;
        var row = tbl.insertRow(lastRow);
        var leftCell = row.insertCell(0);
        var rightCell = row.insertCell(1);
        row.id = "locRow" + location;

        // Create location name
        var locationName = locationNames[location];
        var textNode = document.createTextNode(locationName);
        leftCell.appendChild(textNode);

        // creat location delete link
        var link = document.createElement('a');
        link.id = "locDelLink" + location;
        link.href = "javascript:deleteLocation(this, '" + location + "')";
        link.title = "<?php echo $lang_Admin_Users_delete;?>";
        var linkText = document.createTextNode('X');
        link.appendChild(linkText);

        rightCell.appendChild(link);
        rightCell.className = "locationDeleteChkBox";
    }

   /**
     * Run when a location has been removed successfully
     * Removes location from assigned list and adds to select box
     */
    function onLocationRemove(location) {

        // Remove location row
        var rowId = "locRow" + location;
        var row = $(rowId);

        var tbl = $('assignedLocationsTable');
        tbl.deleteRow(row.rowIndex);

        // Add location to select box
        var cmbLocation = $('cmbNewLocationId');

        var locationName = locationNames[location];
        var option = document.createElement('option');
        option.text = locationName;
        option.value = location;
        cmbLocation.options[cmbLocation.length] = option;
    }

    /**
     * Enable all location modify links
     */
    function enableLocationLinks() {
        enableLocationDeleteLinks();
        enableAssignLocationBtn();
    }

    /**
     * Disable all location modify links
     */
    function disableLocationLinks() {
        disableLocationDeleteLinks();
        disableAssignLocationBtn();
    }

    /**
     * Disable delete links
     */
    function disableLocationDeleteLinks() {
        var links = YAHOO.util.Dom.getElementsByClassName('locationDeleteLink');
        var numLinks = links.length;

        for(var i=0; i<numLinks;i++){
            links[i].href = "";
        }
    }

    /**
     * Enable delete links
     */
    function enableLocationDeleteLinks() {
        var links = YAHOO.util.Dom.getElementsByClassName('locationDeleteLink');
        var numLinks = links.length;

        for(var i=0; i<numLinks;i++) {
            var link = links[i];
            var location = link.id.replace("locDelLink", "");
            link.href = "javascript:deleteLocation(this, '" + location + "')";
        }
    }


    /**
     * Disable the assign location button
     */
    function disableAssignLocationBtn() {
        var btn = $('assignLocationButton');
        btn.attributes["onclick"].value  = "";
        btn.attributes["onmouseout"].value ="";
        btn.attributes["onmouseover"].value ="";
        btn.attributes["src"].value = "<?php echo $iconDir;?>assign.gif";
    }

    /**
     * Enable the assign location button
     */
    function enableAssignLocationBtn() {
        var btn = $('assignLocationButton');
        btn.attributes["onclick"].value  = "<?php echo $saveLocBtnAction; ?>;";
        btn.attributes["onmouseout"].value ="this.src='<?php echo $iconDir;?>assign.gif';";
        btn.attributes["onmouseover"].value ="this.src='<?php echo $iconDir;?>assign_o.gif';";
        btn.attributes["src"].value = "<?php echo $iconDir;?>assign.gif";
    }

    /**
     * Function run when job title selection is changed.
     */
     function onJobTitleChange(value) {
		document.getElementById('status').innerHTML = '<?php echo $lang_Commn_PleaseWait;?>....';
		//xajax_assEmpStat(value);
		xajax_fetchJobSpecInfo(value);
     }

//--><!]]></script>
<?php
    $edit1 = $this->popArr['editJobInfoArr'];
    $jobSpec = $this->popArr['jobSpec'];
    if (empty($jobSpec)) {
        $jobSpecName = '';
        $jobSpecDuties = '';
    } else {
        $jobSpecName = CommonFunctions::escapeHtml($jobSpec->getName());
        $jobSpecDuties = nl2br(CommonFunctions::escapeHtml($jobSpec->getDuties()));
    }

if(isset($this->getArr['capturemode']) && $this->getArr['capturemode'] == 'updatemode') { ?>

<table onclick="setUpdate(2)" onkeypress="setUpdate(2)" border="0" cellpadding="5" cellspacing="0">
	<tr>
			   <td><?php echo $lang_hremp_jobtitle; ?></td>
			  <td><select name="cmbJobTitle" <?php echo (isset($this->postArr['EditMode']) && $this->postArr['EditMode']=='1') ? '' : 'disabled="disabled"'?> onchange="onJobTitleChange(this.value);">
			  		<option value="0">-- <?php echo $lang_hremp_SelectJobTitle; ?> --</option>
			  		<?php $jobtit = $this->popArr['jobtit'];
			  			for ($c=0; $jobtit && count($jobtit)>$c ; $c++)
			  				if(isset($this->postArr['cmbJobTitle'])) {
			  					if($this->postArr['cmbJobTitle'] == $jobtit[$c][0])
					  				echo "<option selected=\"selected\" value='" . $jobtit[$c][0] . "'>" .$jobtit[$c][1]. "</option>";
					  			else
					  				echo "<option value='" . $jobtit[$c][0] . "'>" .$jobtit[$c][1]. "</option>";
			  				} elseif($edit1[0][2] == $jobtit[$c][0])
					  				echo "<option selected=\"selected\" value='" . $jobtit[$c][0] . "'>" .$jobtit[$c][1]. "</option>";
					  			else
					  				echo "<option value='" . $jobtit[$c][0] . "'>" .$jobtit[$c][1]. "</option>";
			  		?>

					</select></td>
			  <td width="50">&nbsp;</td>
			  <td><?php echo $lang_hremp_EmpStatus; ?></td>
			  <td><select class="formSelect" <?php echo (isset($this->postArr['EditMode']) && $this->postArr['EditMode']=='1') ? '' : 'disabled="disabled"'?> name="cmbType" id="cmbType" onchange="javascript: cmbTypeChanged();">
			  		<option value="0">-- <?php echo $lang_hremp_selempstat?> --</option>
<?php						$arrEmpType = $this->popArr['empstatlist'];
						for($c=0;count($arrEmpType)>$c;$c++)
							if(isset($this->postArr['cmbType'])) {
								if($this->postArr['cmbType']==$arrEmpType[$c][0])
										echo "<option selected=\"selected\" value='".$arrEmpType[$c][0]."'>" .$arrEmpType[$c][1]. "</option>";
									else
										echo "<option value='".$arrEmpType[$c][0]."'>" .$arrEmpType[$c][1]. "</option>";
							} elseif($edit1[0][1]==$arrEmpType[$c][0])
										echo "<option selected=\"selected\" value='".$arrEmpType[$c][0]."'>" .$arrEmpType[$c][1]. "</option>";
									else
										echo "<option value='".$arrEmpType[$c][0]."'>" .$arrEmpType[$c][1]. "</option>";

							if(count($arrEmpType) == 0) {
								$empStatDefault = new  EmploymentStatus();
								$arrDisplayEmpStat = $empStatDefault->filterEmpStat(EmploymentStatus::EMPLOYMENT_STATUS_ID_TERMINATED);
								echo "<option value='".$arrDisplayEmpStat[0][0]."'>".$arrDisplayEmpStat[0][1]."</option>";
						}
?>
			  </select></td>
              </tr>
              <tr>
                <td><?php echo $lang_hremp_jobspec; ?></td>
                <td id='jobSpecName'><?php echo $jobSpecName;?></td>
                <td width="50">&nbsp;</td>
                <td><?php echo $lang_hremp_jobspecduties; ?></td>
                <td id='jobSpecDuties'><?php echo $jobSpecDuties;?></td>
              </tr>
			  <tr>
			  <td><?php echo $lang_hremp_eeocategory; ?></td>
			  <td><select <?php echo (isset($this->postArr['EditMode']) && $this->postArr['EditMode']=='1') ? '' : 'disabled="disabled"'?> name="cmbEEOCat">
			  		<option value="0">-- <?php echo $lang_hremp_seleeocat?> --</option>
<?php				  		$eeojobcat = $this->popArr['eeojobcat'];
				for($c=0;$eeojobcat && count($eeojobcat)>$c;$c++)
							if(isset($this->postArr['cmbEEOCat'])) {
							   if($this->postArr['cmbEEOCat']==$eeojobcat[$c][0])
								    echo "<option selected=\"selected\" value='".$eeojobcat[$c][0]. "'>" . $eeojobcat[$c][1] ."</option>";
								else
								    echo "<option value='".$eeojobcat[$c][0]. "'>" . $eeojobcat[$c][1] ."</option>";
							} elseif($edit1[0][3]==$eeojobcat[$c][0])
								    echo "<option selected=\"selected\" value='".$eeojobcat[$c][0]. "'>" . $eeojobcat[$c][1] ."</option>";
								else
								    echo "<option value='".$eeojobcat[$c][0]. "'>" . $eeojobcat[$c][1] ."</option>";
?>
			  </select></td>

			  <td width="50">&nbsp;</td>

			  <td><?php echo $lang_hremp_joindate; ?></td>
				<td><input class="formDateInput" type="text" <?php echo (isset($this->postArr['EditMode']) && $this->postArr['EditMode']=='1') ? '' : 'disabled="disabled"'?> name="txtJoinedDate" id="txtJoinedDate" value="<?php echo (isset($this->postArr['txtJoinedDate']))?LocaleUtil::getInstance()->formatDate($this->postArr['txtJoinedDate']):LocaleUtil::getInstance()->formatDate($edit1[0][5]); ?>" size="10" />
					<input type="button" <?php echo (isset($this->postArr['EditMode']) && $this->postArr['EditMode']=='1') ? '' : 'disabled="disabled"'?> value="  " class="calendarBtn" /></td>


			  </tr>
			  <tr>

			  <td nowrap="nowrap"><?php echo $lang_hremp_Subdivision; ?></td>
			  <td nowrap="nowrap"><input type="text"  name="txtLocation" value="<?php echo isset($this->postArr['txtLocation']) ? $this->postArr['txtLocation'] : $edit1[0][4]?>" readonly="readonly" />
			  			 <input type="hidden"  name="cmbLocation" value="<?php echo isset($this->postArr['cmbLocation']) ? $this->postArr['cmbLocation'] : $edit1[0][6]?>" readonly="readonly" />
			  <input type="button" name="popLoc" value="..." onclick="returnLocDet()" <?php echo (isset($this->postArr['EditMode']) && $this->postArr['EditMode']=='1') ? '' : 'disabled="disabled"'?> class="button" /></td>

			  <td width="50">&nbsp;</td>
<?php if($_GET['reqcode'] === "ESS") { ?>
		<td colspan="2"></td>
<?php } else { ?>
			  <td  <?php echo($edit1[0][1]=='EST000'?'':'style="visibility:hidden"') ?>  id='tdTermDateDisc'><?php echo $lang_hremp_termination_date; ?></td>
				<td   <?php echo($edit1[0][1]=='EST000'?'':'style="visibility:hidden"') ?> id='tdTermDateValue'><input type="text" <?php echo (isset($this->postArr['EditMode']) && $this->postArr['EditMode']=='1') ? '' : 'disabled="disabled"'?> name="txtTermDate" id="txtTermDate" value="<?php echo (isset($this->postArr['txtTermDate']))?LocaleUtil::getInstance()->formatDate($this->postArr['txtTermDate']):LocaleUtil::getInstance()->formatDate($edit1[0][7]); ?>" size="10"/>
					<input type="button" <?php echo (isset($this->postArr['EditMode']) && $this->postArr['EditMode']=='1') ? '' : 'disabled="disabled"'?> value="  " class="calendarBtn" name='calTermDate' id='calTermDate'/></td>
<?php } ?>
			  </tr>
			  <tr>
			  <td nowrap="nowrap"><?php echo $lang_hremp_Locations; ?></td>
			  <td nowrap="nowrap">
<!-- start of list of assigned locations -->

<?php
    $assignedList = $this->popArr['assignedlocationList'];
    $availableList = $this->popArr['availablelocationList'];
?>
<?php if (!empty($assignedList)) { ?>
	<table id="assignedLocationsTable">
<?php
    foreach($assignedList as $empLoc) {
        $locId = $empLoc->getLocation();
?>
    <tr id="locRow<?php echo $locId;?>" >
        <td style="padding-right:10px;"><?php echo $empLoc->getLocationName(); ?></td>
<?php if ($locRights['delete']) { ?>
        <td class="locationDeleteChkBox" style="display:none;">
            <a class="locationDeleteLink" id="locDelLink<?php echo $locId;?>"
                href="javascript:deleteLocation(this, '<?php echo $locId;?>')"
                title="<?php echo $lang_Admin_Users_delete;?>">X</a></td>
<?php } ?>
    </tr>
<?php
    }
?>
	</table>
<?php
	}
?>
<!-- end of list of assigned locations -->
<?php
if ($locRights['add']) {
?>
<div id="toggleAddLocationLayer" style="display:none;" >
<a href="javascript:toggleLocAddLayer();" id="toggleLocAddLayerLink"><?php echo $lang_hremp_AddLocation; ?></a>
</div>
<?php
}
?>
              </td>
			  <td width="50">&nbsp;</td>
<?php if($_GET['reqcode'] === "ESS") { ?>
		<td colspan="2"></td>
<?php } else { ?>
			  <td  <?php echo($edit1[0][1]=='EST000'?'':'style="visibility:hidden"') ?> id='tdTermReasonDisc'><?php echo $lang_hremp_termination_reason; ?> </td>
			  <td  <?php echo($edit1[0][1]=='EST000'?'':'style="visibility:hidden"') ?> id='tdTermReasonValue'><textarea rows="3" cols="24" <?php echo (isset($this->postArr['EditMode']) && $this->postArr['EditMode']=='1') ? '' : 'disabled="disabled"'?>  name="txtTermReason" id="txtTermReason" ><?php echo (isset($this->postArr['txtTermReason'])?$this->postArr['txtTermReason']:$edit1[0][8]);?></textarea></td>
<?php } ?>
			  </tr>
</table>
<?php
}
?>
<div id ="addLocationLayer" style="display:none;height:50px;padding-left:5px;">
    <select name="cmbNewLocationId" id="cmbNewLocationId" style="margin-top:10px;">
        <?php
         echo "<option value='0'> -- {$lang_hremp_SelectLocation} -- </option>";
         foreach ($availableList as $loc) {
              echo "<option value=\"{$loc[0]}\">{$loc[1]}</option>";
         }
        ?>
    </select>

    <img onclick="<?php echo $saveLocBtnAction; ?>;"
        id="assignLocationButton"
        style="margin-top:10px;"
        alt=""
        onmouseout="this.src='<?php echo $iconDir;?>assign.gif';"
        onmouseover="this.src='<?php echo $iconDir;?>assign_o.gif';"
        src="<?php echo $iconDir;?>assign.gif" />
</div>
<div class="formbuttons">
    <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton';?>" name="EditMain" id="btnEditJob"
    	value="<?php echo $editMode ? $lang_Common_Edit : $lang_Common_Save;?>"
    	title="<?php echo $editMode ? $lang_Common_Edit : $lang_Common_Save;?>"
    	onmouseover="moverButton(this);" onmouseout="moutButton(this);"
    	onclick="editEmpMain(); return false;"/>
	<input type="button" class="clearbutton" id="btnClearJob" onclick="reLoad();  return false;" tabindex="5"
		onmouseover="moverButton(this);" onmouseout="moutButton(this);"	disabled="disabled"
		 value="<?php echo $lang_Common_Clear;?>" />
	<a href="javascript:toggleEmployeeContracts();" id="toggleContractLayerLink"><?php echo $lang_hremp_ShowEmployeeContracts; ?></a>
	<a href="javascript:toggleEmployeeJobHistory();" id="toggleJobHistoryLayerLink"><?php echo $lang_hremp_ShowEmployeeJobHistory; ?></a>

</div>
