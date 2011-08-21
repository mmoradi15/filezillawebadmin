<?php
require_once 'FzItem.php';
require_once 'FzUserGroup.php';

/**
 *
 * @author Ivan Ramirez
 *
 */
class FzAdmin {

    /**
     *
     * @var array of FzItem
     */
    private $settings;

    /**
     * Indexed by group's name
     * @var array of FzGroup
     */
    private $groups = array();

    /**
     * Indexed by user's name
     * @var array of FzUser
     */
    private $users = array();

    /**
     *
     * @var string path to the configuration file
     */
    private $filepath;

    /**
     *
     * @param string $name
     * @return FzUserGroup 
     */
    public function getGroupByName($name) {
        if( isset($this->groups[$name])) {
            return $this->groups[$name];
        }
        
        return null;
    }

    public function addGroup(FzUserGroup $g) {
        $this->groups[ $g->getName() ] = $g;
    }


    public function getSettings() {
        return $this->settings;
    }
    
    public function setSettings(array $s) {
        $this->settings = $s;
    }
    
    /**
     *
     * @return FzUserGroup
     */
    public function getGroups() {
        return $this->groups;
    }
    
    public function setGroups(array $g) {
        $this->groups = $g;
    }
    
    /**
     *
     * @return FzUser
     */
    public function getUsers() {
        return $this->users;
    }
    
    public function setUsers(array $u) {
        $this->users = $u;
    }
    
    public function getFilepath() {
        return $this->filepath;
    }

    public function setFilepath($filepath) {
        $this->filepath = $filepath;
    }
}