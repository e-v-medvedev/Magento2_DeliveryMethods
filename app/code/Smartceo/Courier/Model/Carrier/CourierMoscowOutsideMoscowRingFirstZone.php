<?php

namespace Smartceo\Courier\Model\Carrier;

use Magento\Quote\Model\Quote\Address\RateRequest;
use \Smartceo\Common\Shipping\Model\AddressTools;

/**
 * Description of CourierMoscowOutsideMoscowRingFirstZone
 *
 * @author bigbear
 */
class CourierMoscowOutsideMoscowRingFirstZone extends CourierCommon {

  protected $_code = 'courierm1';

  /**
   * @param RateRequest $request
   * @return \Magento\Shipping\Model\Rate\Result|bool
   */
  public function collectRates(\Magento\Quote\Model\Quote\Address\RateRequest $request) {
	if (!$this->getConfigFlag('active')) {
	  return false;
	}

	if (!AddressTools::isPostcodeZerro($request) && !AddressTools::isMoscow($request)) {
		return false;
	}
	
	/** @var \Magento\Shipping\Model\Rate\Result $result */
	$result = $this->_rateResultFactory->create();

	$specialPriceFromCartTotal = $this->getConfigData('special_price_from');
	if ($specialPriceFromCartTotal > $request->getPackageValueWithDiscount()) {
	  $shippingPrice = $this->getConfigData('price');
	} else {
	  $shippingPrice = $this->getConfigData('special_price');
	}

	$method = $this->_rateMethodFactory->create();
	$method->setCarrier($this->_code);
	$method->setCarrierTitle($this->getConfigData('title'));
	$method->setMethod($this->_code);
	$method->setMethodTitle($this->getConfigData('name'));
	$method->setPrice($shippingPrice);
	$method->setCost($shippingPrice);
	$result->append($method);

	return $result;
  }

  /**
   * @return array
   */
  public function getAllowedMethods() {
	return [$this->_code => $this->getConfigData('name')];
  }

}
