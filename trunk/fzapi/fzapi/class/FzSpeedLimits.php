<?php

/**
 * 
 * @author Ivan Ramirez
 *
 */
class FzSpeedLimits {

    /**
     *
     * @var array
     */
    protected $attributes = array();
    
    /**
     *
     * @var array 
     */
    protected $download;
    
    /**
     *
     * @var array 
     */
    protected $upload;

    /**
     *
     * @param SimpleXMLElement $elt 
     * 
     * @return FzSpeedLimits
     */
    static public function fromXml(SimpleXMLElement $elt) {

        $fzSpeedLimit = new FzSpeedLimits();
        $attributes['DlType'] = (string) $elt['DlType'];
        $attributes['DlLimit'] = (string) $elt['DlLimit'];
        $attributes['ServerDlLimitBypass'] = (string) $elt['ServerDlLimitBypass'];
        $attributes['UlType'] = (string) $elt['UlType'];
        $attributes['UlLimit'] = (string) $elt['UlLimit'];
        $attributes['ServerUlLimitBypass'] = (string) $elt['ServerUlLimitBypass'];

        $fzSpeedLimit->setAttributes($attributes);
        
        $download = array();
        foreach ($elt->Download->Rule as $ruleElt) {
            $download[] = FzRule::fromXml($ruleElt);
        }
        $fzSpeedLimit->setDownload($download);
        
        $upload = array();
        foreach ($elt->Upload->Rule as $ruleElt) {
            $upload[] = FzRule::fromXml($ruleElt);
        }
        
        $fzSpeedLimit->setUpload($upload);

        return $fzSpeedLimit;
    }
    
    /**
     *
     * @return array 
     */
    public function getAttributes() {
        return $this->attributes;
    }

    public function setAttributes($attributes) {
        $this->attributes = $attributes;
    }

    /**
     *
     * @return array 
     */
    public function getDownload() {
        return $this->download;
    }

    public function setDownload($download) {
        $this->download = $download;
    }

    /**
     *
     * @return array 
     */
    public function getUpload() {
        return $this->upload;
    }

    public function setUpload($upload) {
        $this->upload = $upload;
    }
}