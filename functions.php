<style>
    <?php include("style/style.css"); ?>
</style>
<?php function saveFormDataFormToDB($date_from,$date_to, $user_vacation_avaliable_days)
{
    $user_id = $_SESSION['ID'];
    include("db_connection.php");
    if ($date_from != NULL){
        if ($date_to != NULL) {
            $dates_range = getDatesFromRange("$date_from", "$date_to");

                foreach ($dates_range as &$valueDates) {
                    $vacationDay = checkFromArrayIfDateIsWeekend("$valueDates");
                    if ($vacationDay == false) {
                        $vacationDays++;
                    }
                }

            $avaliable_vacation_days_update = $user_vacation_avaliable_days - $vacationDays;

            if ($avaliable_vacation_days_update >= 0) {
                //INSERT DO BAZY, DO TABELI php_vacations
                    $date_from = $con->real_escape_string($_POST['date_from']);
                    $date_to   = $con->real_escape_string(($_POST['date_to']));
                    $status    = "Wysłany";

                    $query = "INSERT INTO php_vacations (user_id,vacation_date_from,vacation_date_to,vacation_days_count,status) VALUES ('$user_id','$date_from','$date_to','$vacationDays','$status')";
                    $result_vacation_form = $con->query($query);
                    if ($result_vacation_form == true) {

                        $query_update = "UPDATE php_users SET vacation_days_avaliable = $avaliable_vacation_days_update WHERE user_id = '$user_id';";
                        $result_vacation_days_update = $con->query($query_update);

                        if ($result_vacation_days_update == true) {
                            header("Refresh:0");
                        }
                    } 
                    else {
                    echo "<script>alert('Wystąpił błąd, spróbuj ponownie!');</script>";
                    }
            } else 
                { 
                echo "<script>alert('Nie masz wystarczającej ilości dni urlopu!');</script>";
                }    
        }
    }
}
?>

<?php
//funkcja sprawdzająca czy w okresie wolnego wypada dzień weekendu
function checkFromArrayIfDateIsWeekend($date_from_array) {

    $date = $date_from_array;
    $timestamp = strtotime($date);
    $weekday= date("l", $timestamp );
    $normalized_weekday = strtolower($weekday);
        if (($normalized_weekday == "saturday") || ($normalized_weekday == "sunday")) {
        return true;
        } else {
        return false;
        }
    }

