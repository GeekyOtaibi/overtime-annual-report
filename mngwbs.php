<?php $title= "Managing WBS"; include('header.php'); ?>

<?php
if(!isset($_SESSION['admin']) || $_SESSION['admin']==0){
    header("location:error.php");
}
?>
<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
    include ('connection-db.php');
    $query="Select * from wbs where code='$id'";
    $result=  mysqli_query($con, $query);
    $row=mysqli_fetch_assoc($result);
}
?>
 <?php
        if(isset($_POST['add']))
        {

            $name =$_POST['project-name'];
            $code =$_POST['wbs-code'];
            $budget =$_POST['budget'];
            
            include('connection-db.php');
            $query="INSERT INTO `wbs`( `name`, `code`, `budget`, `withdrew`, `remainder`) VALUES ('$name','$code','$budget','0','$budget')" ;
            $result=mysqli_query($con,$query);
            
              if($result==1)
            {
                header("location:mngwbs.php?status=1");//this message is for correct inset command 
            }
            else {
                header("location:mngwbs.php?status=0");//this message is for incorrect inset command
            }
            
        }
            ?>
 <?php
        if(isset($_POST['update']))
        {

            $name =$_POST['project-name'];
            $code =$_POST['wbs-code'];
            $budget =$_POST['budget'];
            
            include('connection-db.php');
            $query="UPDATE `wbs` SET `name`='$name',`budget`=$budget,`remainder`=($budget - withdrew) where code='$code' and withdrew < $budget;" ;
            $result=mysqli_query($con,$query);
              if($result==1)
            {
                header("location:mngwbs.php?status=1");//this message is for correct inset command 
            }
            else {
                header("location:mngwbs.php?status=0");//this message is for incorrect inset command
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
        <h5>Managing WBS</h5>
      </div>
      <div class='panel-body'>
          <form autocomplete="off" class='form-horizontal' action="mngwbs.php" name="update" method="get" role='form'>
        <div class="form-group">
        <label class='control-label col-md-2 col-md-offset-3' for='wbs-code'>Enter WBS Code</label>
            <div class='col-md-6'>
              <div class='col-md-6'>
                <div class='form-group internal'>
                    <input  required class='form-control' id='id' name="id" required >
                </div>
              </div>
            <button class="btn-sm btn-primary col-sm-offset-1">check Update</button>
        </div>
      </div>
      </form><legend></legend>
          <form autocomplete="off" class='form-horizontal' role='form' method="POST" name="add" value="mngwbs" action="mngwbs.php">
            
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='project-name'>Project's Name</label>
            <div class='col-md-8'>
              <div class='col-md-5 indent-small'>
                <div class='form-group internal'>
                    <input class='form-control' id='project-name' type='text' name="project-name" value="<?php if(!empty($row['name'])){echo $row['name'];} ?>">
                </div>
              </div>
                
            <label class='control-label col-md-2' for='employee-grade'>WBS Code</label>
              <div class='col-md-3 indent-small'>
                <div class='form-group internal'>
                    <input class='form-control' id='wbs-code' type='text' name="wbs-code" value="<?php if(!empty($row['code'])){echo $row['code'];} ?>">
                </div>
              </div>
            </div>
          </div>
        <!--_________________________________________________________________-->
       <div class='form-group'>
         <label class='control-label col-md-1 col-md-offset-3' for='budget'>Budget</label>
            <div class='col-md-8'>
              <div class='col-md-3'>
                <div class='form-group internal'>
                  <input class='form-control' type="number" id='budget' name="budget" value="<?php if(!empty($row['budget'])){echo $row['budget'];} ?>">
                   
                </div>
              </div>
            </div>
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
       $query="Select * from wbs ;";
       $result=  mysqli_query($con, $query);
       $user=array();
       while($row=  mysqli_fetch_assoc($result)){
           $user[$row['ID']]=array("ID"=>$row['ID'],
                   "name"=>$row['name'],
                   "code"=>$row['code'],
                   "budget"=>$row['budget'],
                   "withdrew"=>$row['withdrew'],
                   "remainder"=>$row['remainder']                   );
        }
?>
      
    <div class='panel panel-default dialog-panel'>
      <div class='panel-heading'>
        <h5>WBS Table</h5>
      </div>
      <div class='panel-body'>
        <a href="#" id="test" onclick="javascript:fnExcelReport();">Download this Table</a>
        <table class="table" id="myTable">
          <thead>
              <tr>
                <th>Project's Name</th>
                <th>WBS Code</th>
                <th>Budget</th>
                <th>Total Withdrews</th>
                <th>Remainder</th>
              </tr>
          </thead>
          <tbody>
            <?php foreach($user as $i){ ?>
              <tr>
                <td><?php echo $i['name']; ?></td>
                <td><?php echo $i['code']; ?></td>
                <td><?php echo $i['budget']; ?></td>
                <td><?php echo $i['withdrew']; ?></td>
                <td><?php echo $i['remainder']; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

<?php include('footer.php') ?>