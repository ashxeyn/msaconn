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
    <script src="../../js/admin.js"></script>
    <script src="../../js/modals.js"></script>
    <style>

        #editUpdateModal .modal-body {
            max-height: 70vh; 
            overflow-y: auto;
        }

        :root {
            --palestine-green: #0F8A53;
            --palestine-black: rgb(0, 0, 0);
            --palestine-light: #f8f9fa;
            --palestine-hover: #0a6b3f;
            --table-border: #e0e0e0;
        }

        .admin-container {
            max-width: 1200px;
            padding-top: 3rem;
        }

        .admin-page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            border-bottom: 2px solid var(--palestine-green);
            padding: 0.5rem 0;
        }

        .admin-btn {
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            transition: all 0.2s ease;
            border-width: 1.5px;
            border-style: solid;
            box-shadow: none;
        }

        .admin-btn-edit {
            background-color: #000000;
            border-color: #000000;
            color: #fff;
        }

        .admin-btn-edit:hover {
            background-color: #fff;
            color: #333;
            border-color: #333;
        }

        .admin-btn-delete {
            background-color: #fff;
            border-color: #dc3545;
            color: #dc3545;
        }

        .admin-btn-delete:hover {
            background-color: #dc3545;
            color: #fff;
        }

        .admin-btn-add {
            background-color: var(--palestine-green);
            border-color: var(--palestine-green);
            color: #fff;
        }

        .admin-btn-add:hover {
            background-color: var(--palestine-hover);
            transform: translateY(-1px);
        }

        .org-updates-container {
            background: #fff;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            border: 1px solid rgba(15, 138, 83, 0.2);
        }

        .org-update-card {
            height: 100%; 
            display: flex;
            flex-direction: column;
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.1);
        }

        .org-update-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
            border-color: rgba(15, 138, 83, 0.3);
        }

        .update-preview-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-bottom: 1px solid var(--table-border);
        }

        .update-images-preview {
            display: flex;
            overflow-x: auto;
            gap: 10px;
            padding: 10px 0;
            margin: 0 -10px;
        }

        .update-images-preview img {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid var(--table-border);
            transition: transform 0.2s;
        }

        .update-images-preview img:hover {
            transform: scale(1.05);
        }

        .card-body {
            padding: 1.25rem;
        }

        .card-title {
            color: var(--palestine-green);
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .card-text {
            color: #555;
            margin-bottom: 1rem;
        }

        .update-author {
            font-size: 0.85rem;
        }

        .dataTables-style-search {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 1.5rem;
        }

        .dataTables-style-search label {
            display: flex;
            align-items: center;
            margin-bottom: 0;
            font-size: 0.875rem;
        }

        .dataTables-style-search input {
            padding: 0.5rem 0.75rem !important;
            font-size: 0.875rem !important;
            border: 1.5px solid var(--palestine-black) !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
            margin-left: 0.5rem !important;
            width: 200px;
        }

        .dataTables-style-search input:focus {
            outline: none !important;
            border-color: var(--palestine-green) !important;
            box-shadow: 0 0 0 2px rgba(15, 138, 83, 0.25) !important;
        }

        @media (max-width: 768px) {
            .admin-container {
                padding-top: 1.5rem;
            }
            
            .update-preview-img {
                height: 150px;
            }
            
            .card-body {
                padding: 1rem;
            }
            
            .admin-btn {
                padding: 0.3rem 0.6rem;
                font-size: 0.8rem;
            }

            .dataTables-style-search {
                justify-content: flex-start;
            }

            .dataTables-style-search input {
                width: 100%;
                max-width: 300px;
            }
        }

        @media (max-width: 576px) {
            .admin-page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            
            .update-images-preview img {
                width: 60px;
                height: 45px;
            }

            .dataTables-style-search input {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
<div class="admin-container">
    <div class="admin-page-header">
        <h3><strong>Organization Updates</strong></h3>
        <button class="admin-btn admin-btn-add" onclick="openUpdateModal('editUpdateModal', null, 'add')">
            <i class="bi bi-plus-lg"></i>
        </button>
    </div>

    <div class="org-updates-container">
        <div class="dataTables-style-search">
            <label>
                Search:
                <input type="text" id="searchOrgUpdates">
            </label>
        </div>

        <div class="row" id="orgUpdatesContainer">
            <?php if ($orgUpdates): ?>
                <?php foreach ($orgUpdates as $update): ?>
                    <?php 
                    $updateImages = $adminObj->getUpdateImages($update['update_id']); 
                    $mainImage = !empty($updateImages) ? $updateImages[0]['file_path'] : '../../assets/default-update.jpg';
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="org-update-card">
                            <img src="../../assets/updates/<?= clean_input($mainImage) ?>" class="update-preview-img" alt="Update Image">
                            <div class="card-body">
                                <p class="card-title"><?= clean_input($update['title']) ?><p>
                                <p class="card-text"><?= clean_article_content(substr($update['content'], 0, 100)) ?>...</p>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted update-author">Posted by: <?= clean_input($update['created_by']) ?></small>
                                    <small class="text-muted"><?= date('M d, Y', strtotime($update['created_at'])) ?></small>
                                </div>
                                
                                <?php if (count($updateImages) > 1): ?>
                                <div class="update-images-preview">
                                    <?php foreach ($updateImages as $image): ?>
                                    <img src="../../assets/updates/<?= clean_input($image['file_path']) ?>" alt="Update image">
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                                
                                <div class="d-flex gap-2 mt-3">
                                    <button class="admin-btn admin-btn-edit" onclick="openUpdateModal('editUpdateModal', <?= $update['update_id'] ?>, 'edit')">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="admin-btn admin-btn-delete" onclick="openUpdateModal('archiveUpdateModal', <?= $update['update_id'] ?>, 'delete')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-4">
                    <p>No organization updates found</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../adminModals/addEditUpdates.php'; ?>
<?php include '../adminModals/deleteUpdates.html'; ?>
</body>
</html>