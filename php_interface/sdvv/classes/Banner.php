<?
class Banner{
    var $banners=[];

    function __construct()
    {
        CModule::IncludeModule("iblock");
        $this->app=$GLOBALS["APPLICATION"];
        $a=CIBlockElement::GetList(["SORT"=>"ASC"], ["IBLOCK_ID"=>10, "ACTIVE"=>"Y", "PROPERTY_LINK"=>$this->app->GetCurPage(false)],
            false,
            false,
            ["ID", "PROPERTY_VIDEO", "PROPERTY_POSTER", "PROPERTY_PHOTO"]);
        while($b=$a->GetNext())
        {
            if($b["PROPERTY_VIDEO_VALUE"]) $b["TYPE"]="video";
            $this->banners[]=$b;
        }
    }
    function GetNextBanner()
    {
        foreach ($this->banners as $k=>$banner)
        {
            unset($this->banners[$k]);
            return $banner;
        }
        return false;
    }

}

?>