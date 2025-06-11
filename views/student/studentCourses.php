<?php
include_once "../../partials/header.php";
?>

  <title>Courses - FlashUT</title>

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />

  <!-- <link rel="stylesheet" href="../../template/css/styleguide.css" />
  <link rel="stylesheet" href="../../template/css/globals.css" /> -->
  <link rel="stylesheet" href="../../template/css/courses.css" />

  <style>
    .btn-primary {
      background-color: #9A2828 !important;
      border:none!important;
      color: #fff;
    }
    .btn-primary:hover,
    .btn-primary:focus {
      background-color: #751F1F !important;
      color: #fff;
    }
    .btn-primary:active {
      background-color: #5E1817!important;
      color: #fff;
    }

    .card {
      background-color: transparent !important;
      border: none;
      box-shadow: none;
    }

    .card-img-top {
      border-radius: .5rem;
    }
  </style>

  <?php include_once "../../partials/navigation.php"; ?>

  <div class="container-fluid courses">
    <div class="row">
     

      <main class="col-12 col-lg-12 py-4">
        <div class="mb-1">
          <h1 class="keep-flashin-smart-add-a-card">
            Keep Flashin' Smart - Let's Flip &amp; Learn!
          </h1>
          <h2 class="choose-a-course-first">Choose your course and dive in</h2>
        </div>

        <div class="mb-1 text-start">
  <select id="semesterSelect" class="form-select w-auto d-inline-block">
    <!-- <option value="">All Semesters</option>
    <option value="46-2">46-2</option>
    <option value="46-1">46-1</option>
    <option value="45-3">45-3</option> -->

  </select>
</div>

        <div id="courseContainer" class="row g-4 mb-3 justify-content-center">
          <p class="text-muted">Loading courses…</p>
        </div>

        <div class="text-center">
          <button id="loadMoreBtn" class="btn btn-primary">
            Load More
          </button>
        </div>
      </main>
    </div>
  </div>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    defer
  ></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      let currentPage = 1, totalPages = 1;
      const container = document.getElementById("courseContainer");
      const btn       = document.getElementById("loadMoreBtn");

      function renderCourse(course,currentSemester) {
      const isCurrent = course.semester_code === currentSemester;  

  return `
          <div class="col-12 col-sm-6 col-md-4 col-lg-3">
      <div class="card h-100 border-0">

        <!-- clickable image wrapper -->
        <div class="coursePic-wrapper mb-3">
          <a href="groupsOfCourse.php?section_id=${course.section_id}" class="d-block">
            <div class="coursePic">
              <img
                src="../../template/imgCourses/${course.image_path}"
                alt="${course.course_name}"
                style="width:100%; height:auto; display:block; cursor:pointer;"
              />
            </div>
          </a>
                   ${isCurrent ? `<span class="badge bg-danger position-relative align-self-center">Current</span>` : ""}

      

        </div>

        <div class="card-body d-flex flex-column align-items-center">
          <h5 class="card-title text-center">${course.course_name}</h5>
           <strong class="card-title text-center mb-2">${course.section_name}</strong>

          <p class="card-text text-muted mb-2 text-center">
            Dr. ${course.firstName} ${course.lastName}
          </p>

          <div class="proffPic mb-4">
            <img
              src="../../template/imgGroups/professorIcon.svg"
              alt="Professor Icon"
            />
          </div>

          <div class="mt-auto w-80">
            <a
              href="groupsOfCourse.php?section_id=${course.section_id}"
              class="btn view-course-button w-100 text-light"
            >
              View Course
            </a>
          </div>
        </div>
      </div>
    </div>
  `;
}
        function loadCourses(page) {
          const semester = document.getElementById('semesterSelect').value;
          fetch(`../../controllers/student/studentCourses.php?page=${page}&semester=${semester}`)
            .then(r => r.json())
            .then(data => {
              container.innerHTML = "";
              if (data.error) {
                container.innerHTML = `<p class="error-message">${data.error}</p>`;
                btn.style.display = "none";
                return;
              }
              if (data.courses.length === 0) {
                container.innerHTML = `<p class="error-message">No courses found for this semester.</p>`;
                btn.style.display = "none";
                return;
            }
            if (data.semesters) {
              updateSemesterOptions(data.semesters,data.currentSemester);
            }

            
              data.courses.forEach(c => {
                container.insertAdjacentHTML("beforeend", renderCourse(c,data.currentSemester));
              });
              totalPages = data.totalPages;
              btn.style.display = totalPages > 1 ? "inline-block" : "none";
              btn.textContent = (currentPage < totalPages) ? "Next Courses" : "First Page";
            });
        }

      btn.addEventListener("click", () => {
        currentPage = (currentPage < totalPages) ? currentPage + 1 : 1;
        loadCourses(currentPage);
      });

        document.getElementById('semesterSelect').addEventListener('change', () => {
          currentPage = 1;
          loadCourses(currentPage);
        });


        function updateSemesterOptions(semesters, currentSemester) {
    const semesterSelect = document.getElementById('semesterSelect');
    const previousValue = semesterSelect.value;

    semesterSelect.innerHTML = '<option value="">All Semesters</option>';

    semesters.forEach(code => {
        const option = document.createElement('option');
        option.value = code;
        option.textContent = (code === currentSemester) ? `${code} (current)` : code;
        semesterSelect.appendChild(option);
    });

    if (semesters.includes(previousValue) || previousValue === "") {
        semesterSelect.value = previousValue;
    } 
}
        

      loadCourses(currentPage);
    });
  </script>
</body>
</html>