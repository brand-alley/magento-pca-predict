var Postcode = Class.create({

    /**
     * Class constructor
     *
     * @param base_url
     */
    init: function (base_url) {
        this.setBaseUrl(base_url);
        this.observe();
        this.find_address_id = '#some-id';
        this.postcode_field_id = '#some-id';
    },

    /**
     * Attach all observers
     *
     * @returns {Postcode}
     */
    observe: function () {
        this.attachFindPostcodeButtonObserver();

        return this;
    },

    /**
     * Attach the observer for the Find Postcode button.
     *
     * @returns {Postcode}
     */
    attachFindPostcodeButtonObserver: function () {
        var findPostcodeButton = $(this.find_address_id);

        findPostcodeButton.click(function () {
            var postcode = $(this.postcode_field_id);
            if (postcode.val() == '') {
                return this;
            }

            this.updateButtonText(findPostcodeButton);
            this.fetchOptions(postcode.val());

        }.bind(this, findPostcodeButton));

        return this;
    },

    /**
     * Fetch the results from the postcode service.
     *
     * @param postcode
     * @param successCallback
     * @returns {Postcode}
     */
    fetchOptions: function (postcode, successCallback) {
        new Ajax.Request(this.base_url + 'postcode/finder/multiple/', {
            method: 'get',
            parameters: 'postcode=' + postcode + '&area=' + this.area,
            onSuccess: successCallback
        });

        return this;
    },

    /**
     * Update the button text.
     *
     * @param findPostcodeButton
     * @returns {Postcode}
     */
    updateButtonText: function (findPostcodeButton) {
        findPostcodeButton.html("<p>Loading...</p>");
        findPostcodeButton.removeClass('invisible');

        return this;
    },

    /**
     * Set the base url with the correct protocol.
     *
     * @param base_url
     * @returns {Postcode}
     */
    setBaseUrl: function (base_url) {
        if (window.location.href.match('https://') && !base_url.match('https://')) {
            this.base_url = base_url.replace('http://', 'https://')
        } else {
            this.base_url = base_url;
        }

        return this;
    }

});
