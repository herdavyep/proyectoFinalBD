<?php
$field_names = array (
    "usuario.id"
    ,"usuario.nombre"
    ,"usuario.cedula"
    ,"usuario.tipo_usuario"
    ,"usuario.fecha_creacion"
    ,"usuario.reporte"
);

$current_page = "";
$page_size = art_session("usuario_page_size", "20");
$page = art_session("usuario_page", "1");
$quick_search = art_session("usuario_quick_search", "");
$category = "";
art_assign_session("artsys_pagerecords", "");
$artsv_pagerecords = art_session("artsys_pagerecords", "");
$artsv_postback = art_request("artsys_postback", "");
$err_string = art_request("usuario_err_string", "");
$pagestyle = art_request("usuario_pagestyle", "");
$navtype = "text";
?>
