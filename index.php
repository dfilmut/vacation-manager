<style>
    <?php include("styles/style.css"); ?>
</style>

<?php
  session_start();
  if (isset($_SESSION['ID'])) {
      header("Location:dashboard.php");
      exit();
  }
  // Include database connectivity
    
  include_once('db_connection.php');
  
  if (isset($_POST['submit'])) {
      $errorMsg = "";
      $login = $con->real_escape_string($_POST['login']);
      $password = $con->real_escape_string(md5($_POST['password']));
      
  if (!empty($login) || !empty($password)) {
        $query  = "SELECT * FROM php_users WHERE login = '$login' AND password = '$password'";
        $result = $con->query($query);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $_SESSION['ID'] = $row['user_id'];
            $_SESSION['ROLE'] = $row['role'];
            $_SESSION['NAME'] = $row['name'];
            $_SESSION['MANAGER'] = $row['manager_id'];
            header("Location:dashboard.php");
            die();                              
        }else{
          echo "<script>alert('Podałeś błędny login lub hasło.');</script>";
        } 
    }else{
      echo "<script>alert('Wpisz login oraz hasło.');</script>";
    }
  }
?>
<div class="">
  <div class="login-form-container">
    <div class="login-form-vertical-center">
      <div class ="div-for-form">
        <h1>Logowanie do panelu</h1>
        <form action="" method="POST">
          <div>
       <a href="/../"><img style="" src="icons/logo.png" alt="logo"></a>   
            <!-- <label for="login">Login</label>  -->
            <p class="login-page-p">Login</p> <br>
            <input type="text" name="login" placeholder="Wprowadź login" >
            </div>
            <div>
              <p class="login-page-p">Hasło</p> <br>
            <!-- <label for="password">Hasło</label>  -->
            <input type="password" name="password" placeholder="Wprowadź hasło">
            </div>
            <input class="input-as-button" style="margin-top: 20px;" type="submit" name="submit" value="Login"> 
        </form>
      </div>
    </div>
  </div>
  
</div>