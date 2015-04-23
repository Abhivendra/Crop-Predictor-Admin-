<?php require_once('Connections/Admin_Panel.php'); ?>
<?php require_once('Connections/Admin_Panel.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if ((isset($_POST['ID'])) && ($_POST['ID'] != "") && (isset($_POST['userID']))) {
  $deleteSQL = sprintf("DELETE FROM admin_login WHERE ID=%s",
                       GetSQLValueString($_POST['ID'], "int"));

  mysql_select_db($database_Admin_Panel, $Admin_Panel);
  $Result1 = mysql_query($deleteSQL, $Admin_Panel) or die(mysql_error());

  $deleteGoTo = "manage_admins.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

mysql_select_db($database_Admin_Panel, $Admin_Panel);
$query_ManageAdmins = "SELECT * FROM admin_login WHERE admin_level = 0 ORDER BY regdate ASC";
$ManageAdmins = mysql_query($query_ManageAdmins, $Admin_Panel) or die(mysql_error());
$row_ManageAdmins = mysql_fetch_assoc($ManageAdmins);
$totalRows_ManageAdmins = mysql_num_rows($ManageAdmins);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Add Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<style type="text/css">
.Manage mm_hiddenregion table {
	background-color: #FFFFFF;
	border-top-color: #999999;
	border-right-color: #999999;
	border-bottom-color: #999999;
	border-left-color: #999999;
	background-image: url(images/1.jpg);
}
</style>
</head>
<body>
<div id="sitename">
  <div class="width" id="wrapper">
    <h1><strong><a href="#"> Admin Panel</a></strong></h1>
    <nav>
      <ul>
        <li><a href="add_info.php">Add Information</a></li>
        <li> <a href="add_admin.php">Add Admin</a> </li>
        <li class="start selected"><a href="#">Manage</a></li>
        <li class="end" ><a href="admin_logout.php">Logout</a></li>
      </ul>
    </nav>
    <div class="clear"></div>
  </div>
</div>
<div class="Manage">
  <p>Admin Manager</p>
  <?php do { ?>
    <?php if ($totalRows_ManageAdmins > 0) { // Show if recordset not empty ?>
  <table width="500" border="0">
    <tr>
      <th scope="col"><form action="" method="post" name="ManageAdmins " id="ManageAdmins ">
        <table width="300" border="0">
          <tr>
            <th scope="col">Admin Name :<?php echo $row_ManageAdmins['user_name']; ?></th>
          </tr>
          <tr>
            <th scope="row"><input type="submit" name="Delete" id="Delete" value="Delete Admin">
              <input name="userId" type="hidden" id="userId" value="<?php echo $row_ManageAdmins['ID']; ?>"></th>
          </tr>
          <tr>
            <th scope="row">&nbsp;</th>
          </tr>
        </table>
      </form></th>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?>
    <?php } while ($row_ManageAdmins = mysql_fetch_assoc($ManageAdmins)); ?>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
<!----------start copyright----------->
<p class="copy_right">&#169; 2014 Made By Team MAD</p>
</body>
</html>
<?php
mysql_free_result($ManageAdmins);

mysql_free_result($ManageAdmins);
?>
