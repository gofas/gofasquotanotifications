<?php
/**
 * Gofas Notificações de Cota de Hospedagem para WHMCS
 * @author		Mauricio Gofas | gofas.net
 * @see			https://gofas.net/?p=9633
 * @copyright	2017 https://gofas.net
 * @license		https://gofas.net/?p=9340
 * @support		https://gofas.net/forums/
 * @version		2.0.0
 */

use WHMCS\Database\Capsule;
require_once __DIR__ . '/../../../init.php';
require_once __DIR__ . '/functions.php';

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