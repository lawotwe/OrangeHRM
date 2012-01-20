<?php

/**
 * BaseAttendanceRecord
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $employeeId
 * @property datetime $punchInUtcTime
 * @property string $punchInNote
 * @property string $punchInTimeOffset
 * @property datetime $punchInUserTime
 * @property datetime $punchOutUtcTime
 * @property string $punchOutNote
 * @property string $punchOutTimeOffset
 * @property datetime $punchOutUserTime
 * @property string $state
 * 
 * @method integer          getId()                 Returns the current record's "id" value
 * @method integer          getEmployeeId()         Returns the current record's "employeeId" value
 * @method datetime         getPunchInUtcTime()     Returns the current record's "punchInUtcTime" value
 * @method string           getPunchInNote()        Returns the current record's "punchInNote" value
 * @method string           getPunchInTimeOffset()  Returns the current record's "punchInTimeOffset" value
 * @method datetime         getPunchInUserTime()    Returns the current record's "punchInUserTime" value
 * @method datetime         getPunchOutUtcTime()    Returns the current record's "punchOutUtcTime" value
 * @method string           getPunchOutNote()       Returns the current record's "punchOutNote" value
 * @method string           getPunchOutTimeOffset() Returns the current record's "punchOutTimeOffset" value
 * @method datetime         getPunchOutUserTime()   Returns the current record's "punchOutUserTime" value
 * @method string           getState()              Returns the current record's "state" value
 * @method AttendanceRecord setId()                 Sets the current record's "id" value
 * @method AttendanceRecord setEmployeeId()         Sets the current record's "employeeId" value
 * @method AttendanceRecord setPunchInUtcTime()     Sets the current record's "punchInUtcTime" value
 * @method AttendanceRecord setPunchInNote()        Sets the current record's "punchInNote" value
 * @method AttendanceRecord setPunchInTimeOffset()  Sets the current record's "punchInTimeOffset" value
 * @method AttendanceRecord setPunchInUserTime()    Sets the current record's "punchInUserTime" value
 * @method AttendanceRecord setPunchOutUtcTime()    Sets the current record's "punchOutUtcTime" value
 * @method AttendanceRecord setPunchOutNote()       Sets the current record's "punchOutNote" value
 * @method AttendanceRecord setPunchOutTimeOffset() Sets the current record's "punchOutTimeOffset" value
 * @method AttendanceRecord setPunchOutUserTime()   Sets the current record's "punchOutUserTime" value
 * @method AttendanceRecord setState()              Sets the current record's "state" value
 * 
 * @package    orangehrm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseAttendanceRecord extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('ohrm_attendance_record');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('employee_id as employeeId', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('punch_in_utc_time as punchInUtcTime', 'datetime', null, array(
             'type' => 'datetime',
             ));
        $this->hasColumn('punch_in_note as punchInNote', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('punch_in_time_offset as punchInTimeOffset', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('punch_in_user_time as punchInUserTime', 'datetime', null, array(
             'type' => 'datetime',
             ));
        $this->hasColumn('punch_out_utc_time as punchOutUtcTime', 'datetime', null, array(
             'type' => 'datetime',
             ));
        $this->hasColumn('punch_out_note as punchOutNote', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('punch_out_time_offset as punchOutTimeOffset', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('punch_out_user_time as punchOutUserTime', 'datetime', null, array(
             'type' => 'datetime',
             ));
        $this->hasColumn('state', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}