<?php
require_once './includes/art_functions.php';
require_once './usuario_const.php';



function art_simplesearch_sql($start_sql, $search_value) {
    $sql = "";
    return $sql;
}

function art_append_sqlcondition($sql, $condition){
    if (!strpos(strtoupper($sql), "WHERE")) {
        $sql .= " WHERE (";
    } else {
        $sql .= " AND (";
    }
    $sql .= $condition;
    return $sql .= ")";
}

function art_split_sql($sql) {
    $ipos = strpos(  strtoupper($sql) , "ORDER BY") ;
    if ($ipos > 0) {
        $sql_array[0] = substr($sql, 1, $ipos - 1);
        $sql_array[1] = substr($sql, $ipos - 1, strlen($sql));
    } else {
        $sql_array[0] = $sql;
        $sql_array[1] = "";
    }
    return $sql_array;
}

function art_append_orderby($sql, $field) {
    $result = "";
    $str_orderby = " ORDER BY " . $field;
    $ipos = strpos(strtoupper($sql), "ORDER BY");
    if ($ipos > 0){
        $ipos = strpos(strtoupper($sql), strtoupper($field));
        if ($ipos > 0){
            $result = $sql;
        } else {
            $result = str_replace("ORDER BY", $str_orderby . ",", strtoupper($sql));
        }
    } else {
        $result = $str_orderby;
    }
    return $result;
}

function art_gridtoolbar_display($category){
}

