<?php
session_start();
require_once '../../tools/function.php'; 

$userRole = $_SESSION['role'] ?? '';
?>

<head>
    <link rel="stylesheet" href="../../css/sideBar.css">
    <link rel="stylesheet" href="header.css">
</head>

<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark sidebar" id="sidebar">
    <!-- Logo container with adjusted positioning -->
    <div class="logo-container">
        <img src="../../assets/images/msa_logo.png" alt="MSA Logo" class="logo">
        <span class="sidebar-title">Muslim Student Assoc.</span>
    </div>
    <hr class="text-white">

    <ul class="nav nav-pills flex-column mb-auto" style="padding-left: 0;">
        <li class="nav-item">
            <a href="#" onclick="loadDashboardSection()" class="nav-link text-white" style="padding-left: 10px;">
                <i class="bi bi-house-door me-2"></i> <span class="sidebar-text">Dashboard</span>
            </a>
        </li>

        <li class="nav-item dropdown">
            <a href="#" class="nav-link text-white dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="padding-left: 10px;">
                <i class="bi bi-gear me-2"></i> <span class="sidebar-text">School Configuration</span>
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" onclick="loadSchoolConfigSection()">Colleges</a></li>
                <li><a class="dropdown-item" href="#" onclick="loadSchoolConfigSection2()">Programs</a></li>
                <li><a class="dropdown-item" href="#" onclick="loadExecutivePositionsSection()">Executive Positions</a></li>
                <li><a class="dropdown-item" href="#" onclick="loadOthersSection()">Others</a></li>
            </ul>
        </li>

        <li>
            <hr class="text-white">
        </li>
        <li class="nav-item">
            <a href="#" onclick="loadUpdatesSection()" class="nav-link text-white">
            <i class="bi bi-newspaper me-2"></i> <span class="sidebar-text">Updates</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" onclick="loadCalendarSection()" class="nav-link text-white">
                <i class="bi bi-calendar3 me-2"></i> <span class="sidebar-text">Calendar</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" onclick="loadTransparencySection()" class="nav-link text-white">
                <i class="bi bi-clipboard-data me-2"></i> <span class="sidebar-text">Transparency Report</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" onclick="loadAboutsSection()" class="nav-link text-white">
                <i class="bi bi-info-circle me-2"></i> <span class="sidebar-text">Abouts</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" onclick="loadFaqsSection()" class="nav-link text-white">
                <i class="bi bi-question-circle me-2"></i> <span class="sidebar-text">FAQs</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" onclick="loadDownloadablesSection()" class="nav-link text-white">
                <i class="bi bi-arrow-down-circle me-2"></i> <span class="sidebar-text">Downloadables</span>
            </a>
        </li>

        <li>
            <hr class="text-white">
        </li>
        <?php if ($userRole === 'admin'): ?>
        <li class="nav-item">
            <a href="#" onclick="loadEnrollmentSection()" class="nav-link text-white">
                <i class="bi bi-person-bounding-box me-2"></i> <span class="sidebar-text">Enrollment</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" onclick="loadStudentsSection()" class="nav-link text-white">
                <i class="bi bi-person-vcard me-2"></i> <span class="sidebar-text">Students</span>
            </a>
        </li>    
        <?php endif; ?> 
        <li class="nav-item">
            <a href="#" onclick="loadOfficersSection()" class="nav-link text-white">
                <i class="bi bi-person-badge me-2"></i> <span class="sidebar-text">Officers</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" onclick="loadVolunteersSection()" class="nav-link text-white">
                <i class="bi bi-people me-2"></i> <span class="sidebar-text">Volunteers</span>
            </a>
        </li>
        <?php if ($userRole === 'admin'): ?>
        <li class="nav-item">
            <a href="#" onclick="loadRegistrationsSection()" class="nav-link text-white">
                <i class="bi bi-person-plus me-2"></i> <span class="sidebar-text">Registrations</span>
            </a>
        </li>
        <?php endif; ?> 
        <!-- <li class="nav-item">
            <a href="#" onclick="loadDonationSection()" class="nav-link text-white">
                <i class="bi bi-collection me-2"></i> <span class="sidebar-text">Donations</span>
            </a>
        </li> -->

        <?php if ($userRole === 'admin'): ?>
        <li>
            <hr class="text-white">
            <!-- <span class="text-uppercase text-muted small fw-bold sidebar-text">Access Management</span> -->
        </li>
        <li class="nav-item">
            <a href="#" onclick="loadModeratorsSection()" class="nav-link text-white">
                <i class="bi bi-person-gear me-2"></i> <span class="sidebar-text">Moderators</span>
            </a>
        </li>
        <?php endif; ?>
    </ul>
</div>