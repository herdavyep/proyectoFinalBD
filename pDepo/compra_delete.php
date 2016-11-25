<?php
if (session_id() == ""){
    session_start();
}
require_once './includes/art_config.php';
require_once './includes/art_db.php';
require_once './includes/art_functions.php';
require_once './languages/art_lang.php';
require_once './compra_delete_func.php';


art_setdefault_session('art_form_loaded', 0);
$cssfile = "./css/defaulttheme.css";
$cssname = "defaulttheme";
$header_text = "";
$err_string = "";
$artsv_postback = art_request("artsys_postback", "");
$refresh_view = art_request("rv", "0");
$artv_pm_calidad_id = art_request("pm_calidad_id", "");
$artv_pm_clientes_id = art_request("pm_clientes_id", "");
$artv_pm_id = art_request("pm_id", "");
$artv_pm_usuario_id = art_request("pm_usuario_id", "");
$artv_id = art_request("id", "");
$artv_fecha_creacion = art_request("fecha_creacion", "");
$artv_kilos = art_request("kilos", "");
$artv_arrobas = art_request("arrobas", "");
$artv_precio = art_request("precio", "");
$artv_total = art_request("total", "");
$artv_bultos = art_request("bultos", "");
$artv_clientes_id = art_request("clientes_id", "");
$artv_calidad_id = art_request("calidad_id", "");
$artv_usuario_id = art_request("usuario_id", "");

if (($artsv_postback == "1") && ($refresh_view != "1")){
    $err_string = art_delete_data();
}
if ($err_string == "SUCCESS"){
    $submiturl = "./compra.php";
    header("location: " . $submiturl);
    exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Compra Delete</title>
<meta name="generator" content="ScriptArtist v3">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="./css/globalcss.css" rel="stylesheet" type="text/css">
<link href="./css/defaulttheme.css" rel="stylesheet" type="text/css">
<link href="components/calendar/basicgreen/jscalendar.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="./js/prototype.js"></script>
<script language="javascript" type="text/javascript" src="./js/art_ajax.js"></script>
<script language="javascript" type="text/javascript" src="components/calendar/basicgreen/jscalendar.js"></script>
</head>
<body >

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td></td>
        </tr>
        <tr>
            <td>
                <form name="art_form" id="art_form" method="post" action="compra_delete.php"  style="margin: 0px; padding: 0px;">
                    <div id="art_ajaxpanel1">
                        <?php art_form_deletedata_display("art_form", $err_string); ?>
                    </div>
                </form>
            </td>
        </tr>
        <tr>
            <td></td>
        </tr>
    </table>
</body>
</html>
<?php	art_db_connection_close(); ?>
