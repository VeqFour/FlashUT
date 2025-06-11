
<?php
include_once "../../partials/header.php";
include_once "../../partials/auth_admin.php"; 
include_once "../../partials/navigation.php";
?>

<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
    <link rel="stylesheet" type="text/css" href="../../template/css/add-flashcard1.css" />
    <link rel="stylesheet" type="text/css" href="../../template/css/manage.css" />


    <!-- <link rel="stylesheet" type="text/css" href="../template/css/courses.css" /> -->

    <title>Manage - FlashUT</title>


    <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    defer
  ></script>
    <script>
document.addEventListener("DOMContentLoaded", function () {
  // ─────────────────────────────────────────────────────────────────────────────
  // Global State
  // ─────────────────────────────────────────────────────────────────────────────
  let currentPage = 1, totalPages = 1;
  let currentPageG = 1, totalPagesG = 1;
  let currentPageR = 1, totalPagesR = 1;
  let currentPageS = 1, totalPagesS = 1; 


  let selectedSectionId = null;
  let reviewSectionId = null;
  let flashcards = [], currentIndex = 0;
  let reviewFlashcardId = null;

  const displayOthers = document.getElementById("displayOtherGroups");
  const displayOthersReview = document.getElementById("displayOthersReview");
  const displayOtherschoose = document.getElementById("displayOtherschoose");

  const loadMoreBtn = document.getElementById("loadMoreBtn");

  const coursePic = document.querySelector(".course-pic");
  const groupTitleEl = document.querySelector(".group-titel");
  const flashcardTotalNoEl = document.querySelector(".flashcard-total-no");
  const flashcardNoEl = document.querySelector(".flashcard-total-No");
  const questionEl = document.querySelector("#QA-section .question");
  const answerEl = document.querySelector("#AQ-section .answer");
  const reviewQuestionFront = document.querySelector(".question.review");
  const reviewAnswerBack = document.querySelector(".answer.review");
  const flashcardClick = document.querySelector(".flip-container");
  const trashFlashcardBtn = document.querySelector(".trashIcon2");
  const nextBtn = document.querySelector(".next-vector");
  const prevBtn = document.querySelector(".previous-vector");

  const nextG = document.getElementById("nextG");
  const prevG = document.getElementById("prevG");
  
  const approveReviewBtn = document.getElementById("approve");
  const rejectReviewBtn = document.getElementById("reject");


  const groupCardsContainer = document.getElementById("groupCardsContainer");


  const displayMode = document.getElementById("displayMode");


  // ─────────────────────────────────────────────────────────────────────────────
  // Load Courses
  // ─────────────────────────────────────────────────────────────────────────────
  function loadCourses(page) {
    fetch(`../../controllers/admin/adminClasses.php?page=${page}`)
      .then(res => res.json())
      .then(data => {
        const courseContainer = document.querySelector(".displayCourses");
        courseContainer.innerHTML = "";

        if (data.error) {
          courseContainer.innerHTML = `<p class="error-message">${data.error} 😞</p>`;
          return;
        }

        data.courses.forEach(course => {
          courseContainer.innerHTML += `
          <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100 border-0">

              <div class="coursePic-wrapper mb-3 ">
                <div class="coursePic">
                  <img
                    src="../../template/imgCourses/${course.image_path}"
                    alt="${course.course_name}"
                    style="width:100%; height:auto; display:block; cursor:pointer;"
                  />
                 </div>
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

                 
               
                 <div class="mt-4 w-80">
                    <button class="view-course button choose-btn"
                        data-id="${course.section_id}"
                        data-name="${course.course_name}"
                        data-firstname="${course.firstName}"
                        data-lastname="${course.lastName}"
                        data-image="${course.image_path}">
                  Manage
                </button>
                </div>
              </div>
            </div>
          </div>

`;
        });

        totalPages = data.totalPages;
        loadMoreBtn.style.display = totalPages > 1 ? "block" : "none";
        loadMoreBtn.textContent = currentPage < totalPages ? "Next Courses" : "Previous Courses";

        document.querySelectorAll('.coursePic').forEach(picBtn => {
        picBtn.addEventListener('click', function() {
            const btn = this.closest('.card').querySelector('.view-course');
            if (btn) btn.click();
        });
});
        
      })
      .catch(err => console.error("Error loading courses:", err));
  }

  // ─────────────────────────────────────────────────────────────────────────────
  // Load Course Info
  // ─────────────────────────────────────────────────────────────────────────────
  function loadCourseInfo(course) {
    const container = document.getElementById("CourseContainerGroups");
    container.querySelector(".courseName").textContent = course.course_name;
    container.querySelector(".profName").textContent = `Dr. ${course.firstName} ${course.lastName}`;
    container.querySelector(".coursePic").innerHTML = `<img src="../../template/imgCourses/${course.image_path}" alt="${course.course_name}" class="course-image" />`;
  }

  // ─────────────────────────────────────────────────────────────────────────────
  // Load Groups
  // ─────────────────────────────────────────────────────────────────────────────

//   const prevBtn = document.querySelector(".previous-vector");
// const nextBtn = document.querySelector(".next-vector");
  function loadGroups(page) {
    if (!selectedSectionId) return;

    fetch(`../../controllers/admin/groupsOfClass.php?page=${page}&section_id=${selectedSectionId}&source=manage`)     
     .then(res => res.json())
      .then(data => {
        let groupSection = document.getElementById("groupsSection");
                let groupCardsContainer = document.querySelector(".groupCardsContainer"); 
                groupSection.innerHTML = "";

        if (data.error) {
          groupSection.innerHTML = `<p class="error-message">${data.error}</p>`;
          return;
        }

        if (data.totalPages === 0) {
          groupSection.innerHTML = "<p>No Groups found.</p>";
          document.getElementById("movingGroups").style.display="none";

          return;
        }
        document.querySelector(".NoOfGroups").textContent = `${data.total} Groups`;

        totalPagesG = data.totalPages;

        data.groups.forEach(group => {
          groupSection.innerHTML += `
            <div class="cardContainer">
                  <svg xmlns="http://www.w3.org/2000/svg" data-group-id="${group.group_id}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="black" class="size-6 trashIcon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                  </svg>
                  <svg xmlns="http://www.w3.org/2000/svg" data-group-id="${group.group_id}" data-name="${group.group_name}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="black" class="size-6 editIcon">
                         <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                  </svg>

                   <div class="cardItems">
                         <h2 class="groupName">${group.group_name}</h2>
                         <div class="bottomPart">
                              <h3 class="NoOfFlashcards">${group.flashcard_count} Flashcards</h3>
                              <button class="display-button" data-id="${group.group_id}" data-name="${group.group_name}">Display
                                   
                              </button>
                         </div>
                    </div>
            </div>`;
        });

        prevG.style.opacity = (currentPageG > 1 ? "1" : "0.3");
        nextG.style.opacity = (currentPageG < totalPagesG ? "1" : "0.3");

              groupSection.innerHTML += `
       <div class="cardContainer addGroupStaticCard">
             <div class="cardItems" style="justify-content: center; height: auto;">
                   <h2 class="groupName" id="addGroupTitle">Add New Group</h2>

             <input type="text" id="newGroupName" placeholder="Enter group name"
                  class="edit-input" style="width: 80%; padding: 5px; display: none;" />

                  <button id="addGroupBtn">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="pink" viewBox="0 0 24 24" stroke-width="1.5" stroke="red" class="size-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                  </button>
            </div>
      </div>`;
     
        bindGroupActions();

        // displayOthers.style.display = totalPagesG > 1 ? "block" : "none";
        // displayOthers.textContent = currentPageG < totalPagesG ? "Next groups" : "Previous groups";
      })
      .catch(err => console.error("Error loading groups:", err));
  }

  prevG.addEventListener("click", () => {
    if (currentPageG > 1) {
      currentPageG--;
      loadGroups(currentPageG);
    }
  });

  nextG.addEventListener("click", () => {
    if (currentPageG < totalPagesG) {
      currentPageG++;
      loadGroups(currentPageG);
    }
  });

  // ─────────────────────────────────────────────────────────────────────────────
  // Group Edit/Delete/Add Actions
  // ─────────────────────────────────────────────────────────────────────────────
  function bindEditIcon(icon) {
  icon.onclick = () => {
    const container = icon.closest(".cardContainer");
    const existingInput = container.querySelector(".edit-input");

    // 🔁 If input is already shown, cancel edit
    if (existingInput) {
      const originalName = icon.dataset.name || existingInput.defaultValue;
      const cancelH2 = document.createElement("h2");
      cancelH2.className = "groupName";
      cancelH2.textContent = originalName;
      existingInput.replaceWith(cancelH2);
      return;
    }

    const groupNameElem = container.querySelector(".groupName");
    const originalName = groupNameElem.textContent;

    const input = document.createElement("input");
    input.className = "edit-input";
    input.value = originalName;
    input.defaultValue = originalName; 
    groupNameElem.replaceWith(input);
    input.focus();

    input.addEventListener("keydown", e => {
      if (e.key === "Enter") {
        const newName = input.value.trim();
        if (!newName) return alert("Name cannot be empty.");

        fetch("../../controllers/admin/manage.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            action: "edit_group",
            group_id: icon.dataset.groupId,
            section_id: selectedSectionId,
            new_name: newName
          })
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            const newH2 = document.createElement("h2");
            newH2.className = "groupName";
            newH2.textContent = newName;
            input.replaceWith(newH2);
            icon.dataset.name = newName;
          } else {
            alert("Failed to update name.");
          }
        });
      } else if (e.key === "Escape") {
        const cancelH2 = document.createElement("h2");
        cancelH2.className = "groupName";
        cancelH2.textContent = originalName;
        input.replaceWith(cancelH2);
      }
    });
  };
}

