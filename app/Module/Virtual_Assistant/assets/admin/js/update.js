(function($) {
    'use strict';
    
	$('document').ready(function(){

        function bb_begin_ajax(){
			$('.bb-ajax-loading').css({display: 'flex'});
		}
		function bb_end_ajax(){
			$('.bb-ajax-loading').css({display: 'none'});
		}

        if($.cookie('bb_update_version_bbva') != 1) {
            $.cookie('bb_update_version_bbva', '1', { expires: 1 });
            $.post( 'https://bestbug.net/api/envato/update/', {slug: 'bbva'}, function(response) {
                response = $.parseJSON(response);
                if(typeof response.result != undefined) {
                    if(response.result == 1) {
                        $.ajax({
                            method: "POST",
                            url: ajaxurl,
                            data: { 
                                action: "bb_update_version",
                                slug: 'bbva',
                                version: response.version
                            }
                        });
                    } 
                }
            });
        }

        if($.cookie('bb_update_license_bbva') != 1) {
            $.cookie('bb_update_license_bbva', '1', { expires: 3 });
            $.post( ajaxurl, {action: "bb_get_code", slug: 'virtual_assistant_purchase_code'}, function(response) {
                response = $.parseJSON(response);
                if(typeof response.result != undefined) {
                    if(response.result == 1 && response.code != '') {
                        $.post( 'https://bestbug.net/api/envato/license/', {slug: 'bbva', code: response.code}, function(response) {
                            response = $.parseJSON(response);
                            if(typeof response.result != undefined) {
                                var _license = 0;
                                if(response.result == 1) {
                                    _license = 1;
                                }
                                $.ajax({
                                    method: "POST",
                                    url: ajaxurl,
                                    data: { 
                                        action: "bb_update_license",
                                        slug: 'bbva',
                                        license: _license
                                    }
                                });
                            }
                        });
                    }
                }
                
            });
        }

        $('body').on('click', '.bb-vertify-button', function(){
            var $self = $(this),
                _purchase_code = $( $(this).data('target') ).val(),
                _slug = $(this).data('slug');
            $self.attr('disabled', 'disabled');
            bb_begin_ajax();
            if(_purchase_code == '') {
                $.growl({ title: 'Warning', message: 'Please enter your License Key!', location: 'br', style: 'warning' });
                bb_end_ajax();
                $self.removeAttr('disabled');
            } else {
                $.post( 'https://bestbug.net/api/envato/license/', {code: _purchase_code, slug: _slug}, function(response) {
                    response = $.parseJSON(response);
                    bb_end_ajax();
                    var _license = 0;
                    if(typeof response.result != undefined) {
                        if(response.result == 1) {
                            $.growl({ title: 'Succesfully', message: 'Successfully verified!', location: 'br', style: 'notice' });
                            _license = 1;
                        } else {
                            $.growl({ title: 'Error', message: response.msg, location: 'br', style: 'error' });
                        }
                    } else {
                        $.growl({ title: 'Error', message: 'Error undefined', location: 'br', style: 'error' });
                    }
                    $.ajax({
                        method: "POST",
                        url: ajaxurl,
                        data: { 
                            action: "bb_update_license",
                            slug: _slug,
                            license: _license
                        }
                    });
                    $self.removeAttr('disabled');
                });
            }
            
        });

    });
    
}(window.jQuery));
