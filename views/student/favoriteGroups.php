<?php
include_once "../../partials/header.php";
include_once "../../partials/navigation.php";
?>
<link rel="stylesheet" href="../../template/css/favoriteGroups.css" />

<script>
document.addEventListener("DOMContentLoaded", () => {
  fetch("../../controllers/student/favoriteGroups.php")
    .then(res => res.json())
    .then(data => {
      const container = document.getElementById("favGroupContainer");
      const showMoreBtn = document.getElementById("showMoreBtn");

      if (!data.success || data.groups.length === 0) {
        container.innerHTML = "<p class='error-message'>No favorite groups found.</p>";
        return;
      }

      let currentIndex = 0;
      const groupsPerPage = 8;

      function displayGroups() {
        const visibleGroups = data.groups.slice(currentIndex, currentIndex + groupsPerPage);


        container.innerHTML = visibleGroups.map(group => {
          const isFavorited = data.favorites.includes(group.group_id);
          return `
            <div class="cardContainer">
              <svg xmlns="http://www.w3.org/2000/svg" 
                   fill="${isFavorited ? "#DB3A3A" : "none"}"
                   data-group-id="${group.group_id}"
                   viewBox="0 0 22 22" 
                   stroke-width="1.5" 
                   stroke="black" 
                   class="size-6 faviorateIcon">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
              </svg>
              <div class="cardItems">
              <p class="courseLine">${group.course_name}</p>
                <h3 class="groupName">${group.group_name}</h3>
                <div class="bottomPart">
                  <h3 class="NoOfFlashcards">${group.flashcard_count} Flashcards</h3>
<a href="flashcard.php?group_id=${group.group_id}&group_name=${group.group_name}&course_id=${group.course_id}&course_name=${group.course_name}&course_image=${group.image_path}">                    <button class="flashing-button">
                      Flashing
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-6">
                        <path fill-rule="evenodd" d="M14.615 1.595a.75.75 0 0 1 .359.852L12.982 9.75h7.268a.75.75 0 0 1 .548 1.262l-10.5 11.25a.75.75 0 0 1-1.272-.71l1.992-7.302H3.75a.75.75 0 0 1-.548-1.262l10.5-11.25a.75.75 0 0 1 .913-.143Z" clip-rule="evenodd" />
                      </svg>
                    </button>
                  </a>
                </div>
              </div>
            </div>
          `;
        }).join('');

        attachToggleEvents();

        if (currentIndex + groupsPerPage < data.groups.length) {
          showMoreBtn.style.display = "block";
        } else {
          showMoreBtn.style.display = "none";
        }
      }

      function attachToggleEvents() {
        document.querySelectorAll(".faviorateIcon").forEach(icon => {
          icon.addEventListener("click", () => {
            const groupId = icon.getAttribute("data-group-id");
            fetch("../../controllers/student/toggleFavoriteGroup.php", {
              method: "POST",
              headers: { "Content-Type": "application/json" },
              body: JSON.stringify({ group_id: groupId })
            })
            .then(res => res.json())
            .then(result => {
              if (result.success) {
                icon.setAttribute("fill", result.favorited ? "#DB3A3A" : "none");
              } else {
                alert("Failed to update favorite.");
              }
            });
          });
        });
      }

      showMoreBtn.addEventListener("click", () => {
        currentIndex += groupsPerPage;
        displayGroups(); 
      });

      displayGroups(); 
    });
});
</script>



<div class="groups screen">
  <div class="flex-col-1">

  <div class="titelContainer">
  <a href="javascript:history.back()">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="#9A2828" stroke="#9A2828" stroke-width="1.1" class="size-6 back-arrow-link">
      <path fill-rule="evenodd" d="M11.03 3.97a.75.75 0 0 1 0 1.06l-6.22 6.22H21a.75.75 0 0 1 0 1.5H4.81l6.22 6.22a.75.75 0 1 1-1.06 1.06l-7.5-7.5a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
    </svg>
  </a>

  <h1 class="page-title">Your Favorite Groups</h1>
</div>

<div id="favGroupContainer" class="groupSection"></div>
<button id="showMoreBtn" class="next-course-btn" style="display:none;">Show More</button>
  </div>
</div>
</body>
</html>