<?php
require_once 'databaseClass.php';

class Admin {

    public $last_name;
    public $first_name;
    public $middle_name; 
    public $position;
    public $image;
    public $school_year;
    public $year;
    public $contact;
    public $email;
    public $program;
    public $section;
    public $cor_file;
    public $officer_id;
    public $status;
    public $user_id;
    public $created_at;
    public $program_id;
    public $school_year_id;
    public $position_id;
    
    protected $db;

    public function __construct() {
        $this->db = new Database();
        $this->db->connect();
    }

    // Officer functions
    function fetchOfficers() {
        $sql = "SELECT 
                    v.officer_id,
                    CONCAT(v.last_name, ', ', v.first_name, ' ', v.middle_name) AS full_name, 
                    p.program_name, 
                    op.position_name, 
                    sy.school_year, 
                    v.image AS image,
                    v.deleted_at
                FROM executive_officers v 
                LEFT JOIN programs p ON v.program_id = p.program_id 
                LEFT JOIN officer_positions op ON v.position_id = op.position_id 
                LEFT JOIN school_years sy ON v.school_year_id = sy.school_year_id
                WHERE v.deleted_at IS NULL
                ORDER BY v.officer_id ASC";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function getOfficerById($officerId) {
        $sql = "SELECT 
                    eo.officer_id,
                    eo.last_name,
                    eo.first_name,
                    eo.middle_name,
                    eo.position_id,
                    eo.image,
                    eo.school_year_id,
                    eo.program_id,
                    eo.deleted_at,
                    p.program_name,
                    op.position_name,
                    sy.school_year
                FROM executive_officers eo
                LEFT JOIN programs p ON eo.program_id = p.program_id
                LEFT JOIN officer_positions op ON eo.position_id = op.position_id
                LEFT JOIN school_years sy ON eo.school_year_id = sy.school_year_id
                WHERE eo.officer_id = :officer_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':officer_id', $officerId);
        $query->execute();
        return $query->fetch();
    }

    function addOfficer($firstName, $middleName, $surname, $position, $program, $schoolYear, $image) {
        $sql = "INSERT INTO executive_officers (last_name, first_name, middle_name, position_id, program_id, school_year_id, image)
                VALUES (:last_name, :first_name, :middle_name, :position, :program, :school_year, :image)";
        
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':last_name', $surname);
        $query->bindParam(':first_name', $firstName);
        $query->bindParam(':middle_name', $middleName);
        $query->bindParam(':position', $position);
        $query->bindParam(':program', $program);
        $query->bindParam(':school_year', $schoolYear);
        $query->bindParam(':image', $image);

        return $query->execute();
    }

    function updateOfficer($officerId, $firstName, $middleName, $surname, $position, $program, $schoolYear, $image) {
        $sql = "UPDATE executive_officers 
                SET last_name = :last_name, 
                    first_name = :first_name, 
                    middle_name = :middle_name, 
                    position_id = :position_id, 
                    program_id = :program_id, 
                    school_year_id = :school_year_id, 
                    image = :image 
                WHERE officer_id = :officer_id";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':first_name', $firstName);
        $query->bindParam(':middle_name', $middleName);
        $query->bindParam(':last_name', $surname);
        $query->bindParam(':position_id', $position);
        $query->bindParam(':program_id', $program);
        $query->bindParam(':school_year_id', $schoolYear);
        $query->bindParam(':image', $image);
        $query->bindParam(':officer_id', $officerId);

        return $query->execute();
    }

    function softDeleteOfficer($officerId, $reason) {
        $sql = "UPDATE executive_officers 
                SET is_deleted = 1, deleted_at = NOW(), reason = :reason 
                WHERE officer_id = :officer_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':reason', $reason);
        $query->bindParam(':officer_id', $officerId);
        return $query->execute();
    }

    function restoreOfficer($officerId) {
        $sql = "UPDATE executive_officers 
                SET is_deleted = 0, deleted_at = NULL, reason = NULL 
                WHERE officer_id = :officer_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':officer_id', $officerId);
        return $query->execute();
    }

    function fetchArchivedOfficers() {
        $sql = "SELECT 
                    eo.officer_id,
                    CONCAT(eo.last_name, ', ', eo.first_name, ' ', eo.middle_name) AS full_name, 
                    p.program_name, 
                    op.position_name, 
                    sy.school_year, 
                    eo.image,
                    eo.reason,
                    eo.deleted_at
                FROM executive_officers eo
                LEFT JOIN programs p ON eo.program_id = p.program_id 
                LEFT JOIN officer_positions op ON eo.position_id = op.position_id 
                LEFT JOIN school_years sy ON eo.school_year_id = sy.school_year_id
                WHERE eo.deleted_at IS NOT NULL
                AND eo.is_deleted = 1
                ORDER BY eo.deleted_at ASC";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    // Volunteer Functions
    function fetchVolunteers() {
        $sql = "SELECT v.volunteer_id, v.first_name, v.middle_name, v.last_name, 
                    v.year AS year_level, v.section, v.program_id, v.contact, 
                    v.email, v.cor_file, v.created_at, v.deleted_at, v.reason,
                    p.program_name
                FROM volunteers v
                JOIN programs p ON v.program_id = p.program_id
                WHERE v.deleted_at IS NULL
                ORDER BY v.volunteer_id ASC";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function getVolunteerById($volunteerId) {
        $sql = "SELECT v.volunteer_id, v.first_name, v.middle_name, v.last_name, 
                    v.year AS year_level, v.section, v.program_id, v.contact, 
                    v.email, v.cor_file, v.status, v.created_at, v.deleted_at,
                    p.program_name
                FROM volunteers v
                JOIN programs p ON v.program_id = p.program_id
                WHERE v.volunteer_id = :volunteer_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':volunteer_id', $volunteerId);
        $query->execute();

        return $query->fetch();
    }

    function addVolunteer($firstName, $middleName, $lastName, $year, $section, $programId, $contact, $email, $corFile) {
        $sql = "INSERT INTO volunteers (first_name, middle_name, last_name, year, section, program_id, contact, email, cor_file) 
                VALUES (:first_name, :middle_name, :last_name, :year, :section, :program_id, :contact, :email, :cor_file)";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':first_name', $firstName);
        $query->bindParam(':middle_name', $middleName);
        $query->bindParam(':last_name', $lastName);
        $query->bindParam(':year', $year);
        $query->bindParam(':section', $section);
        $query->bindParam(':program_id', $programId);
        $query->bindParam(':contact', $contact);
        $query->bindParam(':email', $email);
        $query->bindParam(':cor_file', $corFile);
        return $query->execute();
    }

    function updateVolunteer($volunteerId, $firstName, $middleName, $lastName, $year, $section, $programId, $contact, $email, $corFile = null) {
        $sql = "UPDATE volunteers 
                SET first_name = :first_name, 
                    middle_name = :middle_name,
                    last_name = :last_name, 
                    year = :year, 
                    section = :section, 
                    program_id = :program_id, 
                    contact = :contact, 
                    email = :email";
                    
        if ($corFile !== null && $corFile !== '') {
            $sql .= ", cor_file = :cor_file";
        }
        
        $sql .= " WHERE volunteer_id = :volunteer_id";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':first_name', $firstName);
        $query->bindParam(':middle_name', $middleName);
        $query->bindParam(':last_name', $lastName);
        $query->bindParam(':year', $year);
        $query->bindParam(':section', $section);
        $query->bindParam(':program_id', $programId);
        $query->bindParam(':contact', $contact);
        $query->bindParam(':email', $email);
        $query->bindParam(':volunteer_id', $volunteerId);
        
        if ($corFile !== null && $corFile !== '') {
            $query->bindParam(':cor_file', $corFile);
        }

        return $query->execute();
    }

    function softDeleteVolunteer($volunteerId, $reason) {
        $sql = "UPDATE volunteers 
                SET is_deleted = 1, deleted_at = NOW(), reason = :reason 
                WHERE volunteer_id = :volunteer_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':reason', $reason);
        $query->bindParam(':volunteer_id', $volunteerId);
        return $query->execute();
    }

    function restoreVolunteer($volunteerId) {
        $sql = "UPDATE volunteers 
                SET is_deleted = 0, deleted_at = NULL, reason = NULL 
                WHERE volunteer_id = :volunteer_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':volunteer_id', $volunteerId);
        return $query->execute();
    }

    function fetchArchivedVolunteers() {
        $sql = "SELECT v.volunteer_id,  CONCAT(v.last_name, ', ', v.first_name, ' ', v.middle_name) AS full_name, 
                CONCAT(v.year, '-', v.section) AS yr_section,
                    v.contact, v.email,
                    v.reason, v.deleted_at, p.program_name
                FROM volunteers v
                JOIN programs p ON v.program_id = p.program_id
                WHERE v.deleted_at IS NOT NULL
                AND v.is_deleted = 1
                ORDER BY v.deleted_at ASC";

        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    function fetchPendingVolunteer() { 
        $sql = "SELECT v.volunteer_id, CONCAT(v.last_name, ', ', v.first_name, ' ', v.middle_name) AS full_name, p.program_name, CONCAT(v.year, '-', v.section) AS yr_section, 
                v.contact, v.email, v.cor_file AS cor, v.status FROM volunteers v
                LEFT JOIN programs p ON v.program_id = p.program_id WHERE v.status = 'pending'";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function fetchApprovedVolunteer() { 
        $sql = "SELECT v.volunteer_id, CONCAT(v.last_name, ', ', v.first_name, ' ', v.middle_name) AS full_name, p.program_name, CONCAT(v.year, '-', v.section) AS yr_section, 
                v.contact, v.email, v.cor_file AS cor, v.status, u.username AS registered_by FROM volunteers v 
                LEFT JOIN users u ON v.user_id = u.user_id LEFT JOIN programs p ON v.program_id = p.program_id WHERE v.status = 'approved' AND v.is_deleted = 0";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function fetchRejectedVolunteer() { 
        $sql = "SELECT v.volunteer_id, CONCAT(v.last_name, ', ', v.first_name, ' ', v.middle_name) AS full_name, p.program_name, CONCAT(v.year, '-', v.section) AS yr_section, 
                v.contact, v.email, v.cor_file AS cor, v.status, u.username AS registered_by FROM volunteers v LEFT JOIN users u ON v.registered_by = u.user_id 
                LEFT JOIN programs p ON v.program_id = p.program_id WHERE v.status = 'rejected'";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function approveVolunteer($volunteerId, $adminUserId) {
        $sql = "UPDATE volunteers SET status = 'approved', user_id = :admin_id WHERE volunteer_id = :volunteer_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':admin_id', $adminUserId);
        $query->bindParam(':volunteer_id', $volunteerId);
        if (!$query->execute()) {
            return "Sad di magawa";
        }
        return 1;
    }
    
    function rejectVolunteer($volunteerId, $adminUserId) {
        $sql = "UPDATE volunteers SET status = 'rejected', user_id = :admin_id WHERE volunteer_id = :volunteer_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':admin_id', $adminUserId);
        $query->bindParam(':volunteer_id', $volunteerId);
        if (!$query->execute()) {
            return "Sad di magawa";
        }
        return 1;
    }

    //Moderator functions
    function fetchModerators() { 
        $sql = "SELECT 
                    u.user_id, 
                    CONCAT(u.last_name, ', ', u.first_name, ' ', COALESCE(u.middle_name, '')) AS full_name, 
                    u.username, 
                    u.email, 
                    op.position_name, 
                    u.created_at,
                    u.deleted_at
                FROM users u 
                LEFT JOIN officer_positions op ON u.position_id = op.position_id 
                WHERE u.role = 'sub-admin'
                AND u.deleted_at IS NULL
                AND u.is_deleted = 0
                ORDER BY u.user_id ASC";
    
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    function getModeratorById($moderatorId) {
        $sql = "SELECT 
                    u.user_id,
                    u.first_name,
                    u.middle_name,
                    u.last_name,
                    u.username,
                    u.email,
                    u.position_id,
                    op.position_name,
                    u.created_at,
                    u.is_deleted,
                    u.deleted_at
                FROM users u
                LEFT JOIN officer_positions op ON u.position_id = op.position_id
                WHERE u.user_id = :user_id";
    
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':user_id', $moderatorId);
        $query->execute();
    
        return $query->fetch();
    }

    function addModerator($firstName, $middleName, $lastName, $username, $email, $positionId, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (first_name, middle_name, last_name, username, email, position_id, password, role) 
                VALUES (:first_name, :middle_name, :last_name, :username, :email, :position_id, :password, 'sub-admin')";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':first_name', $firstName);
        $query->bindParam(':middle_name', $middleName);
        $query->bindParam(':last_name', $lastName);
        $query->bindParam(':username', $username);
        $query->bindParam(':email', $email);
        $query->bindParam(':position_id', $positionId);
        $query->bindParam(':password', $hashedPassword);
        
        return $query->execute();
    }
    
    function updateModerator($moderatorId, $firstName, $middleName, $lastName, $username, $email, $positionId) {
        $sql = "UPDATE users 
                SET first_name = :first_name, 
                    middle_name = :middle_name, 
                    last_name = :last_name, 
                    username = :username, 
                    email = :email, 
                    position_id = :position_id
                WHERE user_id = :user_id";
        
        $query = $this->db->connect()->prepare($sql);
    
        $query->bindParam(':first_name', $firstName);
        $query->bindParam(':middle_name', $middleName);
        $query->bindParam(':last_name', $lastName);
        $query->bindParam(':username', $username);
        $query->bindParam(':email', $email);
        $query->bindParam(':position_id', $positionId);
        $query->bindParam(':user_id', $moderatorId);
    
        return $query->execute();
    }
    
    function softDeleteModerator($moderatorId, $reason) {
        $sql = "UPDATE users 
                SET is_deleted = 1, deleted_at = NOW(), reason = :reason 
                WHERE user_id = :user_id";
    
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':reason', $reason);
        $query->bindParam(':user_id', $moderatorId);
        return $query->execute();
    }
    
    function restoreModerator($moderatorId) {
        $sql = "UPDATE users 
                SET is_deleted = 0, deleted_at = NULL, reason = NULL 
                WHERE user_id = :user_id";
    
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':user_id', $moderatorId);
        return $query->execute();
    }
    
    function fetchArchivedModerators() {
        $sql = "SELECT 
                    u.user_id,
                    CONCAT(u.last_name, ', ', u.first_name, ' ', COALESCE(u.middle_name, '')) AS full_name,
                    u.username,
                    u.email,
                    op.position_name,
                    u.reason,
                    u.deleted_at
                FROM users u
                LEFT JOIN officer_positions op ON u.position_id = op.position_id
                WHERE u.role = 'sub-admin'
                AND u.is_deleted = 1
                AND u.deleted_at IS NOT NULL
                ORDER BY u.deleted_at ASC";
    
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function getModerators() {
        $sql = "SELECT COUNT(*) AS total FROM users WHERE role = 'sub-admin' AND deleted_at IS NULL AND is_deleted = 0";   
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        
        $result = $query->fetch();
        return $result['total'] ?? 0;
    }

    function getVolunteersByYear() {
        $sql = "SELECT YEAR(created_at) AS year, COUNT(*) AS count FROM volunteers GROUP BY year";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        
        $data = [];
        while ($row = $query->fetch()) {
            $data['labels'][] = $row['year'];
            $data['volunteers'][] = $row['count'];
        }
        return $data;
    }

    // School Config Functions
    function getProgramById($programId) {
        $sql = "SELECT * FROM programs WHERE program_id = :program_id";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':program_id', $programId);
        $query->execute();
    
        return $query->fetch();
    }

    function getCollegeById($collegeId) {
        $sql = "SELECT * FROM colleges WHERE college_id = :college_id";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':college_id', $collegeId);
        $query->execute();
    
        return $query->fetch();
    }

    function fetchColleges() {
        $sql = "SELECT * FROM colleges WHERE is_deleted = 0 ORDER BY college_name";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        
        return $query->fetchAll();
    }

    function fetchArchivedColleges() {
        $sql = "SELECT * FROM colleges WHERE is_deleted = 1 ORDER BY college_name";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        
        return $query->fetchAll();
    }

    function fetchProgramsByCollege($collegeId) {
        $sql = "SELECT * FROM programs WHERE college_id = :college_id AND is_deleted = 0 ORDER BY program_name";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':college_id', $collegeId);
        $query->execute();
        
        return $query->fetchAll();
    }

    function fetchAllPrograms() {
        $sql = "SELECT p.*, c.college_name 
                FROM programs p 
                JOIN colleges c ON p.college_id = c.college_id 
                WHERE p.is_deleted = 0 
                ORDER BY c.college_name, p.program_name";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        
        return $query->fetchAll();
    }

    function fetchArchivedPrograms() {
        $sql = "SELECT p.*, c.college_name 
                FROM programs p 
                JOIN colleges c ON p.college_id = c.college_id 
                WHERE p.is_deleted = 1 
                ORDER BY c.college_name, p.program_name";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        
        return $query->fetchAll();
    }

    function addProgram($programName, $collegeId) {
        $sql = "INSERT INTO programs (program_name, college_id, is_deleted) VALUES (:program_name, :college_id, 0)";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':program_name', $programName);
        $query->bindParam(':college_id', $collegeId);
        
        return $query->execute();
    }

    function updateProgram($programId, $programName, $collegeId) {
        $sql = "UPDATE programs 
                SET program_name = :program_name, 
                    college_id = :college_id
                WHERE program_id = :program_id";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':program_name', $programName);
        $query->bindParam(':college_id', $collegeId);
        $query->bindParam(':program_id', $programId);
        
        return $query->execute();
    }

    function softDeleteProgram($programId, $reason) {
        $sql = "UPDATE programs 
                SET is_deleted = 1, 
                    reason = :reason,
                    deleted_at = NOW()
                WHERE program_id = :program_id";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':program_id', $programId);
        $query->bindParam(':reason', $reason);
        
        return $query->execute();
    }

    function restoreProgram($programId) {
        $sql = "UPDATE programs 
                SET is_deleted = 0, 
                    reason = NULL,
                    deleted_at = NULL
                WHERE program_id = :program_id";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':program_id', $programId);
        
        return $query->execute();
    }

    function addCollege($collegeName) {
        $sql = "INSERT INTO colleges (college_name, is_deleted) VALUES (:college_name, 0)";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':college_name', $collegeName);
        
        return $query->execute();
    }

    function updateCollege($collegeId, $collegeName) {
        $sql = "UPDATE colleges 
                SET college_name = :college_name
                WHERE college_id = :college_id";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':college_name', $collegeName);
        $query->bindParam(':college_id', $collegeId);
        
        return $query->execute();
    }

    function softDeleteCollege($collegeId, $reason) {
        $sql = "UPDATE colleges 
                SET is_deleted = 1, 
                    reason = :reason,
                    deleted_at = NOW() 
                WHERE college_id = :college_id";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':college_id', $collegeId);
        $query->bindParam(':reason', $reason);
        
        return $query->execute();
    }

    function restoreCollege($collegeId) {
        $sql = "UPDATE colleges 
                SET is_deleted = 0, 
                    reason = NULL,
                    deleted_at = NULL
                WHERE college_id = :college_id";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':college_id', $collegeId);
        
        return $query->execute();
    }

    // Analytics Functions
    function getVolunteersPerMonth($startDate = null, $endDate = null) {
        $sql = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, COUNT(*) AS total
                FROM volunteers
                WHERE status = 'approved'";

        if ($startDate && $endDate) {
            $sql .= " AND created_at BETWEEN :start_date AND :end_date";
        } else if ($startDate) {
            $sql .= " AND created_at >= :start_date";
        } else if ($endDate) {
            $sql .= " AND created_at <= :end_date";
        }

        $sql .= " GROUP BY month
                 ORDER BY month ASC";

        $query = $this->db->connect()->prepare($sql);
        if ($startDate && $endDate) {
            $query->bindParam(':start_date', $startDate);
            $query->bindParam(':end_date', $endDate);
        } else if ($startDate) {
            $query->bindParam(':start_date', $startDate);
        } else if ($endDate) {
            $query->bindParam(':end_date', $endDate);
        }
        $query->execute();
        return $query->fetchAll();
    }

    function getCashFlowPerMonth($startDate = null, $endDate = null) {
        $sql = "SELECT
                    DATE_FORMAT(report_date, '%Y-%m') AS month,
                    SUM(CASE WHEN transaction_type = 'Cash In' THEN amount ELSE 0 END) AS total_cashin,
                    SUM(CASE WHEN transaction_type = 'Cash Out' THEN amount ELSE 0 END) AS total_cashout,
                    (SELECT SUM(CASE WHEN transaction_type = 'Cash In' THEN amount ELSE 0 END) -
                            SUM(CASE WHEN transaction_type = 'Cash Out' THEN amount ELSE 0 END)
                     FROM transparency_report AS sub
                     WHERE DATE_FORMAT(sub.report_date, '%Y-%m') <= DATE_FORMAT(main.report_date, '%Y-%m')";
        if ($startDate && $endDate) {
            $sql .= " AND sub.report_date BETWEEN :start_date AND :end_date";
        } else if ($startDate) {
            $sql .= " AND sub.report_date >= :start_date";
        } else if ($endDate) {
            $sql .= " AND sub.report_date <= :end_date";
        }
        $sql .= ") AS net_money
                FROM transparency_report AS main";
        if ($startDate && $endDate) {
            $sql .= " WHERE main.report_date BETWEEN :start_date AND :end_date";
        } else if ($startDate) {
            $sql .= " WHERE main.report_date >= :start_date";
        } else if ($endDate) {
            $sql .= " WHERE main.report_date <= :end_date";
        }
        $sql .= " GROUP BY month
                 ORDER BY month ASC";

        $query = $this->db->connect()->prepare($sql);
        if ($startDate && $endDate) {
            $query->bindParam(':start_date', $startDate);
            $query->bindParam(':end_date', $endDate);
        } else if ($startDate) {
            $query->bindParam(':start_date', $startDate);
        } else if ($endDate) {
            $query->bindParam(':end_date', $endDate);
        }
        $query->execute();
        return $query->fetchAll();
    }

    function getApprovedVolunteers($startDate = null, $endDate = null) {
        $sql = "SELECT COUNT(*) AS total FROM volunteers WHERE status = 'approved'";
        if ($startDate && $endDate) {
            $sql .= " AND created_at BETWEEN :start_date AND :end_date";
        } else if ($startDate) {
            $sql .= " AND created_at >= :start_date";
        } else if ($endDate) {
            $sql .= " AND created_at <= :end_date";
        }
        $query = $this->db->connect()->prepare($sql);
        if ($startDate && $endDate) {
            $query->bindParam(':start_date', $startDate);
            $query->bindParam(':end_date', $endDate);
        } else if ($startDate) {
            $query->bindParam(':start_date', $startDate);
        } else if ($endDate) {
            $query->bindParam(':end_date', $endDate);
        }
        $query->execute();

        $result = $query->fetch();
        return $result['total'] ?? 0;
    }

    function getPedingVolunteers($startDate = null, $endDate = null) {
        $sql = "SELECT COUNT(*) AS total FROM volunteers WHERE status = 'pending'";
        if ($startDate && $endDate) {
            $sql .= " AND created_at BETWEEN :start_date AND :end_date";
        } else if ($startDate) {
            $sql .= " AND created_at >= :start_date";
        } else if ($endDate) {
            $sql .= " AND created_at <= :end_date";
        }
        $query = $this->db->connect()->prepare($sql);
        if ($startDate && $endDate) {
            $query->bindParam(':start_date', $startDate);
            $query->bindParam(':end_date', $endDate);
        } else if ($startDate) {
            $query->bindParam(':start_date', $startDate);
        } else if ($endDate) {
            $query->bindParam(':end_date', $endDate);
        }
        $query->execute();

        $result = $query->fetch();
        return $result['total'] ?? 0;
    }

    // FAQs Functions
    function fetchFaqs() {
        $sql = "SELECT f.faq_id, f.question, f.answer, f.category, f.created_at, f.deleted_at, f.reason
                FROM faqs f
                WHERE f.is_deleted = 0
                ORDER BY f.category ASC";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function getFaqById($faqId) {
        $sql = "SELECT * FROM faqs WHERE faq_id = :faq_id";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':faq_id', $faqId);
        $query->execute();

        return $query->fetch();
    }

    function updateFaq($faqId, $question, $answer, $category) {
        $sql = "UPDATE faqs 
                SET question = :question, 
                    answer = :answer, 
                    category = :category
                WHERE faq_id = :faq_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':question', $question);
        $query->bindParam(':answer', $answer);
        $query->bindParam(':category', $category);
        $query->bindParam(':faq_id', $faqId);

        return $query->execute();
    }

    function addFaq($question, $answer, $category, $userId) {
        $sql = "INSERT INTO faqs (question, answer, category) 
                VALUES (:question, :answer, :category)";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':question', $question);
        $query->bindParam(':answer', $answer);
        $query->bindParam(':category', $category);

        return $query->execute();
    }

    function softDeleteFaq($faqId, $reason) {
        $sql = "UPDATE faqs 
                SET is_deleted = 1,
                    deleted_at = NOW(), 
                    reason = :reason 
                WHERE faq_id = :faq_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':reason', $reason);
        $query->bindParam(':faq_id', $faqId);
        return $query->execute();
    }

    function restoreFaq($faqId) {
        $sql = "UPDATE faqs 
                SET is_deleted = 0,
                    deleted_at = NULL, 
                    reason = NULL 
                WHERE faq_id = :faq_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':faq_id', $faqId);
        return $query->execute();
    }

    function fetchArchivedFaqs() {
        $sql = "SELECT faq_id, question, answer, category, reason, deleted_at
                FROM faqs 
                WHERE is_deleted = 1
                ORDER BY deleted_at DESC";
    
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    // Events Functions
    function fetchEventPhotos() {
        $sql = "SELECT e.event_id, e.image, e.description, e.created_at, e.deleted_at,
                    u.username AS uploaded_by 
                FROM events e
                LEFT JOIN users u ON e.uploaded_by = u.user_id
                WHERE e.deleted_at IS NULL
                ORDER BY e.event_id ASC";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function getEventById($eventId) {
        $sql = "SELECT e.event_id, e.image, e.description, e.created_at, e.deleted_at,
                    u.username AS uploaded_by 
                FROM events e
                LEFT JOIN users u ON e.uploaded_by = u.user_id
                WHERE e.event_id = :event_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':event_id', $eventId);
        $query->execute();
        return $query->fetch();
    }

    function addEvent($description, $image, $userId) {
        $sql = "INSERT INTO events (description, image, uploaded_by) 
                VALUES (:description, :image, :uploaded_by)";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':description', $description);
        $query->bindParam(':image', $image);
        $query->bindParam(':uploaded_by', $userId);
        return $query->execute();
    }

    function updateEvent($eventId, $description, $image) {
        $sql = "UPDATE events 
                SET description = :description, image = :image 
                WHERE event_id = :event_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':description', $description);
        $query->bindParam(':image', $image);
        $query->bindParam(':event_id', $eventId);
        return $query->execute();
    }

    function softDeleteEvent($eventId, $reason) {
        $sql = "UPDATE events 
                SET is_deleted = 1, 
                    reason = :reason,
                    deleted_at = NOW() 
                WHERE event_id = :event_id";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':event_id', $eventId);
        $query->bindParam(':reason', $reason);
        
        return $query->execute();
    }

    function restoreEvent($eventId) {
        $sql = "UPDATE events 
                SET is_deleted = 0, deleted_at = NULL, reason = NULL 
                WHERE event_id = :event_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':event_id', $eventId);
        return $query->execute();
    }

    function fetchArchivedEvents() {
        $sql = "SELECT e.event_id, e.description, e.reason, e.deleted_at,
                    u.username AS uploaded_by
                FROM events e
                LEFT JOIN users u ON e.uploaded_by = u.user_id
                WHERE e.deleted_at IS NOT NULL
                ORDER BY e.deleted_at ASC";

        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    // Calendar Functions
    function fetchCalendarEvents() {
        $sql = "SELECT ca.activity_id, ca.activity_date, ca.title, ca.description, ca.created_at, ca.deleted_at,
                    u.username 
                FROM calendar_activities ca
                LEFT JOIN users u ON ca.created_by = u.user_id
                WHERE ca.deleted_at IS NULL
                ORDER BY ca.activity_date ASC";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    function getCalendarEventById($activityId) {
        $sql = "SELECT ca.activity_id, ca.activity_date, ca.title, ca.description, ca.created_at, ca.deleted_at,
                    u.username
                FROM calendar_activities ca
                LEFT JOIN users u ON ca.created_by = u.user_id
                WHERE ca.activity_id = :activity_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':activity_id', $activityId);
        $query->execute();
        return $query->fetch();
    }
    
    function addCalendarEvent($activityDate, $title, $description, $userId) {
        $sql = "INSERT INTO calendar_activities (activity_date, title, description, created_by) 
                VALUES (:activity_date, :title, :description, :created_by)";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':activity_date', $activityDate);
        $query->bindParam(':title', $title);
        $query->bindParam(':description', $description);
        $query->bindParam(':created_by', $userId);
        return $query->execute();
    }
    
    function updateCalendarEvent($activityId, $activityDate, $title, $description) {
        $sql = "UPDATE calendar_activities 
                SET activity_date = :activity_date, title = :title, description = :description 
                WHERE activity_id = :activity_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':activity_date', $activityDate);
        $query->bindParam(':title', $title);
        $query->bindParam(':description', $description);
        $query->bindParam(':activity_id', $activityId);
        return $query->execute();
    }
    
    function softDeleteCalendarEvent($activityId, $reason) {
        $sql = "UPDATE calendar_activities 
                SET is_deleted = 1, 
                    reason = :reason,
                    deleted_at = NOW() 
                WHERE activity_id = :activity_id";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':activity_id', $activityId);
        $query->bindParam(':reason', $reason);
        
        return $query->execute();
    }
    
    function restoreCalendarEvent($activityId) {
        $sql = "UPDATE calendar_activities 
                SET is_deleted = 0, deleted_at = NULL, reason = NULL 
                WHERE activity_id = :activity_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':activity_id', $activityId);
        return $query->execute();
    }
    
    function fetchArchivedCalendar() {
        $sql = "SELECT ca.activity_id, ca.activity_date, ca.title, ca.description, ca.reason, ca.deleted_at,
                    u.username
                FROM calendar_activities ca
                LEFT JOIN users u ON ca.created_by = u.user_id
                WHERE ca.deleted_at IS NOT NULL
                ORDER BY ca.deleted_at ASC";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    // Prayer Schedule Functions
    function fetchFridayPrayers() {
        $sql = "SELECT fp.*, u.username 
                FROM friday_prayers fp 
                LEFT JOIN users u ON u.user_id = fp.created_by 
                WHERE fp.deleted_at IS NULL
                ORDER BY fp.khutbah_date ASC";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    function getPrayerScheduleById($prayerId) {
        $sql = "SELECT fp.*, u.username 
                FROM friday_prayers fp 
                LEFT JOIN users u ON u.user_id = fp.created_by 
                WHERE fp.prayer_id = :prayer_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':prayer_id', $prayerId);
        $query->execute();
        return $query->fetch();
    }
    
    function addPrayerSchedule($date, $speaker, $topic, $location, $created_by) {
        $sql = "INSERT INTO friday_prayers (khutbah_date, speaker, topic, location, created_by) 
                VALUES (:khutbah_date, :speaker, :topic, :location, :created_by)";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':khutbah_date', $date);
        $query->bindParam(':speaker', $speaker);
        $query->bindParam(':topic', $topic);
        $query->bindParam(':location', $location);
        $query->bindParam(':created_by', $created_by);
        return $query->execute();
    }
    
    function updatePrayerSchedule($prayerId, $date, $speaker, $topic, $location) {
        $sql = "UPDATE friday_prayers SET khutbah_date = :khutbah_date, speaker = :speaker, topic = :topic, location = :location WHERE prayer_id = :prayer_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':khutbah_date', $date);
        $query->bindParam(':speaker', $speaker);
        $query->bindParam(':topic', $topic);
        $query->bindParam(':location', $location);
        $query->bindParam(':prayer_id', $prayerId);
        return $query->execute();
    }
    
    function softDeletePrayerSchedule($prayerId, $reason) {
        $sql = "UPDATE friday_prayers 
                SET is_deleted = 1, 
                    reason = :reason,
                    deleted_at = NOW() 
                WHERE prayer_id = :prayer_id";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':prayer_id', $prayerId);
        $query->bindParam(':reason', $reason);
        
        return $query->execute();
    }
    
    function restorePrayerSchedule($prayerId) {
        $sql = "UPDATE friday_prayers 
                SET is_deleted = 0, deleted_at = NULL, reason = NULL 
                WHERE prayer_id = :prayer_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':prayer_id', $prayerId);
        return $query->execute();
    }
    
    function fetchArchivedPrayers() {
        $sql = "SELECT prayer_id, khutbah_date, speaker, topic, location, reason, deleted_at
                FROM friday_prayers
                WHERE deleted_at IS NOT NULL
                ORDER BY deleted_at ASC";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    // Transparency Report Functions
    function getCashInTransactions($schoolYearId = null, $semester = null, $month = null, $startDate = null, $endDate = null) {
        $sql = "SELECT * FROM transparency_report WHERE transaction_type = 'Cash In' AND deleted_at IS NULL";
        
        if ($schoolYearId) {
            $sql .= " AND school_year_id = :school_year_id";
        }
        
        if ($semester) {
            $sql .= " AND semester = :semester";
        }
        
        if ($startDate && $endDate) {
            $sql .= " AND report_date BETWEEN :start_date AND :end_date";
        } else if ($startDate) {
            $sql .= " AND report_date >= :start_date";
        } else if ($endDate) {
            $sql .= " AND report_date <= :end_date";
        } else if ($month) {
            $sql .= " AND MONTH(report_date) = :month";
        }
        
        $sql .= " ORDER BY report_date DESC";
        
        $query = $this->db->connect()->prepare($sql);
        
        if ($schoolYearId) {
            $query->bindParam(':school_year_id', $schoolYearId);
        }
        
        if ($semester) {
            $query->bindParam(':semester', $semester);
        }
        
        if ($startDate && $endDate) {
            $query->bindParam(':start_date', $startDate);
            $query->bindParam(':end_date', $endDate);
        } else if ($startDate) {
            $query->bindParam(':start_date', $startDate);
        } else if ($endDate) {
            $query->bindParam(':end_date', $endDate);
        } else if ($month) {
            $query->bindParam(':month', $month);
        }
        
        $query->execute();
        return $query->fetchAll();
    }

    function getCashOutTransactions($schoolYearId = null, $semester = null, $month = null, $startDate = null, $endDate = null) {
        $sql = "SELECT * FROM transparency_report WHERE transaction_type = 'Cash Out' AND deleted_at IS NULL";
        
        if ($schoolYearId) {
            $sql .= " AND school_year_id = :school_year_id";
        }
        
        if ($semester) {
            $sql .= " AND semester = :semester";
        }
        
        if ($startDate && $endDate) {
            $sql .= " AND report_date BETWEEN :start_date AND :end_date";
        } else if ($startDate) {
            $sql .= " AND report_date >= :start_date";
        } else if ($endDate) {
            $sql .= " AND report_date <= :end_date";
        } else if ($month) {
            $sql .= " AND MONTH(report_date) = :month";
        }
        
        $sql .= " ORDER BY report_date ASC";
        
        $query = $this->db->connect()->prepare($sql);
        
        if ($schoolYearId) {
            $query->bindParam(':school_year_id', $schoolYearId);
        }
        
        if ($semester) {
            $query->bindParam(':semester', $semester);
        }
        
        if ($startDate && $endDate) {
            $query->bindParam(':start_date', $startDate);
            $query->bindParam(':end_date', $endDate);
        } else if ($startDate) {
            $query->bindParam(':start_date', $startDate);
        } else if ($endDate) {
            $query->bindParam(':end_date', $endDate);
        } else if ($month) {
            $query->bindParam(':month', $month);
        }
        
        $query->execute();
        return $query->fetchAll();
    }

    function getTransactionById($reportId) {
        $sql = "SELECT * FROM transparency_report WHERE report_id = :report_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':report_id', $reportId);
        $query->execute();
        return $query->fetch();
    }

    function addTransparencyTransaction($reportDate, $expenseDetail, $expenseCategory, $amount, $transactionType, $semester, $schoolYearId) {
        $sql = "INSERT INTO transparency_report 
                (report_date, expense_detail, expense_category, amount, transaction_type, semester, school_year_id) 
                VALUES (:report_date, :expense_detail, :expense_category, :amount, :transaction_type, :semester, :school_year_id)";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':report_date', $reportDate);
        $query->bindParam(':expense_detail', $expenseDetail);
        $query->bindParam(':expense_category', $expenseCategory);
        $query->bindParam(':amount', $amount);
        $query->bindParam(':transaction_type', $transactionType);
        $query->bindParam(':semester', $semester);
        $query->bindParam(':school_year_id', $schoolYearId);
        return $query->execute();
    }

    function updateTransparencyTransaction($reportId, $reportDate, $expenseDetail, $expenseCategory, $amount, $transactionType, $semester, $schoolYearId) {
        $sql = "UPDATE transparency_report 
                SET report_date = :report_date, 
                    expense_detail = :expense_detail, 
                    expense_category = :expense_category,
                    amount = :amount, 
                    transaction_type = :transaction_type, 
                    semester = :semester, 
                    school_year_id = :school_year_id 
                WHERE report_id = :report_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':report_date', $reportDate);
        $query->bindParam(':expense_detail', $expenseDetail);
        $query->bindParam(':expense_category', $expenseCategory);
        $query->bindParam(':amount', $amount);
        $query->bindParam(':transaction_type', $transactionType);
        $query->bindParam(':semester', $semester);
        $query->bindParam(':school_year_id', $schoolYearId);
        $query->bindParam(':report_id', $reportId);
        return $query->execute();
    }

    function softDeleteTransaction($reportId, $reason) {
        $sql = "UPDATE transparency_report 
                SET is_deleted = 1, 
                    reason = :reason,
                    deleted_at = NOW() 
                WHERE report_id = :report_id";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':report_id', $reportId);
        $query->bindParam(':reason', $reason);
        
        return $query->execute();
    }

    function restoreTransaction($reportId) {
        $sql = "UPDATE transparency_report 
                SET is_deleted = 0, deleted_at = NULL, reason = NULL 
                WHERE report_id = :report_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':report_id', $reportId);
        return $query->execute();
    }

    function fetchArchivedTransactions($transactionType) {
        $sql = "SELECT * FROM transparency_report 
                WHERE transaction_type = :transaction_type 
                AND deleted_at IS NOT NULL 
                ORDER BY deleted_at DESC";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':transaction_type', $transactionType);
        $query->execute();
        return $query->fetchAll();
    }

    function getAllSchoolYears() {
        $sql = "SELECT * FROM school_years ORDER BY school_year ASC";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function getCurrentSchoolYear() {
        $sql = "SELECT * FROM school_years ORDER BY school_year DESC LIMIT 1";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    // ABOUTS Functions
    function fetchAbouts() {
        $sql = "SELECT * FROM about_msa 
                WHERE is_deleted = 0
                ORDER BY id ASC";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        
        return $query->fetchAll();
    }

    function getAboutById($aboutId) {
        $sql = "SELECT * FROM about_msa WHERE id = :about_id";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':about_id', $aboutId);
        $query->execute();

        return $query->fetch();
    }

    function addAbout($mission, $vision, $description) {
        $sql = "INSERT INTO about_msa (mission, vision, description) 
                VALUES (:mission, :vision, :description)";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':mission', $mission);
        $query->bindParam(':vision', $vision);
        $query->bindParam(':description', $description);

        return $query->execute();
    }

    function updateAbout($aboutId, $mission, $vision, $description) {
        $sql = "UPDATE about_msa 
                SET mission = :mission, 
                    vision = :vision, 
                    description = :description
                WHERE id = :about_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':mission', $mission);
        $query->bindParam(':vision', $vision);
        $query->bindParam(':description', $description);
        $query->bindParam(':about_id', $aboutId);

        return $query->execute();
    }

    function softDeleteAbout($aboutId, $reason) {
        $sql = "UPDATE about_msa 
                SET is_deleted = 1, 
                    deleted_at = NOW(), 
                    reason = :reason 
                WHERE id = :about_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':reason', $reason);
        $query->bindParam(':about_id', $aboutId);

        return $query->execute();
    }

    function restoreAbout($aboutId) {
        $sql = "UPDATE about_msa 
                SET is_deleted = 0, 
                    deleted_at = NULL, 
                    reason = NULL 
                WHERE id = :about_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':about_id', $aboutId);

        return $query->execute();
    }

    function fetchArchivedAbouts() {
        $sql = "SELECT * FROM about_msa 
                WHERE is_deleted = 1
                ORDER BY deleted_at ASC";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        
        return $query->fetchAll();
        // var_dump($result);
    }

    // FILE FUNCTIONS
    function fetchDownloadableFiles() {
        $sql = "SELECT f.file_id, f.file_name, f.file_path, f.file_type, f.file_size, 
                    f.created_at, f.deleted_at, u.username AS username 
                FROM downloadable_files f
                LEFT JOIN users u ON f.user_id = u.user_id
                WHERE f.deleted_at IS NULL
                ORDER BY f.file_id ASC";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function getFileById($fileId) {
        $sql = "SELECT f.file_id, f.file_name, f.file_path, f.file_type, f.file_size, 
                    f.created_at, f.deleted_at, u.username AS uploaded_by 
                FROM downloadable_files f
                LEFT JOIN users u ON f.user_id = u.user_id
                WHERE f.file_id = :file_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':file_id', $fileId);
        $query->execute();
        return $query->fetch();
    }

    function addFile($fileName, $filePath, $fileType, $fileSize, $userId) {
        $sql = "INSERT INTO downloadable_files (file_name, file_path, file_type, file_size, user_id) 
                VALUES (:file_name, :file_path, :file_type, :file_size, :user_id)";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':file_name', $fileName);
        $query->bindParam(':file_path', $filePath);
        $query->bindParam(':file_type', $fileType);
        $query->bindParam(':file_size', $fileSize);
        $query->bindParam(':user_id', $userId);
        return $query->execute();
    }

    function updateFile($fileId, $fileName, $filePath, $fileType, $fileSize) {
        $sql = "UPDATE downloadable_files 
                SET file_name = :file_name, file_path = :file_path, 
                    file_type = :file_type, file_size = :file_size 
                WHERE file_id = :file_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':file_name', $fileName);
        $query->bindParam(':file_path', $filePath);
        $query->bindParam(':file_type', $fileType);
        $query->bindParam(':file_size', $fileSize);
        $query->bindParam(':file_id', $fileId);
        return $query->execute();
    }

    function softDeleteFile($fileId, $reason) {
        $sql = "UPDATE downloadable_files 
                SET is_deleted = 1, deleted_at = NOW(), reason = :reason 
                WHERE file_id = :file_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':reason', $reason);
        $query->bindParam(':file_id', $fileId);
        return $query->execute();
    }

    function restoreFile($fileId) {
        $sql = "UPDATE downloadable_files 
                SET is_deleted = 0, deleted_at = NULL, reason = NULL 
                WHERE file_id = :file_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':file_id', $fileId);
        return $query->execute();
    }

    function fetchArchivedFiles() {
        $sql = "SELECT f.file_id, f.file_name, f.file_path, f.file_type, f.file_size, 
                    f.reason, f.deleted_at, u.username AS uploaded_by
                FROM downloadable_files f
                LEFT JOIN users u ON f.user_id = u.user_id
                WHERE f.deleted_at IS NOT NULL
                ORDER BY f.deleted_at ASC";

        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function getFileExtension($fileType) {
        $extensions = [
            'application/pdf' => 'PDF',
            'application/vnd.openxmlformats-officedocument.word' => 'DOCX'
        ];
        
        return $extensions[$fileType] ?? $fileType;
    }

    // Madrasa Enrollment and Students Functions
    function addMadrasaEnrollment($data) {
        $sql = "INSERT INTO madrasa_enrollment 
                (first_name, middle_name, last_name, classification, address, 
                college_id, program_id, year_level, school, cor_path, email, contact_number)
                VALUES 
                (:first_name, :middle_name, :last_name, :classification, :address, 
                :college_id, :program_id, :year_level, :school, :cor_path, :email, :contact_number)";
        
        $query = $this->db->connect()->prepare($sql);
        
        $query->bindParam(':first_name', $data['first_name']);
        $query->bindParam(':middle_name', $data['middle_name']);
        $query->bindParam(':last_name', $data['last_name']);
        $query->bindParam(':classification', $data['classification']);
        $query->bindParam(':address', $data['address']);
        $query->bindParam(':college_id', $data['college_id'], PDO::PARAM_INT);
        $query->bindParam(':program_id', $data['program_id'], PDO::PARAM_INT);
        $query->bindParam(':year_level', $data['year_level']);
        $query->bindParam(':school', $data['school']);
        $query->bindParam(':cor_path', $data['cor_path']);
        $query->bindParam(':email', $data['email']);
        $query->bindParam(':contact_number', $data['contact_number']);
        
        if (!$query->execute()) {
            throw new Exception("Failed to save enrollment");
        }
        
        return $this->db->connect()->lastInsertId();
    }

    function getPendingEnrollments() {
        $sql = "SELECT e.*, 
                    c.college_name,
                    p.program_name
                FROM madrasa_enrollment e
                LEFT JOIN colleges c ON e.college_id = c.college_id
                LEFT JOIN programs p ON e.program_id = p.program_id
                WHERE e.status = 'Pending'
                ORDER BY e.created_at ASC";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function updateEnrollmentStatus($enrollmentId, $status, $adminId) {
        if (!in_array($status, ['Enrolled', 'Rejected'])) {
            throw new InvalidArgumentException("Invalid status");
        }
        
        $sql = "UPDATE madrasa_enrollment 
                SET status = :status
                WHERE enrollment_id = :enrollment_id";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':status', $status);
        $query->bindParam(':enrollment_id', $enrollmentId, PDO::PARAM_INT);
        
        return $query->execute();
    }

    function fetchPendingEnrollments() {
        $sql = "SELECT e.enrollment_id, 
                CONCAT(e.last_name, ', ', e.first_name, ' ', IFNULL(e.middle_name, '')) AS full_name, 
                e.classification, 
                CONCAT(e.region, ', ', e.province, ', ', e.city, ', ', e.barangay, ', ', e.street, ', ', e.zip_code) AS address,
                p.program_name, c.college_name, 
                e.year_level, e.school, 
                e.cor_path, e.status,
                e.contact_number, e.email,
                e.ol_college, e.ol_program
                FROM madrasa_enrollment e
                LEFT JOIN programs p ON e.program_id = p.program_id
                LEFT JOIN colleges c ON e.college_id = c.college_id
                WHERE e.status = 'Pending'";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    function fetchOnsiteEnrolledStudents() {
        $sql = "SELECT e.enrollment_id, 
                CONCAT(e.last_name, ', ', e.first_name, ' ', IFNULL(e.middle_name, '')) AS full_name, 
                e.classification, 
                CONCAT(e.region, ', ', e.province, ', ', e.city, ', ', e.barangay, ', ', e.street, ', ', e.zip_code) AS address,
                p.program_name, c.college_name, 
                e.year_level, e.school, 
                e.cor_path, e.status, e.contact_number, e.email 
                FROM madrasa_enrollment e
                LEFT JOIN programs p ON e.program_id = p.program_id
                LEFT JOIN colleges c ON e.college_id = c.college_id
                WHERE e.status = 'Enrolled' AND e.classification = 'On-site' AND e.is_deleted = 0";   
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    function fetchOnlineEnrolledStudents() {
        $sql = "SELECT e.enrollment_id, 
                CONCAT(e.last_name, ', ', e.first_name, ' ', IFNULL(e.middle_name, '')) AS full_name, 
                e.classification, 
                CONCAT(e.region, ', ', e.province, ', ', e.city, ', ', e.barangay, ', ', e.street, ', ', e.zip_code) AS address,
                e.ol_college, e.ol_program, 
                e.year_level, e.school, 
                e.cor_path, e.status, e.contact_number, e.email
                FROM madrasa_enrollment e
                LEFT JOIN programs p ON e.program_id = p.program_id
                LEFT JOIN colleges c ON e.college_id = c.college_id
                WHERE e.status = 'Enrolled' AND e.classification = 'Online' AND e.is_deleted = 0";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    function getEnrollmentById($enrollmentId) {
        $sql = "SELECT e.enrollment_id, e.first_name, e.middle_name, e.last_name, 
                e.classification, e.region, e.province, e.city, e.barangay, e.street, 
                e.zip_code, e.college_id, e.program_id, e.year_level, e.school, 
                e.cor_path, e.ol_college, e.ol_program, e.email, e.contact_number,
                p.program_name, c.college_name
                FROM madrasa_enrollment e
                LEFT JOIN programs p ON e.program_id = p.program_id
                LEFT JOIN colleges c ON e.college_id = c.college_id
                WHERE e.enrollment_id = :enrollment_id";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':enrollment_id', $enrollmentId);
        $query->execute();
        return $query->fetch();
    }

    function enrollStudent($enrollmentId, $adminUserId) {
        $sql = "UPDATE madrasa_enrollment SET status = 'Enrolled', updated_at = NOW() WHERE enrollment_id = :enrollment_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':enrollment_id', $enrollmentId);
        if (!$query->execute()) {
            return 0;
        }
        return 1;
    }

    function rejectEnrollment($enrollmentId, $adminUserId) {
        $sql = "UPDATE madrasa_enrollment SET status = 'Rejected', updated_at = NOW() WHERE enrollment_id = :enrollment_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':enrollment_id', $enrollmentId);
        if (!$query->execute()) {
            return 0;
        }
        return 1;
    }

    function fetchAllColleges() {
        $sql = "SELECT * FROM colleges ORDER BY college_name";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function addStudent($firstName, $middleName, $lastName, $classification, 
    $region, $province, $city, $barangay, $street, $zipCode,
    $collegeId, $programId, $yearLevel, $school, $corPath, 
    $email, $contactNumber, $collegeText = null, $programText = null) {
    
    $sql = "INSERT INTO madrasa_enrollment (
        first_name, middle_name, last_name, classification, 
        region, province, city, barangay, street, zip_code,
        college_id, program_id, year_level, school, cor_path, 
        ol_college, ol_program, email, contact_number, status) 
        VALUES (
        :first_name, :middle_name, :last_name, :classification, 
        :region, :province, :city, :barangay, :street, :zip_code,
        :college_id, :program_id, :year_level, :school, :cor_path,
        :ol_college, :ol_program, :email, :contact_number, 'Enrolled')";

    $query = $this->db->connect()->prepare($sql);
    $query->bindParam(':first_name', $firstName);
    $query->bindParam(':middle_name', $middleName);
    $query->bindParam(':last_name', $lastName);
    $query->bindParam(':classification', $classification);
    $query->bindParam(':region', $region);
    $query->bindParam(':province', $province);
    $query->bindParam(':city', $city);
    $query->bindParam(':barangay', $barangay);
    $query->bindParam(':street', $street);
    $query->bindParam(':zip_code', $zipCode);
    $query->bindParam(':college_id', $collegeId);
    $query->bindParam(':program_id', $programId);
    $query->bindParam(':year_level', $yearLevel);
    $query->bindParam(':school', $school);
    $query->bindParam(':cor_path', $corPath);
    $query->bindParam(':ol_college', $collegeText);
    $query->bindParam(':ol_program', $programText);
    $query->bindParam(':email', $email);
    $query->bindParam(':contact_number', $contactNumber);

    return $query->execute();
}

function updateStudent($enrollmentId, $firstName, $middleName, $lastName, $classification, 
    $region, $province, $city, $barangay, $street, $zipCode,
    $collegeId, $programId, $yearLevel, $school, $corPath, 
    $email, $contactNumber, $collegeText = null, $programText = null) {
    
    $sql = "UPDATE madrasa_enrollment SET 
        first_name = :first_name, 
        middle_name = :middle_name, 
        last_name = :last_name, 
        classification = :classification, 
        region = :region,
        province = :province,
        city = :city,
        barangay = :barangay,
        street = :street,
        zip_code = :zip_code,
        college_id = :college_id, 
        program_id = :program_id, 
        year_level = :year_level, 
        school = :school,
        email = :email,
        contact_number = :contact_number,
        ol_college = :ol_college,
        ol_program = :ol_program";

    if (!empty($corPath)) {
        $sql .= ", cor_path = :cor_path";
    }

    $sql .= ", updated_at = NOW() WHERE enrollment_id = :enrollment_id";

    $query = $this->db->connect()->prepare($sql);
    $query->bindParam(':first_name', $firstName);
    $query->bindParam(':middle_name', $middleName);
    $query->bindParam(':last_name', $lastName);
    $query->bindParam(':classification', $classification);
    $query->bindParam(':region', $region);
    $query->bindParam(':province', $province);
    $query->bindParam(':city', $city);
    $query->bindParam(':barangay', $barangay);
    $query->bindParam(':street', $street);
    $query->bindParam(':zip_code', $zipCode);
    $query->bindParam(':college_id', $collegeId);
    $query->bindParam(':program_id', $programId);
    $query->bindParam(':year_level', $yearLevel);
    $query->bindParam(':school', $school);
    $query->bindParam(':email', $email);
    $query->bindParam(':contact_number', $contactNumber);
    $query->bindParam(':ol_college', $collegeText);
    $query->bindParam(':ol_program', $programText);

    if (!empty($corPath)) {
        $query->bindParam(':cor_path', $corPath);
    }

    $query->bindParam(':enrollment_id', $enrollmentId);

    return $query->execute();
}

    function softDeleteStudent($enrollmentId, $reason) {
    $sql = "UPDATE madrasa_enrollment 
            SET is_deleted = 1, deleted_at = NOW(), reason = :reason 
            WHERE enrollment_id = :enrollment_id";

    $query = $this->db->connect()->prepare($sql);
    $query->bindParam(':reason', $reason);
    $query->bindParam(':enrollment_id', $enrollmentId);
    return $query->execute();
    }

    function restoreStudent($enrollmentId) {
    $sql = "UPDATE madrasa_enrollment 
            SET is_deleted = 0, deleted_at = NULL, reason = NULL 
            WHERE enrollment_id = :enrollment_id";

    $query = $this->db->connect()->prepare($sql);
    $query->bindParam(':enrollment_id', $enrollmentId);
    return $query->execute();
    }

    function fetchArchivedStudents($classification = null) {
        $sql = "SELECT e.enrollment_id, e.email, e.contact_number,
                CONCAT(e.last_name, ', ', e.first_name, ' ', IFNULL(e.middle_name, '')) AS full_name, 
                e.classification, e.reason, e.deleted_at,
                CASE 
                    WHEN e.classification = 'On-site' THEN CONCAT(c.college_name, ' - ', p.program_name) 
                    ELSE CONCAT(e.ol_college, ' - ', e.ol_program)
                END AS program_info
                FROM madrasa_enrollment e
                LEFT JOIN programs p ON e.program_id = p.program_id
                LEFT JOIN colleges c ON e.college_id = c.college_id
                WHERE e.deleted_at IS NOT NULL";
        
        if ($classification === 'On-site') {
            $sql .= " AND e.classification = 'On-site'";
        } elseif ($classification === 'Online') {
            $sql .= " AND e.classification = 'Online'";
        }
        
        $sql .= " ORDER BY e.deleted_at DESC";
    
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function validateEmail($email, $classification) {
    if ($classification === 'On-site') {
        return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@wmsu\.edu\.ph$/', $email);
    } else {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    }
    
    // Org Updates Functions
    function fetchOrgUpdates() {
        $sql = "SELECT ou.update_id, ou.title, ou.content, ou.created_at, ou.deleted_at,
                    u.username AS created_by 
                FROM org_updates ou
                LEFT JOIN users u ON ou.created_by = u.user_id
                WHERE ou.deleted_at IS NULL
                ORDER BY ou.update_id ASC";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function getUpdateById($updateId) {
        $sql = "SELECT ou.update_id, ou.title, ou.content, ou.created_at, ou.deleted_at,
                    u.username AS created_by 
                FROM org_updates ou
                LEFT JOIN users u ON ou.created_by = u.user_id
                WHERE ou.update_id = :update_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':update_id', $updateId);
        $query->execute();
        return $query->fetch();
    }

    function getUpdateImages($updateId) {
        $sql = "SELECT image_id, file_path, upload_order
                FROM update_images 
                WHERE update_id = :update_id
                ORDER BY upload_order ASC";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':update_id', $updateId);
        $query->execute();
        return $query->fetchAll();
    }

    function addOrgUpdate($title, $content, $userId) {
        $pdo = $this->db->connect();
        
        try {
            $pdo->beginTransaction();
            
            $sql = "INSERT INTO org_updates (title, content, created_by) 
                    VALUES (:title, :content, :created_by)";

            $query = $pdo->prepare($sql);
            $query->bindParam(':title', $title);
            $query->bindParam(':content', $content);
            $query->bindParam(':created_by', $userId);
            $query->execute();
            
            $updateId = $pdo->lastInsertId();
            $pdo->commit();
            return $updateId;
        } catch (Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log("Error in addOrgUpdate: " . $e->getMessage());
            return false;
        }
    }

    function addUpdateImages($updateId, $imagePaths) {
        $pdo = $this->db->connect();
        
        try {
            $pdo->beginTransaction();
            
            $sql = "INSERT INTO update_images (update_id, file_path, upload_order) 
                    VALUES (:update_id, :file_path, :upload_order)";
            
            $query = $pdo->prepare($sql);
            
            foreach ($imagePaths as $index => $path) {
                $query->bindParam(':update_id', $updateId);
                $query->bindParam(':file_path', $path);
                $uploadOrder = $index;
                $query->bindParam(':upload_order', $uploadOrder);
                $query->execute();
            }
            
            $pdo->commit();
            return true;
        } catch (Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log("Error in addUpdateImages: " . $e->getMessage());
            return false;
        }
    }

    function updateOrgUpdate($updateId, $title, $content) {
        try {
            $sql = "UPDATE org_updates 
                    SET title = :title, content = :content 
                    WHERE update_id = :update_id";

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':title', $title);
            $query->bindParam(':content', $content);
            $query->bindParam(':update_id', $updateId);
            return $query->execute();
        } catch (Exception $e) {
            error_log("Error in updateOrgUpdate: " . $e->getMessage());
            return false;
        }
    }

    function deleteUpdateImages($updateId) {
        try {
            $sql = "DELETE FROM update_images 
                    WHERE update_id = :update_id";

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':update_id', $updateId);
            return $query->execute();
        } catch (Exception $e) {
            error_log("Error in deleteUpdateImages: " . $e->getMessage());
            return false;
        }
    }

    function deleteSpecificUpdateImages($imageIds) {
        if (empty($imageIds)) {
            return true; 
        }
        
        try {
            $imageIdsStr = implode(',', array_map('intval', $imageIds));
            
            $sql = "DELETE FROM update_images 
                    WHERE image_id IN ($imageIdsStr)";

            $query = $this->db->connect()->prepare($sql);
            return $query->execute();
        } catch (Exception $e) {
            error_log("Error in deleteSpecificUpdateImages: " . $e->getMessage());
            return false;
        }
    }

    function softDeleteOrgUpdate($updateId, $reason) {
        try {
            $sql = "UPDATE org_updates 
                    SET deleted_at = NOW(), reason = :reason, is_deleted = 1
                    WHERE update_id = :update_id";

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':reason', $reason);
            $query->bindParam(':update_id', $updateId);
            return $query->execute();
        } catch (Exception $e) {
            error_log("Error in softDeleteOrgUpdate: " . $e->getMessage());
            return false;
        }
    }

    function restoreOrgUpdate($updateId) {
        try {
            $sql = "UPDATE org_updates 
                    SET deleted_at = NULL, reason = NULL, is_deleted = 0
                    WHERE update_id = :update_id";

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':update_id', $updateId);
            return $query->execute();
        } catch (Exception $e) {
            error_log("Error in restoreOrgUpdate: " . $e->getMessage());
            return false;
        }
    }

    function fetchArchivedOrgUpdates() {
        $sql = "SELECT 
                    ou.update_id, 
                    ou.title, 
                    ou.content, 
                    ou.reason, 
                    ou.deleted_at, 
                    ou.created_at,
                    u.username AS created_by,
                    GROUP_CONCAT(ui.file_path ORDER BY ui.upload_order SEPARATOR '||') AS image_paths
                FROM org_updates ou
                LEFT JOIN users u ON ou.created_by = u.user_id
                LEFT JOIN update_images ui ON ou.update_id = ui.update_id
                WHERE ou.deleted_at IS NOT NULL
                GROUP BY ou.update_id
                ORDER BY ou.deleted_at ASC";

        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    // Officer Position Functions
    function fetchOfficerPositions() {
        $sql = "SELECT position_id, position_name, is_deleted, reason, deleted_at 
                FROM officer_positions
                WHERE is_deleted = 0
                ORDER BY position_id ASC";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function getPositionById($positionId) {
        $sql = "SELECT position_id, position_name, is_deleted, reason, deleted_at
                FROM officer_positions
                WHERE position_id = :position_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':position_id', $positionId);
        $query->execute();
        return $query->fetch();
    }

    function checkPositionExists($positionName, $excludeId = null) {
        $sql = "SELECT COUNT(*) as count FROM officer_positions 
                WHERE LOWER(position_name) = LOWER(:position_name)";
        
        if ($excludeId !== null) {
            $sql .= " AND position_id != :exclude_id";
        }

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':position_name', $positionName);
        
        if ($excludeId !== null) {
            $query->bindParam(':exclude_id', $excludeId);
        }
        
        $query->execute();
        $result = $query->fetch();
        return $result['count'] > 0;
    }

    function addOfficerPosition($positionName) {
        if ($this->checkPositionExists($positionName)) {
            return "duplicate";
        }
        
        $sql = "INSERT INTO officer_positions (position_name) 
                VALUES (:position_name)";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':position_name', $positionName);
        return $query->execute() ? "success" : "error";
    }

    function updateOfficerPosition($positionId, $positionName) {
        if ($this->checkPositionExists($positionName, $positionId)) {
            return "duplicate";
        }
        
        $sql = "UPDATE officer_positions 
                SET position_name = :position_name 
                WHERE position_id = :position_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':position_name', $positionName);
        $query->bindParam(':position_id', $positionId);
        return $query->execute() ? "success" : "error";
    }

    function softDeletePosition($positionId, $reason) {
        $sql = "UPDATE officer_positions 
                SET is_deleted = 1, reason = :reason, deleted_at = NOW() 
                WHERE position_id = :position_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':reason', $reason);
        $query->bindParam(':position_id', $positionId);
        return $query->execute();
    }

    function restorePosition($positionId) {
        $sql = "UPDATE officer_positions 
                SET is_deleted = 0, reason = NULL, deleted_at = NULL 
                WHERE position_id = :position_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':position_id', $positionId);
        return $query->execute();
    }

    function fetchArchivedPositions() {
        $sql = "SELECT position_id, position_name, reason, deleted_at
                FROM officer_positions
                WHERE is_deleted = 1
                ORDER BY deleted_at DESC";

        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    // School Year Functions
    function fetchSchoolYears() {
        $sql = "SELECT school_year_id, school_year, is_deleted, reason, deleted_at
                FROM school_years
                WHERE is_deleted = 0
                ORDER BY school_year_id DESC";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function getSchoolYearById($schoolYearId) {
        $sql = "SELECT school_year_id, school_year, is_deleted, reason, deleted_at
                FROM school_years
                WHERE school_year_id = :school_year_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':school_year_id', $schoolYearId);
        $query->execute();
        return $query->fetch();
    }

    function checkSchoolYearExists($schoolYear, $excludeId = null) {
        if ($excludeId) {
            $sql = "SELECT COUNT(*) as count FROM school_years 
                    WHERE school_year = :school_year AND school_year_id != :exclude_id";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':exclude_id', $excludeId);
        } else {
            $sql = "SELECT COUNT(*) as count FROM school_years 
                    WHERE school_year = :school_year";
            $query = $this->db->connect()->prepare($sql);
        }
        
        $query->bindParam(':school_year', $schoolYear);
        $query->execute();
        $result = $query->fetch();
        return $result['count'] > 0;
    }

    function addSchoolYear($schoolYear) {
        if ($this->checkSchoolYearExists($schoolYear)) {
            return 'duplicate';
        }

        $sql = "INSERT INTO school_years (school_year) 
                VALUES (:school_year)";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':school_year', $schoolYear);
        return $query->execute() ? 'success' : 'error';
    }

    function updateSchoolYear($schoolYearId, $schoolYear) {
        if ($this->checkSchoolYearExists($schoolYear, $schoolYearId)) {
            return 'duplicate';
        }

        $sql = "UPDATE school_years 
                SET school_year = :school_year 
                WHERE school_year_id = :school_year_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':school_year', $schoolYear);
        $query->bindParam(':school_year_id', $schoolYearId);
        return $query->execute() ? 'success' : 'error';
    }

    function softDeleteSchoolYear($schoolYearId, $reason) {
        $sql = "UPDATE school_years 
                SET is_deleted = 1, deleted_at = NOW(), reason = :reason 
                WHERE school_year_id = :school_year_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':reason', $reason);
        $query->bindParam(':school_year_id', $schoolYearId);
        return $query->execute() ? 'success' : 'error';
    }

    function restoreSchoolYear($schoolYearId) {
        $sql = "UPDATE school_years 
                SET is_deleted = 0, deleted_at = NULL, reason = NULL 
                WHERE school_year_id = :school_year_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':school_year_id', $schoolYearId);
        return $query->execute() ? 'success' : 'error';
    }

    function fetchArchivedSchoolYears() {
        $sql = "SELECT school_year_id, school_year, is_deleted, reason, deleted_at
                FROM school_years
                WHERE is_deleted = 1
                ORDER BY deleted_at ASC";

        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    // Others
    function fetchSy(){
        $sql = "SELECT * FROM school_years ORDER BY school_year_id ASC;";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    function fetchProgram() {
        $sql = "SELECT programs.program_id, programs.program_name, colleges.college_name 
                FROM programs 
                INNER JOIN colleges ON programs.college_id = colleges.college_id 
                WHERE programs.is_deleted = 0 
                ORDER BY programs.program_name ASC";
        
        $query = $this->db->connect()->prepare($sql);
        if ($query->execute()) {
            return $query->fetchAll();
        }
        return false; 
    }
    
    // function fetchColleges(){
    //     $sql = "SELECT * FROM colleges ORDER BY college_name ASC;";
    //     $query = $this->db->connect()->prepare($sql);
    //     $query->execute();
    //     return $query->fetchAll();
    // }

    
}