<body style="border: 1px solid #ccc">
<?php $output='';?>
    
    <?php
      $output .='
        <table class="table" bordered="1">
          <tr class="bg-info">
            <th class="text-center">#</th>
            <th class="text-center">CODE</th>   
            <th class="text-center">TITLE</th>   
            <th class="text-center">AUTHOR</th>  
            <th class="text-center">QUANTITY</th>
          </tr>
            ';
        $ctr = 0;
        if(!empty($datas)){

          foreach ($datas as $key => $bill) { 
            $ctr +=1;
            $output .='
              <tr>
                <td>'.$ctr.'</td>
                <td>'.$bill['code'].'</td>
                <td>'.$bill['title'].'</td>
                <td>'.$bill['author'].'</td>
                <td>'.$ctr.'</td>
              </tr>
            ';

          }

        }

        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition:attachment;filename=Inventory Bibliography.xls");
        echo $output;
    ?>
  </body>
    
