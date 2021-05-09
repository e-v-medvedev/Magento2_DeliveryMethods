define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/shipping-rates-validator',
        'Magento_Checkout/js/model/shipping-rates-validation-rules',
        '../../model/shipping-rates-validator/smartceo-courier',
        '../../model/shipping-rates-validation-rules/smartceo-courier'
    ],
    function (
        Component,
        defaultShippingRatesValidator,
        defaultShippingRatesValidationRules,
        smartceoCourierShippingRatesValidator,
        smartceoCourierShippingRatesValidationRules
    ) {
        "use strict";
        defaultShippingRatesValidator.registerValidator('smartceo-courier', smartceoCourierShippingRatesValidator);
        defaultShippingRatesValidationRules.registerRules('smartceo-courier', smartceoCourierShippingRatesValidationRules);
        return Component;
    }
);