<!DOCTYPE html>
<html>
<head>
<title>cbwebshop admin area</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="page-topic" content="Folkadelic shop admin area">
<meta name="description" content="Folkadelic shop admin area">
<style type="text/css">
a:link { color: #24280F; text-decoration: none}
a:visited { color: #24280F; text-decoration: none}
a:hover { color: #999966; text-decoration: none }
ul { width: 180px; }
li { list-style: none; width: 180px; }
<?php 
  if ($settings == "hide") echo "li.settings { display: none; }";
  if ($settings == "show") echo "li.settings { }";
?>
.menu { font-size: 0.9em; padding: 0px; margin: 0px; }
.menu input { width: 170px; }
.menu hr { width: 155px; }
body.menu { width: 190px; text-align: center; }
</style>
<script type="text/javascript" src="../shop.js"></script>
</head>
