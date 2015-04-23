<?php require_once('Connections/Admin_Panel.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "0,1,2";
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "Farmer_Basic_Info")) {
  $insertSQL = sprintf("INSERT INTO farmer_basic_info (F_ID, F_Name, Family_Size, Total_Land) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['F_ID'], "text"),
                       GetSQLValueString($_POST['F_Name'], "text"),
                       GetSQLValueString($_POST['Family_Size'], "int"),
                       GetSQLValueString($_POST['Total_Land'], "double"));

  mysql_select_db($database_Admin_Panel, $Admin_Panel);
  $Result1 = mysql_query($insertSQL, $Admin_Panel) or die(mysql_error());

  $insertGoTo = "add_info.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "Farmer_Address_Info")) {
  $insertSQL = sprintf("INSERT INTO address_of_farmer (F_ID, Village, Block, District, `State`, PIN) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['F_ID'], "text"),
                       GetSQLValueString($_POST['Village'], "text"),
                       GetSQLValueString($_POST['Block'], "text"),
                       GetSQLValueString($_POST['District'], "text"),
                       GetSQLValueString($_POST['Block'], "text"),
                       GetSQLValueString($_POST['PIN'], "int"));

  mysql_select_db($database_Admin_Panel, $Admin_Panel);
  $Result1 = mysql_query($insertSQL, $Admin_Panel) or die(mysql_error());

  $insertGoTo = "add_info.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "Crop_Details")) {
  $insertSQL = sprintf("INSERT INTO crop_detail (C_ID, Crop_Name) VALUES (%s, %s)",
                       GetSQLValueString($_POST['C_ID'], "int"),
                       GetSQLValueString($_POST['Crop_Name'], "text"));

  mysql_select_db($database_Admin_Panel, $Admin_Panel);
  $Result1 = mysql_query($insertSQL, $Admin_Panel) or die(mysql_error());

  $insertGoTo = "add_info.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "Present_Production")) {
  $insertSQL = sprintf("INSERT INTO estimated_production_details (F_ID, C_ID, AMNT_OF_LAND_PRDCTION, ESTIMATED_PRODUCTION) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['F_ID'], "text"),
                       GetSQLValueString($_POST['C_ID'], "int"),
                       GetSQLValueString($_POST['land_size'], "double"),
                       GetSQLValueString($_POST['Total_Production'], "double"));

  mysql_select_db($database_Admin_Panel, $Admin_Panel);
  $Result1 = mysql_query($insertSQL, $Admin_Panel) or die(mysql_error());

  $insertGoTo = "add_info.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "Previous_Production")) {
  $insertSQL = sprintf("INSERT INTO previous_producion_deatil (F_ID, C_ID, AMNT_OF_LAND_PRDCTION, PEVIOUS_PRODUCTION) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['F_ID'], "text"),
                       GetSQLValueString($_POST['C_ID'], "int"),
                       GetSQLValueString($_POST['land_size'], "double"),
                       GetSQLValueString($_POST['Total_Production'], "int"));

  mysql_select_db($database_Admin_Panel, $Admin_Panel);
  $Result1 = mysql_query($insertSQL, $Admin_Panel) or die(mysql_error());

  $insertGoTo = "add_info.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_Admin_Panel, $Admin_Panel);
$query_farmer_basic_info = "SELECT * FROM farmer_basic_info";
$farmer_basic_info = mysql_query($query_farmer_basic_info, $Admin_Panel) or die(mysql_error());
$row_farmer_basic_info = mysql_fetch_assoc($farmer_basic_info);
$totalRows_farmer_basic_info = mysql_num_rows($farmer_basic_info);

mysql_select_db($database_Admin_Panel, $Admin_Panel);
$query_Farmer_address = "SELECT * FROM address_of_farmer";
$Farmer_address = mysql_query($query_Farmer_address, $Admin_Panel) or die(mysql_error());
$row_Farmer_address = mysql_fetch_assoc($Farmer_address);
$totalRows_Farmer_address = mysql_num_rows($Farmer_address);

mysql_select_db($database_Admin_Panel, $Admin_Panel);
$query_crop_info = "SELECT * FROM crop_detail";
$crop_info = mysql_query($query_crop_info, $Admin_Panel) or die(mysql_error());
$row_crop_info = mysql_fetch_assoc($crop_info);
$totalRows_crop_info = mysql_num_rows($crop_info);

mysql_select_db($database_Admin_Panel, $Admin_Panel);
$query_present_production = "SELECT F_ID, C_ID, AMNT_OF_LAND_PRDCTION, ESTIMATED_PRODUCTION FROM estimated_production_details";
$present_production = mysql_query($query_present_production, $Admin_Panel) or die(mysql_error());
$row_present_production = mysql_fetch_assoc($present_production);
$totalRows_present_production = mysql_num_rows($present_production);

mysql_select_db($database_Admin_Panel, $Admin_Panel);
$query_previous_info = "SELECT F_ID, C_ID, AMNT_OF_LAND_PRDCTION, PEVIOUS_PRODUCTION FROM previous_producion_deatil";
$previous_info = mysql_query($query_previous_info, $Admin_Panel) or die(mysql_error());
$row_previous_info = mysql_fetch_assoc($previous_info);
$totalRows_previous_info = mysql_num_rows($previous_info);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Admin Panel || Home</title>
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
                    		<li class="start selected"><a href="add_info.php">Add Information</a></li>              
        					<li>
        					 <a href="add_admin.php">Add Admin</a>
        					</li>
        	    				
         	   				<li class="end" > <a href="admin_logout.php">Logout</a></li>
          	  	
   				  </ul>
				</nav>
			    <div class="clear"></div>
			</div>
</div>


<!--------------------- Farmer Basic Information---------------------------------------------------------------------------------
---------------------------------------------------------------->
<!----------start sign_up----------->
		<div class="sign_up">
			<!----------start form----------->
			<form action="<?php echo $editFormAction; ?>" method="POST" name="Farmer_Basic_Info" class="sign">
				<div class="formtitle">Farmer's Basic Information</div>
				<!----------start personal Details----------->
				<!----------start bottom-section----------->
				<div class="bottom-section">
					<div class="title">Enter The Following Details</div>
					<!----------start name section----------->
					<div class="section">
						<div class="input-sign details">
							<input type="text"  name = "F_ID" placeholder="Farmer ID" required/>
						</div>
						<div class="input-sign details1">
							<input type="text"  name="F_Name" placeholder="Farmer's Name" required/>
						</div>
						<div class="clear"> </div>
					</div>
					
					<!----------start Family and Land Size section----------->
					<div class="section">
						<div class="input-sign details">
							<input type="text" name="Family_Size" placeholder="Farmer's Family Size" required/> 
						</div>
						<div class="input-sign details1">
							<input type="text" name="Total_Land"  placeholder="Farmer's Total Land" required/> 
						</div>
						<div class="clear"> </div>
					</div>
					<div class="submit">
						<input class="bluebutton submitbotton" type="submit" value="Submit" />
					</div>
				</div>
				<!----------end bottom-section----------->
				<input type="hidden" name="MM_insert" value="Farmer_Basic_Info">
          </form>
			<!----------end form----------->
		</div>
		
		
		
		
		
		
<!--------------------- Farmer Address Information---------------------------------------------------------------------------------
---------------------------------------------------------------->
<div class="sign_up">
			<!----------start form----------->
			<form action="<?php echo $editFormAction; ?>" method="POST" name="Farmer_Address_Info" class="sign">
				<div class="formtitle">Farmer's Address Information</div>
				<!----------start personal Details----------->
				<!----------start bottom-section----------->
				<div class="bottom-section">
					<div class="title">Enter The Following Details</div>
					<!----------start ID and Village section----------->
					<div class="section">
						<div class="input-sign details">
							<input type="text"  name = "F_ID" placeholder="Farmer ID" required/>
						</div>
						<div class="input-sign details1">
							<input type="text"  name="Village" placeholder="Village"/>
						</div>
						<div class="clear"> </div>
					</div>
					
					<!----------start Block and District section----------->
					<div class="section">
						<div class="input-sign details">
							<input type="text" name="Block" placeholder="Block" required/> 
						</div>
						<div class="input-sign details1">
							<input type="text" name="District"  placeholder="District" required/> 
						</div>
						<div class="clear"> </div>
					</div>
				<!----------start State and PIN section----------->
					<div class="section">
						<div class="input-sign details">
							<input type="text" name="State" placeholder="State ( Full )" required/> 
						</div>
						<div class="input-sign details1">
							<input type="text" name="PIN"  placeholder="PIN No." required/> 
						</div>
						<div class="clear"> </div>
					</div>
					<div class="submit">
						<input class="bluebutton submitbotton" type="submit" value="Submit" />
					</div>
				</div>
				<!----------end bottom-section----------->
				<input type="hidden" name="MM_insert" value="Farmer_Address_Info">
          </form>
			<!----------end form----------->
		</div>
		
		
		
<!----------Crop_Details-----------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------>
<div class="sign_up">
			<!----------start form----------->
			<form action="<?php echo $editFormAction; ?>" method="POST" name="Crop_Details" class="sign">
				<div class="formtitle">Crop Details</div>
				<!----------start personal Details----------->
				<!----------start bottom-section----------->
				<div class="bottom-section">
					<div class="title">Enter The Following Details</div>
					<!----------start ID and Crop Name section----------->
					<div class="section">
						<div class="input-sign details">
							<input type="text"  name = "C_ID" placeholder="Crop ID" required/>
						</div>
						<div class="input-sign details1">
							<input type="text"  name="Crop_Name" placeholder="Crop Name"/>
						</div>
						<div class="clear"> </div>
					</div>
					<div class="submit">
						<input class="bluebutton submitbotton" type="submit" value="Submit" />
					</div>
				</div>
				<!----------end bottom-section----------->
				<input type="hidden" name="MM_insert" value="Crop_Details">
          </form>
			<!----------end form----------->
		</div>
		
		
<!----------Present Year Production-----------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------>
<div class="sign_up">
			<!----------start form----------->
			<form action="<?php echo $editFormAction; ?>" method="POST" name="Present_Production" class="sign">
				<div class="formtitle">Present Year Production</div>
				<!----------start personal Details----------->
				<!----------start bottom-section----------->
				<div class="bottom-section">
					<div class="title">Enter The Details</div>
					<!----------start Farmer ID and Crop ID section----------->
					<div class="section">
						<div class="input-sign details">
							<input type="text"  name = "F_ID" placeholder="Farmer's ID" required/>
						</div>
						<div class="input-sign details1">
							<input type="text"  name="C_ID" placeholder="Crop ID"/>
						</div>
						<div class="clear"> </div>
					</div>
					<div class="section">
						<div class="input-sign details">
							<input type="text"  name = "land_size" placeholder="Land Size" required/>
						</div>
						<div class="input-sign details1">
							<input type="text"  name="Total_Production" placeholder="Total Production"/>
						</div>
						<div class="clear"> </div>
					</div>
					<div class="submit">
						<input class="bluebutton submitbotton" type="submit" value="Submit" />
					</div>
				</div>
				<!----------end bottom-section----------->
				<input type="hidden" name="MM_insert" value="Present_Production">
          </form>
			<!----------end form----------->
		</div>
		
		
		
		
<!----------Previous Year Production-----------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------>
<div class="sign_up">
			<!----------start form----------->
			<form action="<?php echo $editFormAction; ?>" method="POST" name="Previous_Production" class="sign">
				<div class="formtitle">Previous Year Production</div>
				<!----------start personal Details----------->
				<!----------start bottom-section----------->
				<div class="bottom-section">
					<div class="title">Enter The Details</div>
					<!----------start Farmer ID and Crop ID section----------->
					<div class="section">
						<div class="input-sign details">
							<input type="text"  name = "F_ID" placeholder="Farmer's ID" required/>
						</div>
						<div class="input-sign details1">
							<input type="text"  name="C_ID" placeholder="Crop ID"/>
						</div>
						<div class="clear"> </div>
					</div>
					<div class="section">
						<div class="input-sign details">
							<input type="text"  name = "land_size" placeholder="Land Size" required/>
						</div>
						<div class="input-sign details1">
							<input type="text"  name="Total_Production" placeholder="Total Production"/>
						</div>
						<div class="clear"> </div>
					</div>
					<div class="submit">
						<input class="bluebutton submitbotton" type="submit" value="Submit" />
					</div>
				</div>
				<!----------end bottom-section----------->
				<input type="hidden" name="MM_insert" value="Previous_Production">
          </form>
			<!----------end form----------->
		</div>
		
		
		
		
</body>
</html>
<?php
mysql_free_result($farmer_basic_info);

mysql_free_result($Farmer_address);

mysql_free_result($crop_info);

mysql_free_result($present_production);

mysql_free_result($previous_info);
?>
