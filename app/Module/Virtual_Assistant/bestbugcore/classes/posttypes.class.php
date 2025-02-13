<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Exlac_Core_Posttypes' ) ) {
	/**
	 * Exlac_Core_Posttypes Class
	 *
	 * @since	1.0
	 */
	class Exlac_Core_Posttypes {

        public $posttypes;
        
		/**
		 * Constructor
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			add_action( 'init', array( $this, 'register_posttypes' ) );
		}
        
        public function register_posttypes() {
            $this->posttypes = apply_filters( 'bb_register_posttypes', array() );

    		if( empty($this->posttypes) ) {
    			return;
    		}

    		foreach ($this->posttypes as $slug => $posttype) {
    			if( !empty($slug) ) {
    				register_post_type( $slug, $posttype );
    			}
    		}
        }
        
    }
	
	new Exlac_Core_Posttypes();
}

