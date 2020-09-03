	
<?php 
	include_once('../Database/database.php');
	include('navside.php'); 
	include('functions.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Teacher Profile</title>
</head>

<body>
	
	<div style="margin-left: 20%; margin-top: 4%;"> <!-- main div -->
		<div class="row">

			<div class="col-xs-8 col-md-12">
				<?php 
				if(isset($_SESSION['pasw_changed'])){
					echo '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> Your Password has been updated.
  						</div>';
				}

				if (isset($_POST['uploadpic'])){
					$file = $_FILES['file'];

					$fileName = $file['name'];
					$fileTmpName = $file['tmp_name'];
					$fileSize = $file['size'];
					$fileErr = $file['error'];
					$fileType = $file['type'];

					$fileExt = explode('.', $fileName);
					$fileExt = strtolower(end($fileExt));

					$allowed = array('jpg');

					if (in_array($fileExt, $allowed)){
						if ($fileErr === 0) {
							$newFileName = $_SESSION['T_ID'].'.'.$fileExt;
							$fileDestination = '../Images/'.$newFileName;
							move_uploaded_file($fileTmpName, $fileDestination);
							$userid = $_SESSION['T_ID'];
							$query = "UPDATE login SET picPath = '$fileDestination' WHERE UserID = '$userid'";
							mysqli_query($GLOBALS['conn'],$query);
							echo '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px">&times;</a>
    						<strong>Success!</strong> Picture Uploaded.
  						</div>';
						}
						else {
							echo '<div class="alert alert-warning alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Error!</strong> Uploading File
  						</div>';
						}
					}
					else {
						echo '<div class="alert alert-warning alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Error!</strong> File Type Not Allowed
  						</div>';
					}
				}

				?>

				<div class='profile_box col-xs-12 col-md-12'>
					<div class ='image'>
						<?php
						$userid = $_SESSION['T_ID'];
						$query = "SELECT picPath FROM login WHERE UserID = '$userid'";
						$result = mysqli_query($GLOBALS['conn'],$query);
						$row = mysqli_fetch_row($result);
						$picPath = $row[0];
						if ($picPath=='NOT SET'){
							$src = "../Images/avatar.png";
						}
						else{
							$src = $picPath;
						}

						 ?>
						<img src="<?php echo $src; ?>" width="210px" height="250px;"></div>
					<div class='profile_txt' style="margin-top: 25px;">ID: <?php echo $_SESSION['T_ID'] ?></div>
					<hr>
					<div class='profile_txt'>Name: <?php echo $_SESSION['Name'] ?></div>
					<hr>
					<div class='profile_txt'>Number: <?php echo $_SESSION['Contact'] ?></div>
					<hr>
					<div class='profile_txt'>Email: <?php echo $_SESSION['Email'] ?></div>
					<hr>
					<div class='profile_txt'>Department: <?php echo $_SESSION['Dept'] ?></div>
					<hr>
					<div class='profile_txt'>Salary: <?php echo $_SESSION['Salary'] ?></div>
					<hr>
					<div class='profile_txt' style="margin-bottom: 25px;">Address: <?php echo $_SESSION['Address'] ?></div>

				</div>



			</div>

		</div>

		<div class = "uploadbox col-xs-12">
			<h2 style="margin-left: 375px;">Change Your Display</h2>

			<form method="post" enctype = "multipart/form-data" action= <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> >
				<div class="form-group">
					<input style = "margin-left: 405px; width: 220px;" class="form-control" type="file" name="file">
					<button style="margin-left: 465px;margin-top: 10px;" type="submit" class="btn btn-primary" name='uploadpic'>UPLOAD</button>
				</div>
				
			</form>

		</div>



	</div> <!-- Main Div> -->
</body>




</html>