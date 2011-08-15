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
class deleteJobVacancyAction extends sfAction {

    private $vacancyService;
    private $jobFeedService;

    /**
     * Get VacancyService
     * @returns vacancyService
     */
    protected function getVacancyService() {

        if (is_null($this->vacancyService)) {
            $this->vacancyService = new VacancyService();
            $this->vacancyService->setVacancyDao(new VacancyDao());
        }
        return $this->vacancyService;
    }
    
    /**
     * Get JobFeedService
     * @returns JobFeedService Object
     */
    public function getJobFeedService() {
        
        if (is_null($this->jobFeedService)) {
            $this->jobFeedService = new JobFeedService();
        }
        
        return $this->jobFeedService;       
    }

    /**
     * Set JobFeedService
     * @param JobFeedService $jobFeedService
     */
    public function setJobFeedService(JobFeedService $jobFeedService) {
        $this->vacancyService = $jobFeedService;
    }

    /**
     *
     * @param <type> $request
     */
    public function execute($request) {

        $toBeDeletedVacancyIds = $request->getParameter('chkSelectRow');

        $isDeletionSucceeded = $this->getVacancyService()->deleteVacancies($toBeDeletedVacancyIds);

        if ($isDeletionSucceeded) {
            $this->getUser()->setFlash('vacancyDeletionMessageItems', array('success', __('Selected Vacancies Deleted Successfully')));
        }

        $this->getJobFeedService()->updateJobFeed();
        
        $this->redirect('recruitment/viewJobVacancy');
    }

}