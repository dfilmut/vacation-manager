<?php
session_start();
if (isset($_SESSION['ID'])) {
  $user_role = $_SESSION['ROLE'];
  if ($user_role =="administrator" || $user_role =="kadry") {
require("functions.php"); 
?>

<style>
    <?php include("styles/style.css"); ?>
</style>
<div class="main-layout">
<?php header_buttons();?>
<div class="login-form-container">
      <div class="login-form-vertical-center">
      <div class = "div-for-form">
<form action="" method="POST">
          <table>
          <tbody>
          <tr>
            <th><label for="login">Login:</label></th>
            <td><input type="text" name="login" placeholder="Login" required=""></td>
          </tr>
          <tr>
            <th><label for="password">Hasło tymczasowe:</label></th>
            <td><input type="text" name="password" placeholder="Hasło tymczasowe" required=""></td>
          </tr>  
          <tr>
            <th><label for="name">Imię:</label></th>
            <td><input type="text" name="name" placeholder="Imię pracownika" required=""></td>
          </tr>
          <tr>
            <th><label for="surname">Nazwisko:</label></th>
            <td><input type="text" name="surname" placeholder="Nazwisko pracownika" required=""></td>
          </tr>
          <tr>
            <th><label for="email">Email:</label></th>
            <td><input type="text" name="email" placeholder="Mail firmowy" required=""></td>
          </tr>
          <tr>
          <th><label for="position">Stanowisko:</label></th>
          <td><input type="text" name="position" placeholder="Stanowisko" required=""></td>
          </tr>
          <tr>
          <th><label for="department">Dział:</label></th>
          <td><input type="text" name="department" placeholder="Dział" required=""></td>
          </tr>
          <tr>
          <th><label for="vacation_days_avaliable">Dostępne dni urlopowe:</label></th>
          <td><input type="text" name="vacation_days_avaliable" placeholder="Wpisz dni" required=""></td>
          </tr>
          <tr>
          <th><label for="manager_id">Kierownik:</label></th>
          <td><select name="manager_id" required="false">
              <option value="">Wybierz pozycję</option>
              <?php 
              
              //POBIERANIE DANYCH O KIEROWNIKACH Z TABELI PHP_MANAGERS
              
              
              ?>
              <option value="1">kierownik 1</option>
              <option value="2">kierownik 2</option>
              <option value="3">kierownik 3</option>
            </select></td>
          </tr>
          <tr>
          <th><label for="role">Uprawnienia:</label></th>
          <td><select name="role" required="">
              <option value="">Wybierz pozycję</option>
              <option value="kadry">Kadry</option>
              <option value="kierownik">Kierownik</option>
              <option value="pracownik">Pracownik</option>
            </select></td>

            

        </form>
        </tbody>
        </table>
        <input class="input-as-button" type="submit" name="submit" value="Dodaj pracownika">
        </div>

        <button style="margin-left:auto;margin-right:auto;margin-top:20px;" onclick="location.href='/../hr-panel.php'" type="button">Wróć do panelu kadr</button>

        </div>
    </div>
    <?php get_footer(); ?>
    </div>
        <?php
        $dataFromPost = $_POST['submit'];
        saveNewEmployeeToDB($dataFromPost);
      } else {
        echo "Nie masz praw do przeglądania tej strony!";
    }
}else {
  header("Location:/");
	die();
}
?>