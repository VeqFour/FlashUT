<?php 
  include_once "../../partials/header.php";  
  include_once "../../partials/navigation.php"; 
?>

  <title>Student Dashboard - FlashUT</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- <link rel="stylesheet" href="../../template/css/styleguide.css">
  <link rel="stylesheet" href="../../template/css/globals.css"> -->
  <link rel="stylesheet" href="../../template/css/student-dashboard.css">

  <style>
    

  .student-dashboard.container-fluid {
      margin-left: 130px;
      width: calc(100% - 130px);

        }
   
/*     
.nav-pills .nav-link {
  color:rgba(93, 93, 93, 0.67);              
  transition: background-color .2s, color .2s;
} */

/* 
.nav-pills .nav-link:hover {
  color:rgb(140, 36, 36);             
} */

/* 
.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
  
  color: #9A2828!important ;             
  border-color: #9A2828 !important;
  background-color:#f6f6f6!important;
  font-weight: 900;

} */

.student-dashboard .course {
  display: flex;
  align-items: center;
  background: #EAE8E8;
  border-radius: 14px;
  box-shadow: 2px 3px rgba(206,205,205,1);
  padding: 11px;
}
.student-dashboard .course-pic {
  flex: 0 0 70px;             
  height: 70px;              
  object-fit: cover;
  border-radius: 8px;
}

.student-dashboard .course-name {
  flex: 2;
  margin: 0.5rem;
}



