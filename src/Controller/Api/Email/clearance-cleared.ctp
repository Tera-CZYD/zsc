<?php
  
  include 'variable.php';

?>

<!DOCTYPE html>
<html>
<head>
  <title> STUDENT CLEARANCE </title>

  <style type="text/css">
    * {
     font-family: "Times New Roman";
    }
  </style>

</head>
<body>

  <h4>Hello Mr/Ms <strong><?php echo $_SESSION['name'];?></strong>, </h4>
  <h4>You are authorize to proceed to the next offices</h4>
  <table width="100%" style="border: 3px solid #ffe6f2; border-radius: 20px;">
  <tr>
    <td style="text-align: center;"><center><img src="<?php echo $logo;?>" height="200" width="200"></center></td>
  </tr>
  <tr>
    <td><center><h1 style="background-color:#ffe6f2; color:black;"> Clearance Status </h1></center></td>
  </tr>
  <tr>
    <td style="text-align: left;"><strong> FACULTY NAME :</strong><i> <?php echo $_SESSION['faculty'];?> </i></td>
  </tr>
  <tr>
    <td style="text-align: left;"><strong> STUDENT NAME :</strong><i> <?php echo $_SESSION['name'];?> </i></td>
  </tr>
  <tr>
    <td style="text-align: left;"><strong> STATUS :</strong><i> <?php echo $_SESSION['status'];?> </i></td>
  </tr>

</table>

  <br>Thank you! </h5>
  <br>Have a nice day. </h5>
</body>
</html>