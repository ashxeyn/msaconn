<?php
require_once '../../classes/adminClass.php';

$adminObj = new Admin();

$volunteerId = $_POST['volunteer_id'] ?? null;

if ($volunteerId) {
    $result = $adminObj->deleteVolunteer($volunteerId);
    echo $result === true ? "success" : $result;
} else {
    echo "invalid_request";
}
?>