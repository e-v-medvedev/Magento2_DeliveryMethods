/*
 * @see https://stackoverflow.com/questions/41998033/how-to-force-update-refresh-shipping-methods-on-checkout-magento-2?rq=1
 */
define([
    'jquery',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/shipping-rate-registry',
    'Magento_Checkout/js/model/checkout-data-resolver'
], function ($, quote, rateRegistry, checkoutDataResolver) {
    'use strict';

    var region_flag = true; //флаг отсечки сохранения первого значения ввода
    var city_flag = true; //флаг отсечки сохранения первого значения ввода
    var s_city = null;
    var s_region = null;

    $(document).ready(function () {
        $(document).on('change keyup', "[name='city']", function (e) {
            
            if (city_flag) {
                console.log(e);
                s_city = e.target.value;
                city_flag = false; //сохранение первого введенного значения
            }

            var wait = setTimeout(function () {
                console.log(s_city);
                if (s_city != null && e.target.value != s_city) {
 //                   alert(e.target.value + " " + s_city);

                    checkoutDataResolver.resolveEstimationAddress();
                    
                    city_flag = true;
                    s_city = null;
                }

            }, 2000);
        });

        $(document).on('change keyup', "[name='region']", function (e) {
            if (region_flag) {
                s_region = e.target.value;
                region_flag = false; //сохранение первого введенного значения
            }

            var wait = setTimeout(function () {
                console.log(s_region);
                if (s_region != null && e.target.value != s_region) {
//                    alert(e.target.value + " " + s_region);

                    checkoutDataResolver.resolveEstimationAddress();

                    region_flag = true;
                    s_region = null;
                }
            }, 2000);
        });

    });

//всегда необходимо возвращать функцию данного вида
    return function (targetModule) {
        //при необходимои к целевому модулю можно добавить доп. свойства, то есть передать данные или методы
        targetModule.crazyPropertyAddedHere = 'yes';
        return targetModule;
    };
});