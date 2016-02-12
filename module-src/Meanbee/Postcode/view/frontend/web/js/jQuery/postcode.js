;require(['jQuery'], function ($) {

    if (!$.Meanbee) {
        $.Meanbee = {};
    }

    $.Meanbee.Postcode = function (options) {

        var base = this;

        /**
         * Class constructor
         */
        base.init = function () {

            base.options = $.extend({},
                $.Meanbee.Postcode.defaultOptions, options
            );

            base.observe();
        };

        /**
         * Attach all observers for plugin.
         */
        base.observe = function () {
            base.attachFindPostcodeButtonObserver();
        };

        /**
         * Attach an observer on the button.
         */
        base.attachFindPostcodeButtonObserver = function () {

            debugger;
            var findPostcodeButton = $(base.options.find_address_id);

            findPostcodeButton.click(function () {
                var postcode = $(base.options.postcode_field_id);
                if (postcode.val() == '') {
                    return this;
                }

                base.updateButtonText(findPostcodeButton);
                base.fetchOptions(postcode.val());

            }.bind(base, findPostcodeButton));
        };

        /**
         * Update the button text.
         *
         * @param findPostcodeButton
         */
        base.updateButtonText = function (findPostcodeButton) {
            findPostcodeButton.html("<p>Loading...</p>");
            findPostcodeButton.removeClass('invisible');
        };

        /**
         * Fetch the results from the postcode service.
         *
         * @param postcode
         * @param successCallback
         */
        base.fetchOptions = function (postcode, successCallback) {
            new $.ajax(base.base_url + 'postcode/finder/multiple/', {
                method: 'get',
                parameters: 'postcode=' + postcode,
                onSuccess: successCallback
            });
        };

        $(document).ready(
            base.init()
        );

    };

    /**
     * Default options for the plugin.
     *
     * @type {{selectors: {find_address_id: string, postcode_field_id: string}}}
     */
    $.Meanbee.Postcode.defaultOptions = {

        selectors: {
            find_address_id: "button",
            postcode_field_id: "postcode"
        }

    };

    /**
     * Setup the plugin, this will override the default
     * options with the object passed in instantiation.
     *
     * @constructor
     *
     * @param options {Object} {{selectors: {find_address_id: string, postcode_field_id: string}}}
     */
    $.fn.meanbee_Postcode = function
        (options) {
        return this.each(function () {
            (new $.Meanbee.Postcode(this, options));
        });
    };

});

