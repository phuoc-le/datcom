<?php
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '../' . PATH_SEPARATOR . '../../' . PATH_SEPARATOR . '../../../');

include_once 'common/autoload.php';


$postedData = json_decode(file_get_contents('php://input'));
$methodName = $postedData->methodName;

$returnMessage = new stdClass();
$returnMessage->responseCode = 0;
$returnMessage->responseMessage = '';
$returnMessage->data = new stdClass();
if ($methodName == 'UpdateMenuByDate') {
    UpdateMenuByDate();
} elseif ($methodName == 'GetUsersByGroupCode') {
    GetUsersByGroupCode();

} elseif ($methodName == 'OrderForUser') {

} elseif ($methodName == 'RemoveOrderForUser') {

} else {

}

function UpdateMenuByDate()
{
    global $returnMessage;
    global $postedData;
    $extraPrice = '25000';
    $day = CommonFunction::convertDayOfWeek();
    $menuItems = $postedData->data->menuItems;
    $menu = new Menu();
    foreach ($menuItems as $item) {

        $menu->insert($item->menuName, $day, $item->price, $extraPrice);
    }
    $result = $menu->findByDay($day);
    $returnMessage->data->menuItems = $result;
    echo json_encode($returnMessage);
}

function GetUsersByGroupCode()
{
    global $returnMessage;
    global $postedData;
    $groupCode = $postedData->data->groupCode;
    $group = new Group();
    $groups = $group->findByGroupCode($groupCode);
    $groupId = $groups[0]["id"];
    $user = new User();
    $result = $user->findByGroupId($groupId);
    $returnMessage->data->users = $result;
    $returnMessage->data->code = 0;

    echo json_encode($returnMessage);

}

function OrderForUser()
{

}

function RemoveOrderForUser()
{

}

function UpdateUserFullname()
{

}