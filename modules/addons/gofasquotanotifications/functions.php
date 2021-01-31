<?php
/**
 * Gofas Notificações de Cota de Hospedagem para WHMCS
 * @author		Mauricio Gofas | gofas.net
 * @see			https://gofas.net/?p=9633
 * @copyright	2017 https://gofas.net
 * @license		https://gofas.net/?p=9340
 * @support		https://gofas.net/forums/
 * @version		1.1
 */
use WHMCS\Database\Capsule;

// System config
function gqn_SystemURL() {
	foreach( Capsule::table('tblconfiguration') -> where('setting', '=', 'SystemURL') -> get( array('value')) as $systemurl ) {
		return $systemurl->value;
	}
}

// https://developers.whmcs.com/api-reference/logactivity/ 
function gqn_LogActivity( $admin, $description ) {
	$postData = array(
    	'description' => $description,
	);

	$results = localAPI( 'LogActivity', $postData, $admin);
	return $results;
}

// http://developers.whmcs.com/api-reference/sendemail/
function gqn_SendEmail ( $admin, $user_id, $email_template ) {
	$postData = array(
    	'messagename' => $email_template,
    	'id' => $user_id,
	);

	$results = localAPI( 'SendEmail', $postData, $admin );
	return $results;
}

// https://developers.whmcs.com/api-reference/sendadminemail/
function gqn_SendAdminEmail ( $subject, $message, $deptid, $admin) { 
	//$command						= "SendAdminEmail";
	$postData = array(
    	'customsubject'						=> $subject,
    	'custommessage'						=> $message,
		'deptid'							=> $deptid,
	);

	$results = localAPI( 'SendAdminEmail', $postData, $admin );
	return $results;
}