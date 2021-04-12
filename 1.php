CModule::IncludeModule("socialnetwork");
$rootActivity = $this->GetRootActivity();

$PROJECT_NAME = $rootActivity->GetVariable("PROJECT_NAME");
$USER_ID = $rootActivity->GetVariable("USER_ID");

$arFields = array(
	"SITE_ID" => "bx",
    "NAME" => $PROJECT_NAME,
    "VISIBLE" => "Y",
	"OPENED" => "Y",
    "SUBJECT_ID" => 1,
    "INITIATE_PERMS" => "E",
    "SPAM_PERMS" => "K",
	"PROJECT" => "Y",
	"PROJECT_DATE_FINISH" => $rootActivity->GetVariable("PROJECT_DATE_FINISH"),
      "PROJECT_DATE_START" => date("d.m.y")
);

$groupId = CSocNetGroup::CreateGroup($USER_ID, $arFields);

$rootActivity->SetVariable("GROUP_ID", $groupId);
