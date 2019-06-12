<?php   
 session_start(); 
 ?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="StyleMenu.css">
	<title>Acasa</title>
	
	<style>
	.container { width: 900px; margin: auto; padding-top: 1em; }
	.container .ism-slider { margin-left: auto; margin-right: auto; }
	</style>

	<link rel="stylesheet" href="css/my-slider.css"/>
	<script src="js/ism-2.2.min.js"></script>
	</head>
<body style="background-image: linear-gradient(to left bottom, white 0%, grey 100%);>
 <div class="sandbox sandbox-titlu">
        <h1 class="heading-titlu">
            <em>Librarie</em>
            Online
        </h1>
    </div>
    <nav>
        <ul id="nav">
            <li>
                <a href="Index.html">Home</a>
            </li>
            <li>
                <a href="AfisareCarti.php">Magazin</a>
            </li>
            <li>
                <a href="Chestionar.php">Chestionar Reducere</a>
            </li>
            <li>
                <a href="form.php">Autentificare</a>
            </li>
        </ul>
    </nav>
	
<div class='container' align="Center">
    <h2>Chestionar complet!</h2>
   <?php $_SESSION['chestionarComplet'] = 1; 
    $mysqli = new mysqli('localhost','root','','acconts');
    $db = mysqli_connect('localhost','root','','acconts');
    $sql = "SELECT * FROM users WHERE username ='".$_SESSION['username'] ."'";
    $result = mysqli_query($db,$sql);
    $row = mysqli_fetch_assoc($result);

    $count = mysqli_num_rows($result);
    // If result matched $myusername and $mypassword, table row must be 1 row
    $id = $row['id'];
    $sql = "UPDATE users SET reducere=1 WHERE id='$id'";

    if (mysqli_query($db, $sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($db);
    }
    echo "Status Updatat";
 ?>
</div>
</body>
</html>