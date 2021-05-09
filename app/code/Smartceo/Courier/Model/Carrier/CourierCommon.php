<?php

namespace Smartceo\Courier\Model\Carrier;

class CourierCommon extends \Magento\Shipping\Model\Carrier\AbstractCarrier implements
\Magento\Shipping\Model\Carrier\CarrierInterface {

  /**
   * @var string
   */
  protected $_logger;

  /**
   * @var bool
   */
  protected $_isFixed = true;

  /**
   * @var \Magento\Shipping\Model\Rate\ResultFactory
   */
  protected $_rateResultFactory;

  /**
   * @var \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory
   */
  protected $_rateMethodFactory;

  /**
   * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
   * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory
   * @param \Psr\Log\LoggerInterface $logger
   * @param \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory
   * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
   * @param array $data
   */
  public function __construct(
  \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
  \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
  \Psr\Log\LoggerInterface $logger,
  \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
  \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
  \Magento\Framework\ObjectManagerInterface $objectManaget,
  array $data = []
  ) {
	$this->_rateResultFactory	 = $rateResultFactory;
	$this->_rateMethodFactory	 = $rateMethodFactory;
	$this->_logger				 = $logger;
	$this->_objectManager		 = $objectManaget;
	parent::__construct($scopeConfig,
					 $rateErrorFactory,
					 $logger,
					 $data);
  }

  public function getObjectManager() {
	return $this->_objectManager;
  }

  /**
   * @param int|string|null|bool|\Magento\Store\Api\Data\StoreInterface $store [optional]
   * @return bool
   */
  public function isAdmin($store = null) {
	/** @var \Magento\Framework\App\State $state */
	$state = $this->getObjectManager()->get('Magento\Framework\App\State');
	return 'adminhtml' === $state->getAreaCode();
  }

  /**
   * Overrided in child classes. Added only for Mage_Shipping_Model_Carrier_Abstract 
   * 
   * @param Magento\Quote\Model\Quote\Address\RateRequest $request
   */
  public function collectRates(\Magento\Quote\Model\Quote\Address\RateRequest $request) {
	
  }

  /**
   * Overrided in child classes. Added only for Mage_Shipping_Model_Carrier_Abstract
   * 
   * @return array
   */
  public function getAllowedMethods() {
	
  }

}
