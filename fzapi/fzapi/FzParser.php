<?php
require_once 'class/FzAdmin.php';

/**
 * 
 * @author Ivan Ramirez
 *
 */
class FzParser {

    /**
     * File to parse
     * @var string
     */
    private $filename;

    /**
     * Errors occuring while parsing the document
     * @var array
     */
    private $errors;
    
    /**
     * 
     * @var FzAdmin
     */
    private $fzAdmin;
    
    
    public function __construct($filename) {
        $this->filename = $filename;
        libxml_use_internal_errors(true);
    }

    public function parse() {

        $root = simplexml_load_file ($this->filename);
        if( $root === FALSE) {
            $this->errors = libxml_get_errors();
            throw new RuntimeException("file $this->filename not found");
        }
        
        $this->fzAdmin = new FzAdmin();
        $this->fzAdmin->setFilepath($this->filename);
        
        //parse the settings
        $this->parseSettings($root);

        //parse the groups
        $this->parseGroups($root);

        //pars ethe users
        $this->parseUsers($root);
        
        return $this->fzAdmin;
    }

    protected function parseSettings(SimpleXMLElement $root) {
        
        $settings = array();
        foreach($root->Settings->Item as $item) {
            $fzItem = FzItem::fromXml($item);
             
            $settings[ $fzItem->name ] = $fzItem;
        }
        
        $this->fzAdmin->setSettings($settings);
    }

    
    protected function parseGroups(SimpleXMLElement $root) {
        $groups = array();
        foreach($root->Groups->Group as $group) {
            $fzGroup = FzUserGroup::fromXml($group);
             
            $groups[ $fzGroup->name ] = $fzGroup;
        }
        
        $this->fzAdmin->setGroups($groups);
    }

    protected function parseUsers(SimpleXMLElement $root) {
        $users = array();
        foreach($root->Users->User as $user ) {
            $fzUser = FzUserGroup::fromXml($user);
             
            $users[ $fzUser->name ] = $fzUser;
        }
        
        $this->fzAdmin->setUsers($users);
    }

}