<?php
  include_once "../../partials/header.php";
  include_once "../../partials/auth_admin.php"; 
  include_once "../../partials/navigation.php";
?>

  <title>Admin Classes – FlashUT</title>

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
<!-- 
  <link rel="stylesheet" href="../../template/css/styleguide.css" />
  <link rel="stylesheet" href="../../template/css/globals.css" /> -->
  <link rel="stylesheet" href="../../template/css/courses.css" />


  <style>
    .btn-primary {
      background-color: #9A2828;
      border-color: #9A2828;
      color: #fff;
    }
    .btn-primary:hover, .btn-primary:focus {
      background-color: #751F1F;
      border-color: #751F1F;
    }
    .btn-primary:active {
      background-color: #5E1817;
      border-color: #5E1817;
    }

    .card {
      background-color: transparent !important;
      border: none;
      box-shadow: none;
    }
    .card-img-top {
      border-radius: .5rem;
    }
    .coursePic-wrapper img {
      border-radius: .5rem;
      object-fit: cover;
    }
  </style>
</head>


  <div class="container-fluid courses">
    <div class="row">

    <main class="col-12 col-lg-12 py-5">

       <div class="mb-5">
          <h1 class="keep-flashin-smart-add-a-card">
            Keep Flashin' Smart - Let's Flip &amp; Learn!
          </h1>
          <h2 class="choose-a-course-first">Choose your course and dive in</h2>
        </div>

        <div class="mb-4 text-start">
  <select id="semesterSelect" class="form-select w-auto d-inline-block">
    <!-- <option value="">All Semesters</option>
    <option value="46-2">46-2</option>
    <option value="46-1">46-1</option>
    <option value="45-3">45-3</option> -->
    <!-- Add more as needed -->
  </select>
</div>


        <div id="courseContainer" class="row g-4 mb-5 justify-content-center">

           <p class="text-muted">Loading courses…</p>
        </div>

        <div class="text-center mt-4">
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

      function renderCourse(course) {
        return `
          <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100 border-0">

              <div class="coursePic-wrapper mb-3 ">
                <a href="groupsOfClass.php?section_id=${course.section_id}" class="d-block">
                <div class="coursePic">
                  <img
                    src="../../template/imgCourses/${course.image_path}"
                    alt="${course.course_name}"
                    style="width:100%; height:auto; display:block; cursor:pointer;"
                  />
                 </div>
                </a>
              </div>

              <div class="card-body d-flex flex-column align-items-center">
                <h5 class="card-title text-center mb-2">${course.course_name}</h5>
                   <strong class="card-title text-center mb-2">${course.section_name}</strong>


                

                 <div class="proffPic mb-4">
                    <img
                    src="../../template/imgGroups/professorIcon.svg"
                    alt="Professor Icon"
                    />
                 </div>

                 
               
                 <div class="mt-auto w-80">
                    <a
                    href="groupsOfClass.php?section_id=${course.section_id}"
                    class="btn view-course-button w-100 text-light"
                    >
                    View class
                    </a>
                </div>
              </div>
            </div>
          </div>
        `;
      }

      function loadCourses(page) {
        const semester = document.getElementById('semesterSelect').value;
        fetch(`../../controllers/admin/adminClasses.php?page=${page}&semester=${semester}`)
          .then(r => r.json())
          .then(data => {
            container.innerHTML = "";
            if (data.error) {
              container.innerHTML = `<p class="text-danger">${data.error}</p>`;
              btn.style.display = "none";
              return;
            }
            if (data.courses.length === 0) {
                container.innerHTML = `<p class="error-message">No courses found for this semester.</p>`;
                btn.style.display = "none";
                return;
            }
            if (data.semesters) {
            updateSemesterOptions(data.semesters);
        }

            data.courses.forEach(c => {
              container.insertAdjacentHTML("beforeend", renderCourse(c));
            });
            totalPages = data.totalPages;
            btn.style.display = totalPages > 1 ? "inline-block" : "none";
            btn.textContent = (currentPage < totalPages) ? "Next Courses" : "First Page";
          })
          .catch(console.error);
      }

      btn.addEventListener("click", () => {
        currentPage = (currentPage < totalPages) ? currentPage + 1 : 1;
        loadCourses(currentPage);
      });

      document.getElementById('semesterSelect').addEventListener('change', () => {
          currentPage = 1;
          loadCourses(currentPage);
        });

        function updateSemesterOptions(semesters) {
          const semesterSelect = document.getElementById('semesterSelect');
          semesterSelect.innerHTML = '<option value="">All Semesters</option>'; 

          semesters.forEach(code => {
              const option = document.createElement('option');
              option.value = code;
              option.textContent = code;
              semesterSelect.appendChild(option);
    });
}


      loadCourses(currentPage);
    });
  </script>
</body>
</html>