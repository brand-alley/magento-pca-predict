/**
 * Meanbee_Postcode
 *
 * This module was developed by Meanbee Internet Solutions.  If you require any
 * support or have any questions please contact us at support@meanbee.com.
 *
 * @category   Meanbee
 * @package    Meanbee_Postcode
 * @author     Meanbee Internet Solutions <support@meanbee.com>
 * @copyright  Copyright (c) 2009 Meanbee Internet Solutions (http://www.meanbee.com)
 * @license    Single Site License, requiring consent from Meanbee Internet Solutions
 */

var Postcode = Class.create({
    initialize: function() {
        this.observe();
    },
    
    observe: function(find_address_id, postcode_field_id, address_selector_id) {
        $(find_address_id).observe('click', function (e) {
            var postcode = $F(postcode_field_id);
            if (postcode != '') {
                $(address_selector_id).innerHTML = "<p>Loading...</p>";
                $(address_selector_id).removeClassName('invisible');
                this.fetchOptions(postcode);
            }
        }.bind(this));
    },

    fetchOptions: function(postcode, successCallback) {
        new Ajax.Request(MEANBEE_POSTCODE_BASE_URL + 'postcode/finder/multiple/', {
            method: 'get',
            parameters: 'postcode=' + postcode,
            onSuccess: successCallback,
        });
    },

    fillFields: function(id, formData) {                
        new Ajax.Request(MEANBEE_POSTCODE_BASE_URL + 'postcode/finder/single/', {
            method: 'get',
            parameters: 'id=' + id,
            onSuccess: function(transport) {
                var json = transport.responseJSON;

                if (!json.error) {

                    $(formData['countryId']).value = 'GB';

                    if (formData['regionUpdate']) { 
                        eval(formData['regionUpdater'] + '.update()');
                    }
                    
                    this.fillStreetFields(json, formData);

                    if (typeof(json.content.organisation_name) != "undefined") {
                        $(formData['company']).value = json.content.organisation_name;
                    } else {
                        $(formData['company']).value = '';
                    }
                    
                    if (typeof(json.content.post_town) != "undefined") {
                        $(formData['city']).value = json.content.post_town;
                    } else {
                        $(formData['city']).value = '';
                    }
                    
                    if (typeof(json.content.county) != "undefined") {
                        $(formData['region']).value = json.content.county;
                    } else {
                        $(formData['region']).value = '';
                    }
                    
                    $(formData['postcode']).value = json.content.postcode;

                    //$('meanbee:' + a + '_address_selector').innerHTML = '&nbsp;';

                    // call the sub classes so they can do their own actions
                    this.childActions();
                } else {
                    this.error(json.content);
                }
            }.bind(this)
        });
    },

    fillStreetFields: function(json, formData) {
        var lines = new Array(json.content.line1, json.content.line2, json.content.line3, json.content.line4);
        var concat_line = null;

        for (var i = 0; i < 4; i++) {
            if (typeof(lines[i]) != "undefined" &&  $(formData['street'] + (i+1)) != null) {
                $(formData['street'] + (i+1)).value = lines[i];
            } else if ($(formData['street'] + (i+1)) != null) {
                $(formData['street'] + (i+1)).value = '';
            } else if (typeof(lines[i]) != "undefined") {
                if (concat_line == null) {
                    concat_line = i - 1;
                }

                $(formData['street'] + (concat_line+1)).value += ', ' + lines[i];
            }
        }
    },

    childActions: function() {
    },

    clearFields: function(formElements) {                
        formElements.each(function(el) {
            if (el != null) {
                el.value = '';
            }
        });
    },

    error: function(message) {
        this.address_selector.innerHTML = "&nbsp";
        this.address_selector.addClassName('invisible');
        alert(message);
    }

});

