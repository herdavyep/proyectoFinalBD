<?php
require_once './includes/art_config.php';
require_once './includes/art_db.php';
require_once './includes/art_functions.php';
require_once './languages/art_lang.php';
require_once './calidad_search_func.php';

$header_text = "";
art_setdefault_session('art_form_loaded', 0);
$refresh_view = art_request("rv", "0");
$err_string = "";
if ($refresh_view != "1"){
    $err_string = art_search_data();	
    if ($err_string == "SUCCESS") {
        art_set_session("calidad_page", "1");
        $submiturl = "./calidad.php";
        header("location: " . $submiturl);
        exit;
    }
}

art_form_searchdata_display("art_form", $err_string);
art_db_connection_close();
?>
