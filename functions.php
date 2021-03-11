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
$url = 'https://telegram-client.it-solution.ru/pub_message/?chat_id=-541482224&message= '.'TEST'; // D_3 29 5
file_get_contents($url);

// Запуск БП
CModule::IncludeModule("bizproc");

$id = substr($ufCrmTask, 2); // ID Сделки
$bizProcId = 28; // ID Шаблона бизнес-процесса
$errorsTemp = array();
$params  = array("Parameter1" => $taskTitle,"Parameter2" => $arFields["META:PREV_FIELDS"]["TITLE"],"Parameter3" => $responsibleId);

CModule::IncludeModule("bizproc");
$instanceId = CBPDocument::StartWorkflow($bizProcId, array('crm', 'CCrmDocumentDeal', 'DEAL_'.$id), $params, $errorsTemp);

}

?>
