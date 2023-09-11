<?php
  
  include 'variable.php';

?>

<!DOCTYPE html>
<html>
<head>
  <title> ADMISSION APPLICATION - UNQUALIFIED </title>

  <style type="text/css">
    * {
     font-family: "Times New Roman";
    }
  </style>

</head>
<body>
  <h4>Hello Mr/Ms <strong><?php echo $_SESSION['name'];?></strong>, </h4>
  <h5>Your admission application has been unqualified.</h5>
  <table width="100%" style="border: 3px solid #ffe6f2; border-radius: 20px;">
  <tr>
    <td style="text-align: center;"><center><img src="<?php echo $logo;?>" height="200" width="200"></center></td>
  </tr>
  <tr>
    <td><center><h1 style="background-color:#ffe6f2; color:black;"> Admission Application </h1></center></td>
  </tr>
  <tr>
    <td style="text-align: left;"><strong> APPLICATION NUMBER :</strong><i> <?php echo $_SESSION['application_no'];?> </i></td>
  </tr>
  <tr>
    <td style="text-align: left;"><strong> NAME :</strong><i> <?php echo $_SESSION['name'];?> </i></td>
  </tr>
  <tr>
    <td style="text-align: left;"><strong> STATUS : </strong><i> UNQUALIFIED </i></td>
  </tr>
  <tr>
    <td style="text-align: left;"><strong> REASON : </strong><i> <?php echo $_SESSION['disapproved_reason'];?> </i></td>
  </tr>
<!--   <tr>
    <td style="text-align: center;"><center><a href='<?php echo $url; ?>' target="_blank" style="padding: 8px 12px; background-color: #038C8C;border-radius: 2px;font-family: Helvetica, Arial, sans-serif;font-size: 14px; color:white;text-decoration: none;font-weight:bold;display: inline-block;">
    Click Here</center></td>
  </tr> -->
</table>
  Note:
  
  <br>The addressee solely is the intended recipient of this communication. It might include private or protected information. 
  <br>Any disclosure, copying, distribution, or action taken in reliance on this communication by someone who is not the intended recipient is unlawful and strictly forbidden. 
  <h5></h5>
  <br>Thank you! </h5>
  <br>Have a nice day. </h5>
</body>
</html>