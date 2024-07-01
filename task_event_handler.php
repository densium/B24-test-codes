<?

AddEventHandler('tasks', 'OnTaskUpdate', 'TaskHandler');

function TaskHandler($id, &$arFields) {

// Условие запуска функции
CModule::IncludeModule("tasks");

$ufCrmTask = $arFields["META:PREV_FIELDS"]["UF_CRM_TASK"][0]; // Сделка привязанная к задаче
$dependsOn = $arFields["META:PREV_FIELDS"]["DEPENDS_ON"][0]; // Связанная задача
$status = $arFields["STATUS"]; // Статус

if ($status != 5 or $dependsOn == null or $ufCrmTask == false) return; 

// Параметры в БП  
$res = CTasks::GetByID($dependsOn, false, $ar);
$taskTitle = $res->GetNext()['TITLE'];

$res = CTasks::GetByID($dependsOn, false, $ar);
$responsibleId = $res->GetNext()['RESPONSIBLE_ID'];

// Отладчик
	$url = 'https://telegram-client.UUUUUUU.ru/pub_message/?chat_id=UUUUUUU&message=TEST: '.$ufCrmTask.' '.$dependsOn.' '.$status;
file_get_contents($url);

// Запуск БП
CModule::IncludeModule("bizproc");

$id = substr($ufCrmTask, 2); // ID Сделки
$bizProcId = 151; // ID Шаблона бизнес-процесса
$errorsTemp = array();
$params  = array("CompleteTask" => $arFields["META:PREV_FIELDS"]["TITLE"],"TaskToStart" => $taskTitle,"NotifyBody" => $responsibleId);

CModule::IncludeModule("bizproc");
$instanceId = CBPDocument::StartWorkflow($bizProcId, array('crm', 'CCrmDocumentDeal', 'DEAL_'.$id), $params, $errorsTemp);

}

?>
