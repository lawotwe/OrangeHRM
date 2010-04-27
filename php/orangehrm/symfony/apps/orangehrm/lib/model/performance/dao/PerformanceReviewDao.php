<?php
/* 
 * 
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

/**
 * PerformanceReview Dao class 
 *
 * @author Samantha Jayasinghe
 */
class PerformanceReviewDao extends BaseDao {
	
    /**
     * Save Performance Review
     * @param PerformanceReview $performanceReview
     * @return PerformanceReview
     */
    public function savePerformanceReview(PerformanceReview $performanceReview) {
        try {
            if ( $performanceReview->getId() == '') {
                $idGenService = new IDGeneratorService( );
                $idGenService->setEntity($performanceReview);
                $performanceReview->setId($idGenService->getNextID());
            }

            $performanceReview->save();
            return $performanceReview;

        } catch (Exception $e) {
            throw new DaoException ( $e->getMessage () );
        }
    }
    
    
 	/**
     * Read Performance Review
     * @param $reviewId
     * @return PerformanceReview
     */
    public function readPerformanceReview($reviewId) {

        try {
            $performanceReview = Doctrine::getTable('PerformanceReview')
            ->find($reviewId);
            return $performanceReview;
        } catch(Exception $e) {
            throw new DaoException ( $e->getMessage () );
        }
    }
    
    /**
     * Get Performance Review List
     * @return unknown_type
     */
    public function getPerformanceReviewList( )
    {
        try
        {
            $q = Doctrine_Query::create()
                ->from('PerformanceReview pr')
                ->orderBy('pr.id');

            $performanceReviewList = $q->execute();

            return  $performanceReviewList ;

        }catch( Exception $e)
        {
            throw new DaoException ( $e->getMessage() );
        }
    }

    /**
     * Delete PerformanceReview
     * @param array reviewList
     * @returns boolean
     * @throws PerformanceServiceException
     */
    public function deletePerformanceReview($reviewList) {

        try {

            $q = Doctrine_Query::create()
               ->delete('PerformanceReview')
               ->whereIn('id', $reviewList);
               $numDeleted = $q->execute();
            if($numDeleted > 0) {
               return true ;
            }
            return false;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * Builds the search query that fetches all the
     * records for given search clues
     */
    private function getSearchReviewQuery($clues) {

        try {

            $where	=	array();
            $from = $clues['from'];
            $to = $clues['to'];
            $jobCode = $clues['jobCode'];
            $divisionId = $clues['divisionId'];
            $empId = $clues['empId'];
            $reviewerId = $clues['reviewerId'];

            if (isset($clues['loggedReviewerId']) && $clues['loggedReviewerId'] != $clues['empId']) {
                $reviewerId = $clues['loggedReviewerId'];
            }

            if (isset($clues['loggedEmpId'])) {
                $empId = $clues['loggedEmpId'];
            }

            //$where = "periodFrom >= '$from' AND periodTo <= '$to'";

        	if (!empty($from)) {
                //$where .= " AND employeeId = $empId";
                array_push($where,"periodFrom >= '$from'");
            }

        	if (!empty($to)) {
                //$where .= " AND employeeId = $empId";
                array_push($where,"periodTo <= '$to'");
            }

            if (!empty($empId)) {
                //$where .= " AND employeeId = $empId";
                array_push($where,"employeeId = $empId");
            }

            if (!empty($reviewerId)) {
                //$where .= " AND reviewerId = $reviewerId";
                if (empty($empId) && isset($clues['loggedReviewerId'])) {
                	$wherePart = "(reviewerId = $reviewerId OR employeeId = $reviewerId)";
                } else {
                    $wherePart = "reviewerId = $reviewerId";
                }
                array_push($where, $wherePart);
            }

            if (!empty($jobCode)) {
               // $where .= " AND jobTitleCode = '$jobCode'";
                array_push($where,"jobTitleCode = '$jobCode'");
            }

            if (!empty($divisionId)) {
               // $where .= " AND subDivisionId = $divisionId";
                array_push($where,"subDivisionId = $divisionId");
            }

            $q = Doctrine_Query::create()
                 ->from('PerformanceReview');
            if (count($where) > 0) {
            	$q->where(implode(' AND ',$where));
            }

            return $q;

        } catch(Exception $e) {
            throw new DaoException($e->getMessage());
        }

    }

    /**
     * Returns Object based on the combination of search
     * @param array $clues
     * @param array $offset
     * @param array $limit
     * @throws DaoException
     */
    public function searchPerformanceReview($clues = array(), $offset = null, $limit = null) {
        try {
            $q = $this->getSearchReviewQuery($clues);
            if(!is_null($offset) && !is_null($limit)) {
               $q->offset($offset)->limit($limit);
            }
            return $q->execute();

        } catch(Exception $e) {
            throw new DaoException($e->getMessage());
        }

    }
    
     /**
     * Update status of performance review
     * @param array $clues
     * @param array $offset
     * @param array $limit
     * @throws DaoException
     */
    public function updatePerformanceReviewStatus( PerformanceReview $performanceReview , $status){
    	try {
             $q = Doctrine_Query::create()
				    ->update('PerformanceReview')
				    ->set("state='?'", $status)
				    ->where("id = ?",$performanceReview->getId());
                $q->execute();
                
                return true ;
			
        } catch(Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
}