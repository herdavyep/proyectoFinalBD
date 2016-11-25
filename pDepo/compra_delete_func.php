<?php
require_once './includes/art_functions.php';
require_once './languages/art_lang.php';

function art_form_deletedata_display($form, $message){
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

    $artv_pm_calidad_id = art_request("pm_calidad_id", "");
    $artv_pm_clientes_id = art_request("pm_clientes_id", "");
    $artv_pm_id = art_request("pm_id", "");
    $artv_pm_usuario_id = art_request("pm_usuario_id", "");
    $disabled = "";
    $check = "";
    art_set_session('art_form_loaded', 0);
    $gridtitle = "Compra Delete";

    $sql = "select * from `compra`";
    $sql .= " WHERE ";
	  $sql .= " compra.calidad_id = " .  art_quote_intval($artv_pm_calidad_id);
	  $sql .= " AND  compra.clientes_id = " .  art_quote_intval($artv_pm_clientes_id);
	  $sql .= " AND  compra.id = " .  art_quote_intval($artv_pm_id);
	  $sql .= " AND  compra.usuario_id = " .  art_quote_intval($artv_pm_usuario_id);
    $query = mysql_query($sql);
    if ($query) {
        $row = mysql_fetch_array($query);
    } else {
        $submiturl = "./compra.php";
        art_show_errormsg(MSG_EXECUTE_SQL_FAIL, $submiturl);
        exit;
    }
    $artv_id =  number_format( art_rowdata($row, 0) , 2, '.', ',' ) ;
    $artv_fecha_creacion =  art_format_date( art_rowdata($row, 1) , "m/d/Y") ;
    $artv_kilos =  number_format( art_rowdata($row, 2) , 2, '.', ',' ) ;
    $artv_arrobas =  number_format( art_rowdata($row, 3) , 2, '.', ',' ) ;
    $artv_precio =  number_format( art_rowdata($row, 4) , 2, '.', ',' ) ;
    $artv_total =  number_format( art_rowdata($row, 5) , 2, '.', ',' ) ;
    $artv_bultos =  number_format( art_rowdata($row, 6) , 2, '.', ',' ) ;
    $artv_clientes_id =  number_format( art_rowdata($row, 7) , 2, '.', ',' ) ;
    $artv_calidad_id =  number_format( art_rowdata($row, 8) , 2, '.', ',' ) ;
    $artv_usuario_id =  number_format( art_rowdata($row, 9) , 2, '.', ',' ) ;

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
    art_sitemenu_display("compra_delete", "defaulttheme");
    print "</td>\n";
    print "<td align=\"left\" class=\"siteMenuGap\">&nbsp;</td>\n";
    print "<td valign=\"top\">\n";
    print "<br />\n";

    print "<div id=\"defaulttheme\">";
    print "    <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"  width=\"90%\" >\n";
    print "        <tr>\n";
    print "            <td class=\"formHeaderBGLeft\" nowrap >&nbsp;</td>\n";
    print "            <td class=\"formHeaderBG\"><span class=\"formHeaderText\">" . $gridtitle . "</span>&nbsp;</td>\n";
    print "            <td class=\"formHeaderBGRight\" nowrap >&nbsp;</td>\n";
    print "        </tr>\n";
    print "        <tr>\n";
    print "            <td class=\"formColumnBGLeft\" align=\"left\">&nbsp;</td>\n";
    print "            <td>\n";
    print "                <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"formBody\" >\n";
    $svalue = art_check_null($artv_id);
    if ($svalue != "&nbsp;"){
        $svalue = htmlspecialchars($svalue);
    }
    print "<tr>\n";
    print "<td class=\"formColumnCaption\">Id</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<label id=\"id\" name=\"id\" >" . $svalue . "</label>\n";
    print"<input id=\"lbhd_id\" name=\"lbhd_id\" type=\"hidden\" value=\"" . $svalue . "\" >\n";
    print "</td>\n";
    print "</tr>\n";
    $svalue = art_check_null($artv_fecha_creacion);
    if ($svalue != "&nbsp;"){
        $svalue = htmlspecialchars($svalue);
    }
    print "<tr>\n";
    print "<td class=\"formColumnCaption\">Fecha Creacion</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<label id=\"fecha_creacion\" name=\"fecha_creacion\" >" . $svalue . "</label>\n";
    print"<input id=\"lbhd_fecha_creacion\" name=\"lbhd_fecha_creacion\" type=\"hidden\" value=\"" . $svalue . "\" >\n";
    print "</td>\n";
    print "</tr>\n";
    $svalue = art_check_null($artv_kilos);
    if ($svalue != "&nbsp;"){
        $svalue = htmlspecialchars($svalue);
    }
    print "<tr>\n";
    print "<td class=\"formColumnCaption\">Kilos</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<label id=\"kilos\" name=\"kilos\" >" . $svalue . "</label>\n";
    print"<input id=\"lbhd_kilos\" name=\"lbhd_kilos\" type=\"hidden\" value=\"" . $svalue . "\" >\n";
    print "</td>\n";
    print "</tr>\n";
    $svalue = art_check_null($artv_arrobas);
    if ($svalue != "&nbsp;"){
        $svalue = htmlspecialchars($svalue);
    }
    print "<tr>\n";
    print "<td class=\"formColumnCaption\">Arrobas</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<label id=\"arrobas\" name=\"arrobas\" >" . $svalue . "</label>\n";
    print"<input id=\"lbhd_arrobas\" name=\"lbhd_arrobas\" type=\"hidden\" value=\"" . $svalue . "\" >\n";
    print "</td>\n";
    print "</tr>\n";
    $svalue = art_check_null($artv_precio);
    if ($svalue != "&nbsp;"){
        $svalue = htmlspecialchars($svalue);
    }
    print "<tr>\n";
    print "<td class=\"formColumnCaption\">Precio</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<label id=\"precio\" name=\"precio\" >" . $svalue . "</label>\n";
    print"<input id=\"lbhd_precio\" name=\"lbhd_precio\" type=\"hidden\" value=\"" . $svalue . "\" >\n";
    print "</td>\n";
    print "</tr>\n";
    $svalue = art_check_null($artv_total);
    if ($svalue != "&nbsp;"){
        $svalue = htmlspecialchars($svalue);
    }
    print "<tr>\n";
    print "<td class=\"formColumnCaption\">Total</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<label id=\"total\" name=\"total\" >" . $svalue . "</label>\n";
    print"<input id=\"lbhd_total\" name=\"lbhd_total\" type=\"hidden\" value=\"" . $svalue . "\" >\n";
    print "</td>\n";
    print "</tr>\n";
    $svalue = art_check_null($artv_bultos);
    if ($svalue != "&nbsp;"){
        $svalue = htmlspecialchars($svalue);
    }
    print "<tr>\n";
    print "<td class=\"formColumnCaption\">Bultos</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<label id=\"bultos\" name=\"bultos\" >" . $svalue . "</label>\n";
    print"<input id=\"lbhd_bultos\" name=\"lbhd_bultos\" type=\"hidden\" value=\"" . $svalue . "\" >\n";
    print "</td>\n";
    print "</tr>\n";
    $svalue = art_check_null($artv_clientes_id);
    if ($svalue != "&nbsp;"){
        $svalue = htmlspecialchars($svalue);
    }
    print "<tr>\n";
    print "<td class=\"formColumnCaption\">Clientes Id</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<label id=\"clientes_id\" name=\"clientes_id\" >" . $svalue . "</label>\n";
    print"<input id=\"lbhd_clientes_id\" name=\"lbhd_clientes_id\" type=\"hidden\" value=\"" . $svalue . "\" >\n";
    print "</td>\n";
    print "</tr>\n";
    $svalue = art_check_null($artv_calidad_id);
    if ($svalue != "&nbsp;"){
        $svalue = htmlspecialchars($svalue);
    }
    print "<tr>\n";
    print "<td class=\"formColumnCaption\">Calidad Id</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<label id=\"calidad_id\" name=\"calidad_id\" >" . $svalue . "</label>\n";
    print"<input id=\"lbhd_calidad_id\" name=\"lbhd_calidad_id\" type=\"hidden\" value=\"" . $svalue . "\" >\n";
    print "</td>\n";
    print "</tr>\n";
    $svalue = art_check_null($artv_usuario_id);
    if ($svalue != "&nbsp;"){
        $svalue = htmlspecialchars($svalue);
    }
    print "<tr>\n";
    print "<td class=\"formColumnCaption\">Usuario Id</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<label id=\"usuario_id\" name=\"usuario_id\" >" . $svalue . "</label>\n";
    print"<input id=\"lbhd_usuario_id\" name=\"lbhd_usuario_id\" type=\"hidden\" value=\"" . $svalue . "\" >\n";
    print "</td>\n";
    print "</tr>\n";
    print "	                  <tr>\n";
    print "	                      <td class=\"formColumnCaption\"></td>\n";
    print "	                      <td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "	                      <td class=\"formColumnData\" align=\"left\" ></br>\n";
    print "		                        <input name=\"btn_delete\" id=\"btn_delete\" type=\"submit\" value=\"" . CAP_BUTTON_DELETE . "\" class=\"button\" >\n";
    $urldatapage = "href='" . "./compra.php" . "'";
    print "		                        <input name=\"btn_cancel\" id=\"btn_cancel\" type=\"reset\" value=\"" . CAP_BUTTON_CANCEL . "\" class=\"button\" onClick=\"javascript:window.location." . $urldatapage . " \">\n";
    print "		                        <input type=\"hidden\" name=\"pm_calidad_id\" value=\"".$artv_pm_calidad_id."\">\n";	
    print "		                        <input type=\"hidden\" name=\"pm_clientes_id\" value=\"".$artv_pm_clientes_id."\">\n";	
    print "		                        <input type=\"hidden\" name=\"pm_id\" value=\"".$artv_pm_id."\">\n";	
    print "		                        <input type=\"hidden\" name=\"pm_usuario_id\" value=\"".$artv_pm_usuario_id."\">\n";	

    print "                           <input type=\"hidden\" name=\"artsys_postback\" value=\"1\" >\n";
    print "	                      </br></br>\n";
    print "	                      </td>\n";
    print "	                  </tr>\n";
    print "                </table>\n";
    print "            </td>\n";
    print "            <td class=\"formColumnBGRight\">&nbsp;</td>\n";
    print "        </tr>\n";
    print "        <tr>\n";
    print "            <td class=\"formFooterLeft\" nowrap >&nbsp;</td>\n";
    print "            <td class=\"formFooter\" align=\"center\" valign=\"middle\">&nbsp;</td>\n";
    print "            <td class=\"formFooterRight\" nowrap >&nbsp;</td>\n";
    print "        </tr>\n";
    print "    </table>\n";
    print "</div>";

    print "</td>\n";
    print "</tr>\n";
    print "</table>\n";
    print "</td>\n";
    print "</tr>\n";
    print "</table>\n";

}

function art_delete_data(){
    $result = "";
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
    if ($result != "") {
	      return $result;
    }

    if ( ($result == "") && (art_session('art_form_loaded', 0) != 1)){

        $sql = "DELETE FROM `compra`";
        $sql .= " WHERE ";
        $sql .= " compra.calidad_id = " .  art_quote_intval($artv_pm_calidad_id);
        $sql .= " AND  compra.clientes_id = " .  art_quote_intval($artv_pm_clientes_id);
        $sql .= " AND  compra.id = " .  art_quote_intval($artv_pm_id);
        $sql .= " AND  compra.usuario_id = " .  art_quote_intval($artv_pm_usuario_id);
    }

    if ($result == ""){
        $query = mysql_query($sql);
		    if (!$query){
            $result .= MSG_DELETE_RECORD_FAIL;
				    $result .= "</br>Error: " . mysql_error();
		    } else {
	          $result = "SUCCESS";
	          art_setdefault_session('art_form_loaded', 1);
        }
    }
    return $result;
}
?>
