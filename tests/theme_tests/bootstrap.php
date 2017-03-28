<?php
require_once dirname( dirname( __FILE__ ) ) . '/includes/functions.php';

function _manually_load_environment() {
        
    // Add your theme …
    switch_theme('hellodorado');
    //      
    // Update array with plugins to include ...
    $plugins_to_active = array(
         'akismet/akismet.php',
         'custom-field-suite/custom-field-suite.php',
         'custom-post-type-ui/custom-post-type-ui.php',
         'encyclopedia-pro/encyclopedia-pro.php',
         'hello/hello.php',
         'wd-twitter-feed/wd-twitter-feed.php'
    );
    
    update_option( 'active_plugins', $plugins_to_active );
    
}
tests_add_filter( 'muplugins_loaded', '_manually_load_environment' );
    
require dirname( dirname( __FILE__ ) ) . '/includes/bootstrap.php';
