<!DOCTYPE html>
<?php session_start();
if(!isset($_SESSION['username'])){
    header("location:login.php");
}
?>

<html>
<head>
  <meta charset="UTF-8">
  <title><?php echo $title ?> | Overtime hours on capital accounts</title>
      <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="img/icon.png" />
</head>
<body>
<!DOCTYPE html>
<head>
    <link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body style="background-image: url('img/background.png'); background-attachment: fixed;">
<nav class="navbar navbar-default" style="height:80px;">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">
        <img alt="Brand" src="img/topimg.png" width="150px">
      </a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="index.php">Home Menu</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="settings.php"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
      <li><a href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
  </div>
</nav>