<?php
/**
 * Created by PhpStorm.
 * User: tronghuan
 * Date: 10/12/14
 * Time: 3:52 PM
 */
class SM_MegaMenu_Block_Menu extends Mage_Core_Block_Template{
    public function getChildMenu(){
        $listMenu = Mage::getModel('megamenu/menu')->getCollection()->getData();
        $menuData=array();
        foreach ($listMenu as $value)
        {
            $menuData['menu'][$value['menu_id']] = $value;
            $menuData['parent'][$value['parent_id']][] = $value['menu_id'];
        }

        return $menuData ;
    }
    public function isHaveChild($id, $menu){
        foreach($menu as $value){
            if($value['parent_id']==$id){
                return true;
            }
        }
        return false;
    }
    public function getMenu($parent=0, $ul=true)
    {

        $menuData = $this->getChildMenu();
        $html = "";
        if (isset($menuData['parent'][$parent])) {
            if($ul){
                if($parent==0){
                    $html .= "<ul><li><a href='".$this->getBaseUrl()."'>Home</a></li>";
                }else{
                    $html .= "<ul class='submenu one_col'>";
                }
            }
            else{
                if($parent==0){
                    $html .= "<li><a href='".$this->getBaseUrl()."'>Home</a></li>";
                }else{
                }
            }
            foreach ($menuData['parent'][$parent] as $value) {
                $html .= "<li>";
                if($menuData['menu'][$value]['menu_type']==2&&$menuData['menu'][$value]['parent_id']!=0){
                    $html .= "<i class='fa fa-angle-right'></i><a href='".$menuData['menu'][$value]['custom_link']."'>" . $menuData['menu'][$value]['menu_name'] . "</a>";
                    $html .= $this->getTreeCategories($menuData['menu'][$value]['cate_id']);
                }
                else if($menuData['menu'][$value]['menu_type']==2&&$menuData['menu'][$value]['parent_id']==0){
                    $html .= "<a href='".$menuData['menu'][$value]['custom_link']."'>" . $menuData['menu'][$value]['menu_name'] . "</a>";
                    $html .= "<ul class='submenu one_col'>";
                    $html .= $this->getMenu($value, false);
                    $html .= "<li>";
                    $html .= $this->getTreeCategories($menuData['menu'][$value]['cate_id']);
                    $html .= "</li>";
                    $html .= "</ul>";
                }
                else if($menuData['menu'][$value]['menu_type']==3){
                    if($this->isHaveChild($menuData['menu'][$value]['menu_id'], $menuData['menu']) && $menuData['menu'][$value]['parent_id']!=0){
                        $html.="<i class='fa fa-angle-right'></i>";
                    }
                    $html .= "<a href='".$menuData['menu'][$value]['custom_link']."'>" . $menuData['menu'][$value]['menu_name'] . "</a>";
                    $html .= $this->getMenu($value);
                }
                else{
                    if($this->isHaveChild($menuData['menu'][$value]['menu_id'], $menuData['menu']) && $menuData['menu'][$value]['parent_id']!=0){
                        $html.="<i class='fa fa-angle-right'></i>";
                    }
                    $html .= "<a href='http://".$menuData['menu'][$value]['custom_link']."'>" . $menuData['menu'][$value]['menu_name'] . "</a>";
                    $html .= $this->getMenu($value);
                }
                $html .= "</li>";

            }
            if($ul){
                $html .= "</ul>";
            }
            else{
            }

        }
        return $html;
    }


    protected function getTreeCategories($parentId=1/*, $isChild=false*/){
        $html="";
        $allCats = Mage::getModel('catalog/category')->getCollection()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('is_active','1')
            ->addAttributeToFilter('include_in_menu','1')
            ->addAttributeToFilter('parent_id',array('eq' => $parentId))
            ->addAttributeToSort('position', 'asc');
        //$class = ($isChild) ? "sub-cat-list" : "cat-list";
        $html .= '<ul class="submenu one_col">';
        foreach($allCats as $category)
        {
            $html .= '<li><a href="#">'.$category->getName()."</a>";
            $subcats = $category->getChildren();
            if($subcats != ''){
                $html .= "<i class='fa fa-angle-right'></i>".$this->getTreeCategories($category->getId()/*, true*/);
            }
            $html .= '</li>';
        }
        $html .= '</ul>';
        return $html;
    }

    function getStaticBlockContent($id){

    }

    public function getAllBlock(){
        $blockList = Mage::getModel('megamenu/source_cms_block')->getAllBlock();
        echo "<pre>";
        print_r($blockList);
    }
}