<?php $title= "Error page"; ?>
<?php session_start();?>
<head>
      <title><?php echo $title ?> | Brand name</title>
      <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="img/icon.png" />
    <link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body style="background-image: url('img/background.png'); background-attachment: fixed;">
<nav class="navbar navbar-default" style="height:80px;">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand">
        <img alt="Brand" src="img/topimg.png" width="150px">
      </a>
    </div>

    <ul class="nav navbar-nav navbar-right">
    </ul>
  </div>
</nav>

<div class='container'>
    <div class="alert alert-danger">
  <strong>Error!</strong> you do not have privilege to access this page, please go back to homepage <a href="index.php" style="color:green">click here</a>
    </div>
    </div></body>