<?php $title= "Work Assignment Entry"; include('header.php'); ?>

<?php 
    include('connection-db.php');
    $query="Select ID, code from wbs;";
    $result=  mysqli_query($con, $query);
    $code=array();
    while($row=mysqli_fetch_assoc($result)){
        $code[$row['ID']]=array("code"=>$row['code']);
    }
?>

<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
    include ('connection-db.php');
    $query="Select * from employee where ID=$id";
    $result=  mysqli_query($con, $query);
    $row=mysqli_fetch_assoc($result);
}

if(isset($_POST['add'])){
    $empID = $_POST['span-id'];
    $empName = $_POST['employee-name'];
    $orgCode = $_POST['org-code'];
    $ccp = $_POST['cost-center-project'];
    $wbsCode = $_POST['wbs-code'];
    $actType = $_POST['activity-type'];
    $waType = $_POST['wa-type'];
    $startDate = $_POST['start-date'];
    $endDate = $_POST['end-date'];
    $waCost = $_POST['wa-cost'];
    $username=$_SESSION['username'];
    $days = $_POST['days'];
    $ticket = $_POST['ticket-cost'];
    $basicsalary=$_POST['baseSalary'];
    
    $startDate=date('Y-m-d',strtotime($startDate));
    $endDate=date('Y-m-d',strtotime($endDate));
    //-------------------------------------------------- compare overtime dates
    include('connection-db.php');
    $query="select startDate from overtime where empID=$empID";
    $result=  mysqli_query($con, $query);
    
    while($row=mysqli_fetch_assoc($result)){
        $otDate= date('Y-m-d',strtotime($row['startDate']));
        if($otDate >= $startDate && $otDate <= $endDate){
            header("location:workassignment.php?error=otdate");
            die();
        }
    }
    //-------------------------------------------------- check and calculate WBS budget
    include('connection-db.php');
    $query="select * from wbs where code='$wbsCode'";
    $result=  mysqli_query($con, $query);
    $row=mysqli_fetch_assoc($result);
    $remainder = $row['remainder'];
    
    if($remainder < $waCost){
        header("location:workassignment.php?error=budget");
        die();
    }
    //--------------------------------------------------
    if($endDate<$startDate){
        header("location:workassignment.php?error=date");
        die();
    }
    else if($startDate >= $otDate && $endDate <= $otDate){
        header("location:workassignment.php?error=otdate");
        die();
    }
    else{
        include('connection-db.php');
        $query="INSERT INTO `work_assign`(`empID`, `empName`, `orgCode`, `ccp`, `wbsCode`, `actType`, `waType`, `startDate`, `endDate`, `days`,`ticket`, `waCost`,`baseSalary`,`Username`) VALUES ('$empID','$empName','$orgCode','$ccp','$wbsCode','$actType','$waType','$startDate','$endDate','$days','$ticket','$waCost','$basicsalary','$username')";

        $result=mysqli_query($con,$query);
        if($result==1){
                {
                    $query="UPDATE `wbs` SET `withdrew`=(withdrew + $waCost),`remainder`=(remainder - $waCost) WHERE code='$wbsCode';";
                    $result=mysqli_query($con,$query);
                    if($result==1){header("location:workassignment.php?status=1");}
                    else{header("location:workassignment.php?status=0");}
                }
        }
        else {
            header("location:workassignment.php?status=0");
        }
    }
}
?>

<div class='container'>
    
<?php if(isset($_GET['id']) && empty($row['name'])){ ?>
    <div class="alert alert-danger">
  <strong>Error!</strong> Employee not found in the database.
    </div>
    <?php } ?>
    
<?php if(isset($_GET['error']) && $_GET['error']=='date'){ ?>
    <div class="alert alert-danger">
  <strong>Error!</strong> End Date is less than Start Date.
    </div>
    <?php } ?>

<?php if(isset($_GET['error']) && $_GET['error']=='otdate'){ ?>
    <div class="alert alert-danger">
  <strong>Error!</strong> This employee has an overtime at this date.
    </div>
    <?php } ?>
    
<?php if(isset($_GET['error']) && $_GET['error']=='budget'){ ?>
    <div class="alert alert-danger">
  <strong>Error!</strong> There's no budget in this WBS.
    </div>
    <?php } ?>

