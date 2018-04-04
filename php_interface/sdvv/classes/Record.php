<?
class Record
{
    var $ib;
    var $entity;
    function __construct($hblock)
    {
        CModule::IncludeModule("highloadblock");
        $this->ib=$hblock;
        $rsData = \Bitrix\Highloadblock\HighloadBlockTable::getList(array('filter'=>array('ID'=>$hblock)));
        if ( !($arData = $rsData->fetch()) ){
            echo 'Инфоблок не найден';
        }
        $this->entity =\Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arData);
        return $this;
    } 
    public static function init($hblock)
    {
        return new Record($hblock);
    }
    function Add($arFields=[])
    {
        $DataClass = $this->entity->getDataClass();
        $result = $DataClass::add($arFields);
        if(!$result->isSuccess()){
            echo implode(', ', $result->getErrorMessages()); //выведем ошибки
            return false;
        }
        return $result->getId();//Id нового элемента
    }
    function Update($id, $arFields=[])
    {
        $DataClass = $this->entity->getDataClass();
        $result = $DataClass::update($id, $arFields);
        if(!$result->isSuccess()){ //произошла ошибка
            echo implode(', ', $result->getErrorMessages()); //выведем ошибки
            return false;
        }
        return true;
    }
    function Delete($id)
    {
        $DataClass = $this->entity->getDataClass();
        $result = $DataClass::delete($id);
        if(!$result->isSuccess()){ //произошла ошибка
            echo implode(', ', $result->getErrorMessages()); //выведем ошибки
            return false;
        }
        return true;
    }
    function GetList($arOrder=[], $arFilter=[], $arSelect=["*"], $doArray=false)
    {
        //Создадим объект - запрос
        $Query = new \Bitrix\Main\Entity\Query($this->entity);

        //Зададим параметры запроса, любой параметр можно опустить
        $Query->setSelect($arSelect);
        $Query->setFilter($arFilter);
        $Query->setOrder($arOrder);

        //Выполним запрос
        $result = $Query->exec();

        //Получаем результат по привычной схеме
        $result = new CDBResult($result);
        $arLang = array();
       
        while ($row = $result->Fetch()){
          
            $arLang[$row['ID']] = $row;
        }
        if(count($arLang)==1 && $doArray)
        {
            $arLang=array_values($arLang)[0];
        }
        return $arLang;
    }
    function GetBy($by, $val, $field)
    {
        if($GLOBALS["hl"][$this->ib][$by][$val][$field]) return $GLOBALS["hl"][$this->ib][$by][$val][$field];
        $arF=array($by=>$val);
        $arSelect=array("ID", $field);
        $res=array_values($this->GetList(array(), $arF, $arSelect));
        $GLOBALS["hl"][$this->ib][$by][$val][$field]=$res[0][$field];
        return $GLOBALS["hl"][$this->ib][$by][$val][$field];
    }
}
?>
