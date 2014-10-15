<?php 
/**
* 
*/
abstract class SM_Bestseller_Block_Bestseller_Abstract 
	extends Mage_Catalog_Block_Product_Abstract
{

	protected static $config_path = "sm_bestseller/home_slider/";

	abstract function getBestsellerProducts();
	

	public function getSwipperScript()
	{
		$script = "<script>
		    \$j(function() {
		        var bestSellerSwiper = \$j('.swiper-bestseller-container').swiper({
		            slidesPerView:".$this->_getSlideConfig('slide_per_view').",
		            loop: ". $this->_getSlideConfig('loop') .",";

		    if ($this->_getSlideConfig('effect') == '3d') {
		        $script .= "
		            centeredSlides: true,
		            initialSlide: 7,
		            tdFlow: {
		                rotate : 30,
		                stretch :10,
		                depth: 150
		            },
		            ";
		    }
		        $script .= "
		            offsetPxBefore:10,
		            offsetPxAfter:10,
		            calculateHeight: true,
		            autoplay: ".$this->_getSlideConfig('autoplay').",
		            speed: ".$this->_getSlideConfig('speed').",
		        ";
		    
		$script .= '});
				$j(".swiper-bestseller-container .arrow-left").on("click", function(e){
				    e.preventDefault()
				    bestSellerSwiper.swipePrev()
				  });
				  $j(".swiper-bestseller-container .arrow-right").on("click", function(e){
				    e.preventDefault()
				    bestSellerSwiper.swipeNext()
				  });
			})</script>';
		return $script;
	}

	public function isShowLabel()
	{
		if (Mage::getStoreConfigFlag('sm_bestseller/general/show_label') 
			&& Mage::getStoreConfigFlag('sm_productlabel/general/enable')) {
			return true;
		}
		return false;
	}

	protected function _getPageSize()
	{
		return (int) $this->_getSlideConfig('number_product');
	}


	protected function _getSlideConfig($attr)
	{
		return Mage::getStoreConfig(static::$config_path.$attr);
	}


}
