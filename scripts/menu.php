<?php


function writeMenu(){

  echo("<!-- Nav -->");
  echo("  <nav id='menu'>");
  echo("    <ul class='links'>");
  echo("      <li><a href='index.php'>Home</a></li>");
  echo("      <li><a href='pages/projects.php'>Projects</a></li>");
  echo("      <li><a href='pages/selectWindchillXML.php'>Import XML</a></li>");
  echo("      <li><a href='pages/partDetails.php'>Part Details</a></li>");
  echo("      <li><a href='selectProductionOrder.php'>View Production Order</a>");
  echo("      <li><a href='newProductionOrder.php'>New Production Order</a>");
//echo("      <li><a href='planning.php'>Planning</a></li>");
  echo("      <li><a href='pages/statistics.php'>Statistics</a></li>");
  echo("      <li><a href='pages/traceability.php'>Traceability</a></li>");
  echo("    </ul>");
  echo("  </nav>");
}


?>
