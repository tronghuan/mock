<?php
/**
 * Created by PhpStorm.
 * User: tronghuan
 * Date: 10/12/14
 * Time: 3:58 PM
 */
$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('sm_menu')};
CREATE TABLE {$this->getTable('sm_menu')} (
    `menu_id` int(11) unsigned NOT NULL auto_increment,
    `menu_name` varchar(255) NOT NULL default '',
    `menu_type` int(11) NOT NULL default 1,
    `custom_link` varchar(255),
    `block_link` varchar(255),
    `menu_order` int(11),
    `menu_level` int(11) NOT NULL default 0,
    `menu_status` smallint(2) NOT NULL default 1,
    `menu_limit` smallint(2) NOT NULL default 0,
    `cate_id` int(11),
    `parent_id` int(11) NOT NULL default 0,
    PRIMARY KEY (`menu_id`)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();