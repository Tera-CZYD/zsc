<body style="border: 1px solid #ccc">
<?php $output='';?>
    
    <?php
      $output .='
        <table class="table" bordered="1">
          <tr class="bg-info">
            <th class="text-center">#</th>
            <th class="text-center">LIBRARY ID</th>   
            <th class="text-center">MEMBER NAME</th> 
            <th class="text-center">MEMBER TYPE</th> 
            <th class="text-center">TEACHING STAFF</th>  
            <th class="text-center">FACULTY STATUS</th>
            <th class="text-center">DATE</th>                       
          </tr>
            ';
        $ctr = 0;
        if(!empty($datas)){

          foreach ($datas as $key => $bill) { 
            $ctr +=1;
            $output .='
              <tr>
                <td>'.$ctr.'</td>
                <td>'.$bill['library_id_number'].'</td>
                <td>'.$bill['member_name'].'</td>
                <td>'.$bill['member_type'].'</td>
                <td>'.$bill['teaching_staff'].'</td>
                <td>'.$bill['faculty_status'].'</td>
                <td>'.$bill['date'].'</td>
              </tr>
            ';

          }

        }

        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition:attachment;filename=Faculty Member.xls");
        echo $output;
    ?>
  </body>
    
