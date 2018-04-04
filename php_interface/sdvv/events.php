<?
include("property/prop_element_desc.php");
include("property/hl_prop.php");
AddEventHandler("main", "OnBeforeUserRegister", "AddUserGroup");
function AddUserGroup(&$arFields)
{
    if($_REQUEST["GROUP_ID"])
    {
        $arFields["GROUP_ID"][]=$_REQUEST["GROUP_ID"];
    }
    return $arFields;
}
AddEventHandler("main", "OnAfterUserRegister", "AddSubs");
function AddSubs($arFields)
{
    if($_REQUEST["SUBS"]=="Y"):
    CModule::IncludeModule("subscribe");
    $arFilter = array(
        "ACTIVE" => "Y",
        "LID" => SITE_ID,
    );

    $rsRubrics = CRubric::GetList(array("SORT"=>"ASC", "NAME"=>"ASC"), $arFilter);
    $arRubrics = array();
    while($arRubric = $rsRubrics->GetNext())
    {
        $arRubrics[] = $arRubric["ID"];
    }
    $obSubscription = new CSubscription;
    $ID = $obSubscription->Add(array(
        "USER_ID" => $arFields["RESULT_MESSAGE"]["ID"],
        "ACTIVE" => "Y",
        "EMAIL" => $arFields["EMAIL"],
        "FORMAT" =>"html",
        "CONFIRMED" => "Y",
        "SEND_CONFIRM" => "N",
        "RUB_ID" => $arRubrics,
    ));
    endif;
    return $arFields;
}

?>