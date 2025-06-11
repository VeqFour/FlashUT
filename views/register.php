<?php 
  include "../partials/header.php";
?>

  <title>Registration - FlashUT</title>

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />

  <!-- <link rel="stylesheet" href="../template/css/register-page.css" /> -->

  <style>
    

    .promo-panel {
      background: linear-gradient(180deg, #9A2828 0%, #340E0E 100%);
      color: #fff;
    }
    .promo-panel a{
      color: #fff;
      text-decoration: none;
    }

    /* Center content vertically */
    .full-vh {
      min-height: 100vh;
    }

    /* Constrain the form’s max width */
    .form-container {
      max-width: 480px;
      width: 100%;
    }

    .btn-primary {
      background-color: #9A2828;
      border-color: #9A2828;
      --bs-btn-hover-bg: rgb(94,19,19);
      --bs-btn-hover-border-color: rgb(94,19,19);
      --bs-btn-active-color: #9A2828 ;
    --bs-btn-active-bg:white;
    --bs-btn-active-border-color:rgba(30, 31, 32, 0.68);
    }
    .form-container .text-center a {
  color: #9A2828;
}

    .form-floating>label{
      font-weight: 200;
      font-size: 16px;

      
    }
    .form-container h2{
      background: linear-gradient(90deg, #C4332F 0%, #5E1817 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  font-size: 2rem;
  padding-bottom: 0.4rem; 

    }
    
  /* … existing overrides … */

  

  </style>
</head>
<body class="bg-light">

  <div class="container-fluid p-0">
    <div class="row gx-0 full-vh">
      
      <div class="col-12 col-lg-6 promo-panel d-flex flex-column justify-content-center align-items-center text-center p-4">
        <h1 style="font-size: 30px;" class="mb-3">Welcome to <a  style="font-weight: 900;"href="../index.php"><strong>FlashUT</strong></a> </h1>
        <p class="lead mb-4">Make studying easier, faster &amp; more fun!</p>
      </div>

      <div class="col-12 col-lg-6 d-flex flex-column justify-content-center align-items-center p-4">
        <div class="form-container bg-white p-4 rounded shadow-sm">
          
          <h2 class="mb-4 text-center">Registration</h2>

          <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
              <?= htmlspecialchars($_GET['error']) ?>
            </div>
          <?php endif; ?>

          <form action="../controllers/register.php" method="POST">
            <div class="form-floating mb-3">
              <input
                type="text"
                id="firstName"
                name="firstName"
                class="form-control"
                placeholder="First Name"
                required
              />
              <label for="firstName">First Name</label>
            </div>

            <div class="form-floating mb-3">
              <input
                type="text"
                id="lastName"
                name="lastName"
                class="form-control"
                placeholder="Last Name"
                required
              />
              <label for="lastName">Last Name</label>
            </div>

            <div class="form-floating mb-3">
                <input 
                    type="number" 
                    id="studentID" 
                    name="academicID"
                    class="form-control" 
                    placeholder="Academic ID"
                    required 
                    pattern="\d{10}" 
                    minlength="10" 
                    maxlength="10"
                    title="Academic ID must be exactly 10 digits"
                />
                <label for="studentID">Academic ID</label>
            </div>

            <div class="form-floating mb-3">
  <select id="department" name="department_id" class="form-select" required>
    <option value="">Select Your College</option>
    <?php 
    require_once "../includes/db.php"; 
    $deptResult = mysqli_query($conn, "SELECT department_id, department_name FROM departments");
    while ($dept = mysqli_fetch_assoc($deptResult)) {
        echo '<option value="' . htmlspecialchars($dept['department_id']) . '">' . htmlspecialchars($dept['department_name']) . '</option>';
    }
    ?>
  </select>
  <label for="department">College</label>
</div>

            <div class="form-floating mb-3">
              <input
                type="email"
                id="email"
                name="email"
                class="form-control"
                placeholder="University Email"
                required
              />
              <label for="email">University Email</label>
            </div>

            <div class="form-floating mb-3">
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    placeholder="Password"
                    required
                    minlength="8"
                    title="Password must be at least 8 characters"
                />
                <label for="password">Password</label>
            </div>

            <div class="form-floating mb-4">
                <input
                    type="password"
                    id="confirm_password"
                    name="confirm_password"
                    class="form-control"
                    placeholder="Confirm Password"
                    required
                    minlength="8"
                    title="Password must be at least 8 characters"
                />
                <label for="confirm_password">Confirm Password</label>
            </div>

            <button class="btn btn-primary w-100 mb-3" type="submit">
              Register
            </button>

            <div class="text-center">
              Already have an account?
              <a href="login.php">Log in</a>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    defer
  ></script>

  

</body>
</html>