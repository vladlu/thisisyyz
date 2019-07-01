/**
 * Admin scripts.
 *
 * Functionality for admin panel.
 *
 * @author Vladislav Luzan
 * @since 1.0.0
 */
'use strict';


jQuery( $ => {
    /*
     * Disables revisions option.
     */
    $( "input[name='_bbp_allow_revisions']" ).prop( 'disabled', true );
});
