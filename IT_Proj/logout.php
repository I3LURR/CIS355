<?php
/* ---------------------------------------------------------------------------
 * filename    : logout.php
 * author      : Tyler O'Lear, tmolear@svsu.edu gpcorser
 * description : This program logs the user out by destroying the session
 * ---------------------------------------------------------------------------
 */
session_start();
session_destroy();
header("Location: index.php");
?>