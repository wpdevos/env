(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

    $(function() {

        /**
         * Check admin actions elements with data attribute
         */

        $('*[data-admin-action]').click(function(e){

            e.preventDefault();

            var admin_action = $(this).attr('data-admin-action');

            switch (admin_action) {

                case 'add_env':

                    var row = $('.env_box:first').clone();
                    $('input', row).val('');
                    $('input', row).attr('disabled', false);
                    $('.delete_on_clone', row).remove();

                    $('.env_box:last').after(row);
                    break;

                case 'add_fill_form_old_config':

                    var currentConfig = JSON.parse($(this).attr('data-current-config'));

                    var inputs = $('.env_box:first').find('input');

                    $.each(currentConfig, function(i,v){

                        //console.log($(v).attr('name'));
                        //console.log(currentConfig[i]);

                        var split = i.split('_');
                        var elementName = 'wpdevos_env_settings[default]['+split[0]+']['+split[1]+']';

                        $.each(inputs, function(inputIndex, inputObject){

                            if ( $(inputObject).attr('name') == elementName) {

                                $(inputObject).val(v);

                            }

                        });
                    });

                    break;

                case 'sys_replace_wpconfig':

                    $.post(
                        ajaxurl,
                        {
                            'action': 'add_foobar',
                            'data':   'foobarid'
                        },
                        function(response){
                            //alert('The server responded: ' + response);
                            console.log(response);
                        }
                    );

                    break;
            }


        });

    });

})( jQuery );
