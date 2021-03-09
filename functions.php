<?
AddEventHandler('tasks', 'OnTaskUpdate', 'TestHandler');

function TestHandler($id, &$arFields) {
	$url = 'https://telegram-client.it-solution.ru/pub_message/?chat_id=-541482224&message= ' .'ID:'.$id.' '. json_encode($arFields);
   file_get_contents($url);
   $arFields['DESCRIPTION'] .= ' Ругаться матом запрещено!';
   if ($GLOBALS['USER']->GetID() == 2) {
      $GLOBALS['APPLICATION']->throwException('Вы не можете создавать группы.');
      return false;
   }
}
?>