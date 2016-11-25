<?php
$field_names = array (
    "clientes.id"
    ,"clientes.nombre"
    ,"clientes.cedula"
    ,"clientes.fecha_creacion"
);

$current_page = "";
$page_size = art_session("clientes_page_size", "20");
$page = art_session("clientes_page", "1");
$quick_search = art_session("clientes_quick_search", "");
$category = "";
art_assign_session("artsys_pagerecords", "");
$artsv_pagerecords = art_session("artsys_pagerecords", "");
$artsv_postback = art_request("artsys_postback", "");
$err_string = art_request("clientes_err_string", "");
$pagestyle = art_request("clientes_pagestyle", "");
$navtype = "text";
?>
