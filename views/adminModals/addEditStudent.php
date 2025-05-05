<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();

$enrollmentId = $_GET['enrollment_id'] ?? null;
$student = null;
if ($enrollmentId) {
    $student = $adminObj->getEnrollmentById($enrollmentId);
}
        
$colleges = $adminObj->fetchAllColleges();
$programs = $student && $student['college_id'] ? $adminObj->fetchProgramsByCollege($student['college_id']) : [];
$yearLevels = ['1st year', '2nd year', '3rd year', '4th year', 'Others'];

$regionData = [
    'regions' => [
        'Zamboanga Peninsula'
    ],
    'provinces' => [
        'Zamboanga del Norte',
        'Zamboanga del Sur',
        'Zamboanga Sibugay',
        'Zamboanga City',
        'Isabela City'
    ],
    'cities' => [
        'Zamboanga del Norte' => [
            'Dapitan City',
            'Dipolog City',
            'Katipunan',
            'La Libertad',
            'Labason',
            'Liloy',
            'Manukan',
            'Polanco',
            'Rizal',
            'Roxas',
            'Sergio Osmeña Sr.',
            'Siayan',
            'Sindangan',
            'Siocon',
            'Tampilisan'
        ],
        'Zamboanga del Sur' => [
            'Aurora',
            'Bayog',
            'Dimataling',
            'Dinas',
            'Dumalinao',
            'Dumingag',
            'Guipos',
            'Josefina',
            'Kumalarang',
            'Labangan',
            'Lakewood',
            'Lapuyan',
            'Mahayag',
            'Margosatubig',
            'Midsalip',
            'Molave',
            'Pagadian City',
            'Pitogo',
            'Ramon Magsaysay',
            'San Miguel',
            'San Pablo',
            'Sominot',
            'Tabina',
            'Tambulig',
            'Tigbao',
            'Tukuran',
            'Vincenzo A. Sagun'
        ],
        'Zamboanga Sibugay' => [
            'Alicia',
            'Buug',
            'Diplahan',
            'Imelda',
            'Ipil',
            'Kabasalan',
            'Mabuhay',
            'Malangas',
            'Naga',
            'Olutanga',
            'Payao',
            'Roseller Lim',
            'Siay',
            'Talusan',
            'Titay',
            'Tungawan'
        ],
        'Zamboanga City' => [
            'Zamboanga City'
        ],
        'Isabela City' => [
            'Isabela City'
        ]
    ],
    'barangays' => [
        'Zamboanga City' => [
            'Arena Blanco',
            'Ayala',
            'Baluno',
            'Boalan',
            'Bolong',
            'Buenavista',
            'Bunguiao',
            'Busay',
            'Cabaluay',
            'Cabatangan'
        ],
        'Dipolog City' => [
            'Barra',
            'Biasong',
            'Central',
            'Cogon',
            'Dicayas',
            'Diwan',
            'Estaka',
            'Galas',
            'Gulayon',
            'Lugdungan'
        ],
        'Pagadian City' => [
            'Balangasan',
            'Balintawak',
            'Baliwasan',
            'Baloyboan',
            'Banale',
            'Bogo Capalaran',
            'Buenavista',
            'Bulatok',
            'Bulatin',
            'Dampalan'
        ]
    ]
];
?>

