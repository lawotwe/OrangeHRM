<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseSkill extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_skill');
        $this->hasColumn('skill_code', 'string', 13, array(
             'type' => 'string',
             'primary' => true,
             'length' => '13',
             ));
        $this->hasColumn('skill_name', 'string', 120, array(
             'type' => 'string',
             'length' => '120',
             ));
        $this->hasColumn('skill_description', 'string', 2147483647, array(
             'type' => 'string',
             'length' => '2147483647',
             ));
    }

    public function setUp()
    {
        $this->hasMany('EmployeeSkill', array(
             'local' => 'skill_code',
             'foreign' => 'skill_code'));
    }
}