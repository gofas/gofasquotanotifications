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

if (!defined("WHMCS")) { die("Esse arquivo não pode ser acessado diretamente");}
use WHMCS\Database\Capsule;

function gofasquotanotifications_config() {
	
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
	
	$moduleVersion	= '1.1';
    
	return array(
        'name' =>  $moduleName,
        'description' => $moduleDescription,
        'author' => $author, 
        'language' => 'portuguese-br',
        'version' => $moduleVersion,
        'fields' => array(
            
			'license_key' => array(
                'FriendlyName' => $licenseKey,
                'Type' => 'text',
                'Size' => '90',
                'Default' => '',
                'Description' => $licenseKeyDesc,
            ),
			
            'whmcs_admin' => array(
                'FriendlyName' => $whmcsAdmin,
                'Type' => 'text',
                'Size' => '1',
                'Default' => '1',
                'Description' => $whmcsAdminDesc,
            ),
			
			'percentage_disk_alert' => array(
                'FriendlyName' => $percentageDiskAlert,
                'Type' => 'text',
                'Size' => '1',
                'Default' => '95',
                'Description' => $percentageDiskAlertDesc,
            ),
			
			/*
			'percentage_disk_suspend' => array(
                'FriendlyName' => $percentageDiskSuspend,
                'Type' => 'yesno',
                'Description' => $percentageDiskSuspendDesc,
            ),
           */
            'percentage_bandwidth_alert' => array(
                'FriendlyName' => $percentageBandwidthAlert,
                'Type' => 'text',
                'Size' => '1',
                'Default' => '95',
                'Description' => $percentageBandwidthAlertDesc,
            ),
			
			/* 'percentage_bandwidth_suspend' => array(
                'FriendlyName' => $percentageBandwidthSuspend,
                'Type' => 'yesno',
                'Description' => $percentageBandwidthSuspendDesc,
            ), */
			
			'email_template' => array(
                'FriendlyName' => $emailTemplate,
                'Type' => 'text',
                'Size' => '20',
                'Description' => $emailTemplateDesc,
            ),
			
            /* 'notifications_time_lapse' => array(
                'FriendlyName' => $notificationsTimeLapse,
                'Type' => 'dropdown',
                'Default' => 'option1',
				'Options' => array(
                    'option1' => $notificationsTimeLapse1,
                    'option2' => $notificationsTimeLapse2,
                    'option3' => $notificationsTimeLapse3,
                ),
                'Description' => $notificationsTimeLapseDesc,
            ), */
			
			'debug' => array(
                'FriendlyName' => $debug,
                'Type' => 'yesno',
                'Description' => $debugDesc,
            ),
			'dept_id' => array(
                'FriendlyName' => $deptID,
                'Type' => 'text',
                'Size' => '1',
                'Description' => $deptIDDesc,
            ),
			
			'footer' => array(
				'Description' => $gqn_footer,
			),
        )
    );
}