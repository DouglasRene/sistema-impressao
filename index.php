<?php require_once __DIR__."/assets/templates/header.php"; ?>  

<!--CONTENT--> 

<main class="main_content">
    <?php

    $file = filter_input(INPUT_GET, "file", FILTER_SANITIZE_SPECIAL_CHARS);
    if((empty($file) && $userData) || ($file == "login" && $userData)) {
        $file = "home";
    }
    if (empty($file)) {
        require __DIR__ . "/views/login.php";
    } elseif (empty($file)) {
        require __DIR__ . "/views/home.php";
    } elseif ($file && file_exists(__DIR__ . "/views/{$file}.php")) {
        require __DIR__ . "/views/{$file}.php";
    } else {
        require __DIR__ . "/views/404.php";
    }
    ?>
</main>

<?php require_once __DIR__."/assets/templates/footer.php"; ?>
