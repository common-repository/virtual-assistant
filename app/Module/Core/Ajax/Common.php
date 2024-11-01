<?php

namespace EWVA\Module\Core\Ajax;


class Common {

	/**
	 * Constuctor
	 * 
	 */
	function __construct() {
		add_action( 'wp_ajax_helpgent_user_config', [ $this, 'save_user_details' ] );
		add_action( 'wp_ajax_nopriv_helpgent_user_config', [ $this, 'save_user_details' ] );
	}
	

    public function save_user_details() {
		
        if ( ! directorist_verify_nonce( 'nonce' ) ) {
			$data['error']   = 1;
			$data['error_log']   = 'nonce_failed';
			$data['message'] = __( 'Something is wrong! Please refresh and retry.', 'directorist-power-ups' );

			wp_send_json_error( $data, 400 );
		}

		if ( ! $_POST ) {
			$data['error']   = 1;
			$data['error_log']   = 'data_missing';
			$data['message'] = __( 'Data missing.', 'directorist-power-ups' );

			wp_send_json_error( $data, 400 );
		}
         
		unset( $_POST['action'] );
		unset( $_POST['nonce'] );

		update_user_meta( get_current_user_id(), "_helpgent_config", directorist_clean( wp_unslash( $_POST ) ) );

		wp_send_json_success( [
			'message' => __( 'Successfully saved! ', 'directorist-power-ups' ),
		] );
	
	}

   

}