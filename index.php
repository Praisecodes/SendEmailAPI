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

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "cmancoder@gmail.com";
        $mail->Password = getenv("PASSWORD");
        $mail->Port = 465;
        $mail->SMTPSecure = "ssl";

        $mail->isHTML(true);
        $mail->setFrom($decoded["Email"], $decoded["Name"]);
        $mail->addAddress("cmancoder@gmail.com");
        $mail->Subject = "Message From " . $decoded["Name"] . "(Portfolio)";
        $mail->Body = $decoded["Body"] . "<br/><br/>Reply to: " . $decoded["Email"];

        if($mail->send()){
            echo json_encode([
                "Success"
            ], true);
        }
        else{
            echo json_encode([
                "Error ". $mail->ErrorInfo
            ], true);
        }

    }
    else{
        echo json_encode([
            "Please set Content-Type to application/json"
        ], true);
        header("Location: https://praisecodes.netlify.app");
    }

?>