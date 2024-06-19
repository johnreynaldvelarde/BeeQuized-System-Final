<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$data['page_title'] . " | " . "Quiz Bee System"?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?=ASSETS?>quizbee/css/main_corner.css" />
    <link rel="stylesheet" href="<?=ASSETS?>quizbee/css/dashboard_style.css" />
  
</head>
<body class="size-1140" >
   <div id="page-wrapper">
    <header role="banner" class="position-absolute margin-top-30 margin-m-top-0 margin-s-top-0">
      <nav class="navbar navbar-expand-lg fixed-top">
          <div class="container-fluid">
            <a class="navbar-brand me-auto" href="#">BeeQuized</a>
            <div
              class="offcanvas offcanvas-end"
              tabindex="-1"
              id="offcanvasNavbar"
              aria-labelledby="offcanvasNavbarLabel"
            >
              <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
                  Quiz Bee System
                </h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="offcanvas"
                  aria-label="Close"
                ></button>
              </div>
              <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?=ROOT?>controller_main">Event Creation</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link mx-lg-2" href="<?=ROOT?>controller_history">Event History</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link mx-lg-2" href="<?=ROOT?>controller_leaderboards">Leaderboards</a>
                  </li>
                  <!--
                  <li class="nav-item">
                    <a class="nav-link mx-lg-2" href="#">Portfolio</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link mx-lg-2" href="#">About</a>
                  </li> -->
                </ul>
              </div>
            </div>

             <!-- User Name and Profile Image -->
            <div class="d-flex align-items-center">

              <?php if (isset($_SESSION['user_name'])): ?>
                <span class="user-name me-2">Hi, <?=$_SESSION['user_name']?></span>
              <?php endif; ?>

              <a href="#" class="profile-image">
                <img src="<?=ASSETS?>quizbee/images/default_profile.png" alt="Profile" style="width:40px; height:40px; border-radius:50%;" onclick="toggleMenu()">
              </a>
            </div>
            <div class="sub-menu-warp" id="subMenu">
              <div class="sub-menu">
                <div class="user-info">
                  <img src="<?=ASSETS?>quizbee/images/default_profile.png" alt="Profile" style="width:40px; height:40px; border-radius:50%;">
                  <h3><?=$_SESSION['user_name']?></h3>
                </div>
                <hr>
                <a href="<?=ROOT?>logout" class="sub-menu-link">
                  <img src="<?=ASSETS?>quizbee/images/logout.png">
                  <p>Logout</p>
                  <span>></span>
                </a>
              </div>
            </div>
            <button class="navbar-toggler pe-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          </div>
      </nav>
    </header>
    
    <!-- End Navbar -->

