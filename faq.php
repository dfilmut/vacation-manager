<?php
session_start();
if (isset($_SESSION['ID'])) {
$dates_range = require("functions.php"); 
include("db_connection.php");?>

<style>
    <?php include("styles/style.css"); ?>
</style>
<div class="main-layout">
<?php header_buttons(); ?>
<div style="width:100%;">
    <div style="margin-left:auto;margin-right:auto;width:88%;">
    <div class="div-for-form" style ="text-align: left;">
<h1>Często zadawane pytania</h1>
<h2>1. Użytkownicy z rolą kadry</h2>
<p>Użytkownicy z rolą kadr mają możliwość podglądu, edycji oraz usuwania użytkownika. Jako jedyni również mają możliwość tworzenia kont pracowników.</p>

<h2>2. Użytkownicy z rolą kierownik</h2>
<p>Użytkownicy z rolą kierownik mają możliwość podglądu danych pracowników w swoich działach oraz akceptowania lub odrzucania wniosków urlopowych.</p>

<h2>3. Użytkownicy z rolą pracownik</h2>
<p>Konta pracowników upoważnione są tylko do składania wniosków oraz wyświetlania tej strony.</p>

<h2>4. Użytkownicy z rolą administrator</h2>
<p>Administratorzy mają wszystkie dostępne opcje możliwe do wykorzystania, tak jakby byli jednocześnie z kadr, kierownikami działów oraz pracownikami.</p>

<h2>5. Zakładanie kont</h2>
<p>Konta zakładane są przez dział Kadr. Istnieje również możliwość uruchomienia rejestracji dla pracowników - taką funkcję mają jedynie administratorzy.</p>

<h2>6. Api</h2>
<p>Dokładna dokumentacja API dostępna jest jedynie za pośrednictwem dostawcy i twórcy strony i to do niego należy się po takową zgłosić. Najlepiej zrobić to przez mail - wszystkie potrzebne informacje znajdują się w stopce strony, w zakładce kontakt z twórcą.</p>
<p>API aktualnie obsługuje jedynie dodawanie kont pracowników - pomaga to połączyć się z zewnętrznymi systemiami w celu integracji z naszą usługą.</p>

<h2>7. Uwagi i zgłoszenia</h2>
<p> Wszelkie uwagi i zgłoszenia można składać na mail oraz poprzez inne drogi kontaktu podane w stopce strony w zakładce kontakt z twórcą.</p>
</div>
</div>
</div>
<?php get_footer(); ?>
</div>
<?php 
} else {
        header("Location:/");
        die();
}
?>


