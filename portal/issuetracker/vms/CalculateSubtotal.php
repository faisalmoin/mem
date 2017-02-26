<?php

require_once("../db.txt");
$qty=$_REQUEST['qtyinput'];
$price=$_REQUEST['priceinput'];
 
echo $subtotal=$qty*$price;

 ?>


   