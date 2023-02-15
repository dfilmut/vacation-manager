<?php
session_start();
if (isset($_SESSION['ID'])) {
include('functions.php'); 
include('db_connection.php');?>
<style>
    <?php include("styles/style.css"); ?>
</style>

<div class="main-layout">
<?php header_buttons();?>

<!-- <div style="width:100%;">
    <div style="margin-left:auto;margin-right:auto;width:88%;">
    <div class="div-for-form" style ="text-align: center;"> -->
    <div class="login-form-container">
      <div class="login-form-vertical-center">
      <div class = "div-for-form">
<h1>Kontakt</h1>
<h2>Twórca: Damian Filmut</h2>
<h2>Email: dfilmut@gmail.com</h2>

</div>
</div>

</div>
<?php get_footer(); ?>
<?php

    } else {
        header("Location:/");
        die();
    }
?>