<?php if(isset($_GET['status']) && $_GET['status']==0){ ?>
    <div class="alert alert-danger">
  <strong>Error!</strong> there's somthing wrong in the PHP code.
    </div>
    <?php } ?>
    
<?php if(isset($_GET['status']) && $_GET['status']==1){ ?>
    <div class="alert alert-success">
  <strong>Success!</strong> information has been submit.
    </div>
    <?php } ?>

  <div class="panel panel-default dialog-panel">
    <div class='panel-heading'>
        <h5>Work Assignment Entry</h5>
    </div>
    <div class="panel-body">
      <form autocomplete="off" class='form-horizontal' action="workassignment.php" name="search" method="get" role='form'>
        <div class="form-group">
        <label class='control-label col-md-2 col-md-offset-3' for='employee-id'>Enter Employee's ID</label>
            <div class='col-md-6'>
              <div class='col-md-6'>
                <div class='form-group internal'>
                  <input class='form-control' id='employee-id' name="id" type='number' required>
                </div>
              </div>
            <button class="btn-sm btn-primary col-sm-offset-1" type="submit">Search </button>
        </div>
      </div>
        </form>
    <form autocomplete="off" class='form-horizontal' action="workassignment.php" method="POST" name="add">
    <div class='form-group'><legend></legend>
            <label class='control-label col-md-2 col-md-offset-1' for='employee-name'>Employee's Name</label>
            <div class='col-md-8'>
              <div class='col-md-5 indent-small'>
                <div class='form-group internal'>
                  <input class='form-control readonly' id='employee-name' name="employee-name" required type='text' value="<?php if(!empty($row['name'])){echo $row['name'];} ?>">
                </div>
              </div>
              <label class='control-label col-md-2' for='org-code'>Org. Code</label>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                  <input class='form-control readonly' id='org-code' name='org-code' type='number' required  value="<?php if(!empty($row['orgCode'])){echo $row['orgCode'];} ?>">
                </div>
              </div>
            </div>
          </div>
    <div class='form-group'><legend></legend>
            <label class='control-label col-md-2 col-md-offset-1' for='cost-center-project'>Cost Center Project</label>
            <div class='col-md-8'>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                  <input class='form-control' id='cost-center-project' name='cost-center-project' type='number' required>
                </div>
              </div>
              <label class='control-label col-md-4' for='wbs-code'>WBS Code</label>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                   <select required class='form-control' id='wbs-code' name="wbs-code">
                    <option value="" selected disabled>Please select</option>
                      <?php foreach($code as $i){ ?>
                    <option value="<?php echo $i['code']; ?>"><?php echo $i['code']; ?></option>
                      <?php } ?>
                    </select>
                </div>
              </div>
            </div>
          </div>
    <div class='form-group'><legend></legend>
            <label class='control-label col-md-2 col-md-offset-1' for='activity-type'>Activity Type</label>
            <div class='col-md-8'>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                  <select class='form-control datepicker' id='activity-type' name='activity-type' required>
                    <option value="" selected disabled>Please select</option>
                    <option value="Witnessing">Witnessing</option>
                    <option value="Testing & Comm.">Testing & Comm.</option>
                    <option value="Other.">Other.</option>
                  </select>
                </div>
              </div>
              <label class='control-label col-md-4' for='attend-type'>Work Assignment Type</label>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                  <select class='form-control datepicker' id='wa-type' name='wa-type' required>
                    <option value="" selected disabled>Please select</option>
                    <option value="50">50-99,KM</option>
                    <option value="50">100-199,KM</option>
                    <option value="450">100-199,KM (Nights)</option>
                    <option value="1000">200,KM+</option>
                  </select>
                </div>
              </div>
            </div>
        </div>
    <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-1' for='start-date'>Start Date</label>
            <div class='col-md-8'>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                  <input class='form-control datepicker' type="date" id='start-date' name='start-date' required>
                  <span class='input-group-addon'>
                    <i class='glyphicon glyphicon-calendar'></i>
                  </span>
                </div>
              </div>
              <label class='control-label col-md-4' for='end-date'>End Date</label>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                  <input class='form-control datepicker' type="date" id='end-date' name='end-date' required>
                  <span class='input-group-addon'>
                    <i class='glyphicon glyphicon-calendar'></i>
                  </span>
                </div>
              </div>
            </div>
        </div>
    <div class='form-group'><legend></legend>
            <label class='control-label col-md-2 col-md-offset-1' for='days'>Days</label>
            <div class='col-md-8'>
              <div class='col-md-1'>
                <div class='form-group internal input-group'>
                  <input class='form-control' id='days' name='days' readonly type='number'>
                </div>
              </div>
            <label class='control-label col-md-3' for='ticket-cost'>Ticket's Cost</label>
              <div class='col-md-2'>
                <div class='form-group internal input-group'>
                  <input required class='form-control' id='ticket-cost' name='ticket-cost' type='number'>
                </div>
              </div>
              <label class='control-label col-md-3' for='wa-cost'>WA Cost</label>
              <div class='col-md-2'>
                <div class='form-group internal input-group'>
                  <input class='form-control' id='wa-cost' name='wa-cost' readonly type='number'>
                </div>
              </div>
            </div>
          </div>
        <!-- this section for hidden inputs -->
        <input hidden name="span-id" value="<?php if(!empty($_GET['id'])){echo $_GET['id'];} ?>">
        <input id='baseSalary' name='baseSalary' style="visibility:hidden" value="<?php if(!empty($row['baseSalary'])){echo $row['baseSalary'];} ?>">
        <!-- ends here -->
    <div class='form-group'><legend></legend>
            <div class='col-md-offset-4 col-md-1'>
              <button class='btn-lg btn-success' type='submit' method="post" name="add">Submit</button>
            </div>
            <div class='col-md-3'>
              <button class='btn-lg btn-danger' style='float:right' type='reset'>Reset</button>
            </div>
          </div>
    </form>
  </div>
    </div>
      <?php 
