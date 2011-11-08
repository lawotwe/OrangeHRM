<?php

require_once 'PHPUnit/Framework.php';
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
require_once sfConfig::get('sf_test_dir') . '/util/TestDataService.php';

class ProjectDaoTest extends PHPUnit_Framework_TestCase {

    private $projectDao;
    protected $fixture;

    /**
     * Set up method
     */
    protected function setUp() {

        $this->projectDao = new ProjectDao();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmAdminPlugin/test/fixtures/ProjectDao.yml';
        TestDataService::populate($this->fixture);
    }

    public function testSearchProjectsForNallArray() {
        $srchClues = array();
        $result = $this->projectDao->searchProjects($srchClues);
        $this->assertEquals(count($result), 2);
    }

    public function testSearchProjectsForProjectName() {
        $srchClues = array(
            'project' => 'project 1'
        );
        $result = $this->projectDao->searchProjects($srchClues);
        $this->assertEquals(count($result), 1);
        $this->assertEquals($result[0]->getProjectId(), 1);
    }

    public function testSearchProjectsForCustomerName() {
        $srchClues = array(
            'customer' => 'customer 1'
        );
        $result = $this->projectDao->searchProjects($srchClues);
        $this->assertEquals(count($result), 2);
        $this->assertEquals($result[1]->getCustomerName(), 'customer 1');
    }

    public function testSearchProjectsForProjectAdmin() {
        $srchClues = array(
            'projectAdmin' => 'Kayla Abbey'
        );
        $result = $this->projectDao->searchProjects($srchClues);
        $this->assertEquals(count($result), 1);
        $this->assertEquals($result[0]->getProjectId(), 1);
    }

}
