<?php require 'config.php'; ?>
<table border = 1>
  <tr>
    <td>#</td>
    <td>Report ID</td>
    <td>Problem</td>
    <td>Rating</td>
    <td>Feedback</td>
  </tr>
  <?php
  $i = 1;
  $rows = mysqli_query($conn, "SELECT * FROM reportdetails");
  foreach($rows as $row) :
  ?>
  <tr>
    <td> <?php echo $i++; ?> </td>
    <td> <?php echo $row["report_id"]; ?> </td>
    <td> <?php echo $row["problem"]; ?> </td>
    <td> <?php echo $row["rating"]; ?> </td>
    <td> <?php echo $row["feedback"]; ?> </td>
  </tr>
  <?php endforeach; ?>
</table>