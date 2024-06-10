<?php 
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
     
     $id = $_SESSION['id'];
     $uname = $_SESSION['user_name'];
     $name = $_SESSION['name'];

 ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="home.css">
	<title>Welcome, <?php echo $name; ?></title>
</head>
<body>
     <div id="container">
          <?php 
          echo '<h1>', $name, '</h1><br>';
          echo '<h2 style="color:gray;">@', $uname,'</h1>';
          
          ?>
          <p><a href = "logout.php" style = "color:red; text-decoration:none;">Logout</a></p>
          <div id="empty"></div>
     </div>
</body>
</html>

<?php 
}else{
     header("Location: index.php?youaintslick");
     exit();
}
 ?>