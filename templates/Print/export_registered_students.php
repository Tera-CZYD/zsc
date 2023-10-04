<body style="border: 1px solid #ccc; background-color: white !important;">
<?php $output='';?>
    
    <?php
      $output .='
        <table class="table" bordered="1" style="background-color: white !important;">
          <tr class="bg-info">
            <th class="text-center">#</th>
            <th class="text-center">STUDENT NUMBER</th>   
            <th class="text-center">STUDENT NAME</th>   
            <th class="text-center">YEAR LEVEL</th>
            <th class="text-center">COLLEGE</th> 
            <th class="text-center">PROGRAM</th>  
            <th class="text-center">CONTACT NUMBER</th>
            <th class="text-center">EMAIL</th>                   
          </tr>
            ';
        $ctr = 0;
        if(!empty($datas)){

          foreach ($datas as $key => $data) { 
            $ctr +=1;
            $output .='
              <tr>
                <td>'.$ctr.'</td>
                <td>'.$data['student_no'].'</td>
                <td>'.$data['full_name'].'</td>
                <td>'.$data['year'].'</td>
                <td>'.$data['college'].'</td>
                <td>'.$data['program'].'</td>
                <td>'.$data['contact_no'].'</td>
                <td>'.$data['year'].'</td>
              </tr>
            ';

          }

        }

        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition:attachment;filename=StudentProfile.xls");
        echo $output;
    ?>
  </body>
    
