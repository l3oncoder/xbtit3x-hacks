<?php
require_once ("include/functions.php");
require_once ("include/config.php");
dbconn();
global $CURUSER, $FORUMLINK, $db_prefix;
  if ($CURUSER["uid"] > 1)
    {
$id=$_GET['id'];
if($id=="vip"){
$uid=$CURUSER["uid"];
$r=do_sqlquery("SELECT seedbonus FROM {$TABLE_PREFIX}users WHERE id=$uid");
$u=mysqli_result($r,0,"seedbonus");
if($u<$GLOBALS["price_vip"] OR $CURUSER["id_level"]>=5) {
header("Location: index.php?page=modules&module=seedbonus");
}else {
do_sqlquery("UPDATE {$TABLE_PREFIX}users SET id_level=5, seedbonus=seedbonus-".$GLOBALS["price_vip"]." WHERE id=$uid");
// sb control
@do_sqlquery("INSERT into {$TABLE_PREFIX}sb (id,what,gb,points,date) VALUES ('$uid','Vip','0', '".$GLOBALS["price_vip"]."',NOW())");
// sb control
if ($FORUMLINK=="smf")
    {do_sqlquery("UPDATE {db_prefix}members SET ID_GROUP=15 WHERE ID_MEMBER=".$CURUSER["smf_fid"]);}
header("Location: index.php?page=modules&module=seedbonus");
}
die(" ");
}
if(is_null($id)||!is_numeric($id)||$CURUSER["view_torrents"]=="no"){
header("Location: index.php");
}
$r=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}bonus WHERE id='$id'");
$p=mysqli_result($r,0,"points");
$t=mysqli_result($r,0,"traffic");
$uid=$CURUSER["uid"];
$r=do_sqlquery("SELECT seedbonus FROM {$TABLE_PREFIX}users WHERE id=$uid");
$u=mysqli_result($r,0,"seedbonus");
if($u<$p) {
header("Location: index.php?page=modules&module=seedbonus");
}else {
@do_sqlquery("UPDATE {$TABLE_PREFIX}users SET uploaded=uploaded+$t,seedbonus=seedbonus-$p WHERE id=$uid");
// sb control

do_sqlquery("INSERT into {$TABLE_PREFIX}sb (id,what,gb,points,date) VALUES ('$uid','Upload','$t', '$p',NOW())");
// sb control
header("Location: index.php?page=modules&module=seedbonus");
}}
else header("Location: index.php");
?>