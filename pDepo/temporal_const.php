<?php
$field_names = array (
    "temporal.id"
    ,"temporal.compra_id"
    ,"temporal.fecha_creacion"
);

$current_page = "";
$page_size = art_session("temporal_page_size", "20");
$page = art_session("temporal_page", "1");
$quick_search = art_session("temporal_quick_search", "");
$category = "";
art_assign_session("artsys_pagerecords", "");
$artsv_pagerecords = art_session("artsys_pagerecords", "");
$artsv_postback = art_request("artsys_postback", "");
$err_string = art_request("temporal_err_string", "");
$pagestyle = art_request("temporal_pagestyle", "");
$navtype = "text";
?>
