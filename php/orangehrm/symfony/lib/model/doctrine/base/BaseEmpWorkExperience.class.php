<?php

/**
 * BaseEmpWorkExperience
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $emp_number
 * @property decimal $seqno
 * @property string $employer
 * @property string $jobtitle
 * @property timestamp $from_date
 * @property timestamp $to_date
 * @property string $comments
 * @property integer $internal
 * @property Employee $Employee
 * 
 * @method integer           getEmpNumber()  Returns the current record's "emp_number" value
 * @method decimal           getSeqno()      Returns the current record's "seqno" value
 * @method string            getEmployer()   Returns the current record's "employer" value
 * @method string            getJobtitle()   Returns the current record's "jobtitle" value
 * @method timestamp         getFromDate()   Returns the current record's "from_date" value
 * @method timestamp         getToDate()     Returns the current record's "to_date" value
 * @method string            getComments()   Returns the current record's "comments" value
 * @method integer           getInternal()   Returns the current record's "internal" value
 * @method Employee          getEmployee()   Returns the current record's "Employee" value
 * @method EmpWorkExperience setEmpNumber()  Sets the current record's "emp_number" value
 * @method EmpWorkExperience setSeqno()      Sets the current record's "seqno" value
 * @method EmpWorkExperience setEmployer()   Sets the current record's "employer" value
 * @method EmpWorkExperience setJobtitle()   Sets the current record's "jobtitle" value
 * @method EmpWorkExperience setFromDate()   Sets the current record's "from_date" value
 * @method EmpWorkExperience setToDate()     Sets the current record's "to_date" value
 * @method EmpWorkExperience setComments()   Sets the current record's "comments" value
 * @method EmpWorkExperience setInternal()   Sets the current record's "internal" value
 * @method EmpWorkExperience setEmployee()   Sets the current record's "Employee" value
 * 
 * @package    orangehrm
 * @subpackage model\base
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEmpWorkExperience extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_emp_work_experience');
        $this->hasColumn('emp_number', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('eexp_seqno as seqno', 'decimal', 10, array(
             'type' => 'decimal',
             'primary' => true,
             'length' => 10,
             ));
        $this->hasColumn('eexp_employer as employer', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('eexp_jobtit as jobtitle', 'string', 120, array(
             'type' => 'string',
             'length' => 120,
             ));
        $this->hasColumn('eexp_from_date as from_date', 'timestamp', 25, array(
             'type' => 'timestamp',
             'length' => 25,
             ));
        $this->hasColumn('eexp_to_date as to_date', 'timestamp', 25, array(
             'type' => 'timestamp',
             'length' => 25,
             ));
        $this->hasColumn('eexp_comments as comments', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             ));
        $this->hasColumn('eexp_internal as internal', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Employee', array(
             'local' => 'emp_number',
             'foreign' => 'emp_number'));
    }
}