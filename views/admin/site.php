<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';
$adminObj = new Admin();
$sitePages = $adminObj->fetchSitePages();

// Group by page type, keep only the latest entry for each (active or inactive, by updated_at)
$pageTypeLatest = [];
$carouselImages = [];
foreach ($sitePages as $page) {
    if ($page['page_type'] === 'carousel') {
        $carouselImages[] = $page;
    } else {
        // Only keep the latest (by updated_at or page_id)
        if (!isset($pageTypeLatest[$page['page_type']]) || strtotime($page['updated_at']) > strtotime($pageTypeLatest[$page['page_type']]['updated_at'])) {
            $pageTypeLatest[$page['page_type']] = $page;
        }
    }
}
?>

<script src="../../js/admin.js"></script>
<style>
    :root {
        --palestine-green: #0F8A53;
        --palestine-black: #000;
        --palestine-light: #f8f9fa;
        --palestine-hover: #0a6b3f;
        --table-border: #e0e0e0;
    }
    .admin-container {
        max-width: 1200px;
        margin: 0 auto;
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
        font-size: 1rem;
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
    .admin-btn-edit {
        background-color: #000;
        border-color: #000;
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
    .admin-btn-toggle {
        background-color: #fff;
        border-color: var(--palestine-green);
        color: var(--palestine-green);
    }
    .admin-btn-toggle.active {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #fff;
    }
    .admin-btn-toggle.inactive {
        background-color: var(--palestine-green);
        border-color: var(--palestine-green);
        color: #fff;
    }
    .site-card {
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        background: #fff;
        padding: 1.25rem;
        border: 1px solid rgba(15, 138, 83, 0.2);
        overflow-x: auto;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    .site-card-content {
        flex: 1;
    }
    .site-card-actions {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        min-width: 120px;
        align-items: flex-end;
    }
    .badge {
        display: inline-block;
        padding: 0.25em 0.6em;
        font-size: 0.75em;
        font-weight: 500;
        line-height: 1;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.375rem;
    }
    .bg-success { background-color: #198754; }
    .bg-secondary { background-color: #6c757d; }
    .text-muted { color: #6c757d; }
    .text-xs { font-size: 0.85em; }
    .site-card .site-card-content .site-type {
        color: var(--palestine-green);
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }
    .site-card .site-card-content .site-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #222;
        margin-bottom: 0.5rem;
    }
    .site-card .site-card-content .site-desc {
        color: #444;
        margin-bottom: 0.5rem;
    }
    .site-card .site-card-content .site-footer {
        margin-bottom: 0.5rem;
    }
    .site-card .site-card-content .site-footer i {
        color: var(--palestine-green);
        margin-right: 0.5rem;
    }
    .site-card .site-card-content .site-meta {
        margin-top: 0.5rem;
    }
    .site-card .site-card-content .site-meta .badge {
        margin-right: 0.5rem;
    }
    @media (max-width: 768px) {
        .admin-container { padding-top: 1.5rem; }
        .site-card { flex-direction: column; align-items: stretch; }
        .site-card-actions { flex-direction: row; gap: 1rem; margin-top: 1rem; justify-content: flex-end; }
    }
    .cor-photo {
        width: 120px;
        height: 80px;
        border-radius: 6px;
        object-fit: cover;
        background-color: #f0f0f0;
        transition: transform 0.2s ease;
    }
    .cor-photo:hover {
        transform: scale(1.05);
    }
    .logo-photo {
        width: 80px;
        height: 120px;
        border-radius: 6px;
        object-fit: cover;
        background-color: #f0f0f0;
        transition: transform 0.2s ease;
    }
    .logo-photo:hover {
        transform: scale(1.05);
    }
    .carousel-divider {
        border: 0;
        border-top: 2px solid #0a6b3f;
        margin: 1rem 0;
    }
    .site-logo-preview img {
        max-width: 100%;
        height: auto;
        border-radius: 4px;
    }
    .site-background-preview img {
        max-width: 100%;
        height: auto;
        border-radius: 4px;
        object-fit: cover;
    }
</style>
<div class="admin-container">
    <div class="admin-page-header">
        <h3><strong>Site Management</strong></h3>
        <button class="admin-btn admin-btn-add" onclick="openSiteModal('addEditSiteModal', null, 'add')">
            <i class="bi bi-plus-lg"></i>
        </button>
    </div>
    <?php
    $order = ['home','registration','about','volunteer','calendar','faqs','transparency','logo','background','carousel','footer'];
    foreach ($order as $type) {
        if ($type === 'carousel') {
            if (count($carouselImages) > 0) {
                $latestCarousel = array_slice($carouselImages, 0, 4);
                $anyActive = false;
                foreach ($latestCarousel as $carousel) {
                    if ($carousel['is_active']) {
                        $anyActive = true;
                        break;
                    }
                }
                ?>
                <div class="site-card">
                    <div class="site-card-content">
                        <div class="site-type">
                            <?= $adminObj->getPageTypeLabel('carousel') ?>
                        </div>
                        <div class="site-carousel-preview mb-2 d-flex flex-row gap-4">
                            <?php foreach ($latestCarousel as $carousel): ?>
                                <div class="d-flex flex-column align-items-center">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#corView" onclick="viewPhoto('<?= basename($carousel['image_path']) ?>', 'site')">
                                        <img src="../../<?= $carousel['image_path'] ?>" alt="Carousel Image" class="cor-photo">
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="site-meta">
                            <span class="badge <?= $anyActive ? 'bg-success' : 'bg-secondary' ?>">
                                <?= $anyActive ? 'Active' : 'Inactive' ?>
                            </span>
                            <span class="text-xs text-muted">
                                Showing latest 4 carousel images
                            </span>
                        </div>
                    </div>
                    <div class="site-card-actions">
                    <button type="button" class="admin-btn admin-btn-edit" onclick="openSiteModal('editCarouselGroupModal', 'carousel_group', 'edit_carousel_group')">
    <i class="bi bi-pencil"></i>
</button>                        <button type="button" class="admin-btn admin-btn-toggle <?= $anyActive ? 'active' : 'inactive' ?>" onclick="openSiteModal('toggleSiteModal', 'carousel_group', 'toggle', <?= $anyActive ? 'true' : 'false' ?>)">
                            <i class="bi <?= $anyActive ? 'bi-toggle-off' : 'bi-toggle-on' ?>"></i>
                        </button>
                    </div>
                </div>
                <?php
            }
        } else if (isset($pageTypeLatest[$type])) {
            $page = $pageTypeLatest[$type];
            ?>
            <div class="site-card">
                <div class="site-card-content">
                    <div class="site-type">
                        <?= $adminObj->getPageTypeLabel($page['page_type']) ?>
                    </div>
                    <div class="site-title">
                        <?= clean_input($page['title']) ?>
                    </div>
                    <?php if($page['page_type'] === 'logo' && $page['image_path']): ?>
                    <div class="site-logo-preview mb-2">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#photoModal" onclick="viewPhoto('<?= basename($page['image_path']) ?>', 'site')">
                            <img src="../../<?= $page['image_path'] ?>" alt="Logo Preview" class="logo-photo">
                        </a>
                    </div>
                    <?php endif; ?>
                    <?php if($page['page_type'] === 'background' && $page['image_path']): ?>
                    <div class="site-background-preview mb-2">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#photoModal" onclick="viewPhoto('<?= basename($page['image_path']) ?>', 'site')">
                            <img src="../../<?= $page['image_path'] ?>" alt="Background Preview" class="cor-photo">
                        </a>
                    </div>
                    <?php endif; ?>
                    <?php if($page['page_type'] !== 'footer' && $page['description']): ?>
                    <div class="site-desc">
                        <?= clean_input(substr($page['description'], 0, 200)) . (strlen($page['description']) > 200 ? '...' : '') ?>
                    </div>
                    <?php endif; ?>
                    <?php if($page['page_type'] === 'footer'): ?>
                    <div class="site-footer">
                        <i class="bi bi-telephone"></i> <?= $page['contact_no'] ?? 'Not set' ?>
                    </div>
                    <div class="site-footer">
                        <i class="bi bi-envelope"></i> <?= $page['email'] ?? 'Not set' ?>
                    </div>
                    <div class="site-footer">
                        <i class="bi bi-building"></i> <?= $page['org_name'] ?? 'Not set' ?>
                    </div>
                    <div class="site-footer">
                        <i class="bi bi-mortarboard"></i> <?= $page['school_name'] ?? 'Not set' ?>
                    </div>
                    <div class="site-footer">
                        <i class="bi bi-globe"></i> <?= $page['web_name'] ?? 'Not set' ?>
                    </div>
                    <div class="site-footer">
                        <i class="bi bi-facebook"></i> <?php if (!empty($page['fb_link'])): ?><a href="<?= htmlspecialchars($page['fb_link']) ?>" target="_blank">Facebook Page</a><?php else: ?>Not set<?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <div class="site-meta">
                        <span class="badge <?= $page['is_active'] ? 'bg-success' : 'bg-secondary' ?>">
                            <?= $page['is_active'] ? 'Active' : 'Inactive' ?>
                        </span>
                        <span class="text-xs text-muted">
                            Last updated: <?= date('M d, Y', strtotime($page['updated_at'])) ?>
                        </span>
                    </div>
                </div>
                <div class="site-card-actions">
                    <button type="button" class="admin-btn admin-btn-edit" onclick="openSiteModal('addEditSiteModal', <?= $page['page_id'] ?>, 'edit')">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button type="button" class="admin-btn admin-btn-toggle <?= $page['is_active'] ? 'active' : 'inactive' ?>" onclick="openSiteModal('toggleSiteModal', <?= $page['page_id'] ?>, 'toggle', <?= $page['is_active'] ? 'true' : 'false' ?>)">
                        <i class="bi <?= $page['is_active'] ? 'bi-toggle-off' : 'bi-toggle-on' ?>"></i>
                    </button>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>
<?php include '../adminModals/addEditSite.html'; ?>
<?php include '../adminModals/toggleSite.html'; ?>
<?php include '../adminModals/corView.html'; ?>
<?php include '../adminModals/editCarouselGroupModal.html'; ?>