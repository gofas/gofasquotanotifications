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
require_once __DIR__ . '/../../../init.php';
require_once __DIR__ . '/functions.php';
/**
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 */
// Receive
if( $_POST['status'] and $_POST['action'] and $_POST['hash'] ) {
	
	// Get license_key
	foreach( Capsule::table('tbladdonmodules') -> where('module', '=', 'gofasquotanotifications') -> get( array( 'setting', 'value') ) as $settings ) {
		$setting_key				= $settings->setting;
		$setting["$setting_key"]	= $settings->value;
	}
	$license_key					= $setting['license_key']; 
 
	$secret_key			= '9c63f8941f7f874e4cd00d6a3c14ff31';
	$hash_composition	= 'Jka90skmLSm0838nAM5a4pQ89B'.$license_key.$secret_key;
	$local_hash			= sha1( $hash_composition );
	$post_status		= $_POST['status'];
	$post_action		= $_POST['action'];
	$post_hash			= $_POST['hash'];
	if ( $post_status === 's' and $post_action === 'e' and $local_hash === $post_hash ) {
		try {
			Capsule::table('tblconfiguration')->
			where( 'setting', 'gqnlocalkey')->
			update(array('value' => 'e', 'created_at' =>  $local_key_created_at , 'updated_at' => date("Y-m-d H:i:s")));		
			echo 'e';
		}
		catch (\Exception $e) {
    		echo $e->getMessage();
		}
	}
	else {
		echo '!e';
	}
}
unset($secret_key);
////
add_hook('DailyCronJob', 1, function(array $params) {

	// System config
	$system_url		= gqn_SystemURL();
		
	// Languages
	foreach( Capsule::table('tblconfiguration') -> where('setting', '=', 'Language') -> get( array('value')) as $language ) {
		$lang		= $language->value;
	}
	
	if ( file_exists( __DIR__. '/lang/'.$lang.'.php' ) ) {
		include __DIR__. '/lang/'.$lang.'.php';
	}
	else {
		include __DIR__. '/lang/english.php';
	}
	// Get module params
	foreach( Capsule::table('tbladdonmodules') -> where('module', '=', 'gofasquotanotifications') -> get( array( 'setting', 'value') ) as $settings ) {
		$setting_key				= $settings->setting;
		$setting["$setting_key"]	= $settings->value;
	}
	if ($setting['whmcs_admin']) {
		$admin						= $setting['whmcs_admin'];
	} else {
		$admin						= 1;
	}
	$percentage_disk_alert			= $setting['percentage_disk_alert'];
	$percentage_disk_suspend		= $setting['percentage_disk_suspend'];
	$percentage_bandwidth_alert		= $setting['percentage_bandwidth_alert'];
	$percentage_bandwidth_suspend	= $setting['percentage_bandwidth_suspend'];
	$email_template					= $setting['email_template'];
	$notifications_time_lapse		= $setting['notifications_time_lapse'];
	$debug							= $setting['debug'];
	$dept_id						= (int)$setting['dept_id'];
	$license_key					= $setting['license_key'];
	
/**
 *
 * Check Start
 *
 */
	 
function g_check_license( $license_key, $local_key ) {
    $gofas = 'https://gofas.net/cliente/';
    $secret_key = '9c63f8941f7f874e4cd00d6a3c14ff31';
    $local_key_days = 7;
    $allowcheckfaildays = 3;
    // ----------------- Start Verification ------------------
    $check_token = time() . md5(mt_rand(1000000000, 9999999999) . $license_key);
    $checkdate = date("Ymd");
    $domain = $_SERVER['SERVER_NAME'];
    $usersip = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : $_SERVER['LOCAL_ADDR'];
    $dirpath = dirname(__FILE__);
    $verifyfilepath = 'modules/servers/licensing/verify.php';
    $local_key_valid = false;
    if ($local_key) {
        $local_key = str_replace("\n", '', $local_key); # Remove the line breaks
        $localdata = substr($local_key, 0, strlen($local_key) - 32); # Extract License Data
        $md5hash = substr($local_key, strlen($local_key) - 32); # Extract MD5 Hash
        if ($md5hash == md5($localdata . $secret_key)) {
            $localdata = strrev($localdata); # Reverse the string
            $md5hash = substr($localdata, 0, 32); # Extract MD5 Hash
            $localdata = substr($localdata, 32); # Extract License Data
            $localdata = base64_decode($localdata);
            $local_key_results = unserialize($localdata);
            $originalcheckdate = $local_key_results['checkdate'];
            if ($md5hash == md5($originalcheckdate . $secret_key)) {
                $localexpiry = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - $local_key_days, date("Y")));
                if ($originalcheckdate > $localexpiry) {
                    $local_key_valid = true;
                    $results = $local_key_results;
                    $validdomains = explode(',', $results['validdomain']);
                    if (!in_array($_SERVER['SERVER_NAME'], $validdomains)) {
                        $local_key_valid = false;
                        $local_key_results['status'] = "Invalid";
                        $results = array();
                    }
                    $validips = explode(',', $results['validip']);
                    if (!in_array($usersip, $validips)) {
                        $local_key_valid = false;
                        $local_key_results['status'] = "Invalid";
                        $results = array();
                    }
                    $validdirs = explode(',', $results['validdirectory']);
                    if (!in_array($dirpath, $validdirs)) {
                        $local_key_valid = false;
                        $local_key_results['status'] = "Invalid";
                        $results = array();
                    }
                }
            }
        }
    }
    if (!$local_key_valid) {
        $responseCode = 0;
        $postfields = array(
            'licensekey' => $license_key,
            'domain' => $domain,
            'ip' => $usersip,
            'dir' => $dirpath,
        );
        if ($check_token) $postfields['check_token'] = $check_token;
        $query_string = '';
        foreach ($postfields AS $k=>$v) {
            $query_string .= $k.'='.urlencode($v).'&';
        }
        if (function_exists('curl_exec')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $gofas . $verifyfilepath);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec($ch);
            $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
        }
		elseif(!function_exists('curl_exec')){
			die('Curl PHP Extension Missing');
		}
        if ($responseCode != 200) {
            $localexpiry = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - ($local_key_days + $allowcheckfaildays), date("Y")));
            if ($originalcheckdate > $localexpiry) {
                $results = $local_key_results;
            } else {
                $results = array();
                $results['status'] = "Invalid";
                $results['description'] = "Remote Check Failed. Response code ".$responseCode;
                return $results;
            }
        } else {
            preg_match_all('/<(.*?)>([^<]+)<\/\\1>/i', $data, $matches);
            $results = array();
            foreach ($matches[1] AS $k=>$v) {
                $results[$v] = $matches[2][$k];
            }
        }
        if (!is_array($results)) {
            die("Invalid License Server Response");
        }
        if ($results['md5hash']) {
            if ($results['md5hash'] != md5( $secret_key . $check_token )) {
                $results['status'] = "Invalid";
                $results['description'] = "MD5 Checksum Verification Failed";
                return $results;
            }
        }
        if ($results['status'] == "Active") {
            $results['checkdate'] = $checkdate;
            $data_encoded = serialize($results);
            $data_encoded = base64_encode($data_encoded);
            $data_encoded = md5($checkdate . $secret_key) . $data_encoded;
            $data_encoded = strrev($data_encoded);
            $data_encoded = $data_encoded . md5($data_encoded . $secret_key);
            $data_encoded = wordwrap($data_encoded, 80, "\n", true);
            $results['local_key'] = $data_encoded;
        }
        $results['remotecheck'] = true;
    }
    unset($postfields,$data,$matches,$gofas,$checkdate,$usersip,$local_key_days,$allowcheckfaildays,$md5hash);
	return $results;
}

