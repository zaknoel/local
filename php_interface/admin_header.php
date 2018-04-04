<?/*
$page=$APPLICATION->GetCurPage();
if($page=="/bitrix/admin/iblock_element_edit.php" && $_REQUEST["IBLOCK_ID"]==7)
{
    CJSCore::Init(array("jquery"));
    ?>
    <script>
        $(function(){
           $("input[name^='PROP[21]']").each(function(){
               if($(this).attr("name").indexOf("VALUE")>1)
               {
                   $(this).attr("placeholder", "Кол-во визиты");
               }else{
                   $(this).attr("placeholder", "Номер месяца");
               }

           });
        });
    </script>

<?}
?>
<!--<style>
    body div.adm-fileinput-item input.adm-fileinput-item-description
    {
        display:block
    }
    #bx-admin-prefix .adm-designed-checkbox-label {
        background: url("/bitrix/panel/main/images/bx-admin-sprite-small-2.png?ds") no-repeat 0 -983px;
        cursor: pointer;
        display: inline-block;
        height: 15px;
        float: none;
        width: 16px;
        vertical-align: text-top;
    }
</style>-->
<?*/?>
