<?php 
  include "../partials/header.php";
?>

  
  <title>Login - FlashUT</title>

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />

  <!-- <link rel="stylesheet" href="../template/css/login-page.css" /> -->

  <style>
    

    .promo-panel {
      background: linear-gradient(180deg, #9A2828 0%, #340E0E 100%);
      color: #fff;
    }
    .promo-panel a{
      color: #fff;
      text-decoration: none;
    }

    .full-vh {
      min-height: 100vh;
    }

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
    .form-container h2{
      background: linear-gradient(90deg, #C4332F 0%, #5E1817 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      font-size: 2rem;
      padding-bottom: 0.4rem; 
      
    }

    .form-container .text-center a {
      color: #9A2828;
    }
  </style>


  <div class="container-fluid p-0">
    <div class="row gx-0 full-vh">
      
      <div class="col-12 col-lg-6 promo-panel 
                  d-flex flex-column 
                  justify-content-center 
                  align-items-center 
                  text-center p-4">
        <h1 class="mb-5" style="font-size: 3.6rem;">
        <a  style="font-weight: 700;"href="../index.php"><strong>FlashUT</strong></a> 
        </h1>
        <h1 class="mb-2" style="font-size:2rem;">
          Ready to Flash Today?
        </h1>
        <p class="lead mb-3">
          Sign in to continue your learning journey!
        </p>
       
      </div>

      <div class="col-12 col-lg-6 
                  d-flex flex-column 
                  justify-content-center 
                  align-items-center p-4">
        <div class="form-container 
                    bg-white p-4 
                    rounded shadow-sm">
          
          <h2 class="mb-4 text-center">Login</h2>

          <?php if (isset($_GET['error']) || isset($_GET['message'])): ?>
            <div class="alert alert-danger">
              <?= htmlspecialchars($_GET['error']??$_GET['message']) ?>
            </div>
          <?php endif; ?>
          <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
              <?= htmlspecialchars($_GET['success']) ?>
            </div>
          <?php endif; ?>

          <form action="../controllers/login.php" method="POST">
            <div class="form-floating mb-3">
              <input
                type="text"
                id="academicID"
                name="academicID"
                class="form-control"
                placeholder="Student or Admin ID"
                required
              />
              <label for="academicID">Student / Admin ID</label>
            </div>

            <div class="form-floating mb-4">
              <input
                type="password"
                id="password"
                name="password"
                class="form-control"
                placeholder="Password"
                required
              />
              <label for="password">Password</label>
            </div>

            <button class="btn btn-primary w-100 mb-3" type="submit">
              Sign In
            </button>

            <p class="text-center mb-0">
              Don’t have an account? 
              <a href="register.php">Register now!</a>
            </p>
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