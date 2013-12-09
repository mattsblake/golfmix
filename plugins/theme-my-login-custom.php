<?php
function tml_new_user_registered( $user_id ) {
	wp_set_auth_cookie( $user_id, false, is_ssl() );
	$referer = remove_query_arg( array( 'action', 'instance' ), wp_get_referer() );
	wp_redirect( $referer );
	exit;
}
add_action( 'tml_new_user_registered', 'tml_new_user_registered' );

function tml_register_form() {
	wp_original_referer_field( true, 'previous' );
}
add_action( 'register_form', 'tml_register_form' );
?>