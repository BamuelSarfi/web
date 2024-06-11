<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    
    if(isset($_SESSION['id']) && isset($_SESSION['user_name'])){
    ?>
<!-- Video Upload Form -->
    <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="videoFile" accept="video/*" required>
        <button type="submit">Upload Video</button>
    </form>
    
    <?php
    }else{
        header("Location: ../index.php?youaintslick");
    }?>
    <a href = "../index.php">Go Back</a>

    <script defer>

    // Upload form submission
    document.getElementById("uploadForm").addEventListener("submit", function(event) {
        event.preventDefault();
        var formData = new FormData(this);

        fetch("../upload.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                addVideoCard(data.videoName, data.videoSrc);
            } else {
                alert("Video upload failed: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error uploading video:", error);
        });
    });

    


    </script>
</body>
</html>