?>
<?php
//funkcja pobierająca daty z formularza i zapisująca je do tabeli
function getDatesFromRange($start, $end, $format = 'Y-m-d') {
    $dates_range = array();
    $interval = new DateInterval('P1D');

    $realEnd = new DateTime($end);
    $realEnd->add($interval);

    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

    foreach($period as $date) { 
        $dates_range[] = $date->format($format);
    }

    return $dates_range;

}
?>
<?php function header_buttons() { //FUNKCJA WYCIĄGAJĄCA PRZYCISKI DLA ODPOWIEDNIEJ GRUPY?>
<header>
    <nav>
        <div>          
            <div id="header_boarder">
                <ul id="header-ul">
                        <li id="li-logout"><button id ="button-logout" onclick="location.href='/../logout.php'" type="button">Wyloguj</button></li>
                        <li id="first-li"><button onclick="location.href='/../dashboard.php'" type="button">Panel pracownika</button></li>
                        <li><button onclick="location.href='/../faq.php'" type="button">FAQ</button></li>

                    <?php if($_SESSION['ROLE'] == 'kierownik'){; ?>
                        <li><button onclick="location.href='/../manager-panel.php'" type="button">Panel kierownika</button></li>

                    <?php }?>

                    <?php if($_SESSION['ROLE'] == 'kadry'){; ?>
                        <li><button onclick="location.href='/../hr-panel.php'" type="button">Panel kadry</button></li>

                    <?php }?>

                    <?php if($_SESSION['ROLE'] == 'administrator'){; ?>
                        <li><button onclick="location.href='/../manager-panel.php'" type="button">Panel kierownika</button></li>
                        <li><button onclick="location.href='/../hr-panel.php'" type="button">Panel kadry</button></li>                
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
</header>


<?php }?>

<?php function get_footer() { ?>
    <footer style="margin-bottom:0px;">
    <div>
        <ul style="margin-bottom:0px;" class="center-button-inside-div">
        <div style="text-align:center">
            <li><b> Programowanie PHP - WSB Poznań 2023 </b> |</a></li>
            <li><a href="/../kontakt.php">Kontakt</a></li>
            <!-- <li><a href="https://www.freepik.com/free-photo/sunset-background-featuring-sky-clouds_16015909.htm#query=orange%20clouds&position=3&from_view=keyword">Background Image by rawpixel.com</a> on Freepik</li> -->
        </div>
        </ul>
    </div>
    </footer>
<?php } ?>

<?php function saveNewEmployeeToDB($dataFromPost) {
    include_once("db_connection.php");
        //tworzenie użytkownika przez osobę uprawnioną
        if (isset($dataFromPost)) {

          $login = $con->real_escape_string($_POST['login']);
          $password = $con->real_escape_string(md5($_POST['password']));
          $name = $con->real_escape_string($_POST['name']);
          $surname = $con->real_escape_string($_POST['surname']);
          $email = $con->real_escape_string($_POST['email']);
          $position = $con->real_escape_string($_POST['position']);
          $department = $con->real_escape_string($_POST['department']);
          $manager_id = $con->real_escape_string($_POST['manager_id']);
          $role = $con->real_escape_string($_POST['role']);
          $vacation_days_avaliable = $con->real_escape_string($_POST['vacation_days_avaliable']);
          $query = "INSERT INTO php_users (login,password,email,name,surname,position,department,role,manager_id,vacation_days_avaliable) VALUES ('$login','$password','$email','$name','$surname','$position','$department','$role','$manager_id','$vacation_days_avaliable')";
          $result = $con->query($query);
          if ($result == true) {
            echo "<script>alert('Pracownik $name $surname został dodany.');</script>";
            //header("Location:create-user.php");
          } else {
            echo "<script>alert('Wystąpił błąd, spróbuj ponownie.');</script>";
          }
        }
}

?>

<?php function changeStateVacationApplication($vacation_form_user_id, $dataFromPost)
{
    include("db_connection.php");
    // $result = $_POST['status'];
    $result_explode = explode('|', $dataFromPost);
    $vacation_id = $result_explode[0];
    $status = $result_explode[1];
    $user_vacation_days_count=$result_explode[2];
    $user_vacation_days_avaliable=$result_explode[3];
    $vacation_form_user_id=$result_explode[4];
    if (isset($dataFromPost)) {
        if ($status == "accepted") {
            $query = "UPDATE php_vacations SET status = 'Zaakceptowany' WHERE vacation_id=$vacation_id;";
            $result = $con->query($query);
            if ($result == true) {
                echo "<script>alert('Wniosek został zaakceptowany.');</script>";
                header("Refresh:0");
                die();
            } else {
                $errorMsg = "Operacja nie powiodła się, spróbuj ponownie.";
            }
        } else if ($status == "declined") {
            $query = "UPDATE php_vacations SET status = 'Odrzucony' WHERE vacation_id=$vacation_id;";
            $result = $con->query($query);
            if ($result == true) {

                $log_file = 'logs/debug_logs.txt';
                $vacation_days_after_rejected = $user_vacation_days_count + $user_vacation_days_avaliable;
                file_put_contents($log_file, "zmienna user_vacation_days_count = $user_vacation_days_count | zmienna user_vacation_days_count = $user_vacation_days_avaliable | zmienna vacation_days_after_rejected = $vacation_days_after_rejected \n", FILE_APPEND);
                $query = "UPDATE php_users SET vacation_days_avaliable = $vacation_days_after_rejected WHERE user_id=$vacation_form_user_id;";
                $result = $con->query($query);
                echo "<script>alert('Wniosek został odrzucony.');</script>";
                header("Refresh:0");
                die();
            } else {
                $errorMsg = "Operacja nie powiodła się, spróbuj ponownie.";
            }
        }
    }
}
?>

<?php function changePasswordAsUser ($old_password, $new_password, $user_id) {
    include("db_connection.php");
            if (isset($_REQUEST["change_password"])) {

                if (!empty($old_password) || !empty($new_password)) {
                $sql_user_password = "SELECT * FROM php_users WHERE user_id='$user_id' AND password='$old_password';";
                $change_password = $con->query($sql_user_password);
                if ($change_password->num_rows > 0) {
                    $row = $change_password->fetch_assoc();
                    $query = "UPDATE php_users SET password = '$new_password' WHERE user_id='$user_id';";
                    $result = $con->query($query);
                        if ($result == true) {
                            echo "<script>alert('Hasło zostało zmienione.');</script>";
                            header("Refresh:0");
                        } else {
                            $errorMsg = "Operacja nie powiodła się, spróbuj ponownie.";
                        }
                } else {
                    echo "Podałeś błędne stare hasło, spróbuj ponownie!";
                }
        }else {
                echo "Musisz wpisać stare oraz nowe hasło!";
        }
    }
}
?>

