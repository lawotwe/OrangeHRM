<?php

/**
 * LoginsTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class LoginsTable extends PluginLoginsTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object LoginsTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Logins');
    }
}