function art_datagrid_display($field_names, $page_size, $current_page, $quick_search, $navtype, $category, $showtotalrec=0, $showpagesize=0) {	
    $artsv_postback = art_request("artsys_postback", "");
    $sql = "";
    $sql_start = " ";
    $sql_condition = "";
    $sql_ext = "";
    $cssrow = "";
    $query_array = "";
    $querystr = ""; 
    $pagerecords = 0; 

    $field_columns = array (
        'usuario.id'
        ,'usuario.nombre'
        ,'usuario.cedula'
        ,'usuario.tipo_usuario'
        ,'usuario.fecha_creacion'
        ,'usuario.reporte'
        ,''
        ,''
	  );

    $qrystr = array_fill(0, 8, "");
    $clr = art_request("clr_usuario", "");
    $clr_adv_session = art_request("clr_usuario_adv_session", "");

    if (strtolower($clr) == "t"){
        art_clear_session("usuario_sort1");	
        art_clear_session("usuario_sort2");	
        art_clear_session("usuario_sort3");	
        art_clear_session("usuario_sort4");	
        art_clear_session("usuario_sort5");	
        art_clear_session("usuario_sort6");	
        art_clear_session("usuario_sort7");	
        art_clear_session("usuario_sort8");	
        $clr = "";
	  }

    if (strtolower($clr_adv_session) == "y") {
        $clr_adv_session = "";
        art_clear_session("usuario_search");
        art_clear_session("usuario_page");
        art_clear_session("usuario_quick_search");
        art_clear_session("usuario_category");
        $quick_search = "";
        $category = "";
	  }

    art_assign_session("usuario_sort1", "");
    art_assign_session("usuario_sort2", "");
    art_assign_session("usuario_sort3", "");
    art_assign_session("usuario_sort4", "");
    art_assign_session("usuario_sort5", "");
    art_assign_session("usuario_sort6", "");
    art_assign_session("usuario_sort7", "");
    art_assign_session("usuario_sort8", "");
    art_assign_session("usuario_page_size", 20);
    art_assign_session("usuario_page", "1");
    $sql_array  = art_split_sql(" select * from `usuario`"); 
    $sql_start = $sql_array[0]; 
    $sql_orderby = $sql_array[1]; 
    $sort1 = art_session("usuario_sort1", "");
    $sort2 = art_session("usuario_sort2", "");
    $sort3 = art_session("usuario_sort3", "");
    $sort4 = art_session("usuario_sort4", "");
    $sort5 = art_session("usuario_sort5", "");
    $sort6 = art_session("usuario_sort6", "");
    $sort7 = art_session("usuario_sort7", "");
    $sort8 = art_session("usuario_sort8", "");
    $page_size = art_session("usuario_page_size", "20");
    $page = art_session("usuario_page", "1");
    $current_page = $page;
    $search = "";
    $sql_condition = $sql_start;
    for ($i=1; $i<=8; $i++){
        $sorting = "";
        $sort_order = "";
        if (art_session("usuario_sort".$i, "") == "1"){
            $sorting = "&usuario_sort". $i . "=" . "2";
            $sort_order = "ASC";
        } else if (art_session("usuario_sort".$i, "") == "2"){
            $sorting = "&usuario_sort". $i . "=" . "1";
            $sort_order = "DESC";
        } else {
            $sorting = "&usuario_sort". $i . "=" . "1";
            $sort_order = "";
        }
        $qrystr[$i] = "usuario_ajax.php?clr_usuario=t".$sorting;

        if ($sort_order != ""){
            if ($sql_orderby == ""){
                $sql_orderby .= " ORDER BY " . $field_columns[$i - 1] . " " . $sort_order;
            } else {
                $sql_orderby .= ", " . $field_columns[$i - 1] . " " . $sort_order;
            }
        }
    }
    $advsearch_sql = art_session("usuario_search","");
    if ($advsearch_sql != "") {
      $sql_condition = art_append_sqlcondition($sql_condition, $advsearch_sql);
    }
    $sql_condition .= $sql_orderby;	
    $current_row = ($current_page - 1) * $page_size;
    $sql = $sql_condition;
    $result = mysql_query($sql);
    $numrows = 0;
    if ($result != null) { $numrows = mysql_num_rows($result); }
    $sql_ext = "";
    if ($numrows < $current_row) {
       $current_row =  $numrows - 1;
    }
    $sql_ext = " LIMIT " . $current_row . ", " . $page_size;
    $sql = $sql . " " . $sql_ext;
    $result = mysql_query($sql);

    print "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"  width=\"100%\" align=\"center\">\n";
    print "<tr>\n";
    print "<td>\n";
    print "<div id=\"mainmenu_defaulttheme\">\n";
    print "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"  width=\"100%\">\n";
    print "    <tr>\n";
    print "    <td colspan=\"3\" valign=\"top\" class=\"mainMenuBG\" >\n";
    print "        <table align=\"right\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
    print "            <tr>\n";
    $sessionlevel = art_session('art_user_level', -1);
    $menuprint = false;
    if ($sessionlevel < 0) {
        if ($menuprint) {
          print "                <td>\n";
          print "                    <span class=\"mainMenuText\">\n";
          print "                        &nbsp;|&nbsp;\n";
          print "                    </span>\n";
          print "                </td>\n";
          $menuprint = false;
        }
        print "                <td>\n";
        print "<a href=\"" . "./user_logout.php". "\"" . " title=\"Login\" class=\"mainMenuLink\"><div><p>Login</p></div></a>";
        print "                </td>\n";
        $menuprint = true;
    }
    if ($sessionlevel > 0) {
        if ($menuprint) {
          print "                <td>\n";
          print "                    <span class=\"mainMenuText\">\n";
          print "                        &nbsp;|&nbsp;\n";
          print "                    </span>\n";
          print "                </td>\n";
          $menuprint = false;
        }
        print "                <td>\n";
        print "<a href=\"" . "./user_logout.php". "\"" . " title=\"Logout\" class=\"mainMenuLink\"><div><p>Logout</p></div></a>";
        print "                </td>\n";
        $menuprint = true;
    }
    print "            </tr>\n";
    print "        </table>\n";
    print "    </td>\n";
    print "    </tr>\n";
    print "</table>\n";
    print "</div>\n";

    print "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
    print "<tr>\n";
    print "<td width=\"1\" align=\"left\" valign=\"top\">\n";
    art_sitemenu_display("usuario", "defaulttheme");
    print "</td>\n";
    print "<td align=\"left\" class=\"siteMenuGap\">&nbsp;</td>\n";
    print "<td valign=\"top\">\n";
    print "<br />\n";
    print "<div id=\"defaulttheme\">";
    print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"gridTable\"  width=\"90%\">\n";
    print "    <tr>\n";
    print "        <td>\n";
    $gridtitle = "Usuario";
    print "            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"gridHeader\" >\n";
    print "                <tr>\n";
    print "                    <td class=\"gridHeaderBGLeft\" nowrap >&nbsp;</td>\n";
    print "                    <td class=\"gridHeaderBG\" colspan=\"8\">\n";
    print "                        <table border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    print "                            <tr>\n";
    print "                                <td valign=\"baseline\" ><span class=\"gridHeaderText\">" . $gridtitle . "</span></td>\n";
    print "                            </tr>\n";
    print "                        </table>\n";
    print "                    </td>\n";
    print "                    <td class=\"gridHeaderBGRight\" nowrap >&nbsp;</td>\n";
    print "                </tr>\n";
    print "            </table>\n";
    print "";
    print "            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"gridToolBar\" >\n";
    print "                <tr>\n";
    print "                    <td colspan=\"8\">\n";
    print "                        <table border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    print "                            <tr>\n";
    print "                                <td valign=\"baseline\" >";
    print "                                </td>\n";
    print "                                <td align=\"right\">\n";
    print "<a href=\"" . art_gen_url("usuario_ajax.php?clr_usuario_adv_session=y", 1). "\"" . " title=\"Show All\" class=\"gridToolBarLink\"><img src=\"./images/defaultbutton/show_all.gif\" border=\"0\" /></a>";
    print "&nbsp;<a href=\"" . art_gen_url("usuario_ajax.php?clr_usuario=t", 1). "\"" . " title=\"Clear Sort\" class=\"gridToolBarLink\"><img src=\"./images/defaultbutton/clear_sort.gif\" border=\"0\" /></a>";
    print "&nbsp;<a href=\"" . "./usuario_search.php". "\"" . " title=\"Advance Search\" class=\"gridToolBarLink\"><img src=\"./images/defaultbutton/adv_search.gif\" border=\"0\" /></a>";
    print "&nbsp;<a href=\"" . "./usuario_add.php". "\"" . " title=\"Add New Record\" class=\"gridToolBarLink\"><img src=\"./images/defaultbutton/add.gif\" border=\"0\" /></a>";
    print "&nbsp;";
    print "                                </td>\n";
    print "                            </tr>\n";
    print "                        </table>\n";
    print "                    </td>\n";
    print "                </tr>\n";
    print "            </table>\n";
    print "            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"gridMain\" >\n";
    print "                <tr>\n";
    print "                    <td class=\"gridColumn\"  NOWRAP >\n";
    print "                        <div class=\"gridColumnText\">\n";
    print "                            <a href=\"" . art_gen_url($qrystr[1], 1) . "\" class=\"gridColumnLink\">Id</a>\n";
    if ($sort1 == "1") {
        print "                            <a href=\"" . art_gen_url($qrystr[1] ,1) . "\" class=\"gridColumnLink\"><img src=\"./images/defaultbutton/sort_asc.gif\" border=\"0\" /></a>\n";
    } else if ($sort1 == "2"){
        print "                            <a href=\"" . art_gen_url($qrystr[1] ,1) . "\" class=\"gridColumnLink\"><img src=\"./images/defaultbutton/sort_desc.gif\" border=\"0\" /></a>\n";
    } else if (trim($sort1) == ""){
        print "                            <a href=\"" . art_gen_url($qrystr[1] ,1) . "\" class=\"gridColumnLink\"><img src=\"./images/defaultbutton/sort_none.gif\" border=\"0\" /></a>\n";
    }
    print "                        </div>\n";
    print "                    </td>\n";
    print "                    <td class=\"gridColumn\"  NOWRAP >\n";
    print "                        <div class=\"gridColumnText\">\n";
    print "                            <a href=\"" . art_gen_url($qrystr[2], 1) . "\" class=\"gridColumnLink\">Nombre</a>\n";
    if ($sort2 == "1") {
        print "                            <a href=\"" . art_gen_url($qrystr[2] ,1) . "\" class=\"gridColumnLink\"><img src=\"./images/defaultbutton/sort_asc.gif\" border=\"0\" /></a>\n";
    } else if ($sort2 == "2"){
        print "                            <a href=\"" . art_gen_url($qrystr[2] ,1) . "\" class=\"gridColumnLink\"><img src=\"./images/defaultbutton/sort_desc.gif\" border=\"0\" /></a>\n";
    } else if (trim($sort2) == ""){
        print "                            <a href=\"" . art_gen_url($qrystr[2] ,1) . "\" class=\"gridColumnLink\"><img src=\"./images/defaultbutton/sort_none.gif\" border=\"0\" /></a>\n";
    }
    print "                        </div>\n";
    print "                    </td>\n";
    print "                    <td class=\"gridColumn\"  NOWRAP >\n";
    print "                        <div class=\"gridColumnText\">\n";
    print "                            <a href=\"" . art_gen_url($qrystr[3], 1) . "\" class=\"gridColumnLink\">Cedula</a>\n";
    if ($sort3 == "1") {
        print "                            <a href=\"" . art_gen_url($qrystr[3] ,1) . "\" class=\"gridColumnLink\"><img src=\"./images/defaultbutton/sort_asc.gif\" border=\"0\" /></a>\n";
    } else if ($sort3 == "2"){
        print "                            <a href=\"" . art_gen_url($qrystr[3] ,1) . "\" class=\"gridColumnLink\"><img src=\"./images/defaultbutton/sort_desc.gif\" border=\"0\" /></a>\n";
    } else if (trim($sort3) == ""){
        print "                            <a href=\"" . art_gen_url($qrystr[3] ,1) . "\" class=\"gridColumnLink\"><img src=\"./images/defaultbutton/sort_none.gif\" border=\"0\" /></a>\n";
    }
    print "                        </div>\n";
    print "                    </td>\n";
    print "                    <td class=\"gridColumn\"  NOWRAP >\n";
    print "                        <div class=\"gridColumnText\">\n";
    print "                            <a href=\"" . art_gen_url($qrystr[4], 1) . "\" class=\"gridColumnLink\">Tipo Usuario</a>\n";
    if ($sort4 == "1") {
        print "                            <a href=\"" . art_gen_url($qrystr[4] ,1) . "\" class=\"gridColumnLink\"><img src=\"./images/defaultbutton/sort_asc.gif\" border=\"0\" /></a>\n";
    } else if ($sort4 == "2"){
        print "                            <a href=\"" . art_gen_url($qrystr[4] ,1) . "\" class=\"gridColumnLink\"><img src=\"./images/defaultbutton/sort_desc.gif\" border=\"0\" /></a>\n";
    } else if (trim($sort4) == ""){
        print "                            <a href=\"" . art_gen_url($qrystr[4] ,1) . "\" class=\"gridColumnLink\"><img src=\"./images/defaultbutton/sort_none.gif\" border=\"0\" /></a>\n";
    }
    print "                        </div>\n";
    print "                    </td>\n";
    print "                    <td class=\"gridColumn\"  NOWRAP >\n";
    print "                        <div class=\"gridColumnText\">\n";
    print "                            <a href=\"" . art_gen_url($qrystr[5], 1) . "\" class=\"gridColumnLink\">Fecha Creacion</a>\n";
    if ($sort5 == "1") {
        print "                            <a href=\"" . art_gen_url($qrystr[5] ,1) . "\" class=\"gridColumnLink\"><img src=\"./images/defaultbutton/sort_asc.gif\" border=\"0\" /></a>\n";
    } else if ($sort5 == "2"){
        print "                            <a href=\"" . art_gen_url($qrystr[5] ,1) . "\" class=\"gridColumnLink\"><img src=\"./images/defaultbutton/sort_desc.gif\" border=\"0\" /></a>\n";
    } else if (trim($sort5) == ""){
        print "                            <a href=\"" . art_gen_url($qrystr[5] ,1) . "\" class=\"gridColumnLink\"><img src=\"./images/defaultbutton/sort_none.gif\" border=\"0\" /></a>\n";
    }
    print "                        </div>\n";
    print "                    </td>\n";
    print "                    <td class=\"gridColumn\"  NOWRAP >\n";
    print "                        <div class=\"gridColumnText\">\n";
    print "                            <a href=\"" . art_gen_url($qrystr[6], 1) . "\" class=\"gridColumnLink\">Reporte</a>\n";
    if ($sort6 == "1") {
        print "                            <a href=\"" . art_gen_url($qrystr[6] ,1) . "\" class=\"gridColumnLink\"><img src=\"./images/defaultbutton/sort_asc.gif\" border=\"0\" /></a>\n";
    } else if ($sort6 == "2"){
        print "                            <a href=\"" . art_gen_url($qrystr[6] ,1) . "\" class=\"gridColumnLink\"><img src=\"./images/defaultbutton/sort_desc.gif\" border=\"0\" /></a>\n";
    } else if (trim($sort6) == ""){
        print "                            <a href=\"" . art_gen_url($qrystr[6] ,1) . "\" class=\"gridColumnLink\"><img src=\"./images/defaultbutton/sort_none.gif\" border=\"0\" /></a>\n";
    }
    print "                        </div>\n";
    print "                    </td>\n";
    print "                    <td class=\"gridColumn\" width=\"40px\"  NOWRAP >\n";
    print "                        <div class=\"gridColumnText\">\n";
    print "                            <a class=\"gridColumnText\">&nbsp;</a>\n";
    print "                        </div>\n";
    print "                    </td>\n";
    print "                    <td class=\"gridColumn\" width=\"40px\"  NOWRAP >\n";
    print "                        <div class=\"gridColumnText\">\n";
    print "                            <a class=\"gridColumnText\">&nbsp;</a>\n";
    print "                        </div>\n";
    print "                    </td>\n";
    print "                </tr>\n";
    $emptydatatext = "No Record Found.";

    $layoutcolumn = 1;
    $icolumn = 0;
    $csscurrrow = "";
    $haveselectrow = false;
    $group = "";
    $currgroup = "";
    if ( ($numrows > 0) && ($result) ) {
        $i = 1;
        while ($row = mysql_fetch_array($result)){ 
            $pagerecords = $i;
            if (strtolower($csscurrrow) == "gridrow"){
                $csscurrrow = "gridRowAlternate";
            }else{
                $csscurrrow = "gridRow";
            }
            $cssrowover = "";
            $isrecmaster = false;
            if ($isrecmaster) {
                $haveselectrow = true;
                $cssrowover = "gridRowOver";
            }
            $cssrow = $csscurrrow;
            if ($cssrowover != "") {
                $cssrow = $cssrowover;
            }

            print "<tr class='".$cssrow."' >\n";
            print "<td align=\"right\" >";
            $svalue = art_check_null( number_format( art_rowdata($row, 0) , 2, '.', ',' ) );
            if ($svalue != "&nbsp;"){
                $svalue = htmlspecialchars($svalue);
            }
            print $svalue;
            print "</td>\n";
            print "<td align=\"left\" >";
            $svalue = art_check_null( art_rowdata($row, 1) );
            if ($svalue != "&nbsp;"){
                $svalue = htmlspecialchars($svalue);
            }
            print $svalue;
            print "</td>\n";
            print "<td align=\"left\" >";
            $svalue = art_check_null( art_rowdata($row, 2) );
            if ($svalue != "&nbsp;"){
                $svalue = htmlspecialchars($svalue);
            }
            print $svalue;
            print "</td>\n";
            print "<td align=\"left\" >";
            $svalue = art_check_null( art_rowdata($row, 3) );
            if ($svalue != "&nbsp;"){
                $svalue = htmlspecialchars($svalue);
            }
            print $svalue;
            print "</td>\n";
            print "<td align=\"left\" >";
            $svalue = art_check_null( art_format_date( art_rowdata($row, 4) , "m/d/Y") );
            if ($svalue != "&nbsp;"){
                $svalue = htmlspecialchars($svalue);
            }
            print $svalue;
            print "</td>\n";
            print "<td align=\"left\" >";
            $svalue = art_check_null( art_rowdata($row, 5) );
            if ($svalue != "&nbsp;"){
                $svalue = htmlspecialchars($svalue);
            }
            print $svalue;
            print "</td>\n";
            print "<td align=\"center\" >";
            print "<a href=\"" . "./usuario_edit.php". "?pm_id=" . art_rowdata_byname($row, $field_names, "usuario.id"). "\"" . " title=\"Edit\" target=\"_self\" class=\"gridBodyLink\">";
            $filename = "./images/defaultbutton/edit.gif";
            if ($filename == ""){
                $filename = "";
            }
            print "<img src=\"" . $filename . "\"  border=\"0\" />";
            print "</a>";
            print "</td>\n";
            print "<td align=\"center\" >";
            print "<a href=\"" . "./usuario_delete.php". "?pm_id=" . art_rowdata_byname($row, $field_names, "usuario.id"). "\"" . " title=\"Delete\" target=\"_self\" class=\"gridBodyLink\">";
            $filename = "./images/defaultbutton/delete.gif";
            if ($filename == ""){
                $filename = "";
            }
            print "<img src=\"" . $filename . "\"  border=\"0\" />";
            print "</a>";
            print "</td>\n";
            print "</tr>\n";

            $i++;
        }
    } else {
        print "                <tr class=\"gridRow\">\n";
        print "                    <td colspan=\"8\" ><div class=\"gridErrMsg\">" . $emptydatatext . "</div></td>\n";
        print "                </tr>\n";
    }
    print "            </table>\n";
    print "            <table  border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"gridFooter\" >\n";
    print "                <tr>\n";
    print "                    <td class=\"gridFooterLeft\" nowrap >&nbsp;</td>\n";
    print "                    <td class=\"gridFooterBG\" colspan=\"8\">\n";
    if ( ($numrows > 0) && ($result) ){
        if (isset($_SERVER["QUERY_STRING"])){
            parse_str($_SERVER["QUERY_STRING"], $query_array);
            parse_str($_SERVER["QUERY_STRING"]."&page=1", $query_array);
            $querystr = art_remove_qrystring($query_array, "page, page_size, order1, order2, order3, sort1, sort2, sort3, clr");
        }
        $use_ajax = 1;
        $folder_button_images = "defaultbutton";
        if ($navtype != ""){
            $pagename = "usuario";
            art_show_navigator($pagename, $navtype, $numrows, $page_size, $current_page, "usuario_ajax.php", 1, 0, $use_ajax, $folder_button_images);
        }
    } else {
        print "                <table align=\"center\" width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\" class=\"inside\">\n";
        print "                    <tr>\n";
        print "                        <td class=\"gridFooterText\" align=\"right\"></td>\n";
        print "                    </tr>\n";
        print "                </table>\n";
    }
    print "                    </td>\n";
    print "                    <td class=\"gridFooterRight\" nowrap >&nbsp;</td>\n";
    print "                </tr>\n";
    print "            </table>\n";
    print "        </td>\n";
    print "    </tr>\n";
    print "</table>\n";
    print "</div>\n";

    print "</td>\n";
    print "</tr>\n";
    print "</table>\n";
    print "</td>\n";
    print "</tr>\n";
    print "</table>\n";

    print "<input type=\"hidden\" name=\"artsys_pagerecords\" value=\"".$pagerecords."\" >\n";
    print "<input type=\"hidden\" name=\"artsys_postback\" value=\"1\" >\n";
    print "<br />\n"; 
}

