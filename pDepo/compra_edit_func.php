<?php
require_once './includes/art_functions.php';
require_once './languages/art_lang.php';

function art_form_updatedata_display($form, $message){
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
    $artv_id = art_request("lbhd_id", "");
    $artv_fecha_creacion_year = art_request("fecha_creacion_year", "");
    $artv_fecha_creacion_month = art_request("fecha_creacion_month", "");
    $artv_fecha_creacion_day = art_request("fecha_creacion_day", "");
    if (($artv_fecha_creacion_year != "")
     && ($artv_fecha_creacion_month != "")
     && ($artv_fecha_creacion_day != "")) {
        $artv_fecha_creacion = $artv_fecha_creacion_year."-".$artv_fecha_creacion_month."-".$artv_fecha_creacion_day;
    } else {
        $artv_fecha_creacion = "";
    }
    $artv_kilos = art_request("kilos", "");
    $artv_arrobas = art_request("arrobas", "");
    $artv_precio = art_request("precio", "");
    $artv_total = art_request("total", "");
    $artv_bultos = art_request("bultos", "");
    $artv_clientes_id = art_request("clientes_id", "");
    $artv_calidad_id = art_request("calidad_id", "");
    $artv_usuario_id = art_request("usuario_id", "");

    $disabled = "";
    $check = "";
    art_set_session('art_form_loaded', 0);
    $gridtitle = "Compra Edit";

    $aj = art_request("aj", ""); 
    if (($aj != "1") && ($message == "")){
        $sql = "select * from `compra`";
        $sql .= " WHERE ";
        $sql .= " compra.calidad_id = " .  art_quote_intval($artv_pm_calidad_id);
	      $sql .= " AND  compra.clientes_id = " .  art_quote_intval($artv_pm_clientes_id);
	      $sql .= " AND  compra.id = " .  art_quote_intval($artv_pm_id);
	      $sql .= " AND  compra.usuario_id = " .  art_quote_intval($artv_pm_usuario_id);
        $query = mysql_query($sql);
        if ($query){
            $row = mysql_fetch_array($query);
        } else {
            $submiturl = "./compra.php";
            art_show_errormsg(MSG_EXECUTE_SQL_FAIL, $submiturl);
            exit;
        }
        $artv_message = "";
        $artv_id =  number_format( art_rowdata($row, 0) , 2, '.', ',' ) ;
        $artv_fecha_creacion =  art_rowdata($row, 1) ;
        $artv_kilos =  number_format( art_rowdata($row, 2) , 2, '.', ',' ) ;
        $artv_arrobas =  number_format( art_rowdata($row, 3) , 2, '.', ',' ) ;
        $artv_precio =  number_format( art_rowdata($row, 4) , 2, '.', ',' ) ;
        $artv_total =  number_format( art_rowdata($row, 5) , 2, '.', ',' ) ;
        $artv_bultos =  number_format( art_rowdata($row, 6) , 2, '.', ',' ) ;
        $artv_clientes_id =  number_format( art_rowdata($row, 7) , 2, '.', ',' ) ;
        $artv_calidad_id =  number_format( art_rowdata($row, 8) , 2, '.', ',' ) ;
        $artv_usuario_id =  number_format( art_rowdata($row, 9) , 2, '.', ',' ) ;

    }
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
    art_sitemenu_display("compra_edit", "defaulttheme");
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
    if ($message != "" ){
        print "<tr>\n";
        print "<td class=\"formColumnCaption\">Message</td>\n";
        print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
        print "<td class=\"formColumnData\" align=\"left\">\n";
        print "<label class=\"errMsg\" >" . $message . "</label>\n";
        print "</td>\n";
        print "</tr>\n";
    }
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
    $value = $artv_fecha_creacion;
    if (($value == "") || ($value == null)) {
        $value = "";
    }
    $v_year = "";
    $v_month = "";
    $v_day = "";
    $v_hour = "";
    $v_minute = "";
    $v_second = "";
    if ($value != "") {
      $datevalue = getdate(strtotime($value));
      if (is_array($datevalue)) {
        $v_year = $datevalue['year'];
        $v_month = str_pad($datevalue['mon'], 2, '0', STR_PAD_LEFT);
        $v_day = str_pad($datevalue['mday'], 2, '0', STR_PAD_LEFT);
        $v_hour = str_pad($datevalue['hours'], 2, '0', STR_PAD_LEFT);
        $v_minute = str_pad($datevalue['minutes'], 2, '0', STR_PAD_LEFT);
        $v_second = str_pad($datevalue['seconds'], 2, '0', STR_PAD_LEFT);
      }
    }

    print "<tr>\n";
    print "<td class=\"formColumnCaption\">Fecha Creacion</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr>\n";
    print "<td valign=\"top\" style=\"padding-left:2px\">\n";
    print "<select class=\"combobox\" name=\"fecha_creacion_day\" id=\"fecha_creacion_day\" style=\"width: 50px\">";
    print "<option value=\"\"></option>";
    if ($v_day == "01") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"01\" $selected >01</option>";
    if ($v_day == "02") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"02\" $selected >02</option>";
    if ($v_day == "03") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"03\" $selected >03</option>";
    if ($v_day == "04") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"04\" $selected >04</option>";
    if ($v_day == "05") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"05\" $selected >05</option>";
    if ($v_day == "06") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"06\" $selected >06</option>";
    if ($v_day == "07") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"07\" $selected >07</option>";
    if ($v_day == "08") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"08\" $selected >08</option>";
    if ($v_day == "09") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"09\" $selected >09</option>";
    if ($v_day == "10") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"10\" $selected >10</option>";
    if ($v_day == "11") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"11\" $selected >11</option>";
    if ($v_day == "12") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"12\" $selected >12</option>";
    if ($v_day == "13") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"13\" $selected >13</option>";
    if ($v_day == "14") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"14\" $selected >14</option>";
    if ($v_day == "15") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"15\" $selected >15</option>";
    if ($v_day == "16") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"16\" $selected >16</option>";
    if ($v_day == "17") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"17\" $selected >17</option>";
    if ($v_day == "18") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"18\" $selected >18</option>";
    if ($v_day == "19") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"19\" $selected >19</option>";
    if ($v_day == "20") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"20\" $selected >20</option>";
    if ($v_day == "21") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"21\" $selected >21</option>";
    if ($v_day == "22") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"22\" $selected >22</option>";
    if ($v_day == "23") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"23\" $selected >23</option>";
    if ($v_day == "24") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"24\" $selected >24</option>";
    if ($v_day == "25") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"25\" $selected >25</option>";
    if ($v_day == "26") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"26\" $selected >26</option>";
    if ($v_day == "27") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"27\" $selected >27</option>";
    if ($v_day == "28") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"28\" $selected >28</option>";
    if ($v_day == "29") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"29\" $selected >29</option>";
    if ($v_day == "30") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"30\" $selected >30</option>";
    if ($v_day == "31") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"31\" $selected >31</option>";
    print "</select>&nbsp;";
    print "</td><td valign=\"top\" style=\"padding-left:2px\">\n";
    print "<select class=\"combobox\" name=\"fecha_creacion_month\" id=\"fecha_creacion_month\" style=\"width: 50px\">";
    print "<option value=\"\"></option>";
    if ($v_month == "01") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"01\" $selected >Jan</option>";
    if ($v_month == "02") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"02\" $selected >Feb</option>";
    if ($v_month == "03") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"03\" $selected >Mar</option>";
    if ($v_month == "04") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"04\" $selected >Apr</option>";
    if ($v_month == "05") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"05\" $selected >May</option>";
    if ($v_month == "06") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"06\" $selected >Jun</option>";
    if ($v_month == "07") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"07\" $selected >Jul</option>";
    if ($v_month == "08") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"08\" $selected >Aug</option>";
    if ($v_month == "09") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"09\" $selected >Sep</option>";
    if ($v_month == "10") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"10\" $selected >Oct</option>";
    if ($v_month == "11") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"11\" $selected >Nov</option>";
    if ($v_month == "12") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"12\" $selected >Dec</option>";
    print "</select>&nbsp;";
    print "</td><td valign=\"top\" style=\"padding-left:2px\">\n";
    print "<input class=\"textbox\" name=\"fecha_creacion_year\" type=\"text\" value=\"$v_year\" id=\"fecha_creacion_year\" size=\"4\"/>";
    print "</td>\n";
    print "<td valign=\"top\" style=\"padding-left:2px\">\n";
    print "<input type=\"image\" name=\"fecha_creacion_btn\" id=\"fecha_creacion_btn\" src=\"components/calendar/basicgreen/images/img_calendar.gif\" onclick =\"displayCalendarSelectBox('fecha_creacion_year','fecha_creacion_month','fecha_creacion_day',false,false,this); return false;\"style=\"border-width:0px;cursor: hand\" />";
    print "</td></tr></table>\n";
    print "</td>\n";
    print "</tr>\n";
    $value = $artv_kilos;
    if (($value == "") || ($value == null)) {
        $value = "";
        $artv_kilos = $value;
    }
    $value = htmlspecialchars($value);

    print "<tr>\n";
    print "<td class=\"formColumnCaption\">Kilos</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<input class=\"textbox\" id=\"kilos\" name=\"kilos\" type=\"text\" value=\"" . $value . "\"  size=\"12\" maxlength=\"12\" >\n";
    print "</td>\n";
    print "</tr>\n";
    $value = $artv_arrobas;
    if (($value == "") || ($value == null)) {
        $value = "";
        $artv_arrobas = $value;
    }
    $value = htmlspecialchars($value);

    print "<tr>\n";
    print "<td class=\"formColumnCaption\">Arrobas</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<input class=\"textbox\" id=\"arrobas\" name=\"arrobas\" type=\"text\" value=\"" . $value . "\"  size=\"12\" maxlength=\"12\" >\n";
    print "</td>\n";
    print "</tr>\n";
    $value = $artv_precio;
    if (($value == "") || ($value == null)) {
        $value = "";
        $artv_precio = $value;
    }
    $value = htmlspecialchars($value);

    print "<tr>\n";
    print "<td class=\"formColumnCaption\">Precio</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<input class=\"textbox\" id=\"precio\" name=\"precio\" type=\"text\" value=\"" . $value . "\"  size=\"12\" maxlength=\"12\" >\n";
    print "</td>\n";
    print "</tr>\n";
    $value = $artv_total;
    if (($value == "") || ($value == null)) {
        $value = "";
        $artv_total = $value;
    }
    $value = htmlspecialchars($value);

    print "<tr>\n";
    print "<td class=\"formColumnCaption\">Total</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<input class=\"textbox\" id=\"total\" name=\"total\" type=\"text\" value=\"" . $value . "\"  size=\"12\" maxlength=\"12\" >\n";
    print "</td>\n";
    print "</tr>\n";
    $value = $artv_bultos;
    if (($value == "") || ($value == null)) {
        $value = "";
        $artv_bultos = $value;
    }
    $value = htmlspecialchars($value);

    print "<tr>\n";
    print "<td class=\"formColumnCaption\">Bultos</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<input class=\"textbox\" id=\"bultos\" name=\"bultos\" type=\"text\" value=\"" . $value . "\"  size=\"10\" maxlength=\"10\" >\n";
    print "</td>\n";
    print "</tr>\n";
    $value = $artv_clientes_id;
    if (($value == "") || ($value == null)) {
        $value = "";
        $artv_clientes_id = $value;
    }
    $value = htmlspecialchars($value);

    print "<tr>\n";
    print "<td class=\"formColumnCaption\">Clientes Id</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<input class=\"textbox\" id=\"clientes_id\" name=\"clientes_id\" type=\"text\" value=\"" . $value . "\"  size=\"10\" maxlength=\"10\" >\n";
    print "</td>\n";
    print "</tr>\n";
    $value = $artv_calidad_id;
    if (($value == "") || ($value == null)) {
        $value = "";
        $artv_calidad_id = $value;
    }
    $value = htmlspecialchars($value);

    print "<tr>\n";
    print "<td class=\"formColumnCaption\">Calidad Id</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<input class=\"textbox\" id=\"calidad_id\" name=\"calidad_id\" type=\"text\" value=\"" . $value . "\"  size=\"10\" maxlength=\"10\" >\n";
    print "</td>\n";
    print "</tr>\n";
    $value = $artv_usuario_id;
    if (($value == "") || ($value == null)) {
        $value = "";
        $artv_usuario_id = $value;
    }
    $value = htmlspecialchars($value);

    print "<tr>\n";
    print "<td class=\"formColumnCaption\">Usuario Id</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<input class=\"textbox\" id=\"usuario_id\" name=\"usuario_id\" type=\"text\" value=\"" . $value . "\"  size=\"10\" maxlength=\"10\" >\n";
    print "</td>\n";
    print "</tr>\n";
    print "	                   <tr>\n";
    print "	                       <td class=\"formColumnCaption\"></td>\n";
    print "	                       <td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "	                       <td class=\"formColumnData\" align=\"left\"></br>\n";
    print "	                           <input name=\"btn_save\" id=\"btn_save\" type=\"submit\" value=\"" . CAP_BUTTON_SAVE . "\" class=\"button\" >\n";
    $urldatapage = "href='" . "./compra.php" . "'";
    print "	                  		     <input name=\"btn_cancel\" id=\"btn_cancel\" type=\"reset\" value=\"" . CAP_BUTTON_CANCEL . "\" class=\"button\" onClick=\"javascript:window.location." . $urldatapage . " \">\n";
    print "	                           <input type=\"hidden\" name=\"pm_calidad_id\" value=\"".$artv_pm_calidad_id."\">\n";	
    print "	                           <input type=\"hidden\" name=\"pm_clientes_id\" value=\"".$artv_pm_clientes_id."\">\n";	
    print "	                           <input type=\"hidden\" name=\"pm_id\" value=\"".$artv_pm_id."\">\n";	
    print "	                           <input type=\"hidden\" name=\"pm_usuario_id\" value=\"".$artv_pm_usuario_id."\">\n";	
    print "                            <input type=\"hidden\" name=\"artsys_postback\" value=\"1\" >\n";
    print "	                       </br></br>\n";
    print "	                       </td>\n";
    print "	                   </tr>\n";
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

function art_update_data(){
    $result = "";
    $msg = "";
    $artv_pm_calidad_id = art_request("pm_calidad_id", "");
    $artv_pm_clientes_id = art_request("pm_clientes_id", "");
    $artv_pm_id = art_request("pm_id", "");
    $artv_pm_usuario_id = art_request("pm_usuario_id", "");

    $artv_message = art_request("message", "");
    $artv_id = art_request("lbhd_id", "");
    $artv_fecha_creacion_year = art_request("fecha_creacion_year", "");
    $artv_fecha_creacion_month = art_request("fecha_creacion_month", "");
    $artv_fecha_creacion_day = art_request("fecha_creacion_day", "");
    if (($artv_fecha_creacion_year != "")
     && ($artv_fecha_creacion_month != "")
     && ($artv_fecha_creacion_day != "")) {
        $artv_fecha_creacion = $artv_fecha_creacion_year."-".$artv_fecha_creacion_month."-".$artv_fecha_creacion_day;
    } else {
        $artv_fecha_creacion = "";
    }
    $artv_kilos = art_request("kilos", "");
    $artv_arrobas = art_request("arrobas", "");
    $artv_precio = art_request("precio", "");
    $artv_total = art_request("total", "");
    $artv_bultos = art_request("bultos", "");
    $artv_clientes_id = art_request("clientes_id", "");
    $artv_calidad_id = art_request("calidad_id", "");
    $artv_usuario_id = art_request("usuario_id", "");
    $err_require = "";
    if ($err_require != "") {
        return $err_require;
    }

    $result = "";
    $err_require = "";
    if ($err_require != ""){
	      return $err_require;
    }
    $result = "";
    if ($result != ""){
        return $result;
    }
    $sql = "";
    if (($result == "") && (art_session('art_form_loaded', 0) != 1)){
        $sql = " UPDATE `compra` SET ";
        $sql .= " compra.fecha_creacion = " .  art_quote_dateval($artv_fecha_creacion); 
        $sql .= ",compra.kilos = " .  art_quote_intval($artv_kilos); 
        $sql .= ",compra.arrobas = " .  art_quote_intval($artv_arrobas); 
        $sql .= ",compra.precio = " .  art_quote_intval($artv_precio); 
        $sql .= ",compra.total = " .  art_quote_intval($artv_total); 
        $sql .= ",compra.bultos = " .  art_quote_intval($artv_bultos); 
        $sql .= ",compra.clientes_id = " .  art_quote_intval($artv_clientes_id); 
        $sql .= ",compra.calidad_id = " .  art_quote_intval($artv_calidad_id); 
        $sql .= ",compra.usuario_id = " .  art_quote_intval($artv_usuario_id); 
        $sql .= " WHERE ";
        $sql .= " compra.calidad_id = " .  art_quote_intval($artv_pm_calidad_id);
        $sql .= " AND  compra.clientes_id = " .  art_quote_intval($artv_pm_clientes_id);
        $sql .= " AND  compra.id = " .  art_quote_intval($artv_pm_id);
        $sql .= " AND  compra.usuario_id = " .  art_quote_intval($artv_pm_usuario_id);
    }

    if ($result == ""){
		    $query = mysql_query($sql);
		    if (!$query){
			      $result .= MSG_UPDATE_RECORD_FAIL;
				    $result .= "</br>Error: " . mysql_error();
		    } else {

	          $result = "SUCCESS";
	          art_setdefault_session('art_form_loaded', 1);
		    }
    }
    return $result;
}
?>
