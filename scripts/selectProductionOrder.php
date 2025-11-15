<html>
  <head>
    <title>Select production order</title>
    <?php
      include("scripts/database_connection.php");
      $conn = new mysqli($servername, $username, $password, $dbname);
      $cgc_member_id=$_GET["cgc_member_id"];
    ?>
  </head>
  <body>
    <h1>Select Production Order</h1>

    <form action="part_details.php" method="post" enctype="multipart/form-data">
      <input type="search" name="productionOrderNumber" list="productionOrdersList">
      <datalist id="productionOrdersList">
        <?php
        // select parts where number contains 'P00' :
        // SELECT Number FROM XML_demo.Parts WHERE Number LIKE '%P00%'
        $query = "SELECT Number FROM XML_demo.Parts ORDER BY 'Number'";
        //echo $query . "<br>";
        $result = $conn->query($query);

        if ($result->num_rows > 0){
          // Loop all found versions
          while($row = $result->fetch_assoc()){
            $existingNumber = $row["Number"];
            echo "<option value='" . $existingNumber . "'></option>";
          }
        }


        ?>

      </datalist>
      <input type="submit" name="selectPartnumber" value="selectPartnumber">
    </form>

  </body>
</html>