var OPCPostcode = Class.create(Postcode, {
    initialize: function($super, page) {
        this.page = page;
        this.address_selector = $('meanbee:' + this.page + '_address_selector');
        $super();
    },

    observe: function($super) {
        var find_address_id = 'meanbee:' + this.page + '_address_find';
        var postcode_field_id = this.page + ':postcode';
        var address_selector_id = 'meanbee:' + this.page + '_address_selector';
        
        $super(find_address_id, postcode_field_id, address_selector_id);

        $('meanbee:' + this.page + '_input_address_manually').observe('click', function (e) {
            $$('#opc-' + this.page + ' .address-detail').each(function(el) {
                el.removeClassName('invisible')
            });
            $$('#opc-' + this.page + ' .meanbee-postcode-element').each(function(el) {
                el.addClassName('invisible');
            });
            $('meanbee:' + this.page + '_show_another').removeClassName('invisible');
            e.preventDefault();
        }.bind(this));

        $('meanbee:' + this.page + '_show_another_link').observe('click', function(e) {
            $$('#opc-' + this.page + ' .address-detail').each(function(el) {
                el.addClassName('invisible')
            });
            $$('#opc-' + this.page + ' .meanbee-postcode-element').each(function(el) {
                el.removeClassName('invisible');
            });
            $('meanbee:' + this.page + '_show_another').addClassName('invisible');
            $('meanbee:' + this.page + '_address_selector').addClassName('invisible');
            this.clearFields(this.page);
            e.preventDefault();
        }.bind(this));
    },

    fetchOptions: function($super, postcode) {
        successCallback = function(transport) {
            var json = transport.responseJSON;

            if (!json.error) {
                var select = '<select id="meanbee:' + this.page + '_address_selector_select">';
                for(var i = 0; i < json.content.length; i++) {
                    select += '<option value="' + json.content[i].id + '">' + json.content[i].description + '</option>'
                }
                select+= '</select>';
                $('meanbee:' + this.page + '_address_selector').innerHTML = '<div class="field">' + select + '</div>' + ' <div class="field"><button onclick="meanbee_postcode_' + this.page + '.fillFields($F(\'meanbee:' + this.page + '_address_selector_select\'), \'' + this.page + '\')" type="button" class="button"><span><span>Select Address</span></span></button></div>';
                //$('meanbee:' + this.page + '_address_selector').innerHTML += '<br /><small><b>Note:</b> Please select your address from the above drop down menu before pressing "Select Address".</small>';
            } else {
                this.error(json.content);
            }
        }.bind(this);
        $super(postcode, successCallback);
    },

    fillFields: function($super, id) {
        var formData = {
            regionUpdate: true,
            countryId: this.page + ':country_id',
            regionUpdater: this.page + 'RegionUpdater',
            street: this.page + ':street',
            company: this.page + ':company',
            city: this.page + ':city',
            region: this.page + ':region',
            postcode: this.page + ':postcode',
        };

        $super(id, formData);
    },

    childActions: function($super) {
        $super();
        $$('#opc-' + this.page + ' .address-detail').each(function(el) {
            el.removeClassName('invisible')
        });
        $$('#opc-' + this.page + ' .meanbee-postcode-element').each(function(el) {
            el.addClassName('invisible')
        });
        $('meanbee:' + this.page + '_show_another').removeClassName('invisible');
        $('meanbee:' + this.page + '_address_selector').addClassName('invisible');
    },
            
    clearFields: function($super) {
        var formElements = new Array(
            $(this.page + ':company'),
            $(this.page + ':postcode'),
            $(this.page + ':street1'),
            $(this.page + ':street2'),
            $(this.page + ':street3'),
            $(this.page + ':city'),
            $(this.page + ':region'),
            $(this.page + ':region_id')
        );
        $super(formElements);
    }

});

var BackendPostcode = Class.create(Postcode, {
    initialize: function($super, page) {
        this.address_selector = $('meanbee:backend_address_selector');
        $super();
    },
      
    observe: function($super) {
        var find_address_id = 'meanbee:backend_address_find';
        var postcode_field_id = 'backend:postcode';
        var address_selector_id = 'meanbee:backend_address_selector';
        
        $super(find_address_id, postcode_field_id, address_selector_id);
    },

    fetchOptions: function($super, postcode) {
        successCallback = function(transport) {
            var json = transport.responseJSON;

            if (!json.error) {
                var select = '<select id="meanbee:backend_address_selector_select">';
                for(var i = 0; i < json.content.length; i++) {
                    select += '<option value="' + json.content[i].id + '">' + json.content[i].description + '</option>'
                }
                select += '</select>';
                $('meanbee:backend_address_selector').innerHTML = select + ' <p><button onclick="meanbee_postcode.fillFields($F(\'meanbee:backend_address_selector_select\'), \'billing\')" type="button">Select as Billing Address</button> <button onclick="meanbee_postcode.fillFields($F(\'meanbee:backend_address_selector_select\'), \'shipping\')" type="button">Select as Shipping Address</button></p>';
                //$('meanbee:backend_address_selector').innerHTML += '<br /><small><b>Note:</b> Please select your address from the above drop down menu before pressing "Select Address".</small>';
            } else {
                this.error(json.content);
            }
        }.bind(this);
        $super(postcode, successCallback);
    },

    fillFields: function($super, id, page) {
        var field_prefix = 'order-' + page + '_address_';
        this.page = page;

        var formData = {
            regionUpdate: false,
            countryId: field_prefix + 'country_id',
            street: field_prefix + 'street',
            company: field_prefix + 'company',
            city: field_prefix + 'city',
            region: field_prefix + 'region',
            postcode: field_prefix + 'postcode',
        };

        $super(id, formData);

    },

    fillStreetFields: function($super, json, formData) {
        var lines = new Array(json.content.line1, json.content.line2, json.content.line3, json.content.line4);
        var concat_line = null;

        for (var i = 0; i < 4; i++) {
            if (typeof(lines[i]) != "undefined" &&  $(formData['street'] + (i)) != null) {
                $(formData['street'] + (i)).value = lines[i];
            } else if ($(formData['street'] + (i)) != null) {
                $(formData['street'] + (i)).value = '';
            } else if (typeof(lines[i]) != "undefined") {
                if (concat_line == null) {
                    concat_line = i - 1;
                }

                $(formData['street'] + (concat_line+1)).value += ', ' + lines[i];
            }
        }
    },

    childActions: function($super) {
        var country_id = 'order-' + this.page + '_address_country_id';

        // Simulate the change event. We can't access the region updater and this has the same effect
        $(country_id).simulate('change');
    },
});

