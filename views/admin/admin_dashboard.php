<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "../../accounts/session.php"; ?>
    <?php include '../../includes/head.php'; ?> 
    <title>Admin Dashboard</title>    
    <link rel="stylesheet" href="../../css/generalAdmin.css">
   <script src="../../js/sideBar.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto min-vh-100 sidebar" id="sidebar">
                <?php include '../../includes/sideBar.php'; ?> 
            </div>

            <div class="col py-3 content-container">
                <?php include '../../includes/topNav.php'; ?>
                <div id="contentArea" class="container mt-4">
                    <?php include 'viewAnalytics.php'; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