function del_selected_items($pagerecords) {
    $j = 0;
    $k = 0;
    $msg = "";
    for ($i=1; $i <= $pagerecords; $i++){
        $del_id = art_request("chk_delfile".$i, "");
        if ($del_id != ""){
            $artv_pm_id = art_request("pm_id" . $i, "");
            if ($j==0){

                $sqlDel = "DELETE FROM `usuario` WHERE ";
                $sqlDel .= "usuario.id = " .  art_quote_intval($artv_pm_id);
                $qryDel = mysql_query($sqlDel);
                if($qryDel){
                    art_set_request("chk_delfile".$i, "");
                } else {
                    $j++;
                }
            } else {
                $j++;
            }
        } else {
            $k++;
		    }
    }
    if ($k == $pagerecords){
        $msg = MSG_MULTIDEL_NO_SELECTED;
    }
    if($j > 0){
        $msg = MSG_MULTIDEL_FAIL;
    }
    return $msg;
}

function art_groupdatagrid_display($field_names, $page_size, $current_page, $quick_search, $navtype, $category, $showtotalrec=0, $showpagesize=0) {	
    $artsv_postback = art_request("artsys_postback", "");
    $sql = "";
    $sql_start = " ";
    $sql_condition = "";
    $sql_ext = "";
    $cssrow = "";
    $query_array = "";
    $querystr = ""; 
    $pagerecords = 0; 
    $field_columns = array (
        'usuario.id'
        ,'usuario.nombre'
        ,'usuario.cedula'
        ,'usuario.tipo_usuario'
        ,'usuario.fecha_creacion'
        ,'usuario.reporte'
        ,''
        ,''
	  );

    $qrystr = array_fill(0, 8, "");

    $clr = art_request("clr_usuario", "");
    $clr_adv_session = art_request("clr_usuario_adv_session", "");

    if (strtolower($clr) == "t") {
        art_clear_session("usuario_sort1");	
        art_clear_session("usuario_sort2");	
        art_clear_session("usuario_sort3");	
        art_clear_session("usuario_sort4");	
        art_clear_session("usuario_sort5");	
        art_clear_session("usuario_sort6");	
        art_clear_session("usuario_sort7");	
        art_clear_session("usuario_sort8");	
        $clr = "";
	  }

    if (strtolower($clr_adv_session) == "y") {
        $clr_adv_session = "";
        art_clear_session("usuario_search");
        art_clear_session("usuario_page");
        art_clear_session("usuario_quick_search");
        art_clear_session("usuario_category");
        $quick_search = "";
        $category = "";
	  }
    art_assign_session("usuario_page_size", 20);
    art_assign_session("usuario_page", "1");
    art_assign_session("usuario_sort1", "");
    art_assign_session("usuario_sort2", "");
    art_assign_session("usuario_sort3", "");
    art_assign_session("usuario_sort4", "");
    art_assign_session("usuario_sort5", "");
    art_assign_session("usuario_sort6", "");
    art_assign_session("usuario_sort7", "");
    art_assign_session("usuario_sort8", "");
    $sql_array  = art_split_sql(" select * from `usuario`"); 
    $sql_start = $sql_array[0]; 
    $sql_orderby = $sql_array[1]; 

    $sort1 = art_session("usuario_sort1", "");
    $sort2 = art_session("usuario_sort2", "");
    $sort3 = art_session("usuario_sort3", "");
    $sort4 = art_session("usuario_sort4", "");
    $sort5 = art_session("usuario_sort5", "");
    $sort6 = art_session("usuario_sort6", "");
    $sort7 = art_session("usuario_sort7", "");
    $sort8 = art_session("usuario_sort8", "");
    $page_size = art_session("usuario_page_size", "20");
    $page = art_session("usuario_page", "1");
    $current_page = $page;
    $search = "";
    $sql_condition = $sql_start;
    for ($i=1; $i<=8; $i++){
        $sorting = "";
        $sort_order = "";
		    if (art_session("usuario_sort".$i, "") == "1"){
		    	  $sorting = "&usuario_sort". $i . "=" . "2";
            $sort_order = "ASC";
		    } else if (art_session("usuario_sort".$i, "") == "2"){
		        $sorting = "&usuario_sort". $i . "=" . "1";
            $sort_order = "DESC";
		    } else {
		        $sorting = "&usuario_sort". $i . "=" . "1";
            $sort_order = "";
		    }
        $qrystr[$i] = "usuario_ajax.php?clr_usuario=t".$sorting;

		    if ($sort_order != ""){
            if ($sql_orderby == ""){
	  	          $sql_orderby .= " ORDER BY " . $field_columns[$i - 1] . " " . $sort_order;
	          } else {
	  	          $sql_orderby .= ", " . $field_columns[$i - 1] . " " . $sort_order;
	          }
        }
    }
    $advsearch_sql = art_session("usuario_search","");
    if ($advsearch_sql != "") {
        $sql_condition = art_append_sqlcondition($sql_condition, $advsearch_sql);
    }
    $current_row = ($current_page - 1) * $page_size;
    $sql_condition .= $sql_orderby;	
    $sql = $sql_condition;
    $result = mysql_query($sql);
    $numrows = 0;
    if ($result != null) { $numrows = mysql_num_rows($result); }
    $sql_ext = "";
    if ($numrows < $current_row) {
       $current_row =  $numrows - 1;
    }
    $sql_ext = " LIMIT " . $current_row . ", " . $page_size;
    $sql = $sql  . " " . $sql_ext;
    $result = mysql_query($sql);
    $numrow1 = mysql_num_rows($result);

    print "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"  width=\"100%\" align=\"center\">\n";
    print "<tr>\n";
    print "<td>\n";
    print "<div id=\"mainmenu_defaulttheme\">\n";
    print "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"  width=\"100%\">\n";
    print "    <tr>\n";
    print "    <td colspan=\"3\" valign=\"top\" class=\"mainMenuBG\" >\n";
    print "        <table align=\"right\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
    print "            <tr>\n";
    $sessionlevel = art_session('art_user_level', -1);
    $menuprint = false;
    if ($sessionlevel < 0) {
        if ($menuprint) {
          print "                <td>\n";
          print "                    <span class=\"mainMenuText\">\n";
          print "                        &nbsp;|&nbsp;\n";
          print "                    </span>\n";
          print "                </td>\n";
          $menuprint = false;
        }
        print "                <td>\n";
        print "<a href=\"" . "./user_logout.php". "\"" . " title=\"Login\" class=\"mainMenuLink\"><div><p>Login</p></div></a>";
        print "                </td>\n";
        $menuprint = true;
    }
    if ($sessionlevel > 0) {
        if ($menuprint) {
          print "                <td>\n";
          print "                    <span class=\"mainMenuText\">\n";
          print "                        &nbsp;|&nbsp;\n";
          print "                    </span>\n";
          print "                </td>\n";
          $menuprint = false;
        }
        print "                <td>\n";
        print "<a href=\"" . "./user_logout.php". "\"" . " title=\"Logout\" class=\"mainMenuLink\"><div><p>Logout</p></div></a>";
        print "                </td>\n";
        $menuprint = true;
    }
    print "            </tr>\n";
    print "        </table>\n";
    print "    </td>\n";
    print "    </tr>\n";
    print "</table>\n";
    print "</div>\n";

    print "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
    print "<tr>\n";
    print "<td width=\"1\" align=\"left\" valign=\"top\">\n";
    art_sitemenu_display("usuario", "defaulttheme");
    print "</td>\n";
    print "<td align=\"left\" class=\"siteMenuGap\">&nbsp;</td>\n";
    print "<td valign=\"top\">\n";
    print "<br />\n";
    print "<div id=\"defaulttheme\">";
    print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"gridTable\"  width=\"90%\">\n";
    print "    <tr>\n";
    print "        <td>\n";
    $gridtitle = "Usuario";
    print "            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"gridHeader\" >\n";
    print "                <tr>\n";
    print "                    <td class=\"gridHeaderBGLeft\" nowrap >&nbsp;</td>\n";
    print "                    <td class=\"gridHeaderBG\" colspan=\"8\">\n";
    print "                        <table border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    print "                            <tr>\n";
    print "                                <td valign=\"baseline\" ><span class=\"gridHeaderText\">" . $gridtitle . "</span></td>\n";
    print "                            </tr>\n";
    print "                        </table>\n";
    print "                    </td>\n";
    print "                    <td class=\"gridHeaderBGRight\" nowrap >&nbsp;</td>\n";
    print "                </tr>\n";
    print "            </table>\n";
    print "            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"gridToolBar\" >\n";
    print "                <tr>\n";
    print "                    <td colspan=\"8\">\n";
    print "                        <table border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    print "                            <tr>\n";
    print "                                <td valign=\"baseline\" >";
    print "                                </td>\n";
    print "                                <td align=\"right\">\n";
    print "<a href=\"" . art_gen_url("usuario_ajax.php?clr_usuario_adv_session=y", 1). "\"" . " title=\"Show All\" class=\"gridToolBarLink\"><img src=\"./images/defaultbutton/show_all.gif\" border=\"0\" /></a>";
    print "&nbsp;<a href=\"" . art_gen_url("usuario_ajax.php?clr_usuario=t", 1). "\"" . " title=\"Clear Sort\" class=\"gridToolBarLink\"><img src=\"./images/defaultbutton/clear_sort.gif\" border=\"0\" /></a>";
    print "&nbsp;<a href=\"" . "./usuario_search.php". "\"" . " title=\"Advance Search\" class=\"gridToolBarLink\"><img src=\"./images/defaultbutton/adv_search.gif\" border=\"0\" /></a>";
    print "&nbsp;<a href=\"" . "./usuario_add.php". "\"" . " title=\"Add New Record\" class=\"gridToolBarLink\"><img src=\"./images/defaultbutton/add.gif\" border=\"0\" /></a>";
    print "&nbsp;";
    print "                                </td>\n";
    print "                            </tr>\n";
    print "                        </table>\n";
    print "                    </td>\n";
    print "                </tr>\n";
    print "            </table>\n";
    print "            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"gridMain\" >\n";
    print "            <tbody>\n";
    print "                <tr>\n";
    print "                    <td class=\"gridColumn\" ><div class=\"gridColumnText\">Id</div></td>\n";
    print "                    <td class=\"gridColumn\" ><div class=\"gridColumnText\">Nombre</div></td>\n";
    print "                    <td class=\"gridColumn\" ><div class=\"gridColumnText\">Cedula</div></td>\n";
    print "                    <td class=\"gridColumn\" ><div class=\"gridColumnText\">Tipo Usuario</div></td>\n";
    print "                    <td class=\"gridColumn\" ><div class=\"gridColumnText\">Fecha Creacion</div></td>\n";
    print "                    <td class=\"gridColumn\" ><div class=\"gridColumnText\">Reporte</div></td>\n";
    print "                    <td class=\"gridColumn\" ><div class=\"gridColumnText\">&nbsp;</div></td>\n";
    print "                    <td class=\"gridColumn\" ><div class=\"gridColumnText\">&nbsp;</div></td>\n";
    print "                </tr>\n";
    print "            </tbody>\n";
    $emptydatatext = "No Record Found.";
    $layoutcolumn = 1;
    $icolumn = 0;
    $csscurrrow = "";
    $haveselectrow = false;
    $group = "";
    $currgroup = "no_group_selected";
    $gr_1 = 0;
    $gr_2 = 1;
    if ( ($numrows > 0) && ($result) ){
        $i = 1;
        while ($row = mysql_fetch_array($result)){ 
            $pagerecords = $i;
            $group = art_rowdata($row, -1);
            if (strcmp($group, $currgroup) != 0){
                $currgroup = $group;
                $gr_1++;
                if ($gr_1 != $gr_2){
                    print "            </tbody>\n";
                }
                print "            <tbody id=\"header_gr_". $gr_1 ."\">\n"; 
                print "                <tr>\n"; 
                print "                    <td colspan=\"8\" class=\"groupCaption\">\n"; 
                print "                    <div class=\"gridToolBarText\" align=\"left\">";
                print "<a href=\"javascript:art_toggle_groupdetail('"."gr_".$gr_1."','"."bt_collapse_".$gr_1."','"."bt_expand_".$gr_1."');\" title=\"" . CAP_CLOSE_GROUP . "\">";
                print "<img type=\"image\" id=\"bt_collapse_".$gr_1."\" src=\"images/defaultbutton/ic_collapse.gif\" style=\"display:'\" border=\"0\" align=\"absmiddle\" alt=\"" . CAP_CLOSE_GROUP . "\" ></a>\n";
                print "<a href=\"javascript:art_toggle_groupdetail('"."gr_".$gr_1."','"."bt_collapse_".$gr_1."','"."bt_expand_".$gr_1."');\" title=\"" . CAP_EXPAND_GROUP . "\">";
                print "<img type=\"image\" id=\"bt_expand_".$gr_1."\" src=\"images/defaultbutton/ic_expand.gif\" style=\"display:none\" border=\"0\" align=\"absmiddle\" alt=\"" . CAP_EXPAND_GROUP . "\" ></a>\n";
                print "&nbsp;" . $currgroup . "\n";
                print "                    </div>\n";
                print "                    </td>\n";
                print "                </tr>\n";
                print "            </tbody>\n";
                print "            <tbody id=\""."gr_".$gr_1."\" style=\"display:'';\">";
            }
            if (strtolower($csscurrrow) == "gridrow"){
                $csscurrrow = "gridRowAlternate";
            }else{
                $csscurrrow = "gridRow";
            }
            $cssrowover = "";
            $isrecmaster = false;
            if ($isrecmaster) {
                $haveselectrow = true;
                $cssrowover = "gridRowOver";
            }
            $cssrow = $csscurrrow;
            if ($cssrowover != "") {
                $cssrow = $cssrowover;
            }
            print "<tr class='".$cssrow."' >\n";
            print "<td align=\"right\" >";
            $svalue = art_check_null( number_format( art_rowdata($row, 0) , 2, '.', ',' ) );
            if ($svalue != "&nbsp;"){
                $svalue = htmlspecialchars($svalue);
            }
            print $svalue;
            print "</td>\n";
            print "<td align=\"left\" >";
            $svalue = art_check_null( art_rowdata($row, 1) );
            if ($svalue != "&nbsp;"){
                $svalue = htmlspecialchars($svalue);
            }
            print $svalue;
            print "</td>\n";
            print "<td align=\"left\" >";
            $svalue = art_check_null( art_rowdata($row, 2) );
            if ($svalue != "&nbsp;"){
                $svalue = htmlspecialchars($svalue);
            }
            print $svalue;
            print "</td>\n";
            print "<td align=\"left\" >";
            $svalue = art_check_null( art_rowdata($row, 3) );
            if ($svalue != "&nbsp;"){
                $svalue = htmlspecialchars($svalue);
            }
            print $svalue;
            print "</td>\n";
            print "<td align=\"left\" >";
            $svalue = art_check_null( art_format_date( art_rowdata($row, 4) , "m/d/Y") );
            if ($svalue != "&nbsp;"){
                $svalue = htmlspecialchars($svalue);
            }
            print $svalue;
            print "</td>\n";
            print "<td align=\"left\" >";
            $svalue = art_check_null( art_rowdata($row, 5) );
            if ($svalue != "&nbsp;"){
                $svalue = htmlspecialchars($svalue);
            }
            print $svalue;
            print "</td>\n";
            print "<td align=\"center\" >";
            print "<a href=\"" . "./usuario_edit.php". "?pm_id=" . art_rowdata_byname($row, $field_names, "usuario.id"). "\"" . " title=\"Edit\" target=\"_self\" class=\"gridBodyLink\">";
            $filename = "./images/defaultbutton/edit.gif";
            if ($filename == ""){
                $filename = "";
            }
            print "<img src=\"" . $filename . "\"  border=\"0\" />";
            print "</a>";
            print "</td>\n";
            print "<td align=\"center\" >";
            print "<a href=\"" . "./usuario_delete.php". "?pm_id=" . art_rowdata_byname($row, $field_names, "usuario.id"). "\"" . " title=\"Delete\" target=\"_self\" class=\"gridBodyLink\">";
            $filename = "./images/defaultbutton/delete.gif";
            if ($filename == ""){
                $filename = "";
            }
            print "<img src=\"" . $filename . "\"  border=\"0\" />";
            print "</a>";
            print "</td>\n";
            print "</tr>\n";

            $i++;
        }
    }else {
        print "                <tr class=\"gridRow\">\n";
        print "                    <td colspan=\"8\" ><div class=\"gridErrMsg\">" . $emptydatatext . "</div></td>\n";
        print "                </tr>\n";
    }
    print "            </table>\n";
    print "            <table  border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"gridFooter\" >\n";
    print "                <tr>\n";
    print "                    <td class=\"gridFooterLeft\" nowrap >&nbsp;</td>\n";
    print "                    <td class=\"gridFooterBG\" colspan=\"8\">\n";
    if ( ($numrows > 0) && ($result) ) {
        if (isset($_SERVER["QUERY_STRING"])) {
            parse_str($_SERVER["QUERY_STRING"], $query_array);
            parse_str($_SERVER["QUERY_STRING"]."&page=1", $query_array);
            $querystr = art_remove_qrystring($query_array, "page, page_size, order1, order2, order3, sort1, sort2, sort3, clr");
        }
        $use_ajax = 1;
        $folder_button_images = "defaultbutton";
        if ($navtype != ""){
            $pagename = "usuario";
            art_show_navigator($pagename, $navtype, $numrows, $page_size, $current_page, "usuario_ajax.php", 1, 0, $use_ajax, $folder_button_images);
        }
    } else {
        print "                <table align=\"center\" width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\" class=\"inside\">\n";
        print "                    <tr>\n";
        print "                        <td class=\"gridFooterText\" align=\"right\"></td>\n";
        print "                    </tr>\n";
        print "                </table>\n";
    }
    print "                    </td>\n";
    print "                    <td class=\"gridFooterRight\" nowrap >&nbsp;</td>\n";
    print "                </tr>\n";
    print "            </table>\n";
    print "        </td>\n";
    print "    </tr>\n";
    print "</table>\n";
    print "</div>\n";

    print "</td>\n";
    print "</tr>\n";
    print "</table>\n";
    print "</td>\n";
    print "</tr>\n";
    print "</table>\n";

    print "<input type=\"hidden\" name=\"artsys_pagerecords\" value=\"" . $pagerecords . "\" >\n";
    print "<input type=\"hidden\" name=\"artsys_postback\" value=\"1\" >\n";
    print "<br />\n"; 
}
?>
