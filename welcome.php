<link rel="stylesheet" href="form.css">
<link rel="stylesheet" href="Css/StyleMenu.css" />

<?php session_start(); ?>

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

<div class="body content" style="background-color: #52616a; border-radius: 10px; margin-bottom: 10px">
	<div class="welcome">
		<div class="alert alert-success"><?= $_SESSION['message'] ?></div>
		<span class="user"><img src='<?= $_SESSION['avatar'] ?>' height="100px" width="auto"></span><br />
		Bun venit <span class="user"><?=$_SESSION['username'] ?> </span>
		<button onclick="location.href='logout.php'" type="button">Logout</button>
	</div>
</div>

<?php echo  $_SESSION['chestionarComplet']; ?>

</body>
