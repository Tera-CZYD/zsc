<?php
  
  include 'variable.php';

?>

<!DOCTYPE html>
<html>
<head>
  <title> EXAMINATION DETAILS </title>

  <style type="text/css">
    * {
     font-family: "Times New Roman";
    }
  </style>

</head>
<body>

  <h4>Hello Mr/Ms <strong><?php echo $_SESSION['name'];?></strong>, </h4>
  <h4>Below is the details for examination.</h4>
  <table width="100%" style="border: 3px solid #ffe6f2; border-radius: 20px;">
  <tr>
    <td style="text-align: center;"><center><img src="<?php echo $logo;?>" height="200" width="200"></center></td>
  </tr>
  <tr>
    <td><center><h1 style="background-color:#ffe6f2; color:black;"> Examination Details </h1></center></td>
  </tr>
  <tr>
    <td style="text-align: left;"><strong> NAME :</strong><i> <?php echo $_SESSION['name'];?> </i></td>
  </tr>
  <tr>
    <td style="text-align: left;"><strong> DATE :</strong><i> <?php echo $_SESSION['date'];?> </i></td>
  </tr>
  <tr>
    <td style="text-align: left;"><strong> TIME :</strong><i> <?php echo $_SESSION['time'];?> </i></td>
  </tr>
   <tr>
    <td style="text-align: left;"><strong> PLACE :</strong><i> <?php echo $_SESSION['place'];?> </i></td>
  </tr>
<!--   <tr>
    <td style="text-align: left;"><strong> ROOM :</strong><i> <?php echo $_SESSION['room'];?> </i></td>
  </tr> -->
  <tr>
    <td></td>
  </tr>
 
</table>
  
</body>
</html>