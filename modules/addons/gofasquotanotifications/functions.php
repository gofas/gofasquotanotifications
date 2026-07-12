<?php
/**
 * Gofas Notificações de Cota de Hospedagem para WHMCS
 * @author		Mauricio Gofas | gofas.net
 * @see			https://gofas.net/?p=9633
 * @copyright	2017 https://gofas.net
 * @license		https://gofas.net/?p=9340
 * @support		https://gofas.net/forums/
 * @version		2.1.0
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

// Telemetria: checagem de versão / contabilização de instalação ativa (sempre identificado, sem consentimento pois este módulo não tem evento de charge)
function gqn_module_version(){
	return '2.1.0';
}
function gqn_current_admin(){
	$currentUser = new \WHMCS\Authentication\CurrentUser;
	$admin = json_decode(json_encode($currentUser->admin()),true);
	return $admin;
}
function gqn_sysinfo(){
	foreach( Capsule::table('tblconfiguration')->where('setting','=','Version')->get(['value']) as $data1 ){
		$Version = $data1->value;
	}
	foreach( Capsule::table('tblconfiguration')->where('setting','=','CronPHPVersion')->get(['value']) as $data1 ){
		$PHPVersion = $data1->value;
	}
	return '&whmcs_version='.$Version.'&php_version='.$PHPVersion;
}
function gqn_verify(){
	$current_admin = gqn_current_admin();
	$install_url = gqn_SystemURL();
	$query = '?software_id=9633&install_url='.$install_url.'&current_version='.gqn_module_version().'&installer_email='.$current_admin['email'].'&installer_firstname='.$current_admin['firstname'].'&installer_lastname='.$current_admin['lastname'].'&action=verify'.gqn_sysinfo();
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,0);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($curl, CURLOPT_URL, 'https://gofas.net/br/updates/stats.php'.$query);
	$response = curl_exec($curl);
	$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl);
	return ['query'=>$query,'response'=>$response,'http_code'=>$http_status];
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