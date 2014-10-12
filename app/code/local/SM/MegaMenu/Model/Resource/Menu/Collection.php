<?php
/**
 * Created by PhpStorm.
 * User: tronghuan
 * Date: 10/12/14
 * Time: 3:50 PM
 */
class SM_MegaMenu_Model_Resource_Menu_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract{
    public function _construct(){
        parent::_construct();
        $this->_init('megamenu/menu');
    }
}