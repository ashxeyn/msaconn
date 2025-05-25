<?php
require_once 'databaseClass.php';

class User {
    protected $db;
    protected $conn;

    public function __construct() {
        $this->db = new Database();
    }

    protected function getConnection() {
        if (!$this->conn) {
            try {
                $this->conn = $this->db->connect();
            } catch (PDOException $e) {
                error_log("Database connection error: " . $e->getMessage());
                throw new Exception("Database connection failed");
            }
        }
        return $this->conn;
    }

    function fetchSy(){
        try {
            $sql = "SELECT * FROM school_years ORDER BY school_year_id ASC;";
            $query = $this->getConnection()->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            error_log("Error in fetchSy: " . $e->getMessage());
            return [];
        }
    }

    function fetchProgram() {
        try {
            $sql = "SELECT programs.program_id, programs.program_name, programs.college_id, colleges.college_name 
                    FROM programs 
                    INNER JOIN colleges ON programs.college_id = colleges.college_id 
                    ORDER BY programs.program_name ASC;";
            
            $query = $this->getConnection()->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in fetchProgram: " . $e->getMessage());
            return [];
        }
    }

    public function fetchColleges() {
        try {
            $sql = "SELECT college_id, college_name FROM colleges ORDER BY college_name ASC";
            $query = $this->getConnection()->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in fetchColleges: " . $e->getMessage());
            return [];
        }
    }

