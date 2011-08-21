<?php
/**
 * Description of FzRule
 *
 * @author iramirez
 */
class FzRule {
    
    protected $speed;
    protected $days;
    protected $date;
    protected $from;
    protected $to;
 
    
    /**
     *
     * @param SimpleXMLElement $elt
     * @return FzRule 
     */
    static public function fromXml(SimpleXMLElement $elt) {
        
        $fzRule = new FzRule();
        $fzRule->setSpeed( (int)$elt['Speed'] );
        $fzRule->setDays( (int)$elt->Days );
        
        //Date
        if( count($elt->Date) ) {
            $date = array();
            $date['Year'] = (string) $elt->Date['Year'];
            $date['Month'] = (string) $elt->Date['Month'];
            $date['Day'] = (string) $elt->Date['Day'];
            $fzRule->setDate($date);
        }
        //From
        if( count($elt->From) ) {
            $from = array();
            $from['Hour'] = (string) $elt->From['Hour'];
            $from['Minute'] = (string) $elt->From['Minute'];
            $from['Second'] = (string) $elt->From['Second'];
            $fzRule->setFrom($from);
        }
        
        //To
        if( count($elt->To) ) {
            $to = array();
            $to['Hour'] = (string) $elt->To['Hour'];
            $to['Minute'] = (string) $elt->To['Minute'];
            $to['Second'] = (string) $elt->To['Second'];
            $fzRule->setTo($to);
        }
        return $fzRule;
    }
    
    public function getSpeed() {
        return $this->speed;
    }

    public function setSpeed($speed) {
        $this->speed = $speed;
    }

    public function getDays() {
        return $this->days;
    }

    public function setDays($days) {
        $this->days = $days;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getFrom() {
        return $this->from;
    }

    public function setFrom($from) {
        $this->from = $from;
    }

    public function getTo() {
        return $this->to;
    }

    public function setTo($to) {
        $this->to = $to;
    }

}

