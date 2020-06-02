</body>

    <script src="js/index.js"></script>
    <script src="js/moment.js"></script>
    <script src="node_modules/chart.js/dist/Chart.js"></script>
    <script src="node_modules/chart.js/dist/Chart.min.js"></script>
    <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <script src="bower_components/jquery/jquery.js"></script>
    <script>
        function goBack() { window.history.back(); }
        function fnExcelReport() {
            var filename = 'test.xls';
            var today = new Date().toLocaleDateString();
            <?php if(basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING'])=='mngusers.php'){ ?>
            filename = 'UserTable_'+today+'.xls';
            <?php } ?>
            <?php if(basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING'])=='workassignment.php'){ ?>
            filename = 'WorkAssignmentTable_'+today+'.xls';
            <?php } ?>
            <?php if(basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING'])=='overtime.php'){ ?>
            filename = 'OverTimeTable_'+today+'.xls';
            <?php } ?>
    var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';

    tab_text = tab_text + '<x:Name>Sheet</x:Name>';

    tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
    tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';

    tab_text = tab_text + "<table border='1px'>";
    tab_text = tab_text + $('#myTable').html();
    tab_text = tab_text + '</table></body></html>';

    var data_type = 'data:application/vnd.ms-excel';
    
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");
    
    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
        if (window.navigator.msSaveBlob) {
            var blob = new Blob([tab_text], {
                type: "application/csv;charset=utf-8;"
            });
            navigator.msSaveBlob(blob, filename);
        }
    } else {
        $('#test').attr('href', data_type + ', ' + encodeURIComponent(tab_text));
        $('#test').attr('download', filename);
    }

}
        
        $(document).ready(function(){
            
            $(".readonly").keydown(function(e){ e.preventDefault(); });
            
            $('#basic-salary').keyup(function() {
                var perhour = ( $('#basic-salary').val() * 12 ) / 2160;
                var extra = perhour * 1.5;
                
                $('#pay-per-hour').val(perhour);
                $('#extra-pay').val(extra);
            });
            
            $('#end-date,#start-date,#wa-type').change(waCostFunc);
            $('#ticket-cost').keyup(waCostFunc);
            function waCostFunc(){
                  var date1 = $('#start-date').val();
                  var date2 = $('#end-date').val();
                  var ticket = $('#ticket-cost').val();
                  document.getElementById('start-date').style="border:1px solid #aaaaaa";
                  document.getElementById('end-date').style="border:1px solid #aaaaaa";
                  document.getElementById('wa-type').style="border:1px solid #aaaaaa";
                  if(date1 != "" && date2 != ""){
                  //Get 1 day in milliseconds
                  var one_day=1000*60*60*24;
                  // Convert both dates to milliseconds
                  var date1Parts = new Date((Number(date1.split("-")[0])), (Number(date1.split("-")[1]) - 1), (Number(date1.split("-")[2])));
                  var date1_ms = date1Parts.getTime();
                  var date2Parts = new Date((Number(date2.split("-")[0])), (Number(date2.split("-")[1]) - 1), (Number(date2.split("-")[2])));
                  var date2_ms = date2Parts.getTime();

                  // Calculate the difference in milliseconds
                  if(date2_ms >= date1_ms){
                  var difference_ms = date2_ms - date1_ms;
                  // Convert back to days and return
                  var result = Math.round(difference_ms/one_day) + 1;
                  $('#days').val(result);
                      
                  var waType = $('#wa-type').val();
                  if(waType != null){
                  waType = waType * 1; // convert string to integer
                  ticket = ticket * 1;
                  var waCost = result * waType;
                      if(waType==1000){waCost += 400;}
                  waCost += ticket;
                  $('#wa-cost').val(waCost);
                      }
                      else{
                          document.getElementById('wa-type').style="border:1px solid #ff0000";
                      }
                      
                    }
                      else{
                        document.getElementById('start-date').style="border:1px solid #ff0000";
                        document.getElementById('end-date').style="border:1px solid #ff0000";
                      }
                  }
            }
            
            $('#end-time,#start-time,#attend-type').change(function(){
                var time1 = $('#start-time').val();
                var time2 = $('#end-time').val();
                document.getElementById('attend-type').style="border:1px solid #aaaaaa";
                if(time1.includes(':') && time2.includes(':')){
                var time1_tmp = time1.split(':');
                var time1_h = time1_tmp[0] * 1;
                var time1_m = time1_tmp[1] * 1;
                var time2_tmp = time2.split(':');
                var time2_h = time2_tmp[0] * 1;
                var time2_m = time2_tmp[1] * 1;     if(time2_h <= time1_h){time2_h+=24;}
                var diff = time2_h - time1_h;
                diff=diff + (time2_m - time1_m)/60 ;    if(diff > 24){diff-=24;}
                $('#hours').val(diff);
                var activity = $('#attend-type').val();

                  if(activity == "Regular" ){
                      var otCost = $('#span-per-hour').val() * diff;
                          $('#ot-cost').val(otCost);
                    }
                  else if(activity == "Overtime" ){
                      var otCost = $('#span-extra-pay').val() * diff;
                          $('#ot-cost').val(otCost);
                    }
                  else{
                      document.getElementById('attend-type').style="border:1px solid #ff0000";
                    }
                      
                  }
                  
                
            });
        
            var regularH = []; var overtimeH = []; var regularC = []; var overtimeC = []; var tmp;
            for (var i = 1; i <= 12; i++) {
                tmp = $("#regularH"+i).val();
                regularH.push(tmp);
                tmp = $("#regularC"+i).val();
                regularC.push(tmp);
                tmp = $("#overtimeH"+i).val();
                overtimeH.push(tmp);
                tmp = $("#overtimeC"+i).val();
                overtimeC.push(tmp);
            }
            var ctx = document.getElementById("chartH").getContext('2d');
            var chartH = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                label: 'Regular Time (H)',
                backgroundColor: '#00cc44',
                data: regularH,
                borderWidth: 1
            },
            {
                label: 'Overtime (H)',
                backgroundColor: '#cccc00',
                data: overtimeH,
                borderWidth: 1
            }]
    }
});
            
            var ctx = document.getElementById("chartCost").getContext('2d');
            var chartCost = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
            label: 'Regular Time - Costs',
            backgroundColor: '#00cc44',
            data: regularC,
            borderWidth: 1
        },
        {
            label: 'Overtime - Costs',
            backgroundColor: '#cccc00',
            data: overtimeC,
            borderWidth: 1
        }]
    }
});
        });
    </script>

</body>
</html>
