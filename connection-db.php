<?php
		
        $host="";
        $user="";
        $pwd="";
        $db="";
        
        $con=mysqli_connect($host,$user,$pwd,$db);
        
        if(mysqli_connect_errno($con))
        {
            echo mysqli_connect_error();
        }

?>