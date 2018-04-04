<?
class CIBlockPropertyElementListPlus
{
    function GetUserTypeDescription()
    {
        return array(
            "PROPERTY_TYPE"      => "E",
            "USER_TYPE"         => "EListPlus",
            "DESCRIPTION"      => "Привязка к элементам в виде списка (расширенное)",
            "GetPropertyFieldHtml"   =>array("CIBlockPropertyElementListPlus","GetPropertyFieldHtml"),
        );
    }

    function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
    {
        static $cache = array();
        $IBLOCK_ID = $arProperty["LINK_IBLOCK_ID"];
        if (!array_key_exists($IBLOCK_ID, $cache))
        {
            $arSelect = array(
                "ID",
                "NAME",
            );
            $arFilter = array (
                "IBLOCK_ID"=> $arProperty["LINK_IBLOCK_ID"],
                "ACTIVE" => "Y",
                "CHECK_PERMISSIONS" => "Y",
            );
            $arOrder = array(
                "NAME" => "ASC",
                "ID" => "ASC",
            );
            $cache[$IBLOCK_ID] = array();
            $rsItems = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
            while($arItem = $rsItems->GetNext())
                $cache[$IBLOCK_ID][] = $arItem;

        }
        $varName = str_replace("VALUE", "DESCRIPTION", $strHTMLControlName["VALUE"]);
        $html = '<select name="'.$strHTMLControlName["VALUE"].'">
      <option value=""> </option>';
        foreach ($cache[$IBLOCK_ID] as $arItem)
        {
            $html .= '<option value="'.$arItem["ID"].'"';
            if($value["VALUE"] == $arItem["~ID"])
                $html .= ' selected';
            $html .= '>'.$arItem["NAME"].'</option>';
        }
        $html .= '</select>';
        $html .= ' ';
        $html .= '<input style="margin-top:10px; margin-bottom:30px; width:100%" placeholder="Значение" type="text" id="DESCR_'.$varName.'" name="'.$varName.'" value="'.$value["DESCRIPTION"].'" />';
        return  $html;
    }
}

AddEventHandler("iblock", "OnIBlockPropertyBuildList", array("CIBlockPropertyElementListPlus", "GetUserTypeDescription"));
?>