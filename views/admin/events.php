<?php
session_start();
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$eventPhotos = $adminObj->fetchEventPhotos();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Event Photos</title>
    <script src="../../js/admin.js"></script>
    <script src="../../js/modals.js"></script>
    <!-- <script src="../../js/sideBar.js"></script> -->
    <!-- <?php include '../../includes/head.php'; ?>  -->

    <style>
        .event-photo {
            width: 120px;
            height: 80px;
            border-radius: 6px;
            object-fit: cover;
            background-color: #f0f0f0;
        }
    </style>

</head>
<body>

<div>
<h2 class="mb-4">Event Management</h2>

    <button class="btn btn-success mb-3" onclick="openEventModal('addEditEventModal', null, 'add')"><i class="bi bi-plus-lg"></i></button>

    <table id="table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Photo</th>
                <th>Uploaded By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($eventPhotos): ?>
                <?php $counter = 1; ?>
                <?php foreach ($eventPhotos as $event): ?>
                    <tr>
                        <td><?= $counter++ ?></td>
                        <td><?= clean_input($event['description']) ?></td>
                        <td>
                            <?php if (!empty($event['image'])): ?>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#photoModal" onclick="viewPhoto('<?= clean_input($event['image']) ?>', 'events')">
                                    <img src="../../assets/events/<?= clean_input($event['image']) ?>" alt="Event Photo" class="event-photo">
                                </a>
                            <?php else: ?>
                                No photo
                            <?php endif; ?>
                        </td>
                        <td><?= clean_input($event['uploaded_by']) ?></td>
                        <td>
                            <button class="btn btn-success btn-sm" onclick="openEventModal('addEditEventModal', <?= $event['event_id'] ?>, 'edit')"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-danger btn-sm" onclick="openEventModal('deleteEventModal', <?= $event['event_id'] ?>, 'delete')"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No event photos found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../adminModals/addEditEvents.php'; ?>
<?php include '../adminModals/deleteEvent.html'; ?>

</body>
</html>
