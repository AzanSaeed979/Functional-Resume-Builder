<?php
require '../vendor/autoload.php';

$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "resumebuilder";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    throw new Exception("Connection failed: " . $conn->connect_error);
}

$sql_personal = "SELECT * FROM personal_details ORDER BY id DESC LIMIT 1";
$result_personal = $conn->query($sql_personal);
$personal = $result_personal->fetch_assoc();

if (!$personal) {
    throw new Exception("No personal details found.");
}

$sql_job_preferences = "SELECT * FROM job_preferences ORDER BY id DESC LIMIT 1";
$result_job_preferences = $conn->query($sql_job_preferences);
$job_preferences = $result_job_preferences->fetch_assoc();

function fetchData($conn, $table, $personal_id)
{
    $stmt = $conn->prepare("SELECT * FROM $table WHERE personal_id = ?");
    $stmt->bind_param("i", $personal_id);
    $stmt->execute();
    return $stmt->get_result();
}

$result_employment = fetchData($conn, "employment", $personal['id']);
$result_education = fetchData($conn, "education", $personal['id']);
$result_skills = fetchData($conn, "skills", $personal['id']);

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);

$pdf->Cell(0, 10, 'Resume', 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Resume Header', 0, 1);
$pdf->SetFont('Arial', '', 10);

if (!empty($job_preferences['image'])) {
    $imagePath = realpath($job_preferences['image']);
    $pdf->Cell(0, 7, 'Profile Picture:', 0, 1);
    $pdf->Image($imagePath, 50, 50, 40, 40);
}

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Personal Details', 0, 1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 7, 'Name: ' . $personal['first_name'] . ' ' . $personal['last_name'], 0, 1);
$pdf->Cell(0, 7, 'Email: ' . $personal['email'], 0, 1);
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Job Preferences', 0, 1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 7, 'Job Title: ' . ($job_preferences['job_title'] ?? "Not found"), 0, 1);
$pdf->Cell(0, 7, 'City: ' . $job_preferences['city'], 0, 1);
$pdf->Cell(0, 7, 'Phone: ' . $job_preferences['phone'], 0, 1);
$pdf->Cell(0, 7, 'Country: ' . $job_preferences['country'], 0, 1);
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Employment Details', 0, 1);
$pdf->SetFont('Arial', '', 10);
while ($employment = $result_employment->fetch_assoc()) {
    $pdf->Cell(0, 7, 'Job Title: ' . $employment['job_title'], 0, 1);
    $pdf->Cell(0, 7, 'Employer: ' . $employment['employer'], 0, 1);
    $pdf->Cell(0, 7, 'City: ' . $employment['city'], 0, 1);
    $pdf->Cell(0, 7, 'Start Date: ' . date('F j, Y', strtotime($employment['start_date'])), 0, 1);
    $pdf->Cell(0, 7, 'End Date: ' . (empty($employment['end_date']) ? 'Present' : date('F j, Y', strtotime($employment['end_date']))), 0, 1);
    $pdf->Ln(5);
}

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Education Details', 0, 1);
$pdf->SetFont('Arial', '', 10);
while ($education = $result_education->fetch_assoc()) {
    $pdf->Cell(0, 7, 'Course: ' . $education['course_title'], 0, 1);
    $pdf->Cell(0, 7, 'Institution: ' . $education['institution'], 0, 1);
    $pdf->Cell(0, 7, 'Start Date: ' . date('F j, Y', strtotime($education['start_date'])), 0, 1);
    $pdf->Cell(0, 7, 'End Date: ' . (empty($education['end_date']) ? 'Present' : date('F j, Y', strtotime($education['end_date']))), 0, 1);
    $pdf->Ln(5);
}

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Skills', 0, 1);
$pdf->SetFont('Arial', '', 10);
while ($skill = $result_skills->fetch_assoc()) {
    $pdf->Cell(0, 7, 'Skill: ' . $skill['skill_name'], 0, 1);
    $pdf->Ln(5);
}



$pdf->Output();
?>
