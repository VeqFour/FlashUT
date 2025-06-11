
<?php
  include_once "../../partials/header.php";
  include_once "../../partials/auth_admin.php"; 
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
  >
</script>

    <script>
document.addEventListener("DOMContentLoaded", function () {
    let currentPage = 1; 
    let totalPages = 1; 
    let selectedSectionId = null; 

  const container = document.getElementById("courseContainer");
  const btn = document.getElementById("loadMoreBtn");

  function renderCourse(course) {
    return `
      <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="card h-100 border-0">
          <div class="coursePic-wrapper mb-3">
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
            <div class="proffPic mb-5">
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
    fetch(`../../controllers/admin/adminClasses.php?page=${page}`)
      .then(r => r.json())
      .then(data => {
        container.innerHTML = "";
        if (data.error) {
          container.innerHTML = `<p class="text-danger">${data.error}</p>`;
          btn.style.display = "none";
          return;
        }
        
        const currentSemester = "46-2";  
        let filteredCourses = data.courses.filter(c => c.semester_code === currentSemester);

         filteredCourses.forEach(course => {  
          container.insertAdjacentHTML("beforeend", renderCourse(course));
        });
        totalPages = data.totalPages;
        btn.style.display = totalPages > 1 ? "inline-block" : "none";
        btn.textContent = (currentPage < totalPages) ? "Next Courses" : "First Page";
      })
      .catch(err => console.error("Error loading courses:", err));
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



let currentPageG = 1; 
let totalPagesG = 1; 
const prevBtn = document.querySelector(".previous-vector");
const nextBtn = document.querySelector(".next-vector");

            function loadGroups(page) {
              if (!selectedSectionId) return; 

             
              fetch(`../../controllers/admin/groupsOfClass.php?page=${page}&section_id=${selectedSectionId}`)
              .then(response => response.json())
              .then(data => {
                let groupSection = document.querySelector(".groupSection");
                let groupCardsContainer = document.querySelector(".groupCardsContainer"); 
                groupSection.innerHTML = "";

                if (data.error) {
                  groupSection.innerHTML =`<p class="error-message">${data.error}</p>`;
                  return;
                }

                if (data.totalPages === 0) {
                  groupSection.innerHTML = "<p>No Groups found.</p>";
                return;
            }
            document.querySelector(".NoOfGroups").textContent = `${data.total} Groups`;


                data.groups.forEach(group => {

                  let groupHTML = `
                    <div class="cardContainer">
                        
                        <div class="cardItems">
                            <h2 class="groupName">${group.group_name}</h2>
                            <div class="bottomPart">
                                <h3 class="NoOfFlashcards">${group.flashcard_count} Flashcards</h3>
                                <button class="flashing-button"
                                 data-id="${group.group_id}" 
                                data-name="${group.group_name}"
                                         >
                                    Add here
                                   <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                  </svg>

                                </button>
                            </div>
                        </div>
                    </div>`;
                    groupSection.innerHTML += groupHTML;
  

            });

            totalPagesG = data.totalPages;

           
        prevBtn.style.opacity = (currentPageG > 1 ? "1" : "0.3");
        nextBtn.style.opacity = (currentPageG < totalPagesG ? "1" : "0.3");
        })
        .catch(error => console.error("Error loading groups:", error));
    }
    prevBtn.addEventListener("click", () => {
    if (currentPageG > 1) {
      currentPageG--;
      loadGroups(currentPageG);
    }
  });

  // next arrow
  nextBtn.addEventListener("click", () => {
    if (currentPageG < totalPagesG) {
      currentPageG++;
      loadGroups(currentPageG);
    }
  });



    
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
      
      selectedSectionId= course.section_id;
        
      loadCourseInfo(course);

        loadGroups(currentPageG);

    }
    if (event.target.closest(".flashing-button")) {
    const groupBtn = event.target.closest(".flashing-button");
    
    const groupId = groupBtn.getAttribute("data-id");
    const groupName = groupBtn.getAttribute("data-name");

    document.querySelector(".groupCardsContainer").style.display = "none";

    document.getElementById("fillCard").style.display = "block";



    window.selectedGroupId = groupBtn.getAttribute("data-id");
}
});

    document.getElementById("loadMoreBtn").addEventListener("click", function () {
        if (currentPage < totalPages) {
            currentPage++;
        } else {
            currentPage = 1; 
        }
        loadCourses(currentPage);
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
    const section_id = urlParams.get('section_id');
    const groupId = window.selectedGroupId;

    if (questionInput.value === "" || answerInput.value === "" || !section_id || !groupId) {
        alert("Please complete the flashcard and select a group before submitting.");
        return;
    }

    const formData = new FormData();
    formData.append("question", questionInput.textContent);
    formData.append("answer", answerInput.value);
    formData.append("section_id", section_id);
    formData.append("group_id", groupId);

    fetch("../../controllers/admin/addFlashcardAdmin.php", {
        method: "POST",
        body: formData,
    })
    .then((response) => response.text())
    .then((response) => {
        if (response.trim() === "success") {
            alert("Flashcard added successfully!");
            window.location.href = "addFlashcard.php";
        } else {
            alert("Failed to add flashcard: " + response);
        }
    })
    .catch((err) => console.error("Error adding flashcard:", err));
});
});
</script>




<style>

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





.groupSection {
  align-items: flex-start;
  display: flex;
  flex-wrap: wrap;
  gap: 30px;
  height: 565px;
  position: relative;
  width: 500px;
}

 .cardContainer {
  box-shadow: inset 0px 4px 4px #00000040, inset 0px 4px 4px #00000040, 0px 4px 4px #00000040;
  height: 275px;
  width: 225px;
  max-width: 225px;
  position: relative;
  display: flex; 
  align-items: center; 
  justify-content: center; 
  border-radius: 12px;

  
}
/* 
.faviorateIcon {
  position: absolute;
  top: 10px;  
  right: 10px; 
  width: 24px; 
  height: 24px; 
  cursor: pointer; 
} */

.cardItems {
  display: flex;
  flex-direction: column;
  justify-content: space-between; 
  align-items: center;
  padding-top: 25px;
  height: 225px; 
  gap: 15px;
  width: auto;
  max-width: 100%;


}


.groupName {
  -webkit-background-clip: text !important;
  -webkit-text-fill-color: transparent;
  background: linear-gradient(180deg, rgb(117, 31, 31) 0%, rgb(219, 58.03, 58.03) 100%);
  background-clip: text;
  text-align: center;
  word-wrap: break-word;
  overflow: hidden;

  text-overflow: ellipsis;
  max-width: 100%;
  padding: 5px;
  
  font-family: 'Baloo Bhai', sans-serif;
  font-size: clamp(12px, 5vw, 28px); 
  font-weight: normal;
  line-height:32px;
}


 .bottomPart {
 
  align-items: center;
  overflow: hidden;
  max-width: 100%;
  width: auto;
  
}

 .NoOfFlashcards {
  -webkit-background-clip: text !important;
  -webkit-text-fill-color: transparent;
  background: linear-gradient(180deg, rgb(154, 40, 40) 0%, rgb(52, 13.51, 13.51) 100%);
  background-clip: text;
  text-align: center;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 100%;
  padding: 5px;
  
  font-family: 'Baloo Bhai 2', sans-serif;
  font-size: clamp(12px, 3vw, 22px); 
  font-weight: 400;
}
.flashing-button {
  display: flex;
  align-items: center;
  font-family: 'Baloo Bhai 2', sans-serif;
  font-size: 18px;
  justify-content: center;
  background-color: #9A2828;
  color: white;
  border: none;
  font-weight: bold;
  border-radius: 8px;
  padding: 8px 15px;
  cursor: pointer;
  gap: 8px;
  width: 100%; 
  max-width: fit-content;
  margin-top: auto; 
}

.flashing-button svg {
  width: 22px;
  height: 22px;
  align-self:center;
  fill: white;

}

.flashing-button:hover {
  background-color: #751F1F;
}
#secondPage .view-course-button {
  position: relative;
  width: fit-content;
  display: flex;
  align-items: center;
  font-family: 'Baloo Bhai 2', sans-serif;
  font-size: 18px;
  justify-content: center;
  background-color: #9A2828;
  color: white;
  border: none;
  font-weight: bold;
  border-radius: 8px;
  padding: 10px 15px;
  cursor: pointer;
  white-space: nowrap;
  margin-top: auto;
  justify-self: center;
}

#secondPage .view-course-button:hover {
  background-color: #751F1F;
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


   
  <div class="container-fluid add-flashcard1">
      
        <div class="mainPage">


        <div id="firstPage" style="width:100%" class="row">

            <main  class="col-12 col-lg-12 py-5 ">

              <div class="mb-5">
              <h1 class="keep-flashin-smart-add-a-card">Keep Flashin’ Smart – Add a Card!</h1>

                  <h2 class="choose-a-course-first">Choose a class first!</h2>
                  </div>

                <div id="courseContainer" class="row g-4 mb-5 justify-content-center">

                  <p class="text-muted">Loading courses…</p>
                </div>

                <div class="d-flex justify-content-center mt-4">
                  <button id="loadMoreBtn" class="btn btn-primary">
                    Load More
                  </button>
                </div>
                </main>
               </div>

           






<div  id="secondPage" style= "display:none;width:100%">
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
<h2 class="submit-your-sentense">Choose A group</h2>
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

          <h2 class="NoOfGroups">  </h2>

           
        
</div>


<div class="groupCardsContainer"  >
<div class="groupSection">
        <p>no Groups</p>
    </div>
              
                       
                 <div id="moving" class="next_-previous_-section">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="#B5B5B5" class="size-6 previous-vector">
        <path d="M9.195 18.44c1.25.714 2.805-.189 2.805-1.629v-2.34l6.945 3.968c1.25.715 2.805-.188 2.805-1.628V8.69c0-1.44-1.555-2.343-2.805-1.628L12 11.029v-2.34c0-1.44-1.555-2.343-2.805-1.628l-7.108 4.061c-1.26.72-1.26 2.536 0 3.256l7.108 4.061Z" />
    </svg>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="#B5B5B5" class="size-6 next-vector">
        <path d="M5.055 7.06C3.805 6.347 2.25 7.25 2.25 8.69v8.122c0 1.44 1.555 2.343 2.805 1.628L12 14.471v2.34c0 1.44 1.555 2.343 2.805 1.628l7.108-4.061c1.26-.72 1.26-2.536 0-3.256l-7.108-4.061C13.555 6.346 12 7.249 12 8.689v2.34L5.055 7.061Z" />
    </svg>
</div> 
              
                 </div>

               




                 <div style= "display: none;" id="fillCard" class="flip-container">
                         <div class="flipper" id="flipper">
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

       
  </body>
</html>
