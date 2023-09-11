<body style="border: 1px solid #ccc; background-color: white !important;">
<?php $output='';?>
    
    <?php
      $output .='
        <table class="table" bordered="1" style="background-color: white !important;">
          <tr class="bg-info">
            <th class="text-center">#</th>
            <th class="text-center">CODE</th>   
            <th class="text-center">TITLE</th>   
            <th class="text-center">AUTHOR</th>
            <th class="text-center">MATERIAL TYPE</th> 
            <th class="text-center">COLLECTION TYPE</th>  
            <th class="text-center">DATE OF PUBLICATION</th>                   
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
                <td>'.$bill['material_type'].'</td>
                <td>'.$bill['collection_type'].'</td>
                <td>'.$bill['date_of_publication'].'</td>
              </tr>
            ';

          }

        }

        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition:attachment;filename=Bibliography.xls");
        echo $output;
    ?>
  </body>
    
