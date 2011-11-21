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
class PayGradeForm extends BaseForm {

	private $payGradeId;
	private $payGradeService;
	
	public function getPayGradeService() {
		if (is_null($this->payGradeService)) {
			$this->payGradeService = new PayGradeService();
			$this->payGradeService->setPayGradeDao(new PayGradeDao());
		}
		return $this->payGradeService;
	}
	
	public function configure() {

		$this->payGradeId = $this->getOption('payGradeId');
		
		$this->setWidgets(array(
		    'payGradeId' => new sfWidgetFormInputHidden(),
		    'name' => new sfWidgetFormInputText(),
		));

		$this->setValidators(array(
		    'payGradeId' => new sfValidatorNumber(array('required' => false)),
		    'name' => new sfValidatorString(array('required' => true, 'max_length' => 52)),
		));

		$this->widgetSchema->setNameFormat('payGrade[%s]');
		
		if ($this->payGradeId != null) {
			$this->setDefaultValues($this->payGradeId);
		}
	}
	
	private function setDefaultValues($payGradeId) {

		$payGrade = $this->getPayGradeService()->getPayGradeById($payGradeId);
		$this->setDefault('payGradeId', $payGradeId);
		$this->setDefault('name', $payGrade->getName());
	}
	
	public function save(){
		
		$payGrade = new PayGrade();
		$payGrade->setName($this->getValue('name'));
		$payGrade->save();
		
		return $payGrade->getId();
	}
}

?>
