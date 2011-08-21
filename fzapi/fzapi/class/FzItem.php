<?php

/**
 * 
 * @author Ivan Ramirez
 *
 */
class FzItem {
  
  public $name;
  public $type;
  public $value;
  
  
  /**
   * Build an instance of FzItem from the element given
   * @param SimpleXMLElement $elt
   * @return FzItem
   */
  public static function fromXml(SimpleXMLElement $elt) {
      $item = new FzItem();
      
      $item->name = (string) $elt['name'];
      $item->type = (string) $elt['type'];
      $item->value = (string) $elt;
      
      return $item;
  } 
  
  public function getName() {
      return $this->name;
  }

  public function setName($name) {
      $this->name = $name;
  }

  public function getType() {
      return $this->type;
  }

  public function setType($type) {
      $this->type = $type;
  }

  public function getValue() {
      return $this->value;
  }

  public function setValue($value) {
      $this->value = $value;
  }

}