<body style="border: 1px solid #ccc">
<?php $output='';?>
    
    <?php
      $output .='
        <table class="table" bordered="1">
          <tr class="bg-info">
            <th class="text-center">#</th>
            <th class="text-center">STUDENT NUMBER</th>   
            <th class="text-center">STUDENT NAME</th> 
            <th class="text-center">YEAR LEVEL</th> 
            <th class="text-center">COLLEGE</th>  
            <th class="text-center">PROGRAM</th>
            <th class="text-center">CONTACT NO.</th>
            <th class="text-center">EMAIL</th>                         
          </tr>
            ';
        $ctr = 0;
        if(!empty($datas)){

          foreach ($datas as $key => $bill) { 
            $ctr +=1;
            $output .='
              <tr>
                <td>'.$ctr.'</td>
                <td>'.$bill['student_no'].'</td>
                <td>'.$bill['full_name'].'</td>
                <td>'.$bill['year'].'</td>
                <td>'.$bill['college'].'</td>
                <td>'.$bill['program'].'</td>
                <td>'.$bill['contact_no'].'</td>
                <td>'.$bill['email'].'</td>
              </tr>
            ';

          }

        }

        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition:attachment;filename=Registered Students.xls");
        echo $output;
    ?>
  </body>
    
