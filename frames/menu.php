<html>
  <head>
    <title>Menu</title>
    <!--<link rel="stylesheet" href="../stylesheets/normalize.css">-->
    <link rel="stylesheet" href="../stylesheets/skeleton.css">
    <!--<link rel="stylesheet" href="../stylesheets/fork-awesome.css">-->
    <link rel="stylesheet" href="../stylesheets/custom.css">
    <?php
      include("../scripts/database_connection.php");
      $conn = new mysqli($servername, $username, $password, $dbname);
    ?>

  </head>
  <body style="background-color: #F1F1FF">
    <div class='container'>
      <div class='row'>
        <div class='one column'>
          <a href="../selectXML.html" target="_parent">Import structure</a>
        </div>

        <div class='four columns'>
          <form action="../part_details.php" method="get" enctype="multipart/form-data" target="_parent">
            <input type="search" name="partNumber" placeholder="Part" list="partsList">
            <datalist id="partsList">
              <?php
              $query = "SELECT Number FROM XML_demo.Parts ORDER BY 'Number'";
              $result = $conn->query($query);
              if ($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                  $existingNumber = $row["Number"];
                  echo "<option value='" . $existingNumber . "'></option>";
                }
              }
              ?>
            </datalist>
            <input type="submit" value="?">
          </form>
        </div>

        <div class='four columns'>
          <form action="../productionOrder.php" method="get" enctype="multipart/form-data" target="_parent">
            <input type="search" name="productionOrdeNumber" placeholder="Production order" list="productionOrdersList">
            <datalist id="productionOrdersList">
              <?php
              // select parts where number contains 'P00' : SELECT Number FROM XML_demo.Parts WHERE Number LIKE '%P00%'
              $query = "SELECT Number FROM XML_demo.Parts WHERE Number LIKE '%P00%' ORDER BY 'Number'";
              $result = $conn->query($query);
              if ($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                  $existingNumber = $row["Number"];
                  echo "<option value='" . $existingNumber . "'></option>";
                }
              }
              ?>
            </datalist>
            <input type="submit" value="?">
          </form>
        </div>

        <div class='two columns'>
          <a href="../planning.html" target="_parent">Planning</a>
        </div>
      </div>
    </div>
  </body>
</html>