function bindGroupActions() {
  document.querySelectorAll(".trashIcon").forEach(icon => {
    icon.onclick = () => {
      const groupId = icon.dataset.groupId;
      if (!confirm("Are you sure you want to delete this group?")) return;

      fetch("../../controllers/admin/manage.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action: "delete_group", group_id: groupId, section_id: selectedSectionId })
      })
        .then(res => res.json())
        .then(data => {
          alert(data.success ? "Group deleted successfully." : "Failed to delete group.");
          if (data.success) loadGroups(currentPageG);
        });
    };
  });

  document.querySelectorAll(".editIcon").forEach(icon => {
    bindEditIcon(icon); 
  });
}

document.addEventListener("click", function (e) {
  const addBtn = e.target.closest("#addGroupBtn");

  if (addBtn) {
    const title = document.getElementById("addGroupTitle");
    const input = document.getElementById("newGroupName");

    if (input.style.display === "none") {
      title.style.display = "none";
      input.style.display = "block";
      addBtn.style.display = "none";
      input.focus();

      input.removeEventListener("keydown", handleAddGroup);
      input.addEventListener("keydown", handleAddGroup);
    }
  }

  function handleAddGroup(e) {
    const input = e.target;
    const title = document.getElementById("addGroupTitle");
    const addBtn = document.getElementById("addGroupBtn");

    if (e.key === "Enter") {
      const groupName = input.value.trim();
      if (!groupName) return alert("Group name cannot be empty.");

      fetch("../../controllers/admin/manage.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          action: "add_group",
          section_id: selectedSectionId,
          group_name: groupName
        }),
      })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            alert("Group added successfully!");
            input.removeEventListener("keydown", handleAddGroup);
            loadGroups(currentPageG);
          } else {
            alert(data.message || "Failed to add group.");
            input.focus();
          }
        })
        .catch(err => {
          console.error("Add group error:", err);
          alert("Error adding group.");
          input.focus();
        });
    } else if (e.key === "Escape") {
      input.style.display = "none";
      title.style.display = "block";
      addBtn.style.display = "flex";
      input.value = "";
      input.removeEventListener("keydown", handleAddGroup);
    }
  }
});
  // ─────────────────────────────────────────────────────────────────────────────
  // Flashcard Display & Navigation
  // ─────────────────────────────────────────────────────────────────────────────
  function updateCard() {
    const flashcard = flashcards[currentIndex];
    const note = document.querySelector(".created-by-admin");

    if (!flashcards.length) {
      questionEl.textContent = answerEl.textContent = "No flashcards yet In this group!";
      nextBtn.classList.add("no-hover");
      prevBtn.classList.add("no-hover");
      return;
    }

    questionEl.textContent = flashcard.question;
    answerEl.textContent = flashcard.answer;
    flashcardNoEl.textContent = `${currentIndex + 1} / ${flashcards.length}`;
    note.style.display = flashcard.role === "admin" ? "block" : "none";

    nextBtn.classList.toggle("no-hover", currentIndex === flashcards.length - 1);
    prevBtn.classList.toggle("no-hover", currentIndex === 0);
  }

  // ─────────────────────────────────────────────────────────────────────────────
  // Load Flashcards for a Group
  // ─────────────────────────────────────────────────────────────────────────────
  function loadFlashcards(groupId, groupName) {
    const flashcardSection = document.getElementById("flashcardSection");
    const groupCardsContainer = document.getElementById("groupCardsContainer");

    groupCardsContainer.style.display = "none";
    flashcardSection.style.display = "flex";
    document.querySelector(".NoOfGroups").style.display = "none";


    fetch(`../../controllers/flashcard.php?section_id=${selectedSectionId}&group_id=${groupId}&group_name=${groupName}`)
      .then(res => res.json())
      .then(data => {
        flashcards = data.flashcards;
        currentIndex = 0;


        flashcardTotalNoEl.textContent = `${flashcards.length} Flashcards`;
        groupTitleEl.textContent = data.group_name;
       

        updateCard();
      });
  }


  // ─────────────────────────────────────────────────────────────────────────────
  // Load Flashcards for Review
  // ─────────────────────────────────────────────────────────────────────────────

  function loadForReview(page) {
  fetch(`../../controllers/admin/review.php?page=${page}`)
    .then(res => res.json())
    .then(data => {
      console.log("💬 Review response:", data);
      const reviewSection = document.getElementById("reviewSection");
      document.getElementById("NoOfPending").textContent=data.totalPending;
      reviewSection.innerHTML = "";

      if (data.error || !data.reviews.length) {
        reviewSection.innerHTML = "<p>No flashcards found for review.</p>";
        return;
      }

      totalPagesR = data.totalPages;
      console.log("🧾 totalPagesR:", totalPagesR);

      data.reviews.forEach(review => {
        reviewSection.innerHTML += `
          <div class="cardContainer_review">
          <span>#${review.flashcard_id}</span>
            <div class="cardItems_review">


           <div class="sectionInfo">
              <h2 class="groupName_review">${review.course_name}</h2>
              <span class="sectionName">${review.section_name}</span>
            </div>

              <div class="bottomPart">
                <h3 style="margin-bottom:0;" class="NoOfFlashcards">${review.firstName} ${review.lastName}</h3>
               <span class="academic_ID">#${review.academicID}</span>
                             </div>

                <button id="reviewNow" class="display-button"
                  data-question="${review.question}"
                  data-answer="${review.answer}"
                  data-course="${review.course_name}"
                  data-flashcard-id="${review.flashcard_id}"
                  data-section-id="${review.section_id}">
                  Review Now!
                </button>
            </div>
          </div>`;
      });

      displayOthersReview.style.display = totalPagesR > 1 ? "block" : "none";
      displayOthersReview.textContent = currentPageR < totalPagesR ? "Next" : "Previous";
    })
    .catch(err => {
      console.error("Error loading review flashcards:", err);
    });
}


  // ─────────────────────────────────────────────────────────────────────────────
  // Load groups for Review
  // ─────────────────────────────────────────────────────────────────────────────


