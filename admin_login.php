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

mysql_select_db($database_Admin_Panel, $Admin_Panel);
$query_admin_login = "SELECT user_name, Password FROM admin_login";
$admin_login = mysql_query($query_admin_login, $Admin_Panel) or die(mysql_error());
$row_admin_login = mysql_fetch_assoc($admin_login);
$totalRows_admin_login = mysql_num_rows($admin_login);
$query_admin_login = "SELECT user_name, Password FROM admin_login";
$admin_login = mysql_query($query_admin_login, $Admin_Panel) or die(mysql_error());
$row_admin_login = mysql_fetch_assoc($admin_login);
$totalRows_admin_login = mysql_num_rows($admin_login);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['user_name'])) {
  $loginUsername=$_POST['user_name'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "admin_level";
  $MM_redirectLoginSuccess = "add_info.php";
  $MM_redirectLoginFailed = "admin_login.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_Admin_Panel, $Admin_Panel);
  	
  $LoginRS__query=sprintf("SELECT user_name, Password, admin_level FROM admin_login WHERE user_name=%s AND Password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $Admin_Panel) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'admin_level');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Administrator Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<div id="sitename">
			<div class="width" id="wrapper">
			    <h1><strong><a href="#"> Admin Panel</a></strong></h1>
                <!---<nav>
					<ul>
                    		<li><a href="#">Add Information</a></li>
                      		<li class="start selected"><a href="#">Update Information</a></li>
        					<li>
        					  <a href="add_admin.php">Add Admin</a>
        					</li>
        	    				
         	   				<li class="end" ><a href="admin_logout.php">Logout</a></li>
          	  	
   				  </ul>
				</nav>--->
			    <div class="clear"></div>
			</div>
</div>
<!----------start admin-login----------->
		<div class="admin-login">
			<!----------star form----------->
				<form ACTION="<?php echo $loginFormAction; ?>" name="login" class="login"  method="POST" >
	
					<div class="formtitle">Admin Login</div>
					<div class="input">
						<input type="text" name="user_name" placeholder="User Name"  required/> 
						<span><img src="images/select.png"/> </span>
					</div>
					<div class="input">
						<input type="password"  name="password" placeholder="Password" required/>
						<span><img src="images/close.png"/></span>
					</div>
					<div class="buttons">
						<a href="#">Forgot password?</a>
						<input class="bluebutton" type="submit" value="Login" />
						<div class="clear"> </div>
					</div>
		
				</form>
				<!----------end form----------->					
		</div>
<!----------start copyright----------->
			<p class="copy_right">&#169; 2014 Made By Team MAD</p>
</body>
</html>
<?php
mysql_free_result($admin_login);
?>
