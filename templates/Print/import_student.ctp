<html>

 <head>

  <title>IMPORT DTR</title>
  <!-- Bootstrap -->
  <link href="<?php echo $this->base ?>/assets/css/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="<?php echo $this->base ?>/assets/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">

  <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

  <style>

    body{

      margin:0;

      padding:0;

      background-color:#f1f1f1;
    }
    
    .box{
    
      width:100%;
    
      border:1px solid #ccc;
    
      background-color:#fff;
    
      border-radius:5px;
    
      margin-top:20px;
    
      margin-left:20px;
    
      margin-right:20px;

      padding: 20px

    }

  </style>
 </head>
 <body>

  <div class="box">
    <form method="post" enctype="multipart/form-data">

      <div class="card" style="margin-bottom: 20px">
        <div class="card-body">
          <h4 class="header-title">Upload Student Information</h4>
        </div>
      </div>
      <div class="card" style="margin-bottom: 20px">
        <div class="card-body">
          <h5 class="header-title">Download Student Information Template</h5>
          <div class="clearfix"></div><hr>
          <h6> Please remove the header and sample content before making an upload. <button type="button" class="btn btn-warning btn-min" onclick="ExportToExcel('xls')"><i class="fa fa-download"></i> Click here to download the template. </button> </h6>
          <div style="background-color: #337ab7;color: white;padding: 10px">
            <h6 class="header-title"><b><i>Legend for monthly income:</i></b></h6>
            <h6 class="header-title"><b>1</b> - P 11,000.00 - P 14,000.00</h6>
            <h6 class="header-title"><b>2</b> - P 15,000.00 - P 20,000.00</h6>
            <h6 class="header-title"><b>3</b> - P 21,000.00 - P 30,000.00</h6>
            <h6 class="header-title"><b>4</b> - P 31,000.00 - P 49,000.00</h6>
            <h6 class="header-title"><b>5</b> - Exceeding P 50,000.00 </h6>


            <h6 class="header-title"><b><i>Student Degree:</i></b></h6>
            <h6 class="header-title"><b>1</b> - Baccalaureate</h6>

            <h6 class="header-title"><b><i>Gender:</i></b></h6>
            <h6 class="header-title"><b>MALE</b> - MALE</h6>
            <h6 class="header-title"><b>FEMALE</b> - FEMALE</h6>
            <br>
            <h6 class="header-title"><b>NOTE : </b></h6>
            <h6 class="header-title">File format should be xlsx/xls. Use spreadsheet application for opening the template. </h6>
            <h6 class="header-title">Date format for date of birth : yyyy-mm-dd</h6>

          </div>
        </div>
      </div>
      <div class="card" style="margin-bottom: 20px">
        <div class="card-body">
          <label>Select Excel File</label>
          <input type="file" name="excel"/>
          <br/>
          <!-- <input type="submit" name="import" class="btn btn-info" value="Import" /> -->
          <div class="mt-3">
            <button type="submit" class="btn btn-primary btn-min" name="import"><i class="fa fa-upload"></i> Import </button>
            <button type="submit" class="btn btn-info btn-min" name="show"><i class="fa fa-eye"></i> Display File List </button>
          </div>
        </div>
      </div>


      <div class="card">
        <div class="card-body">
          <h4 class="header-title">Upload Student Information</h4>
        </div>
      </div>
    </form>
    <?php

      App::Import('ConnectionManager');

      $ds = ConnectionManager::getDataSource('default');

      $dsc = $ds->config;

      $connect = mysqli_connect($dsc['host'], $dsc['login'],$dsc['password'],$dsc['database']);

      $output = '';

      if(isset($_POST["import"])){

        $tmp = explode('.', $_FILES["excel"]["name"]);

        $extension = end($tmp);

        $allowed_extension = array("xls", "xlsx", "csv");

        if(in_array($extension, $allowed_extension)){

          $file = $_FILES["excel"]["tmp_name"];

          include("PHPExcel-1.8/Classes/PHPExcel/IOFactory.php");

          $objPHPExcel = PHPExcel_IOFactory::load($file);
       
          $output .= "<label class='text-success'>Data Inserted</label><br />

          <div style='width:100%; height:100%; overflow-y:auto;'>

          <table class='table table-bordered'> 
            <th class='text-center'>#</th>
            <th class='text-center'>STUDENT NO.</th>
            <th class='text-center'>FIRST NAME</th>
            <th class='text-center'>LAST NAME</th>
            <th class='text-center'>MIDDLE NAME</th>
            <th class='text-center'>COLLEGE ID</th>
            <th class='text-center'>GENDER</th>
            <th class='text-center'>DATE OF BIRTH</th>
            <th class='text-center'>HOUSE NO.</th>
            <th class='text-center'>BARANGAY</th>
            <th class='text-center'>TOWN/CITY</th>
            <th class='text-center'>ZIPCODE</th>
            <th class='text-center'>PROVINCE</th>
            <th class='text-center'>INCOME</th>
            <th class='text-center'>DEGREE</th>
            <th class='text-center'>EMAIL</th>
            <th class='text-center'>CONTACT NO.</th>

          ";

          foreach ($objPHPExcel->getWorksheetIterator() as $key => $worksheet){

            $worksheetTitle = $worksheet->getTitle();

            $highestColumn = $worksheet->getHighestColumn();

            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

            // expects same number of row records for all columns

            $highestRow = $worksheet->getHighestRow();

            if ($worksheetTitle == 'student') {

              $highestRow = $worksheet->getHighestRow();

              for($row = 1;$row <= $highestRow;$row++){

                $student_no = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue());

                $first_name = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2,$row)->getValue());

                $last_name = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3,$row)->getValue());

                $middle_name = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(4,$row)->getValue());

                $college_id = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(5,$row)->getValue());

                $gender = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(6,$row)->getValue());

                $date_of_birth = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(7,$row)->getValue());

                $house_no = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(8,$row)->getValue());

                $barangay = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(9,$row)->getValue());

                $town = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(10,$row)->getValue());

                $zip_code = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(11,$row)->getValue());

                $province = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(12,$row)->getValue());

                $income_id = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(13,$row)->getValue());

                $degree_id = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(14,$row)->getValue());

                $email = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(15,$row)->getValue());

                $contact_no = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(16,$row)->getValue());

                $cdate = date("Y-m-d h:i:s A");

                $date = date("Y-m-d");

                $output .= "<tr>";

                $query = "INSERT INTO student_applicants(

                    code,

                    date,

                    first_name,

                    last_name,

                    middle_name,

                    college_id,

                    gender,

                    date_of_birth,

                    house_no,

                    barangay,

                    town,

                    zip_code,

                    province,

                    income_id,

                    degree_id,

                    email,

                    contact_no,

                    created,

                    modified

                  ) VALUES 

                  (

                    '".$student_no."',

                    '".$date."',

                    '".$first_name."',

                    '".$last_name."',

                    '".$middle_name."',

                    '".$college_id."',

                    '".$gender."',

                    '".$date_of_birth."',

                    '".$house_no."',

                    '".$barangay."',

                    '".$town."',

                    '".$zip_code."',

                    '".$province."',

                    '".$income_id."',

                    '".$degree_id."',

                    '".$email."',

                    '".$contact_no."',

                    '".$cdate."',

                    '".$cdate."'

                  )

                ";

                $connect->query($query);

                $output .= '<td>'.($key + 1).'</td>';

                $output .= '<td>'.$student_no.'</td>';

                $output .= '<td>'.$first_name.'</td>';

                $output .= '<td>'.$last_name.'</td>';

                $output .= '<td>'.$middle_name.'</td>';

                $output .= '<td>'.$college_id.'</td>';

                $output .= '<td>'.$gender.'</td>';

                $output .= '<td>'.$date_of_birth.'</td>';

                $output .= '<td>'.$house_no.'</td>';

                $output .= '<td>'.$barangay.'</td>';

                $output .= '<td>'.$town.'</td>';

                $output .= '<td>'.$zip_code.'</td>';

                $output .= '<td>'.$province.'</td>';

                $output .= '<td>'.$income_id.'</td>';

                $output .= '<td>'.$degree_id.'</td>';

                $output .= '<td>'.$email.'</td>';

                $output .= '<td>'.$contact_no.'</td>';

                $output .= '</tr>';

              }

            }

          }

        }else{

          $output = '<label class="text-danger">Invalid File</label>'; //if non excel file then

        }

      }

    ?>
   <br>

   <?php

    echo $output;

   ?>

  </div>
  <table class="table" bordered="1" id = "tbl_exporttable_to_xls" hidden="">
    <tr>
      <th class="text-center">#</th>
      <th class="text-center">STUDENT NO.</th>
      <th class="text-center">FIRST NAME</th>
      <th class="text-center">LAST NAME</th>
      <th class="text-center">MIDDLE NAME</th>
      <th class="text-center">COLLEGE ID</th>
      <th class="text-center">GENDER</th>
      <th class="text-center">DATE OF BIRTH</th>
      <th class="text-center">HOUSE NO.</th>
      <th class="text-center">BARANGAY</th>
      <th class="text-center">TOWN/CITY</th>
      <th class="text-center">ZIPCODE</th>
      <th class="text-center">PROVINCE</th>
      <th class="text-center">INCOME</th>
      <th class="text-center">DEGREE</th>
      <th class="text-center">EMAIL</th>
      <th class="text-center">CONTACT NO.</th>
    </tr>
    <tr>
      <th class="text-center">1</th>
      <th class="text-center">123456</th>
      <th class="text-center">JUAN</th>
      <th class="text-center">DELA CEUZ</th>
      <th class="text-center">DALISAY</th>
      <th class="text-center">1</th>
      <th class="text-center">MALE</th>
      <th class="text-center">1997-02-16</th>
      <th class="text-center">84</th>
      <th class="text-center">TONDO</th>
      <th class="text-center">MANILA</th>
      <th class="text-center">2300</th>
      <th class="text-center">MANILA</th>
      <th class="text-center">1</th>
      <th class="text-center">1</th>
      <th class="text-center">juandelacruz@gmail.com</th>
      <th class="text-center">09151449994</th>
    </tr>
  </table>
 </body>


<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script type="text/javascript">
   
  function ExportToExcel(type, fn, dl) {

    var elt = document.getElementById('tbl_exporttable_to_xls');

    var wb = XLSX.utils.table_to_book(elt, { sheet: "student" });

    return dl ? XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) : XLSX.writeFile(wb, fn || ('studentdatatemplate.' + (type || 'xls')));

  }

 </script>

</html>