function loadGroupsForAssignment(page) {
  const groupSelect = document.getElementById("groupSelect");
  groupSelect.innerHTML = "Loading groups...";

  fetch(`../../controllers/admin/groupsOfClass.php?page=${page}&section_id=${reviewSectionId}&source=assign`)
    .then(res => res.json())
    .then(data => {
      if (data.error || !data.groups.length) {
        groupSelect.innerHTML = "<p>No groups found to assign this flashcard.</p>";
        return;
      }

      groupSelect.innerHTML = "";
      totalPagesS = data.totalPages;

      data.groups.forEach(group => {
        groupSelect.innerHTML += `
          <div class="cardContainer">
            <div class="cardItems">
              <h2 class="groupName">${group.group_name}</h2>
              <div class="bottomPart">
                <h3 class="NoOfFlashcards">${group.flashcard_count} Flashcards</h3>
                <button class="display-button assignGroup" data-id="${group.group_id}" data-name="${group.group_name}">Add here</button>
              </div>
            </div>
          </div>`;
      });

      displayOtherschoose.style.display = totalPagesS > 1 ? "block" : "none";
      displayOtherschoose.textContent = page < totalPagesS ? "Next groups" : "Previous groups";

      document.querySelectorAll(".assignGroup").forEach(btn => {
        btn.addEventListener("click", () => {
          const groupId = btn.dataset.id;
          const groupName = btn.dataset.name;


          const confirmed = confirm(`Are you sure you want to assign it to "${groupName}"?`);     
          if (!confirmed) return;
          fetch("../../controllers/admin/manage.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
              action: "approve_and_assign_flashcard",
              flashcard_id: reviewFlashcardId,
              group_id: groupId
            }),
          })
            .then(res => res.json())
            .then(data => {
              if (data.success) {
                alert("Flashcard approved and assigned successfully.");
                document.getElementById("chosenReview").style.display = "none";
                document.getElementById("reviewSection").style.display = "flex";
                reviewFlashcardId = null;
                loadForReview(currentPageR);
              } else {
                alert(data.message || "Failed to approve and assign flashcard.");
              }
            });
        });
      });
    })
    .catch(err => {
      console.error("Error loading groups:", err);
      groupSelect.innerHTML = "<p>Error loading groups.</p>";
    });
}

  // ─────────────────────────────────────────────────────────────────────────────
  // UI Events
  // ─────────────────────────────────────────────────────────────────────────────
  loadCourses(currentPage);
  loadForReview(currentPageG);

  loadMoreBtn.onclick = () => {
    currentPage = currentPage < totalPages ? currentPage + 1 : 1;
    loadCourses(currentPage);
  };

  // displayOthers.onclick = () => {
  //   currentPageG = currentPageG < totalPagesG ? currentPageG + 1 : 1;
  //   loadGroups(currentPageG);
  // };

  displayOthersReview.onclick = () => {
    currentPageR = currentPageR < totalPagesR ? currentPageR + 1 : 1;
    loadForReview(currentPageR);
  };

  document.addEventListener("click", function (e) {
    const target = e.target;

    if (target.closest("#manageBtn")) {
      document.getElementById("firstPage").style.display = "none";
      document.getElementById("manageClasses").style.display = "block";
    }

    if (target.closest("#reviewBtn")) {
      document.getElementById("firstPage").style.display = "none";
      document.getElementById("reviewFlashcards").style.display = "block";
      loadForReview(currentPageG);

    }

    if (target.classList.contains("choose-btn")) {
      selectedSectionId = target.dataset.id;
      document.getElementById("manageClasses").style.display = "none";
      document.getElementById("groupsPage").style.display = "flex";
      loadCourseInfo({
        section_id: selectedSectionId,
        course_name: target.dataset.name,
        firstName: target.dataset.firstname,
        lastName: target.dataset.lastname,
        image_path: target.dataset.image
      });
      loadGroups(currentPageG);
    }
    

    if (target.closest(".display-button")) {
      const btn = target.closest(".display-button");
      
      loadFlashcards(btn.dataset.id, btn.dataset.name);
    }
 

  if (target.id === "reviewNow") {
  document.getElementById("reviewSection").style.display = "none";
  reviewFlashcardId = target.dataset.flashcardId;
  reviewSectionId = target.dataset.sectionId;

    displayOthersReview.style.display="none";
  document.getElementById("flashcardSectionReview").style.display = "flex";    
  document.getElementById("reviewTitel").textContent = "Review it Carefully!";

  document.getElementById("courseReviewName").textContent = "Flashcard Preview";
  reviewQuestionFront.textContent = target.dataset.question;
reviewAnswerBack.textContent = target.dataset.answer;

}

approveReviewBtn.onclick = () => {
  if (!reviewFlashcardId || !reviewSectionId) return;

  const confirmed = confirm("Are you sure you want to approve and assign this flashcard?");
  if (!confirmed) return;

  document.getElementById("flashcardSectionReview").style.display = "none";
  document.getElementById("chosenReview").style.display = "flex";
  document.getElementById("reviewTitel").textContent = "Assign it to a group";


  loadGroupsForAssignment(currentPageS);
};

rejectReviewBtn.onclick = () => {
  if (!reviewFlashcardId || !reviewSectionId) return;

  const feedback = prompt("Please provide feedback for the rejection:");

  if (feedback === null || feedback.trim() === "") {
    alert("Feedback is required to reject the flashcard.");
    return;
  }

  fetch("../../controllers/admin/manage.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      action: "reject_flashcard",
      flashcard_id: reviewFlashcardId,
      feedback: feedback.trim()
    }),
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert("Flashcard rejected with feedback.");
        document.getElementById("flashcardSectionReview").style.display = "none";
        document.getElementById("reviewSection").style.display = "flex";
        reviewFlashcardId = null;
        loadForReview(currentPageR);
      } else {
        alert(data.message || "Failed to reject flashcard.");
      }
    });
};


