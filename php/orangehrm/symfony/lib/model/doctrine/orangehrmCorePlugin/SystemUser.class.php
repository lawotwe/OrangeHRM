<?php

/**
 * SystemUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    orangehrm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class SystemUser extends PluginSystemUser
{
    const NO_OF_RECORDS_PER_PAGE    =   50 ;
    const ADMIN_USER_ROLE_ID        =   1;
    /**
     * Get text status according system user status
     * 
     * @return String
     */
    public function getTextStatus(){
        if( $this->getStatus() == '1'){
            return 'Enabled';
        }else{
            return 'Disabled';
        }
    }
    
    public function getIsAdmin(){
        if( $this->getUserRoleId() == SystemUser::ADMIN_USER_ROLE_ID){
            return 'Yes';
        }else{
            return 'No';
        }
        
    }
    
    public function getUsergId(){
        if( $this->getUserRoleId() == SystemUser::ADMIN_USER_ROLE_ID){
             return 'USG001';
        }else{
            return null;
        }
      
    }
}
