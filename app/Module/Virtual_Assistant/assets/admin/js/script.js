(function($) {
    'use strict';
    
    $(document).ready(function() {
        if($("body").hasClass("toplevel_page_virtual_assistant") ||
        $("body").hasClass("virtual-assistants_page_add_command") ||
        $("body").hasClass("virtual-assistants_page_virtual_assistant_settings") ||
        $("body").hasClass("virtual-assistants_page_va_wpbb_about")){
            $('html.wp-toolbar').addClass('wpsg_active');
            var html = '<div class="wpsg_raiting">Enjoyed <b>Virtual Assistant for Wordpress</b>? Please leave us a <div class="wpsg_content_star">';
                html += ' <a href="mailto:rafiq.exlac@gmail.com" class="wpsg_star_1 fa fa-star" title = "Really bad"></a> ';
                html += ' <a href="mailto:rafiq.exlac@gmail.com" class="wpsg_star_2 fa fa-star" title ="Bad"></a>';
                html += ' <a href="mailto:rafiq.exlac@gmail.com" class="wpsg_star_3 fa fa-star" title = "Okay"></a>';
                html += ' <a href="https://wordpress.org/plugins/virtual-assistant" target="_blank" class="wpsg_star_4 fa fa-star" title = "Good"></a>';
                html += ' <a href="https://wordpress.org/plugins/virtual-assistant" target="_blank" class="wpsg_star_5 fa fa-star" title = "Very good"></a>';
                html += '</div> rating. We really appreciate your support!</div>';
            $('#footer-left').html(html);
            $('.wpsg_star_4').on('click',function(){
                setTimeout(function(){
                    window.location.href = "mailto:rafiq.exlac@gmail.com";
                }, 1000);
            });
        }
        $('.bb-button-delete').on('click', function(){
            var $self = $(this),
                id = $self.data('id'),
                $table = $self.closest('table').DataTable(),
                $row = $self.closest('tr');
                
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Command!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then(function(willDelete){
                
                if (willDelete) {
                    $('.bb-ajax-loading').css({display: 'flex'});
                    $.post(ajaxurl, { 'action': 'rc_delete_shortcode', id: id }, function(response) {
                        
                        response = JSON.parse(response);
                        if(typeof response.status != 'undefined') {
                            $.growl({ title: response.title, message: response.message, location: 'br', style: response.status });
                            
                            if(response.status == 'notice') {
                                $table.row($row).remove();
                                $table.draw();
                            }
                        }
                        
                        $('.bb-ajax-loading').css({display: 'none'});
                        
                    });
                }
            });
            
            return;
            
            
        });
    });
}(window.jQuery));