displayOtherschoose.onclick = () => {
  currentPageS = currentPageS < totalPagesS ? currentPageS + 1 : 1;
  loadGroupsForAssignment(currentPageS);
};


});
  nextBtn.onclick = () => {
    if (currentIndex < flashcards.length - 1) {
      currentIndex++;
      updateCard();
      if (flashcardClick.classList.contains("flipped")) {
              
              flashcardClick.classList.toggle("flipped");
           
          } 
    }
  };

  prevBtn.onclick = () => {
    if (currentIndex > 0) {
      currentIndex--;
      updateCard();
      if (flashcardClick.classList.contains("flipped")) {
              
              flashcardClick.classList.toggle("flipped");
           
          } 
    }
  };

  flashcardClick.onclick = () => {
    flashcardClick.classList.toggle("flipped");
  };



  displayMode.onclick = () => {
    displayMode.classList.toggle("flipped");
  };


  trashFlashcardBtn.onclick = () => {

  const flashcardId = flashcards[currentIndex].flashcard_id;

  const confirmDelete = confirm("Are you sure you want to delete this flashcard?");
  if (!confirmDelete) return;

  fetch("../../controllers/admin/manage.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      action: "delete_flashcard",
      flashcard_id: flashcardId
    }),
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert("Flashcard deleted successfully.");

        flashcards.splice(currentIndex, 1);
        if (currentIndex > 0) currentIndex--;
        updateCard();
      } else {
        alert("Failed to delete flashcard.");
      }
    })
    .catch(err => {
      console.error("Error deleting flashcard:", err);
      alert("An error occurred.");
    });
};
});

