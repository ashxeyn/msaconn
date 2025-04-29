<?php
require_once 'databaseClass.php';

class User {
    protected $db;

    public function __construct() {
        $this->db = new Database();
        $this->db->connect();
    }

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
    public function fetchColleges() {
        $sql = "SELECT college_id, college_name FROM colleges ORDER BY college_name ASC";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
}
    public function addMadrasaEnrollment($data) {
        $sql = "INSERT INTO madrasa_enrollment 
                (first_name, middle_name, last_name, classification, address, college_id, program_id, year_level, school, cor_path, email, contact_number) 
                VALUES 
                (:first_name, :middle_name, :last_name, :classification, :address, :college_id, :program_id, :year_level, :school, :cor_path, :email, :contact_number)";
        
        $query = $this->db->connect()->prepare($sql);
    
        $query->bindParam(':first_name', $data['first_name']);
        $query->bindParam(':middle_name', $data['middle_name']);
        $query->bindParam(':last_name', $data['last_name']);
        $query->bindParam(':classification', $data['classification']);
        $query->bindParam(':address', $data['address']);
        $query->bindParam(':college_id', $data['college_id']);
        $query->bindParam(':program_id', $data['program_id']);
        $query->bindParam(':year_level', $data['year_level']);
        $query->bindParam(':school', $data['school']);
        $query->bindParam(':cor_path', $data['cor_path']);
        $query->bindParam(':email', $data['email']);
        $query->bindParam(':contact_number', $data['contact_number']);
    
        $query->execute();
    
        // Return the last inserted ID
        return $this->db->connect()->lastInsertId();
    }

    // Fetch about data for the "About Us" page
    public function getAboutMSAData() {
        $sql = "SELECT mission, vision, description 
                FROM about_msa 
                WHERE is_deleted = 0 
                ORDER BY created_at DESC 
                LIMIT 1";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Fetch all FAQs
    function fetchUserFaqs() {
        $sql = "SELECT * FROM faqs ORDER BY category ASC, created_at DESC";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch a single FAQ by ID for the user side
    function getUserFaqById($faqId) {
        $sql = "SELECT * FROM faqs WHERE faq_id = :faq_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':faq_id', $faqId, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function fetchDownloadableFiles() {
        $sql = "SELECT file_id, file_name, file_path, file_type, file_size, created_at 
                FROM downloadable_files 
                ORDER BY created_at DESC";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
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
    
    public function fetchPrayerSchedules() {
        $sql = "SELECT khutbah_date, speaker, topic, location 
                FROM friday_prayers 
                WHERE khutbah_date >= CURDATE() 
                ORDER BY khutbah_date ASC";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
}
    public function fetchCalendarActivities() {
        $sql = "SELECT activity_id, title, description, activity_date FROM calendar_activities WHERE is_deleted = 0 ORDER BY activity_date ASC";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        // Log or print the result to ensure it’s being fetched
        error_log(print_r($result, true)); // This logs to the PHP error log
        
        return $result;
    }
    public function fetchVolunteers() {
        $sql = "SELECT first_name, last_name FROM volunteers WHERE is_deleted = 0 ORDER BY created_at DESC";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
