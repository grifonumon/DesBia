<?php 
session_start();
$_SESSION['message'] = '';

$mysqli = new mysqli('localhost','root','','acconts');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  //tow passwords are equal to each other
  if($_POST['password'] == $_POST['confirmpassword']){
    
    $username = $mysqli->real_escape_string($_POST['username']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = md5($_POST['password']); //md5 hash password
    $avatar_path = $mysqli->real_escape_string('images/'.$_FILES['avatar']['name']);

    //make sure file type is image
    if(preg_match("!image!", $_FILES['avatar']['type'])){
        //copy image to images/ folder
        if(copy($_FILES['avatar']['tmp_name'], $avatar_path)){
          $_SESSION['username'] = $username;
          $_SESSION['avatar'] = $avatar_path;

          $sql = "INSERT INTO users (username, email, password, avatar) "
                ."VALUES('$username','$email','$password','$avatar_path')";
          //if the query is succesful, redirect to first page
          if($mysqli->query($sql) === true){
            $_SESSION['message'] = 'Registration succesful! Added $username to the database!';
            header("location: welcome.php");
          }
          else{
            $_SESSION['message'] = "Nu a putut fi adaugat utilizatorul in baza de date!";
          }
        }
        else{
          $_SESSION['message'] = "Nu a putut fi incarcat fisierul!";
        }
     }
     else{
        $_SESSION['message'] = "Incarcati doar fisiere cu extensia .GIF, .JPG, .PNG!";
    }
   }
   else{
     $_SESSION['message'] = "Cele doua parole nu sunt identice!";
  }
}
?>

<link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="StyleMenu.css">
<link rel="stylesheet" href="form.css">

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
                <a href="Chestionar.html">Chestionar Reducere</a>
            </li>
            <li>
                <a href="form.php">Autentificare</a>
            </li>
        </ul>
    </nav>

<div class="body-content">
  <div class="module" align="Center" style="background-color:#7D7D7D7D; border-radius:10px;">
    <h1 style="color: black;"><strong>Inregistrare</strong></h1>
    <form class="form" action="form.php" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="alert alert-error"><?=$_SESSION['message'] ?></div>
      <input type="text" placeholder="Nume" name="username" required />
      <input type="email" placeholder="Email" name="email" required />
      <input type="password" placeholder="Parola" name="password" autocomplete="new-password" required />
      <input type="password" placeholder="Confirmare Parola" name="confirmpassword" autocomplete="new-password" required />
      <div class="avatar"><label style="color: black;">Selectare imagine: </label><input type="file" name="avatar" accept="image/*" required /></div>
      <input type="submit" value="Inregistrare" name="register" class="btn btn-block btn-primary" />
       <input type="submit" value="Logare" name="login" class="btn btn-block btn-primary" />
    </form>
  </div>
</div>
</body>