<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
  include_once "../../partials/header.php";
  include_once "../../partials/navigation.php"; 
?>

  <title>Add Flashcard - FlashUT</title>

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
<!-- 
  <link rel="stylesheet" href="../../template/css/styleguide.css" />
  <link rel="stylesheet" href="../../template/css/globals.css" /> -->
  <link rel="stylesheet" href="../../template/css/add-flashcard1.css" />

  
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    defer
  ></script>


    <script>
document.addEventListener("DOMContentLoaded", function () {
  let currentPage = 1, totalPages = 1;
  const container = document.getElementById("courseContainer");
  const btn = document.getElementById("loadMoreBtn");

  function renderCourse(course) {
    return `
      <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="card h-100 border-0">
          <div class="coursePic-wrapper mb-3">
            <a href="groupsOfCourse.php?course_id=${course.course_id}" class="d-block">
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
            <h5 class="card-title text-center">${course.course_name}</h5>
            <p class="card-text text-muted mb-2 text-center">Dr. ${course.firstName} ${course.lastName}</p>
            <div class="proffPic mb-4">
              <img src="../../template/imgGroups/professorIcon.svg" alt="Professor Icon" />
            </div>
            <div class="mt-auto w-80">
              <button 
                id="choose-btn" 
                class="btn view-course-button w-100 text-light"
                data-id="${course.section_id}" 
                data-name="${course.course_name}"
                data-firstname="${course.firstName}"
                data-lastname="${course.lastName}"
                data-image="${course.image_path}"
              >
                Adding
              </button>
            </div>
          </div>
        </div>
      </div>
    `;
  }

  function loadCourses(page) {
    fetch(`../../controllers/student/studentCourses.php?page=${page}&state=add`)
          .then(r => r.json())
      .then(data => {
        container.innerHTML = "";
        if (data.error) {
          container.innerHTML = `<p class="text-danger">${data.error}</p>`;
          btn.style.display = "none";
          return;
        }
          // const currentSemester = "46-2";  
          // let filteredCourses = data.courses.filter(c => c.semester_code === currentSemester);

          data.courses.forEach(c => {
                container.insertAdjacentHTML("beforeend", renderCourse(c));
              });

        //   filteredCourses.forEach(course => {  
        //   container.insertAdjacentHTML("beforeend", renderCourse(course));
        // });
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

  loadCourses(currentPage);


    function loadCourseInfo(course) {
    const container = document.getElementById("CourseContainer");
    const newUrl = `addFlashcard.php?section_id=${course.section_id}`;
    window.history.pushState({path: newUrl}, '', newUrl);


    container.querySelector(".courseName").textContent = course.course_name;
    container.querySelector(".profName").textContent = `Dr. ${course.firstName} ${course.lastName}`;
    container.querySelector(".coursePic").innerHTML = `<img src="../../template/imgCourses/${course.image_path}" alt="${course.course_name}" class="course-image" />`;
}

    document.addEventListener("click", function (event) {
    if (event.target.id === "choose-btn") {
      let firstPage = document.getElementById("firstPage");
      let secondPage = document.getElementById("secondPage");


      firstPage.style.display="none";
      secondPage.style.display="block";
      const course = {
            section_id: event.target.getAttribute("data-id"),
            course_name: event.target.getAttribute("data-name"),
            firstName: event.target.getAttribute("data-firstname"),
            lastName: event.target.getAttribute("data-lastname"),
            image_path: event.target.getAttribute("data-image")
        };
      loadCourseInfo(course);

     ;
    }
});

   
});
</script>



<script>
document.addEventListener("DOMContentLoaded", function () {
    const confirmBtn = document.querySelector("#QA-section .confirm-question");
    const EditQ_Btn = document.querySelector("#AQ-section .confirm-question");
    const AddFlashcard_Btn = document.querySelector("#AQ-section .AddingBtn");

    const answerSection = document.getElementById("AQ-section");
    const questionSection = document.getElementById("QA-section");

    const questionInput = answerSection.querySelector(".question");
    const answerInput = answerSection.querySelector(".answer");

    

    const flipper = document.querySelector(".flip-container");


    confirmBtn.addEventListener("click", function () {
      const questionInputInit = questionSection.querySelector(".question");

        const userQuestion = questionInputInit.value.trim();

        if (userQuestion === "") {
            alert("Please type a question before confirming.");
            return;
        }

        questionInput.textContent = userQuestion;
        flipper.classList.add("flipped");

    });

    EditQ_Btn.addEventListener("click", function () {
      const userAnswer = answerInput.value.trim();
      answerInput.textContent = userAnswer;
        
        flipper.classList.remove("flipped");

    });

    AddFlashcard_Btn.addEventListener("click", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const sectionId = urlParams.get("section_id");

    if (questionInput.textContent.trim() === "" || answerInput.value.trim() === "" || !sectionId) {
        alert("Please complete the flashcard before submitting.");
        return;
    }

    const formData = new FormData();
    formData.append("question", questionInput.textContent);
    formData.append("answer", answerInput.value);
    formData.append("section_id", sectionId);

    //  Show loading message while waiting for AI
    const resultContainer = document.createElement("div");
    resultContainer.classList.add("ai-result-message");
    resultContainer.innerHTML = `<p>⏳ Reviewing your flashcard with AI...</p>`;
    document.body.appendChild(resultContainer);

    fetch("../../controllers/addFlashcard.php", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.text())
        .then((response) => {
            resultContainer.remove();

            try {
                const result = JSON.parse(response);

                if (result.success) {
                    const feedback = result.feedback;
                    const status = result.status;

                    if (status === "approved") {
                        alert(
                            "✅ Your flashcard is approved by AI!\n\n" +
                                feedback +
                                "\n\nNow waiting for final review by your doctor."
                        );
                    } else {
                        alert(
                            "❌ Your flashcard was rejected by AI.\n\n" +
                                feedback +
                                "\n\nYou can edit and try again."
                        );
                    }

                    window.location.href = "addFlashcard.php";
                } else {
                    alert("Failed to add flashcard: " + result.message);
                }
            } catch (e) {
                console.error("Unexpected response:", response);
                alert("Error reviewing flashcard. Please try again.");
            }
        })
        .catch((err) => {
            resultContainer.remove();
            console.error("Error adding flashcard:", err);
            alert("Something went wrong while submitting.");
        });
});
});
</script>



    <?php
include_once "../../partials/navigation.php";
?>


<style>
  .ai-result-message {
  background-color: #fff8dc;
  padding: 16px;
  border: 1px solid #ffd700;
  position: fixed;
  top: 20px;
  left: 50%;
  transform: translateX(-50%);
  font-size: 16px;
  color: #333;
  border-radius: 8px;
  z-index: 1000;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.flip-container {
  width: 600px;
  height: auto;
  background-color: var(--black-haze);
  border-radius: 20px;
  box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
}

.flipper {
  transition: transform 0.8s ease;
  transform-style: preserve-3d;
  position: relative;
}

.front, .back {
  backface-visibility: hidden;
  position: absolute;
  width: 100%;
  
}

.front {
  z-index: 2;
}

.back {
  transform: rotateY(180deg);
  z-index: 1;
}

.flip-container.flipped .flipper {
  transform: rotateY(180deg);
}




.btn {
      background-color: #9A2828;
      border-color: #9A2828;
      color: #fff;
    }
    .btn:hover, .btn:focus {
      background-color: #751F1F;
      border-color: #751F1F;
    }
    .btn:active {
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
<body style="background-color: var(--black-haze);">


      <div class="container-fluid add-flashcard1">
      
        <div class="mainPage">

           <div id="firstPage" style="width:100%" class="row">

            <main  class="col-12 col-lg-12 py-3 ">

              <div class="mb-3">
              <h1 class="keep-flashin-smart-add-a-card">Keep Flashin’ Smart – Add a Card!</h1>

                  <h2 class="choose-a-course-first">Choose a class first!</h2>
                  </div>

                <div id="courseContainer" class="row g-4 mb-5 justify-content-center">

                  <p class="text-muted">Loading courses…</p>
                </div>

              <div class="d-flex justify-content-center mt-4">
                  <button id="loadMoreBtn" class="btn">
                    Load More
                  </button>
                </div>
              </main>
            </div>










            <div style="display: none; width:100%"  id="secondPage">

            <div class="titelContainer">
          <a href="addFlashcard.php" class="back-arrow-link">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="#9A2828" stroke="#9A2828" stroke-width="1.1"  class="size-6">
                   <path fill-rule="evenodd" d="M11.03 3.97a.75.75 0 0 1 0 1.06l-6.22 6.22H21a.75.75 0 0 1 0 1.5H4.81l6.22 6.22a.75.75 0 1 1-1.06 1.06l-7.5-7.5a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                  </svg>
                  <!-- <h1 class="titel-content">Groups</h1> -->

            </a>
            </div>

            <div class ="titels">

            <h1 class="keep-flashin-smart-add-a-card">Keep Flashin’ Smart – Add a Card!</h1>
            <h2 class="submit-your-sentense">Submit your flashcard, wait for review, then keep going!</h2>
            </div>

            <div class="flex-row">

              <div id ="CourseContainer" class="CourseContainer">


              <div class="coursePic-wrapper">
         <div class="coursePic"> </div>
      </div>                                      
                              

                                  <div class="courseNameContainer">
                                    <h1 class="courseName"></h1>
                                  </div>


                                  <div class="profSection">
                                        <img class="profIcon" src="../../template/imgGroups/professorIcon.svg" alt="Professor Vector"/>                                                               
                                        <h2 class="profName"></h2>
                                  </div>    
                                  
                      </div>



                  <div class="flip-container">
                         <div class="flipper" id="flipper">
                                    <!-- Front: QA-section -->
                                    <div class="front QA-section" id="QA-section">
                                          <div class="QA-container">
                                                <div class="A-container">
                                                      <p class="answer"></p>
                                                </div>
                                                <div class="Q-container">
                                                       <textarea class="question" placeholder="Type your question here" rows="3"></textarea>
                                                </div>
                                          </div>

                                          <div class="BtnsContainer">
                                                <button class="confirm-question">Confirm Question</button>
                                          </div>
                                    </div>

                                    <!-- Back: AQ-section -->
                                    <div  class="back QA-section" id="AQ-section">
                                          <div class="QA-container">
                                                <div class="Q-container">
                                                      <p class="question"></p>
                                                </div>
                                                <div class="A-container">
                                                       <textarea class="answer" placeholder="Type your answer here" rows="3"></textarea>
                                                </div>
                                          </div>

                                          <div class="BtnsContainer">
                                                <button class="confirm-question">Edit Question</button>
                                                <button class="AddingBtn">Adding</button>
                                          </div>
                                    </div>
                         </div>
                  </div>


            </div>
          </div>




          
            </div>


                  
        </div>
      </div>
  </body>
</html>
