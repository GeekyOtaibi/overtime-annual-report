<?php $title= "Home"; include('header.php'); ?>
<div class='container'>
  <div class="panel panel-default dialog-panel">
    <div class='panel-heading'>
        <h4 align="center">Over time hours on capital accounts</h4>
    </div>
    <div class="panel-body">
    <button type="button" class="btn btn-default btn-lg btn-block" onClick="location.href='overtime.php'">Over Time</button>
    <button type="button" class="btn btn-default btn-lg btn-block" onClick="location.href='workassignment.php'">Work Assignments</button>
    <button type="button" class="btn btn-default btn-lg btn-block" onClick="location.href='report.php'">Report</button>
    <?php if(isset($_SESSION['admin']) && $_SESSION['admin']==1){ ?>
    <button type="button" class="btn btn-default btn-lg btn-block" onclick="location.href='mng.php'">Management's Page</button>
    <?php } ?>
    </div>
  </div>
</div>

<style>.footer {
  position: absolute;
  right: 0;
  bottom: 0;
  left: 0;
  padding: 1rem;
  background-color: #efefef;
  text-align: center;
}</style>