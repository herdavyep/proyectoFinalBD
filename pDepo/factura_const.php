<?php
$field_names = array (
    "factura.id"
    ,"factura.valor"
    ,"factura.fecha_creacion"
    ,"factura.temporal_id"
    ,"factura.clientes_id"
    ,"factura.usuario_id"
);

$current_page = "";
$page_size = art_session("factura_page_size", "20");
$page = art_session("factura_page", "1");
$quick_search = art_session("factura_quick_search", "");
$category = "";
art_assign_session("artsys_pagerecords", "");
$artsv_pagerecords = art_session("artsys_pagerecords", "");
$artsv_postback = art_request("artsys_postback", "");
$err_string = art_request("factura_err_string", "");
$pagestyle = art_request("factura_pagestyle", "");
$navtype = "text";
?>
