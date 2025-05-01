<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';
$adminObj = new Admin();
$sitePages = $adminObj->fetchSitePages();
?>

<script src="../../js/admin.js"></script>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h2>Site Management</h2>    
</div>

    <div class="row">
        <?php foreach ($sitePages as $page): ?>
            <div class="col-12 mb-4">
                <div class="card <?= $page['is_active'] ? 'border-left-primary' : 'border-left-secondary' ?> shadow h-100 py-3">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-2">
                                        <?= $adminObj->getPageTypeLabel($page['page_type']) ?>
                                    </div>
                                </div>
                                
                                <div class="h5 mb-3 font-weight-bold text-gray-800">
                                    <?= clean_input($page['title']) ?>
                                </div>
                                
                                <div class="mb-3 d-flex align-items-center">
                                    <span class="text-xs">
                                        Last updated: <?= date('M d, Y', strtotime($page['updated_at'])) ?>
                                    </span>
                                </div>
                                
                                <div class="text-gray-600 line-height-1-5">
                                    <?= clean_input(substr($page['description'], 0, 200)) . (strlen($page['description']) > 200 ? '...' : '') ?>
                                </div>
                                <span class="badge <?= $page['is_active'] ? 'bg-success' : 'bg-secondary' ?> py-2 px-3 mr-3">
                                        <?= $page['is_active'] ? 'Active' : 'Inactive' ?>
                                </span>
                            </div>
                            <div class="col-md-2 text-right">
                                <div class="btn-group-vertical w-100" role="group">
                                    <button type="button" class="btn btn-sm btn-primary mb-3 py-2"
                                            onclick="openSiteModal('editSiteModal', <?= $page['page_id'] ?>, 'edit')">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button type="button" class="btn btn-sm <?= $page['is_active'] ? 'btn-warning' : 'btn-success' ?> py-2"
                                            onclick="openSiteModal('toggleSiteModal', <?= $page['page_id'] ?>, 'toggle', <?= $page['is_active'] ? 'true' : 'false' ?>)">
                                        <i class="fas <?= $page['is_active'] ? 'fa-eye-slash' : 'fa-eye' ?>"></i>
                                        <?= $page['is_active'] ? 'Deactivate' : 'Activate' ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include '../adminModals/editSite.html'; ?>
<?php include '../adminModals/deleteSite.html'; ?>

<style>
    .line-height-1-5 {
        line-height: 1.5;
    }
    .badge {
        font-size: 85%;
    }
    .btn-group-vertical .btn {
        text-align: center;
        font-size: 0.9rem;
    }
    .card {
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>

