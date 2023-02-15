<?php
session_start();
if (isset($_SESSION['ID'])) {
$dates_range = require("functions.php"); 
include('db_connection.php');?>
<style>
    <?php include("styles/style.css"); ?>
</style>
<main>
<div class="main-layout">

<?php header_buttons();?>

    <div style="margin-left:auto;margin-right:auto;width:88%;">
<h1> Panel - pracownik </h1>
<div id="wrapper">
    <div id="first"><h2>Twoje dane</h2></div>
    <div id="second"></div>
    <div id="third"></div>
</div>
<head>
<script>
    function popoutWindow() {
        var x;
        var r = confirm("Potwierdź przesłanie wniosku o urlop!");
        if (r == true) {
         x = "You pressed OK!";
     }
        else {
         x = "You pressed Cancel!";
     }
     document.getElementById("demo").innerHTML = x;
}
</script>
</head>



<?php
$user_id = $_SESSION['ID'];
 
$sql_user_profile = "SELECT * FROM php_users WHERE user_id=$user_id";
$database_user_profile = $con->query($sql_user_profile); 
// WYŚWIETLANIE DANYCH ZALOGOWANEGO PRACOWNIKA z BAZY?>
<div id="wrapper">
<div id="first">
    <table class="table-employee-data">
        <tbody>   
            <?php
            if ($database_user_profile->num_rows > 0) {
                while($row = $database_user_profile->fetch_assoc()) {
                $user_vacation_avaliable_days = $row["vacation_days_avaliable"]; ?>
                <tr>
                <th>Imie:</th><td><?php echo $row["name"] ?></td>
                </tr>
                <tr>
                <th>Nazwisko:</th><td><?php echo $row["surname"] ?></td>
                </tr>
                <tr>
                <th>Stanowisko:</th><td><?php echo $row["position"] ?></td>
                </tr>
                <tr>
                <th>Dział:</th><td><?php echo $row["department"] ?></td>
                </tr>
                <tr>
                <th>Dostępne dni urlopu:</th><td><?php echo $row["vacation_days_avaliable"]?></td>
                </tr>
            <?php }} ?>
        </tbody>
    </table>
</div>
<?php //FORMULARZ WYPEŁNIANIA WNIOSKU URLOPOWEGO ?>
<div id="second">
    <div class = "div-for-form">
    <h2>Wniosek urlopowy</h2>
    <form action = "" method = "post">
        <p>Data rozpoczęcia urlopu:</p><br><input type="date" name="date_from"><br>
        <p class="dashboard-windows">Data zakończenia urlopu:</p><br><input type="date" name="date_to"><br> 
        <div class="center-button-inside-div">
    <input class="input-as-button dashboard-windows" onclick="return confirm('Czy na pewno wysłać wniosek?')" type="submit" value="Wyślij wniosek">
    </div>
    </div>
    </form>
</div>
<?php
    //ZAPISANIE WNIOSKU DO BAZY DANYCH I OBSŁUGA BŁĘDÓW W PLIKU functions.php
    $date_from = $_REQUEST['date_from'];
    $date_to = $_REQUEST['date_to'];
    //funkcja przyjmuje zmienne z formularza ($date_from,$date_to) oraz dostępne dni urlopowe pracownika ze zmiennej $user_vacation_avaliable_days
    saveFormDataFormToDB($date_from,$date_to, $user_vacation_avaliable_days);
?>
<div id="third">
<div class = "div-for-form">
<h2>Zmień hasło</h2>
    <form action = "" method = "post">
        <p>Wprowadź obecne hasło:</p> <br><input type="password" name="old_password"><br>
        <p class="dashboard-windows">Wprowadź nowe hasło:</p> <br><input type="password" name="new_password"><br> 
        <div class="center-button-inside-div">
    <input class="input-as-button dashboard-windows" onclick="return confirm('Czy na pewno zmienić hasło?')" name="change_password" type="submit" value="Zmień hasło">
    </div>
    </div>
    </form>
</div>
</div>
<?php

$old_password = $con->real_escape_string(md5($_POST['old_password']));
$new_password = $con->real_escape_string(md5($_POST['new_password']));
$user_id = $_SESSION['ID'];

    changePasswordAsUser($old_password, $new_password, $user_id);
//sprawdzenie czy obecne hasło jest takie jakie jest naprawdę z bazy

//update na bazie z miejsce password nowego hasła
?>

<h2>Złożone wnioski urlopowe</h2>
<?php
$user_id = $_SESSION['ID'];
$sql_user_vacations = "SELECT * FROM php_vacations WHERE user_id=$user_id";
$database_user_vacations = $con->query($sql_user_vacations); 
// WYŚWIETLANIE WNIOSKÓW URLOPOWYCH ZALOGOWANEGO PRACOWNIKA?>

    <table>
        <tr>
            <th>Data rozpoczęcia urlopu</th>
            <th>Data zakończenia urlopu</th>
            <th>Wykorzystane dni urlopowe</th>
            <th>Status</th>
        </tr>
        <?php
            if ($database_user_vacations->num_rows > 0) {
                while($row = $database_user_vacations->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row["vacation_date_from"] ?></td>
            <td><?php echo $row["vacation_date_to"] ?></td>
            <td><?php echo $row["vacation_days_count"] ?></td>
            <td><?php echo $row["status"] ?></td>
        </tr>
    <?php } } ?>

    </table>

</div>
<?php get_footer(); ?>
</main>


</div>
<?php
        
} else {
        header("Location:/");
        die();
}
?>
