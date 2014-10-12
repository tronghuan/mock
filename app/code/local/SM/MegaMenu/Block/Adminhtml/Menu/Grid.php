<?php
/**
 * Created by PhpStorm.
 * User: tronghuan
 * Date: 10/12/14
 * Time: 3:54 PM
 */
class SM_MegaMenu_Block_Adminhtml_Menu_Grid extends Mage_Adminhtml_Block_Widget_Grid{
    public function __construct(){
        parent::__construct();
        $this->setId('menuGrid');
        $this->setDefaultSort('menu_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }
    protected function _prepareCollection(){
        $collection = Mage::getModel('megamenu/menu')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $this->addColumn('menu_id', array(
            'header'    => Mage::helper('megamenu')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'menu_id',
        ));

        $this->addColumn('menu_name', array(
            'header'    => Mage::helper('megamenu')->__('Menu name'),
            'align'     =>'left',
            'index'     => 'menu_name',
        ));

        $this->addColumn('menu_type', array(
            'header'    => Mage::helper('megamenu')->__('Type'),
            'width'     => '150px',
            'index'     => 'menu_type',
        ));
        $this->addColumn('menu_order', array(
            'header'    => Mage::helper('megamenu')->__('Order'),
            'width'     => '150px',
            'index'     => 'menu_order',
        ));
        $this->addColumn('menu_limit', array(
            'header'    => Mage::helper('megamenu')->__('Limit'),
            'width'     => '150px',
            'index'     => 'menu_limit',
        ));
        $this->addColumn('menu_status', array(
            'header'    => Mage::helper('megamenu')->__('Status'),
            'width'     => '150px',
            'index'     => 'menu_status',
        ));
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('megamenu')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('megamenu')->__('Delete'),
                        'url'       => array('base'=> '*/*/delete'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
            ));

        return parent::_prepareColumns();
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}