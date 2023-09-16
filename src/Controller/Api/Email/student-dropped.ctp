<?php
  
  include 'variable.php';

?>

<!DOCTYPE html>
<html>
<head>
  <title> DROPPED STUDENT </title>

  <style type="text/css">
    * {
     font-family: "Times New Roman";
    }
  </style>

</head>
<body>
  <h4>Hello Mr/Ms <strong><?php echo $_SESSION['name'];?></strong>, </h4>
  <h5>This is to notify you that you have already 5 absences it your class <?php echo $_SESSION['course'];?> and is now dropped.</h5>
  <table width="100%" style="border: 3px solid #ffe6f2; border-radius: 20px;">
  <tr>
    <td style="text-align: center;"><center><img src="<?php echo $logo;?>" height="200" width="200"></center></td>
  </tr>
  <tr>
    <td><center><h1 style="background-color:#ffe6f2; color:black;"> STUDENT STATUS </h1></center></td>
  </tr>
  <tr>
    <td style="text-align: left;"><strong> STUDENT NAME :</strong><i> <?php echo $_SESSION['name'];?> </i></td>
  </tr>
  <tr>
    <td style="text-align: left;"><strong> COURSE : </strong><i> <?php echo $_SESSION['course'];?> </i></td>
  </tr>
  <tr>
    <td style="text-align: left;"><strong> FACULTY NAME :</strong><i> <?php echo $_SESSION['faculty'];?> </i></td>
  </tr>
</table>
</body>
</html>