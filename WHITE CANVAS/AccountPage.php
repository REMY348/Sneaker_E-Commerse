<?php
	include "config.php";
	
	if(isset($_POST["Update_Button"]))
	{
		if(isset($_SESSION['user_id'])){
		$username = $_POST["Username"];
		$password = $_POST["Password"]; 
		$Email = $_POST["Email"];
		$PhoneNumber = $_POST["PhoneNumber"];
		$Address = $_POST["Address"];
		
		$sql = "UPDATE customer 
				SET Customer_Username = '$username', Customer_Password = '$password', Customer_Email = '$Email',
					Customer_PhoneNumber = '$PhoneNumber', Customer_Address = '$Address'
				WHERE Customer_ID LIKE '$_SESSION[user_id]'";
					
		$sendsql = mysqli_query($connect, $sql);
		
		if($sendsql)
		{	
			echo "<script>alert('Update complete')</script>";
		}
		else 
			echo "<script>alert('Update failed')</script>";
		}
		else 
			echo"<script>alert('You must Login First')</script>";
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
		<link rel="stylesheet" href="CSS/AccountPage.css" type="text/css" />
		<script src="https://code.jquery.com/jquery-3.5.1.min.js"> </script>
		
	</head>
	
	<body>
		<!--------------------- Header (calling header function)-------------------->
		<div id="header"></div>
		<!--------------------- Header End -------------------->
		
		<!---------------------  content -------------------->
		
		<div style="height:800px; display:flex; width:100%">
			<div id="mySidebar" class="sidebar">
				<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
				<a href="AccountPage.php">Account</a>
				<a href="CartPage.php">My Cart</a>
				<a href="OrderHistory.php">My purchase</a>
				<a href="Logout.php">Logout</a>
			</div>

			<div class="main">
				
				<button class="openbtnX" onclick="openNav()">☰ Open Sidebar</button>  
				
				<h1 style="text-align:center; font-size: 40px; ">My Account</h1>
				<hr>

				<div class="InnerContainer">
	
					<div style="width:30%; background-color:#DBE2EF; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"> 
						<img src="Images/Image for users/AccountDetail.png" style="width:100%; "/>
					</div>
					
					<!---------------------  user info -------------------->
					<div class = "RegisterDiv"> 
						<br>
						<h2 >My Details</h2>
						<hr style="width:100%">
						
						<?php
						
						if(isset($_SESSION['user_id'])){
							// display user info 
							$sql = "SELECT 
										*
									FROM
										customer
									WHERE
										Customer_ID LIKE '$_SESSION[user_id]';"; 
											
								$result = mysqli_query($connect, $sql);
									
								if($result)
								{
									if(mysqli_num_rows($result) > 0)
									{	
										while($row = mysqli_fetch_assoc($result))
										{
											echo "<ol class='listStyle'>
													<li><b>Username     :</b> $row[Customer_Username] </li>
													<li><b>Password     :</b> $row[Customer_Password] </li> 
													<li><b>Email        :</b> $row[Customer_Email] </li> 
													<li><b>Phone num.   :</b> $row[Customer_PhoneNumber] </li> 
													<li><b>Address      :</b> $row[Customer_Address] </li>
												</ol>
												";	

											$Uname = $row['Customer_Username'];	
											$Upassword = $row['Customer_Password'];	
											$Uemail = $row['Customer_Email'];	
											$UphoneNum = $row['Customer_PhoneNumber'];	
											$Uaddress = $row['Customer_Address'];	
										}
									}
								}
								else{ 
									"query failed!";
								}
						}
						else 
						{	
							$Uname = 'None';	
							$Upassword = '';	
							$Uemail = 'None';	
							$UphoneNum = 'None';	
							$Uaddress = 'None';
							echo"
							<div style='text-align:center'>
								<h3 style='color:grey;'>You must login first, click the link below to login</h3>
								<a style='text-decoration:none' href='LoginPage.php'> - Login here -</a>
							</div>
								";
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
										
										<div style="display:block; margin-bottom: 10px;  text-align:center; ">
											<input class="input-field1" type="text" placeholder="<?php echo "$Uname";?>" name="Username" value="<?php echo "$Uname";?>">
									
											<input class="input-field1" type="password" placeholder="<?php echo "$Upassword";?>" name="Password" value="<?php echo "$Upassword";?>">
								
											<input class="input-field1" type="text" placeholder="<?php echo "$Uemail";?>" name="Email" value="<?php echo "$Uemail";?>">
									
											<input class="input-field1" type="text" placeholder="<?php echo "$UphoneNum";?>" name="PhoneNumber" value="<?php echo "$UphoneNum";?>">
								
											<input class="input-field1" type="text" placeholder="<?php echo "$Uaddress";?>" name="Address" value="<?php echo "$Uaddress";?>">
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
		<!--------------------- content end -------------------->
		
		<!--------------- Footer ---------------->
		<div id="footer"></div>
		<!--------------- End of footer---------------->
		
		<script>
			/*-------------------------- Sidebar ------------------------------*/
			function openNav() {
				document.getElementById("mySidebar").style.width = "20%";
				document.getElementById("main").style.marginLeft = "50px";
			}

			function closeNav() {
				document.getElementById("mySidebar").style.width = "0";
				document.getElementById("main").style.marginLeft= "0";
			}
			/*-------------------------- Sidebar ends ------------------------------*/
			
			
			/*-------------------------- Calling header and footer fucntion ------------------------------*/
			$(function(){
				$("#header").load("Header.php"); 
				$("#footer").load("Footer.php");
			});
			/*-------------------------- header and footer fucntion end ------------------------------*/
			
			/*-------------------------- header and footer fucntion end ------------------------------*/
			// Get the modal
			var modal = document.getElementById('id01');

			// When the user clicks anywhere outside of the modal, close it
			window.onclick = function(event) {
				if (event.target == modal) {
					modal.style.display = "none";
				}
			}
			/*-------------------------- header and footer fucntion end ------------------------------*/
		</script>
		
	</body>
</html>