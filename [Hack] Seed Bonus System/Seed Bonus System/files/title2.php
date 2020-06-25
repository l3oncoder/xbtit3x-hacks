<?php
require_once ("include/functions.php");
require_once ("include/config.php");
dbconn();
  if ($CURUSER["uid"] > 1)
    {
  $uid=$CURUSER['uid'];
  $r=do_sqlquery("SELECT * from {$TABLE_PREFIX}users where id=$uid");
  $c=mysqli_result($r,0,"seedbonus");
if($c>=$GLOBALS["price_ct"]) {
          if (isset($_POST["title"])) $custom=mysqli_real_escape_string($GLOBALS['conn'],$_POST["title"]);
             else $custom = "";
    if ("$custom"=="")
        {
          do_sqlquery("UPDATE {$TABLE_PREFIX}users SET custom_title=NULL WHERE id='".$userid."'");
        }
    else
        {
          do_sqlquery("UPDATE {$TABLE_PREFIX}users SET custom_title='".htmlspecialchars($custom)."' WHERE id=$CURUSER[uid]");
        }
        $p=$GLOBALS["price_ct"];
        do_sqlquery("UPDATE {$TABLE_PREFIX}users SET seedbonus=seedbonus-$p WHERE id=$CURUSER[uid]");
        // sb control
@do_sqlquery("INSERT into {$TABLE_PREFIX}sb (id,what,gb,points,date) VALUES ('$uid','Title ( ".htmlspecialchars($custom)." )',0, '".$GLOBALS["price_ct"]."',NOW())");
// sb control
        }
header("Location: index.php?page=modules&module=seedbonus");
   }
else header("Location: index.php");
?>