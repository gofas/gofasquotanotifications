<?php
/**
 * Gofas Notificações de Cota de Hospedagem para WHMCS
 * @author		Mauricio Gofas | gofas.net
 * @see			https://gofas.net/?p	=7893
 * @copyright	2017 https://gofas.net
 * @license		https://gofas.net/?p=9340
 * @support		https://gofas.net/forums/
 * @version		2.0.0
 */

// Textos das configurações em português do Brasil

$moduleName										= 'Gofas Notificações de Cota de Hospedagem';
$_ADDONLANG['moduleName']						= $moduleName;

$moduleDescription								= 'Avisa seus cientes de hospedagem quando o espaço em disco e banda estão se aproximando ou já ultrapassaram os limites.';
$_ADDONLANG['moduleDescription']				= $moduleDescription;

$author											= '<a title	="Gofas - Soluções avançadas para WordPress e WHMCS" href	="https://gofas.net/" target	="_blank" alt	="Gofas"><img src	="/modules/addons/gofasquotanotifications/lib/logo.png"></a>';
$_ADDONLANG['author']							= $author;

$licenseKey										= 'Chave de Licença';
$_ADDONLANG['licenseKey']						= $licenseKey;

$licenseKeyDesc									= 'Insira a chave de licença fornecida no momento da compra do módulo. Você pode encontrar a sua chave de licença em Gofas.Net > Cliente > Serviços > Minhas Licenças';
$_ADDONLANG['licenseKeyDesc']					= $licenseKeyDesc;

$whmcsAdmin										= 'Administrador do WHMCS';
$_ADDONLANG['whmcsAdminName']					= $whmcsAdmin;

$whmcsAdminDesc									= 'ID ou nome de usuário do administrador do WHMCS com permissão de acesso à API interna do WHMCS. Se essa opção estiver vazia o administrador padrão será o ID 1. Opcional no WHMCS 7.2 ou superior.';
$_ADDONLANG['whmcsAdminDesc']					= $whmcsAdminDesc;

$percentageDiskAlert							= 'Notificar o cliente quando o espaço em disco atingir (%)';
$_ADDONLANG['percentageDiskAlert']				= $percentageDiskAlert;

$percentageDiskAlertDesc						= 'Especifique em que porcentagem de uso do disco que o cliente será notificado. Apenas números.';
$_ADDONLANG['percentageDiskAlertDesc']			= $percentageDiskAlertDesc;

$percentageDiskSuspend							= 'Suspender a conta do cliente quando o espaço em disco ultrapassar o limite.';
$_ADDONLANG['percentageDiskSuspend']			= $percentageDiskSuspend;

$percentageDiskSuspendDesc						= 'Ative essa opção para suspender automaticamente a conta do cliente quando o espaço em disco ultrapassar o limite estabelecido acima.';
$_ADDONLANG['percentageDiskSuspendDesc']		= $percentageDiskSuspendDesc;

$percentageBandwidthAlert						= 'Notificar o cliente quando a transferência atingir (%)';
$_ADDONLANG['percentageBandwidthAlert']			= $percentageBandwidthAlert;

$percentageBandwidthAlertDesc					= 'Especifique em que porcentagem de uso da largura de banda do plano o cliente será notificado. Apenas números.';
$_ADDONLANG['percentageBandwidthAlertDesc']		= $percentageBandwidthAlertDesc;

$percentageBandwidthSuspend						= 'Suspender a conta do cliente quando a largura de banda ultrapassar o limite.';
$_ADDONLANG['percentageBandwidthSuspend']		= $percentageBandwidthSuspend;

$percentageBandwidthSuspendDesc					= 'Ative essa opção para suspender automaticamente a conta do cliente quando a largura de banda ultrapassar o limite estabelecido acima.';
$_ADDONLANG['percentageBandwidthSuspendDesc']	= $percentageBandwidthSuspendDesc;

$emailTemplate									= 'Nome do template de e-mail';
$_ADDONLANG['emailTemplate']					= $emailTemplate;

$emailTemplateDesc								= 'Defina um template de e-mail que será utilizado para as notificações enviadas aos seus clientes quando algum dos eventos previstos pelo módulo acontecer. O nome do template deve ser exatamente igual ao nome definido em <i>Opções > Modelos de Email</i>, respeitando letras maiúsculas e minúsculas. Veja <a style="text-decoration: underline;" href="https://gist.github.com/mauriciogofas/c5d96e9f4b850f520e94c8df2ddb9ac4" target="_blank">aqui</a> todas as tags disponíveis e um exemplo e template.';
$_ADDONLANG['emailTemplateDesc']				= $emailTemplateDesc;

$notificationsTimeLapse							= 'Frequência das notificações';
$_ADDONLANG['notificationsTimeLapse']			= $notificationsTimeLapse;

$notificationsTimeLapse1						= 'Uma vez por Dia';
$_ADDONLANG['notificationsTimeLapse1']			= $notificationsTimeLapse1;

$notificationsTimeLapse2						= 'Uma vez por Semana';
$_ADDONLANG['notificationsTimeLapse2']			= $notificationsTimeLapse2;

$notificationsTimeLapse3						= 'Uma vez por Mês';
$_ADDONLANG['notificationsTimeLapse3']			= $notificationsTimeLapse3;

