<?php 
  include_once "../../partials/header.php"; 
  include_once "../../partials/auth_admin.php"; 
  include_once "../../partials/navigation.php";

?>

  <title>Admin Dashboard - FlashUT</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!--   
  <link rel="stylesheet" href="../../template/css/styleguide.css">
  <link rel="stylesheet" href="../../template/css/globals.css"> -->
  <link rel="stylesheet" href="../../template/css/admin-dashboard.css">

  <style>
    .admin-dashboard.container-fluid {
      margin-left: 130px;
      width: calc(100% - 130px);

    }
    @media (max-width: 991.98px) {
      .admin-dashboard { margin-left: 0; }
    }

    .admin-dashboard .course {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: #EAE8E8;
      border-radius: 14px;
      box-shadow: 2px 3px rgba(206,205,205,1);
      padding: 12px;
      margin-bottom: 1rem;
      width: 100%;
    }
    .admin-dashboard .course-pic {
      flex: 0 0 70px;
      height: 70px;
      object-fit: cover;
      border-radius: 8px;
    }
    .admin-dashboard .course-name {
      flex: 1;
      margin: 0 1rem;
      font-family: 'Baloo Bhai', sans-serif;
      font-weight: 500;
    }
    
    .admin-dashboard .vector {
      width: 15px;
      height: 15px;
    }
    
.admin-dashboard .view-course-btn {
  display: block;
  width: 90%;
  text-align: center;
}
    .admin-dashboard .view-course-btn:hover {
      background-color: #751F1F;
      transform: scale(1.05);
    }
    .btn-group .btn {
  transition: background-color .2s, color .2s;
  
}

.btn-group .btn:hover {
  background-color: rgba(150, 33, 33, 0.1);
}

.btn-group .btn.active {
  background-color: #9A2828 !important;
  color: #fff !important;
  border-color: #9A2828 !important;
}
  </style>