</script>



   
      <div class="add-flashcard1 screen">
      
        <div class="mainPage">


        <div  id="firstPage" style="width: 100%; text-align: center; padding-top: 80px;">

              <h1 style="font-family: 'Baloo Bhai', sans-serif; font-size: 42px; -webkit-background-clip: text !important;
                  -webkit-text-fill-color: transparent;
                  background: linear-gradient(180deg, rgb(189.13, 53.58, 53.58) 75%, rgb(87.13, 24.68, 24.68) 100%);
                  background-clip: text;
                  color: transparent;
                  font-family: 'Baloo Bhai', sans-serif;
                  font-weight: 500;">
                  Admin Dashboard
              </h1>
              <h2 style="font-family: 'Baloo Bhai 2', sans-serif; font-size: 24px; color: #5f1717;
                  font-family: 'Baloo Bhai 2', sans-serif;
                  font-weight: 700; margin-top: 10px;">
                  Choose what you want to manage
              </h2>

              <div style="justify-content: center; display: flex; gap: 50px; margin-top: 60px; flex-wrap: wrap;" class="modeSection">

              <div style="height: 220px;" class="cardContainer optionCard" id="manageBtn">
                        <div class="cardItems" style="justify-content: center; height: auto; padding-top:0">
                          <svg xmlns="http://www.w3.org/2000/svg" class="optionIcon" viewBox="0 0 24 24">
                              <path fill="#9A2828" d="M12 2l9 4.5v11l-9 4.5-9-4.5v-11zM12 13l-8-4.5 8-4.5 8 4.5z" />
                          </svg>
                          <button class="choiceTitel" id="manageBtn">Manage My Classes</button>
                      </div>
                  </div>

                  <div style="height: 220px;" class="cardContainer optionCard" id="reviewBtn">
                      <div class="cardItems" style="justify-content: center; height: auto; padding-top:0">
                          <svg xmlns="http://www.w3.org/2000/svg" class="optionIcon" viewBox="0 0 24 24">
                              <path fill="#9A2828" d="M4 4h16v2H4zm0 4h16v2H4zm0 4h10v2H4zm0 4h10v2H4z"/>
                          </svg>
                          <button class="choiceTitel" >Review Flashcards</button>
                          <span id="NoOfPending" class="badgePending"></span>
                      </div>
                  </div>

              </div>

        </div>


