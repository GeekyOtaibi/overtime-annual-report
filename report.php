<?php $title= "Report"; include('header.php'); ?>
<?php if(!isset($_GET['year'])){ header("location:report.php?year=".date("Y")."&wbs=all"); }?>

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

    function filterOT($m,$attend,$datatype){
        $nextm = $m + 1; if($nextm == 13){$nextm = 1;}
        $y = $_GET['year'];
        if($_GET['wbs'] == "all"){
            $wbs = " AND 1=1";
        }
        else{
            $wbs = " AND wbsCode = '".$_GET['wbs']."'";
        }
        $from_date = date("Y-m-d",strtotime($m.'/1/'.$y));
        $to_date = date("Y-m-d",strtotime($nextm.'/1/'.$y));
        $query = "SELECT ID, $datatype FROM overtime WHERE attType = '".$attend."' AND startDate >= '".$from_date."' AND startDate < '".$to_date."'".$wbs;
        include ('connection-db.php');
        $result= mysqli_query($con,$query);
        $record=array();
        while($row=  mysqli_fetch_assoc($result)){
        $record[$row['ID']]=array("$datatype"=>$row["$datatype"]);
        }
        $total = 0;
        foreach($record as $i){
            $total += $i["$datatype"];
        }
        return $total;
    }

    function filterWA($m){
        $nextm = $m + 1; if($nextm == 13){$nextm = 1;}
        $y = $_GET['year'];
        if($_GET['wbs'] == "all"){
            $wbs = "AND 1=1";
        }
        else{
            $wbs = " AND wbsCode = '".$_GET['wbs']."'";
        }
        $from_date = date("Y-m-d",strtotime($m.'/1/'.$y));
        $to_date = date("Y-m-d",strtotime($nextm.'/1/'.$y));
        $query = "SELECT ID, waCost FROM work_assign WHERE startDate >= '".$from_date."' AND startDate < '".$to_date."'".$wbs;
        include ('connection-db.php');
        $result= mysqli_query($con,$query);
        $record=array();
        while($row=  mysqli_fetch_assoc($result)){
        $record[$row['ID']]=array("waCost"=>$row["waCost"]);
        }
        $total = 0;
        foreach($record as $i){
            $total += $i["waCost"];
        }
        return $total;
    }

?>

<div class='container'>
  <div class="panel panel-default dialog-panel">
    <div class='panel-heading'>
        <h5 style="display:inline">Report in Year of </h5>
        <select id='year-selector' name='year-selector' onchange="javascript:location.href = this.value;">
            <script language="javascript" type="text/javascript"> 
               function filteryear(y){
                var url = "report.php?year="+y+"&wbs=<?php echo $_GET['wbs']; ?>"
                return url;
            }
            for(var d=2017;d<=2199;d++)
            {
                if(d == <?php echo $_GET['year']; ?>){
                document.write("<option selected value='"+filteryear(d)+"'>"+d+"</option>");
                    }
                else{
                document.write("<option value='"+filteryear(d)+"'>"+d+"</option>");
                }
            }
            </script>
        </select>
        <h5 style="display:inline"> Filter WBS by </h5>
        
        <script>function filterwbs(w){
                var url = "report.php?year=<?php echo $_GET['year']; ?>"+w;
                location.href = url;
            }
        </script>
        
        <select id='wbs-code' name="wbs-code" onchange="filterwbs(this.value)">
            <option value="&wbs=all" selected>All</option>
                <?php foreach($code as $i){
                        if($i['code'] == $_GET['wbs']){ ?>
                            <option selected value="&wbs=<?php echo $i['code']; ?>"><?php echo $i['code']; ?></option>
                <?php   }else{ ?>
                            <option value="&wbs=<?php echo $i['code']; ?>"><?php echo $i['code']; ?></option>
                <?php }} ?>
        </select>
    </div>
    <div class="panel-body">
    <button class='btn-sm btn-success' onclick="window.print();" style="width:150px;">Print Report</button>
    <form class='form-horizontal' action="report.php">
        <legend align="center">Monthly OT Used (H)</legend>
    <table class="table">
      <thead>
        <tr>
        <th>
        </th>
        <th>Jan</th><th>Feb</th><th>Mar</th><th>Apr</th><th>May</th><th>Jun</th>
        <th>Jul</th><th>Aug</th><th>Sep</th><th>Oct</th><th>Nov</th><th>Dec</th>
        </tr>
      </thead>
      <tbody>
          <tr>
              <td>Regular Time (H)</td>
              <?php for( $i = 1; $i<=12; $i++){
                $tmp= filterOT($i,'Regular','hours');
                echo "<td>".number_format($tmp, 2)."</td>";
                echo "<input hidden id='regularH$i' value='$tmp'>";
              } ?>
          </tr>
          <tr>
              <td>Over Time (H)</td>
              <?php for( $i = 1; $i<=12; $i++){
                $tmp= filterOT($i,'Overtime','hours');
                echo "<td>".number_format($tmp, 2)."</td>";
                echo "<input hidden id='overtimeH$i' value='$tmp'>";
              } ?>
          </tr>
      </tbody>
    </table>
        <legend align="center">Monthly Cost (SAR)</legend>
        <table class="table">
      <thead>
        <tr>
        <th>
        </th>
        <th>Jan</th><th>Feb</th><th>Mar</th><th>Apr</th><th>May</th><th>Jun</th>
        <th>Jul</th><th>Aug</th><th>Sep</th><th>Oct</th><th>Nov</th><th>Dec</th>
        </tr>
      </thead>
      <tbody>
          <tr>
              <td>Regular Time - Cost</td>
              <?php for( $i = 1; $i<=12; $i++){
                $tmp= filterOT($i,'Regular','otCost');
                echo "<td>".number_format($tmp, 2)."</td>";
                echo "<input hidden id='regularC$i' value='$tmp'>";
              } ?>
          </tr>
          <tr>
              <td>Over Time - Cost</td>
              <?php for( $i = 1; $i<=12; $i++){
                $tmp= filterOT($i,'Overtime','otCost');
                echo "<td>".number_format($tmp, 2)."</td>";
                echo "<input hidden id='overtimeC$i' value='$tmp'>";
              } ?>
          </tr>
          <tr>
              <td>WA - Cost</td>
              <?php for( $i = 1; $i<=12; $i++){
                $tmp= filterWA($i);
                echo "<td>".number_format($tmp, 2)."</td>";
                echo "<input hidden id='waC$i' value='$tmp'>";
              } ?>
          </tr>
      </tbody>
    </table>
        <legend></legend>
        <div style="width:48%;float:left;">
            <canvas id="chartH" width="400" height="400"></canvas>
        </div>
        <div style="width:48%;float:right;">
            <canvas id="chartCost" width="400" height="400"></canvas>
        </div>
    </form>
  </div>
</div>
    
    <?php include('footer.php'); ?>