</head>


  <main class="admin-dashboard container-fluid pb-4">
    <div class="row gx-1">
      
      <section class="col-12 col-lg-6 mb-4 mb-lg-0">
      <div class="welcomeFrame mb-4 position-relative">

          <div class="rectangle-welcomeFrame"></div>
          <div class="greet-sentence">
            <h1 class="title">Hello Dr. <?php echo htmlspecialchars($_SESSION['firstName']); ?>!</h1>
            <p class="ready-to-flash-your-courses b1">Time to Flash and manage!</p>
          </div>
          
          <svg class="illustration" width="179" height="161" viewBox="0 0 179 161" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_2371_347)">
                                    <path d="M172.062 80.0365L195.344 45.8786L169.089 78.2486L169.09 78.2491L159.562 91.0437C151.637 83.8758 124.642 59.4618 124.241 59.1427C129.401 54.4497 132.617 48.0281 132.711 40.9415C136.511 40.1307 139.288 37.0825 139.288 33.4271C139.288 29.7706 136.509 26.7211 132.708 25.9114C132.443 11.5839 119.411 0 103.42 0C87.4284 0 74.3962 11.5839 74.1318 25.9116C70.3306 26.7214 67.5523 29.7706 67.5523 33.4268C67.5523 37.0822 70.3289 40.1304 74.1283 40.9412C74.2224 48.0274 77.438 54.4492 82.598 59.1422C80.9768 60.4302 45.3062 93.0054 45.3062 93.0054C43.174 94.9232 42 97.4724 42 100.184C42 102.897 43.1743 105.447 45.3062 107.364C47.4402 109.284 50.2767 110.341 53.2925 110.341C56.3086 110.341 59.1443 109.283 61.2753 107.364L72.0171 97.7023V119.373H81.0909V161H125.749V119.373H134.823V97.5253L145.761 107.363C146.09 107.66 146.437 107.932 146.798 108.187L142.473 113.995L145.444 115.785L149.937 109.75C151.144 110.138 152.428 110.34 153.747 110.34C156.763 110.34 159.598 109.283 161.73 107.363C163.862 105.446 165.036 102.896 165.036 100.184C165.036 97.6447 164.007 95.2476 162.125 93.379L172.062 80.0365ZM132.72 29.2963C134.491 29.9927 135.712 31.5758 135.712 33.4268C135.712 35.2778 134.492 36.861 132.72 37.5573V29.2963ZM74.1192 37.5573C72.3488 36.861 71.128 35.2783 71.128 33.4268C71.128 31.5756 72.3488 29.9927 74.1192 29.2963V37.5573ZM119.218 8.11316C125.216 12.3252 129.094 18.8699 129.141 26.2197C125.045 24.6525 121.831 21.7837 120.069 18.0994C118.542 14.9083 118.26 11.4266 119.218 8.11316ZM90.2886 6.46791C94.1357 4.40542 98.6253 3.21633 103.42 3.21633C108.03 3.21633 112.357 4.31834 116.103 6.2364C114.548 10.5521 114.774 15.1696 116.784 19.3706C118.708 23.394 122.063 26.6153 126.344 28.5944L122.932 30.6114C121.074 28.6392 118.303 27.3835 115.21 27.3835C109.772 27.3835 105.324 31.2615 105.1 36.1041H101.739C101.515 31.2617 97.067 27.3835 91.6291 27.3835C88.7031 27.3835 86.0646 28.5071 84.2149 30.2986L80.7133 28.2285C84.6364 26.2297 87.7162 23.1559 89.5273 19.37C91.501 15.2448 91.7543 10.7171 90.2886 6.46791ZM121.756 36.4874C121.756 39.7335 118.819 42.3747 115.21 42.3747C111.601 42.3747 108.665 39.7337 108.665 36.4874C108.665 33.2411 111.601 30.6001 115.21 30.6001C118.82 30.6001 121.756 33.2413 121.756 36.4874ZM98.1746 36.4874C98.1746 39.7335 95.2383 42.3747 91.6291 42.3747C88.0198 42.3747 85.0836 39.7337 85.0836 36.4874C85.0836 33.2411 88.0198 30.6001 91.6291 30.6001C95.238 30.6001 98.1746 33.2413 98.1746 36.4874ZM87.1839 8.42306C88.0371 11.6431 87.7215 15.008 86.2427 18.0997C84.5571 21.6227 81.5457 24.4016 77.7048 26.0084C77.8215 18.9236 81.4907 12.6009 87.1839 8.42306ZM77.6948 40.6224V30.2936L82.2795 33.0041C81.7835 34.0779 81.5076 35.2541 81.5076 36.4874C81.5076 41.5068 86.0482 45.591 91.6291 45.591C96.1099 45.591 99.9178 42.9574 101.246 39.321H105.594C106.922 42.9569 110.73 45.591 115.211 45.591C120.792 45.591 125.332 41.5071 125.332 36.4874C125.332 35.403 125.12 34.3631 124.731 33.3979L129.145 30.7882V40.6224C129.145 53.3806 117.605 63.7602 103.421 63.7602H103.42C89.2351 63.7602 77.6948 53.3804 77.6948 40.6224ZM103.42 105.55L97.2012 98.838L103.42 80.6992L109.639 98.838L103.42 105.55ZM103.418 72.9161L95.804 66.0678C98.2343 66.6569 100.786 66.976 103.42 66.976C106.053 66.976 108.604 66.6569 111.033 66.0681L103.418 72.9161ZM99.3524 73.8082L91.9897 76.7189L83.9034 62.4403C84.3486 62.0483 84.8124 61.67 85.2895 61.3023C85.5243 61.4691 99.3524 73.8082 99.3524 73.8082ZM121.551 61.3017C121.994 61.6443 122.43 62.0036 122.856 62.378L114.734 76.7189L107.449 73.8387C107.45 73.8387 121.316 61.4683 121.551 61.3017ZM58.7465 105.091C57.2899 106.403 55.3531 107.125 53.2928 107.125C51.2323 107.125 49.2937 106.402 47.8348 105.091C46.3785 103.781 45.5762 102.039 45.5762 100.185C45.5762 98.3321 46.3785 96.5903 47.8348 95.28L51.9067 91.6175L63.0311 101.238L58.7465 105.091ZM72.0174 80.2838V93.1541L65.5602 98.9619L54.4359 89.3416L73.2403 72.4281C72.4371 74.9447 72.0174 77.5828 72.0174 80.2838ZM75.5933 116.158V80.2843C75.5933 74.6627 77.6469 69.3502 81.3567 65.0295L90.3366 80.8857L101.068 76.6433L93.2123 99.5573L101.643 108.656V116.158H75.5933ZM84.8788 157.784C85.7326 154.289 89.1131 151.898 93.1485 151.898C97.1842 151.898 100.564 154.289 101.418 157.784H84.8788ZM101.63 151.809C99.4495 149.872 96.4527 148.682 93.148 148.682C89.8438 148.682 86.847 149.873 84.6665 151.809V119.374H101.629V151.809H101.63ZM105.421 157.784C106.275 154.289 109.655 151.898 113.691 151.898C117.727 151.898 121.107 154.289 121.961 157.784H105.421ZM122.173 151.809C119.993 149.872 116.995 148.682 113.691 148.682C110.385 148.682 107.386 149.873 105.206 151.812V119.373H122.173V151.809H122.173ZM131.247 116.158H105.219V108.632L113.627 99.5573L105.789 76.696L116.388 80.8857L125.411 64.954C129.191 69.321 131.247 74.6579 131.247 80.2843L131.247 116.158ZM133.513 72.174L152.597 89.3387L141.473 98.959L134.823 92.9775V80.2838C134.823 77.4965 134.374 74.7716 133.513 72.174ZM159.201 105.091C157.744 106.403 155.807 107.125 153.747 107.125C151.686 107.125 149.748 106.402 148.289 105.09L144.002 101.234L155.126 91.6138L159.202 95.2794C160.658 96.5895 161.46 98.3316 161.46 100.185C161.461 102.038 160.658 103.78 159.201 105.091Z" fill="#7B1B1B"/>
                                    <path d="M91.6291 38.7642C93.027 38.7642 94.1603 37.7449 94.1603 36.4876C94.1603 35.2302 93.027 34.2109 91.6291 34.2109C90.2312 34.2109 89.0979 35.2302 89.0979 36.4876C89.0979 37.7449 90.2312 38.7642 91.6291 38.7642Z" fill="#4A0E5C"/>
                                    <path d="M115.211 38.7642C116.609 38.7642 117.742 37.7449 117.742 36.4876C117.742 35.2302 116.609 34.2109 115.211 34.2109C113.813 34.2109 112.68 35.2302 112.68 36.4876C112.68 37.7449 113.813 38.7642 115.211 38.7642Z" fill="#4A0E5C"/>
                                    <path d="M94.2234 83.9468H80.3669V87.1631H94.2234V83.9468Z" fill="#4A0E5C"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_2371_347">
                                       <stop stop-color="#9A2929"/>
                                       <stop offset="1" stop-color="#340E0E"/>


                                       <rect width="182.25" height="160.789" fill="white" transform="translate(0.253662)"/>
                                       </clipPath>
                                    </defs>
                               </svg>        </div>

        <h2 class="h3 coursesText mb-4 pt-4">Classes</h2>

            <div id="courseContainer" class="row mt-3">
             <p class="text-muted">Loading courses…</p>
            </div>
      </section>

      <aside class="col-12 col-lg-5 pt-4 ms-5">
         <div class="mb-2 p-2 rounded Motiv-Container d-flex align-items-center justify-content-center">
         <svg xmlns="http://www.w3.org/2000/svg" fill="yellow" viewBox="0 0 24 24" width="48" height="48" class="icon-1 ">
  <path d="M9 21h6v-1H9v1zm3-19a7 7 0 0 0-7 7c0 2.615 1.579 4.844 3.823 6.004L9 18v1h6v-1l.177-2.996A7.001 7.001 0 0 0 12 2zm0 2a5 5 0 0 1 5 5c0 1.707-.887 3.202-2.305 4.106l-.403.25-.292 2.644H9l-.292-2.644-.403-.25A5.002 5.002 0 0 1 12 4z"/>
