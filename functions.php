<?

AddEventHandler('tasks', 'OnTaskUpdate', 'TestHandler');

function TestHandler($id, &$arFields) {
	//$res = $arFields["META:PREV_FIELDS"]["UF_CRM_TASK"][0]; // Сделка привязанная к задаче
	$res = $arFields["META:PREV_FIELDS"]["DEPENDS_ON"][0]; // Связанная задача
	// статус продумать

	//id ($res === null)
	//{return;}

	$url = 'https://telegram-client.it-solution.ru/pub_message/?chat_id=-541482224&message= ' .'ID:'.$id.' '. $res;
  	file_get_contents($url);

	CModule::IncludeModule("bizproc");

	$id = 5; // ID Сделки
	$bizProcId = 28; // ID Шаблона бизнес-процесса
	$arErrors = array();

	CBPDocument::StartWorkflow($bizProcId, array('crm', 'DEAL', 'D_'.$id), 0, $arErrors);

}


?>