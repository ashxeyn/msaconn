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
    function addOfficer($data) {
        $sql = "INSERT INTO executive_officers (last_name, first_name, middle_name, position_id, program_id, school_year_id, image)
                VALUES (:last_name, :first_name, :middle_name, :position, :program, :school_year, :image)";
        
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':last_name', $data['surname']);
        $query->bindParam(':first_name', $data['firstName']);
        $query->bindParam(':middle_name', $data['middleName']);
        $query->bindParam(':position', $data['position']);
        $query->bindParam(':program', $data['program']);
        $query->bindParam(':school_year', $data['schoolYear']);
        $query->bindParam(':image', $data['image']['name']);

        if ($query->execute()) {
            if (!empty($data['image']['tmp_name'])) {
                move_uploaded_file($data['image']['tmp_name'], "../../assets/officers/" . $data['image']['name']);
            }
            return true;
        } else {
            return "Failed to add officer.";
        }
    }
    
    function updateOfficer($data) {
        $existingImage = $data['existingImage'];
        $newImage = $data['image']['name'] ?? null;
    
        if (!empty($newImage)) {
            $imageToSave = $newImage;
            move_uploaded_file($data['image']['tmp_name'], "../../assets/officers/" . $newImage);
        } else {
            $imageToSave = $existingImage;
        }
    
        $sql = "UPDATE executive_officers 
                SET last_name = :last_name, 
                    first_name = :first_name, 
                    middle_name = :middle_name, 
                    position_id = :position_id, 
                    school_year_id = :school_year_id, 
                    program_id = :program_id, 
                    image = :image 
                WHERE officer_id = :officer_id";
    
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':last_name', $data['surname']);
        $query->bindParam(':first_name', $data['firstName']);
        $query->bindParam(':middle_name', $data['middleName']);
        $query->bindParam(':position_id', $data['position']);
        $query->bindParam(':school_year_id', $data['schoolYear']);
        $query->bindParam(':program_id', $data['program']);
        $query->bindParam(':image', $imageToSave);
        $query->bindParam(':officer_id', $data['officerId']);
    
        return $query->execute();
    }
    
        

    function deleteOfficer($officerId) {
        $sql = "DELETE FROM executive_officers WHERE officer_id = :officer_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':officer_id', $officerId);
            
        if ($query->execute()) {
            return true;
        } else {
            return "Failed to delete officer.";
        }
    }

    function fetchOfficers() {
        $sql = "SELECT 
                    v.officer_id,
                    CONCAT(v.last_name, ', ', v.first_name, ' ', v.middle_name) AS full_name, 
                    p.program_name, 
                    op.position_name, 
                    sy.school_year, 
                    v.image AS image 
                FROM executive_officers v 
                LEFT JOIN programs p ON v.program_id = p.program_id 
                LEFT JOIN officer_positions op ON v.position_id = op.position_id 
                LEFT JOIN school_years sy ON v.school_year_id = sy.school_year_id";
        
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

    // Volunteer functions
    function addVolunteer() {
        $sql = "INSERT INTO volunteers (last_name, first_name, middle_name, year, section, program_id, contact, email, cor_file)
                VALUES (:last_name, :first_name, :middle_name, :year, :section, :program, :contact, :email, :cor_file)";
        
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':last_name', $this->last_name);
        $query->bindParam(':first_name', $this->first_name);
        $query->bindParam(':middle_name', $this->middle_name);
        $query->bindParam(':year', $this->year);
        $query->bindParam(':section', $this->section);
        $query->bindParam(':contact', $this->contact);
        $query->bindParam(':email', $this->email);
        $query->bindParam(':cor_file', $this->cor_file);
        $query->bindParam(':program', $this->program);

        $query->execute();
    }

    function updateVolunteer($volunteerId, $surname, $firstName, $middleName, $year, $section, $programId, $contact, $email, $corFile = null) {
        $sql = "UPDATE volunteers 
                SET last_name = :last_name, 
                    first_name = :first_name, 
                    middle_name = :middle_name, 
                    year = :year, 
                    section = :section, 
                    program_id = :program_id, 
                    contact = :contact, 
                    email = :email, 
                    cor_file = IF(:cor_file IS NOT NULL AND :cor_file != '', :cor_file, cor_file)
                WHERE volunteer_id = :volunteer_id";
    
        $query = $this->db->connect()->prepare($sql);
    
        $query->bindParam(':last_name', $surname);
        $query->bindParam(':first_name', $firstName);
        $query->bindParam(':middle_name', $middleName);
        $query->bindParam(':year', $year);
        $query->bindParam(':section', $section);
        $query->bindParam(':program_id', $programId);
        $query->bindParam(':contact', $contact);
        $query->bindParam(':email', $email);
        $query->bindParam(':cor_file', $corFile);
        $query->bindParam(':volunteer_id', $volunteerId);
    
        if (!$query->execute()) {
            return "Failed to update volunteer.";
        }
        return true;
    }

    function getVolunteerById($volunteerId) {
        $sql = "SELECT 
                    v.volunteer_id,
                    v.first_name,
                    v.middle_name,
                    v.last_name,
                    v.year AS year_level,
                    v.section,
                    v.program_id,
                    v.contact,
                    v.email,
                    v.cor_file,
                    v.status,
                    v.created_at,
                    p.program_name
                FROM volunteers v
                JOIN programs p ON v.program_id = p.program_id
                WHERE v.volunteer_id = :volunteer_id";
    
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':volunteer_id', $volunteerId);
        $query->execute();
    
        return $query->fetch();
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
                LEFT JOIN users u ON v.user_id = u.user_id LEFT JOIN programs p ON v.program_id = p.program_id WHERE v.status = 'approved'";
        
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
        return true;
    }
    
    function rejectVolunteer($volunteerId, $adminUserId) {
        $sql = "UPDATE volunteers SET status = 'rejected', user_id = :admin_id WHERE volunteer_id = :volunteer_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':admin_id', $adminUserId);
        $query->bindParam(':volunteer_id', $volunteerId);
        if (!$query->execute()) {
            return "Sad di magawa";
        }
        return true;
    }
    
    function deleteVolunteer($volunteerId) {
        $sql = "DELETE FROM volunteers WHERE volunteer_id = :volunteer_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':volunteer_id', $volunteerId);
        return $query->execute();
    }

    //Moderator functions
    function fetchSubAdmins() { 
        $sql = "SELECT 
                    u.user_id, 
                    CONCAT(u.last_name, ', ', u.first_name, ' ', u.middle_name) AS full_name, 
                    u.username, 
                    u.email, 
                    op.position_name, 
                    u.created_at 
                FROM users u 
                LEFT JOIN officer_positions op ON u.position_id = op.position_id 
                WHERE u.role = 'sub-admin'";
    
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
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
    
        if (!$query->execute()) {
            return "Failed to update moderator.";
        }
        return true;
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
                    op.position_name
                FROM users u
                LEFT JOIN officer_positions op ON u.position_id = op.position_id
                WHERE u.user_id = :user_id";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':user_id', $moderatorId);
        $query->execute();
        
        return $query->fetch();
    }    
    
    function deleteModerator($moderatorId) {
        $sql = "DELETE FROM users WHERE user_id = :user_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':user_id', $moderatorId);
        return $query->execute();
    }

    function getModerators() {
        $sql = "SELECT COUNT(*) AS total FROM users WHERE role = 'sub-admin'";
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

    function addProgram($programName, $collegeId) {
        $sql = "INSERT INTO programs (program_name, college_id) VALUES (:program_name, :college_id)";
        
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

    function deleteProgram($programId) {
        $sql = "DELETE FROM programs WHERE program_id = :program_id";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':program_id', $programId);
        
        return $query->execute();
    }

    function addCollege($collegeName) {
        $sql = "INSERT INTO colleges (college_name) VALUES (:college_name)";
        
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

    function deleteCollege($collegeId) {
        $sql = "DELETE FROM colleges WHERE college_id = :college_id";
        
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
        $sql = "SELECT * FROM faqs ORDER BY category ASC";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    function getFaqById($faqId) {
        $sql = "SELECT 
                    faq_id,
                    question,
                    answer,
                    category
                FROM faqs
                WHERE faq_id = :faq_id";
    
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':faq_id', $faqId);
        $query->execute();
    
        return $query->fetch();
    }

    function updateFaq($faqId, $question, $answer, $category) {
        $sql = "UPDATE faqs 
                SET question = :question, answer = :answer, category = :category
                WHERE faq_id = :faq_id";
    
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':question', $question);
        $query->bindParam(':answer', $answer);
        $query->bindParam(':category', $category);
        $query->bindParam(':faq_id', $faqId);
    
        return $query->execute();
    }
    
    function addFaq($question, $answer, $category) {
        $sql = "INSERT INTO faqs (question, answer, category) 
                    VALUES (:question, :answer, :category)";
    
        $query = $this->db->connect()->prepare($sql);
         $query->bindParam(':question', $question);
        $query->bindParam(':answer', $answer);
        $query->bindParam(':category', $category);
    
        return $query->execute();
    }
    
    function deleteFaq($faqId) {
        $sql = "DELETE FROM faqs WHERE faq_id = :faq_id";
    
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':faq_id', $faqId);
    
        return $query->execute();
    }

    // Events Functions
    function fetchEventPhotos() {
        $sql = "SELECT e.event_id, e.image, e.description, e.created_at, 
                    u.username AS uploaded_by 
                FROM events e
                LEFT JOIN users u ON e.uploaded_by = u.user_id
                ORDER BY e.event_id DESC";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function getEventById($eventId) {
        $sql = "SELECT e.event_id, e.image, e.description, e.created_at, 
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

    function deleteEvent($eventId) {
        $sql = "DELETE FROM events WHERE event_id = :event_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':event_id', $eventId);
        return $query->execute();
    }

    // Calendar Functions
    function fetchCalendarEvents() {
        $sql = "SELECT ca.*, u.username FROM calendar_activities ca 
                LEFT JOIN users u ON ca.created_by = u.user_id 
                ORDER BY ca.activity_date DESC";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    function getCalendarEventById($eventId) {
        $sql = "SELECT * FROM calendar_activities WHERE activity_id = :activity_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':activity_id', $eventId);
        $query->execute();
        return $query->fetch();
    }
    
    function addCalendarEvent($eventDate, $title, $description, $userId) {
        $sql = "INSERT INTO calendar_activities (activity_date, title, description, created_by) 
                VALUES (:activity_date, :title, :description, :created_by)";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':activity_date', $eventDate);
        $query->bindParam(':title', $title);
        $query->bindParam(':description', $description);
        $query->bindParam(':created_by', $userId);
        return $query->execute();
    }
    
    function updateCalendarEvent($eventId, $eventDate, $title, $description) {
        $sql = "UPDATE calendar_activities 
                SET activity_date = :activity_date, 
                    title = :title, 
                    description = :description 
                WHERE activity_id = :activity_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':activity_date', $eventDate);
        $query->bindParam(':title', $title);
        $query->bindParam(':description', $description);
        $query->bindParam(':activity_id', $eventId);
        return $query->execute();
    }
    
    function deleteCalendarEvent($eventId) {
        $sql = "DELETE FROM calendar_activities WHERE activity_id = :activity_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':activity_id', $eventId);
        return $query->execute();
    }
    
    // Prayer Schedule Functions
    function fetchFridayPrayers() {
        $sql = "SELECT fp.*, u.username 
                FROM friday_prayers fp 
                LEFT JOIN users u ON u.user_id = fp.created_by 
                ORDER BY fp.khutbah_date DESC";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    function getPrayerScheduleById($prayerId) {
        $sql = "SELECT * FROM friday_prayers WHERE prayer_id = :prayer_id";
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
    
    function deletePrayerSchedule($prayerId) {
        $sql = "DELETE FROM friday_prayers WHERE prayer_id = :prayer_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':prayer_id', $prayerId);
        return $query->execute();
    }

// Transparency Report Functions
function getCashInTransactions($schoolYearId, $semester = null, $month = null, $startDate = null, $endDate = null) {
    $sql = "SELECT * FROM transparency_report 
            WHERE transaction_type = 'Cash In' 
            AND school_year_id = :school_year_id";
    
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
    $query->bindParam(':school_year_id', $schoolYearId);
    
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

function getCashOutTransactions($schoolYearId, $semester = null, $month = null, $startDate = null, $endDate = null) {
    $sql = "SELECT * FROM transparency_report 
            WHERE transaction_type = 'Cash Out' 
            AND school_year_id = :school_year_id";
    
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
    $query->bindParam(':school_year_id', $schoolYearId);
    
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

    function deleteTransparencyTransaction($reportId) {
        $sql = "DELETE FROM transparency_report WHERE report_id = :report_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':report_id', $reportId);
        return $query->execute();
    }

    function getTotalStudentsPaid($schoolYearId, $semester = null) {
        $sql = "SELECT SUM(no_students) as total FROM student_paid 
                WHERE school_year_id = :school_year_id";
        
        if ($semester) {
            $sql .= " AND semester = :semester";
        }
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':school_year_id', $schoolYearId);
        
        if ($semester) {
            $query->bindParam(':semester', $semester);
        }
        
        $query->execute();
        $result = $query->fetch();
        return $result['total'] ?? 0;
    }

    function getStudentPaidRecord($schoolYearId, $semester) {
        $sql = "SELECT * FROM student_paid 
                WHERE school_year_id = :school_year_id 
                AND semester = :semester";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':school_year_id', $schoolYearId);
        $query->bindParam(':semester', $semester);
        $query->execute();
        return $query->fetch();
    }

    function updateStudentsPaid($noStudents, $schoolYearId, $semester, $paidId = null) {
        if ($paidId) {
            $sql = "UPDATE student_paid 
                    SET no_students = :no_students 
                    WHERE paid_id = :paid_id";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':no_students', $noStudents);
            $query->bindParam(':paid_id', $paidId);
        } else {
            $checkSql = "SELECT paid_id FROM student_paid 
                        WHERE school_year_id = :school_year_id 
                        AND semester = :semester";
            $checkQuery = $this->db->connect()->prepare($checkSql);
            $checkQuery->bindParam(':school_year_id', $schoolYearId);
            $checkQuery->bindParam(':semester', $semester);
            $checkQuery->execute();
            $existingRecord = $checkQuery->fetch();
            
            if ($existingRecord) {
                $sql = "UPDATE student_paid 
                        SET no_students = :no_students 
                        WHERE paid_id = :paid_id";
                $query = $this->db->connect()->prepare($sql);
                $query->bindParam(':no_students', $noStudents);
                $query->bindParam(':paid_id', $existingRecord['paid_id']);
            } else {
                $sql = "INSERT INTO student_paid 
                        (no_students, school_year_id, semester) 
                        VALUES (:no_students, :school_year_id, :semester)";
                $query = $this->db->connect()->prepare($sql);
                $query->bindParam(':no_students', $noStudents);
                $query->bindParam(':school_year_id', $schoolYearId);
                $query->bindParam(':semester', $semester);
            }
        }
        return $query->execute();
    }

    function getAllSchoolYears() {
        $sql = "SELECT * FROM school_years ORDER BY school_year DESC";
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
                ORDER BY programs.program_name ASC;";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    function fetchColleges(){
        $sql = "SELECT * FROM colleges ORDER BY college_name ASC;";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}