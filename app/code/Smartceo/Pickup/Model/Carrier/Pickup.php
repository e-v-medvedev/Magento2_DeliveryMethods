<?php

namespace Smartceo\Pickup\Model\Carrier;

use Magento\Quote\Model\Quote\Address\RateRequest;
use \Smartceo\Common\Shipping\Model\AddressTools;

class Pickup extends \Magento\Shipping\Model\Carrier\AbstractCarrier implements
\Magento\Shipping\Model\Carrier\CarrierInterface {

    /**
     * @var string
     */
    protected $_code = 'pickup';
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
            array $data = []
    ) {
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        $this->_logger = $logger;
        parent::__construct($scopeConfig,
                $rateErrorFactory,
                $logger,
                $data);
    }

    protected function _getObjectManager() {
        return \Magento\Framework\App\ObjectManager::getInstance();
    }

//    protected function _getDomain() {
//        $storeManager = $this->_getObjectManager()->get('\Magento\Store\Model\StoreManagerInterface');
//        $baseUrl = $storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);
//        return pathinfo($baseUrl,
//                PATHINFO_BASENAME);
//    }

    /**
     * @param RateRequest $request
     * @return \Magento\Shipping\Model\Rate\Result|bool
     */
    public function collectRates(RateRequest $request) {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        //если все поля для расчета доставки пусты, то метод не выводится
        if (
                ($request->getDestRegionCode() == NULL || $request->getDestRegionCode() == "") &&
                ($request->getDestCity() == NULL) &&
                ($request->getDestPostcode() == NULL || $request->getDestPostcode() == "")) {
            return false;
        }

        //если индекс присутствует, но не проходит проверку,
        //то метод недоступен 
        if ($request->getDestPostcode() != NULL &&
                !AddressTools::checkPostindex($request) &&
                !AddressTools::isPostcodeZerro($request)
        ) {
            return false;
        };


//	//если поле "город" заполнено и город не Москва, то метод недоступен
//	if ($request->getDestCity() != NULL && !AddressTools::isMoscow($request)) {
//	  return false;
//	}
//
//	//если поле области заполнено и регион не Московская область и не Москва, то метод недоступен
//	if ($request->getDestRegionCode() != NULL && !AddressTools::isMosObl($request) && !AddressTools::isMoscow($request)) {
//	  return false;
//	}

        /** @var \Magento\Shipping\Model\Rate\Result $result */
        $result = $this->_rateResultFactory->create();

        $shippingPrice = $this->getConfigData('price');
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

    protected function _getStoreInformation() {
        $storeInformation = $this->_getObjectManager()->create('Magento\Store\Model\Information');
        $store = $this->_getObjectManager()->create('Magento\Store\Model\Store');
        return $storeInformation->getStoreInformationObject($store);
    }

}
