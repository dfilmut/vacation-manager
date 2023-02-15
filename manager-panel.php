<?php
session_start();
if (isset($_SESSION['ID'])) {
    $user_role = $_SESSION['ROLE'];
    if ($user_role =="kierownik" || $user_role =="administrator") {
    
        require("functions.php"); 
        include('db_connection.php');
?>

<style>
    <?php include("styles/style.css"); ?>
</style>

<div class="main-layout">
<?php header_buttons();?>
<div style="width:100%;">
    <div style="margin-left:auto;margin-right:auto;width:88%;">
<h1> Panel - kierownik </h1>
<h2> Lista wniosków urlopowych </h2>

<?php
$user_id = $_SESSION['ID'];
$manager_id = $_SESSION['MANAGER'];

$sql_user_vacations = "SELECT concat(us.name, ' ', us.surname) AS full_name, us.email, us.position, us.department, us.manager_id, va.vacation_date_from, va.vacation_date_to, va.vacation_days_count, va.status, va.vacation_id, va.user_id, us.vacation_days_avaliable
FROM php_users us INNER JOIN php_vacations va ON us.user_id = va.user_id WHERE us.manager_id = $manager_id ORDER BY va.vacation_id DESC;";

$database_user_vacations = $con->query($sql_user_vacations); 
// WYŚWIETLANIE WNIOSKÓW URLOPOWYCH PRACOWNIKÓW DANEGO KIEROWNIKA?>

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
        <th>Dostępne operacje</th>
    </tr>

<?php if ($database_user_vacations->num_rows > 0) {  
    while ($row = $database_user_vacations->fetch_assoc()) { 
        $form_status = $row["status"];
        $vacation_id = $row["vacation_id"];
        $vacation_form_user_id = $row["user_id"];
        $user_vacation_days_count = $row["vacation_days_count"];
        $user_vacation_days_avaliable = $row["vacation_days_avaliable"]; ?>
    <tr>
        <td class="table-employee-data"><?php echo $row["full_name"] ?></td>
        <td><?php echo $row["email"] ?></td>
        <td><?php echo $row["position"] ?></td>
        <td><?php echo $row["department"] ?></td>
        <td><?php echo $row["vacation_date_from"] ?></td>
        <td><?php echo $row["vacation_date_to"] ?></td>
        <td><?php echo $row["vacation_days_count"] ?></td>
        <td><?php echo $row["status"] ?></td>
        <?php if ($form_status == "Wysłany") { ?> 
            <form action="" method="post">
                <td class="button-acc">
                    <select name="status" id="status">
                        <option style="text-align: center;" value='<?php echo "$vacation_id";?>|accepted|<?php echo "$user_vacation_days_count";?>|<?php echo "$user_vacation_days_avaliable";?>|<?php echo "$vacation_form_user_id";?>'>Zaakceptuj</option>
                        <option style="text-align: center;" value='<?php echo "$vacation_id";?>|declined|<?php echo "$user_vacation_days_count";?>|<?php echo "$user_vacation_days_avaliable";?>|<?php echo "$vacation_form_user_id";?>'>Odrzuć</option>
                        <input class="input-as-button" onclick="return confirm('Jesteś pewny?')" type="submit" value="Zatwierdź">
                    </select>
                </td>
            </form>
        <?php } else { ?>
        <td>Nie możesz zmienić statusu tego wniosku!</td>
        <?php } ?>
    </tr>
<?php } } ?>
</table>
</div>

</div>
<?php
        $dataFromPost = $_POST['status'];
        changeStateVacationApplication($vacation_form_user_id, $dataFromPost);

    } else {
        echo "Nie masz praw do przeglądania tej strony!";
    }
        } else {
        header("Location:/");
        die();
}
?>
<?php get_footer(); ?>