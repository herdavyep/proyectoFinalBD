<?php
require_once './includes/art_config.php';
require_once './includes/art_db.php';
require_once './includes/art_functions.php';
require_once './languages/art_lang.php';
require_once './compra_edit_func.php';

art_setdefault_session('art_form_loaded', 0);
$header_text = "";
$err_string = "";
$report = "";
$artsv_postback = art_request("artsys_postback", "");
$refresh_view = art_request("rv", "0");
$artv_pm_calidad_id = art_request("pm_calidad_id", "");
$artv_pm_clientes_id = art_request("pm_clientes_id", "");
$artv_pm_id = art_request("pm_id", "");
$artv_pm_usuario_id = art_request("pm_usuario_id", "");

if (($artsv_postback == "1") && ($refresh_view != "1")){
    $err_string = art_update_data();
}

if ($err_string == "SUCCESS"){
    $submiturl = "./compra.php";
	  header("location: " . $submiturl);
	  exit;
}

art_form_updatedata_display("art_form", $err_string);
art_db_connection_close();
?>
