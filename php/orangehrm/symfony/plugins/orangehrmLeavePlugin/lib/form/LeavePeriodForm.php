<?php

/**
 * Form class to define leave period
 */
class LeavePeriodForm extends sfForm {

    public function configure() {

        $leavePeriodService = new LeavePeriodService();
        $month = "-- " . __("Month") . " --";
        $date = "-- " . __("Date") . " --";
        $monthsChoiceList = array($month);
        $monthsChoiceList = array_merge($monthsChoiceList, $leavePeriodService->getListOfMonths());
        $datesChoiceList = array($date);

        $currentLeavePeriod = $leavePeriodService->getCurrentLeavePeriodStartDateAndMonth();
        
        if ($currentLeavePeriod instanceof LeavePeriodHistory) {
            $datesChoiceList = array_merge($datesChoiceList, $leavePeriodService->getListOfDates($currentLeavePeriod->getLeavePeriodStartMonth()));
        }

        $this->setWidgets(array(
            'cmbStartMonth' => new sfWidgetFormSelect(array(
                'choices' => $monthsChoiceList,
                    )),
            'cmbStartDate' => new sfWidgetFormSelect(array(
                'choices' => $datesChoiceList,
                    )),
        ));
        $this->setValidators(array(
            'cmbStartMonth' => new sfValidatorString(array('required' => false)),
            'cmbStartDate' => new sfValidatorString(array('required' => false)),
            
        ));

        $this->widgetSchema->setNameFormat('leaveperiod[%s]');
        $this->getWidgetSchema()->setLabels($this->getFormLabels());

    }
    
     /**
     * 
     * @return string 
     */
    public function getFormLabels() {
        $requiredMarker = ' <em>*</em>';
        $labels = array(
            'cmbStartMonth' => __('Start Month') . $requiredMarker,
            'cmbStartDate' => __('Start Date') . $requiredMarker,
		    
        );
        return $labels;
    }

}
