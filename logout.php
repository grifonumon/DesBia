<?php 
session_start();
  if(isset($_SESSION['username'])){ 
  		session_destroy();
  	}?>
<script>document.location.href = "Index.html";</script>    