include ('connection-db.php');
       $query="Select * from work_assign ;";
       $result=  mysqli_query($con, $query);
       $record=array();
       while($row=  mysqli_fetch_assoc($result)){
           $record[$row['ID']]=array( "empID"=>$row['empID'],
                   "empname"=>$row['empName'],
                   "orgcode"=>$row['orgCode'],
                   "ccp"=>$row['ccp'],
                   "wbsCode"=>$row['wbsCode'],
                   "actType"=>$row['actType'],
                   "waType"=>$row['waType'],
                   "startDate"=>$row['startDate'],
                   "endDate"=>$row['endDate'],
                   "days"=>$row['days'],
                   "waCost"=>$row['waCost'],
                   "baseSalary"=>$row['baseSalary'],
                   "ticket"=>$row['ticket'],
                   "Username"=>$row['Username']
                   );
        }
?>
    <?php if(isset($_SESSION['admin']) && $_SESSION['admin']==1){ ?>
    <div class='panel panel-default dialog-panel'>
      <div class='panel-heading'>
        <h5>Users Table</h5>
      </div>
      <div class='panel-body'>
        <a href="#" id="test" onclick="javascript:fnExcelReport();">Download this Table</a>
        <table class="table" id="myTable">
          <thead>
              <tr>
                <th>Emp's ID</th>
                <th>Emp's Name</th>
                <th>Org. Code</th>
                <th>CCP</th>
                <th>WBS Code</th>
                <th>Activity's Type</th>
                <th>WA's Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>days</th>
                <th>Ticket's Cost</th>
                <th>WA's Cost</th>
                <th>Username</th>
              </tr>
          </thead>
          <tbody>
            <?php foreach($record as $i){ ?>
              <tr>
                <td><?php echo $i['empID']; ?></td>
                <td><?php echo $i['empname']; ?></td>
                <td><?php echo $i['orgcode']; ?></td>
                <td><?php echo $i['ccp']; ?></td>
                <td><?php echo $i['wbsCode']; ?></td>
                <td><?php echo $i['actType']; ?></td>
                <td><?php echo $i['waType']; ?></td>
                <td><?php echo $i['startDate']; ?></td>
                <td><?php echo $i['endDate']; ?></td>
                <td><?php echo $i['days']; ?></td>
                <td><?php echo $i['ticket']; ?></td>
                <td><?php echo $i['waCost']; ?></td>
                <td><?php echo $i['Username']; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php } ?>
    
    </div>
    
    <?php include('footer.php'); ?>