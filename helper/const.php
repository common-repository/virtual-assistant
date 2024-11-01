<?php

if ( ! defined( 'EWVA_VERSION' ) ) {
    define( 'EWVA_VERSION', '0.3' );
}

if ( ! defined( 'EWVA_PREFIX' ) ) {
    define( 'EWVA_PREFIX', 'virtual-assistant' );
}

if ( ! defined( 'EWVA_DB_TABLE_PREFIX' ) ) {
    define( 'EWVA_DB_TABLE_PREFIX', EWVA_PREFIX );
}

if ( ! defined( 'EWVA_REST_BASE_PREFIX' ) ) {
    define( 'EWVA_REST_BASE_PREFIX', EWVA_PREFIX );
}

if ( ! defined( 'EWVA_IN_DEVELOPMENT' ) ) {
    define( 'EWVA_IN_DEVELOPMENT', SCRIPT_DEBUG );
}

if ( ! defined( 'EWVA_SCRIPT_VERSION' ) ) {
    define( 'EWVA_SCRIPT_VERSION', EWVA_VERSION );
}

if ( ! defined( 'EWVA_FILE' ) ) {
    define( 'EWVA_FILE', dirname( dirname( __FILE__ ) ) . '/dhgi.php' );
}

if ( ! defined( 'EWVA_BASE' ) ) {
    define( 'EWVA_BASE', dirname( dirname( __FILE__ ) ) . '/' );
}

if ( ! defined( 'EWVA_LANGUAGES' ) ) {
    define( 'EWVA_LANGUAGES', EWVA_BASE . 'languages' );
}

if ( ! defined( 'EWVA_POST_TYPE' ) ) {
    define( 'EWVA_POST_TYPE', 'virtual-assistant' );
}

if ( ! defined( 'EWVA_TEMPLATE_PATH' ) ) {
    define( 'EWVA_TEMPLATE_PATH', EWVA_BASE . 'templates/' );
}

if ( ! defined( 'EWVA_VIEW_PATH' ) ) {
    define( 'EWVA_VIEW_PATH', EWVA_BASE . 'view/' );
}

if ( ! defined( 'EWVA_URL' ) ) {
    define( 'EWVA_URL', plugin_dir_url( EWVA_FILE ) );
}

if ( ! defined( 'EWVA_ASSET_URL' ) ) {
    define( 'EWVA_ASSET_URL', EWVA_URL . 'assets/' );
}

if ( ! defined( 'EWVA_ASSET_SRC_PATH' ) ) {
    define( 'EWVA_ASSET_SRC_PATH', 'src/' );
}

if ( ! defined( 'EWVA_JS_PATH' ) ) {
    define( 'EWVA_JS_PATH', EWVA_ASSET_URL . 'js/' );
}

if ( ! defined( 'EWVA_VENDOR_JS_PATH' ) ) {
    define( 'EWVA_VENDOR_JS_PATH',  EWVA_ASSET_URL . 'js/vendor-js' );
}

if ( ! defined( 'EWVA_VENDOR_JS_SRC_PATH' ) ) {
    define( 'EWVA_VENDOR_JS_SRC_PATH', 'assets/vendor-js/' );
}

if ( ! defined( 'EWVA_CSS_PATH' ) ) {
    define( 'EWVA_CSS_PATH', EWVA_ASSET_URL . 'css/' );
}

if ( ! defined( 'EWVA_LOAD_MIN_FILES' ) ) {
    define( 'EWVA_LOAD_MIN_FILES', ! EWVA_IN_DEVELOPMENT );
}

// Meta Keys
if ( ! defined( 'EWVA_META_PREFIX' ) ) {
    define( 'EWVA_META_PREFIX',  EWVA_PREFIX . '_' );
}

if ( ! defined( 'EWVA_USER_META_AVATER' ) ) {
    define( 'EWVA_USER_META_AVATER', EWVA_META_PREFIX . 'user_avater' );
}

if ( ! defined( 'EWVA_USER_META_IS_GUEST' ) ) {
    define( 'EWVA_USER_META_IS_GUEST', EWVA_META_PREFIX . 'is_guest' );
}

if ( ! defined( 'EWVA_OPTIONS' ) ) {
    define( 'EWVA_OPTIONS', EWVA_META_PREFIX . 'options' );
}