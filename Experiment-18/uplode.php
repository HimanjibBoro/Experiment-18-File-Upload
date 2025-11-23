<?php
require "db.php";   

if (isset($_POST['upload'])) {

    $targetDir = "uploads/";


    $fileName = basename($_FILES["profile"]["name"]);
    $targetFile = $targetDir . time() . "_" . $fileName;

    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $fileSize = $_FILES["profile"]["size"];

    $allowedTypes = ["jpg", "jpeg", "png", "gif"];

    if (!in_array($fileType, $allowedTypes)) {
        die("Error: Only JPG, JPEG, PNG and GIF files are allowed.");
    }
    if ($fileSize > 2 * 1024 * 1024) {
        die("Error: File size should be less than 2MB.");
    }

    if (move_uploaded_file($_FILES["profile"]["tmp_name"], $targetFile)) {

        $sql = "UPDATE users SET profile_pic = ? WHERE id = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $targetFile);

        if ($stmt->execute()) {
            echo "Upload successful!<br>";
            echo "<img src='$targetFile' width='150'>";
        } else {
            echo "Database error!";
        }

    } else {
        echo "Error: File could not be uploaded.";
    }
}
?>
