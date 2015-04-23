<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_Admin_Panel = "localhost";
$database_Admin_Panel = "crop management system";
$username_Admin_Panel = "root";
$password_Admin_Panel = "";
$Admin_Panel = mysql_pconnect($hostname_Admin_Panel, $username_Admin_Panel, $password_Admin_Panel) or trigger_error(mysql_error(),E_USER_ERROR); 
?>