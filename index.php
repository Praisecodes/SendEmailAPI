<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");

    require_once "./libs/Exception.php";
    require_once "./libs/PHPMailer.php";
    require_once "./libs/SMTP.php";

    use PHPMailer\PHPMailer\PHPMailer;

    $ContentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : "not set";

    if($ContentType === "application/json"){
        $contents = trim(file_get_contents("php://input"));

        $decoded = json_decode($contents, true);

        
    }
    else{
        echo json_encode([
            "Please set Content-Type to application/json"
        ], true);
    }

?>