    public function addMadrasaEnrollment($data) {
        try {
            // Log the data being sent to the database
            error_log("=== BEGIN MADRASA ENROLLMENT DATA ===");
            error_log(print_r($data, true));
            error_log("=== END MADRASA ENROLLMENT DATA ===");
            
            // Ensure empty values are properly handled
            foreach ($data as $key => $value) {
                if ($value === null || $value === "") {
                    // Convert empty strings to NULL for database
                    if ($key === 'college_id' || $key === 'program_id') {
                        $data[$key] = null; // Allow NULL for foreign keys
                    } else {
                        $data[$key] = ''; // Empty string for non-foreign keys
                    }
                }
            }
            
            $sql = "INSERT INTO madrasa_enrollment 
                    (first_name, middle_name, last_name, email, contact_number, classification, 
                    region, province, city, barangay, street, zip_code, 
                    college_id, ol_college, program_id, ol_program, year_level, school, cor_path) 
                    VALUES 
                    (:first_name, :middle_name, :last_name, :email, :contact_number, :classification, 
                    :region, :province, :city, :barangay, :street, :zip_code, 
                    :college_id, :ol_college, :program_id, :ol_program, :year_level, :school, :cor_path)";
            
            error_log("SQL Query: " . $sql);
                
            $query = $this->getConnection()->prepare($sql);
            
            // Log parameter binding to check for any issues
            error_log("Binding parameters for database insertion...");
        
            $query->bindParam(':first_name', $data['first_name']);
            $query->bindParam(':middle_name', $data['middle_name']);
            $query->bindParam(':last_name', $data['last_name']);
            $query->bindParam(':email', $data['email']);
            $query->bindParam(':contact_number', $data['contact_number']);
            $query->bindParam(':classification', $data['classification']);
            $query->bindParam(':region', $data['region']);
            $query->bindParam(':province', $data['province']);
            $query->bindParam(':city', $data['city']);
            $query->bindParam(':barangay', $data['barangay']);
            $query->bindParam(':street', $data['street']);
            $query->bindParam(':zip_code', $data['zip_code']);
            
            // Special handling for foreign keys that may need to be NULL
            if ($data['college_id'] === null) {
                $query->bindValue(':college_id', null, PDO::PARAM_NULL);
            } else {
                $query->bindValue(':college_id', $data['college_id'], PDO::PARAM_INT);
            }
            
            $query->bindParam(':ol_college', $data['ol_college']);
            
            if ($data['program_id'] === null) {
                $query->bindValue(':program_id', null, PDO::PARAM_NULL);
            } else {
                $query->bindValue(':program_id', $data['program_id'], PDO::PARAM_INT);
            }
            
            $query->bindParam(':ol_program', $data['ol_program']);
            $query->bindParam(':year_level', $data['year_level']);
            $query->bindParam(':school', $data['school']);
            $query->bindParam(':cor_path', $data['cor_path']);
            
            error_log("Executing query...");
        
            if ($query->execute()) {
                // Store the database connection for reuse
                $conn = $this->getConnection();
                
                // Get the last inserted ID
                $lastId = $conn->lastInsertId();
                error_log("Query executed successfully. Last inserted ID: $lastId");
                
                // Return the ID even if it's 0 (which is a valid ID in some DBs)
                return $lastId;
            } else {
                $error = $query->errorInfo();
                error_log("Error executing query: " . implode(", ", $error));
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database error in addMadrasaEnrollment (PDOException): " . $e->getMessage());
            error_log("SQL State: " . $e->getCode());
            return false;
        } catch (Exception $e) {
            error_log("General error in addMadrasaEnrollment: " . $e->getMessage());
            return false;
        }
    }

    // Fetch about data for the "About Us" page
    public function getAboutMSAData() {
        $sql = "SELECT mission, vision, description 
                FROM about_msa 
                WHERE is_deleted = 0 
                ORDER BY created_at DESC 
                LIMIT 1";
        $query = $this->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Fetch all FAQs
    function fetchUserFaqs() {
        $sql = "SELECT * FROM faqs WHERE is_deleted = 0 ORDER BY category ASC, created_at DESC";
        $query = $this->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch a single FAQ by ID for the user side
    function getUserFaqById($faqId) {
        $sql = "SELECT * FROM faqs WHERE faq_id = :faq_id";
        $query = $this->getConnection()->prepare($sql);
        $query->bindParam(':faq_id', $faqId, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
   
     // Volunteer functions
     function addVolunteer($first_name, $last_name, $middle_name, $year, $section, $program, $contact, $email, $cor_file) {
        $sql = "INSERT INTO volunteers (first_name, middle_name, last_name, year, program_id, contact, email, cor_file)
                VALUES (:first_name, :middle_name, :last_name, :year, :program_id, :contact, :email, :cor_file)";
        
        $query = $this->getConnection()->prepare($sql);

        $query->bindParam(':first_name', $first_name);
        $query->bindParam(':middle_name', $middle_name);
        $query->bindParam(':last_name', $last_name);
        $query->bindParam(':year', $year);
        $query->bindParam(':program_id', $program);
        $query->bindParam(':contact', $contact);
        $query->bindParam(':email', $email);
        $query->bindParam(':cor_file', $cor_file);

        return $query->execute();
    }
    public function fetchDownloadableFiles() {
        try {
            // Match the admin query - use both conditions for consistency
            $sql = "SELECT file_id, file_name, file_path, file_type, file_size, created_at 
                    FROM downloadable_files 
                    WHERE is_deleted = 0 AND deleted_at IS NULL 
                    ORDER BY created_at DESC
                    LIMIT 6";  // Limit to 6 latest files
                    
            $query = $this->db->connect()->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching downloadable files: " . $e->getMessage());
            return [];
        }
    }
    
    public function fetchFridayPrayers() {
        $sql = "SELECT khutbah_date, speaker, topic, location 
                FROM friday_prayers 
                WHERE khutbah_date >= CURDATE() AND is_deleted = 0 
                ORDER BY khutbah_date ASC";
        $query = $this->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchPrayerSchedule() {
        $sql = "SELECT * FROM friday_prayers WHERE is_deleted=0 ORDER BY khutbah_date";
        $query = $this->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchCalendarActivities() {
        $sql = "SELECT activity_id, title, description, activity_date, end_date FROM calendar_activities WHERE is_deleted = 0 ORDER BY activity_date ASC";
        $query = $this->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        // Log or print the result to ensure it's being fetched
        error_log(print_r($result, true)); // This logs to the PHP error log
        
        return $result;
    }
    
    public function getActivityById($activity_id) {
        $sql = "SELECT activity_id, title, description, venue, activity_date, end_date, time 
                FROM calendar_activities 
                WHERE activity_id = :activity_id AND is_deleted = 0";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':activity_id', $activity_id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    
    public function fetchVolunteers() {
        $sql = "SELECT first_name, last_name 
                FROM volunteers 
                WHERE is_deleted = 0 AND status = 'approved' 
                ORDER BY created_at DESC";
        $query = $this->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchTransparencyReports() {
        $sql = "SELECT 
                    tr.report_id, 
                    tr.report_date, 
                    tr.expense_detail, 
                    tr.expense_category, 
                    tr.amount, 
                    tr.transaction_type, 
                    tr.semester, 
                    sy.school_year 
                FROM transparency_report tr
                INNER JOIN school_years sy ON tr.school_year_id = sy.school_year_id
                WHERE tr.is_deleted = 0
                ORDER BY tr.report_date DESC";
        $query = $this->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function fetchExecutiveOfficers() {
        try {
            // Query all officers with their position and branch (office) information
            $sql = "
                SELECT 
                    eo.first_name, 
                    eo.middle_name, 
                    eo.last_name, 
                    op.position_name AS position, 
                    op.position_id,
                    eo.image AS picture,
                    eo.office,
                    eo.school_year_id
                FROM 
                    executive_officers eo
                INNER JOIN 
                    officer_positions op ON eo.position_id = op.position_id
                WHERE 
                    eo.is_deleted = 0
                ORDER BY 
                    eo.school_year_id DESC,
                    eo.office,
                    CASE 
                        WHEN op.position_name = 'Adviser' THEN 0
                        WHEN op.position_name = 'Consultant' THEN 1
                        WHEN op.position_name = 'President' THEN 2
                        WHEN op.position_name = 'Internal Vice President' THEN 3
                        WHEN op.position_name = 'External Vice President' THEN 4
                        WHEN op.position_name = 'Secretary' THEN 5
                        WHEN op.position_name = 'Treasurer' THEN 6
                        WHEN op.position_name = 'Auditor' THEN 7
                        WHEN op.position_name = 'P.I.O.' THEN 8
                        WHEN op.position_name = 'Project Manager' THEN 9
                        ELSE 10
                    END ASC
            ";
            $query = $this->getConnection()->prepare($sql);
            $query->execute();
            $officers = $query->fetchAll(PDO::FETCH_ASSOC);
            
            // Group officers by branch
            $result = [
                'adviser' => [],
                'male' => [],
                'wac' => [],
                'ils' => []
            ];
            
            // Track positions already added to avoid duplicates
            $addedPositions = [
                'adviser' => [],
                'male' => [],
                'wac' => [],
                'ils' => []
            ];
            
            // Process officers, taking only the first occurrence of each position
            // Since we ordered by school_year_id DESC, the first occurrence will be the latest one
            foreach ($officers as $officer) {
                $branch = '';
                
                if ($officer['position'] === 'Adviser' || $officer['position'] === 'Consultant') {
                    $branch = 'adviser';
                } elseif ($officer['office'] === 'male' || empty($officer['office'])) {
                    $branch = 'male';
                } elseif ($officer['office'] === 'wac') {
                    $branch = 'wac';
                } elseif ($officer['office'] === 'ils') {
                    $branch = 'ils';
                }
                
                // Only add this officer if we haven't already added one with the same position in this branch
                $positionKey = $officer['position_id'] . '_' . $officer['office'];
                if (!isset($addedPositions[$branch][$positionKey])) {
                    $result[$branch][] = $officer;
                    $addedPositions[$branch][$positionKey] = true;
                }
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            throw $e;
        }
    }
    function fetchOrgUpdates() {
        // First get all updates
        $sql = "SELECT ou.update_id, ou.title, ou.content, ou.created_at, ou.deleted_at,
                    u.username AS created_by 
                FROM org_updates ou
                LEFT JOIN users u ON ou.created_by = u.user_id
                WHERE ou.deleted_at IS NULL
                ORDER BY ou.update_id ASC";
        
        $query = $this->getConnection()->prepare($sql);
        $query->execute();
        $updates = $query->fetchAll();
        
        // Then get images for each update
        foreach ($updates as &$update) {
            $imagesSql = "SELECT file_path 
                         FROM update_images 
                         WHERE update_id = :update_id
                         ORDER BY upload_order ASC";
            
            $imagesQuery = $this->getConnection()->prepare($imagesSql);
            $imagesQuery->bindParam(':update_id', $update['update_id']);
            $imagesQuery->execute();
            $update['images'] = $imagesQuery->fetchAll();
        }
        
        return $updates;
    }

        public function fetchUpdateImages($update_id) {
            $sql = "SELECT image_id, file_path, upload_order
                    FROM update_images 
                    WHERE update_id = :update_id
                    ORDER BY upload_order ASC";
    
            $query = $this->getConnection()->prepare($sql);
            $query->bindParam(':update_id', $update_id, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll();
        }

    public function fetchProgramsByCollege($college_id) {
        $sql = "SELECT program_id, program_name, college_id 
                FROM programs 
                WHERE college_id = :college_id AND is_deleted = 0 
                ORDER BY program_name ASC";
        
        error_log("Fetching programs for college ID: $college_id");
        
        $query = $this->getConnection()->prepare($sql);
        $query->bindParam(':college_id', $college_id, PDO::PARAM_INT);
        $query->execute();
        
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        error_log("Found " . count($result) . " programs for college ID: $college_id");
        
        return $result;
    }

    // SITE MANAGEMENT FUNCTIONS
    function fetchFooterInfo() {
        $sql = "SELECT * FROM site_pages WHERE page_type = 'footer' AND is_active = 1";
        $query = $this->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    // LOGO
    function fetchLogo() {
        $sql = "SELECT * FROM site_pages WHERE page_type = 'logo' AND is_active = 1";
        $query = $this->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    // CAROUSEL
    function fetchCarousel() {
        try {
            $sql = "SELECT * FROM site_pages WHERE page_type = 'carousel' AND is_active = 1";
            $query = $this->getConnection()->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            error_log("Error in fetchCarousel: " . $e->getMessage());
            return [];
        }
    }

    function fetchHome() {
        try {
            $sql = "SELECT * FROM site_pages WHERE page_type = 'home' AND is_active = 1";
            $query = $this->getConnection()->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            error_log("Error in fetchHome: " . $e->getMessage());
            return [];
        }
    }

    // ORG UPDATES
    function fetchOrgUpdatesWithImages() {
        try {
            $sql = "
                SELECT u.*, 
                      (SELECT i.file_path 
                       FROM update_images i 
                       WHERE i.update_id = u.update_id 
                       ORDER BY i.upload_order ASC 
                       LIMIT 1) as image_path
                FROM org_updates u 
                WHERE u.is_deleted = 0 
                ORDER BY u.created_at DESC
            ";
            
            $query = $this->getConnection()->prepare($sql);
            $query->execute();
            
            $result = $query->fetchAll();
            
            foreach ($result as &$update) {
                if (!empty($update['image_path'])) {
                    $update['image_path'] = '/updates/' . $update['image_path'];
                }
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log("Error fetching org updates with images: " . $e->getMessage());
            return [];
        }
    }

    // VOLUNTEERS
    function fetchVolunteerInfo() {
        $sql = "SELECT * FROM site_pages WHERE page_type = 'volunteer' AND is_active = 1";
        $query = $this->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    // BACKGROUND IMAGE
    function fetchBackgroundImage() {
        $sql = "SELECT * FROM site_pages WHERE page_type = 'background' AND is_active = 1";
        $query = $this->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    // CALENDAR
    function fetchCalendar() {
        $sql = "SELECT * FROM site_pages WHERE page_type = 'calendar' AND is_active = 1";
        $query = $this->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    // REGISTRATION MADRASA
    function fetchRegistrationInfo() {
        $sql = "SELECT * FROM site_pages WHERE page_type = 'registration' AND is_active = 1";
        $query = $this->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    // FAQ
    function fetchFaqsInfo() {
        $sql = "SELECT * FROM site_pages WHERE page_type = 'faqs' AND is_active = 1";
        $query = $this->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    // TRANSPARENCY REPORT
    function fetchTransparencyInfo() {
        $sql = "SELECT * FROM site_pages WHERE page_type = 'transparency' AND is_active = 1";
        $query = $this->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    // ABOUT US PAGE
    function fetchAboutInfo() {
        $sql = "SELECT * FROM site_pages WHERE page_type = 'about' AND is_active = 1";
        $query = $this->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    // Fetch all org updates for the sidebar, ordered by creation date (newest first)
    function fetchAllOrgUpdates() {
        try {
            $sql = "
                SELECT ou.update_id as id, ou.title, ou.content, ou.created_at,
                      (SELECT ui.file_path 
                       FROM update_images ui 
                       WHERE ui.update_id = ou.update_id 
                       ORDER BY ui.upload_order ASC 
                       LIMIT 1) as image_path
                FROM org_updates ou
                WHERE ou.is_deleted = 0
                ORDER BY ou.created_at DESC
            ";
            
            $query = $this->getConnection()->prepare($sql);
            $query->execute();
            $updates = $query->fetchAll(PDO::FETCH_ASSOC);
            
            // Format image paths
            foreach ($updates as &$update) {
                if (!empty($update['image_path'])) {
                    $update['image_path'] = '/updates/' . $update['image_path'];
                }
            }
            
            return $updates;
        } catch (PDOException $e) {
            error_log("Error fetching all org updates: " . $e->getMessage());
            return [];
        }
    }
    
    // Fetch a single organization update by ID
    function fetchOrgUpdateById($update_id) {
        try {
            // Get the main article data
            $sql = "SELECT * FROM org_updates WHERE update_id = :update_id AND is_deleted = 0";
            
            $query = $this->getConnection()->prepare($sql);
            $query->bindParam(':update_id', $update_id, PDO::PARAM_INT);
            $query->execute();
            
            $update = $query->fetch(PDO::FETCH_ASSOC);
            
            if ($update) {
                // Get all images for this update
                $imagesSql = "SELECT image_id, file_path, upload_order 
                             FROM update_images 
                             WHERE update_id = :update_id
                             ORDER BY upload_order ASC";
                
                $imagesQuery = $this->getConnection()->prepare($imagesSql);
                $imagesQuery->bindParam(':update_id', $update_id, PDO::PARAM_INT);
                $imagesQuery->execute();
                $update['images'] = $imagesQuery->fetchAll(PDO::FETCH_ASSOC);
                
                // Format image paths
                foreach ($update['images'] as &$image) {
                    if (!empty($image['file_path'])) {
                        $image['file_path'] = '/updates/' . $image['file_path'];
                    }
                }
                
                // Keep first image in image_path for backward compatibility
                if (!empty($update['images'][0]['file_path'])) {
                    $update['image_path'] = $update['images'][0]['file_path'];
                }
            }
            
            return $update;
        } catch (PDOException $e) {
            error_log("Error fetching org update by ID: " . $e->getMessage());
            return false;
        }
    }

    public function fetchDailyPrayers() {
        try {
            $sql = "SELECT prayer_id, date, time, iqamah, prayer_type, location 
                    FROM prayer_schedule 
                    WHERE is_deleted = 0 
                    ORDER BY date ASC, time ASC";
            
            $query = $this->getConnection()->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in fetchDailyPrayers: " . $e->getMessage());
            return [];
        }
    }
}
