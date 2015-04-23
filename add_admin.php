<?php require_once('Connections/Admin_Panel.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "2";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "admin_login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "Signup")) {
  $insertSQL = sprintf("INSERT INTO admin_login (user_name, Password, First_Name, Last_Name, email, admin_level) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['user_name'], "text"),
                       GetSQLValueString($_POST['Password'], "text"),
                       GetSQLValueString($_POST['F_Name'], "text"),
                       GetSQLValueString($_POST['L_Name'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['level'], "int"));

  mysql_select_db($database_Admin_Panel, $Admin_Panel);
  $Result1 = mysql_query($insertSQL, $Admin_Panel) or die(mysql_error());

  $insertGoTo = "add_admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Add Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<div id="sitename">
			<div class="width" id="wrapper">
			    <h1><strong><a href="#"> Admin Panel</a></strong></h1>
                <nav>
					<ul>
                    		<li><a href="add_info.php">Add Information</a></li>
        					<li class="start selected">
        					  <a href="add_admin.php">Add Admin</a>
        					</li>
        	    			<li><a href="manage_admins.php">Manage</a></li>
         	   				<li class="end" ><a href="admin_logout.php">Logout</a></li>
          	  	
   				  </ul>
				</nav>
			    <div class="clear"></div>
			</div>
</div>
<div class="sign_up">
			<!----------start form----------->
<form action="<?php echo $editFormAction; ?>" method="POST" name="Signup" class="sign">
				<div class="formtitle">Add Administrators</div>
				<!----------start top_section----------->
				<div class="top_section">
					<div class="section">
						<div class="input username">
							<input type="text"  name="user_name" placeholder="User Name"  required/> <span><img src="images/select.png"/> </span>
							
						</div>
						<div class="input password">
							<input type="password" name="Password"  placeholder="Password" required/><span><img src="images/close.png"/></span>
						</div>
						<div class="clear"> </div>
					</div>
					<div class="section">
						<div class="input-sign email">
							<input type="email" name="email"  placeholder="Email"  required /> 
						</div>
						<div class="input-sign re-email">
							<input type="email" placeholder="Re-confirm email" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Re-confirm email';}"required />
						</div>
						<div class="clear"> </div>
					</div>
				</div>
				<!----------end top_section----------->
				<!----------start bottom-section----------->
				<div class="bottom-section">
					<div class="title">Administrator Details</div>
					<!----------start name section----------->
					<div class="section">
						<div class="input-sign details">
							<input type="text" name="F_Name" placeholder="First Name" required/>
						</div>
						<div class="input-sign details1">
							<input type="text" name="L_Name" placeholder="Last Name" required/>
						</div>
						<div class="clear"> </div>
					</div>
					
					<!----------start admin level section----------->
					<div class="section-country">
				<select id="country" name="level" onchange="change_country(this.value)" class="frm-field required">
		            <option value="0">Data Entry</option>
		            <option value="1">Data Manager</option>
		         </select>
					</div>
					<div class="submit">
						<input class="bluebutton submitbotton" type="submit" value="Sign up" />
					</div>
				</div>
				<!----------end bottom-section----------->
				<input type="hidden" name="MM_insert" value="Signup">
			</form>
			<!----------end form----------->
</div>
<!----------start copyright----------->
<p class="copy_right">&#169; 2014 Made By Team MAD</p>
</body>
</html>