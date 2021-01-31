<?php
/**
 * Gofas Quota Notifications for WHMCS
 * @author		Mauricio Gofas | gofas.net
 * @see			https://gofas.net/?p=9633
 * @copyright	2017 https://gofas.net
 * @license		https://gofas.net/?p=9340
 * @support		https://gofas.net/forums/
 * @version		1.1
 */
 
// English Settings Texts

$moduleName										= 'Gofas Quota Notifications';
$_ADDONLANG['moduleName']						= $moduleName;

$moduleDescription								= 'Warns your hosting clients when disk space and bandwidth are approaching or have already exceeded the limits.';
$_ADDONLANG['moduleDescription']				= $moduleDescription;

$author											= '<a title="Gofas - Advanced Solutions for WordPress and WHMCS" href="https://gofas.net/" target="_blank" alt="Gofas"><img src="/modules/addons/gofasquotanotifications/lib/logo.png"></a>';
$_ADDONLANG['author']							= $author;

$licenseKey										= 'Chave de Licença';
$_ADDONLANG['licenseKey']						= $licenseKey;

$licenseKeyDesc									= 'Insira a chave de licença fornecida no momento da compra do módulo. Você pode encontrar a sua chave de licença em Gofas.Net > Cliente > Serviços > Minhas Licenças';
$_ADDONLANG['licenseKeyDesc']					= $licenseKeyDesc;

$whmcsAdmin										= 'WHMCS Administrator';
$_ADDONLANG['whmcsAdminName']					= $whmcsAdmin;

$whmcsAdminDesc									= 'WHMCS administrator ID or user name with WHMCS internal API access permission. If it is the default send or administrator option, be ID 1. Optional in WHMCS 7.2 or higher.';
$_ADDONLANG['whmcsAdminDesc']					= $whmcsAdminDesc;

$percentageDiskAlert							= 'Notify client when storage reaches (%)';
$_ADDONLANG['percentageDiskAlert']				= $percentageDiskAlert;

$percentageDiskAlertDesc						= 'Specify in what percentage of disk usage the client will be notified. Only numbers.';
$_ADDONLANG['percentageDiskAlertDesc']			= $percentageDiskAlertDesc;

$percentageDiskSuspend							= 'Suspend the client account when the disk space exceeds the limit.';
$_ADDONLANG['percentageDiskSuspend']			= $percentageDiskSuspend;

$percentageDiskSuspendDesc						= 'Enable this option to automatically suspend the client account when disk space exceeds the above limit.';
$_ADDONLANG['percentageDiskSuspendDesc']		= $percentageDiskSuspendDesc;

$percentageBandwidthAlert						= 'Notify customer when bandwidth reaches (%)';
$_ADDONLANG['percentageBandwidthAlert']			= $percentageBandwidthAlert;

$percentageBandwidthAlertDesc					= 'Specify in what percentage of bandwidth usage the plan will notify the customer. Only numbers.';
$_ADDONLANG['percentageBandwidthAlertDesc']		= $percentageBandwidthAlertDesc;

$percentageBandwidthSuspend						= 'Suspend the client account when the bandwidth exceeds the limit.';
$_ADDONLANG['percentageBandwidthSuspend']		= $percentageBandwidthSuspend;

$percentageBandwidthSuspendDesc					= 'Enable this option to automatically suspend the client account when the bandwidth exceeds the threshold set above.';
$_ADDONLANG['percentageBandwidthSuspendDesc']	= $percentageBandwidthSuspendDesc;

$emailTemplate									= 'Name of the e-mail template';
$_ADDONLANG['emailTemplate']					= $emailTemplate;

$emailTemplateDesc								= 'Set the e-mail template that will be used for notifications sent to your clients when happen any of the events predicted by the module. The template name must be exactly the same as the name defined in <i> Options > Mail Templates </i>, respecting uppercase and lowercase letters. See <a style = "text-decoration: underline;" href = "https://gist.github.com/mauriciogofas/c5d96e9f4b850f520e94c8df2ddb9ac4" target = "_ blank">here</a> all available tags and an example and template.';
$_ADDONLANG['emailTemplateDesc']				= $emailTemplateDesc;

$notificationsTimeLapse							= 'Time lapse for notifications';
$_ADDONLANG['notificationsTimeLapse']			= $notificationsTimeLapse;

$notificationsTimeLapse1						= 'Once a Day';
$_ADDONLANG['notificationsTimeLapse1']			= $notificationsTimeLapse1;

$notificationsTimeLapse2						= 'Once a Week';
$_ADDONLANG['notificationsTimeLapse2']			= $notificationsTimeLapse2;

$notificationsTimeLapse3						= 'Once a Month';
$_ADDONLANG['notificationsTimeLapse3']			= $notificationsTimeLapse3;

