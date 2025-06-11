<?php session_start();
include "db.php";
?>






    <!-- <a href="../controllers/logout.php">
    <button>Logout</button></a> -->

    <?php 
  include "../partials/header.php";
  ?><?php
  include_once "../partials/header.php";
  ?>
  
  <link rel="stylesheet" type="text/css" href="../template/css/groups.css" />
  
  <title>Groups </title>
  <script>
  
  document.addEventListener("DOMContentLoaded", function () {
      const urlParams = new URLSearchParams(window.location.search);
      const course_id = urlParams.get("course_id");
  
      if (!course_id) {
          document.getElementById("mainPageItems").innerHTML = "<p class='error-message'>No course selected.</p>";
          return;
      }
  
      fetch(`../controllers/groupsOfCourse.php?course_id=${course_id}`)
          .then(response => response.json())
          .then(data => {
              if (data.error) {
                let mainPageItems=  document.getElementById("mainPageItems");
                    mainPageItems.innerHTML = `<p class="error-message">${data.error}</p>`;
                  return;
              }
  
              // Update course info
              document.querySelector(".courseName").textContent = data.course.course_name;
              document.querySelector(".profName").textContent = `Dr. ${data.course.firstName} ${data.course.lastName}`;
              document.querySelector(".NoOfGroups").textContent = `${data.groups.length} Groups`;
  
              // Add course image
              document.querySelector(".coursePic").innerHTML = `<img src="../template/imgCourses/${data.course.image_path}" alt="${data.course.course_name}" class="course-image" />`;
  
              let groupSection = document.querySelector(".groupSection");
              groupSection.innerHTML = "";
  
              data.groups.forEach(group => {
                  groupSection.innerHTML += `
                      <div class="cardContainer">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 22 22" stroke-width="1.5" stroke="black" class="size-6 faviorateIcon ">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                  </svg>
                          <div class="cardItems">
                            
                                  <h2 class="groupName">${group.group_name}</h2>
                              
  
                                <div class="bottomPart">
                                    <h3 class="NoOfFlashcards">${group.flashcard_count} Flashcards</h3>
                                    <button class="flashing-button">
                                        <span>Flashing</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                            <path fill-rule="evenodd" d="M14.615 1.595a.75.75 0 0 1 .359.852L12.982 9.75h7.268a.75.75 0 0 1 .548 1.262l-10.5 11.25a.75.75 0 0 1-1.272-.71l1.992-7.302H3.75a.75.75 0 0 1-.548-1.262l10.5-11.25a.75.75 0 0 1 .913-.143Z" clip-rule="evenodd" />
                                         </svg>
                                    </button>
                                </div>
  
                          </div>
                      </div>`;
              });
  
              // Define course_id for pagination
              window.course_id = course_id;
          })
          .catch(error => console.error("Error loading groups:", error));
  });
  
  // Pagination for more groups
  let offset = 4;
  
  document.getElementById("viewMoreGroups").addEventListener("click", function () {
      fetch(`../controllers/groupsOfCourse.php?course_id=${window.course_id}&offset=${offset}`)
          .then(response => response.json())
          .then(data => {
              if (data.groups.length === 0) {
                  this.style.display = "none"; // Hide button if no more groups
                  return;
              }
  
              let groupSection = document.querySelector(".groupSection");
              if (data.groups.length === 0) {
                groupSection.innerHTML = '<p class="error-message"> No courses found.</span>';
                  return;
              }
  
              data.groups.forEach(group => {
                  groupSection.innerHTML += `
                      <div class="cardContainer">
                                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 22 22" stroke-width="1.5" stroke="black" class="size-6 faviorateIcon ">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                  </svg>
                          <div class="cardItems">
                              <div class="name-number-ofGroup">
                                  <div class="groupName">${group.group_name}</div>
                              </div>
  
                              <div class="slider">
                               <div class="NoOfFlashcards">${group.flashcard_count} Flashcards</div>
                               <button class="flashing-button">Flashing</button>
                              </div>
                             
                          </div>
                      </div>`;
              });
  
              offset += 4;
          })
          .catch(error => console.error("Error loading more groups:", error));
  });
  </script>
  
  
  
  <?php
  include_once "../partials/navigation.php";
  ?>
      
        <div class="groups screen">
          
        
          <div class="flex-col-1">
  
            <div class="overlap-group3">
              <div class="overlap-group1">
                <img class="group-34" src="../template/imgGroups/ring@2x.png" alt="Group 34" />
                <img class="ellipse-5" src="../template/imgGroups/ellipse-5.svg" alt="Ellipse 5" />
                <div class="ellipse-4"></div>
                <div class="number">1</div>
              </div>
              <div class="profile-picture">
                <img class="mask-group" src="../template/imgGroups/mask-group@2x.png" alt="Mask Group" />
                <div class="group-38"><img class="group" src="../template/imgGroups/group@2x.png" alt="Group" /></div>
              </div>
            </div>
  
  
            <div class="titelContainer">
              <img class="arrowBack" src="../template/imgGroups/group-85@2x.png" alt="Group 85" />
              <h1 class="title">Groups</h1>
            </div>
  
  
  
  
              <div class="mainPageItems">
  
  
                        <div class="CourseContainer">
  
                                    <div class="coursePic">
                                      
                                  </div>
  
                                    <div class="courseNameContainer">
                                      <h1 class="courseName"></h1>
                                    </div>
  
  
                                    <div class="profSection">
                                          <img class="profIcon" src="../template/imgGroups/professorIcon.svg" alt="Professor Vector"/>                                                               
                                          <h2 class="profName"></h2>
                                    </div>
  
  
                                    
                                   
                                      <h2 class="NoOfGroups"></h2>
  
  
  
                                      <button id="viewMoreGroups" class="view-course-button">
                                            <span>Display others</span>
                                       </button>
                                    
  
                                   
                        </div>
  
  
  
                <div class="groupSection">
                  
                <p>no Groups </p>
                        <!-- <div class="cardContainer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 22 22" stroke-width="1.5" stroke="currentColor" class="size-6 faviorateIcon ">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                  </svg>
                                  
                            <div class="cardItems">
                                  
  
                             
                                <div class="name-number-ofGroup">
                                  <h2 class="groupName ">Introduction</h2>
                                  <h3 class="NoOfFlashcards">20 Flashcards</h3>
                                </div>
                                
                                <button class="flashing-button">
                                      <span>Flashing</span>
                                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                            <path fill-rule="evenodd" d="M14.615 1.595a.75.75 0 0 1 .359.852L12.982 9.75h7.268a.75.75 0 0 1 .548 1.262l-10.5 11.25a.75.75 0 0 1-1.272-.71l1.992-7.302H3.75a.75.75 0 0 1-.548-1.262l10.5-11.25a.75.75 0 0 1 .913-.143Z" clip-rule="evenodd" />
                                       </svg>
                                </button>
                                
                            </div>
                        </div> -->
  
                 </div>
  
  
  
              </div>
              <div class="group-94"><img class="vector-9" src="../template/imgGroups/vector-13.svg" alt="Vector" /></div>
            
          </div>
        </div>
      </div>
    </body>
  </html>
  <!-- this is view/groupsOfCourses.php -->
   <link rel="stylesheet" type="text/css" href="../template/css/student-dashboard.css" />

      <div class="container-center-horizontal">
        <div class="student-dashboard screen">

    <?php 
    include "../partials/navigation.php";
    ?>
        
        <div class="left-container flex">
          <div class="welcomeFrame">
            <div class="rectangle-welcomeFrame"></div>
              <div class="greet-sentence">

                <h1 class="title">Hello <?php echo $_SESSION['firstName']."!"; ?></h1>
                <p class="ready-to-flash-your-courses b1">Ready to Flash your courses?</p>
              </div>

                  <img class="illustration" src="../template/img/illustration.svg" alt="Illustration" />
                  <img class="iconAnas" src="../template/img/icon-1.svg" alt="Icon" />
               </div>





               
 


          <div class="courses-section">
            <div class="titels">
              <h1 class="courses">Courses</h1>
              <div class="options flex">
                <a><h2 class="all-courses-option">All Courses</h2></a>
                <a><h2 class="the-recent-option">The Recent</h2></a>
              </div>
            </div>

            <div class="course1">
              <img class="course-pic" src="../template/img/rectangle-12.svg" alt="CoursePic" />
              <div class="course-name-1 course-name-3">
                <div class="ai baloobhai-regular-normal-black-16px">AI</div>
                <div class="dr-abdurahman-fakki caption">Dr. Abdurahman fakki</div>
              </div>
              <div class="houres-1 houres-3">
                <img class="vector" src="../template/img/vector-1.svg" alt="Vector" />
                <div class="x6h-30min caption">6h 30min</div>
              </div>
              <div class="fire">
                <img class="vector-1" src="../template/img/vector.svg" alt="Vector" />
                <div class="text caption">4,9</div>
              </div>
              <div class="overlap-group"><div class="view-course button">View course</div></div>
            </div>
            <div class="course">
              <img class="rectangle-12" src="../template/img/rectangle-12.svg" alt="Rectangle 12" />
              <div class="course-name-2 course-name-3">
                <div class="computer baloobhai-regular-normal-black-16px">Computer organization</div>
                <div class="dr-ahmed-shamsan-saleh caption">Dr. Ahmed Shamsan Saleh</div>
              </div>
              <div class="houres-2 houres-3">
                <img class="vector" src="../template/img/vector-1.svg" alt="Vector" />
                <div class="x6h-30min caption">6h 30min</div>
              </div>
              <div class="fire">
                <img class="vector-1" src="../template/img/vector.svg" alt="Vector" />
                <div class="text caption">4,9</div>
              </div>
              <div class="overlap-group"><div class="view-course button">View course</div></div>
            </div>
            <div class="course">
              <img class="rectangle-12-4" src="../template/img/rectangle-12.svg" alt="Rectangle 12" />
              <div class="course-name">
                <div class="computer baloobhai-regular-normal-black-16px">Computer networking</div>
                <div class="dr-adel-alharbi caption">Dr. Adel Alharbi</div>
              </div>
              <div class="houres">
                <img class="vector" src="../template/img/vector-1.svg" alt="Vector" />
                <div class="x6h-30min caption">6h 30min</div>
              </div>
              <div class="fire">
                <img class="vector-1" src="../template/img/vector.svg" alt="Vector" />
                <div class="text caption">4,9</div>
              </div>
              <div class="overlap-group"><div class="view-course button">View course</div></div>
            </div>
            <div class="course4">
              <img class="rectangle-12-4" src="../template/img/rectangle-12.svg" alt="Rectangle 12" />
              <div class="course-name">
                <div class="interaction-design baloobhai-regular-normal-black-16px">Interaction Design</div>
                <div class="dr-omer-asiri caption">Dr. Omer Asiri</div>
              </div>
              <div class="houres">
                <img class="vector" src="../template/img/vector-1.svg" alt="Vector" />
                <div class="x6h-30min caption">6h 30min</div>
              </div>
              <div class="fire">
                <img class="vector-1" src="../template/img/vector.svg" alt="Vector" />
                <div class="text caption">4,9</div>
              </div>
              <div class="overlap-group"><div class="view-course button">View course</div></div>
            </div>
            <div class="course5">
              <img class="rectangle-12-4" src="../template/img/rectangle-12.svg" alt="Rectangle 12" />
              <div class="course-name">
                <div class="visual-programming baloobhai-regular-normal-black-16px">Visual Programming</div>
                <div class="dr-waseem-masoudi caption">Dr. Waseem masoudi</div>
              </div>
              <div class="houres">
                <img class="vector" src="../template/img/vector-1.svg" alt="Vector" />
                <div class="x6h-30min caption">6h 30min</div>
              </div>
              <div class="fire">
                <img class="vector-1" src="../template/img/vector.svg" alt="Vector" />
                <div class="text caption">4,9</div>
              </div>
              <div class="overlap-group"><div class="view-course button">View course</div></div>
            </div>
          </div>
        </div>




        
        <div class="flex-col-1">
          <div class="flex-row-1">
            <div class="overlap-group11">
              <img class="ring" src="../template/img/ring@2x.png" alt="ring" />
              <div class="overlap-group-1">
                <div class="ellipse-4"></div>
                <div class="number">1</div>
              </div>
            </div>
            <img class="profile-picture" src="../template/img/profile-picture@2x.png" alt="Profile picture" />
          </div>
          <div class="overlap-group10">
            <div class="rectangle-33"></div>
            <img class="icon-1" src="../template/img/icon.svg" alt="Icon" />
            <p class="flash-ut-leader-keep-it-up">FlashUT Leader! Keep it up!</p>
          </div>
          <div class="stat-container">
            <div class="your-statistics-section">
              <div class="your-statistics">Your statistics</div>
              <div class="flex-row-2">
                <div class="learning-hours">Learning Hours</div>
                <div class="flashcards-added flashcards baloobhai-regular-normal-black-16px">Flashcards Added</div>
                <div class="flashcards-viewed flashcards baloobhai-regular-normal-black-16px">Flashcards Viewed</div>
              </div>
              <div class="line caption">
                <div class="overlap-group9">
                  <div class="overlap-group8">
                    <div class="number-1">0</div>
                    <div class="number-2">1</div>
                    <img
                      class="divider-graph-horizontal"
                      src="../template/img/divider---graph---horizontal.svg"
                      alt="divider / graph / horizontal"
                    />
                    <img
                      class="divider-graph-horizontal-1 divider-graph-horizontal-6"
                      src="../template/img/divider---graph---horizontal-1.svg"
                      alt="divider / graph / horizontal"
                    />
                    <img
                      class="divider-graph-horizontal-2 divider-graph-horizontal-6"
                      src="../template/img/divider---graph---horizontal-2.svg"
                      alt="divider / graph / horizontal"
                    />
                    <img
                      class="divider-graph-horizontal-3 divider-graph-horizontal-6"
                      src="../template/img/divider---graph---horizontal-3.svg"
                      alt="divider / graph / horizontal"
                    />
                    <img
                      class="divider-graph-horizontal-4 divider-graph-horizontal-6"
                      src="../template/img/divider---graph---horizontal-4.svg"
                      alt="divider / graph / horizontal"
                    />
                    <img
                      class="divider-graph-horizontal-5 divider-graph-horizontal-6"
                      src="../template/img/divider---graph---horizontal-5.svg"
                      alt="divider / graph / horizontal"
                    />
                    <div class="overlap-group1">
                      <img class="circle_pointer-4" src="../template/img/circle-pointer-4.svg" alt="circle_pointer 4" />
                      <div class="overlap-group-2">
                        <img class="sheet" src="../template/img/sheet-1.svg" alt="sheet" />
                        <div class="pointer-value valign-text-middle baloobhai-regular-normal-black-14px">2h</div>
                      </div>
                    </div>
                    <div class="overlap-group2">
                      <img class="circle_pointer-4" src="../template/img/circle-pointer-4-1.svg" alt="circle_pointer 4" />
                      <div class="overlap-group-3">
                        <img class="sheet" src="../template/img/sheet-3.svg" alt="sheet" />
                        <div class="pointer-value valign-text-middle baloobhai-regular-normal-black-14px">3h</div>
                      </div>
                    </div>
                    <div class="overlap-group3">
                      <img class="circle_pointer-4" src="../template/img/circle-pointer-4-2.svg" alt="circle_pointer 4" />
                      <div class="overlap-group-4">
                        <img class="sheet" src="../template/img/sheet-5.svg" alt="sheet" />
                        <div class="pointer-value valign-text-middle baloobhai-regular-normal-black-14px">4h</div>
                      </div>
                    </div>
                    <div class="overlap-group4">
                      <img class="circle_pointer-4" src="../template/img/circle-pointer-4-3.svg" alt="circle_pointer 4" />
                      <div class="overlap-group-5">
                        <img class="sheet" src="../template/img/sheet-7.svg" alt="sheet" />
                        <div class="pointer-value valign-text-middle baloobhai-regular-normal-black-14px">1h</div>
                      </div>
                    </div>
                    <div class="overlap-group5">
                      <img class="circle_pointer-4" src="../template/img/circle-pointer-4-4.svg" alt="circle_pointer 4" />
                      <div class="overlap-group-6">
                        <img class="sheet" src="../template/img/sheet-9.svg" alt="sheet" />
                        <div class="pointer-value-1 valign-text-middle baloobhai-regular-normal-black-14px">2,5h</div>
                      </div>
                    </div>
                    <div class="overlap-group6">
                      <img class="circle_pointer-4" src="../template/img/circle-pointer-4-5.svg" alt="circle_pointer 4" />
                      <div class="overlap-group-7">
                        <img class="sheet" src="../template/img/sheet-11.svg" alt="sheet" />
                        <div class="pointer-value valign-text-middle baloobhai-regular-normal-black-14px">1,5h</div>
                      </div>
                    </div>
                    <div class="overlap-group7">
                      <img class="circle_pointer-4" src="../template/img/circle-pointer-4-6.svg" alt="circle_pointer 4" />
                      <div class="overlap-group-8">
                        <img class="sheet" src="../template/img/sheet-13.svg" alt="sheet" />
                        <div class="pointer-value valign-text-middle baloobhai-regular-normal-black-14px">0h</div>
                      </div>
                    </div>
                    <img class="graph" src="../template/img/graph.svg" alt="graph" />
                  </div>
                  <div class="number-3">2</div>
                  <div class="number-4">3</div>
                  <div class="number-5">4</div>
                  <div class="number-6">5</div>
                </div>
                <div class="flex-row-3">
                  <div class="mon">mon</div>
                  <div class="tue">tue</div>
                  <div class="wed">wed</div>
                  <div class="flex-row-item">thu</div>
                  <div class="fri">fri</div>
                  <div class="flex-row-item">sat</div>
                  <div class="place">sun</div>
                </div>
              </div>
            </div>
            <div class="stats-boxes">
              <div class="overlap-group-9">
                <div class="rectangle-33-1"></div>
                <div class="value">
                  <div class="number-7 baloobhai-regular-normal-ripe-plum-64px">6</div>
                  <div class="available-courses b1">
                    Available<br />
                    Courses
                  </div>
                </div>
              </div>
              <div class="stats-box-2">
                <div class="number-8 baloobhai-regular-normal-ripe-plum-64px">4</div>
                <div class="pending-flashcards b1">Pending<br />Flashcards...</div>
              </div>
            </div>
          </div>
          <img class="quick-add" src="../template/img/quick-add@2x.png" alt="quick add" />
        </div>
      </div>
    </div>
  </body>
</html>


<!-- <?php if (isset($_GET['message'])): ?> 
      <h2 style="color: green;">
            <?php echo htmlspecialchars($_GET['message']); ?>
            <?php echo $_SESSION['firstName']; ?>

       </h2>
    <?php endif; ?>  -->