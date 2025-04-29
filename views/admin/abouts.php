<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';
$adminObj = new Admin();
$abouts = $adminObj->fetchAbouts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About MSA</title>
    <script src="../../js/admin.js"></script>
    <!-- <?php include '../../includes/head.php'; ?>  -->
    <style>
        .about-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .about-card h5 {
            margin-top: 0;
        }
        .about-card .card-actions {
            margin-top: 15px;
            text-align: right;
        }
    </style>
</head>

<body>
<div class="container mt-4">

    <h3>About MSA</h3>

    <button class="btn btn-success mb-4" onclick="openAboutModal('addEditAboutModal', null, 'add')">Add About</button>

    <div id="aboutCards">
        <?php foreach ($abouts as $about): ?>
            <div class="about-card">
                <h5><strong>Mission:</strong></h5>
                <p><?= clean_input($about['mission']) ?></p>

                <h5><strong>Vision:</strong></h5>
                <p><?= clean_input($about['vision']) ?></p>

                <h5><strong>Description:</strong></h5>
                <p><?= clean_input($about['description']) ?></p>

                <small><strong>Created At:</strong> <?= formatDate($about['created_at']) ?></small>

                <div class="card-actions">
                    <button class="btn btn-primary" onclick="openAboutModal('addEditAboutModal', <?= $about['id'] ?>, 'edit')">Edit</button>
                    <button class="btn btn-danger" onclick="openAboutModal('deleteAboutModal', <?= $about['id'] ?>, 'delete')">Delete</button>
                </div>
            </div>
        <?php endforeach ?>
    </div>

</div>

<?php include '../adminModals/addEditAbouts.php'; ?>
<?php include '../adminModals/deleteAbouts.html'; ?>

</body>
</html>
