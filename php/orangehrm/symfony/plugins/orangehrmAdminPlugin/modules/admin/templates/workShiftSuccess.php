<link href="<?php echo public_path('../../themes/orange/css/ui-lightness/jquery-ui-1.7.2.custom.css') ?>" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/ui/ui.core.js') ?>"></script>
<script type="text/javascript" src="../../scripts/archive.js"></script>
<script type="text/javascript" src="../../scripts/octopus.js"></script>

<?php use_stylesheet('../../../themes/orange/css/ui-lightness/jquery-ui-1.8.13.custom.css'); ?>
<?php use_javascript('../../../scripts/jquery/ui/ui.core.js'); ?>
<?php use_javascript('../../../scripts/jquery/ui/ui.dialog.js'); ?>
<?php use_stylesheet('../orangehrmAdminPlugin/css/workShiftSuccess'); ?>
<?php use_javascript('../orangehrmAdminPlugin/js/workShiftSuccess'); ?>
<?php echo isset($templateMessage) ? templateMessage($templateMessage) : ''; ?>
<div id="messagebar" class="<?php echo isset($messageType) ? "messageBalloon_{$messageType}" : ''; ?>" >
	<span><?php echo isset($message) ? $message : ''; ?></span>
</div>

<div id="workShift">
    <div class="outerbox">

        <div class="mainHeading"><h2 id="workShiftHeading"><?php echo __("Work Shift"); ?></h2></div>
        <form name="frmWorkShift" id="frmWorkShift" method="post" action="<?php echo url_for('admin/workShift'); ?>" >

            <?php echo $form['_csrf_token']; ?>
            <?php echo $form->renderHiddenFields(); ?>
            <br class="clear"/>

	    <?php echo $form['name']->renderLabel(__('Shift Name'). ' <span class="required">*</span>'); ?>
            <?php echo $form['name']->render(array("class" => "formInput", "maxlength" => 52)); ?>
            <div class="errorHolder"></div>
	    <br class="clear"/>
	    
	    <?php echo $form['hours']->renderLabel(__('Hours Per Day'). ' <span class="required">*</span>'); ?>
            <?php echo $form['hours']->render(array("class" => "formInput")); ?>
            <div class="errorHolder"></div>
	    <br class="clear"/>
	    <br class="clear"/>
	    
	    <div id="selectManyTable">
	    <table border="0">
		<tbody>
		<tr>
		    <th width="100" style=""><?php echo __("Available Employees"); ?></th>
		    <th width="100">
		    </th><th width="125" style=""><?php echo __("Assigned Employees"); ?></th>
		</tr>
		<tr>
		    <td width="100">
			<?php echo $form['availableEmp']->render(array("class" => "selectMany", "size" => 10)); ?>	
		    </td>
		    <td align="center" width="100">
				<input type="button" style="width: 80%;" value="<?php echo __("Add"). " >"; ?>" onmouseout="moutButton(this)" onmouseover="moverButton(this)" class="plainbtn" id="btnAssignEmployee" name="btnAssignEmployee"><br><br>
				<input type="button" style="width: 80%;" value="<?php echo "< ".__("Remove"); ?>" onmouseout="moutButton(this)" onmouseover="moverButton(this)" class="plainbtn" id="btnRemoveEmployee" name="btnRemoveEmployee">
		    </td>
		    <td>
			<?php echo $form['assignedEmp']->render(array("class" => "selectMany", "size" => 10)); ?>
       		    </td>
		</tr>
	        </tbody>
	    </table>
	    </div>
	    
	    <br class="clear"/>
	    
	    <div class="actionbuttons">
                    <input type="button" class="savebutton" name="btnSave" id="btnSave"
                           value="<?php echo __("Save"); ?>"onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                    <input type="button" class="cancelbutton" name="btnCancel" id="btnCancel"
                           value="<?php echo __("Cancel"); ?>"onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
	    </div>
	</form>
    </div>
    <div class="paddingLeftRequired"><?php echo __('Fields marked with an asterisk') ?> <span class="required">*</span> <?php echo __('are required.') ?></div>
</div>

<div id="customerList">
    <?php include_component('core', 'ohrmList', $parmetersForListCompoment); ?>
</div>

<!-- confirmation box -->
<div id="deleteConfirmation" title="<?php echo __('OrangeHRM - Confirmation Required'); ?>" style="display: none;">

    <?php echo __("Selected employment status(es) will be deleted") . "?"; ?>

    <div class="dialogButtons">
        <input type="button" id="dialogDeleteBtn" class="savebutton" value="<?php echo __('Delete'); ?>" />
        <input type="button" id="dialogCancelBtn" class="savebutton" value="<?php echo __('Cancel'); ?>" />
    </div>
</div>

<script type="text/javascript">
	var lang_NameRequired = "<?php echo __("Shift Name is required"); ?>";
	var lang_exceed50Charactors = "<?php echo __("Cannot exceed 50 charactors"); ?>";
	var lang_hoursRequired = "<?php echo __("Hour per day is required"); ?>";
	var lang_notNumeric = "<?php echo __("Enter a valid number"); ?>";
	var lang_addWorkShift = "<?php echo __("Add Work Shift"); ?>";
	var lang_editWorkShift = "<?php echo __("Edit Work Shift"); ?>";
	var workShiftInfoUrl = "<?php echo url_for("admin/getWorkShiftInfoJson"); ?>";
	var workShiftEmpInfoUrl = "<?php echo url_for("admin/getWorkShiftEmpInfoJson"); ?>";
</script>