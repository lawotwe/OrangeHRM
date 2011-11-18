<link href="<?php echo public_path('../../themes/orange/css/ui-lightness/jquery-ui-1.7.2.custom.css') ?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/ui/ui.core.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/ui/ui.datepicker.js') ?>"></script>
<?php echo stylesheet_tag('orangehrm.datepicker.css') ?>
<?php echo javascript_include_tag('orangehrm.datepicker.js') ?>

<?php echo stylesheet_tag('../orangehrmPimPlugin/css/viewJobDetailsSuccess'); ?>

<script type="text/javascript">
    //<![CDATA[
    //we write javascript related stuff here, but if the logic gets lengthy should use a seperate js file
    var edit = "<?php echo __("Edit"); ?>";
    var save = "<?php echo __("Save"); ?>";
    var lang_firstNameRequired = "<?php echo __("First Name is required"); ?>";
    var lang_lastNameRequired = "<?php echo __("Last Name is required"); ?>";
    var lang_selectGender = "<?php echo __("Select a gender"); ?>";
    var lang_invalidDate = '<?php echo __("Please enter a valid date in %format% format", array('%format%' => get_datepicker_date_format($sf_user->getDateFormat()))) ?>'
    var lang_startDateAfterEndDate = "<?php echo __('End date should be after the start date'); ?>";
    var lang_View_Details =  "<?php echo __('View Details'); ?>";
    var lang_Hide_Details =  "<?php echo __('Hide Details'); ?>";
    var lang_max_char_terminated_reason =  "<?php echo __('Maximum character limit for terminated reason is 256'); ?>";

    var datepickerDateFormat = '<?php echo get_datepicker_date_format($sf_user->getDateFormat()); ?>';
    var fileModified = 0;

    //]]>
</script>

