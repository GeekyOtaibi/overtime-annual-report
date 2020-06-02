<?php $title= "Home"; include('header.php'); ?>
<?php if(isset($_SESSION['admin']) && $_SESSION['admin']==1){ ?>
<div class='container'>
  <div class="panel panel-default dialog-panel">
    <div class='panel-heading'>
        <h4 align="center">Management's Page</h4>
    </div>
    <div class="panel-body">
    <button type="button" class="btn btn-default btn-lg btn-block" onClick="location.href='mngusers.php'">Managing Users</button>
    <button type="button" class="btn btn-default btn-lg btn-block" onClick="location.href='mngwbs.php'">Managing WBS</button>
    </div>
  </div>
</div>
<?php }else{
    header('location:error.php');
} ?>
<style>.footer {
  position: absolute;
  right: 0;
  bottom: 0;
  left: 0;
  padding: 1rem;
  background-color: #efefef;
  text-align: center;
}</style>