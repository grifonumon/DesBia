<?php
	$sql = "SELECT * FROM users WHERE username = '"$_SESSION['currentUser']"';" 
	$conn = mysql_connect("localhost","root","acconts");
	$result = mysql_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);

	if($resultCheck>0){
		while ($row = mysqli_fetch_assoc($result)) {
			echo $row['reducere']."<br>";
		}
	}

?>