var AccountPostcode = Class.create(Postcode, {
    initialize: function($super, page) {
        this.address_selector = $('meanbee:account_address_selector');
        $super();
    },

    observe: function($super) {
        var find_address_id = 'meanbee:account_address_find';
        var postcode_field_id = 'zip';
        var address_selector_id = 'meanbee:account_address_selector';
        
        $super(find_address_id, postcode_field_id, address_selector_id);

        $('meanbee:account_input_address_manually').observe('click', function (e) {
            $$('.address-detail').each(function(el) {
                el.removeClassName('invisible')
            });
            $$('.meanbee-postcode-element').each(function(el) {
                el.addClassName('invisible');
            });
            $('meanbee:account_show_another').removeClassName('invisible');
            e.preventDefault();
        }.bind(this));

        $('meanbee:account_show_another_link').observe('click', function(e) {
            $$('.address-detail').each(function(el) {
                el.addClassName('invisible')
            });
            $$('.meanbee-postcode-element').each(function(el) {
                el.removeClassName('invisible');
            });
            $('meanbee:account_show_another').addClassName('invisible');
            $('meanbee:account_address_selector').addClassName('invisible');
            this.clearFields(this.page);
            e.preventDefault();
        }.bind(this));
    },

    fetchOptions: function($super, postcode) {
        successCallback = function(transport) {
            var json = transport.responseJSON;

            if (!json.error) {
                var select = '<select id="meanbee:account_address_selector_select">';
                for(var i = 0; i < json.content.length; i++) {
                    select += '<option value="' + json.content[i].id + '">' + json.content[i].description + '</option>'
                }
                select+= '</select>';
                $('meanbee:account_address_selector').innerHTML = '<div class="field">' + select + '</div>' + ' <div class="field"><button onclick="meanbee_postcode.fillFields($F(\'meanbee:account_address_selector_select\'))" type="button" class="button"><span><span>Select Address</span></span></button></div>';
                //$('meanbee:account_address_selector').innerHTML += '<br /><small><b>Note:</b> Please select your address from the above drop down menu before pressing "Select Address".</small>';
            } else {
                this.error(json.content);
            }
        }.bind(this);
        $super(postcode, successCallback);
    },

    fillFields: function($super, id) {
        var formData = {
            regionUpdate: true,
            countryId: 'country',
            regionUpdater: 'accountRegionUpdater',
            street: 'street_',
            company: 'company',
            city: 'city',
            region: 'region',
            postcode: 'zip',
        };

        $super(id, formData);
    },

    childActions: function($super) {
        $super();
        $$('.address-detail').each(function(el) {
            el.removeClassName('invisible')
        });
        $$('.meanbee-postcode-element').each(function(el) {
            el.addClassName('invisible')
        });
        $('meanbee:account_show_another').removeClassName('invisible');
        $('meanbee:account_address_selector').addClassName('invisible');
    },

    clearFields: function($super) {
        var formElements = new Array(
            $('company'),
            $('zip'),
            $('street_1'),
            $('street_2'),
            $('street_3'),
            $('city'),
            $('region'),
            $('region_id')
        );
        $super(formElements);
    }
});

