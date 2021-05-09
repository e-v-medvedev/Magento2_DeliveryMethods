define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/shipping-rates-validator',
        'Magento_Checkout/js/model/shipping-rates-validation-rules',
        '../../model/shipping-rates-validator/smartceo-pickup',
        '../../model/shipping-rates-validation-rules/smartceo-pickup'
    ],
    function (
        Component,
        defaultShippingRatesValidator,
        defaultShippingRatesValidationRules,
        smartceoPickupShippingRatesValidator,
        smartceoPickupShippingRatesValidationRules
    ) {
        "use strict";
        defaultShippingRatesValidator.registerValidator('smartceo-pickup', smartceoPickupShippingRatesValidator);
        defaultShippingRatesValidationRules.registerRules('smartceo-pickup', smartceoPickupShippingRatesValidationRules);
        return Component;
    }
);