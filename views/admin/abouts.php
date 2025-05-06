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
    <script src="../../js/modals.js"></script>
    <!-- <?php include '../../includes/head.php'; ?>  -->
    <style>
                :root {
            --palestine-green: #0F8A53;
            --palestine-black:rgb(0, 0, 0);
            --palestine-light: #f8f9fa;
            --palestine-hover: #0a6b3f;
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

        .admin-btn-edit:hover i {
            color: #333;
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

        .about-card {
                    border-radius: 10px;
                    margin-bottom: 20px;
                    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
                    background: #fff;
                    padding: 1.25rem;
                    border: 1px solid rgba(15, 138, 83, 0.2);
                    transition: transform 0.2s ease;
                    
                }
                .title {
                    margin-top: 0;
                    color: var(--palestine-green);
                    font-weight: 600;
                    margin-bottom: 0.75rem;
                }
                
                .about-card .card-actions {
                    display: flex;
                    justify-content: flex-end;
                    gap: 0.5rem;
                    margin-top: 0.75rem;
                }

        @media screen and (max-width: 768px) {
        .admin-container {
            padding: 0.5rem;
        }

        .admin-page-header h3 {
            font-size: 1.3rem;
        }

        .title {
            font-size: 1rem;
        }

        .about-card {
            padding: 1rem;
        }

        .about-card p {
            font-size: 0.95rem;
        }

        .admin-btn {
            padding: 0.35rem 0.7rem;
            font-size: 0.85rem;
        }
    }

    @media screen and (max-width: 576px) {
        .admin-page-header h3 {
            font-size: 1.2rem;
        }

        .title {
            font-size: 0.95rem;
        }

        .about-card {
            padding: 0.875rem;
            margin-bottom: 15px;
        }

        .about-card p {
            font-size: 0.9rem;
            line-height: 1.4;
            margin-bottom: 0.75rem;
        }

        .about-card small {
            font-size: 0.8rem;
        }

        .admin-btn {
            padding: 0.3rem 0.6rem;
            font-size: 0.8rem;
        }

        .admin-btn i {
            font-size: 0.9rem;
        }
    }

    @media screen and (max-width: 375px) {
        .admin-container {
            padding: 0.25rem;
        }

        .admin-page-header h3 {
            font-size: 1.1rem;
        }

        .title {
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .about-card {
            padding: 0.75rem;
            margin-bottom: 12px;
        }

        .about-card p {
            font-size: 0.85rem;
            line-height: 1.3;
            margin-bottom: 0.5rem;
        }

        .about-card small {
            font-size: 0.75rem;
        }

        .card-actions {
            margin-top: 0.5rem;
            gap: 0.25rem;
        }

        .admin-btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .admin-btn i {
            font-size: 0.8rem;
        }
    }
    </style>
</head>

<body>
<div class="admin-container">
    <div class="admin-page-header">
        <h3><strong>About MSA</strong></h3>
        <button class="admin-btn admin-btn-add" onclick="openAboutModal('addEditAboutModal', null, 'add')">
            <i class="bi bi-plus-lg"></i>
        </button>
    </div>
    <div id="aboutCards">
        <?php foreach ($abouts as $about): ?>
            <div class="about-card">
                <p class="title">Mission:</p>
                <p><?= clean_input($about['mission']) ?></p>

                <p class="title">Vision:</p>
                <p><?= clean_input($about['vision']) ?></p>

                <small><strong>Created At:</strong> <?= formatDate($about['created_at']) ?></small>

                <div class="card-actions">
                    <button class="admin-btn admin-btn-edit" onclick="openAboutModal('addEditAboutModal', <?= $about['id'] ?>, 'edit')"><i class="bi bi-pencil"></i></button>
                    <button class="admin-btn admin-btn-delete" onclick="openAboutModal('deleteAboutModal', <?= $about['id'] ?>, 'delete')"><i class="bi bi-trash"></i></button>
                </div>
            </div>
        <?php endforeach ?>
    </div>

</div>
</div>

<?php include '../adminModals/addEditAbouts.php'; ?>
<?php include '../adminModals/deleteAbouts.html'; ?>

</body>
</html>
