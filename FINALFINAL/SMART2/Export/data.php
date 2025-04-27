<?php require 'config.php'; ?>
<table border = 1>
  <tr>
    <td>#</td>
    <td>Report ID</td>
    <td>Name</td>
    <td>Location</td>
    <td>Problem</td>
    <td>Status</td>
    <td>Date Reported</td>
    <td>Date Resolved</td>
  </tr>
  <?php
  $i = 1;
  $rows = mysqli_query($conn, "SELECT * FROM reportdetails");
  foreach($rows as $row) :
  ?>
  <tr>
    <td> <?php echo $i++; ?> </td>
    <td> <?php echo $row["report_id"]; ?> </td>
    <td> <?php echo $row["rname"]; ?> </td>
    <td> <?php echo $row["plocation"]; ?> </td>
    <td> <?php echo $row["problem"]; ?> </td>
    <td> <?php echo $row["status"]; ?> </td>
    <td> <?php echo $row["date_reported"]; ?> </td>
    <td> <?php echo $row["date_resolved"]; ?> </td>
  </tr>
  <?php endforeach; ?>
</table>