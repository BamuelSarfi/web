<?php 
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

 ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
	<title>Welcome, <?php echo $_SESSION['name']; ?></title>
</head>
<body>
     <h1>Hello, master.</h1>
     <a id="logout" href="logout.php">Logout</a>
</body>
</html>

<?php 
}else{
     header("Location: index.php");
     exit();
}
 ?>