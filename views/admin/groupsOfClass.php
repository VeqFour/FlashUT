<?php
include_once "../../partials/header.php";
include_once "../../partials/auth_admin.php"; 
include_once "../../partials/navigation.php";
?>

<link rel="stylesheet" type="text/css" href="../../template/css/groups.css" />

<title>Groups - FlashUT </title>




<script>
document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const section_id = urlParams.get("section_id");



    if (!section_id) {
        document.getElementById("mainPageItems").innerHTML = "<p class='error-message'>No course selected.</p>";
        return;
    }
    

    const prevBtn = document.querySelector(".previous-vector");
  const nextBtn = document.querySelector(".next-vector");

    fetch(`../../controllers/admin/groupsOfClass.php?section_id=${section_id}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById("mainPageItems").innerHTML = `<p class="error-message">${data.error}</p>`;
                return;
            }

            document.querySelector(".courseName").textContent = data.course.course_name;
            document.querySelector(".profName").textContent = `Dr. ${data.course.firstName} ${data.course.lastName}`;
            document.querySelector(".NoOfGroups").textContent = `${data.total} Groups`;
            document.querySelector(".coursePic").innerHTML = `<img src="../../template/imgCourses/${data.course.image_path}" alt="${data.course.course_name}" class="course-image" />`;

          })
        
          let currentPage = 1; 
          let totalPages = 1; 
            function loadGroups(page) {
              fetch(`../../controllers/admin/groupsOfClass.php?page=${page}&section_id=${section_id}`)
              .then(response => response.json())
              .then(data => {
                let groupSection = document.querySelector(".groupSection");
                let displayOthers = document.getElementById("displayOthers");
                totalPages =data.totalPages
                groupSection.innerHTML = "";

                if (data.error) {
                  groupSection.innerHTML =`<p class="error-message">${data.error}</p>`;
                  return;
                }

                if (totalPages === 0) {
                  groupSection.innerHTML = "<p>No Groups found.</p>";
                return;
            }


                data.groups.forEach(group => {

                  let groupHTML = `
                    <div class="cardContainer">
                        
                        <div class="cardItems">
                            <h2 class="groupName">${group.group_name}</h2>
                            <div class="bottomPart">
                                <h3 class="NoOfFlashcards">${group.flashcard_count} Flashcards</h3>
                        <a href="flashcard.php?group_name=${group.group_name}&group_id=${group.group_id}&section_id=${section_id}">
                                <button class="flashing-button" >
                                    Flashing
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-6">
                                        <path fill-rule="evenodd" d="M14.615 1.595a.75.75 0 0 1 .359.852L12.982 9.75h7.268a.75.75 0 0 1 .548 1.262l-10.5 11.25a.75.75 0 0 1-1.272-.71l1.992-7.302H3.75a.75.75 0 0 1-.548-1.262l10.5-11.25a.75.75 0 0 1 .913-.143Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                </a>
                            </div>
                        </div>
                    </div>`;
                    groupSection.innerHTML += groupHTML;
  

            });


            prevBtn.style.opacity = (currentPage > 1 ? "1" : "0.3");
            nextBtn.style.opacity = (currentPage < totalPages ? "1" : "0.3");


            
        })
        .catch(error => console.error("Error loading groups:", error));
    }

  
    
    prevBtn.addEventListener("click", () => {
    if (currentPage > 1) {
      currentPage--;
      loadGroups(currentPage);
    }
  });

  nextBtn.addEventListener("click", () => {
    if (currentPage < totalPages) {
      currentPage++;
      loadGroups(currentPage);
    }
  });   
  
  
  loadGroups(currentPage);

    
});



</script>




      <div class="groups screen">
        
      
        <div class="flex-col-1">

         

          <div class="titelContainer">
          <a href="javascript:history.back()" class="back-arrow-link">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="#9A2828" stroke="#9A2828" stroke-width="1.1"  class="size-6">
                   <path fill-rule="evenodd" d="M11.03 3.97a.75.75 0 0 1 0 1.06l-6.22 6.22H21a.75.75 0 0 1 0 1.5H4.81l6.22 6.22a.75.75 0 1 1-1.06 1.06l-7.5-7.5a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                  </svg>
                  <h1 class="titel-content">Groups</h1>

            </a>
          </div>




            <div class="mainPageItems" id="mainPageItems">


                      <div class="CourseContainer">

                                 
                         <div class="coursePic-wrapper">
                                        <div class="coursePic">
                                        </div>
                                    </div> 
                                    

                                  <div class="courseNameContainer">
                                    <h1 class="courseName">  </h1>
                                  </div>


                                  <div class="profSection">
                                        <img class="profIcon" src="../../template/imgGroups/professorIcon.svg" alt="Professor Vector"/>                                                               
                                        <h2 class="profName">  </h2>
                                  </div>


                                  
                                 
                                    <h2 class="NoOfGroups">  </h2>




                                  

                                 
                      </div>



                      <div> 
              <div class="groupSection">
                
              <p>no Groups </p>
                      

               </div>

              <div class="next_-previous_-section">
                   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="#B5B5B5" class="size-6 previous-vector">
                         <path d="M9.195 18.44c1.25.714 2.805-.189 2.805-1.629v-2.34l6.945 3.968c1.25.715 2.805-.188 2.805-1.628V8.69c0-1.44-1.555-2.343-2.805-1.628L12 11.029v-2.34c0-1.44-1.555-2.343-2.805-1.628l-7.108 4.061c-1.26.72-1.26 2.536 0 3.256l7.108 4.061Z" />
                   </svg>
                                    
                         


                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="#B5B5B5" class="size-6 next-vector">
                        <path d="M5.055 7.06C3.805 6.347 2.25 7.25 2.25 8.69v8.122c0 1.44 1.555 2.343 2.805 1.628L12 14.471v2.34c0 1.44 1.555 2.343 2.805 1.628l7.108-4.061c1.26-.72 1.26-2.536 0-3.256l-7.108-4.061C13.555 6.346 12 7.249 12 8.689v2.34L5.055 7.061Z" />
                  </svg>

              </div>
               



            </div>


            </div>
          
        </div>
      </div>
    </div>
  </body>
  </head>
</html>
