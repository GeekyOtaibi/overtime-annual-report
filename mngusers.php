<?php $title= "Managing Users"; include('header.php');$readonly=false; // for initialization ?>

<?php
if(!isset($_SESSION['admin']) || $_SESSION['admin']==0){
    header("location:error.php");
}
?>
<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $readonly=TRUE;
    include ('connection-db.php');
    $query="Select * from employee where ID=$id";
    $result=  mysqli_query($con, $query);
    $row=mysqli_fetch_assoc($result);
}
?>
 <?php
        if(isset($_POST['add']))
        {

            $employeeid=$_POST['employee-id'];
            $employeename=$_POST['employee-name'];
            $grade=$_POST['employee-grade'];
            $orgcode=$_POST['org-code'];
            $basicsalery=$_POST['basic-salary'];
            $perh=$_POST['pay-per-hour'];
            $extrapay=$_POST['extra-pay'];
            
            include('connection-db.php');
            $query="INSERT INTO `employee`( `ID`, `name`, `grade`, `orgCode`, `baseSalary`, `perHour`, `extraPay`) VALUES ('$employeeid','$employeename','$grade','$orgcode','$basicsalery','$perh','$extrapay')" ;
            $result=mysqli_query($con,$query);
            
              if($result==1)
            {
                header("location:mngusers.php?status=1");//this message is for correct inset command 
            }
            else {
                header("location:mngusers.php?status=0");//this message is for incorrect inset command
            }
            
        }
            ?>
 <?php
        if(isset($_POST['update']))
        {

            $employeeid=$_POST['employee-id'];
            $employeename=$_POST['employee-name'];
            $grade=$_POST['employee-grade'];
            $orgcode=$_POST['org-code'];
            $basicsalery=$_POST['basic-salary'];
            $perh=$_POST['pay-per-hour'];
            $extrapay=$_POST['extra-pay'];
            
            include('connection-db.php');
            $query="UPDATE `employee` SET `name`='$employeename',`grade`='$grade',`orgCode`='$orgcode',`baseSalary`='$basicsalery',`perHour`='$perh',`extraPay`='$extrapay' WHERE ID='$employeeid'";
            $result=mysqli_query($con,$query);
            
              if($result==1)
            {
                header("location:mngusers.php?status=1");//this message is for correct inset command 
            }
            else {
                header("location:mngusers.php?status=0");//this message is for incorrect inset command
            }
            
        }
            ?>


    
  <div class='container'>
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
   

    <div class='panel panel-default dialog-panel'>
      <div class='panel-heading'>
        <h5>Managing Users</h5>
      </div>
      <div class='panel-body'>
          <form autocomplete="off" class='form-horizontal' action="mngusers.php" name="update" method="get" role='form'>
        <div class="form-group">
        <label class='control-label col-md-2 col-md-offset-3' for='employee-id'>Enter Employee's ID</label>
            <div class='col-md-6'>
              <div class='col-md-6'>
                <div class='form-group internal'>
                    <input  required class='form-control' id='employee-id' name="id" type='number' required >
                </div>
              </div>
            <button class="btn-sm btn-primary col-sm-offset-1">check Update</button>
        </div>
      </div>
      </form>
          <form autocomplete="off" class='form-horizontal' role='form' method="POST" name="add" value="mngusers" action="mngusers.php">
            
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='employee-id'>Employee's ID</label>
            <div class='col-md-8'>
              <div class='col-md-2'>
                <div class='form-group internal'>
                    <input  <?php if($readonly){ echo "readonly";}?> class='form-control' id='employee-id' type='number' name="employee-id" value="<?php if(!empty($row['ID'])){echo $row['ID'];} ?>">
                </div>
              </div>
            <label class='control-label col-md-1' for='employee-name'>Name</label>
              <div class='col-md-5 indent-small'>
                <div class='form-group internal'>
                    <input class='form-control' id='employee-name' type='text' name="employee-name" value="<?php if(!empty($row['name'])){echo $row['name'];} ?>">
                </div>
              </div>
                
            <label class='control-label col-md-1' for='employee-grade'>Grade</label>
              <div class='col-md-2 indent-small'>
                <div class='form-group internal'>
                    <select class='form-control' id='employee-grade' name="employee-grade" >
                    <option value="" selected disabled>Please select</option>
                    <option value="40" <?php if(isset($row['grade'])){ $row['grade']=="40" ? 'selected = "selected"' : '';}?>>40</option>
                    <option value="41" <?php if(isset($row['grade'])){ $row['grade']=="41" ? 'selected = "selected"' : '';}?>>41</option>
                    <option value="42" <?php if(isset($row['grade'])){ $row['grade']=="42" ? 'selected = "selected"' : '';}?>>42</option>
                    <option value="43" <?php if(isset($row['grade'])){ $row['grade']=="43" ? 'selected = "selected"' : '';}?>>43</option>
                    <option value="44" <?php if(isset($row['grade'])){ $row['grade']=="44" ? 'selected = "selected"' : '';}?>>44</option>
                    <option value="45" <?php if(isset($row['grade'])){ $row['grade']=="45" ? 'selected = "selected"' : '';}?>>45</option>
                    <option value="46" <?php if(isset($row['grade'])){ $row['grade']=="46" ? 'selected = "selected"' : '';}?>>46</option>
                    <option value="47" <?php if(isset($row['grade'])){ $row['grade']=="47" ? 'selected = "selected"' : '';}?>>47</option>
                    <option value="48" <?php if(isset($row['grade'])){ $row['grade']=="48" ? 'selected = "selected"' : '';}?>>48</option>
                    <option value="49" <?php if(isset($row['grade'])){ $row['grade']=="49" ? 'selected = "selected"' : '';}?>>49</option>
                    <option value="50" <?php if(isset($row['grade'])){ $row['grade']=="50" ? 'selected = "selected"' : '';}?>>50</option>
                    <option value="51" <?php if(isset($row['grade'])){ $row['grade']=="51" ? 'selected = "selected"' : '';}?>>51</option>
                    <option value="52" <?php if(isset($row['grade'])){ $row['grade']=="52" ? 'selected = "selected"' : '';}?>>52</option>
                    <option value="53" <?php if(isset($row['grade'])){ $row['grade']=="53" ? 'selected = "selected"' : '';}?>>53</option>
                    <option value="54" <?php if(isset($row['grade'])){ $row['grade']=="54" ? 'selected = "selected"' : '';}?>>54</option>
                    <option value="55" <?php if(isset($row['grade'])){ $row['grade']=="55" ? 'selected = "selected"' : '';}?>>55</option>
                    <option value="56" <?php if(isset($row['grade'])){ $row['grade']=="56" ? 'selected = "selected"' : '';}?>>56</option>
                    <option value="57" <?php if(isset($row['grade'])){ $row['grade']=="57" ? 'selected = "selected"' : '';}?>>57</option>
                    <option value="58" <?php if(isset($row['grade'])){ $row['grade']=="58" ? 'selected = "selected"' : '';}?>>58</option>
                    <option value="59" <?php if(isset($row['grade'])){ $row['grade']=="59" ? 'selected = "selected"' : '';}?>>59</option>
                    <option value="60" <?php if(isset($row['grade'])){ $row['grade']=="60" ? 'selected = "selected"' : '';}?>>60</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        <!--_________________________________________________________________-->
       <div class='form-group'>
         <label class='control-label col-md-2 col-md-offset-2' for='org-code'>Organization Code</label>
            <div class='col-md-8'>
              <div class='col-md-2'>
                <div class='form-group internal'>
                  <input class='form-control' id='org-code' name="org-code" value="<?php if(!empty($row['orgCode'])){echo $row['orgCode'];} ?>">
                   
                </div>
              </div>
            </div>
          </div> 
        <div class='form-group'>
         <label class='control-label col-md-2 col-md-offset-2' for='basic-salary'>Basic Salary</label>
            <div class='col-md-8'>
              <div class='col-md-2'>
                <div class='form-group internal'>
                    <input class='form-control' id='basic-salary' type='number' name="basic-salary" value="<?php if(!empty($row['baseSalary'])){echo $row['baseSalary'];} ?>">
                </div>
              </div>
            
            <label class='control-label col-md-3' for='pay-per-hour'>Pay per Hour</label>
              <div class='col-md-2 indent-small'>
                <div class='form-group internal'>
                    <input class='form-control' id='pay-per-hour' type='number' readonly name="pay-per-hour" value="<?php if(!empty($row['perHour'])){echo $row['perHour'];} ?>">
                </div>
              </div>
            <label class='control-label col-md-2' for='extra-pay'>Extra Pay</label>
              <div class='col-md-2 indent-small'>
                <div class='form-group internal'>
                    <input class='form-control' id='extra-pay' type='number' readonly name="extra-pay" value="<?php if(!empty($row['extraPay'])){echo $row['extraPay'];} ?>">
                </div>
              </div>
            </div>
        </div>
            <div>
            </div>
          <div class='form-group'><legend></legend>
            <div class='col-md-offset-1 col-md-1'>
              <button class='btn-lg btn-success' type='submit' method="POST" name="add">Submit</button>
            </div>
              <div class='col-md-offset-1 col-md-1'>
              <button class='btn-lg btn-primary' type='submit' method="POST" name="update" value="Update">Update</button>
            </div>
            <div class='col-md-offset-4 col-md-3'>
              <button class='btn-lg btn-danger' style='float:right' type='Reset'>Reset</button>
            </div>
          </div>
            
        </form>
      </div>
    </div>

      
<?php 
include ('connection-db.php');
       $query="Select * from employee ;";
       $result=  mysqli_query($con, $query);
       $user=array();
       while($row=  mysqli_fetch_assoc($result)){
           $user[$row['ID']]=array("ID"=>$row['ID'],
                   "name"=>$row['name'],
                   "grade"=>$row['grade'],
                   "orgCode"=>$row['orgCode'],
                   "baseSalary"=>$row['baseSalary'],
                   "perHour"=>$row['perHour'],
                   "extraPay"=>$row['extraPay']
                   );
        }
?>
      
    <div class='panel panel-default dialog-panel'>
      <div class='panel-heading'>
        <h5>Users Table</h5>
      </div>
      <div class='panel-body'>
        <a href="#" id="test" onclick="javascript:fnExcelReport();">Download this Table</a>
        <table class="table" id="myTable">
          <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Grade</th>
                <th>Org. Code</th>
              </tr>
          </thead>
          <tbody>
            <?php foreach($user as $i){ ?>
              <tr>
                <td><?php echo $i['ID']; ?></td>
                <td><?php echo $i['name']; ?></td>
                <td><?php echo $i['grade']; ?></td>
                <td><?php echo $i['orgCode']; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

<?php include('footer.php') ?>