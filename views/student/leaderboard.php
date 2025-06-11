<?php
include_once "../../partials/header.php";
include_once "../../partials/navigation.php";
?>
    <link rel="stylesheet" type="text/css" href="../../template/css/leaderboard.css" />

    <title>Leaderboard - FlashUT</title>
    

    <script>
       

function loadLeaderboard(sortBy) {
  document.querySelectorAll(".filter-btn").forEach(btn => btn.classList.remove("active"));
  document.getElementById(`${sortBy}Btn`)?.classList.add("active");

  fetch(`../../controllers/student/leaderboard.php?sort=${sortBy}`)
    .then(res => res.json())
    .then(data => {
      const CURRENT_USER_ID = data.current_user_id;
      const leaders = data.leaders;

      displayTopThree(leaders);

      const container = document.getElementById("leaderboardData");
      container.innerHTML = "";

      leaders.forEach((leader, index) => {
        const isCurrentUser = leader.user_id == CURRENT_USER_ID;
        const highlightClass = isCurrentUser ? " current-user" : "";

        container.innerHTML += `
          <div class="userInfos leaderboard-row${highlightClass}">
            <span class="name">
              ${leader.firstName} ${leader.lastName}
              <div class="student-id">#${leader.academicID.slice(-3)}</div>
            </span>
            <span class="rank">${index + 1}</span>
            <span class="add">${leader.add_count}</span>
            <span class="view">${leader.view_count}</span>
            <span class="scores">${leader.score}</span>
          </div>
        `;
      });
    })
    .catch(err => {
      console.error("Failed to load leaderboard:", err);
    });
}


function displayTopThree(leaders) {
  const topThree = leaders.slice(0, 3);

  const containerMap = {
    0: document.getElementById("1st"), 
    1: document.getElementById("2st"), 
    2: document.getElementById("3st")  
  };

  topThree.forEach((leader, i) => {
    const card = containerMap[i];
    if (card) {
      card.querySelector(".top-name").textContent = `${leader.firstName} ${leader.lastName}`;
      card.querySelector(".top-id").textContent = `#${leader.academicID.slice(-3)}`;
    }
  });
}
document.addEventListener("DOMContentLoaded", () => {
    loadLeaderboard("score");
});

function filterLeadeboard() {
  const input = document.getElementById("searchInput")
  const filter = input.value.toLowerCase();
  const students = document.querySelectorAll("#leaderboardData .name");

  students.forEach(student => {
    const name = student.textContent.toLowerCase();
    student.style.display = name.includes(filter) ? "block" : "none";
    
  });
}
document.querySelector(".search-bar").addEventListener("input", searchLeaderboard);
</script>



    

      <div class="leadrboard screen">
            
          <div class="titel-container">
            <h1 class="titel-page">See where you are!</h1>
            <img class="icon-page" src="../../template/imgLeader/iconpage.png" alt="IconPage" />
          </div>


          <div class="main-leader-board">

            <div class="leader-borad-state">

                   <div class="top3-container">
                        
                        <div id="2st" class="x2st-container top-card">
                        <div class="medalIcon">
                              <img src="../../template/imgLeader/medal-silver-badge.svg" alt="Silver Medal" />
                        </div>
                        <div class="top-name">Name</div>
                        <div class="top-id">#123</div>
                        </div>

                        <div id="1st" class="x1st-container top-card">
                        <div class="medalIcon just">
                              <img src="../../template/imgLeader/gold-medal.svg" alt="Gold Medal" />
                        </div>
                        <div class="top-name">Name</div>
                        <div class="top-id">#456</div>
                        </div>

                        <div id="3st" class="x3st-container top-card">
                        <div class="medalIcon">
                              <img src="../../template/imgLeader/medal-bronze-prize.svg" alt="Bronze Medal" />
                        </div>
                        <div class="top-name">Name</div>
                        <div class="top-id">#789</div>
                        </div>

                  </div>

                  <div class="leaderboard-filters">
                        <button onclick="loadLeaderboard('view')" class="filter-btn" id="viewBtn">Most Viewed</button>
                        <button onclick="loadLeaderboard('score')" class="filter-btn active" id="scoreBtn">Top Score</button>
                        <button onclick="loadLeaderboard('add')" class="filter-btn" id="addBtn">Most Added</button>
                   </div>
                                                            
            

                    <div class="states-container">
                        <div class="states-labels leaderboard-row">
                              <div class="name">Name</div>
                              <div class="rank">Rank</div>
                              <div class="add">Add</div>
                              <div class="view">View</div>
                              <div class="score">Score</div>
                        </div>
                        <input type="text" class="search-bar" placeholder="Search by name or ID" id="searchInput" onkeyup="filterLeadeboard()">

                        <div class="leaderboard-scroll-area">
                              <div id="leaderboardData"></div>
                        </div>
                  </div>

      



            



            </div>
          </div>
      </div>
  </body>
</html>
