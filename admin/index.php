<!DOCTYPE html>
<html>
<head>
<title>folkadelic shop admin</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<style type="text/css">
a:link { color: #24280F; text-decoration: none}
a:visited { color: #24280F; text-decoration: none}
a:hover { color: #999966; text-decoration: none }
</style>
</head>
<?php
$current_page = "shop-admin";
include ('../../kopf.php');
?>
<!-- INHALT -->
<table border="0" width="800" align="center" cellpadding="5" cellspacing="0" bgcolor="#544a31">
  <tr align="center">
    <td width="750" align="center" valign="top">
      <iframe name="shop-admin" src="showitems.php" width="780" height="600" scrolling="auto" frameborder="0"></iframe>
    </td>
  </tr>
</table>
<?php include ('../fuss.php'); ?>
