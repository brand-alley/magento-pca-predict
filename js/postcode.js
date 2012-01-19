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
    observe: function(a, page) {
        $('meanbee:' + a + '_address_find').observe('click', function (e) {
            var postcode = $F(a + ':postcode');
            if (postcode != '') {
                $('meanbee:' + a + '_address_selector').innerHTML = "<p>Loading...</p>";
                $('meanbee:' + a + '_address_selector').removeClassName('invisible');
                meanbee_postcode.fetchOptions(postcode, a, page);
            }
        });
        $('meanbee:' + a + '_input_address_manually').observe('click', function (e) {
            $$('.address-detail').each(function(el) {
                el.removeClassName('invisible')
            });
            $$('.meanbee-postcode-element').each(function(el) {
                el.addClassName('invisible');
            });
            $('meanbee:' + a + '_show_another').removeClassName('invisible');
            e.preventDefault();
        });

        $('meanbee:' + a + '_show_another_link').observe('click', function(e) {
            $$('.address-detail').each(function(el) {
                el.addClassName('invisible')
            });
            $$('.meanbee-postcode-element').each(function(el) {
                el.removeClassName('invisible');
            });
            $('meanbee:' + a + '_show_another').addClassName('invisible');
            $('meanbee:' + a + '_address_selector').addClassName('invisible');
            meanbee_postcode.clearFields(a);
            e.preventDefault();
        });
    },

    fetchOptions: function(p, a, page) {
        new Ajax.Request(BASE_URL + 'postcode/finder/multiple/', {
            method: 'get',
            parameters: 'postcode=' + p,
            onSuccess: function(t) {
                var j = t.responseJSON;

                if (!j.error) {
                    var c = '<select id="meanbee:' + a + '_address_selector_select">';
                    for(var i = 0; i < j.content.length; i++) {
                        c += '<option value="' + j.content[i].id + '">' + j.content[i].description + '</option>'
                    }
                    c+= '</select>';
                    if (page == "backend") {
                        $('meanbee:' + a + '_address_selector').innerHTML = c + ' <p><button onclick="meanbee_postcode.fillBackendFields($F(\'meanbee:billing_address_selector_select\'), \'billing\')" type="button">Select as Billing Address</button> <button onclick="meanbee_postcode.fillBackendFields($F(\'meanbee:billing_address_selector_select\'), \'shipping\')" type="button">Select as Shipping Address</button></p>';
                    } else {
                        $('meanbee:' + a + '_address_selector').innerHTML = '<div class="field">' + c + '</div>' + ' <div class="field"><button onclick="meanbee_postcode.fillFields($F(\'meanbee:' + a + '_address_selector_select\'), \'' + a + '\')" type="button" class="button"><span><span>Select Address</span></span></button></div>';
                    } 
                    //$('meanbee:' + a + '_address_selector').innerHTML += '<br /><small><b>Note:</b> Please select your address from the above drop down menu before pressing "Select Address".</small>';
                } else {
                    meanbee_postcode.error(j.content, a);
                }
            }
        });
    },
    
    fillFields: function(id, a) {                
        new Ajax.Request(BASE_URL + 'postcode/finder/single/', {
            method: 'get',
            parameters: 'id=' + id,
            onSuccess: function(t) {
                var j = t.responseJSON;

                if (!j.error) {
                    var lines = new Array(j.content.line1, j.content.line2, j.content.line3, j.content.line4);
                    var concat_line = null;

                    $(a + ':country_id').value = 'GB';
                    eval(a + 'RegionUpdater.update();');
                    
                    for (var i =0; i < 4; i++) {
                        if (typeof(lines[i]) != "undefined" &&  $(a + ':street' + (i+1)) != null) {
                            $(a + ':street' + (i+1)).value = lines[i];
                        } else if ($(a + ':street' + (i+1)) != null) {
                            $(a + ':street' + (i+1)).value = '';
                        } else if (typeof(lines[i]) != "undefined") {
                            if (concat_line == null) {
                                concat_line = i - 1;
                            }

                            $(a + ':street' + (concat_line+1)).value += ', ' + lines[i];
                        }
                    }

                    if (typeof(j.content.organisation_name) != "undefined") {
                        $(a + ':company').value = j.content.organisation_name;
                    } else {
                        $(a + ':company').value = '';
                    }
                    
                    if (typeof(j.content.post_town) != "undefined") {
                        $(a + ':city').value = j.content.post_town;
                    } else {
                        $(a + ':city').value = '';
                    }
                    
                    if (typeof(j.content.county) != "undefined") {
                        $(a + ':region').value = j.content.county;
                    } else {
                        $(a + ':region').value = '';
                    }
                    
                    $(a + ':postcode').value = j.content.postcode;

                    //$('meanbee:' + a + '_address_selector').innerHTML = '&nbsp;';

                    $$('.address-detail').each(function(el) {
                        el.removeClassName('invisible')
                    });
                    $$('.meanbee-postcode-element').each(function(el) {
                        el.addClassName('invisible')
                    });
                    $('meanbee:' + a + '_show_another').removeClassName('invisible');
                    $('meanbee:' + a + '_address_selector').addClassName('invisible');
                } else {
                    meanbee_postcode.error(j.content, a);
                }
            }
        });
    },

    fillBackendFields: function(id, a) {                
        new Ajax.Request(BASE_URL + 'postcode/finder/single/', {
            method: 'get',
            parameters: 'id=' + id,
            onSuccess: function(t) {
                var j = t.responseJSON;

                var field_prefix = 'order-' + a + '_address_';

                if (!j.error) {
                    var lines = new Array(j.content.line1, j.content.line2, j.content.line3, j.content.line4);
                    var concat_line = null;

                    $(field_prefix + 'country_id').value = 'GB';
                    
                    for (var i =0; i < 4; i++) {
                        if (typeof(lines[i]) != "undefined" &&  $(field_prefix + 'street' + (i)) != null) {
                            $(field_prefix + 'street' + (i)).value = lines[i];
                        } else if ($(field_prefix + 'street' + (i)) != null) {
                            $(field_prefix + 'street' + (i)).value = '';
                        } else if (typeof(lines[i]) != "undefined") {
                            if (concat_line == null) {
                                concat_line = i - 1;
                            }

                            $(field_prefix + 'street' + (concat_line)).value += ', ' + lines[i];
                        }
                    }

                    if (typeof(j.content.organisation_name) != "undefined") {
                        $(field_prefix + 'company').value = j.content.organisation_name;
                    } else {
                        $(field_prefix + 'company').value = '';
                    }
                    
                    if (typeof(j.content.post_town) != "undefined") {
                        $(field_prefix + 'city').value = j.content.post_town;
                    } else {
                        $(field_prefix + 'city').value = '';
                    }
                    
                    if (typeof(j.content.county) != "undefined") {
                        $(field_prefix + 'region').value = j.content.county;
                    } else {
                        $(field_prefix + 'region').value = '';
                    }
                    
                    $(field_prefix + 'postcode').value = j.content.postcode;

                    $('meanbee:billing_address_selector').innerHTML = '&nbsp;';
                } else {
                    meanbee_postcode.error(j.content, a);
                }
            }
        });
    },

    clearFields: function(a) {                
        var formElements = new Array(
            $(a + ':company'),
            $(a + ':postcode'),
            $(a + ':street1'),
            $(a + ':street2'),
            $(a + ':street3'),
            $(a + ':city'),
            $(a + ':region'),
            $(a + ':region_id')
        );

        formElements.each(function(el) {
            if (el != null) {
                el.value = '';
            }
        });



    },


    error: function(m, a) {
        $('meanbee:' + a + '_address_selector').innerHTML = '&nbsp;';
        alert(m);
    }

});


