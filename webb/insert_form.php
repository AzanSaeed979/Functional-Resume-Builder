<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "resumebuilder";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$image_path = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        
        $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];
        $allowed_mimes = ['image/jpeg', 'image/png', 'image/gif'];
        $mime_type = mime_content_type($image_tmp);

        if (!in_array($image_ext, $allowed_exts) || !in_array($mime_type, $allowed_mimes)) {
            die("Error: Only JPG, JPEG, PNG, and GIF files are allowed.");
        }

        if ($image_size > 2 * 1024 * 1024) {
            die("Error: File size exceeds 2MB.");
        }

        $new_filename = uniqid() . "." . $image_ext;
        $upload_path = "uploads/" . $new_filename;

        if (move_uploaded_file($image_tmp, $upload_path)) {
            $image_path = $upload_path;
        } else {
            die("Error: Failed to upload image.");
        }
    }

    $first_name = isset($_POST['first_names']) ? trim($_POST['first_names']) : '';
    $last_name = isset($_POST['last_names']) ? trim($_POST['last_names']) : '';
    $email = isset($_POST['emails']) ? trim($_POST['emails']) : '';

    $stmt = $conn->prepare("INSERT INTO personal_details (first_name, last_name, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $first_name, $last_name, $email);
    
    if ($stmt->execute()) {
        $personal_id = $conn->insert_id;
    } else {
        die("Error inserting personal details: " . $conn->error);
    }

    if (isset($_POST['job_titles']) && is_array($_POST['job_titles'])) {
        $job_titles = $_POST['job_titles'];
        $employers = $_POST['employer'];
        $start_dates = $_POST['start_date'];
        $end_dates = $_POST['end_date'];
        $cities = $_POST['cities'];
        $descriptions = $_POST['description'];

        $stmt = $conn->prepare("INSERT INTO employment (personal_id, job_title, employer, start_date, end_date, city, description) VALUES (?, ?, ?, ?, ?, ?, ?)");

        foreach ($job_titles as $key => $job_title) {
            $job_title = trim($job_title);
            $employer = isset($employers[$key]) ? trim($employers[$key]) : "";
            $start_date = isset($start_dates[$key]) ? trim($start_dates[$key]) : "";
            $end_date = isset($end_dates[$key]) ? trim($end_dates[$key]) : "";
            $city = isset($cities[$key]) ? trim($cities[$key]) : "";
            $description = isset($descriptions[$key]) ? trim($descriptions[$key]) : "";

            $stmt->bind_param("issssss", $personal_id, $job_title, $employer, $start_date, $end_date, $city, $description);
            $stmt->execute();
        }
    }

    if (isset($_POST['course_title']) && is_array($_POST['course_title'])) {
        $course_titles = $_POST['course_title'];
        $institutions = $_POST['institution'];
        $edu_start_dates = isset($_POST['edu_start_date']) ? $_POST['edu_start_date'] : [];
        $edu_end_dates = isset($_POST['edu_end_date']) ? $_POST['edu_end_date'] : [];

        $stmt = $conn->prepare("INSERT INTO education (personal_id, course_title, institution, start_date, end_date) VALUES (?, ?, ?, ?, ?)");

        foreach ($course_titles as $key => $course) {
            $course = trim($course);
            $institution = trim($institutions[$key]);
            $edu_start_date = isset($edu_start_dates[$key]) ? $edu_start_dates[$key] : "";
            $edu_end_date = isset($edu_end_dates[$key]) ? $edu_end_dates[$key] : "";

            $stmt->bind_param("issss", $personal_id, $course, $institution, $edu_start_date, $edu_end_date);
            $stmt->execute();
        }
    }

    if (isset($_POST['skill_name']) && is_array($_POST['skill_name']) && isset($_POST['skill_level']) && is_array($_POST['skill_level'])) {
        $skill_names = $_POST['skill_name'];
        $skill_levels = $_POST['skill_level'];

        $stmt = $conn->prepare("INSERT INTO skills (personal_id, skill_name, skill_level) VALUES (?, ?, ?)");

        foreach ($skill_names as $index => $skill_name) {
            $skill_level = $skill_levels[$index];
            $stmt->bind_param("iss", $personal_id, $skill_name, $skill_level);
            $stmt->execute();
        }
    }

    $job_pref_title = isset($_POST['job_pref_title']) ? trim($_POST['job_pref_title']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $country = isset($_POST['country']) ? trim($_POST['country']) : '';
    $job_pref_city = isset($_POST['job_pref_city']) ? trim($_POST['job_pref_city']) : '';
    $professional_summary = isset($_POST['professional_summary']) ? trim($_POST['professional_summary']) : '';
    $location = isset($_POST['location']) ? trim($_POST['location']) : '';
    $image = $image_path ? $image_path : null;

    $stmt = $conn->prepare("INSERT INTO job_preferences (job_title, phone, country, city, professional_summary, location, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $job_pref_title, $phone, $country, $job_pref_city, $professional_summary, $location, $image);

    if ($stmt->execute()) {
        echo "Your resume data has been successfully saved!";
    } else {
        die("Error inserting job preferences: " . $conn->error);
    }
}

$conn->close();
?>
