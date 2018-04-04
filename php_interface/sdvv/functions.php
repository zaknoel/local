<?
function isTestUser()
{
    global $USER;
    $arGroups = $USER->GetUserGroupArray();
    if(in_array(10, $arGroups) || in_array(1, $arGroups)) return true;
    if($USER->isAdmin() || $USER->GetEmail()=="vip.panzhazova@mail.ru") return true;

    return false;
}
function isIExplorer(){
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    if(preg_match('/MSIE/i',$u_agent) || preg_match('/RV:11.0/i',$u_agent)  || preg_match('/Edge/i',$u_agent) )
    {
        return true;
    }
    return false;
}
function GetOption($name)
{
    return COption::GetOptionString("dik", $name);
}
function isAuthor()
{
    global $USER;
    $arGroups = $USER->GetUserGroupArray();
    if(in_array(9, $arGroups)) return true;
    return false;
}
function isJudge()
{
    global $USER;
    $arGroups = $USER->GetUserGroupArray();
    if(in_array(8, $arGroups)) return true;
    return false;
}
function FileInclude($name)
{
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/include_areas/".$name.".php"))
    {
        $data= file_get_contents($_SERVER["DOCUMENT_ROOT"]."/include_areas/".$name.".php");
        $data=str_replace(" ", "", $data);
        $data=str_replace("-", "", $data);
        return $data;
    }
}
function ArrayDevide($ar, $devide=1)
{
    $c=intval(count($ar)/$devide);
    if(count($ar)%$devide>0) $c++;
    return array_chunk($ar, $c);
}
function IncludeArea($name, $self=false)
{
    global $APPLICATION;
    $spath=($self)?($APPLICATION->GetCurDir()."inlude/"):("/include_areas/");
    CheckDirPath($_SERVER["DOCUMENT_ROOT"].$spath);
    $path=$_SERVER["DOCUMENT_ROOT"].$spath.$name.".php";
    if(!file_exists($path))
    {
        file_put_contents($path, "EDITABLE AREA");
    }

    $APPLICATION->IncludeFile(

    			$APPLICATION->GetTemplatePath($spath.$name.".php"),
    			Array(),
    			Array("MODE"=>"html")
    );
}
function GetPicInfo(&$arItem, $fields=["DETAIL_PICTURE", "PREVIEW_PICTURE"])
{
    Bitrix\Iblock\Component\Tools::getFieldImageData(
        $arItem,
        $fields,
        Bitrix\Iblock\Component\Tools::IPROPERTY_ENTITY_ELEMENT,
        'IPROPERTY_VALUES'
    );
}
?>