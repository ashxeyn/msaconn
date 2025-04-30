<?php
require_once '../../classes/adminClass.php';
require_once '../../classes/accountClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$accountObj = new Account();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = clean_input($_POST['action']);
    $moderatorId = isset($_POST['user_id']) ? clean_input($_POST['user_id']) : null;

    if ($action === 'edit') {
        $firstName = clean_input($_POST['firstName']);
        $middleName = clean_input($_POST['middleName']);
        $lastName = clean_input($_POST['lastName']);
        $username = clean_input($_POST['username']);
        $email = clean_input($_POST['email']);
        $positionId = clean_input($_POST['positionId']);

        $existingModerator = $adminObj->getModeratorById($moderatorId);
        if (!$existingModerator) {
            echo "error:moderator_not_found";
            exit;
        }

        if ($username !== $existingModerator['username'] && $accountObj->usernameExist($username)) {
            echo "error:username_exists";
            exit;
        }

        if ($email !== $existingModerator['email'] && $accountObj->emailExist($email)) {
            echo "error:email_exists";
            exit;
        }

        $result = $adminObj->updateModerator(
            $moderatorId,
            $firstName,
            $middleName,
            $lastName,
            $username,
            $email,
            $positionId
        );

        echo $result ? "success" : "error";

    } elseif ($action === 'delete') {
        $reason = clean_input($_POST['reason']);
        if (empty($reason)) {
            echo "error:reason_required";
            exit;
        }

        $result = $adminObj->softDeleteModerator($moderatorId, $reason);
        echo $result ? "success" : "error";

    } elseif ($action === 'restore') {
        $result = $adminObj->restoreModerator($moderatorId);
        echo $result ? "success" : "error";

    } elseif ($action === 'add') {
        $firstName = clean_input($_POST['firstName']);
        $middleName = clean_input($_POST['middleName']);
        $lastName = clean_input($_POST['lastName']);
        $username = clean_input($_POST['username']);
        $email = clean_input($_POST['email']);
        $positionId = clean_input($_POST['positionId']);
        $password = clean_input($_POST['password']);

        // Check for duplicate username/email
        if ($accountObj->usernameExist($username)) {
            echo "error:username_exists";
            exit;
        }

        if ($accountObj->emailExist($email)) {
            echo "error:email_exists";
            exit;
        }

        $result = $adminObj->addModerator(
            $firstName,
            $middleName,
            $lastName,
            $username,
            $email,
            $positionId,
            $password
        );

        echo $result ? "success" : "error";
    } else {
        echo "error:invalid_action";
    }
} else {
    echo "error:invalid_request_method";
}
?>