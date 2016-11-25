<?php
function art_check_userpw($username, $password) {
$username = art_escape_sqlval($username);
$password = art_escape_sqlval($password);
	  $sql = " select `tipo_usuario`, `cedula`  from `usuario` ";
	  $sql .= " where `nombre` = '" . strtolower(trim($username)) . "'";
	  $query = mysql_query($sql);	
	  if(!$query || (mysql_num_rows($query) < 1)) {
        return -1000;
    }
    $row = mysql_fetch_array($query);
    $dbpassword = stripslashes(art_rowdata($row, 1));
    $dbuserlevel = stripslashes(art_rowdata($row, 0));
    $password = stripslashes($password);
    if ($password == $dbpassword) {
        art_set_userinfo($username, $dbuserlevel);
        return $dbuserlevel;
    } else {
        return -1000;
    }
  }

function art_set_userinfo($username, $userlevel) {
	  art_set_session('art_user_name', $username);
	  art_set_session('art_user_level', $userlevel);
}

function art_check_permission($pagelevel, $pageurl) {
    if ($pagelevel <= art_session('art_user_level', -1)) {
        return true;
    } else {
        art_set_session('art_page_level', $pagelevel);
	      header("location: user_login.php");
        return false;
    }
}
?>