<!-- Student Modal -->
<div class="modal fade" id="addEditStudentModal" tabindex="-1" aria-labelledby="addEditStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg student-modal">
        <form id="studentForm" enctype="multipart/form-data" novalidate>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Student</h5>
                </div>
                
                    <input type="hidden" id="enrollmentId" name="enrollmentId" value="<?= $student ? $student['enrollment_id'] : '' ?>">
                    <input type="hidden" id="existing_image" name="existing_image" value="<?= $student['cor_path'] ?? '' ?>">

                <!-- Classification Step -->
                    <div id="classificationStep" style="display: <?= $student ? 'none' : 'block' ?>;">
                    <div class="modal-body">
                        <div class="modal-section">
                            <h6 class="section-title">Learning Mode Selection</h6>
                        <div class="mb-3">
                                <label for="classification" class="form-label">Select Learning Mode</label>
                            <select class="form-select" id="classification" name="classification">
                                <option value="">Select Classification</option>
                                <option value="On-site" <?= ($student && $student['classification'] == 'On-site') ? 'selected' : '' ?>>On-site</option>
                                <option value="Online" <?= ($student && $student['classification'] == 'Online') ? 'selected' : '' ?>>Online</option>
                            </select>
                            <div id="classificationError" class="text-danger"></div>
                        </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                        </div>
                    </div>

                <!-- Student Details Step -->
                    <div id="studentDetailsStep" style="display: <?= $student ? 'block' : 'none' ?>;">
                    <div class="modal-body">
                        <!-- Left Column -->
                        <div class="modal-section">
                            <h6 class="section-title">Personal Information</h6>
                        <div class="mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" value="<?= $student['first_name'] ?? '' ?>">
                            <div id="firstNameError" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label for="middleName" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="middleName" name="middleName" value="<?= $student['middle_name'] ?? '' ?>">
                            <div id="middleNameError" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" value="<?= $student['last_name'] ?? '' ?>">
                            <div id="lastNameError" class="text-danger"></div>
                        </div>

                            <h6 class="section-title">Contact Information</h6>
                        <div class="mb-3">
                            <label for="contactNumber" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="contactNumber" name="contactNumber" placeholder="09XXXXXXXXX" value="<?= $student['contact_number'] ?? '' ?>">
                            <div id="contactNumberError" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $student['email'] ?? '' ?>">
                            <div id="emailError" class="text-danger"></div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="modal-section">
                            <h6 class="section-title">Address Information</h6>
                        <div class="mb-3">
                            <label for="region" class="form-label">Region</label>
                            <select class="form-select" id="region" name="region">
                                <option value="">Select Region</option>
                                <?php foreach ($regionData['regions'] as $region): ?>
                                        <option value="<?= $region ?>" <?= ($student && $student['region'] == $region) ? 'selected' : '' ?>>
                                        <?= $region ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div id="regionError" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label for="province" class="form-label">Province</label>
                            <select class="form-select" id="province" name="province">
                                <option value="">Select Province</option>
                                <?php foreach ($regionData['provinces'] as $province): ?>
                                        <option value="<?= $province ?>" <?= ($student && $student['province'] == $province) ? 'selected' : '' ?>>
                                        <?= $province ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div id="provinceError" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label for="city" class="form-label">City/Municipality</label>
                            <select class="form-select" id="city" name="city">
                                <option value="">Select City/Municipality</option>
                                <?php if ($student && $student['province'] && isset($regionData['cities'][$student['province']])): ?>
                                    <?php foreach ($regionData['cities'][$student['province']] as $city): ?>
                                            <option value="<?= $city ?>" <?= ($student && $student['city'] == $city) ? 'selected' : '' ?>>
                                            <?= $city ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div id="cityError" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label for="barangay" class="form-label">Barangay</label>
                            <select class="form-select" id="barangay" name="barangay">
                                <option value="">Select Barangay</option>
                                <?php if ($student && $student['city'] && isset($regionData['barangays'][$student['city']])): ?>
                                    <?php foreach ($regionData['barangays'][$student['city']] as $barangay): ?>
                                            <option value="<?= $barangay ?>" <?= ($student && $student['barangay'] == $barangay) ? 'selected' : '' ?>>
                                            <?= $barangay ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div id="barangayError" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label for="street" class="form-label">Street/House No./Blk/Lot</label>
                            <input type="text" class="form-control" id="street" name="street" value="<?= $student['street'] ?? '' ?>">
                            <div id="streetError" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label for="zipCode" class="form-label">Zip Code</label>
                            <input type="text" class="form-control" id="zipCode" name="zipCode" value="<?= $student['zip_code'] ?? '' ?>">
                            <div id="zipCodeError" class="text-danger"></div>
                        </div>

                            <!-- Academic Information -->
                        <div id="onsiteFields" class="<?= ($student && $student['classification'] == 'Online') ? 'd-none' : '' ?>">
                                <h6 class="section-title">Academic Information</h6>
                            <div class="mb-3">
                                <label for="college" class="form-label">College</label>
                                <select class="form-select" id="college" name="college">
                                    <option value="">Select College</option>
                                    <?php foreach ($colleges as $college): ?>
                                            <option value="<?= $college['college_id'] ?>" <?= ($student && $student['college_id'] == $college['college_id']) ? 'selected' : '' ?>>
                                            <?= clean_input($college['college_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="collegeError" class="text-danger"></div>
                            </div>

                            <div class="mb-3">
                                <label for="program" class="form-label">Program</label>
                                <select class="form-select" id="program" name="program">
                                    <option value="">Select Program</option>
                                    <?php foreach ($programs as $program): ?>
                                            <option value="<?= $program['program_id'] ?>" <?= ($student && $student['program_id'] == $program['program_id']) ? 'selected' : '' ?>>
                                            <?= clean_input($program['program_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="programError" class="text-danger"></div>
                            </div>

                            <div class="mb-3">
                                <label for="yearLevel" class="form-label">Year Level</label>
                                <select class="form-select" id="yearLevel" name="yearLevel">
                                    <option value="">Select Year Level</option>
                                    <?php foreach ($yearLevels as $level): ?>
                                            <option value="<?= $level ?>" <?= ($student && $student['year_level'] == $level) ? 'selected' : '' ?>>
                                            <?= $level ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="yearLevelError" class="text-danger"></div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="image" class="form-label">Certificate of Registration (COR)</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <div id="imageError" class="text-danger"></div>

                                <div id="image-preview" class="mt-2" <?= ($student && !empty($student['cor_path'])) ? '' : 'style="display:none;"' ?>>
                                    <img id="preview-img" src="<?= $student && !empty($student['cor_path']) ? '../../assets/enrollment/' . $student['cor_path'] : '' ?>" alt="Student COR Image" class="img-thumbnail" width="150">
                                </div>
                            </div>
                        </div>

                            <!-- Online Fields -->
                        <div id="onlineFields" class="<?= ($student && $student['classification'] == 'On-site') ? 'd-none' : '' ?>">
                                <h6 class="section-title">School Information</h6>
                            <div class="mb-3">
                                <label for="school" class="form-label">School (Optional)</label>
                                <input type="text" class="form-control" id="school" name="school" value="<?= $student['school'] ?? '' ?>">
                                <div id="schoolError" class="text-danger"></div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="collegeText" class="form-label">College (Optional)</label>
                                <input type="text" class="form-control" id="collegeText" name="collegeText" value="<?= $student['ol_college'] ?? '' ?>">
                                <div id="collegeTextError" class="text-danger"></div>
                            </div>

                            <div class="mb-3">
                                <label for="programText" class="form-label">Program (Optional)</label>
                                <input type="text" class="form-control" id="programText" name="programText" value="<?= $student['ol_program'] ?? '' ?>">
                                <div id="programTextError" class="text-danger"></div>
                                </div>
                            </div>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                        <?php if (!$student): ?>
                        <a href="#" class="back-link" onclick="prevStep(); return false;">
                            <i class="fas fa-arrow-left"></i>
                            <span>Back to Learning Mode</span>
                        </a>
                        <?php endif; ?>
                        <div class="ms-auto">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" id="confirmSaveStudent" class="btn btn-primary">Add Student</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

