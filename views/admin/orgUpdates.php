<?php
session_start();
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$orgUpdates = $adminObj->fetchOrgUpdates();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Organization Updates</title>
    <link rel="stylesheet" href="../../css/adminRegistration.css?v=<?php echo time(); ?>">
    <script src="../../js/admin.js"></script>
    <script src="../../js/modals.js"></script>
   <!-- <?php include '../../includes/head.php'; ?>  -->

    <style>
        .org-update-card {
            transition: transform 0.3s;
            margin-bottom: 20px;
        }
        .org-update-card:hover {
            transform: translateY(-5px);
        }
        .update-preview-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 6px 6px 0 0;
        }
        .update-images-preview {
            display: flex;
            overflow-x: auto;
            gap: 10px;
            padding: 10px 0;
        }
        .update-images-preview img {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }
        .search-container {
            margin-bottom: 20px;
        }
    </style>

</head>
<body>

<div>
    <h2 class="mb-4">Organization Updates</h2>

    <div class="row mb-4">
        <div class="col-md-6">
            <button class="btn btn-success" onclick="openUpdateModal('editUpdateModal', null, 'add')">
                <i class="fas fa-plus-circle"></i> Add New Update
            </button>
        </div>
        <div class="col-md-6">
            <div class="search-container">
                <input type="text" id="searchOrgUpdates" class="form-control" placeholder="Search updates...">
            </div>
        </div>
    </div>

    <div class="row" id="orgUpdatesContainer">
        <?php if ($orgUpdates): ?>
            <?php foreach ($orgUpdates as $update): ?>
                <?php 
                $updateImages = $adminObj->getUpdateImages($update['update_id']); 
                $mainImage = !empty($updateImages) ? $updateImages[0]['file_path'] : 'default.jpg';
                ?>
                <div class="col-md-4 org-update-card">
                    <div class="card shadow">
                        <img src="../../assets/updates/<?= clean_input($mainImage) ?>" class="update-preview-img" alt="Update Image">
                        <div class="card-body">
                            <h5 class="card-title"><?= clean_input($update['title']) ?></h5>
                            <p class="card-text text-truncate"><?= clean_input($update['content']) ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted update-author">Posted by: <?= clean_input($update['created_by']) ?></small>
                                <small class="text-muted"><?= date('M d, Y', strtotime($update['created_at'])) ?></small>
                            </div>
                            
                            <?php if (count($updateImages) > 1): ?>
                            <div class="update-images-preview mt-2">
                                <?php foreach ($updateImages as $image): ?>
                                <img src="../../assets/updates/<?= clean_input($image['file_path']) ?>" alt="Update image">
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                            
                            <div class="mt-3">
                                <button class="btn btn-info btn-sm" onclick="openUpdateModal('editUpdateModal', <?= $update['update_id'] ?>, 'edit')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="openUpdateModal('archiveUpdateModal', <?= $update['update_id'] ?>, 'delete')">
                                    <i class="fas fa-archive"></i> Archive
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p>No organization updates found</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../adminModals/addEditUpdates.php'; ?>
<?php include '../adminModals/deleteUpdates.html'; ?>


</body>
</html>