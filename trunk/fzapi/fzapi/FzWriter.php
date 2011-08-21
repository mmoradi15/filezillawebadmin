<?php


/**
 * FzWriter writes the configuration file from an instance of FzAdmin
 *
 * @author iramirez
 */
class FzWriter {
   
    /**
     *
     * @var FzAdmin an instance of FzAdmin previously parsed
     */
    protected $admin;
    
    
    /**
     *
     * @param FzAdmin $adminObj
     * @param string $xmlConfig 
     */
    public function __construct(FzAdmin $adminObj) {
        $this->admin = $adminObj;
    }
    
    /**
     *
     * @return FzAdmin
     */
    public function getAdmin() {
        return $this->admin;
    }

    
    public function setAdmin(FzAdmin $admin) {
        $this->admin = $admin;
    }
 
    
    /**
     *
     * @param FzAdmin $admin 
     */
    public function toXml($admin = null) {
        if( !is_null($admin) && !$admin instanceof FzAdmin ) {
            throw new RuntimeException('Argument $admin must be an instance of FzAdmin');
        }
        
        $xml = new SimpleXMLElement('<FileZillaServer />');
        $settings = $xml->addChild('Settings');

        foreach ($this->admin->getSettings() as $s) {
            $item = $settings->addChild( 'Item', $s->getValue() );
            $item->addAttribute('name', $s->getName() );
            $item->addAttribute('type', $s->getType() );
        }

        $speedLim = $settings->addChild('SpeedLimits');
        $speedLim->addChild('Download');
        $speedLim->addChild('Upload');
        
        $groups = $xml->addChild('Groups');
        foreach($this->admin->getGroups() as $g) {
            $this->writeUserGroup($groups, $g);
        }

        $users = $xml->addChild('Users');
        foreach($this->admin->getUsers() as $u) {
            $this->writeUserGroup($users, $u);
        }
        
        $dom = dom_import_simplexml($xml)->ownerDocument;
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        return $dom->saveXML($dom);
    }
    
    protected function writeUserGroup(SimpleXMLElement $xml, FzUserGroup $group) {
        $g = $xml->addChild('Group');
        $g->addAttribute('Name', $group->getName() );
        
        foreach ($group->getOptions() as $name => $value) {
            $o = $g->addChild('Option', $value);
            $o->addAttribute('Name', $name);
        }
        
        $if = $g->addChild('IpFilter');
        $if->addChild('Disallowed', $group->getIpDisallowed() );
        $if->addChild('Allowed', $group->getIpAllowed() );
        
        $perms = $g->addChild('Permissions');
        
        foreach ($group->getPermissions() as $permDir => $groupPerms) {
            $perm = $perms->addChild('Permission');
            $perm->addAttribute('Dir', $permDir);
            
            foreach ($groupPerms as $name => $value) {
                $o = $perm->addChild('Option', $value);
                $o->addAttribute('Name', $name);
            }
        }
        
        $this->writeSpeedLimits($g, $group->getSpeedLimits() );
        
    }
    
    public function writeSpeedLimits(SimpleXMLElement $g, FzSpeedLimits $speedLimits) {
        
        $slAttr = $speedLimits->getAttributes();
        $sl = $g->addChild('SpeedLimits');
        $sl->addAttribute('DlType', $slAttr['DlType']);
        $sl->addAttribute('DlLimit', $slAttr['DlLimit']);
        $sl->addAttribute('ServerDlLimitBypass', $slAttr['ServerDlLimitBypass']);
        $sl->addAttribute('UlType', $slAttr['UlType']);
        $sl->addAttribute('UlLimit', $slAttr['UlLimit']);
        $sl->addAttribute('ServerUlLimitBypass', $slAttr['ServerUlLimitBypass']);
        
        $dl = $sl->addChild('Download');
        
        foreach( $speedLimits->getDownload() as $rule) {
            $this->writeRule($dl, $rule);
        }
        
        $dl = $sl->addChild('Upload');
        foreach( $speedLimits->getUpload() as $rule) {
            $this->writeRule($dl, $rule);
        }
    }
    
    public function writeRule(SimpleXMLElement $dl, FzRule $rule) {
        $r = $dl->addChild('Rule');
        $r->addAttribute('Speed', $rule->getSpeed() );
        $r->addChild('Days', $rule->getDays());

        if( $rule->getDate() ) {
            $date = $rule->getDate();
            $dateElt = $r->addChild('Date');
            $dateElt->addAttribute('Year', $date['Year']);
            $dateElt->addAttribute('Month', $date['Month']);
            $dateElt->addAttribute('Day', $date['Day']);
        }

        if( count($rule->getFrom()) > 0 ) {
            $from = $rule->getFrom();
            $fromElt = $r->addChild('From');
            $fromElt->addAttribute('Year', $from['Hour']);
            $fromElt->addAttribute('Month', $from['Minute']);
            $fromElt->addAttribute('Day', $from['Second']);
        }

        if( count($rule->getTo()) > 0 ) {
            $to = $rule->getTo();
            $toElt = $r->addChild('To');
            $toElt->addAttribute('Year', $to['Hour']);
            $toElt->addAttribute('Month', $to['Minute']);
            $toElt->addAttribute('Day', $to['Second']);
        }
    }
}