<!-- // MANAGE CLASSES PAGE// -->

<div  id="manageClasses" style= "display:none;width:100%">

            <div class="titelContainer">
                        <a href="manage.php" class="back-arrow-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="#9A2828" stroke="#9A2828" stroke-width="1.1"  class="size-6">
                                    <path fill-rule="evenodd" d="M11.03 3.97a.75.75 0 0 1 0 1.06l-6.22 6.22H21a.75.75 0 0 1 0 1.5H4.81l6.22 6.22a.75.75 0 1 1-1.06 1.06l-7.5-7.5a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                                    </svg>
                        </a>
            </div>

            <div class ="titels">
                  <h1 class="keep-flashin-smart-add-a-card">Manage you classes!</h1>
                  <h2 class="submit-your-sentense">Choose A Class</h2>
            </div>

            <div class="displayCourses row g-4 mb-5 justify-content-center" id="courseContainer">
                  <p>Loading Classes...</p>                       
            </div>
            <button class="Load-More-button" id="loadMoreBtn">Load More</button>


</div>




<!-- // REVIEW FLASHCARD PAGE// -->

<div  id="reviewFlashcards" style= "display:none;width:100%;padding:20px">

            <div class="titelContainer">
                        <a href="manage.php" class="back-arrow-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="#9A2828" stroke="#9A2828" stroke-width="1.1"  class="size-6">
                                    <path fill-rule="evenodd" d="M11.03 3.97a.75.75 0 0 1 0 1.06l-6.22 6.22H21a.75.75 0 0 1 0 1.5H4.81l6.22 6.22a.75.75 0 1 1-1.06 1.06l-7.5-7.5a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                                    </svg>
                        </a>
            </div>

            <div class ="titels">
                  <h1 class="keep-flashin-smart-add-a-card">Review your students flashcards!</h1>
                  <h2 id= "reviewTitel" class="submit-your-sentense">Choose one to Review</h2>
            </div>




            <div style="width:auto;padding-top:110px;gap:40px;" id="reviewSection" class="groupSection Assign"  >
                
                <p>no Groups </p>

                        
  
             </div>
            



             <div style="display:none;justify-self:center;padding-top:50px" id="flashcardSectionReview" class="card-container">

                                    
              <div style="font-size: 40px;" id="courseReviewName" class="groupName">
                <h1 class="group-titel"></h1>
              </div>

              <div class="flip-container">
              
                         <div class="flipper" id="flipper">
                                    <!-- Front: QA-section -->
                                    <div class="front QA-section" >
                                          <div class="QA-container">
                                                <div class="A-container">
                                                      <p class="answer"> STILL LOADING..</p>
                                                </div>
                                                <div class="Q-container">
                                                       <p class="question review" >LOADING...</p>

                                                     
                                                  </div>
                                          </div>

                                  
                                    </div>

                                    <!-- Back: AQ-section -->
                                    <div  class="back QA-section">
                                          <div class="QA-container">
                                                <div class="Q-container">
                                                      <p class="question review"></p>
                                                </div>
                                                <div class="A-container">
                                                       <p class="answer review" >STILL LOADING..</p>
                                                </div>
                                          </div>

                                         
                                    </div>
                         </div>
                  </div>




              <div class="decision">
                  
              
                
                

                  <button id="approve" class="accept">Approve</button>
                  <button id="reject" class="reject">Reject</button>

                      
                        

              </div>


            </div>

            


            <button id="displayOthersReview" class="Load-More-button review-load-more-btn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="blue" class="size-6">
                                                <path fill-rule="evenodd" d="M14.615 1.595a.75.75 0 0 1 .359.852L12.982 9.75h7.268a.75.75 0 0 1 .548 1.262l-10.5 11.25a.75.75 0 0 1-1.272-.71l1.992-7.302H3.75a.75.75 0 0 1-.548-1.262l10.5-11.25a.75.75 0 0 1 .913-.143Z" clip-rule="evenodd" />
                                                </svg>
                  </button>  

  
                  <div style="display:none; padding-top:110px" id="chosenReview">

                        <div id="groupSelect" class="groupSection Assign">
                      
                              <p>no Groups </p>

                             
        
                  </div>
                  <button id="displayOtherschoose" class="Load-More-button review-load-more-btn">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="blue" class="size-6">
                                                              <path fill-rule="evenodd" d="M14.615 1.595a.75.75 0 0 1 .359.852L12.982 9.75h7.268a.75.75 0 0 1 .548 1.262l-10.5 11.25a.75.75 0 0 1-1.272-.71l1.992-7.302H3.75a.75.75 0 0 1-.548-1.262l10.5-11.25a.75.75 0 0 1 .913-.143Z" clip-rule="evenodd" />
                                                              </svg>
                              
             </div>