$notificationsTimeLapseDesc						= 'Escolha o espaço de tempo em que serão enviados os e-mails de notificação até que a pendência do cliente tennha sido resolvida. Tenha em mente que o módulo é executado uma vez por dia juntamente com as principais tarefas cron. Quando o módulo detectar que o espaço em disco e/ou a largura de banda tenhan sofrido redução para valores menores que os limites estabelecidos acima, ou os limites do plano do cliente tenham sido aumentados, no caso de um upgrade por exemplo, o envio das notificações será interrompido automaticamente.';
$_ADDONLANG['notificationsTimeLapseDesc']		= $notificationsTimeLapseDesc;

$debug											= 'Modo Debug / Depuração';
$_ADDONLANG['debug']							= $debug;

$debugDesc										= 'CUIDADO! Nunca use em produção. Exibe informações de diagnóstico ao acessar os arquivos do módulo diretamente no navegador e serve para salvar registros de atividade do módulo nos logs do WHMCS.';
$_ADDONLANG['debugDesc']						= $debugDesc;

$deptID										= 'Enviar relatório de notificações aos administradores do WHMCS';
$_ADDONLANG['deptID']						= $deptID;

$deptIDDesc									= 'Insira o ID do <a target="_blank" style="text-decoration: underline;" href="'.$systemurl.'configticketdepartments.php">departamento de suporte</a> que receberá um relatório de notificações de excesso de uso cada vez que o cron for executado e houverem serviços que excedem os limites de uso de disco e/ou largura de banda.';
$_ADDONLANG['deptIDDesc']					= $deptIDDesc;

/** Hooks translation **/

$Service									= 'Serviço';
$_ADDONLANG['Service']						= $Service;

$AdminReportSubject							= 'Relatório de Notificações de Cotas';
$_ADDONLANG['AdminReportSubject']			= $AdminReportSubject;

$AdminReportMessageIntro					= 'Os serviços listados a seguir atingiram o limite de Espaço em Disco e/ou Largura de Banda definidos para receber notificações e os respectivos clientes foram notificados por e-mail. Esse e-mail foi enviado aos administradores do WHMCS para que seja possível revisar as informações e tomar as ações necessárias. Confira o relatório de notificações de cota:<br>';
$_ADDONLANG['AdminReportMessage']			= $AdminReportMessageIntro;

$DiskAdminReportMessage						= '<br>Serviços notificados sobre uso de <b>Espaço em Disco</b>:<br>';
$_ADDONLANG['DiskAdminReportMessage']		= $DiskAdminReportMessage;

$BwAdminReportMessage						= '<br>Serviços notificados sobre uso de <b>Largura de Banda</b>:<br>';
$_ADDONLANG['BwAdminReportMessage']			= $BwAdminReportMessage;

if($system_url) {
$AdminReportMessageOutcome					= '<br><span style="font-size:75%;">Você recebeu esse email por que faz parte do departamento de suporte configurado para receber os relatórios de notificações de cotas. Essa configuração pode ser alterada nas configurações do módulo <a href="'.$system_url.'admin/configaddonmods.php#gofasquotanotifications"><i>'.$moduleName.'</i></a></span><br>';
$_ADDONLANG['AdminReportMessageOutcome']	= $AdminReportMessageOutcome;
}

/** Email Tpl Merge Fields Translation **/

$EmailTplDiskusage							= 'Uso em MB do Disco';
$_ADDONLANG['EmailTplDiskusage']			= $EmailTplDiskusage;

$EmailTplDisklimit							= 'Limite em MB do Disco';
$_ADDONLANG['EmailTplDisklimit']			= $EmailTplDisklimit;

$EmailTplDiskusagePercent					= 'Porcentagem de uso do Disco';
$_ADDONLANG['EmailTplDiskusagePercent']		= $EmailTplDiskusagePercent;

$EmailTplDisklimitAlert						= 'Limite em MB para alerta de Uso do Disco';
$_ADDONLANG['EmailTplDisklimitAlert']		= $EmailTplDisklimitAlert;

$EmailTplBwUsage							= 'Uso em MB de Largura de Banda';
$_ADDONLANG['EmailTplBwUsage']				= $EmailTplBwUsage;

$EmailTplBwLimit							= 'Limite em MB de Largura de Banda';
$_ADDONLANG['EmailTplBwLimit']				= $EmailTplBwLimit;

$EmailTplBwUsagePercent						= 'Porcentagem de uso da Largura de Banda';
$_ADDONLANG['EmailTplBwUsagePercent']		= $EmailTplBwUsagePercent;

$EmailTplBwLimitAlert						= 'Limite em MB para alerta de Largura de Banda';
$_ADDONLANG['EmailTplBwLimitAlert']			= $EmailTplBwLimitAlert;

$EmailTplUpgradeUrl							= 'URL de upgrade específico do serviço';
$_ADDONLANG['EmailTplUpgradeUrl']			= $EmailTplUpgradeUrl;

$gqn_footer									= '<div class="gqn_section">
			<p>&copy; '.date('Y').' <a style="text-decoration:underline;" target="_blank" title="↗ Gofas.net" href="https://gofas.net">Gofas.net</a> | <a style="text-decoration:underline;" target="_blank" title="↗ Gofas.net" href="https://gofas.net/blog/">Versão 2.0.0</a> | <a  style="text-decoration:underline;"target="_blank" title="↗ Documentação" href="https://gofas.net/?p=9633">Documentação</a> | <a style="text-decoration:underline;" target="_blank" title="↗ Fórum de Suporte Gratuito" href="https://gofas.net/?p=9635">Suporte</a>.</p>
			
			</div>';
$_ADDONLANG['gqn_footer']			= $gqn_footer;			