$notificationsTimeLapseDesc						= 'Choose the length of time notification emails will be sent until the pending customer has been resolved. Keep in mind that the module runs once a day along with the main cron tasks. When the module detects that disk space and/or bandwidth has been reduced to values less than the limits set forth above, or the limits of the customer plan have been increased, in the case of an upgrade for example, notifications will be automatically stopped.';
$_ADDONLANG['notificationsTimeLapseDesc']		= $notificationsTimeLapseDesc;

$debug											= 'Debug mode';
$_ADDONLANG['debug']							= $debug;

$debugDesc										= 'CAUTION! Never use in production. Enable this option to display diagnostic information by accessing the module files directly in the browser and saving module activity records in the WHMCS logs.';
$_ADDONLANG['debugDesc']						= $debugDesc;

$deptID										= 'Send notifications report to WHMCS administrators';
$_ADDONLANG['deptID']						= $deptID;

$deptIDDesc									= 'Enter the <a target="_blank" style="text-decoration: underline;" href="'.$systemurl.'configticketdepartments.php">support department</a> ID that will receive a report of overuse notifications each time cron is run and there are services that exceed the limits of disk usage and / or bandwidth.';
$_ADDONLANG['deptIDDesc']					= $deptIDDesc;

/** Hooks translation **/

$Service									= 'Service';
$_ADDONLANG['Service']						= $Service;

$AdminReportSubject							= 'Quotas Notification Report';
$_ADDONLANG['AdminReportSubject']			= $AdminReportSubject;

$AdminReportMessageIntro					= 'The services listed below have reached the space limit on disk and / or Bandwidth set to receive notifications and their customers were notified by email. This email was sent to WHMCS administrators so that you can review the information and take the necessary actions. Check the quota notifications report:<br>';
$_ADDONLANG['AdminReportMessage']			= $AdminReportMessageIntro;

$DiskAdminReportMessage						= '<br>Notified services by use of <b>Disk Space</b>:<br>';
$_ADDONLANG['DiskAdminReportMessage']		= $DiskAdminReportMessage;

$BwAdminReportMessage						= '<br>Notified services by use of <b>Band Width</b>:<br>';
$_ADDONLANG['BwAdminReportMessage']			= $BwAdminReportMessage;

if($system_url) {
	$AdminReportMessageOutcome					= '<br><span style="font-size:75%;">You received this email because it is part of the support department set up to receive quota notification reports. This setting can be changed in the module settings <a href="'.$system_url.'admin/configaddonmods.php#gofasquotanotifications"><i>'.
	$moduleName.'</i></a></span><br>';
	$_ADDONLANG['AdminReportMessageOutcome']	= $AdminReportMessageOutcome;
}

/** Email Tpl Merge Fields Translation **/

$EmailTplDiskusage							= 'Usage of Disk in MB';
$_ADDONLANG['EmailTplDiskusage']			= $EmailTplDiskusage;

$EmailTplDisklimit							= 'Limit of Disk in MB';
$_ADDONLANG['EmailTplDisklimit']			= $EmailTplDisklimit;

$EmailTplDiskusagePercent					= 'Disk Usage Percentage';
$_ADDONLANG['EmailTplDiskusagePercent']		= $EmailTplDiskusagePercent;

$EmailTplDisklimitAlert						= 'Limit for Disk Usage Alert in MB';
$_ADDONLANG['EmailTplDisklimitAlert']		= $EmailTplDisklimitAlert;

$EmailTplBwUsage							= 'Usage of Band Width in MB';
$_ADDONLANG['EmailTplBwUsage']				= $EmailTplBwUsage;

$EmailTplBwLimit							= 'Limit of Band Width in MB';
$_ADDONLANG['EmailTplBwLimit']				= $EmailTplBwLimit;

$EmailTplBwUsagePercent						= 'Band Width Usage Percentage';
$_ADDONLANG['EmailTplBwUsagePercent']		= $EmailTplBwUsagePercent;

$EmailTplBwLimitAlert						= 'Limit for Band Width Usage Alert in MB';
$_ADDONLANG['EmailTplBwLimitAlert']			= $EmailTplBwLimitAlert;

$EmailTplUpgradeUrl							= 'Service Specific Upgrade URL';
$_ADDONLANG['EmailTplUpgradeUrl']			= $EmailTplUpgradeUrl;

$gqn_footer									= '<div class="gqn_section">
			<p>&copy; '.date('Y').' <a style="text-decoration:underline;" target="_blank" title="↗ Gofas.net" href="https://gofas.net">Gofas.net</a> | <a style="text-decoration:underline;" target="_blank" title="↗ Gofas.net" href="https://gofas.net/blog/">Version 1.1</a> | <a  style="text-decoration:underline;"target="_blank" title="↗ Docs" href="https://gofas.net/?p=9633">Documentation</a> | <a style="text-decoration:underline;" target="_blank" title="↗ Support" href="https://gofas.net/?p=9635">Support</a>.</p>
			</div>';
$_ADDONLANG['gqn_footer']			= $gqn_footer;	