document.addEventListener("DOMContentLoaded", function () {
  // Function to Preview Image Before Upload
  window.previewImage = function (event) {
    const imgPreview = document.getElementById("imgPreview");
    const file = event.target.files[0];

    if (file) {
      const reader = new FileReader();
      reader.onload = function () {
        imgPreview.src = reader.result;
      };
      reader.readAsDataURL(file);
    }
  };

  const employ = document.getElementById("emp");
  const employmentContainer = document.getElementById("employment-container");
  let employmentCount = 0;
  const maxEmployment = 3;

  employ.onclick = function () {
    if (employmentCount < maxEmployment) {
      employmentCount++;

      const newEmployment = document.createElement("div");
      newEmployment.classList.add("employment-section");

      newEmployment.innerHTML = `
        <h4 >Employment ${employmentCount}</h4>
        <label>Job Title:</label>
        <input  type="text" name="job_titles[]" required /><br />

        <label>Employer:</label>
        <input type="text" name="employer[]" required /><br />

        <label>Start Date:</label>
        <input type="date" name="start_date[]" required />
        <label>End Date:</label>
        <input type="date" name="end_date[]" required /><br />

        <label>City:</label>
        <input type="text" name="cities[]" required /><br />

        <label>Description:</label>
        <textarea name="description[]" rows="3" required></textarea>
      `;

      employmentContainer.appendChild(newEmployment);
    } else {
      alert("You can only add up to 3 employment sections.");
    }
  };

  const form = document.getElementById("checkboxForm");
  const checkboxOutput = document.getElementById("checkboxOutput");

  form.addEventListener("change", function (event) {
    const checkbox = event.target;
    const skillValue = checkbox.value;

    if (checkbox.checked) {
      const skillDiv = document.createElement("div");
      skillDiv.classList.add("skill-item");
      skillDiv.setAttribute("data-skill", skillValue);
      skillDiv.innerHTML = `
        <h3 style="color: green;">${skillValue}</h3>
        <label>Select Level:</label>
        <select name="skill_level[]">
            <option value="Beginner">Beginner</option>
            <option value="Intermediate">Intermediate</option>
            <option value="Expert">Expert</option>
        </select>
        <input style="color: green;" type="hidden" name="skill_name[]" value="${skillValue}">
      `;

      checkboxOutput.appendChild(skillDiv);
    } else {
      const skillDivToRemove = document.querySelector(`.skill-item[data-skill="${skillValue}"]`);
      if (skillDivToRemove) {
        checkboxOutput.removeChild(skillDivToRemove);
      }
    }
  });

  let courseContainer = document.getElementById("outputCourse");
  let addCourseBtn = document.getElementById("course");
  let courseCount = 0;
  const maxCourses = 3;

  addCourseBtn.addEventListener("click", function () {
    if (courseCount < maxCourses) {
      courseCount++;
      let courseDiv = document.createElement("div");
      courseDiv.innerHTML = `
          <h2 style="color: green;">Course ${courseCount}</h2>
          <label>Course Title:</label>
          <input type="text" name="course_title[]" required /><br/>

          <label>Institution:</label>
          <input type="text" name="institution[]" required /><br/>

          <label>Start Date:</label>
          <input type="date" name="edu_start_date[]" required />
          <label>End Date:</label>
          <input type="date" name="edu_end_date[]" required />

      `;

      courseContainer.appendChild(courseDiv);
    } else {
      alert("You can only add up to 3 courses.");
    }
  });
});
