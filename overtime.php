<?php $title= "Overtime Enery"; include('header.php'); ?>

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
?>

<?php
        if(isset($_POST['add']))
        {
            
            $employeeid=$_POST['span-id'];
            $employeename=$_POST['employee-name'];
            $orgcode=$_POST['org-code'];
            $ccp=$_POST['cost-center-project'];
            $wbs=$_POST['wbs-code'];
            $actType=$_POST['activity-type'];
            $attType=$_POST['attend-type'];
            $date=$_POST['date'];
            $startTime=$_POST['start-time'];
            $endTime=$_POST['end-time'];
            $hours=$_POST['hours'];
            $otCost=$_POST['ot-cost'];
            $username=$_SESSION['username'];
            $basicsalary=$_POST['baseSalary'];
            $date=date('Y-m-d',strtotime($date));
            //-------------------------------------------------- compare work assignemnt dates
            include('connection-db.php');
            $query="select startDate, endDate from work_assign where empID=$employeeid";
            $result=  mysqli_query($con, $query);
            while($row=mysqli_fetch_assoc($result)){
                $startDate= date('Y-m-d',strtotime($row['startDate']));
                $endDate= date('Y-m-d',strtotime($row['endDate']));
                if($date >= $startDate && $date <= $endDate){
                    header("location:overtime.php?error=wadate");
                    die();
                }
            }
            //-------------------------------------------------- check and calculate WBS budget
            include('connection-db.php');
            $query="select * from wbs where code='$wbs'";
            $result=  mysqli_query($con, $query);
            $row=mysqli_fetch_assoc($result);
            $remainder = $row['remainder'];
            if($remainder < $otCost){
                header("location:overtime.php?error=budget");
                die();
            }
            //--------------------------------------------------
                include ('connection-db.php');
                $query="INSERT INTO `overtime`( `empID`, `empname`, `orgcode`, `ccp`, `wbsCode`, `actType`,"
                        . " `attType`, `startDate`, `startTime`, `endTime`, `hours`, `otCost`, `baseSalary`,`Username`) "
                        . "VALUES ('$employeeid','$employeename',"
                        . "'$orgcode','$ccp','$wbs','$actType','$attType',"
                        . "'$date','$startTime','$endTime','$hours','$otCost' , '$basicsalary','$username')" ;
                $result=mysqli_query($con,$query);
                  if($result==1)
                {
                    $query="UPDATE `wbs` SET `withdrew`=(withdrew + $otCost),`remainder`=(remainder - $otCost) WHERE code='$wbs';";
                    $result=mysqli_query($con,$query);
                    if($result==1){header("location:overtime.php?status=1");}
                    else{header("location:overtime.php?status=0");}
                }
                else{
                    header("location:overtime.php?status=0");
                }
            }
            ?>
<div class='container'>
    
<?php if(isset($_GET['id']) && empty($row['name'])){ ?>
    <div class="alert alert-danger">
  <strong>Error!</strong> Employee not found in the database.
    </div>
    <?php } ?>
    
<?php if(isset($_GET['status']) && $_GET['status']==0){ ?>
    <div class="alert alert-danger">
  <strong>Error!</strong> there's somthing wrong in the PHP code.
    </div>
    <?php } ?>

<?php if(isset($_GET['error']) && $_GET['error']=='wadate'){ ?>
    <div class="alert alert-danger">
  <strong>Error!</strong> This employee has an work assignment at this date.
    </div>
<?php } ?>
    
<?php if(isset($_GET['error']) && $_GET['error']=='budget'){ ?>
    <div class="alert alert-danger">
  <strong>Error!</strong> There's no budget in this WBS.
    </div>
<?php } ?>
    