// Get local_key
foreach( Capsule::table('tblconfiguration') -> where('setting', '=', 'gqnlocalkey') -> get( array( 'setting', 'value', 'created_at' ) ) as $local_key_info ) {
	$local_key_setting		= $local_key_info->setting;
	$local_key_value		= $local_key_info->value;
	$local_key_created_at	= $local_key_info->created_at;
}
if ($debug) {
	$gqn_log = array();
}
if ( $local_key_value ) {
	$local_key	= $local_key_value;
	if($debug) {
		$gqn_log['local_key_status']	= "Local Key Exist\n";
		$gqn_log['local_key']	= substr($local_key_value, 0, 25). "(...)". substr($local_key_value, -25). "\n";
		$gqn_log['created_at']	= $local_key_created_at. "\n";
	}
}
elseif( !$local_key_value ) {
	$local_key = false;
	if($debug) { $gqn_log['status']	= "Local Key Not Exist\n"; }
}
/**
 * Validate license key information
 */
$results = g_check_license( $license_key, $local_key );
if ($debug) { 
	$gqn_log['license_info']	= "License Info\n";
	$gqn_log['status']			= $results['status']."\n";
	$gqn_log['registeredname']	= $results['registeredname']."\n";
	$gqn_log['companyname']		= $results['companyname']."\n";
	$gqn_log['email']			= $results['email']."\n";
	$gqn_log['productname']		= $results['productname']."\n";
	$gqn_log['regdate']			= $results['regdate']."\n";
	$gqn_log['nextduedate']		= $results['nextduedate']."\n";
	$gqn_log['billingcycle']	= $results['billingcycle']."\n";
	$gqn_log['validdomain']		= $results['validdomain']."\n";
	$gqn_log['validip']			= $results['validip']."\n";
	$gqn_log['validdirectory']	= $results['validdirectory']."\n";
	$gqn_log['checkdate']		= $results['checkdate']."\n";
}
// Interpret response
if ($results['status'] === "Active") {
    $local_key_data = $results['local_key'];
	if ( !$local_key_value ) {
		if($debug) { $gqn_log['validation']	= "Licença válida. Primeira local_key gravada\n"; }
		try {
			Capsule::table('tblconfiguration')->insert(array('setting' => 'gqnlocalkey', 'value' => $local_key_data, 'created_at' =>  date("Y-m-d H:i:s") , 'updated_at' => date("Y-m-d H:i:s") ));
		
		 	if($debug) { $gqn_log['inserction']	= "Coluna gqnlocalkey inserida\n"; }
		}
		catch (\Exception $e) {
   			$e->getMessage();
		}
	}
	elseif ( $local_key_value and $local_key_data ) {
		try {
			Capsule::table('tblconfiguration')->where( 'setting', 'gqnlocalkey')->update(array('value' => $local_key_data, 'created_at' =>  $local_key_created_at , 'updated_at' => date("Y-m-d H:i:s")));
					
			if($debug) { $gqn_log['update']	= "Licença válida, local_key atualizada\n"; }		
		}
		catch (\Exception $e) {
    		echo $e->getMessage();
		}
	}
}
elseif ($results['status'] === "Invalid" ) {
	$gqn_log['validation']	= "Licença Inválida";
	die("Licença Inválida");
}
elseif ($results['status'] === "Expired" ) {
	$gqn_log['validation']	= "Licença Expirada";
	die("Licença Expirada");
}
elseif ($results['status'] === "Suspended" ) {
	$gqn_log['validation']	= "Licença Suspensa";
	die("Licença Suspensa");		
}
else {
	$gqn_log['validation']	= "Resposta Inválida";
	die("Resposta Inválida.");  
}
if ($debug) {
	echo "<pre>";
	print_r($gqn_log);
	logModuleCall( 'gofasquotanotifications', 'check license', 'check license remotely', false, $gqn_log, false);
	echo '</pre>';
}

 
/**
 *
 * Check End
 *
 */

	if($debug){
		$log_description	.= '-------------------- Debug -------------------';
		$log_description	.= '<br>Settings:<pre>';
		$log_description	.= json_encode($setting, JSON_PRETTY_PRINT);
		$log_description	.= 	'<br><br>System URL: '.$system_url.'<br>';	
	}

	// Get usage statistics
	foreach( Capsule::table('tblhosting') -> get( array('id', 'userid', 'packageid', 'disklimit', 'diskusage', 'bwlimit', 'bwusage') ) as $tblhostings ) {
	
		$tblhosting["$tblhostings->id"]				= $tblhostings;
		$service_id									= $tblhostings->id;
		$user_id									= $tblhostings->userid;
		$diskusage									= $tblhostings->diskusage;	// MB
		$disklimit									= $tblhostings->disklimit;	// MB
		$bwusage									= $tblhostings->bwusage;	// MB
		$bwlimit									= $tblhostings->bwlimit;	// MB

		// Limite em MB para alerta | X % do limite = X mb
		$disklimit_alert							= ( $disklimit / 100 ) * $percentage_disk_alert;
		$bwlimit_alert								= ( $bwlimit / 100 ) * $percentage_bandwidth_alert;
	
		// % de uso
		$diskusage_percent							= ( $diskusage * 100 ) / $disklimit;
		$bwusage_percent							= ( $bwusage * 100 ) / $bwlimit;
	
		######## Debug ######## - Array de limites em mb para alerta | X % do limite = X mb
		if ($debug) {
			$diskusage_arr["$service_id"]				= $diskusage;	// MB
			$bwusage_arr["$service_id"]					= $bwusage;	// MB
			$disklimit_arr["$service_id"]				= $disklimit;	// MB
			$bwlimit_arr["$service_id"]					= $bwlimit;	// MB
			$disklimit_alert_arr["$service_id"]			= $disklimit_alert;
			$bwlimit_alert_arr["$service_id"]			= $bwlimit_alert;
			$diskusage_percent_arr["$service_id"]		= $diskusage_percent;
			$bwusage_percent_arr["$service_id"]			= $bwusage_percent;
		}
		######## Debug End ########

		// Resultados / definições
		if ( $diskusage > 0 and $diskusage >= $disklimit_alert and $disklimit > 0 ) {
			$disklimit_alert_exceeded_arr["$service_id"]['service_id']			= $service_id;
			$disklimit_alert_exceeded_arr["$service_id"]['user_id']				= $user_id;
			$disklimit_alert_exceeded_arr["$service_id"]['diskusage']			= $diskusage;
			$disklimit_alert_exceeded_arr["$service_id"]['disklimit']			= $disklimit;
			$disklimit_alert_exceeded_arr["$service_id"]['diskusage_percent']	= $diskusage_percent;
			$disklimit_alert_exceeded_arr["$service_id"]['disklimit_alert']		= $disklimit_alert;
		}
	
		if ( $bwusage > 0 and $bwusage >= $bwlimit_alert and $bwlimit > 0 ) {
			$bwlimit_alert_exceeded_arr["$service_id"]['service_id']		= $service_id;
			$bwlimit_alert_exceeded_arr["$service_id"]['user_id']			= $user_id;
			$bwlimit_alert_exceeded_arr["$service_id"]['bwusage']			= $bwusage;
			$bwlimit_alert_exceeded_arr["$service_id"]['bwlimit']			= $bwlimit;
			$bwlimit_alert_exceeded_arr["$service_id"]['bwusage_percent']	= $bwusage_percent;
			$bwlimit_alert_exceeded_arr["$service_id"]['bwlimit_alert']		= $bwlimit_alert;
		}

	} // end foreach

	// Constants Array of exceded limits 
	define("DisklimitAlertExceededArr", json_encode($disklimit_alert_exceeded_arr) );
	define("BwlimitAlertExceededArr", json_encode($bwlimit_alert_exceeded_arr) );

	//https://developers.whmcs.com/hooks-reference/everything-else/#EmailPreSend
	add_hook('EmailPreSend', 1, function($vars) {
		$rel_id								= $vars['relid'];
		if (!$vars['relid']) { $rel_id = 1; } // Evite error on SendAdminEmail local API execution
		
		$EmailPreSend						= array();
		$email_disklimit_alert_exceeded_arr	= json_decode(DisklimitAlertExceededArr);
		$email_bwlimit_alert_exceeded_arr	= json_decode(BwlimitAlertExceededArr);
		
		$EmailPreSend['diskusage']			= $email_disklimit_alert_exceeded_arr->$rel_id->diskusage;
		$EmailPreSend['disklimit']			= $email_disklimit_alert_exceeded_arr->$rel_id->disklimit;
		$EmailPreSend['diskusage_percent']	= $email_disklimit_alert_exceeded_arr->$rel_id->diskusage_percent;
		$EmailPreSend['disklimit_alert']	= $email_disklimit_alert_exceeded_arr->$rel_id->disklimit_alert;
		
		$EmailPreSend['bwusage']			= $email_bwlimit_alert_exceeded_arr->$rel_id->bwusage;
		$EmailPreSend['bwlimit']			= $email_bwlimit_alert_exceeded_arr->$rel_id->bwlimit;
		$EmailPreSend['bwusage_percent']	= $email_bwlimit_alert_exceeded_arr->$rel_id->bwusage_percent;
		$EmailPreSend['bwlimit_alert']		= $email_bwlimit_alert_exceeded_arr->$rel_id->bwlimit_alert;	
		$EmailPreSend['upgradeurl']			= gqn_SystemURL().'upgrade.php?type=package&id='.$rel_id;
		
		return $EmailPreSend;
	}); // end of EmailPreSend hook

	// send e-mails
	if ($debug) {
		$log_description	.= '<br>-------------------- Execution result -------------------<br>';
	}
		
	try {
		if ( $disklimit_alert_exceeded_arr ) {
			
			if ($debug) {
				$log_description	.= "<br>E-mails disparados notificando excesso de <b>Espaço em Disco</b>:<br>";
			}
			
			foreach ( $disklimit_alert_exceeded_arr as $disklimit_emailto_service_id => $disklimit_emailto_service_info) {
				
				$disklimit_alert_exceeded_email = gqn_SendEmail ( $admin, $disklimit_emailto_service_id, $email_template );
				
				$disklimit_emailto_service_id_arr[] = "<a href=".$system_url."admin/clientsservices.php?id=$disklimit_emailto_service_id>".$Service." ID #".$disklimit_emailto_service_id."</a><br>";
				
				if ($debug) {
					$log_description	.= $disklimit_alert_exceeded_email['result'];
					$log_description	.= " no envio para serviço ID #$disklimit_emailto_service_id<br>";
				}				

			} // end foreach		
			
		} //

		if ( $bwlimit_alert_exceeded_arr ) {
			if ($debug) {
				$log_description	.= "<br>E-mails disparados notificando excesso de uso de <b>Largura de Banda</b>:<br>";
			}
			foreach ( $bwlimit_alert_exceeded_arr as $bwlimit_emailto_service_id => $bwlimit_emailto_service_info) {
				
				$bwlimit_alert_exceeded_email = gqn_SendEmail ( $admin, $bwlimit_emailto_service_id, $email_template );
				
				$bwlimit_emailto_service_id_arr[] = "<a href=".$system_url."admin/clientsservices.php?id=$disklimit_emailto_service_id'>".$Service." ID #".$bwlimit_emailto_service_id."</a><br>";
				
				if ($debug) {
					$log_description	.= $bwlimit_alert_exceeded_email['result'];
					$log_description	.= " no envio para serviço ID #$bwlimit_emailto_service_id<br>";
				}
			}
		}
	} // end try
	
	catch (Exception $e) {
		$gqn_LogActivity	= gqn_LogActivity( $admin, $e );
    }
	// send admin e-mail report
	if ( $dept_id and ( $disklimit_emailto_service_id_arr || $bwlimit_emailto_service_id_arr ) ) {
		
		$admin_report_subject	= $AdminReportSubject;
		$admin_report_message	.= $AdminReportMessageIntro;
		
		if ( $disklimit_emailto_service_id_arr ) {
			$admin_report_message			.= $DiskAdminReportMessage;
			$disk_admin_report_message_json	= json_encode( $disklimit_emailto_service_id_arr, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
			$admin_report_message		    .= str_replace( array('["', '","', '"]') , '', $disk_admin_report_message_json );
		}
		
		if ( $bwlimit_emailto_service_id_arr ) {
			$admin_report_message			.= $BwAdminReportMessage;
			$bw_admin_report_message_json	= json_encode( $bwlimit_emailto_service_id_arr, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
			$admin_report_message			.= str_replace( array('["', '","', '"]') , '', $bw_admin_report_message_json );
		}
		
		$admin_report_message	.= $AdminReportMessageOutcome;
		
		$admin_report_send	= gqn_SendAdminEmail ( $admin_report_subject, $admin_report_message, $dept_id, $admin  );
		
		if($debug){
			$log_description	.= '<br>Resultado no envio de notificação para o admin: <b>' . json_encode($admin_report_send['result']) . '</b><br>'; 
		}
	}
	
	// Debug
	if($debug){
		$log_description	.= '<br>-------------------- Serviços - tblhosting --------------------<br><pre>';
		$log_description	.= json_encode($tblhosting, JSON_PRETTY_PRINT);
		
		$log_description	.= '<br>Uso do disco MB<br>';
		$log_description	.= json_encode($diskusage_arr, JSON_PRETTY_PRINT);
	
		$log_description	.= '<br>Uso do disco %<br>';
		$log_description	.= json_encode($diskusage_percent_arr, JSON_PRETTY_PRINT);
	
		$log_description	.= '<br>Limite em mb do disco <br>';
		$log_description	.= json_encode($disklimit_arr, JSON_PRETTY_PRINT);
	
		$log_description	.= '<br>Limite em MB do disco para alerta | MB<br>';
		$log_description	.= json_encode($disklimit_alert_arr, JSON_PRETTY_PRINT);
	
		$log_description	.= '<br>Serviços que excederam limite de disco para alerta<br>';
		$log_description	.= json_encode($disklimit_alert_exceeded_arr, JSON_PRETTY_PRINT);
	
		$log_description	.= '<br>Array dos serviços que excederam limite de banda para alerta<br>';
		$log_description	.= json_encode($bwlimit_alert_exceeded_arr, JSON_PRETTY_PRINT);
	
		$log_description	.= '</pre>-------------------- End Debug -------------------<br>';
	}	
	
	if ($debug) {
		echo $log_description;
		gqn_LogActivity( $admin, $log_description );
	}
	// Debug End	

}); // End DailyCronJob

