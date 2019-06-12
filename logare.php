<?php 
session_start();
$_SESSION['message'] = '';

$mysqli = new mysqli('localhost','root','','acconts');
$db = mysqli_connect('localhost','root','','acconts');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    

    $username = $mysqli->real_escape_string($_POST['username']);
    $password = md5($_POST['password']); //md5 hash password

    $sql = "SELECT * FROM users WHERE username = '$username' and password = '$password'";
    $result = mysqli_query($db,$sql);
    $row = mysqli_fetch_assoc($result);

    $count = mysqli_num_rows($result);
    // If result matched $myusername and $mypassword, table row must be 1 row
    
      if($count == 1) {
         $_SESSION['username'] = $username;
         $_SESSION['avatar'] = $row['avatar'];
         $_SESSION['chestionarComplet'] = $row['reducere'];
         $_SESSION['message'] = 'Registration succesful! Exist $username to the database!';
         header("location: welcome.php");
      }else {
         $_SESSION['message'] = "Nume sau parola invalide!";
      }


}
?>

<link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="StyleMenu.css">
<link rel="stylesheet" href="form.css">

<body style="background-image: linear-gradient(to left bottom, white 0%, grey 100%); font-family: ">
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

<div class="body-content">
  <div class="module" align="Center" style="background-color:#7D7D7D7D; border-radius:10px;">
    <h1 style="color: black;"><strong>Logare</strong></h1>
    <form class="form" action="logare.php" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="alert alert-error"><?=$_SESSION['message'] ?></div>
      <input type="text" placeholder="Nume" name="username" required />
      <input type="password" placeholder="Parola" name="password" autocomplete="new-password" required />
      <input type="submit" value="Logare" name="login" class="btn btn-block btn-primary" />
      <br>
      <h5 style="color: #000000">Nu ai cont? Creaza-ti unul.</h5>
      <a href="form.php">
       <input type="button" value="Inregistrare" name="register" class="btn btn-block btn-primary" />
     </a>
    </form>
  </div>
</div>
</body>