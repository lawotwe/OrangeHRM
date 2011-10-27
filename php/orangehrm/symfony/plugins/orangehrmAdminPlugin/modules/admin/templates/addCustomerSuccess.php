<link href="<?php echo public_path('../../themes/orange/css/ui-lightness/jquery-ui-1.7.2.custom.css') ?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/ui/ui.core.js') ?>"></script>

<?php use_stylesheet('../orangehrmAdminPlugin/css/addCustomerSuccess'); ?>
<?php use_javascript('../orangehrmAdminPlugin/js/addCustomerSuccess'); ?>
<?php use_stylesheet('../../../themes/orange/css/ui-lightness/jquery-ui-1.7.2.custom.css'); ?>
<?php use_javascript('../../../scripts/jquery/ui/ui.core.js'); ?>
<?php echo isset($templateMessage) ? templateMessage($templateMessage) : ''; ?>
<div id="messagebar" class="<?php echo isset($messageType) ? "messageBalloon_{$messageType}" : ''; ?>" >
	<span><?php echo isset($message) ? $message : ''; ?></span>
</div>

<div id="addCustomer">
            <div class="outerbox">

                <div class="mainHeading"><h2 id="addCustomerHeading"><?php echo __("Customer"); ?></h2></div>
                <form name="frmAddCustomer" id="frmAddCustomer" method="post" action="<?php echo url_for('admin/addCustomer'); ?>" >

            <?php echo $form['_csrf_token']; ?>
            <?php echo $form->renderHiddenFields(); ?>
            <br class="clear"/>
	    <div class="newColumn">
                <?php echo $form['customerName']->renderLabel(__('Name'). ' <span class="required">*</span>'); ?>
                <?php echo $form['customerName']->render(array("class" => "formInput", "maxlength" => 52)); ?>
                <div class="errorHolder"></div>
            </div>
	    <br class="clear"/>
	    
	    <div class="newColumn">
                <?php echo $form['description']->renderLabel(__('Description')); ?>
                <?php echo $form['description']->render(array("class" => "formInput", "maxlength" => 255)); ?>
                <div class="errorHolder"></div>
            </div>
	    <br class="clear"/>
	    
	    
	    <div class="formbuttons">
                    <input type="button" class="savebutton" name="btnSave" id="btnSave"
                           value="<?php echo __("Save"); ?>"onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                    <input type="button" class="cancelbutton" name="btnCancel" id="btnCancel"
                           value="<?php echo __("Cancel"); ?>"onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
	    </div>
	    </div>
    </form>
</div>
<div class="paddingLeftRequired"><?php echo __('Fields marked with an asterisk') ?> <span class="required">*</span> <?php echo __('are required.') ?></div>
<script type="text/javascript">
	var lang_customerNameRequired = "<?php echo __("Customer name is required"); ?>";
	var lang_exceed50Charactors = "<?php echo __("Cannot exceed 50 charactors"); ?>";
	var lang_exceed255Charactors = "<?php echo __("Cannot exceed 255 charactors"); ?>";
	var customerId = '<?php echo $customerId;?>';
	var cancelBtnUrl = '<?php echo url_for('admin/viewCustomers'); ?>';
</script>