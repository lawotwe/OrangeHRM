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
 */
abstract class displayReportAction extends sfAction {

    private $confFactory;
    private $form;

    public function execute($request) {

        $reportId = $request->getParameter("reportId");
        $backRequest = $request->getParameter("backRequest");

        $reportableGeneratorService = new ReportGeneratorService();

        $sql = $request->getParameter("sql");

        $reportableService = new ReportableService();
        $report = $reportableService->getReport($reportId);
        $useFilterField = $report->getUseFilterField();

        if (!$useFilterField) {
            $this->setCriteriaForm();
            if ($request->isMethod('post')) {

                $this->form->bind($request->getParameter($this->form->getName()));

                if ($this->form->isValid()) {

                    $reportGeneratorService = new ReportGeneratorService();
                    $formValues = $this->form->getValues();
                    $this->setReportCriteriaInfoInRequest($formValues);
                    $sql = $reportGeneratorService->generateSqlForNotUseFilterFieldReports($reportId, $formValues);
                }
            }
        } else {

            if ($request->isMethod("get")) {

                $reportGeneratorService = new ReportGeneratorService();
                $selectedRuntimeFilterFieldList = $reportGeneratorService->getSelectedRuntimeFilterFields($reportId);

                $values = $this->setValues();

                $linkedFilterFieldIdsAndFormValues = $reportGeneratorService->linkFilterFieldIdsToFormValues($selectedRuntimeFilterFieldList, $values);
                $runtimeWhereClause = $reportGeneratorService->generateWhereClauseConditionArray($linkedFilterFieldIdsAndFormValues);
                $sql = $reportGeneratorService->generateSql($reportId, $runtimeWhereClause);
            }
        }
        $paramArray = array();
        if ($reportId == 1) {
            if (!isset($backRequest)) {
                $this->getUser()->setAttribute("reportCriteriaSql", $sql);
                $this->getUser()->setAttribute("parametersForListComponent", $this->setParametersForListComponent());
            }
            if (isset($backRequest) && $this->getUser()->hasAttribute("reportCriteriaSql")) {
                $sql = $this->getUser()->getAttribute("reportCriteriaSql");
                $paramArray = $this->getUser()->getAttribute("parametersForListComponent");
            }
        }

        $params = (!empty($paramArray)) ? $paramArray : $this->setParametersForListComponent();
        $dataSet = $reportableGeneratorService->generateReportDataSet($sql);
        $headers = $reportableGeneratorService->getHeaders($reportId);

        $this->setConfigurationFactory();
        $configurationFactory = $this->getConfFactory();
        $configurationFactory->setHeaders($headers);

        ohrmListComponent::setConfigurationFactory($configurationFactory);

        $this->setListHeaderPartial();
        
        ohrmListComponent::setListData($dataSet);

        $this->parmetersForListComponent = $params;
    }

    abstract public function setParametersForListComponent();

    abstract public function setConfigurationFactory();

    abstract public function setListHeaderPartial();

    abstract public function setValues();

    public function getConfFactory() {

        return $this->confFactory;
    }

    public function setConfFactory(ListConfigurationFactory $configurationFactory) {

        $this->confFactory = $configurationFactory;
    }

    public function setReportCriteriaInfoInRequest($formValues) {

    }

    public function setCriteriaForm() {

    }

    public function setForm($form) {
        $this->form = $form;
    }

}