<!-- common table structure to be followed -->
<table cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
        <td width="5">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <!-- this space is reserved for menus - dont use -->
        <td width="200" valign="top">
            <?php include_partial('leftmenu', array('empNumber' => $empNumber, 'form' => $form)); ?></td>
        <td valign="top">
            <table cellspacing="0" cellpadding="0" border="0" width="90%">
                <tr>
                    <td valign="top" width="750">
                        <!-- this space is for contents -->
                        <?php if (!empty($message)) : ?>
                            <div id="messagebar" class="<?php echo isset($messageType) ? "messageBalloon_{$messageType}" : ''; ?>" style="margin-left: 16px;width: 700px;">
                                <span style="font-weight: bold;"><?php echo $message; ?></span>
                            </div>
                        <?php endif; ?>
                            <div class="outerbox">
                                <div class="mainHeading"><h2><?php echo __('Job'); ?></h2></div>
                                <div>
                                    <form id="frmEmpJobDetails" method="post" enctype="multipart/form-data"
                                          action="<?php echo url_for('pim/viewJobDetails'); ?>">
                                          <?php echo $form['_csrf_token']; ?>
                                          <?php echo $form['emp_number']->render(); ?>
                                          <?php echo $form['job_title']->renderLabel(__('Job Title')); ?>
                                          <?php echo $form['job_title']->render(array("class" => "formSelect")); ?>
                                    <br class="clear"/>

                                    <label><?php echo __("Job Specification"); ?></label>
                                    <?php
                                          $specAttachment = $form->jobSpecAttachment;
                                          $specId = (!empty($specAttachment)) ? $specAttachment->getId() : "";
                                          if (!empty($specId)) {
                                              $linkHtml = "<div id=\"fileLink\"><a target=\"_blank\" class=\"fileLink\" href=\"";
                                              $linkHtml .= url_for('admin/viewJobSpec?attachId=' . $specId);
                                              $linkHtml .= "\">{$specAttachment->getFileName()}</a></div>";
                                              echo $linkHtml;
                                          } else {
                                              echo "<div id=\"fileLink\"><label id=\"notDefinedLabel\">" . __('Not Defined') . "</label></div>";
                                          }
                                    ?><br class="clear"/>
                                    <?php echo $form['emp_status']->renderLabel(__('Employment Status')); ?>
                                    <?php echo $form['emp_status']->render(array("class" => "formSelect")); ?>
                                          <br class="clear"/>

                                          <div id="terminatedDetails">
                                        <?php echo $form['terminated_date']->renderLabel(__('Terminated Date')); ?>
                                        <?php echo $form['terminated_date']->render(array("class" => "formDateInput")); ?>
                                          <br class="clear"/>
                                        <?php echo $form['termination_reason']->renderLabel(__('Terminated Reason')); ?>
                                        <?php echo $form['termination_reason']->render(); ?>
                                          <label class="error" id="terminatedReason"></label>
                                          <br class="clear"/>
                                      </div> <!-- End of terminatedDetails -->

                                    <?php echo $form['eeo_category']->renderLabel(__('Job Category')); ?>
                                    <?php echo $form['eeo_category']->render(array("class" => "formSelect")); ?>
                                          <br class="clear"/>

                                    <?php echo $form['joined_date']->renderLabel(__('Joined Date')); ?>
                                    <?php echo $form['joined_date']->render(array("class" => "formDateInput")); ?>
                                          <br class="clear"/>

                                    <?php echo $form['sub_unit']->renderLabel(__('Sub Unit')); ?>
                                    <?php echo $form['sub_unit']->render(array("class" => "formSelect")); ?>
                                          <br class="clear"/>

                                    <?php echo $form['location']->renderLabel(__('Location')); ?>
                                    <?php echo $form['location']->render(array("class" => "formSelect")); ?>
                                          <br class="clear"/>

                                          <div><h4><?php echo __('Employment Contract'); ?></h4></div>

                                    <?php echo $form['contract_start_date']->renderLabel(__('Start Date')); ?>
                                    <?php echo $form['contract_start_date']->render(array("class" => "formDateInput")); ?>
                                          <br class="clear"/>

                                    <?php echo $form['contract_end_date']->renderLabel(__('End Date')); ?>
                                    <?php echo $form['contract_end_date']->render(array("class" => "formDateInput")); ?>
                                          <br class="clear"/>

                                          <div id="contractEdidMode">
                                        <?php
                                          if (empty($form->attachment)) {

                                              echo $form['contract_file']->renderLabel('Contract Details');
                                              echo $form['contract_file']->render(array("class" => ""));
                                              echo "<p class=\"commonUploadHelp\">[" . __("1M Max, any larger attachments will be ignored") . "]</p>";
                                          } else {

                                              $attachment = $form->attachment;
                                              $linkHtml = "<a title=\"{$attachment->description}\" target=\"_blank\" class=\"fileLink\" href=\"";
                                              $linkHtml .= url_for('pim/viewAttachment?empNumber=' . $empNumber . '&attachId=' . $attachment->attach_id);
                                              $linkHtml .= "\">{$attachment->filename}</a>";

                                              echo $form['contract_update']->renderLabel(__('Contract Details'));
                                              echo $linkHtml;
                                              echo "<br class=\"clear\"/>";
                                              echo $form['contract_update']->render(array("class" => ""));
                                              echo "<br class=\"clear\"/>";
                                              echo "<div id=\"fileUploadSection\">";
                                              echo $form['contract_file']->renderLabel(' ');
                                              echo $form['contract_file']->render(array("class" => ""));
                                              echo "<p class=\"commonUploadHelp\">[" . __("1M Max, any larger attachments will be ignored") . "]</p>";
                                              echo "</div>";
                                          }
                                        ?>
                                      </div> <!-- End of contractEdidMode -->

                                      <div id="contractReadMode">
                                        <?php
                                          echo "<label>" . __('Contract Details') . "</label>";

                                          if (empty($form->attachment)) {

                                              echo "<label id=\"notDefinedLabel\">" . __('Not Defined') . "</label>";
                                          } else {

                                              echo $linkHtml;
                                          }
                                        ?>
                                      </div> <!-- End of contractReadMode -->

                                      <div class="formbuttons">
                                        <?php if (!$ownRecords): ?>
                                              <input type="button" class="savebutton" id="btnSave" value="<?php echo __("Edit"); ?>" />
                                        <?php endif; ?>
                                          </div>

                                      </form>
                                  </div>
                              </div>
                        <?php if (!$ownRecords): ?>
                                                  <div class="paddingLeftRequired"><?php echo __('Fields marked with an asterisk') ?> <span class="required">*</span> <?php echo __('are required.') ?></div>
                        <?php endif; ?>
                        <?php echo include_component('pim', 'customFields', array('empNumber' => $empNumber, 'screen' => 'job')); ?>
                        <?php echo include_component('pim', 'attachments', array('empNumber' => $empNumber, 'screen' => 'job')); ?>

                                              </td>
                                              <td valign="top" align="center">
                                              </td>
                                          </tr>
                                      </table>
                                  </td>
                              </tr>
                          </table>