// https://developers.whmcs.com/hooks-reference/everything-else/#EmailTplMergeFields
add_hook('EmailTplMergeFields', 1, function($vars) {
	
	// Languages
	foreach( Capsule::table('tblconfiguration') -> where('setting', '=', 'Language') -> get( array('value')) as $language ) {
		$lang		= $language->value;
	}
	
	if ( file_exists( __DIR__. '/lang/'.$lang.'.php' ) ) {
		include __DIR__. '/lang/'.$lang.'.php';
	}
	else {
		include __DIR__. '/../lang/english.php';
	}
	
	$EmailTplMergeFields = array();
		
    $EmailTplMergeFields['diskusage']			= $EmailTplDiskusage;
	$EmailTplMergeFields['disklimit']			= $EmailTplDisklimit;
	$EmailTplMergeFields['diskusage_percent']	= $EmailTplDiskusagePercent;
	$EmailTplMergeFields['disklimit_alert']		= $EmailTplDisklimitAlert;
		
	$EmailTplMergeFields['bwusage']				= $EmailTplBwUsage;
	$EmailTplMergeFields['bwlimit']				= $EmailTplBwLimit;
    $EmailTplMergeFields['bwusage_percent']		= $EmailTplBwUsagePercent;
	$EmailTplMergeFields['bwlimit_alert']		= $EmailTplBwLimitAlert;
	
	$EmailTplMergeFields['upgradeurl']			= $EmailTplUpgradeUrl;
		
    return $EmailTplMergeFields;
}); // End of EmailTplMergeFields