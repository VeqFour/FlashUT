<?php

if (!isUserLoggedIn()) {
  header("Location:/FlashUT/views/login.php?message=You have to login");
  exit();
  include "functions.php";
}

$dashboardPage   = ($_SESSION['role'] === 'admin') ? 'admin/adminDashboard.php'   : 'student/studentDashboard.php';
$coursesPage     = ($_SESSION['role'] === 'admin') ? 'admin/adminClasses.php'     : 'student/studentCourses.php';
$addFlashcard    = ($_SESSION['role'] === 'admin') ? 'admin/addFlashcard.php'     : 'student/addFlashcard.php';
$groupsPage      = ($_SESSION['role'] === 'admin') ? 'admin/groupsOfClass.php'     : 'student/groupsOfCourse.php';
$leaderboardPage = ($_SESSION['role'] === 'admin') ? 'admin/leaderboard.php'     : 'student/leaderboard.php';
$profile         = ($_SESSION['role'] === 'student') ? 'student/profile.php' : 'admin/profile.php';
$managePage      = ($_SESSION['role'] === 'admin') ? 'admin/manage.php'            : null;
$followFlashcards  = ($_SESSION['role'] === 'student') ? 'student/followFlashcards.php' : null;
?>

<?php
function renderMenuItems() {
    global $dashboardPage, $coursesPage, $addFlashcard, $groupsPage, $leaderboardPage, $managePage,$followFlashcards,$profile;
    ?>
    <ul class="menu-items p-0 m-0 list-unstyled">
      <li><a style="text-decoration: none;cursor:pointer" href="../../index.php"><h4 class="flash-ut">Flash UT</h4></a></li>

      <div class="tooltip-container" data-tooltip="Dashboard">
        <li class="menu-icon <?= activePage($dashboardPage) ?>">
          <a href="/FlashUT/views/<?= $dashboardPage ?>">
          <svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none" stroke="white" class="size-5" >
                                                 <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 0 1 1.414 0l7 7A1 1 0 0 1 17 11h-1v6a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-6H3a1 1 0 0 1-.707-1.707l7-7Z" clip-rule="evenodd" />
                                     </svg>          </a>
        </li>
      </div>

      <div class="tooltip-container" data-tooltip="My Courses">
        <li class="menu-icon <?= activePage($coursesPage) . activePage($groupsPage) . activePage("flashcard.php") ?>">
          <a href="/FlashUT/views/<?= $coursesPage ?>">
          <svg   xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white"  class="size-6">
                              <path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                              <path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
                              <path d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z" />
                        </svg>          </a>
        </li>
      </div>

      <div class="tooltip-container" data-tooltip="Add Flashcard">
        <li class="menu-icon <?= activePage($addFlashcard) ?>">
          <a href="/FlashUT/views/<?= $addFlashcard ?>">
            <svg width="40px" height="40px" viewBox="0 0 44.00 44.00" id="a" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#ffffff" transform="matrix(1, 0, 0, 1, 0, 0)" stroke-width="1.3"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.288"></g>
              <g id="SVGRepo_iconCarrier"><defs></defs><rect class="b" x="10.0372" y="11.3298" width="21.0638" height="32.1702" rx="2.5612" ry="2.5612"></rect><path class="b" d="m13.4521,11.3298v-.8537c0-1.4145,1.1467-2.5612,2.5612-2.5612h15.9415c1.4145,0,2.5612,1.1467,2.5612,2.5612v27.0479c0,1.4145-1.1467,2.5612-2.5612,2.5612h-.8537"></path><path class="b" d="m16.8989,7.9149v-.8537c0-1.4145,1.1467-2.5612,2.5612-2.5612h15.9415c1.4145,0,2.5612,1.1467,2.5612,2.5612v27.0479c0,1.4145-1.1467,2.5612-2.5612,2.5612h-.8856"></path></g>
            </svg>    
          </a>
        </li>
      </div>

      <div class="tooltip-container" data-tooltip="Leaderboard">
        <li class="menu-icon <?= activePage($leaderboardPage) ?>">
          <a href="/FlashUT/views/<?= $leaderboardPage ?>">
          <svg viewBox="0 0 24 24" width="44px" height="44px"  fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff" stroke-width="1.8"><g id="SVGRepo_bgCarrier" stroke-width="1.5"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="1.624"></g>
                                    <g id="SVGRepo_iconCarrier"> <path d="M15 21H9V12.6C9 12.2686 9.26863 12 9.6 12H14.4C14.7314 12 15 12.2686 15 12.6V21Z" stroke="#ffffff" stroke-width="0.83200000000000005" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M20.4 21H15V18.1C15 17.7686 15.2686 17.5 15.6 17.5H20.4C20.7314 17.5 21 17.7686 21 18.1V20.4C21 20.7314 20.7314 21 20.4 21Z" stroke="#ffffff" stroke-width="0.83200000000000005" stroke-linecap="round" stroke-linejoin="round"></path> 
                                    <path d="M9 21V16.1C9 15.7686 8.73137 15.5 8.4 15.5H3.6C3.26863 15.5 3 15.7686 3 16.1V20.4C3 20.7314 3.26863 21 3.6 21H9Z" stroke="#ffffff" stroke-width="0.83200000000000005" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M10.8056 5.11325L11.7147 3.1856C11.8314 2.93813 12.1686 2.93813 12.2853 3.1856L13.1944 5.11325L15.2275 5.42427C15.4884 5.46418 15.5923 5.79977 15.4035 5.99229L13.9326 7.4917L14.2797 9.60999C14.3243 9.88202 14.0515 10.0895 13.8181 9.96099L12 8.96031L10.1819 9.96099C9.94851 10.0895 9.67568 9.88202 9.72026 9.60999L10.0674 7.4917L8.59651 5.99229C8.40766 5.79977 8.51163 5.46418 8.77248 5.42427L10.8056 5.11325Z" stroke="#ffffff" stroke-width="0.83200000000000005" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </g>
                                    </svg>          </a>
        </li>
      </div>

      <?php if ($_SESSION['role'] === 'admin'): ?>
      <div class="tooltip-container" data-tooltip="Manage">
        <li class="menu-icon <?= activePage($managePage) ?>">
          <a href="/FlashUT/views/<?= $managePage ?>">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="size-6">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                                    </svg>          </a>
        </li>
      </div>
      <?php endif; ?>

      <?php if ($_SESSION['role'] === 'student'): ?>
              <div class="tooltip-container" data-tooltip="Track">
        <li class="menu-icon <?= activePage($followFlashcards) ?>">
          <a href="/FlashUT/views/<?= $followFlashcards ?>">
         <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 512 512" fill="white" viewBox="0 0 24 24" stroke-width="1.9" stroke="white" class="size-6" xml:space="preserve">
<g>
	<g>
		<path d="M437.4,281.224h-21.046c16.833-34.58,28.023-67.206,28.023-92.847c0-18.316-2.624-36.425-7.802-53.82
			c-1.268-4.259-5.747-6.682-10.012-5.419c-4.261,1.269-6.687,5.75-5.419,10.012c4.734,15.904,7.134,32.466,7.134,49.227
			c0,85.29-140.794,263.973-172.277,302.857C224.517,452.35,83.723,273.668,83.723,188.377c0-94.994,77.283-172.277,172.277-172.277
			c65.227,0,124.115,36.151,153.686,94.345c2.015,3.965,6.86,5.544,10.824,3.53c3.963-2.015,5.544-6.861,3.53-10.824
			c-15.519-30.541-39.089-56.31-68.164-74.526C325.981,9.9,291.444,0,256,0C157.613,0,76.615,75.82,68.334,172.096
			c-28.133,3.128-50.087,27.042-50.087,55.996v12.881c0,31.072,25.28,56.352,56.352,56.352h29.205
			c16.907,32.145,37.839,65.281,58.534,95.53h-81.3c-31.072,0-56.352,25.28-56.352,56.352v6.44C24.688,486.72,49.968,512,81.04,512
			h172.813c4.341,0,9.685-4.342,12.328-7.737c16.117-20.708,40.306-49.843,72.37-95.402c0.383,0.056,0.773,0.094,1.172,0.094H437.4
			c31.072,0,56.352-25.28,56.352-56.352v-15.027C493.753,306.504,468.472,281.224,437.4,281.224z M74.6,281.224
			c-22.195,0-40.252-18.056-40.252-40.252v-12.881c0-19.814,14.396-36.32,33.276-39.634c0.024,25.628,11.206,58.222,28.022,92.766
			H74.6z M81.04,495.899c-22.195,0-40.252-18.056-40.252-40.252v-6.44c0-22.195,18.056-40.252,40.252-40.252h92.476
			c26.737,37.984,51.744,69.845,65.512,86.943H81.04z M477.652,352.604c0,22.195-18.056,40.252-40.252,40.252h-87.74
			c20.696-30.25,41.628-63.385,58.534-95.53H437.4c22.195,0,40.252,18.056,40.252,40.252V352.604z"/>
	</g>
</g>
<g>
	<g>
		<path d="M256,40.788c-81.38,0-147.589,66.209-147.589,147.589c0,13.892,1.93,27.644,5.735,40.872
			c1.23,4.272,5.692,6.743,9.962,5.512c4.272-1.23,6.74-5.69,5.512-9.962c-3.39-11.782-5.108-24.036-5.108-36.422
			c0-72.503,58.985-131.488,131.488-131.488s131.488,58.985,131.488,131.488S328.503,319.866,256,319.866
			c-48.242,0-92.539-26.357-115.604-68.783c-2.123-3.906-7.011-5.353-10.917-3.228c-3.907,2.123-5.351,7.011-3.228,10.917
			c25.884,47.615,75.602,77.194,129.749,77.194c81.38,0,147.589-66.209,147.589-147.589S337.38,40.788,256,40.788z"/>
	</g>
</g>
<g>
	<g>
		<path d="M350.457,115.925H161.543c-4.447,0-8.05,3.603-8.05,8.05v137.392c0,4.447,3.603,8.05,8.05,8.05h188.914
			c4.447,0,8.05-3.603,8.05-8.05V123.975C358.507,119.528,354.904,115.925,350.457,115.925z M218.969,132.025h26.834v44.008h-26.834
			V132.025z M299.472,253.317H169.593V132.025h33.275v52.059c0,4.447,3.603,8.05,8.05,8.05h42.935c4.447,0,8.05-3.603,8.05-8.05
			v-52.059h37.568V253.317z M342.407,253.317h-26.834V132.025h26.834V253.317z"/>
	</g>
</g>
<g>
	<g>
		<path d="M281.761,206.088h-92.31c-4.447,0-8.05,3.603-8.05,8.05s3.603,8.05,8.05,8.05h92.31c4.447,0,8.05-3.603,8.05-8.05
			S286.208,206.088,281.761,206.088z"/>
	</g>
</g>
<g>
	<g>
		<path d="M281.761,229.702h-92.31c-4.447,0-8.05,3.603-8.05,8.05s3.603,8.05,8.05,8.05h92.31c4.447,0,8.05-3.603,8.05-8.05
			S286.208,229.702,281.761,229.702z"/>
	</g>
</g>
</svg>

         </a>
        </li>
      </div>
      <?php endif; ?>

      <div class="bottom-section">
        <div class="tooltip-container" data-tooltip="Profile">
          <li class="menu-icon <?= activePage("profile.php") ?>">
            <a href="/FlashUT/views/<?=$profile?>">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.0" stroke="white" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                              </svg>            </a>
          </li>
        </div>

        <div class="tooltip-container" data-tooltip="Log out">
          <li class="menu-icon logout">
            <a href="/FlashUT/controllers/logout.php">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white"  class="size-6">
                                    <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 0 0 6 5.25v13.5a1.5 1.5 0 0 0 1.5 1.5h6a1.5 1.5 0 0 0 1.5-1.5V15a.75.75 0 0 1 1.5 0v3.75a3 3 0 0 1-3 3h-6a3 3 0 0 1-3-3V5.25a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3V9A.75.75 0 0 1 15 9V5.25a1.5 1.5 0 0 0-1.5-1.5h-6Zm5.03 4.72a.75.75 0 0 1 0 1.06l-1.72 1.72h10.94a.75.75 0 0 1 0 1.5H10.81l1.72 1.72a.75.75 0 1 1-1.06 1.06l-3-3a.75.75 0 0 1 0-1.06l3-3a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                              </svg>            </a>
          </li>
        </div>
      </div>
    </ul>
    <?php
}
?>


  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />


  <style>
    .offcanvas-backdrop {
      background-color: rgba(0,0,0,0.3);
    }
    #toggleMenuBtn {
    color: #9A2828;      
    z-index: 100000;       
  }
  </style>
</head>
<body>

<button id="toggleMenuBtn"
        class="btn btn-link position-fixed top-0 start-0 m-3 d-lg-none"
        data-bs-toggle="offcanvas" data-bs-target="#mobileMenu"
        aria-label="Open menu">
  <i class="bi bi-list" style="font-size:2rem;"></i>
</button>

  <div
    class="offcanvas offcanvas-start d-lg-none"
    tabindex="-1"
    id="mobileMenu"
    aria-labelledby="mobileMenuLabel"
  >
    <div class="offcanvas-body p-0">
      <nav class="menu h-100">
        <?php renderMenuItems(); ?>
      </nav>
    </div>
  </div>

  <nav class="menu d-none d-lg-flex">
    <?php renderMenuItems(); ?>
  </nav>

  <main class="ms-lg-5 ps-lg-5">
  </main>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    defer
  ></script>
</body>
</html>