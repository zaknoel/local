<?
$_SERVER["DOCUMENT_ROOT"] ="/srv/www/dik.kz/htdocs";
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);
define("BX_CRONTAB", true);
define('BX_NO_ACCELERATOR_RESET', true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
echo "\nstart\n";
@set_time_limit(0);
@ignore_user_abort(true);
CModule::IncludeModule("iblock");
CModule::IncludeModule("sale");
$arFilter=array("IBLOCK_ID"=>CATALOG_IB, "ACTIVE"=>"Y");
$s5=date("Y-m-d", strtotime("+5 days"));
$s1=date("Y-m-d", strtotime("+1 days"));
$m1=date("Y-m-d", strtotime("-1 days"));
$emails=Notification::GetSubUsers();
$db=CUser::GetList($by, $order, array("ACTIVE"=>"Y"), array("FIELDS"=>["ID"]));
$public=[];
while($b=$db->GetNext())
{
    $public[$b["ID"]]=$b["ID"];
}
/*$emails=["softdeveleng@gmail.com"];
$public=[2=>2];*/





/*############################################До 5 дней до начало####################################################*/
///do 5 dney
$arFilter["PROPERTY_START_DATE"]=$s5;
$db=CIBlockElement::GetList(
    array(),
    $arFilter,
    false, false,
    array("ID", "NAME", "DETAIL_PAGE_URL")
);
$arItems=[];
while($arItem=$db->GetNext())
{
    $arItem[]=$arItem;
}
if($arItems):
//send message
$mtext="Через 5 дней стартуют следующие события:<br>";
$mtext.="<ol>";
   foreach ($arItems as $item)
   {
       $mtext.="<li><a href='".$item["DETAIL_PAGE_URL"]."'>".$item["NAME"]."</a></li>";
   }
$mtext.="</ol>";

$mtext.="<br>Приглашаем Вас принять участие!<br>";
$mtext.="<a class='n_link' href='http://dik.kz/faq/12/'>Как подать заявку</a>#br#";
Notification::Add(str_replace("#br#", "", $mtext), COMMON, $public);
Notification::SendEmail(str_replace("class='n_link'", "", $mtext), $emails);
endif;







/*#############################################До 1 дней до начало###################################################*/
//do 1 dney
$arFilter["PROPERTY_START_DATE"]=$s1;
$db=CIBlockElement::GetList(
    array(),
    $arFilter,
    false, false,
    array("ID", "NAME", "DETAIL_PAGE_URL")
);
$arItems=[];
while($arItem=$db->GetNext())
{
    $arItems[]=$arItem;
}
if($arItems):
///send message
$mtext="Завтра станут доступны для скачивания задания по следующим событиям в Ваших личных кабинетах:<br>";
$mtext.="<ol>";
foreach ($arItems as $item)
{
    $mtext.="<li><a href='".$item["DETAIL_PAGE_URL"]."'>".$item["NAME"]."</a></li>";
}
$mtext.="</ol>";

$mtext.="<br>Если Вы еще не подали заявку, приглашаем Вас принять участие!<br>";
$mtext.="<a class='n_link' href='http://dik.kz/faq/12/'>Как подать заявку</a>#br# 
<a class='n_link' href='http://dik.kz/faq/41/'>Как скачать задание </a>#br#
<a class='n_link' href='http://dik.kz/faq/42/'>Как внести ответы</a>#br#";
Notification::Add(str_replace("#br#", "", $mtext), COMMON, $public);
Notification::SendEmail(str_replace("class='n_link'", "", $mtext), $emails);
endif;
unset($arFilter["PROPERTY_START_DATE"]);









/*###############################################До 1 дней до закрытия#################################################*/
//do 1 den zakritiya
$arFilter["PROPERTY_END_DATE"]=$s1;
$db=CIBlockElement::GetList(
    array(),
    $arFilter,
    false, false,
    array("ID", "NAME", "DETAIL_PAGE_URL")
);
$arItems=[];
while($arItem=$db->GetNext())
{
    $arItems[]=$arItem;
}
if($arItems):
///send message
$mtext="Внимание! Завтра последний день подачи заявок и внесения ответов по следующим событиям:<br>";
$mtext.="<ol>";
foreach ($arItems as $item)
{
    $mtext.="<li><a href='".$item["DETAIL_PAGE_URL"]."'>".$item["NAME"]."</a></li>";
}
$mtext.="</ol>";

$mtext.="<br>Время автоматического закрытия события завтра в 23:59. Будьте внимательны!<br>";
$mtext.="<br>Если Вы еще не подали заявку, приглашаем Вас принять участие!<br>";
$mtext.="<a class='n_link' href='http://dik.kz/faq/12/'>Как подать заявку</a>#br# 
<a class='n_link' href='http://dik.kz/faq/41/'>Как скачать задание </a>#br#
<a class='n_link' href='http://dik.kz/faq/42/'>Как внести ответы</a>#br#";
Notification::Add(str_replace("#br#", "", $mtext), COMMON, $public);
Notification::SendEmail(str_replace("class='n_link'", "", $mtext), $emails);

endif;





/*############################################### 1 дней  после закрытия #################################################*/
///posle 1 den zakritiya
$arFilter["PROPERTY_END_DATE"]=$m1;
$db=CIBlockElement::GetList(
    array(),
    $arFilter,
    false, false,
    array("ID", "NAME", "DETAIL_PAGE_URL")
);
while($arItem=$db->GetNext())
{

    $text="Подведены итоги ".$arItem["NAME"].".<br>
Ознакомиться с результатами Вы можете в разделе <a href='".str_replace("catalog", "results", $arItem["DETAIL_PAGE_URL"])."'>Результаты</a>. Наградные материалы доступны для скачивания в личных кабинетах.<br>
<a class='n_link' href='http://dik.kz/faq/39/'>Как посмотреть результаты</a>#br#
<a class='n_link' href='http://dik.kz/faq/39/'>Как скачать наградные материалы</a>#br#
";
    $dbP=CSaleBasket::GetList(
        array(),
        array("!ORDER_ID"=>NULL, "PRODUCT_ID"=>$arItem["ID"], "ORDER_PAYED"=>"Y"),
        false,
        false,
        array("ID", "NAME", "ORDER_ID", "PRODUCT_ID", "USER_ID", "ORDER_PAYED")
    );
    $pUser=[];
    while($arP=$dbP->GetNext())
    {
        unset($my_public[$arP["ID"]]);
        $pUser[]=$arP["USER_ID"];
    }
    $a=CUser::GetList($by, $order, array("ID"=>implode(" | ", $pUser)), ["FIELDS"=>["ID", "EMAIL"]]);
    $semail=[];
    while($b=$a->GetNext())
    {
        $semail[]=$b["EMAIL"];
    }
  /*  $semail=["softdeveleng@gmail.com"];
    $pUser=[2];*/
    Notification::Add(str_replace("#br#", "", $text), PERSONAL, $pUser);
    Notification::SendEmail(str_replace("class='n_link'", "", $text), $semail);
}
echo "\n end".date("d.m.Y H:i:s");
?>