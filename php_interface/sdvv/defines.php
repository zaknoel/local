<?

define("IS_INDEX", ($APPLICATION->GetCurPage()==SITE_DIR)?(true):(false));
define("IS_CATALOG", (CSite::InDir("/catalog/"))?(true):(false));
define("SHOW_TITLE", ($APPLICATION->GetDirProperty("showTitle")=="Y" || $APPLICATION->GetPageProperty("showTitle")=="Y")?(true):(false));
define("SHOW_LEFT_MENU", ($APPLICATION->GetDirProperty("showLeftMenu")=="Y")?(true):(false));
define("SHOW_BREADCRUMB", ($APPLICATION->GetDirProperty("showBread")=="Y")?(true):(false));

define("IS_AJAX", ($_REQUEST["z-ajax"]=="Y")?(true):(false));

?>