</div>




<!-- // GROUPS PAGE// -->
<div id="groupsPage" style="display:none;">

<div class="titelContainer">
                        <a href="manage.php" class="back-arrow-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="#9A2828" stroke="#9A2828" stroke-width="1.1"  class="size-6">
                                    <path fill-rule="evenodd" d="M11.03 3.97a.75.75 0 0 1 0 1.06l-6.22 6.22H21a.75.75 0 0 1 0 1.5H4.81l6.22 6.22a.75.75 0 1 1-1.06 1.06l-7.5-7.5a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                                    </svg>
                        </a>
            </div>

<div class="flex-row" >




            <div class ="titels">
                  <h1 class="keep-flashin-smart-add-a-card">Manage you class!</h1>
                  <h2 class="submit-your-sentense">Choose A group</h2>
            </div>

            <div id ="CourseContainerGroups" class="CourseContainer">

                                 
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
          


            <div id="groupCardsContainer" class="groupCardsContainer"  >
<div id="groupsSection" class="groupSection">
        <p>no Groups</p>
    </div>
              
                       
                 <div id="movingGroups" class="next_-previous_-sectionG">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="#B5B5B5" class="size-6 previous-vectorG" id="prevG">
        <path d="M9.195 18.44c1.25.714 2.805-.189 2.805-1.629v-2.34l6.945 3.968c1.25.715 2.805-.188 2.805-1.628V8.69c0-1.44-1.555-2.343-2.805-1.628L12 11.029v-2.34c0-1.44-1.555-2.343-2.805-1.628l-7.108 4.061c-1.26.72-1.26 2.536 0 3.256l7.108 4.061Z" />
    </svg>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="#B5B5B5" class="size-6 next-vectorG" id="nextG">
        <path d="M5.055 7.06C3.805 6.347 2.25 7.25 2.25 8.69v8.122c0 1.44 1.555 2.343 2.805 1.628L12 14.471v2.34c0 1.44 1.555 2.343 2.805 1.628l7.108-4.061c1.26-.72 1.26-2.536 0-3.256l-7.108-4.061C13.555 6.346 12 7.249 12 8.689v2.34L5.055 7.061Z" />
    </svg>