<?php //echo javascript_include_tag('../orangehrmPimPlugin/js/viewPersonalDetailsSuccess');   ?>
                                                  <script type="text/javascript">
                                                      //<![CDATA[

                                                      var firstPart = '<?php echo url_for('admin/viewJobSpec?attachId='); ?>';
                                                      var notDefinedLabel = '<?php echo  __('Not Defined'); ?>';

                                                      var stratDate = "";

                                                      function showHideViewDetailsLink() {

                                                          if ($("#job_spec_desc").val() != '' || $("#job_spec_duties").val() != '') {
                                                              $('#viewDetailsLink').show();
                                                          } else {
                                                              $('#viewDetailsLink').hide();
                                                          }

                                                      }

                                                      function showHideTerminatedDetails() {

                                                          if ($('#job_emp_status').val() == 'EST000') {
                                                              $('#terminatedDetails').show();
                                                          } else {
                                                              $('#terminatedDetails').hide();
                                                          }

                                                      }

                                                      $(document).ready(function() {

                                                          $("#job_job_title").change(function() {

                                                              var jobTitle = this.options[this.selectedIndex].value;

                                                              if(jobTitle != ""){

                                                                  var specUrl = '<?php echo url_for('admin/getJobSpecificationJson?jobTitleId='); ?>' + jobTitle;

                                                                  $.getJSON(specUrl, function(data) {

                                                                      var specId = "";
                                                                      var fileName = "";

                                                                      if (data) {
                                                                          specId = (data.specId != null) ? data.specId : specId;
                                                                          fileName = data.fileName;
                                                                      }

                                                                      if(specId != ""){
                                                                          $('#fileLink').html("<a target=\"_blank\" class=\"fileLink\" href=\""+ firstPart + specId + ">"+fileName+ "</a>");
                                                                      }else{
                                                                          $('#fileLink').html("<label id=\"notDefinedLabel\">"+notDefinedLabel+"</label>")
                                                                      }

                                                                  });}
                                                          });

                                                          /* Form validation */
                                                          $("#frmEmpJobDetails").validate({
                                                              rules: {
                                                                  'job[terminated_date]': { required: false, valid_date: function(){ return {format:datepickerDateFormat, required:false} } },
                                                                  'job[termination_reason]': { maxlength: 256 },
                                                                  'job[joined_date]': { required: false, valid_date: function(){ return {format:datepickerDateFormat, required:false} } },
                                                                  'job[contract_start_date]': { required: false, valid_date: function(){ return {format:datepickerDateFormat, required:false}}},
                                                                  'job[contract_end_date]': { required: false, valid_date: function(){ return {format:datepickerDateFormat, required:false} }, date_range: function() {return {format:datepickerDateFormat, fromDate:stratDate}}}
                                                              },
                                                              messages: {
                                                                  'job[terminated_date]': { valid_date: lang_invalidDate },
                                                                  'job[termination_reason]': { maxlength: lang_max_char_terminated_reason },
                                                                  'job[joined_date]': { valid_date: lang_invalidDate },
                                                                  'job[contract_start_date]': { valid_date: lang_invalidDate},
                                                                  'job[contract_end_date]': { valid_date: lang_invalidDate, date_range:'<?php echo __('End date should be after the start date'); ?>'}
                                                              },
                                                              errorElement : 'div',
                                                              errorPlacement: function(error, element) {
                                                                  error.appendTo(element.prev('label'));
                                                              }
                                                          });



                                                          var readonlyFlag = 0;
<?php if ($essMode) { ?>
                                                      readonlyFlag = 1;
<?php } ?>

                                                  var list = new Array('#job_job_title', '#job_emp_status', '#job_terminated_date', '.calendarBtn', '#job_termination_reason', '#job_eeo_category',
                                                  '#job_joined_date', '#job_sub_unit', '#job_location',
                                                  '#contract_file', 'ul.radio_list input',
                                                  '#job_contract_start_date', '#job_contract_end_date',
                                                  '#job_contract_file');
                                                  for(i=0; i < list.length; i++) {
                                                  $(list[i]).attr("disabled", "disabled");
                                                  }
<?php if (empty($form->attachment)) { ?>
                                                      $('#job_contract_update_3').attr('checked', 'checked');
<?php } ?>

                                                  $('#fileUploadSection').hide();

                                                  $("input[name=job[contract_update]]").click(function () {

                                                  if ($('#job_contract_update_3').attr("checked")) {
                                                  $('#fileUploadSection').show();
                                                  } else {
                                                  $('#fileUploadSection').hide();
                                                  }
                                                  });

                                                  $('#contractEdidMode').hide();

                                                  $("#btnSave").click(function() {

                                                  $('#contractEdidMode').show();
                                                  $('#contractReadMode').hide();

                                                  if ( !readonlyFlag) {
                                                  //if user clicks on Edit make all fields editable
                                                  if($("#btnSave").attr('value') == edit) {
                                                  for(i=0; i < list.length; i++) {
                                                  $(list[i]).removeAttr("disabled");
                                                  }

                                                  $("#btnSave").attr('value', save);

<?php if (empty($form->attachment)) { ?>
                                                      $('#job_contract_update_1').attr('disabled', 'disabled');
                                                      $('#job_contract_update_2').attr('disabled', 'disabled');
                                                      $('#job_contract_update_3').attr('checked', 'checked');
<?php } ?>

                                                  return;
                                                  }

                                                  if($("#btnSave").attr('value') == save) {


                                                  if ($('#job_emp_status').val() != 'EST000') {
                                                  $('#job_terminated_date').val('');
                                                  $('#job_termination_reason').val('');
                                                  }
                                                  stratDate = $('#job_contract_start_date').val();
                                                  $("#frmEmpJobDetails").submit();
                                                  }
                                                  }
                                                  });

                                                  $('a#viewDetailsLink').click(function() {
                                                  var linkText = $('div#job_spec_details').is(':visible') ? lang_View_Details: lang_Hide_Details;
                                                  $(this).text(linkText);

                                                  $('div#job_spec_details').toggle();
                                                  });

                                                  /* Hiding/showing terminatedDetails */

                                                  showHideTerminatedDetails();

                                                  $('#job_emp_status').change(function(){
                                                  showHideTerminatedDetails();
                                                  });

                                                  /* Hiding showing viewDetailsLink at loading */
                                                  showHideViewDetailsLink();

                                                  /*
                                                  * Ajax call to fetch job specification for selected job
                                                  */
                                                  $("#job_job_title").change(function() {

                                                  var jobTitle = this.options[this.selectedIndex].value;

                                                  // don't check if not selected
                                                  if (jobTitle == '0' || jobTitle == '') {
                                                  $("#job_emp_status").html("<option value=''>-- <?php echo __("Select") ?> --</option>");
                                                  $("#viewDetailsLink").hide();
                                                  $('a#viewDetailsLink').text(lang_View_Details);
                                                  return;
                                                  }

                                                  // Note: it be more efficient if these 2 ajax calls were combined.
                                                  var empStatusUrl = '<?php echo url_for('admin/getEmpStatusesJson?job='); ?>' + jobTitle;

                                                  $.getJSON(empStatusUrl, function(data) {

                                                  $("#job_emp_status").html("<option value=''>-- <?php echo __("Select") ?> --</option>");
                                                  if (data) {
                                                  var statusCount = data.length;
                                                  var cmbJobTitle = $('#job_job_title').get(0);
                                                  var jobTitle = cmbJobTitle.options[cmbJobTitle.selectedIndex].value;

                                                  for (var i = 0; i < statusCount; i++) {
                                                  var status = data[i];
                                                  var selected = '';

                                                  // This restores current employee status
                                                  if ((jobTitle == '<?php echo $form->getValue('job_title'); ?>') &&
                                                  (status.id == '<?php echo $form->getValue('emp_status'); ?>') ) {
selected = "selected='selected'";
}

$("#job_emp_status").append("<option value='" + status.id + "' " + selected + ">" + status.name + "</option>");
}
}

})

});

});

//]]>
</script>

