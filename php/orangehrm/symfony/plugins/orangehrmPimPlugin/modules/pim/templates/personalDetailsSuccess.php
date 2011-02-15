<link href="<?php echo public_path('../../themes/orange/css/ui-lightness/jquery-ui-1.7.2.custom.css')?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/ui/ui.core.js')?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/ui/ui.datepicker.js')?>"></script>
<?php echo stylesheet_tag('orangehrm.datepicker.css') ?>
<?php echo javascript_include_tag('orangehrm.datepicker.js')?>

<?php echo stylesheet_tag('../orangehrmPimPlugin/css/personalDetailsSuccess'); ?>
<?php echo javascript_include_tag('../orangehrmPimPlugin/js/personalDetailsSuccess'); ?>
<!-- common table structure to be followed -->
<table cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
        <td width="5">&nbsp;</td>
        <td colspan="2" height="30">&nbsp;<?php if($showBackButton) {?><input type="button" class="backbutton" value="<?php echo __("Back") ?>" onclick="goBack();" /><?php }?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <!-- this space is reserved for menus - dont use -->
        <td width="200" valign="top"><?php require_once 'leftMenu.php';?></td>
        <td valign="top">
            <table cellspacing="0" cellpadding="0" border="0" width="90%">
                <tr>
                    <td valign="top" width="750">
                        <!-- this space is for contents -->
                        <div class="outerbox">
                            <div class="mainHeading"><h2><?php echo __('Personal Details'); ?></h2></div>
                            <div>
                                <form id="frmEmpPersonalDetails" method="post" action="<?php echo url_for('pim/personalDetails'); ?>">
                                    <?php echo $form['_csrf_token']; ?>
                                    <table cellspacing="0" cellpadding="0" border="0" class="tableArrange">
                                        <?php echo $form['txtEmpID']->render(); ?>
                                        <tr>
                                            <!-- section for full name -->
                                            <td>
                                                <table width="100%">
                                                    <tr>
                                                        <td><?php echo __('Full Name'); ?></td>
                                                        <td><?php echo $form['txtEmpFirstName']->render(array("class" => "formInputText", "maxlength" => 30)); ?><br class="clear" /></td>
                                                        <td><?php echo $form['txtEmpMiddleName']->render(array("class" => "formInputText", "maxlength" => 30)); ?></td>
                                                        <td><?php echo $form['txtEmpLastName']->render(array("class" => "formInputText", "maxlength" => 30)); ?><br class="clear" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td class="helpText"><?php echo __('First Name'); ?><span class="required">*</span></td>
                                                        <td class="helpText"><?php echo __('Middle Name'); ?></td>
                                                        <td class="helpText"><?php echo __('Last Name'); ?><span class="required">*</span></td>
                                                    </tr>
                                                </table>
                                                <div class="hrLine" >&nbsp;</div>
                                            </td>
                                        </tr>
                                        <tr>                
                                            <td>
                                                <!-- section for rest of the contents -->
                                                <table border="0" width="100%">
                                                    <tr>
                                                        <td><?php echo __('Employee Id'); ?></td>
                                                        <td><?php echo $form['txtEmployeeId']->render(array("class" => "formInputText", "maxlength" => 10)); ?></td>
                                                        <td><?php echo __('SSN Number'); ?></td>
                                                        <td><?php echo $form['txtNICNo']->render(array("class" => "formInputText", "maxlength" => 30)); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo __('Other Id'); ?></td>
                                                        <td><?php echo $form['txtOtherID']->render(array("class" => "formInputText", "maxlength" => 30)); ?></td>
                                                        <td><?php echo __('SIN Number'); ?></td>
                                                        <td><?php echo $form['txtSINNo']->render(array("class" => "formInputText", "maxlength" => 30)); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo __("Driver's License Number"); ?></td>
                                                        <td><?php echo $form['txtLicenNo']->render(array("class" => "formInputText", "maxlength" => 30)); ?></td>
                                                        <td><?php echo __('License Expiry Date'); ?></td>
                                                        <td><?php echo $form['txtLicExpDate']->render(array('size'=>'10','class'=>'formInputText', "maxlength" => 11)); ?>
                                                            <input id="licExpDateBtn" type="button" name="Submit" value="  " class="calendarBtn" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4"><br /> <div class="hrLine" >&nbsp;</div></td>
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo __("Gender"); ?></td>
                                                        <td valign="top"><?php echo $form['optGender']->render(); ?></td>
                                                        <td><?php echo __('Marital Status'); ?></td>
                                                        <td><?php echo $form['cmbMarital']->render(array("class" => "formInputText")); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo __("Nationality"); ?></td>
                                                        <td><?php echo $form['cmbNation']->render(array("class" => "formInputText")); ?></td>
                                                        <td><?php echo __('Ethinical Race'); ?></td>
                                                        <td><?php echo $form['cmbEthnicRace']->render(array("class" => "formInputText")); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo __("Date of Birth"); ?></td>
                                                        <td><?php echo $form['DOB']->render(array("class" => "formInputText", "maxlength" => 11)); ?>
                                                            <input id="dateOfBirthBtn" type="button" name="Submit" value="  " class="calendarBtn" />
                                                        </td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr <?php if(!$showDeprecatedFields) { echo "class='hideTr'"; }?> >
                                                        <td colspan="4"><br /> <div class="hrLine" >&nbsp;</div></td>
                                                    </tr>
                                                    <tr <?php if(!$showDeprecatedFields) { echo "class='hideTr'"; }?> >
                                                        <td><?php echo __("Nick Name"); ?></td>
                                                        <td><?php echo $form['txtEmpNickName']->render(array("class" => "formInputText", "maxlength" => 30)); ?></td>
                                                        <td><?php echo __('Smoker'); ?>&nbsp;<?php echo $form['chkSmokeFlag']->render(); ?></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr <?php if(!$showDeprecatedFields) {echo "class='hideTr'";}?> >
                                                        <td><?php echo __("Military Service"); ?></td>
                                                        <td><?php echo $form['txtMilitarySer']->render(array("class" => "formInputText", "maxlength" => 30)); ?></td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="formbuttons">
                                        <input type="button" class="savebutton" id="btnSave" value="<?php echo __("Edit"); ?>" tabindex="2" />
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="paddingLeftRequired"><?php echo __('Fields marked with an asterisk')?> <span class="required">*</span> <?php echo __('are required.')?></div>
                    </td>
                    <td valign="top" align="center">
                        <!-- include photo -->
                        <?php require_once 'photo.php';?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<script type="text/javascript">
    //<![CDATA[
    //we write javascript related stuff here, but if the logic gets lengthy should use a seperate js file
    var edit = "<?php echo __("Edit"); ?>";
    var save = "<?php echo __("Save"); ?>";
    var firstNameRequired = "<?php echo __("First Name is required"); ?>";
    var lastNameRequired = "<?php echo __("Last Name is required"); ?>";
    //]]>
</script>