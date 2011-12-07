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
class JobTitleForm extends BaseForm {

    private $jobTitleService;
    public $jobTitleId;
    public $attachment;

    public function getJobTitleService() {
        if (is_null($this->jobTitleService)) {
            $this->jobTitleService = new JobTitleService();
            $this->jobTitleService->setJobTitleDao(new JobTitleDao());
        }
        return $this->jobTitleService;
    }

    const CONTRACT_KEEP = 1;
    const CONTRACT_DELETE = 2;
    const CONTRACT_UPLOAD = 3;

    public function configure() {

        $this->jobTitleId = $this->getOption('jobTitleId');

        $jobSpecUpdateChoices = array(self::CONTRACT_KEEP => __('Keep Current'),
            self::CONTRACT_DELETE => __('Delete Current'),
            self::CONTRACT_UPLOAD => __('Replace Current'));

        $this->setWidgets(array(
            'jobTitle' => new sfWidgetFormInputText(),
            'jobDescription' => new sfWidgetFormTextArea(),
            'note' => new sfWidgetFormTextArea(),
            'jobSpec' => new sfWidgetFormInputFile(),
            'jobSpecUpdate' => new sfWidgetFormChoice(array('expanded' => true, 'choices' => $jobSpecUpdateChoices))
        ));

        $this->setValidators(array(
            'jobTitle' => new sfValidatorString(array('required' => true, 'max_length' => 100)),
            'jobDescription' => new sfValidatorString(array('required' => false, 'max_length' => 400, 'trim' => true)),
            'note' => new sfValidatorString(array('required' => false, 'max_length' => 400, 'trim' => true)),
            'jobSpec' => new sfValidatorFile(array('required' => false, 'max_size' => 1024000,
                'validated_file_class' => 'orangehrmValidatedFile')),
            'jobSpecUpdate' => new sfValidatorString(array('required' => false))
        ));

        $this->widgetSchema->setNameFormat('jobTitle[%s]');

        if (!empty($this->jobTitleId)) {
            $jobTitle = $this->getJobTitleService()->getJobTitleById($this->jobTitleId);

            $this->setDefault('jobTitle', $jobTitle->getJobTitleName());
            $this->setDefault('jobDescription', $jobTitle->getJobDescription());
            $this->setDefault('note', $jobTitle->getNote());

            $this->attachment = $jobTitle->getJobSpecificationAttachment();
        }
    }

    public function save() {
        $resultArray = array();

        $jobTitle = $this->getValue('jobTitle');
        $jobDescription = $this->getValue('jobDescription');
        $note = $this->getValue('note');
        $jobSpec = $this->getValue('jobSpec');
        $jobSpecUpdate = $this->getValue('jobSpecUpdate');

        if (!empty($this->jobTitleId)) {
            $jobTitleObj = $this->getJobTitleService()->getJobTitleById($this->jobTitleId);
            $attachment = $jobTitleObj->getJobSpecificationAttachment();
            if (!empty($attachment) && $jobSpecUpdate != self::CONTRACT_KEEP) {
                $attachment->delete();
            }
            $resultArray['messageType'] = 'success';
            $resultArray['message'] = __('Job Title Updated Successfully');
        } else {
            $jobTitleObj = new JobTitle();
            $resultArray['messageType'] = 'success';
            $resultArray['message'] = __('Job Title Added Successfully');
        }

        $jobTitleObj->setJobTitleName($jobTitle);
        $jobTitleObj->setJobDescription($jobDescription);
        $jobTitleObj->setNote($note);
        if (!empty($jobSpec)) {
            $jobTitleObj->setJobSpecificationAttachment($this->__getJobSpecAttachmentObj());
        } else {
            $jobTitleObj->setJobSpecificationAttachment(null);
        }

        $jobTitleObj->save();


        return $resultArray;
    }

    private function __getJobSpecAttachmentObj() {

        $jobSpec = $this->getValue('jobSpec');

        $jobSpecAttachement = new JobSpecificationAttachment();

        $jobSpecAttachement->setFileName($jobSpec->getOriginalName());
        $jobSpecAttachement->setFileType($jobSpec->getType());
        $jobSpecAttachement->setFileSize($jobSpec->getSize());
        $jobSpecAttachement->setFileContent(file_get_contents($jobSpec->getTempName()));

        return $jobSpecAttachement;
    }

    public function getJobTitleListAsJson() {

        $list = array();
        $jobTitleList = $this->getJobTitleService()->getJobTitleList();
        foreach ($jobTitleList as $job) {
            $list[] = array('id' => $job->getId(), 'name' => $job->getJobTitleName());
        }
        return json_encode($list);
    }

}

