<?php
$field_names = array (
    "calidad.id"
    ,"calidad.nombre"
    ,"calidad.fecha_creacion"
);

$current_page = "";
$page_size = art_session("calidad_page_size", "20");
$page = art_session("calidad_page", "1");
$quick_search = art_session("calidad_quick_search", "");
$category = "";
art_assign_session("artsys_pagerecords", "");
$artsv_pagerecords = art_session("artsys_pagerecords", "");
$artsv_postback = art_request("artsys_postback", "");
$err_string = art_request("calidad_err_string", "");
$pagestyle = art_request("calidad_pagestyle", "");
$navtype = "text";
?>
