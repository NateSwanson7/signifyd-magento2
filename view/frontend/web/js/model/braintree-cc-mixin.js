define(function () {
    'use strict';
    var mixin = {
        /**
         *
         * @param {Column} elem
         */
        placeOrder: function (key) {
            this.additionalData['signifyd-bin'] = this.paymentPayload.details.bin;
            this.additionalData['signifyd-lastFour'] = this.paymentPayload.details.lastFour;

            this._super();
        }
    };
    return function (target) {
        return target.extend(mixin);
    };
});
