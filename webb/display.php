<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Resume</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e0eafc, #cfdef3);
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .resume-container {
            width: 800px;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .resume-header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 3px solid #444;
        }

        .resume-header img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }

        .resume-header img:hover {
            transform: scale(1.1);
        }

        h2 {
            background: #444;
            color: white;
            padding: 12px;
            border-radius: 5px;
            font-size: 20px;
            text-align: center;
        }

        p {
            margin: 5px 0;
            font-size: 16px;
            color: #222;
        }

        .resume-section {
            margin-top: 20px;
            padding: 20px;
            border-radius: 10px;
            background: #f3f3f3;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .resume-section:hover {
            transform: scale(1.03);
            box-shadow: 0 5px 12px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>

    <div class="resume-container">

        <?php
        $servername = "localhost:3307";
        $username = "root";
        $password = "";
        $dbname = "resumebuilder";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql_personal = "SELECT * FROM personal_details ORDER BY id DESC LIMIT 1";
        $result_personal = $conn->query($sql_personal);
        $personal = $result_personal->fetch_assoc();

        if (!$personal) {
            die("<p>No personal details found.</p>");
        }

        $stmt = $conn->prepare("SELECT * FROM employment WHERE personal_id = ?");
        $stmt->bind_param("i", $personal['id']);
        $stmt->execute();
        $result_employment = $stmt->get_result();

        $stmt = $conn->prepare("SELECT * FROM education WHERE personal_id = ?");
        $stmt->bind_param("i", $personal['id']);
        $stmt->execute();
        $result_education = $stmt->get_result();

        $stmt = $conn->prepare("SELECT * FROM skills WHERE personal_id = ?");
        $stmt->bind_param("i", $personal['id']);
        $stmt->execute();
        $result_skills = $stmt->get_result();

        $sql_job_preferences = "SELECT * FROM job_preferences ORDER BY id DESC LIMIT 1";
        $result_job_preferences = $conn->query($sql_job_preferences);
        $job_preferences = $result_job_preferences->fetch_assoc();
        ?>

        <div class="resume-header">
            <?php if (!empty($job_preferences['image'])): ?>
                <img src="<?= $job_preferences['image'] ?>" alt="Profile Picture">
            <?php endif; ?>
            <h1><?= $personal['first_name'] . " " . $personal['last_name'] ?></h1>
            <p>Email: <?= $personal['email'] ?></p>
        </div>

        <div class="resume-section">
            <h2>Job Preferences</h2>
            <p><strong>Job Title:</strong> <?= $job_preferences['job_title'] ?? "Not found" ?></p>
            <p><strong>City:</strong> <?= $job_preferences['city'] ?></p>
            <p><strong>Phone:</strong> <?= $job_preferences['phone'] ?></p>
            <p><strong>Country:</strong> <?= $job_preferences['country'] ?></p>
        </div>

        <div class="resume-section">
            <h2>Employment Details</h2>
            <?php while ($employment = $result_employment->fetch_assoc()): ?>
                <p><strong>Job Title:</strong> <?= $employment['job_title'] ?></p>
                <p><strong>Employer:</strong> <?= $employment['employer'] ?></p>
                <p><strong>City:</strong> <?= $employment['city'] ?></p>
                <hr>
            <?php endwhile; ?>
        </div>

        <div class="resume-section">
            <h2>Education</h2>
            <?php while ($education = $result_education->fetch_assoc()): ?>
                <p><strong>Course:</strong> <?= $education['course_title'] ?></p>
                <p><strong>Institution:</strong> <?= $education['institution'] ?></p>
                <hr>
            <?php endwhile; ?>
        </div>

        <div class="resume-section">
            <h2>Skills</h2>
            <?php while ($skill = $result_skills->fetch_assoc()): ?>
                <p><strong>Skill:</strong> <?= $skill['skill_name'] ?> (Level: <?= $skill['skill_level'] ?>)</p>
            <?php endwhile; ?>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <a href="download.php" class="download-btn" download style="text-decoration: none;">
                <button style="
            background: #444; 
            color: white; 
            border: none; 
            padding: 10px 20px; 
            font-size: 16px; 
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s ease;">
                    Download Resume
                </button>
            </a>
        </div>


    </div>
</body>

</html>

<?php
$conn->close();
?>