<?php
session_start();
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$downloadableFiles = $adminObj->fetchDownloadableFiles();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Downloadable Files</title>
    <link rel="stylesheet" href="../../css/adminRegistration.css?v=<?php echo time(); ?>">
    <script src="../../js/admin.js"></script>
    <script src="../../js/modals.js"></script>
    <!-- <?php include '../../includes/head.php'; ?>  -->

    <style>
        .file-icon {
            font-size: 24px;
            margin-right: 5px;
        }
        .file-size {
            font-size: 12px;
            color: #666;
        }
    </style>

</head>
<body>

<div>
<h2 class="mb-4">File Management</h2>

    <button class="btn btn-success mb-3" onclick="openFileModal('addEditFileModal', null, 'add')">Add File</button>

    <table id="table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>File Name</th>
                <th>File Type</th>
                <th>File Size</th>
                <th>Uploaded By</th>
                <th>Upload Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($downloadableFiles): ?>
                <?php $counter = 1; ?>
                <?php foreach ($downloadableFiles as $file): ?>
                    <tr>
                        <td><?= $counter++ ?></td>
                        <td><?= clean_input($file['file_name']) ?></td>
                        <td><?= $adminObj->getFileExtension(clean_input($file['file_type'])) ?></td>                        <td><span class="file-size"><?= formatFileSize($file['file_size']) ?></span></td>
                        <td><?= clean_input($file['username']) ?></td>
                        <td><?= formatDate($file['created_at']) ?></td>
                        <td>
                            <button class="btn btn-success btn-sm" onclick="openFileModal('addEditFileModal', <?= $file['file_id'] ?>, 'edit')">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="openFileModal('deleteFileModal', <?= $file['file_id'] ?>, 'delete')">Delete</button>
                            <a href="../../assets/downloadables/<?= clean_input($file['file_path']) ?>" class="btn btn-info btn-sm" download>Download</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No downloadable files found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../adminModals/addEditFile.php'; ?>
<?php include '../adminModals/deleteFile.html'; ?>

</body>
</html>