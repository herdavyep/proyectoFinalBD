<?php
$field_names = array (
    "compra.id"
    ,"compra.fecha_creacion"
    ,"compra.kilos"
    ,"compra.arrobas"
    ,"compra.precio"
    ,"compra.total"
    ,"compra.bultos"
    ,"compra.clientes_id"
    ,"compra.calidad_id"
    ,"compra.usuario_id"
);

$current_page = "";
$page_size = art_session("compra_page_size", "20");
$page = art_session("compra_page", "1");
$quick_search = art_session("compra_quick_search", "");
$category = "";
art_assign_session("artsys_pagerecords", "");
$artsv_pagerecords = art_session("artsys_pagerecords", "");
$artsv_postback = art_request("artsys_postback", "");
$err_string = art_request("compra_err_string", "");
$pagestyle = art_request("compra_pagestyle", "");
$navtype = "text";
?>
