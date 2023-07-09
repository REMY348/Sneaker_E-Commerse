<?php
	include "config.php";
	if(isset($_POST["Update_Button"]))
	{
		if(isset($_SESSION['adminID'])){
			$username = $_POST["Username"];
			$password = $_POST["Password"]; 
			$Email = $_POST["Email"];
			
			$sql = "UPDATE admin 
					SET Admin_Username = :username, password = :password, email = :email				
					WHERE Admin_ID = :adminID";
					
			$stmt = oci_parse($dbconn, $sql);
			oci_bind_by_name($stmt, ':username', $username);
			oci_bind_by_name($stmt, ':password', $password);
			oci_bind_by_name($stmt, ':email', $Email);
			oci_bind_by_name($stmt, ':adminID', $_SESSION['adminID']);
			oci_execute($stmt);

			// $result = oci_execute($stmt);
			
			if($stmt)
			{	
				echo "<script>alert('Update complete')</script>";
			}
			else 
				echo "<script>alert('Update failed')</script>";
		}
		else 
			echo"<script>alert('You must Login First')</script>";

			oci_error();
	}
?>


<!DOCTYPE html>
<html>
	<head>
		<title>	White Canvas | My Account</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=Ddevice-width, initial-scale=1.0">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
		<link rel="stylesheet" href="css/AccountPage.css" type="text/css" />  
		<link  rel="stylesheet" type="text/css" href="css/adminstyle.css?v=<?php echo time(); ?>">
		<script src="https://code.jquery.com/jquery-3.5.1.min.js"> </script>
		
	</head>
	
	<body>
		<div id="mySidebar" class="sidebar">
	
			<div class="nav-column">
			  <div class="logo-image" style="display:flex;">
				  	<img src="img/logoIcon4.png" class="logo-image"/>
					<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
			  </div>
			  <a href="adminHome.php"><img class="img-icon" src="img/list.png" style="height:40px; width:40px;"><p>Dashboard</p></a>
			  <a href="adminSales.php"><img class="img-icon" src="img/sales.png"><p>Sales</p></a>
			  <a href="adminCust.php"><img class="img-icon" src="img/customer.png"><p>Customers</p></a>
			  <a href="adminOrders.php"><img class="img-icon" src="img/order2.png"><p>Orders</p></a>
			  <a href="adminInventory.php"><img class="img-icon" src="img/inventory.png"><p>Inventory</p></a>
			  <a href="adminAccount.php"><img class="img-icon" src="img/account.png"><p>My Account</p></a>
			  <a href="Logout.php"><img class="img-icon" src="img/logout.png"><p>Log out</p></a>
			</div>
		</div>
		
		<div id="main">
			<!------------------------Header--------------------------->
			<div class="admin-header">
			  <button class="openbtn" onclick="openNav()">☰</button> 
				<script>
					function openNav() {
					  //The getElementById() method returns the element that has the ID attribute 
					  document.getElementById("mySidebar").style.width = "260px";
					  document.getElementById("main").style.marginLeft = "260px";
					}

					function closeNav() {
					  document.getElementById("mySidebar").style.width = "0";
					  document.getElementById("main").style.marginLeft= "0";
					}
				</script>
				<div class="admin-name">
					<img src="img/adminIcon2.png" style="height:80px; width:85px;">
					<h3><?php echo $_SESSION['adminUsername'] ?></h3>
				</div>				
			</div>
			 
			 <br><br>  
			 <hr style="background:black">
			<!-------------------------------------COntent-------------------------------------------->
				<div class="accountContainer">
	
					<div style="width:30%; background-color:#DBE2EF; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"> 
						<img src="Images/Image for users/AccountDetail.png" style="width:100%; "/>
					</div>
					
					<!---------------------  user info -------------------->
					<div class = "RegisterDiv"> 
						<br>
						<h2 >My Details</h2>
						<hr style="width:100%">
						
						<?php
						
						if(isset($_SESSION['adminID'])){
							// display user info 
							$sql = "SELECT 
										*
									FROM
										admin									
									WHERE Admin_ID = :adminID";
											
							$stmt = oci_parse($dbconn, $sql);
							oci_bind_by_name($stmt, ':adminID', $_SESSION['adminID']);
							oci_execute($stmt);
							
							$row = oci_fetch_assoc($stmt);
							
							if($row)
							{
								$Uname = $row['ADMIN_USERNAME'];
								$Upassword = $row['PASSWORD'];
								$Uemail = $row['EMAIL'];
								
								echo "<ol class='listStyle'>
										<li><b>Username     :</b> $Uname </li>
										<li><b>Password     :</b> $Upassword </li> 
										<li><b>Email        :</b> $Uemail </li> 
									</ol>";
							}
						}
						else 
						{	
							$Uname = 'None';	
							$Upassword = '';	
							$Uemail = 'None';	
						}
						
										
						?>	
						
						<br><br><hr style=" color:gray; background-color:gray; width:100%">
						<div style="text-align:center;">
							<button onclick="document.getElementById('id01').style.display='block'" class="edit">Update account</button>
						</div>
						
						<!---------------------  update form -------------------->
						<div id="id01" class="modal">
								<span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
								<div style="margin-left: auto; margin-right: auto; text-align:center;">
								<form class="modal-content" action="AccountPage.php" method="post">
									<div class="containers">
										<h1>Update your account</h1>
										<p>Please fill in the specific detail to update your account.</p>
										<hr>
										
										<div class='account' style="display:block; margin-bottom: 10px;  text-align:center; ">
											<input class="input-field1" type="text" placeholder="<?php echo "$Uname";?>" name="Username" value="<?php echo "$Uname";?>">
									
											<input class="input-field1" type="password" placeholder="<?php echo "$Upassword";?>" name="Password" value="<?php echo "$Upassword";?>">
								
											<input class="input-field1" type="text" placeholder="<?php echo "$Uemail";?>" name="Email" value="<?php echo "$Uemail";?>">
									
										</div>
										
										<div class="clearfix">
											<button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
											<button type="submit" class="updatebtn" name="Update_Button">Update</button>
										</div>
									</div>
								</form>
								</div>
							</div>	
					</div>
				</div>
			</div>
		</div>
		
	</body>
</html>