</svg>
                <span class="h4 mb-0 Motiv-sentence"><strong>FlashUT Admin</strong>  — Empowering every learner!</span>
        </div>


        <div class="d-flex justify-content-between mt-2">
            <div  class="p-1 rounded text-center flex-fill me-2 statContainer">
                <div id="NoCourses" class="fs-1 theNo">0</div>
                     <strong class="h5">Available Classes</strong>
            </div>

          
            <div class="p-1 rounded text-center flex-fill ms-2 statContainer">
                <div id="NoReviews" class="fs-1 theNo">0</div>
                <strong  class="h5">Flashcards for Review..</strong>
            </div>

        </div>

        <div class="mb-2 mt-4 rounded">
            <h4 class="your-statistics">Your Statistics</h4>
            
          <div class="btn-group m-1" role="group">
            <button
                id="weeklyBtn"
                class="btn btn-outline-secondary active"
                onclick="selectPeriod('weekly')"
            >
                Weekly
            </button>

            <button
                id="monthlyBtn"
                class="btn btn-outline-secondary"
                onclick="selectPeriod('monthly')"
            >
                Monthly
            </button>

        </div>
            <canvas id="flashcardStatsChart" width="400" height="250"></canvas>
            </div>


            <div class="row g-2 align-items-stretch">
        <div class="col-12">
    <a href="addFlashcard.php"
       class="quickAction rounded d-flex flex-column justify-content-center align-items-center p-2 h-95 text-decoration-none"
       title="Add a quick flashcard">
      <h3 class="h5 mt-3">Add a quick flashcard</h3>
      <svg xmlns="http://www.w3.org/2000/svg"
           viewBox="0 0 22 22"
           stroke="#751F1F"
           stroke-width="1.5"
           class="size-6 add mb-4">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
      </svg>
    </a>
  </div>

          <!-- <div class="col-6">
    <a href="favoriteGroups.php"
       class="quickAction rounded d-flex flex-column justify-content-center align-items-center p-2 h-95 text-decoration-none"
       title="Favorite Groups">
      <h3 class="h5 mt-2">Favorite Groups</h3>
      <div id="favoriteCount" class="mb-2 text-dark">0 Groups</div>
      <svg xmlns="http://www.w3.org/2000/svg"
           viewBox="0 0 24 24"
           stroke="#751F1F"
           stroke-width="1.5"
           class="size-6 fav mb-0">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
      </svg>
    </a>
  </div> -->
        </div>
      </aside>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>


  
  <script>
  document.addEventListener("DOMContentLoaded",()=>{
    fetch(`../../controllers/admin/adminDashboard.php`)
      .then(r=>r.json())
      .then(data=>{
        document.getElementById("NoCourses").textContent = data.total;
        const container = document.getElementById("courseContainer");
        container.innerHTML = "";
        if(!data.courses || data.courses.length===0){
          container.innerHTML = '<p class="text-muted">No classes found.</p>';
          return;
        }
        const currentSemester = "46-2";  
        let filteredCourses = data.courses.filter(c => c.semester_code === currentSemester);
        filteredCourses.slice(0, 5).forEach(c => {  
          container.insertAdjacentHTML("beforeend", `
          <div class="col-12 mb-0,5">
            <div class="course">

              <img src="../../template/imgCourses/${c.image_path}" class="course-pic" alt="">

              <div class="course-name"> 
              <strong>${c.course_name}</strong>
              </div>

             
              <div style="flex:1.2;" class="sectionContainer">

                      <svg class="vector" fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 30 30" xml:space="preserve">
                      <g id="SVGRepo_bgCarrier" stroke-width="3.5"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g>
                       <path d="M29.936,1.153H0v20.045h10.91l-3.76,7.584h2.899l1.288-2.613h6.72l1.287,2.613h2.932l-3.787-7.583h11.445V1.153H29.936z M12.292,24.234l1.496-3.035h1.819l1.496,3.035H12.292z M28.646,19.908H1.29V2.443h27.356V19.908z"></path> <rect x="22.631" y="17.149" width="2.191" height="1.859"></rect> </g> </g> </g>
                       </svg>
                        
                          <span class="caption"> ${c.section_name}</span>
                      </div>

                      <div class="sectionContainer">

                            <svg class="vector"  viewBox="0 0 50.00 50.00" id="a" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="black" transform="matrix(1, 0, 0, 1, 0, 0)" stroke-width="1.7"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.288"></g>
                                <g id="SVGRepo_iconCarrier"><defs></defs><rect class="b" x="10.0372" y="11.3298" width="21.0638" height="32.1702" rx="2.5612" ry="2.5612"></rect><path class="b" d="m13.4521,11.3298v-.8537c0-1.4145,1.1467-2.5612,2.5612-2.5612h15.9415c1.4145,0,2.5612,1.1467,2.5612,2.5612v27.0479c0,1.4145-1.1467,2.5612-2.5612,2.5612h-.8537"></path><path class="b" d="m16.8989,7.9149v-.8537c0-1.4145,1.1467-2.5612,2.5612-2.5612h15.9415c1.4145,0,2.5612,1.1467,2.5612,2.5612v27.0479c0,1.4145-1.1467,2.5612-2.5612,2.5612h-.8856"></path>
                                </g>
                            </svg> 
                                
                          <span class="caption"> ${c.total_flashcards}</span>
                      </div>

                      


                <a href="groupsOfClass.php?section_id=${c.section_id}"
                class="view-course-btn"> View
                 </a> 
             
       </div>

     </div>

          `);
        });
      });
  });


  fetch(`../../controllers/admin/adminDashboard.php?state=2`)
      .then(r=>r.json())
      .then(data=>{
        document.getElementById("NoReviews").textContent=data.review;
      });


  let statsChart;
  function loadStats(period="weekly"){
    fetch(`../../controllers/admin/adminDashboard.php?stats=1&period=${period}`)
      .then(r=>r.json()).then(data=>{
        const added = Object.values(data.stats.added);
        const reviewed = Object.values(data.stats.reviewed);
        const labels = Object.keys(data.stats.added);
        const ctx = document.getElementById("flashcardStatsChart").getContext("2d");
        if(statsChart) statsChart.destroy();
        statsChart = new Chart(ctx,{
          type:"bar",
          data:{ labels, datasets:[
            { label:"Added",    data:added,    backgroundColor:"rgba(150,33,33,0.7)" },
            { label:"Reviewed", data:reviewed, backgroundColor:"rgba(33,105,150,0.6)" }
          ]},
          options:{ responsive:true, scales:{ y:{ beginAtZero:true, stepSize:1 } } }
        });
      });
   
  }
  document.addEventListener("DOMContentLoaded",()=>loadStats());
  </script>
  <script>
  function selectPeriod(period) {
    document.getElementById('weeklyBtn').classList.toggle('active', period === 'weekly');
    document.getElementById('monthlyBtn').classList.toggle('active', period === 'monthly');
    loadStats(period);
  }

  document.addEventListener('DOMContentLoaded', () => {
    selectPeriod('weekly');
  });
</script>
</body>
</html>