<link href="<?php echo public_path('../../themes/orange/css/ui-lightness/jquery-ui-1.7.2.custom.css') ?>" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/ui/ui.core.js') ?>"></script>

<?php use_stylesheet('../../../themes/orange/css/ui-lightness/jquery-ui-1.8.13.custom.css'); ?>
<?php use_javascript('../../../scripts/jquery/ui/ui.core.js'); ?>
<?php use_javascript('../../../scripts/jquery/ui/ui.dialog.js'); ?>
<?php use_stylesheet('../orangehrmAdminPlugin/css/nationalitySuccess'); ?>
<?php use_javascript('../orangehrmAdminPlugin/js/nationalitySuccess'); ?>

<?php echo isset($templateMessage) ? templateMessage($templateMessage) : ''; ?>
<div id="messagebar" class="<?php echo isset($messageType) ? "messageBalloon_{$messageType}" : ''; ?>" >
	<span><?php echo isset($message) ? $message : ''; ?></span>
</div>

<div id="nationality">
    <div class="outerbox">

        <div class="mainHeading"><h2 id="nationalityHeading"><?php echo __("Add Nationality"); ?></h2></div>
        <form name="frmNationality" id="frmNationality" method="post" action="<?php echo url_for('admin/nationality'); ?>" >

            <?php echo $form['_csrf_token']; ?>
            <?php echo $form->renderHiddenFields(); ?>
            <br class="clear"/>

	    <div class="newColumn">
                <?php echo $form['name']->renderLabel(__('Name'). ' <span class="required">*</span>'); ?>
                <?php echo $form['name']->render(array("class" => "formInput", "maxlength" => 100)); ?>
                <div class="errorHolder"></div>
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
<div class="paddingLeftRequired"><span class="required">* <?php echo __(CommonMessages::REQUIRED_FIELD); ?></span></div>
</div>


<div id="nationalityList">
    <?php include_component('core', 'ohrmList', $parmetersForListCompoment); ?>
</div>

<!-- confirmation box -->
<div id="deleteConfirmation" title="<?php echo __('OrangeHRM - Confirmation Required'); ?>" style="display: none;">

    <?php echo __("Selected nationality record(s) will be deleted") . "?"; ?>

    <div class="dialogButtons">
        <input type="button" id="dialogDeleteBtn" class="savebutton" value="<?php echo __('Delete'); ?>" />
        <input type="button" id="dialogCancelBtn" class="savebutton" value="<?php echo __('Cancel'); ?>" />
    </div>
</div>

<script type="text/javascript">
	var nationalities = <?php echo str_replace('&#039;', "'", $form->getNationalityListAsJson()) ?> ;
        var nationalityList = eval(nationalities);
	var lang_NameRequired = '<?php echo __(ValidationMessages::REQUIRED); ?>';
	var lang_exceed50Charactors = "<?php echo __("Cannot exceed 100 charactors"); ?>";
	var nationalityInfoUrl = "<?php echo url_for("admin/getNationalityJson?id="); ?>";
	var lang_editNationality = "<?php echo __("Edit Nationality"); ?>";
	var lang_addNationality = "<?php echo __("Add Nationality"); ?>";
	var lang_uniqueName = "<?php echo __("Name already exist"); ?>";
</script>