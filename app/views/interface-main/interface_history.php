<?php $this->view("base/header_main",$data);?>

<body>
     <!-- Hero Section -->
     <section class="hero-section">
      <div class="container d-flex align-items-center justify-content-center fs-1">
        <h1>Event History</h1>
      </div>
    </section>
    <!-- End Hero Section -->
    
    <script>
      document.addEventListener("DOMContentLoaded", function() {
            let currentPath = window.location.pathname;
            let navLinks = document.querySelectorAll(".nav-link");

            navLinks.forEach(link => {
                if (link.getAttribute("href").includes(currentPath)) {
                    link.classList.add("active");
                } else {
                    link.classList.remove("active");
                }
            });
        });
    </script>
</body>

<?php $this->view("base/footer_main", $data); ?>
