
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$data['page_title'] . " | " . "Quiz Bee System"?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
   
    <!--<link rel="stylesheet" href="<?=ASSETS?>quizbee/css/main_corner.css" />-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=ASSETS?>quizbee/css/audiance_style.css" />

</head>

<body style="min-height: 100vh; display: flex; flex-direction: column; background: linear-gradient(to right, #2d388a, #00aeef), url('<?= ASSETS ?>quizbee/images/7951512.jpg'); background-blend-mode: multiply; background-size: cover;">
    <div class="container mx-auto p-4 flex flex-col min-h-screen">
        <div class="flex-grow flex flex-col items-center justify-center">
            <div class="w-full max-w-4xl relative">
                <!-- Placeholder for Leaderboard -->
                <div class="leaderboard-placeholder">
                    <!-- Leaderboard will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>
</body>
<?php $this->view("base/footer_realtime_audiance", $data); ?>
