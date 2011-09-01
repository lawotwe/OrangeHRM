<?php

/**
 * BaseCandidateHistory
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $candidateId
 * @property integer $vacancyId
 * @property string $candidateVacancyName
 * @property integer $interviewId
 * @property integer $action
 * @property integer $performedBy
 * @property datetime $performedDate
 * @property string $note
 * @property JobCandidate $JobCandidate
 * @property JobVacancy $JobVacancy
 * @property Employee $Employee
 * @property JobInterview $JobInterview
 * 
 * @method integer          getId()                   Returns the current record's "id" value
 * @method integer          getCandidateId()          Returns the current record's "candidateId" value
 * @method integer          getVacancyId()            Returns the current record's "vacancyId" value
 * @method string           getCandidateVacancyName() Returns the current record's "candidateVacancyName" value
 * @method integer          getInterviewId()          Returns the current record's "interviewId" value
 * @method integer          getAction()               Returns the current record's "action" value
 * @method integer          getPerformedBy()          Returns the current record's "performedBy" value
 * @method datetime         getPerformedDate()        Returns the current record's "performedDate" value
 * @method string           getNote()                 Returns the current record's "note" value
 * @method JobCandidate     getJobCandidate()         Returns the current record's "JobCandidate" value
 * @method JobVacancy       getJobVacancy()           Returns the current record's "JobVacancy" value
 * @method Employee         getEmployee()             Returns the current record's "Employee" value
 * @method JobInterview     getJobInterview()         Returns the current record's "JobInterview" value
 * @method CandidateHistory setId()                   Sets the current record's "id" value
 * @method CandidateHistory setCandidateId()          Sets the current record's "candidateId" value
 * @method CandidateHistory setVacancyId()            Sets the current record's "vacancyId" value
 * @method CandidateHistory setCandidateVacancyName() Sets the current record's "candidateVacancyName" value
 * @method CandidateHistory setInterviewId()          Sets the current record's "interviewId" value
 * @method CandidateHistory setAction()               Sets the current record's "action" value
 * @method CandidateHistory setPerformedBy()          Sets the current record's "performedBy" value
 * @method CandidateHistory setPerformedDate()        Sets the current record's "performedDate" value
 * @method CandidateHistory setNote()                 Sets the current record's "note" value
 * @method CandidateHistory setJobCandidate()         Sets the current record's "JobCandidate" value
 * @method CandidateHistory setJobVacancy()           Sets the current record's "JobVacancy" value
 * @method CandidateHistory setEmployee()             Sets the current record's "Employee" value
 * @method CandidateHistory setJobInterview()         Sets the current record's "JobInterview" value
 * 
 * @package    orangehrm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCandidateHistory extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('ohrm_job_candidate_history');
        $this->hasColumn('id', 'integer', 13, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 13,
             ));
        $this->hasColumn('candidate_id as candidateId', 'integer', 13, array(
             'type' => 'integer',
             'length' => 13,
             ));
        $this->hasColumn('vacancy_id as vacancyId', 'integer', 13, array(
             'type' => 'integer',
             'length' => 13,
             ));
        $this->hasColumn('candidate_vacancy_name as candidateVacancyName', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('interview_id as interviewId', 'integer', 13, array(
             'type' => 'integer',
             'length' => 13,
             ));
        $this->hasColumn('action', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('performed_by as performedBy', 'integer', 13, array(
             'type' => 'integer',
             'length' => 13,
             ));
        $this->hasColumn('performed_date as performedDate', 'datetime', null, array(
             'type' => 'datetime',
             ));
        $this->hasColumn('note', 'string', 2147483647, array(
             'type' => 'string',
             'length' => 2147483647,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('JobCandidate', array(
             'local' => 'candidateId',
             'foreign' => 'id'));

        $this->hasOne('JobVacancy', array(
             'local' => 'vacancyId',
             'foreign' => 'id'));

        $this->hasOne('Employee', array(
             'local' => 'performedBy',
             'foreign' => 'empNumber'));

        $this->hasOne('JobInterview', array(
             'local' => 'id',
             'foreign' => 'interviewId'));
    }
}