.student-dashboard .view-course-btn {
  display: block;
  width: 90%;
  text-align: center;
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

  <main class="student-dashboard container-fluid pb-9">
    <div class="row gx-1">

      <section class="col-12 col-lg-6 mb-4 mb-lg-0">
        <div class="welcomeFrame mb-4 position-relative">
          <div class="rectangle-welcomeFrame"></div>
          <img id="iconLeader" class="iconGold" src="../../template/img/icon-1.svg" alt="Icon" />
          <svg id="iconALT" class="iconGold" fill="#FFD700" viewBox="-6.4 -6.4 76.80 76.80" data-name="Layer 1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff" stroke-width="0.00064" transform="matrix(1, 0, 0, 1, 0, 0)rotate(0)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><title></title><rect height="8" width="8" x="6" y="54"></rect><rect height="11" width="8" x="21" y="51"></rect><rect height="15" width="8" x="36" y="47"></rect><rect height="24" width="8" x="51" y="38"></rect><rect height="10" width="4.5" x="39" y="18"></rect><rect height="10" width="3" x="44.5" y="18"></rect><rect height="10" width="4.5" x="48.5" y="18"></rect><path d="M30.00146,17.9502l-.002.08007L32,18a14.02975,14.02975,0,0,1,.46582-3.59473l-1.93359-.51269A15.88629,15.88629,0,0,0,30.00146,17.9502Z"></path><path d="M46.01514,34,46,32a14.03255,14.03255,0,0,1-3.6084-.46924L41.877,33.46338A16.04749,16.04749,0,0,0,46,34Z"></path><path d="M41.81494,2.55322a15.905,15.905,0,0,0-3.85351,1.60987L38.96729,5.8916a13.90736,13.90736,0,0,1,3.36914-1.40771Z"></path><path d="M59.52686,21.62256l1.93261.51562A16.057,16.057,0,0,0,62,18v-.06055L60,18A14.04072,14.04072,0,0,1,59.52686,21.62256Z"></path><path d="M59.82861,9.94727l-1.72754,1.00781a13.92209,13.92209,0,0,1,1.41114,3.36767l1.92968-.52441A15.90937,15.90937,0,0,0,59.82861,9.94727Z"></path><path d="M57.27393,6.647a16.03853,16.03853,0,0,0-3.31934-2.53174l-.99512,1.73438a14.04964,14.04964,0,0,1,2.90528,2.21631Z"></path><path d="M30.54932,22.17041a15.91558,15.91558,0,0,0,1.606,3.855l1.7295-1.00488A13.883,13.883,0,0,1,32.481,21.65088Z"></path><path d="M50.0918,2.52832A16.03746,16.03746,0,0,0,46,2h-.04541L46,4a14.03208,14.03208,0,0,1,3.581.46191Z"></path><path d="M58.12939,24.99609a14.04627,14.04627,0,0,1-2.22558,2.89844l1.415,1.41406a16.06769,16.06769,0,0,0,2.542-3.31152Z"></path><path d="M54.01123,31.853,53.0083,30.12256a13.91241,13.91241,0,0,1-3.37158,1.40088l.51855,1.93164A15.93177,15.93177,0,0,0,54.01123,31.853Z"></path><path d="M33.85645,11.02832a14.04574,14.04574,0,0,1,2.21972-2.90283l-1.418-1.41113a16.07144,16.07144,0,0,0-2.53515,3.31591Z"></path><path d="M34.70312,29.33008a16.04284,16.04284,0,0,0,3.31348,2.53857l.999-1.73242a14.06851,14.06851,0,0,1-2.90039-2.22217Z"></path><path d="M14.27051,41H24a1.00071,1.00071,0,0,0,.6001-.2002l6.00311-4.50231-.58954,3.538,1.97266.3291,1-6a1.0001,1.0001,0,0,0-.82178-1.15088l-6-1-.3291,1.97266,3.69519.61572L23.6665,39H14a.998.998,0,0,0-.50391.13623l-12,7,1.00782,1.72754Z"></path><path d="M47.5,12l1.56641-2.16748a1.07439,1.07439,0,0,1,1.88232,1.0332L50,12H48.5v5H55V12H52.618l.11981-.23975a3.07454,3.07454,0,0,0-5.38623-2.957l-1.31982,2.2-1.31983-2.2a3.07456,3.07456,0,0,0-5.38623,2.957L39.4455,12H37v5h6.5V12H42l-.88525-1.13428a1.0744,1.0744,0,0,1,1.88232-1.0332L44.5,12v5h3Z"></path>
        </g></svg>

          <div class="greet-sentence">
            <h1 class="title">Hello <?php echo htmlspecialchars($_SESSION['firstName']); ?>!</h1>
            <p class="ready-to-flash-your-courses b1">Ready to Flash your courses?</p>
          </div>

          <svg class="illustration" width="132" height="161" viewBox="0 0 132 161" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_2353_58)">
                                <path d="M70.5194 16.8865C75.1007 30.636 90.0939 28.5669 100.268 25.6301C102.707 24.8959 105.206 24.095 107.407 22.6933C109.609 21.2917 111.453 19.0223 112.167 16.2858C112.941 13.2155 112.048 9.81153 110.501 7.14173C109.073 4.67216 106.991 2.06911 104.79 0.46723C103.838 3.20377 100.446 3.40401 98.126 3.40401C94.8536 3.40401 91.8788 2.00237 88.8444 1.00119C85.7506 1.50651e-05 82.4188 -0.20022 79.325 0.73421C73.0778 2.40284 68.0801 9.54455 70.5194 16.8865Z" fill="black"/>
                                <path d="M79.8604 108.928C79.6819 108.928 79.6224 108.928 79.5034 108.994L79.8604 108.928Z" fill="black"/>
                                <path d="M79.8604 108.928C79.6819 108.928 79.6224 108.928 79.5034 108.994L79.8604 108.928Z" fill="black"/>
                                <path d="M66.6521 41.9827V29.1009C66.6521 18.1548 75.7551 9.21094 86.881 9.21094C92.4142 9.21094 97.4715 11.4135 101.16 15.0178C104.849 18.622 107.11 23.5611 107.11 29.0342V41.916" stroke="black" stroke-width="2" stroke-miterlimit="10"/>
                                <path d="M107.11 55.9321V70.8163C107.11 81.7624 98.0069 90.7063 86.881 90.7063C75.7551 90.7063 66.6521 81.7624 66.6521 70.8163V55.9321" stroke="black" stroke-width="2" stroke-miterlimit="10"/>
                                <path d="M74.8627 60.5376C80.5473 60.5376 85.1556 55.3679 85.1556 48.9907C85.1556 42.6136 80.5473 37.4438 74.8627 37.4438C69.178 37.4438 64.5697 42.6136 64.5697 48.9907C64.5697 55.3679 69.178 60.5376 74.8627 60.5376Z" stroke="black" stroke-width="2" stroke-miterlimit="10"/>
                                <path d="M98.84 60.5376C104.525 60.5376 109.133 55.3679 109.133 48.9907C109.133 42.6136 104.525 37.4438 98.84 37.4438C93.1553 37.4438 88.547 42.6136 88.547 48.9907C88.547 55.3679 93.1553 60.5376 98.84 60.5376Z" stroke="black" stroke-width="2" stroke-miterlimit="10"/>
                                <path d="M85.0962 48.6572H88.666" stroke="black" stroke-width="4" stroke-miterlimit="10"/>
                                <path d="M95.1511 88.9043H95.2101V109.795" stroke="black" stroke-width="2" stroke-miterlimit="10"/>
                                <path d="M80.3364 109.529V89.4385" stroke="black" stroke-width="2" stroke-miterlimit="10"/>
                                <path d="M74.8627 51.6604C76.177 51.6604 77.2425 50.4651 77.2425 48.9906C77.2425 47.5161 76.177 46.3208 74.8627 46.3208C73.5483 46.3208 72.4828 47.5161 72.4828 48.9906C72.4828 50.4651 73.5483 51.6604 74.8627 51.6604Z" fill="black"/>
                                <path d="M98.84 51.6604C100.154 51.6604 101.22 50.4651 101.22 48.9906C101.22 47.5161 100.154 46.3208 98.84 46.3208C97.5256 46.3208 96.4601 47.5161 96.4601 48.9906C96.4601 50.4651 97.5256 51.6604 98.84 51.6604Z" fill="black"/>
                                <path d="M65.2837 53.3291H64.0937C62.7848 53.3291 61.5949 53.9298 60.7024 54.8642C59.8695 55.8654 59.334 57.2003 59.334 58.6687C59.334 61.6055 61.4759 64.0083 64.0937 64.0083H66.4736" stroke="black" stroke-width="2" stroke-miterlimit="10"/>
                                <path d="M108.419 53.3291H109.609C112.227 53.3291 114.369 55.7319 114.369 58.6687C114.369 60.1371 113.833 61.472 112.941 62.4732C112.108 63.4076 110.918 64.0083 109.609 64.0083H107.229" stroke="black" stroke-width="2" stroke-miterlimit="10"/>
                                <path d="M66.5331 57.0669V60.2707H64.6292C63.8558 60.2707 63.2013 59.5365 63.2013 58.6688C63.2013 58.2016 63.3798 57.8011 63.6178 57.5341C63.8558 57.2671 64.2127 57.0669 64.6292 57.0669H66.5331Z" fill="black"/>
                                <path d="M107.229 60.2707V57.0669H109.133C109.906 57.0669 110.561 57.8011 110.561 58.6688C110.561 59.136 110.382 59.5365 110.144 59.8034C109.906 60.0704 109.549 60.2707 109.133 60.2707H107.229Z" fill="black"/>
                                <path d="M86.8811 60.0039C86.8811 60.0039 83.9062 65.3435 88.666 64.0086" stroke="black" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                                <path d="M81.5264 75.4219C81.5264 75.4219 86.2861 82.0296 92.8308 75.4219" stroke="black" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                                <path d="M70.2219 35.3083C70.2219 35.3083 73.4943 31.6374 79.1464 34.6409" stroke="black" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round"/>
                                <path d="M103.54 35.3083C103.54 35.3083 100.268 31.6374 94.6156 34.6409" stroke="black" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round"/>
                                <path d="M66.5331 27.6991C66.5331 27.6991 58.3225 20.5573 61.8923 11.8805C65.4621 3.20364 76.7665 7.87579 76.7665 7.87579C76.7665 7.87579 81.2883 29.5012 66.5331 27.6991Z" fill="black"/>
                                <path d="M25.7183 81.0289C25.0043 78.4258 23.9928 77.1577 23.4574 73.3532C22.3269 65.7443 22.7434 58.4691 19.9471 58.736C18.8166 58.8695 18.4596 60.2044 18.5191 60.9386L19.4116 72.9527C19.0546 74.3544 18.4001 73.8204 18.4001 73.8204C18.4001 73.8204 16.0798 63.1412 15.7823 61.2056C15.4848 59.3367 14.6518 58.2688 13.5214 58.4023C11.558 58.6025 12.3315 61.2723 12.51 62.2735L14.5923 75.222C14.7708 76.4902 13.5809 76.0897 13.5809 76.0897L8.94015 63.1412C8.40467 61.7396 7.39323 62.0733 7.39323 62.0733C5.54883 62.5405 6.26279 64.4094 6.26279 64.4094L10.2491 78.1588C10.2491 78.2256 10.2491 78.2923 10.2491 78.3591C10.3086 79.0933 9.47562 79.4937 9.11864 78.8263C7.8692 76.6904 5.42983 73.2864 3.40694 71.9515C2.39549 71.2841 1.68153 71.4176 1.26505 71.7513C0.848575 72.085 0.789078 72.6857 1.08656 73.153L8.52367 85.2338C10.2491 98.0488 17.2102 99.584 17.2102 99.584L21.375 117.872L27.5032 146.706L28.2766 150.377C28.9906 153.914 31.8464 156.451 35.0593 156.451H38.3316C40.652 156.451 42.2584 153.914 41.5444 151.512L26.7297 100.919L26.0752 96.5137C27.5032 94.7116 28.4551 90.9071 28.9311 88.1706C29.2286 86.7022 29.3476 85.1671 29.2286 83.6987C28.9906 80.0277 31.192 73.4199 31.192 73.4199C31.0135 72.1518 28.8716 73.2197 28.8716 73.2197C26.4917 74.1541 25.8967 78.4258 25.7183 80.7619C25.6588 81.7631 25.2423 82.6307 24.6473 83.2982C21.0775 87.2362 20.78 91.6413 20.78 91.6413" stroke="black" stroke-width="2" stroke-miterlimit="10"/>
                                <path d="M15.7228 61.2718C15.4253 59.4029 14.8898 58.0013 13.4619 58.4685C11.558 59.0692 12.272 61.3385 12.4505 62.3397" stroke="black" stroke-width="2" stroke-miterlimit="10"/>
                                <path d="M131.504 160.121V160.789H118.533L115.797 143.769V160.789H59.6315V151.111C59.6315 148.774 59.6315 146.438 59.691 144.102C58.4416 145.237 57.0732 146.171 55.4668 147.173L43.0319 156.517C42.9724 156.584 42.9129 156.584 42.8534 156.65C42.3179 156.984 41.723 157.184 41.0685 157.184L38.4826 157.294C38.4826 157.294 41.247 156.116 41.9015 153.18L37.4392 136.493C43.8054 130.553 54.0983 113.4 73.8513 109.862C74.6842 109.662 75.5767 109.462 76.5286 109.328C77.4211 109.195 78.3135 109.061 79.325 108.994L79.9794 108.928V109.061L79.6225 109.128C79.7415 109.128 79.801 109.128 79.9199 109.061H79.9794C80.0984 109.061 80.2174 109.061 80.3364 108.994H80.3959L80.9909 108.928V111.464C80.9909 111.798 81.1099 112.198 81.4074 112.532C82.2998 113.667 84.3227 114.534 86.7621 114.735C87.1786 114.801 87.595 114.801 88.0115 114.801C88.071 114.801 88.1305 114.801 88.1305 114.801H88.19C90.5699 114.735 92.7713 114 93.9017 112.932C94.2587 112.599 94.6157 112.131 94.6157 111.464V109.128L95.2106 109.261H95.3296C95.5081 109.261 95.6271 109.328 95.8056 109.328V109.128L96.5791 109.261C118.414 112.265 131.504 131.287 131.504 160.121Z" fill="url(#paint0_linear_2353_58)"/>
                                <path d="M42.9721 156.45L42.7939 156.584C42.8533 156.584 42.9127 156.517 42.9721 156.45Z" fill="black"/>
                                </g>
                                <defs>
                                <linearGradient id="paint0_linear_2353_58" x1="84.4715" y1="108.928" x2="84.4715" y2="160.789" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#9A2929"/>
                                <stop offset="1" stop-color="#340E0E"/>
                                </linearGradient>
                                <clipPath id="clip0_2353_58">
                                <rect width="131.25" height="160.789" fill="white" transform="translate(0.253662)"/>
                                </clipPath>
                                </defs>
                        </svg>
        </div>

        <div class="pt-4">
          <h4 class="coursesTitel">Courses</h3>
        </div>

        <div id="courseContainer" class="row mt-1">
          <p class="text-muted">Loading courses…</p>
        </div>

      </section>

      <section class="col-12 col-lg-5 pt-4 ms-5">
        <div class="mb-2 p-2 rounded Motiv-Container d-flex align-items-center justify-content-center">
            <img class="icon-1 me-2" src="../../template/img/icon.svg" alt="Icon" />

            <svg class="icon-2 me-2" fill="#FFD700" viewBox="-6.4 -6.4 76.80 76.80" data-name="Layer 1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff" stroke-width="0.00064" transform="matrix(1, 0, 0, 1, 0, 0)rotate(0)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g>
               <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><title></title><rect height="8" width="8" x="6" y="54"></rect><rect height="11" width="8" x="21" y="51"></rect><rect height="15" width="8" x="36" y="47"></rect><rect height="24" width="8" x="51" y="38"></rect><rect height="10" width="4.5" x="39" y="18"></rect><rect height="10" width="3" x="44.5" y="18"></rect><rect height="10" width="4.5" x="48.5" y="18"></rect><path d="M30.00146,17.9502l-.002.08007L32,18a14.02975,14.02975,0,0,1,.46582-3.59473l-1.93359-.51269A15.88629,15.88629,0,0,0,30.00146,17.9502Z"></path><path d="M46.01514,34,46,32a14.03255,14.03255,0,0,1-3.6084-.46924L41.877,33.46338A16.04749,16.04749,0,0,0,46,34Z"></path><path d="M41.81494,2.55322a15.905,15.905,0,0,0-3.85351,1.60987L38.96729,5.8916a13.90736,13.90736,0,0,1,3.36914-1.40771Z"></path><path d="M59.52686,21.62256l1.93261.51562A16.057,16.057,0,0,0,62,18v-.06055L60,18A14.04072,14.04072,0,0,1,59.52686,21.62256Z"></path><path d="M59.82861,9.94727l-1.72754,1.00781a13.92209,13.92209,0,0,1,1.41114,3.36767l1.92968-.52441A15.90937,15.90937,0,0,0,59.82861,9.94727Z"></path><path d="M57.27393,6.647a16.03853,16.03853,0,0,0-3.31934-2.53174l-.99512,1.73438a14.04964,14.04964,0,0,1,2.90528,2.21631Z"></path><path d="M30.54932,22.17041a15.91558,15.91558,0,0,0,1.606,3.855l1.7295-1.00488A13.883,13.883,0,0,1,32.481,21.65088Z"></path><path d="M50.0918,2.52832A16.03746,16.03746,0,0,0,46,2h-.04541L46,4a14.03208,14.03208,0,0,1,3.581.46191Z"></path><path d="M58.12939,24.99609a14.04627,14.04627,0,0,1-2.22558,2.89844l1.415,1.41406a16.06769,16.06769,0,0,0,2.542-3.31152Z"></path><path d="M54.01123,31.853,53.0083,30.12256a13.91241,13.91241,0,0,1-3.37158,1.40088l.51855,1.93164A15.93177,15.93177,0,0,0,54.01123,31.853Z"></path><path d="M33.85645,11.02832a14.04574,14.04574,0,0,1,2.21972-2.90283l-1.418-1.41113a16.07144,16.07144,0,0,0-2.53515,3.31591Z"></path><path d="M34.70312,29.33008a16.04284,16.04284,0,0,0,3.31348,2.53857l.999-1.73242a14.06851,14.06851,0,0,1-2.90039-2.22217Z"></path><path d="M14.27051,41H24a1.00071,1.00071,0,0,0,.6001-.2002l6.00311-4.50231-.58954,3.538,1.97266.3291,1-6a1.0001,1.0001,0,0,0-.82178-1.15088l-6-1-.3291,1.97266,3.69519.61572L23.6665,39H14a.998.998,0,0,0-.50391.13623l-12,7,1.00782,1.72754Z"></path><path d="M47.5,12l1.56641-2.16748a1.07439,1.07439,0,0,1,1.88232,1.0332L50,12H48.5v5H55V12H52.618l.11981-.23975a3.07454,3.07454,0,0,0-5.38623-2.957l-1.31982,2.2-1.31983-2.2a3.07456,3.07456,0,0,0-5.38623,2.957L39.4455,12H37v5h6.5V12H42l-.88525-1.13428a1.0744,1.0744,0,0,1,1.88232-1.0332L44.5,12v5h3Z"></path>
               </g>
             </svg>
            <span class="h2 mb-0 Motiv-sentence">FlashUT Leader! Keep it up!</span>
        </div>


        <div class="d-flex justify-content-between mt-2">

            <div  class="p-1 rounded text-center flex-fill me-2 statContainer">
              <div style="font-family: 'Baloo Bhai', sans-serif; 
                  font-weight: 400;" id="NoCourses" class="fs-1">0</div>
              <strong s class="h5">Available Courses</strong>
            </div>

            <div class="p-1 rounded text-center flex-fill ms-2 statContainer">
              <div style="font-family: 'Baloo Bhai', sans-serif; 
                  font-weight: 400;" id="NoPending" class="fs-1">0</div>
              <strong   class="h5">Pending Flashcards</strong>
            </div>

        </div>

        <div class="mb-2 mt-3 rounded">
          <h4 class="your-statistics py-1">Your Statistics</h4>
          
          <div class="btn-group mb-3" role="group">
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

          <canvas id="flashcardStatsChart"></canvas>

      
        </div>

        <div class="row g-2 align-items-stretch mt-3">
            <div class="col-6">
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

            <div class="col-6">
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
            </div>
          </div>
      </section>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>

  <script>

  document.addEventListener("DOMContentLoaded", function(){
    function loadCourses(){
      fetch(`../../controllers/student/studentDashboard.php`)
        .then(r=>r.json())
        .then(data => {
          document.getElementById("NoCourses").textContent = data.total_courses;


          let motivContainer = document.querySelector(".Motiv-Container");
          let motivText = motivContainer.querySelector(".Motiv-sentence");
          let motivIcon = motivContainer.querySelector("img");
          let motivSVG = motivContainer.querySelector("svg");

          let iconLeader = document.getElementById("iconLeader");
          let iconALT  = document.getElementById("iconALT");

        if (data.is_top_scorer) {
            motivText.textContent = "FlashUT Leader! Keep it up!";
            motivIcon.style.display = "inline"; 
            iconALT.style.display= "none"; 
            motivSVG.style.display="none";
        } else {
            motivText.textContent = "Keep going! Review your flashcards daily";
            motivText.style.fontSize = "26px";
            motivIcon.style.display = "none";
            iconLeader.style.display= "none"; 
  
        }



          let container = document.getElementById("courseContainer");
          container.innerHTML = "";
          if(data.total_courses===0){
            container.innerHTML = '<p class="text-muted">No courses found.</p>';
            return;
          }
                container.innerHTML = ""; 
                const currentSemester = "46-2";  
                let filteredCourses = data.courses.filter(c => c.semester_code === currentSemester);
                filteredCourses.slice(0, 5).forEach(course => {  
                    container.insertAdjacentHTML("beforeend", `
                <div class="col-12 mb-0.5">
                    <div class="course">
                      <img
                        src="../../template/imgCourses/${course.image_path}"
                        alt="Course image"
                        class="course-pic"
                      />

                      <div class="course-name">
                        <strong>${course.course_name}</strong> <br>
                        <span class="caption">D. ${course.firstName} ${course.lastName}</span>
                              

                      </div>

                      <div style="flex:1.2;" class="sectionContainer">

                      <svg class="vector" fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 30 30" xml:space="preserve">
                      <g id="SVGRepo_bgCarrier" stroke-width="3.5"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g>
                       <path d="M29.936,1.153H0v20.045h10.91l-3.76,7.584h2.899l1.288-2.613h6.72l1.287,2.613h2.932l-3.787-7.583h11.445V1.153H29.936z M12.292,24.234l1.496-3.035h1.819l1.496,3.035H12.292z M28.646,19.908H1.29V2.443h27.356V19.908z"></path> <rect x="22.631" y="17.149" width="2.191" height="1.859"></rect> </g> </g> </g>
                       </svg>
                        
                          <span class="caption"> ${course.section_name}</span>
                      </div>
                      
                      

                      <div class="sectionContainer">

                            <svg class="vector"  viewBox="0 0 50.00 50.00" id="a" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="black" transform="matrix(1, 0, 0, 1, 0, 0)" stroke-width="1.7"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.288"></g>
                                <g id="SVGRepo_iconCarrier"><defs></defs><rect class="b" x="10.0372" y="11.3298" width="21.0638" height="32.1702" rx="2.5612" ry="2.5612"></rect><path class="b" d="m13.4521,11.3298v-.8537c0-1.4145,1.1467-2.5612,2.5612-2.5612h15.9415c1.4145,0,2.5612,1.1467,2.5612,2.5612v27.0479c0,1.4145-1.1467,2.5612-2.5612,2.5612h-.8537"></path><path class="b" d="m16.8989,7.9149v-.8537c0-1.4145,1.1467-2.5612,2.5612-2.5612h15.9415c1.4145,0,2.5612,1.1467,2.5612,2.5612v27.0479c0,1.4145-1.1467,2.5612-2.5612,2.5612h-.8856"></path>
                                </g>
                            </svg> 
                                
                          <span class="caption"> ${course.total_flashcards}</span>
                      </div>


                     
                        <a
                          href="groupsOfCourse.php?section_id=${course.section_id}"
                          class="view-course-btn"
                        >
                          View
                        </a>
                    </div>
                  </div>
                `);
                });
              }); 
           }
    // document.getElementById("allCoursesBtn").addEventListener("click", e=>{
    //   e.preventDefault();
    //   loadCourses("all");
    //   e.target.classList.add("active");
    //   document.getElementById("recentCoursesBtn").classList.remove("active");
    // });
    // document.getElementById("recentCoursesBtn").addEventListener("click", e=>{
    //   e.preventDefault();
    //   loadCourses("recent");
    //   e.target.classList.add("active");
    //   document.getElementById("allCoursesBtn").classList.remove("active");
    // });
    loadCourses();
  });


  fetch(`../../controllers/student/studentDashboard.php?state=2`)
      .then(r=>r.json())
      .then(data=>{
        document.getElementById("NoPending").textContent=data.pending;
      });

  //STATS LOGIC
  let statsChart;
  function loadStats(period="weekly"){
    fetch(`../../controllers/student/studentDashboard.php?stats=1&period=${period}`)
      .then(r=>r.json())
      .then(data=>{
        const labels = Object.keys(data.stats.viewed);
        const viewed = Object.values(data.stats.viewed);
        const added  = Object.values(data.stats.added);
        const ctx = document.getElementById("flashcardStatsChart").getContext("2d");
        if(statsChart) statsChart.destroy();
        statsChart = new Chart(ctx,{
          type:"bar",
          data:{
            labels,
            datasets:[
              { label:"Viewed",  data:viewed, backgroundColor:"rgba(150,33,33,0.7)" },
              { label:"Added",   data:added,  backgroundColor:"rgba(93,103,109,0.53)" },
            ]
          },
          options:{ responsive:true, scales:{ y:{ beginAtZero:true } } }
        });
      });
  }
  document.addEventListener("DOMContentLoaded", ()=> loadStats());

  function loadFavoriteGroupCount(){
    fetch('../../controllers/student/favoriteGroups.php')
      .then(r=>r.json())
      .then(d=>{
        if(d.success){
          document.getElementById("favoriteCount").textContent = `${d.count} Groups`;
        }
      });
  }
  document.addEventListener("DOMContentLoaded", loadFavoriteGroupCount);
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