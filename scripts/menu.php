<?php


function writeMenu(){

  echo("<!-- Nav -->");
  echo("  <nav id='menu'>");
  echo("    <ul class='links'>");
  echo("      <li><a href='index.php'>Home</a></li>");
  echo("      <p>Parts</p>");
  echo("      <li><a href='importWindchillXML.php'>Import XML</a></li>");
  echo("      <li><a href='partDetails.php'>Part Details</a></li>");
//echo("      <li><a href='selectPart.html'>Parts</a>");
  echo("      <p>Production</p>");
  echo("      <li><a href='selectProductionOrder.php'>View Production Order</a>");
  echo("      <li><a href='newProductionOrder.php'>New Production Order</a>");
  echo("      <li><a href='planning.php'>Planning</a></li>");
  echo("      <li><a href='generic.html'>Generic</a></li>");
  echo("      <li><a href='elements.html'>Elements</a></li>");
  echo("      <li><a href='pages/statistics.php'>Statistics</a></li>");
  echo("    </ul>");
  echo("  </nav>");
}


?>
