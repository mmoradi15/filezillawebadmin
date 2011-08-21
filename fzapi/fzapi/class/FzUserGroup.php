<?php

require_once 'FzSpeedLimits.php';
require_once 'FzRule.php';

/**
 * 
 * @author Ivan Ramirez
 *
 */
class FzUserGroup {

    public $name;

    /**
     * indexed by the name
     * @var array
     */
    public $options;

    /**
     * indexed by the directory path
     * @var array
     */
    public $permissions;

    /**
     * 
     * @var array
     */
    public $speedLimits;

    /**
     *
     * @var string 
     */
    public $ipDisallowed;
    
    /**
     *
     * @var string 
     */
    public $ipAllowed;
    
    
    /**
     * 
     * @param SimpleXMLElement $elt
     * @return FzUserGroup
     */
    public static function fromXml(SimpleXMLElement $elt) {
        $group = new FzUserGroup();
        $group->name = (string) $elt['Name'];

        //fetch group's options
        $group->options = self::parseOptions($elt);

        //fetch parmissions
        $group->permissions = self::parsePermissions($elt);

        $group->speedLimits = FzSpeedLimits::fromXml($elt->SpeedLimits);

        return $group;
    }

    public static function parsePermissions(SimpleXMLElement $elt) {
        $permissions = array();
        foreach ($elt->Permissions->Permission as $perm) {
            $permDir = (string) $perm['Dir'];
            $permOptions = self::parseOptions($perm);

            $permissions[$permDir] = $permOptions;
        }

        return $permissions;
    }

    /**
     * REturn an array of the options indexed by the name
     * @param SimpleXMLElement $elt
     * @return array
     */
    public static function parseOptions(SimpleXMLElement $elt) {
        $options = array();

        foreach ($elt->Option as $option) {
            $optName = (string) $option['Name'];
            $options[$optName] = (string) $option;
        }

        return $options;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getOptions() {
        return $this->options;
    }

    public function setOptions($options) {
        $this->options = $options;
    }

    public function getPermissions() {
        return $this->permissions;
    }

    public function setPermissions($permissions) {
        $this->permissions = $permissions;
    }

    /**
     *
     * @return FzSpeedLimits
     */
    public function getSpeedLimits() {
        return $this->speedLimits;
    }

    public function setSpeedLimits($speedLimits) {
        $this->speedLimits = $speedLimits;
    }
    public function getIpDisallowed() {
        return $this->ipDisallowed;
    }

    public function setIpDisallowed($ipDisallowed) {
        $this->ipDisallowed = $ipDisallowed;
    }

    public function getIpAllowed() {
        return $this->ipAllowed;
    }

    public function setIpAllowed($ipAllowed) {
        $this->ipAllowed = $ipAllowed;
    }

}