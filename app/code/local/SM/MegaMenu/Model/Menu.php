<?php
/**
 * Created by PhpStorm.
 * User: tronghuan
 * Date: 10/12/14
 * Time: 3:48 PM
 */
class SM_MegaMenu_Model_Menu extends Mage_Core_Model_Abstract{
    protected function _construct(){
        parent::_construct();
        $this->_init('megamenu/menu');
    }
}