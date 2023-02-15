<?php
session_start();
if (isset($_SESSION['ID'])) {
    $user_role = $_SESSION['ROLE'];
    if ($user_role =="administrator" || $user_role =="kadry") {
         
        require("functions.php");
        include('db_connection.php');
?>

<style>
    <?php include("styles/style.css"); ?>
</style>


<div class="main-layout">
<?php header_buttons(); ?>
<div style="width:100%;">
    <div style="margin-left:auto;margin-right:auto;width:88%;">
<div id="wrapper">
    <div id="first-kadry-cu-button">
        <div>
    <h1> Panel - kadry </h1>
    <h2> Lista wniosków urlopowych </h2>
    </div>
    </div>
    <div id="second-kadry-cu-button">
    <button style="padding: 25px;" onclick="location.href='/../create-user.php'" type="button">Dodaj pracownika</button>
    </div>
</div>
<?php
                $sql_user_vacations = "SELECT concat(us.name, ' ', us.surname) AS full_name, us.email, us.position, us.department, us.manager_id, va.vacation_date_from, va.vacation_date_to, va.vacation_days_count, va.status  
FROM php_users us INNER JOIN php_vacations va ON us.user_id = va.user_id ORDER BY va.vacation_id DESC";

                $database_user_vacations = $con->query($sql_user_vacations); ?>
    <table>
        <tr>
            <th>Imię i nazwisko</th>
            <th>e-mail</th>
            <th>Stanowisko</th>
            <th>Dział</th>
            <th>Data rozpoczęcia urlopu</th>
            <th>Data zakończenia urlopu</th>
            <th>Wykorzystane dni urlopowe</th>
            <th>Status</th>
        </tr>

<?php if ($database_user_vacations->num_rows > 0) {
                    while ($row = $database_user_vacations->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row["full_name"] ?></td>
            <td><?php echo $row["email"] ?></td>
            <td><?php echo $row["position"] ?></td>
            <td><?php echo $row["department"] ?></td>
            <td><?php echo $row["vacation_date_from"] ?></td>
            <td><?php echo $row["vacation_date_to"] ?></td>
            <td><?php echo $row["vacation_days_count"] ?></td>
            <td><?php echo $row["status"] ?></td>
        </tr>
<?php }
                } ?>
    </table> 

<h2> Lista pracowników </h2>
<?php
                $sql_employess = "SELECT concat(us.name, ' ', us.surname) AS full_name, us.email, us.position, us.department, us.manager_id, us.vacation_days_avaliable, us.user_id FROM php_users us";

                $database_employess = $con->query($sql_employess);
                // WYŚWIETLANIE WNIOSKÓW URLOPOWYCH ZALOGOWANEGO PRACOWNIKA?>

<table>
<tr>
    <th>Imię i nazwisko</th>
    <th>e-mail</th>
    <th>Stanowisko</th>
    <th>Dział</th>
    <th>Dostępne dni urlopowe</th>
    <th>Dostępne operacje</th>
</tr>

<?php if ($database_employess->num_rows > 0) {
                    while ($row = $database_employess->fetch_assoc()) {
                        $user_id = $row["user_id"]; ?>

        <tr>
            <td><?php echo $row["full_name"] ?></td>
            <td><?php echo $row["email"] ?></td>
            <td><?php echo $row["position"] ?></td>
            <td><?php echo $row["department"] ?></td>
            <td><?php echo $row["vacation_days_avaliable"] ?></td>
            <form action="" method="post">
                <td>
                    <select name="action" id="action">
                        <option style="text-align: center;" value='<?php echo "$user_id"; ?>|delete'>Usuń pracownika</option>
                        <input class="input-as-button" onclick="return confirm('Czy na pewno chcesz usunąć pracownika? Tej operacji nie można cofnąć!')" type="submit" value="Zatwierdź">
                    </select>
                </td>
            </form>  
            <?php }
                } ?>
        </tr>
</table>


<?php

                $result = $_POST['action'];
                $result_explode = explode('|', $result);
                $user_id = $result_explode[0];
                $action = $result_explode[1];

                $user_id = $con->real_escape_string($user_id);
                $action = $con->real_escape_string($action);
                if ($action == "delete") {
                    $query = "DELETE FROM php_users WHERE user_id='$user_id';";
                    $result = $con->query($query);
                    if ($result == true) {
                        header("Refresh:0");
                        die();
                    } else {
                        $errorMsg = "Operacja nie powiodła się, spróbuj ponownie.";
                    }
                }
                ?>
</div>
</div>
<?php get_footer(); ?>
</div>
<?php
    } else {
        echo "Nie masz praw do przeglądania tej strony!";
    }
} else {
        header("Location:/");
        die();
}

?>