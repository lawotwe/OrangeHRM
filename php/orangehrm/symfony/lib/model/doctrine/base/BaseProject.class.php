<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseProject extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_project');
        $this->hasColumn('project_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('customer_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('deleted', 'integer', 1, array(
             'type' => 'integer',
             'default' => '0',
             'length' => '1',
             ));
        $this->hasColumn('name', 'string', 100, array(
             'type' => 'string',
             'length' => '100',
             ));
        $this->hasColumn('description', 'string', 250, array(
             'type' => 'string',
             'length' => '250',
             ));
    }

    public function setUp()
    {
        $this->hasOne('Customer', array(
             'local' => 'customer_id',
             'foreign' => 'customer_id'));

        $this->hasMany('ProjectActivity', array(
             'local' => 'project_id',
             'foreign' => 'project_id'));

        $this->hasMany('ProjectAdmin', array(
             'local' => 'project_id',
             'foreign' => 'project_id'));
    }
}