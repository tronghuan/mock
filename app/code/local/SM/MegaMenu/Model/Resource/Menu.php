<?php
/**
 * Created by PhpStorm.
 * User: tronghuan
 * Date: 10/12/14
 * Time: 3:49 PM
 */
class SM_MegaMenu_Model_Resource_Menu extends Mage_Core_Model_Resource_Db_Abstract{
    public function _construct(){
        // Note that the menu_id refers to the key field in your database table.
        $this->_init('megamenu/menu', 'menu_id');
    }
}