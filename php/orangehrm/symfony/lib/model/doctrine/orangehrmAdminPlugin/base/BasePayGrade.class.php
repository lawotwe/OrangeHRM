<?php

/**
 * BasePayGrade
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property Doctrine_Collection $EmpBasicsalary
 * @property Doctrine_Collection $PayGradeCurrency
 * 
 * @method integer             getId()               Returns the current record's "id" value
 * @method string              getName()             Returns the current record's "name" value
 * @method Doctrine_Collection getEmpBasicsalary()   Returns the current record's "EmpBasicsalary" collection
 * @method Doctrine_Collection getPayGradeCurrency() Returns the current record's "PayGradeCurrency" collection
 * @method PayGrade            setId()               Sets the current record's "id" value
 * @method PayGrade            setName()             Sets the current record's "name" value
 * @method PayGrade            setEmpBasicsalary()   Sets the current record's "EmpBasicsalary" collection
 * @method PayGrade            setPayGradeCurrency() Sets the current record's "PayGradeCurrency" collection
 * 
 * @package    orangehrm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePayGrade extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('ohrm_pay_grade');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('name', 'string', 60, array(
             'type' => 'string',
             'length' => 60,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('EmpBasicsalary', array(
             'local' => 'id',
             'foreign' => 'sal_grd_code'));

        $this->hasMany('PayGradeCurrency', array(
             'local' => 'id',
             'foreign' => 'pay_grade_id'));
    }
}