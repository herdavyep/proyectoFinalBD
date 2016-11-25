<?php
require_once './includes/art_functions.php';
require_once './languages/art_lang.php';

function art_form_deletedata_display($form, $message){
    $field_names = array (
        "clientes.id"
        ,"clientes.nombre"
        ,"clientes.cedula"
        ,"clientes.fecha_creacion"
    );

    $artv_pm_id = art_request("pm_id", "");
    $disabled = "";
    $check = "";
    art_set_session('art_form_loaded', 0);
    $gridtitle = "Clientes Delete";

    $sql = "select * from `clientes`";
    $sql .= " WHERE ";
	  $sql .= " clientes.id = " .  art_quote_intval($artv_pm_id);
    $query = mysql_query($sql);
    if ($query) {
        $row = mysql_fetch_array($query);
    } else {
        $submiturl = "./clientes.php";
        art_show_errormsg(MSG_EXECUTE_SQL_FAIL, $submiturl);
        exit;
    }
    $artv_id =  number_format( art_rowdata($row, 0) , 2, '.', ',' ) ;
    $artv_nombre =  art_rowdata($row, 1) ;
    $artv_cedula =  art_rowdata($row, 2) ;
    $artv_fecha_creacion =  art_format_date( art_rowdata($row, 3) , "m/d/Y") ;

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
    art_sitemenu_display("clientes_delete", "defaulttheme");
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
    $svalue = art_check_null($artv_nombre);
    if ($svalue != "&nbsp;"){
        $svalue = htmlspecialchars($svalue);
    }
    print "<tr>\n";
    print "<td class=\"formColumnCaption\">Nombre</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<label id=\"nombre\" name=\"nombre\" >" . $svalue . "</label>\n";
    print"<input id=\"lbhd_nombre\" name=\"lbhd_nombre\" type=\"hidden\" value=\"" . $svalue . "\" >\n";
    print "</td>\n";
    print "</tr>\n";
    $svalue = art_check_null($artv_cedula);
    if ($svalue != "&nbsp;"){
        $svalue = htmlspecialchars($svalue);
    }
    print "<tr>\n";
    print "<td class=\"formColumnCaption\">Cedula</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<label id=\"cedula\" name=\"cedula\" >" . $svalue . "</label>\n";
    print"<input id=\"lbhd_cedula\" name=\"lbhd_cedula\" type=\"hidden\" value=\"" . $svalue . "\" >\n";
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
    print "	                  <tr>\n";
    print "	                      <td class=\"formColumnCaption\"></td>\n";
    print "	                      <td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "	                      <td class=\"formColumnData\" align=\"left\" ></br>\n";
    print "		                        <input name=\"btn_delete\" id=\"btn_delete\" type=\"submit\" value=\"" . CAP_BUTTON_DELETE . "\" class=\"button\" >\n";
    $urldatapage = "href='" . "./clientes.php" . "'";
    print "		                        <input name=\"btn_cancel\" id=\"btn_cancel\" type=\"reset\" value=\"" . CAP_BUTTON_CANCEL . "\" class=\"button\" onClick=\"javascript:window.location." . $urldatapage . " \">\n";
    print "		                        <input type=\"hidden\" name=\"pm_id\" value=\"".$artv_pm_id."\">\n";	

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
    $artv_pm_id = art_request("pm_id", "");
    $artv_id = art_request("id", "");
    $artv_nombre = art_request("nombre", "");
    $artv_cedula = art_request("cedula", "");
    $artv_fecha_creacion = art_request("fecha_creacion", "");
    if ($result != "") {
	      return $result;
    }

    if ( ($result == "") && (art_session('art_form_loaded', 0) != 1)){

        $sql = "DELETE FROM `clientes`";
        $sql .= " WHERE ";
        $sql .= " clientes.id = " .  art_quote_intval($artv_pm_id);
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
