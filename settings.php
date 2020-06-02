<?php $title= "Settings"; include('header.php'); ?>
<?php     include ('connection-db.php');
if(isset($_POST['settings'])){
    $username = $_SESSION['username'];
    $curPwd = $_POST['current-password'];
    $newPwd1 = $_POST['new-password1'];
    $newPwd2 = $_POST['new-password2'];
    if(md5($newPwd1) != md5($newPwd2)){
        header("location:settings.php?pwd=2");
    }
    else{
        $newPwd1 = md5($newPwd1);
        $curPwd = md5($curPwd);
    $query = "UPDATE `users` SET `password`='$newPwd1' WHERE username='$username' AND password='$curPwd';";
    $result=  mysqli_query($con, $query);
        if(mysqli_affected_rows($con) >0){
            header("location:settings.php?pwd=1");        
        }
        else {
            header("location:settings.php?pwd=0");
        }}
}

if(isset($_POST['add'])){
    $username = $_POST['username'];
    $newPwd1 = $_POST['password'];
    $newPwd2 = $_POST['password2'];
    $usertype = $_POST['user-type'];
    if(md5($newPwd1) != md5($newPwd2)){
        header("location:settings.php?pwd=2");
    }
    else{
        $newPwd1 = md5($newPwd1);
    $query = "INSERT INTO `users`(`username`, `password`, `admin`) VALUES ('$username','$newPwd1','$usertype');";
    $result=  mysqli_query($con, $query);
        if(mysqli_affected_rows($con) >0){
            header("location:settings.php?add=1");        
        }
        else {
            header("location:settings.php?add=0");
        }}
}
if(isset($_POST['update'])){
    $username = $_POST['username'];
    $newPwd1 = $_POST['password'];
    $newPwd2 = $_POST['password2'];
    $usertype = $_POST['user-type'];
    
    if($newPwd1 =="" && $newPwd2==""){
    $query = "UPDATE `users` SET `admin`='$usertype' WHERE username='$username';";
    $result=  mysqli_query($con, $query);
        if(mysqli_affected_rows($con) >0){
            header("location:settings.php?update=1");        
        }
        else {
            header("location:settings.php?update=0");
        }
    }
    else if(md5($newPwd1) != md5($newPwd2)){
        header("location:settings.php?pwd=2");
    }
    else{
        $newPwd1 = md5($newPwd1);
    $query = "UPDATE `users` SET `password`='$newPwd1',`admin`='$usertype' WHERE username='$username';";
    $result=  mysqli_query($con, $query);
        if(mysqli_affected_rows($con) >0){
            header("location:settings.php?update=1");        
        }
        else {
            header("location:settings.php?update=0");
        }}
}