<?php if(isset($_GET['status']) && $_GET['status']==1){ ?>
    <div class="alert alert-success">
  <strong>Success!</strong> information has been submit.
    </div>
    <?php } ?>

  <div class="panel panel-default dialog-panel">
    <div class='panel-heading'>
        <h5>Over Time Entry</h5>
    </div>
    <div class="panel-body">
      <form autocomplete="off" class='form-horizontal' action="overtime.php" name="search" method="get" role='form'>
        <div class="form-group">
        <label class='control-label col-md-2 col-md-offset-3' for='employee-id'>Enter Employee's ID</label>
            <div class='col-md-6'>
              <div class='col-md-6'>
                <div class='form-group internal'>
                    <input required class='form-control' id='employee-id' name="id" type='number' required >
                </div>
              </div>
            <button class="btn-sm btn-primary col-sm-offset-1">Search</button>
        </div>
      </div>
      </form>
       <form autocomplete="off" class='form-horizontal' action="overtime.php"  method="POST" role='form' name="add">
    <div class='form-group'><legend></legend>
            <label class='control-label col-md-2 col-md-offset-1' for='employee-name'>Employee's Name</label>
            <div class='col-md-8'>
              <div class='col-md-5 indent-small'>
                <div class='form-group internal'>
                  <input  class='form-control readonly' id='employee-name' required name="employee-name" type='text' value="<?php if(!empty($row['name'])){echo $row['name'];} ?>">
                </div>
              </div>
              <label class='control-label col-md-2' for='id_checkout'>Org. Code</label>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>   
                  <input class='form-control readonly' id='org-code' type='number' name="org-code" required  value="<?php if(!empty($row['orgCode'])){echo $row['orgCode'];} ?>">
                </div>
              </div>
            </div>
          </div>
    <div class='form-group'><legend></legend>
            <label class='control-label col-md-2 col-md-offset-1' for='cost-center-project'>Cost Center Project</label>
            <div class='col-md-8'>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                  <input required class='form-control' id='cost-center-project' type='number' name="cost-center-project">
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
                  <select class='form-control datepicker' id='activity-type' name="activity-type">
                    <option value="" selected disabled>Please select</option>
                    <option value="Witnessing">Witnessing</option>
                    <option value="Testing & Comm.">Testing & Comm.</option>
                    <option value="Other.">Other.</option>
                  </select>
                </div>
              </div>
              <label class='control-label col-md-4' for='attend-type'>Attend. Type</label>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                  <select class='form-control datepicker' id='attend-type' name="attend-type">
                    <option value="" selected disabled>Please select</option>
                    <option value="Regular">Regular</option>
                    <option value="Overtime">Overtime</option>
                  </select>
                </div>
              </div>
            </div>
        </div>
    <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-1' for='date'>Date</label>
            <div class='col-md-8'>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                    <input required class='form-control datepicker' type="date" id='date' name="date">
                  <span class='input-group-addon'>
                    <i class='glyphicon glyphicon-calendar'></i>
                  </span>
                </div>
              </div>
            </div>
        </div>
    <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-1' for='id_checkin'>Start Time</label>
            <div class='col-md-8'>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                    <input required class='form-control timepicker' type="time" id='start-time' name="start-time">
                  <span class='input-group-addon'>
                    <i class='glyphicon glyphicon-time'></i>
                  </span>
                </div>
              </div>
                <label class='control-label col-md-4' for='id_checkout' >End Time</label>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                    <input required class='form-control timepicker' type="time" id='end-time' name="end-time">
                  <span class='input-group-addon'>
                    <i class='glyphicon glyphicon-time'></i>
                  </span>
                </div>
              </div>
            </div>
        </div>
    <div class='form-group'><legend></legend>
            <label class='control-label col-md-2 col-md-offset-1' for='hours'>Hours</label>
            <div class='col-md-8'>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                    <input required class='form-control' id='hours' readonly type='number' name="hours">
                </div>
              </div>
              <label class='control-label col-md-4' for='ot-code' hidden>OT Cost</label>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                    <input required  class='form-control' id='ot-cost' readonly type='number' name="ot-cost" style="visibility:hidden" >
                </div>
              </div>
                <label class='control-label col-md-4' for='baseSalary' hidden>Basic Salary</label>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                  <input class='form-control' id='baseSalary' name='baseSalary' readonly type='number' style="visibility:hidden" value="<?php if(!empty($row['baseSalary'])){echo $row['baseSalary'];} ?>">
                </div>
              </div>
            </div>
          </div>
           <!-- this section for hidden inputs -->
        <input required hidden name="span-id" value="<?php if (!empty($_GET['id'])){echo $_GET['id'];}?>">
        <input required hidden id="span-per-hour" value="<?php if(!empty($row['perHour'])){echo $row['perHour'];} ?>">
        <input required hidden id="span-extra-pay" value="<?php if(!empty($row['extraPay'])){echo $row['extraPay'];} ?>">
           <!-- ends here -->
    <div class='form-group'><legend></legend>
            <div class='col-md-offset-4 col-md-1'>
              <button class='btn-lg btn-success' type='submit' name="add" value="overtime" method="post">Submit</button>
            </div>
            <div class='col-md-3'>
                <button class='btn-lg btn-danger' style='float:right' type='Reset' >Reset</button>
            </div>
          </div>
    </form>
  </div>
</div>
    
    
      
<?php 
include ('connection-db.php');
       $query="Select * from overtime ;";
       $result=  mysqli_query($con, $query);
       $record=array();
       while($row=  mysqli_fetch_assoc($result)){
           $record[$row['ID']]=array( "empID"=>$row['empID'],
                   "empname"=>$row['empname'],
                   "orgcode"=>$row['orgcode'],
                   "ccp"=>$row['ccp'],
                   "wbsCode"=>$row['wbsCode'],
                   "actType"=>$row['actType'],
                   "attType"=>$row['attType'],
                   "startDate"=>$row['startDate'],
                   "startTime"=>$row['startTime'],
                   "endTime"=>$row['endTime'],
                   "hours"=>$row['hours'],
                   "otCost"=>$row['otCost'],
                   "baseSalary"=>$row['baseSalary'],
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
                <th>Attend's Type</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Date</th>
                <th>otCost</th>
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
                <td><?php echo $i['attType']; ?></td>
                <td><?php echo $i['startDate']; ?></td>
                <td><?php echo date("g:i a", strtotime($i['startTime'])); ?></td>
                <td><?php echo date("g:i a", strtotime($i['endTime'])); ?></td>
                <td><?php echo number_format($i['otCost'], 2); ?></td>
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