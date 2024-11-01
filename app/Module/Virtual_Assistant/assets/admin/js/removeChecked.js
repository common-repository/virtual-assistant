(function($) {
	'use strict';

	$(document).ready(function(){
        
        $('.checked_remove').on('click', function(){
            list_get_ids();
        });

        $('.delete_checked_ids').on('click', function(){

            var ids = $( '#ids_checked_remove' ).val();

            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover these command!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then(function(willDeleteChecked){
                if (willDeleteChecked) {
                    $('.bb-ajax-loading').css({display: 'flex'});
                    $.post(ajaxurl, { 'action': 'bbsm_delete_checked_as', ids: ids }, function(response) {
                        var ar_ids = ids.split(",");
                        $.each( ar_ids, function( key, value ) {
                            $('#checked_remove-'+value).closest('tr').remove();
                        });
                        $('.bb-ajax-loading').css({display: 'none'});
                        
                        $.growl({ title: 'Deleted!', message: "Command(s) is deleted!", location: 'br', style: 'notice' });
                    });
                }
            });

            

            return;
        });

        $('#checked_all_remove').on('click', function(){
            var listIds = new Array();
            if( $(this).is( ':checked') ){
                $(this).val(1);

                $( '.checked_remove' ).each( function() {
                    listIds.push( $( this ).data( 'id' ) );
                });
                if ( listIds.length > 0 ) {
                    $( ".checked_remove" ).prop( "checked", true );
                    $( '#ids_checked_remove' ).val( listIds.join( ',' ) );
                    $('.bb_remove_all').show();
                }

            }else{
                $(this).val('');
                $( ".checked_remove" ).prop( "checked", false );
                $( '#ids_checked_remove' ).val( '' );
                $('.bb_remove_all').hide();
            }
        });

        function list_get_ids() {
            var listId = new Array();
            $( '.checked_remove' ).each( function() {
                if( $(this).is( ':checked') ){
                    $(this).val(1);
                    listId.push( $( this ).data( 'id' ) );
                }else{
                    $(this).val('');
                }
            } );
            if ( listId.length > 0 ) {
                $( '#ids_checked_remove' ).val( listId.join( ',' ) );
                $('.bb_remove_all').show();
            } else {
                $( '#ids_checked_remove' ).val( '' );
                $('.bb_remove_all').hide();
            }
        }

	});
	
}(window.jQuery));