?>
  <div class='container'>

  <?php if(isset($_GET['update']) && $_GET['update']==0){ ?>
    <div class="alert alert-danger">
  <strong>Error!</strong> User does not found, please check username.
    </div>
    <?php } ?>

  <?php if(isset($_GET['update']) && $_GET['update']==1){ ?>
    <div class="alert alert-success">
  <strong>Success!</strong> User has been updated successufully.
    </div>
    <?php } ?>
      
  <?php if(isset($_GET['add']) && $_GET['add']==0){ ?>
    <div class="alert alert-danger">
  <strong>Error!</strong> New user does not added into the database, please check if there a user has same username.
    </div>
    <?php } ?>

  <?php if(isset($_GET['add']) && $_GET['add']==1){ ?>
    <div class="alert alert-success">
  <strong>Success!</strong> new user added successfully into the database.
    </div>
    <?php } ?>
      
      <?php if(isset($_GET['pwd']) && $_GET['pwd']==0){ ?>
    <div class="alert alert-danger">
  <strong>Error!</strong> Current Password is incorrect.
    </div>
    <?php } ?>
    
      <?php if(isset($_GET['pwd']) && $_GET['pwd']==1){ ?>
    <div class="alert alert-success">
  <strong>Success!</strong> Password has been changed.
    </div>
    <?php } ?>

    <?php if(isset($_GET['pwd']) && $_GET['pwd']==2){ ?>
    <div class="alert alert-danger">
  <strong>Error!</strong> New Password and Confirm Password does not match.
    </div>
    <?php } ?>
      
    <div class='panel panel-default dialog-panel'>
      <div class='panel-heading'>
        <h5>Change password</h5>
      </div>
      <div class='panel-body'>
        <form autocomplete="off" class='form-horizontal' role='form' method="POST" name="settings" value="settings" action="settings.php">
          <div class='form-group'>
          <label class='control-label col-md-2 col-md-offset-2' for='current-password'>Current Password </label>
            <div class='col-md-8'>
              <div class='col-md-7 indent-small'>
                <div class='form-group internal'>
                  <input required class='form-control' id='current-password' name="current-password" type='password'>
                </div>
              </div>
            </div>
          </div><div class='form-group'></div><legend></legend>
        <div class='form-group'>
          <label class='control-label col-md-2 col-md-offset-2' for='employee-name'>New Password </label>
            <div class='col-md-8'>
              <div class='col-md-7 indent-small'>
                <div class='form-group internal'>
                  <input required class='form-control' id='new-password1' name="new-password1" type='password'>
                </div>
              </div>
            </div>
            </div>
        <div class='form-group'>
          <label class='control-label col-md-2 col-md-offset-2' for='employee-name'>confirm Password </label>
            <div class='col-md-8'>
              <div class='col-md-7 indent-small'>
                <div class='form-group internal'>
                  <input required class='form-control' id='new-password2' name="new-password2" type='password'>
                </div>
              </div>
            </div>
          </div>
                <div class='form-group'>
            <div class='col-md-offset-4 col-md-1'>
              <button class='btn-lg btn-success' type='submit' name="settings" value="settings" method="post">Apply</button>
            </div>
          </div>
        </form>
      </div>
    </div>
          <?php if(isset($_SESSION['admin']) && $_SESSION['admin']==1){ ?>
    <div class='panel panel-default dialog-panel'>
      <div class='panel-heading'>
        <h5>Admin panel</h5>
      </div>
      <div class='panel-body'>
          <legend><h5>modify Users</h5></legend>
         <form autocomplete="off" class='form-horizontal' role='form' method="POST" name="add" value="add" action="settings.php">
          <div class='form-group'>
          <label class='control-label col-md-2 col-md-offset-2' for='username'>Username </label>
            <div class='col-md-8'>
              <div class='col-md-7 indent-small'>
                <div class='form-group internal'>
                  <input required class='form-control' id='username' name="username" type='text'>
                </div>
              </div>
            </div>
          </div>
        <div class='form-group'>
          <label class='control-label col-md-2 col-md-offset-2' for='password'>Password </label>
            <div class='col-md-8'>
                
              <div class='col-md-7 indent-small'>
                <div class='form-group internal'>
                  <input class='form-control' id='password' name="password" type='password'>
                </div>
              </div>
            </div>
            </div>
        <div class='form-group'>
          <label class='control-label col-md-2 col-md-offset-2' for='employee-name'>confirm Password </label>
            <div class='col-md-8'>
              <div class='col-md-7 indent-small'>
                <div class='form-group internal'>
                  <input class='form-control' id='password2' name="password2" type='password'>
                </div>
              </div>
            </div>
          </div>
        <div class='form-group'>
          <label class='control-label col-md-2 col-md-offset-2' for='user-type'>User Type </label>
            <div class='col-md-8'>
              <div class='col-md-7 indent-small'>
                <div class='form-group internal'>
                  <select required class='form-control datepicker' id="user-type" name="user-type">
                    <option value="" selected disabled>Please Select</option>
                    <option value="0">End User</option>
                    <option value="1">Admin</option>
                    </select>
                  </div>
              </div>
            </div>
          </div>
                <div class='form-group'>
            <div class='col-md-offset-4 col-md-1'>
              <button class='btn-lg btn-success' type='submit' name="add" value="add" method="post">Add</button>
            </div>
            <div class='col-md-offset-2 col-md-1'>
              <button class='btn-lg btn-primary' type='submit' name="update" value="update" method="post">Update</button>
            </div>
          </div>
        </form>
      </div>
    </div>
      <?php } ?>
  </div>

<?php include('footer.php') ?>