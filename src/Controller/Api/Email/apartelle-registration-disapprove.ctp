<?php
  
  include 'variable.php';

?>

<!DOCTYPE html>
<html>
<head>
  <title> APARTELLE APPLICATION - DISAPPROVED </title>

  <style type="text/css">
    * {
     font-family: "Times New Roman";
    }
  </style>

</head>
<body>
  <h4>Hello Mr/Ms <strong><?php echo $_SESSION['name'];?></strong>, </h4>
  <h5>Your apartelle/dormitory application has been disapproved.</h5>
  <table width="100%" style="border: 3px solid #ffe6f2; border-radius: 20px;">
  <tr>
    <td style="text-align: center;"><center><img src="<?php echo $logo;?>" height="200" width="200"></center></td>
  </tr>
  <tr>
    <td><center><h1 style="background-color:#ffe6f2; color:black;"> Apartelle Application </h1></center></td>
  </tr>
  <tr>
    <td style="text-align: left;"><strong> CONTROL NO. :</strong><i> <?php echo $_SESSION['code'];?> </i></td>
  </tr>
  <tr>
    <td style="text-align: left;"><strong> STUDENT NUMBER :</strong><i> <?php echo $_SESSION['student_no'];?> </i></td>
  </tr>
  <tr>
    <td style="text-align: left;"><strong> STUDENT NAME :</strong><i> <?php echo $_SESSION['name'];?> </i></td>
  </tr>
  <tr>
    <td style="text-align: left;"><strong> STATUS : </strong><i> DISAPPROVED </i></td>
  </tr>
  <tr>
    <td style="text-align: center;font-family:'Poppins';"><center><a href='<?php echo $url; ?>apartelle-registration/view/<?php echo $_SESSION['id']; ?>'. target="_blank" style="padding: 8px 12px; background-color: #038C8C;border-radius: 2px;font-family: Helvetica, Arial, sans-serif;font-size: 14px; color:white;text-decoration: none;font-weight:bold;display: inline-block;">
    Click Here</center></td>
  </tr>
</table>
</body>
</html>