</div> 

</div> 
                 <!-- </div>
            <div id="groupsSection" class="groupSection"  >
                
                <p>no Groups </p>
                        
  
             </div> -->




             <div style= "display: none;"  id="flashcardSection" class="card-container">

              <div class="group-name">
                <h2 class="flashcard-total-no"></h2>
                <h1 class="group-titel"></h1>
              </div>

              <span style="display:none" class="created-by-admin">Created by Doctor</span>

              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="black" class="size-6 trashIcon2">
  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
</svg>


              <div id="displayMode" class="flip-container">
              
                         <div class="flipper" id="flipper">
                                    <!-- Front: QA-section -->
                                    <div class="front QA-section" id="QA-section">
                                          <div class="QA-container">
                                                <div class="A-container">
                                                      <p class="answer"> STILL LOADING..</p>
                                                </div>
                                                <div class="Q-container">
                                                       <p class="question" >LOADING...</p>

                                                     
                                                  </div>
                                          </div>

                                  
                                    </div>

                                    <!-- Back: AQ-section -->
                                    <div  class="back QA-section" id="AQ-section">
                                          <div class="QA-container">
                                                <div class="Q-container">
                                                      <p class="question"></p>
                                                </div>
                                                <div class="A-container">
                                                       <p class="answer" >STILL LOADING..</p>
                                                </div>
                                          </div>

                                         
                                    </div>
                         </div>
                  </div>






              <div class="next_-previous_-section">
                   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="#B5B5B5" class="size-6 previous-vector">
                         <path d="M9.195 18.44c1.25.714 2.805-.189 2.805-1.629v-2.34l6.945 3.968c1.25.715 2.805-.188 2.805-1.628V8.69c0-1.44-1.555-2.343-2.805-1.628L12 11.029v-2.34c0-1.44-1.555-2.343-2.805-1.628l-7.108 4.061c-1.26.72-1.26 2.536 0 3.256l7.108 4.061Z" />
                   </svg>
                
                  <h2 class="flashcard-total-No">Wait</h2>
                      
                        


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
</html>
