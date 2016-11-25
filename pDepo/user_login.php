<?php
if (session_id() == ""){
    session_start();
}
require_once './includes/art_config.php';
require_once './includes/art_db.php';
require_once './includes/art_functions.php';
require_once './languages/art_lang.php';
require_once './user_login_func.php';

$artv_login = art_request("btn_login", "");
$artv_username  = art_request("username", "");
$artv_password = art_request("password", "");
$message = "";
$artv_userlevel = "";

if ($artv_login  != ""){
    if (($artv_username == "") || ($artv_password == "")){
        $message = MSG_INVALID_USERPW;
    }

    if ($message == ""){
        $userlevel = art_check_userpw($artv_username, $artv_password);
        if ($userlevel == -1000){
            $message = MSG_LOGIN_FAIL;
        } else {
            $redirect_url = 'calidad.php';
            header("location: " . $redirect_url);
		    }
		}
} else {
    if (art_check_session('art_page_level')){
        $message = MSG_NO_PERMISSION;
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>User Login</title>
<meta name="generator" content="ScriptArtist v3">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="./css/globalcss.css" rel="stylesheet" type="text/css">
<link href="./css/defaulttheme.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="defaulttheme">



<br />
<form name="art_form" id="art_form" method="post" action="user_login.php"  style="margin: 0px; padding: 0px;">
    <table cellpadding="0" cellspacing="0" border="0"  width="500" align="center" >
        <tr>
            <td class="formHeaderBGLeft" nowrap >&nbsp;</td>
            <td class="formHeaderBG"><span class="formHeaderText">INICIAR SESION</span>&nbsp;</td>
            <td class="formHeaderBGRight" nowrap >&nbsp;</td>
        </tr>
        <tr>
            <td class="formColumnBGLeft" align="left">&nbsp;</td>
            <td>
                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="formBody" >
<?php

    if ($message != "" ){
        print "<tr>\n";
        print "<td class=\"formColumnCaption\">ERROR</td>\n";
        print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
        print "<td class=\"formColumnData\" align=\"left\">\n";
        print "<label class=\"errMsg\" >" . $message . "</label>\n";
        print "</td>\n";
        print "</tr>\n";
    }
    $value = $artv_username;
    if (($value == "") || ($value == null)) {
        $value = "";
        $artv_username = $value;
    }
    $value = htmlspecialchars($value);

    print "<tr>\n";
    print "<td class=\"formColumnCaption\"><b>NOMBRE<b></td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<input class=\"textbox\" id=\"username\" name=\"username\" type=\"text\" value=\"" . $value . "\"  size=\"50\" maxlength=\"50\" >\n";
    print "</td>\n";
    print "</tr>\n";
    $value = $artv_password;
    if (($value == "") || ($value == null)) {
        $value = "";
        $artv_password = $value;
    }
    $value = htmlspecialchars($value);

    print "<tr>\n";
    print "<td class=\"formColumnCaption\"><b>No DOCUMENTO<b></td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<input class=\"textbox\" id=\"password\" name=\"password\" type=\"password\" value=\"" . $value . "\"  size=\"50\" maxlength=\"50\" >\n";
    print "</td>\n";
    print "</tr>\n";
?>
	                  <tr>
	                      <td class="formColumnCaption"></td>
	                      <td width="3" class="formColumnData">&nbsp;</td>
	                      <td class="formColumnData" align="left"><br/>
	                          <input name="btn_login" id="btn_login" type="submit" value="Iniciar Sesion" class="button" />
	                          <input name="btn_cancel"  id="btn_cancel" type="reset" value="Cancelar" class="button" />
                              <br/><br/>
	                      </td>
	                  </tr>
                </table>
            </td>
            <td class="formColumnBGRight">&nbsp;</td>
        </tr>
        <tr>
            <td class="formFooterLeft" nowrap >&nbsp;</td>
            <td class="formFooter" align="center" valign="middle">&nbsp;</td>
            <td class="formFooterRight" nowrap >&nbsp;</td>
        </tr>
    </table>
</form>
    <form action="registro.php" class="text-center col-md-8">
        <h1 class="center">Presione el boton para registrar un usuario en el sofware</h1>
        <input type="submit" value="REGISTRARSE" >
    </form>

</div>
</body>
</html>
<?php art_db_connection_close(); ?>
