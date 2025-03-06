<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="personaldetails.css" />
  <link rel="stylesheet" href="style.css" />
  <title>Personal Details</title>
</head>

<body>
  <br /><br />

  <h1>Personal Details:</h1>
  <form id="myform" action="insert_form.php" method="post" enctype="multipart/form-data">

    <img id="imgPreview" src="images/avatar.jpeg" alt="avatar" width="100" height="100" style="border-radius:50%;" />
    <input type="file" id="file" name="image" accept="image/*" onchange="previewImage(event)" /><br />
    <button type="submit">Upload</button>

    <br /><br />
    <label for="job_title">Job Title:</label>
    <input type="text" placeholder="Job Title..." name="job_pref_title" id="job_title" /><br />

    <label for="phone">Phone:</label>
    <input type="tel" name="phone" id="phone" placeholder="Enter phone number..." pattern="[0-9]{10,15}" required /><br />

    <label for="country">Country:</label>
    <input type="text" name="country" id="country" placeholder="Enter your country..." /><br />

    <label for="city">City:</label>
    <input type="text" name="job_pref_city" id="city" placeholder="Enter your city..." /><br />

    <div>
      <h1>Professional Summary</h1>
      <textarea placeholder="Summary..." name="professional_summary" required></textarea>
    </div>

    <label for="first_names">First Name:</label>
    <input type="text" name="first_names" required /><br />

    <label for="last_names">Last Name:</label>
    <input type="text" name="last_names" required /><br />

    <label for="emails">Email:</label>
    <input type="email" name="emails" required /><br />

    <h1 style="color: black;">Job Preferences</h1>
    <p style="color: orange;">Tell us about the job you want. We use this information to find and recommend the best jobs for you.</p>

    <h2 style="color: black;">Preferred Location:</h2>
    <label for="location">Location:</label>
    <input type="text" name="location" id="location" placeholder="Preferred Location..." /><br />

    <h1 style="color: black;">Work Experience</h1>
    <p style="color: orange;">Show Your Relevant Experience (Last 10 years). Use bullet points to note your achievements.</p>

    <h3 id="emp" style="color: black;">Add Employment</h3>
    <div id="employment-container"></div>

    <h2 style="color: green;">Select Your Skills</h2>
    <div id="checkboxForm">
      <label><input type="checkbox" name="skills[]" value="Web Development" /> Web Development</label><br />
      <label><input type="checkbox" name="skills[]" value="Android Development" /> Android Development</label><br />
      <label><input type="checkbox" name="skills[]" value="iOS Development" /> iOS Development</label><br />
      <label><input type="checkbox" name="skills[]" value="Machine Learning" /> Machine Learning</label><br />
      <label><input type="checkbox" name="skills[]" value="Deep Learning" /> Deep Learning</label><br />
      <label><input type="checkbox" name="skills[]" value="DSA" /> DSA</label><br />
      <label><input type="checkbox" name="skills[]" value="Database" /> Database</label><br />
    </div>

    <div id="checkboxOutput"></div>

    <h2 style="color: black;">Courses</h2>
    <h3 id="course" style="color: black;">Add Course</h3>
    <div id="outputCourse"></div>

    <button type="submit">Submit</button>
  </form>
  <br>

  <footer>
    <p>&copy; 2023 Resume Builder. All rights reserved.</p>
  </footer>

  <script src="index.js"></script>
</body>

</html>