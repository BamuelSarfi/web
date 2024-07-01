<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Player</title>
    <style>
       
       body{
    overflow-x: hidden;
    
    background-color:#008F8C;
}
#container{
    width:100%;
    height: 500px;
    margin-left:0px;
    padding-left:0px;
    overflow: "hidden";
}
#container h2{
    margin-top:25vh;
}
video {
    padding: 17px;
    margin-left: 20px;
    margin-top: 20px;
    border-radius: 24px;
    height: 551px;
    width: 175vh;
    background-color: #0d4241;
    margin-top: 3vh;
}
#container{
    margin:0 auto;
    padding: 0;
    font-family: monospace;
    text-align: center;
    height:200px;
}
#container ul{
    font-family: cursive;
    text-align: left;
    width:25%;
    
}
#header{
    background-color: #0d4241;
    width:100% + 24px;
    margin: 0;
    padding: 24px;
    color:white;
    margin:0px;
}
#glow{
    
    color:white;
    position: absolute;
    box-shadow: 0rem 0rem 12rem 3rem ;
}
/*container*/
#container2 {
    margin: 0;
    padding: 0;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 0.5fr));
    width: 100%;
    height:300px;
    overflow-y: "hidden";
    margin-bottom: 12px;
    
}


#container2 p {
    background-color: #0d4241;
    width: 300px;
    height: 200px;
    margin: 12px;
    text-align: center;
    line-height: 200px; /* Adjusted line-height */
    border-radius: 24px;
    overflow-y: auto;
}
@media only screen and (max-width: 664px) {
    #container2 p {
        width: 92vw;
        margin-right:24px;
    }
    video{
        margin-top:700px;
        width:94vh;
        height:503px;
    }
    body{
        overflow-x:"hidden";
    }

}
#closeBtn {
    position: relative;
    top: -551px;
    right: -170vh;
    background-color: #008F8C;
    color: #0d4241;
    border: none;
    border-radius: 12px;
    width: 30px;
    height: 30px;
    font-size: 16px;
    
}
#closeBtn:hover{
    background-color: #0d4241;
    color:#008F8C;
    cursor: pointer;
    transition-duration:0.3s;
}
button{
    margin-bottom:20px;
}

    </style>
</head>
<body>
    <div id="glow"></div>
    <div id="container">
    <div id = "header">
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

//clunky code that does work
if (isset($_SESSION['name']) && isset($_SESSION['user_name'])) {
    $uname = $_SESSION['user_name'];
    $name = $_SESSION['name'];
    //$id = $_SESSION['id'];

    echo "<h1>Welcome, <a href = './login/home.php' style = ' color:white;'> $name</a></h1>";
    if($_SESSION['id'] != 1){
    }else {   
    ?>
        //fix link
        <a href = "#"><p style = "text-decoration:none; color:white; text-align:left;">Upload a video</p></a>
<?php
    }    
} else {
    echo '<a href="./login/index.php"><p style = "text-decoration:none; color:white; text-align:left;">Login</p></a>';
}
?>

        <h1>VIDEO PLAYER</h1><br><h3 style = "color:green;">made by @bamuelSarfi</h3></div><a href = "../index.html"><p>Return...</p></a>
        <div id="container2" data-mouse-down-at="0">
        <?php 
                $directory = __DIR__ . "/videos/";
                $files = scandir($directory);

                foreach ($files as $file) {
                    if ($file != "." && $file != "..") {
                        $filePath = $directory . $file; // Full path to the file
                        echo "<div id='card'><p draggable='false'><a href='player/videos/$file' data-src='$file'>", substr($file, 0, 30), "</a></p></div>" . PHP_EOL;
                    }
                }
        ?>

                
        <!-- Add more video links as needed -->
            
        </div>
    <div id="nothing" style="width:100%;height:30px;"></div>
    
    <div id="videoPlayer" style = "margin-bottom: 20px;"></div>

</div>
    <script>
        const container2 = document.getElementById('container2');
        const glow = document.getElementById('glow');
        const colours = ["white", "green", "purple"];
        var videoPlayerDiv = document.getElementById("videoPlayer");
        max = colours.length;
        let click = 0;

        document.addEventListener("DOMContentLoaded", function() {
            var videoList = document.getElementById("container2");

            function deLoadVideoCards(){
              function close(){ 
                const button = document.addEventListener('closeBtn');
                videoPlayerDiv.innerHTML = ``;
                console.log("s")
               }
            }
        
            videoList.addEventListener("click", function(event) {
                event.preventDefault();
                if (event.target.tagName === "A") {
                    var videoSrc = "videos/" + event.target.getAttribute("data-src");
                    var videoName = extractFileName(videoSrc);
                    loadVideoPlayer(videoSrc, videoName);
                }
            });

            function extractFileName(url) {
                var index = url.lastIndexOf("/") + 1;
                return url.substr(index);
            }

            function loadVideoPlayer(videoSrc, videoName) {
                
                
                videoPlayerDiv.innerHTML = `
                    <h2>${videoName}</h2>
                    
                    <button id="closeBtn">&times;</button><video controls>
                        <source src="${videoSrc}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                `;
               
                closeBtn.addEventListener('mousedown', () => {
                    videoPlayerDiv.innerHTML = ``;
                })
              
            }
        });

        ///////glow///////////////////////////////////////////////////////

        function getRandomInt(max) {
            return Math.floor(Math.random() * (max));
        }

        console.log(getRandomInt(max))



        //track

        window.addEventListener("mousedown", function() {
            glow.style.color = colours[getRandomInt(max)]
            click++;
        })

        window.addEventListener('mousemove', (e) => {
            const mouseX = e.clientX;
            const mouseY = e.clientY;
        
            glow.style.left = `${mouseX}px`;
            glow.style.top = `${mouseY}px`;
        
            document.body.appendChild(glow);
        })

        //upload
        document.addEventListener("DOMContentLoaded", function() {
    var videoList = document.getElementById("container2");
    var videoPlayerDiv = document.getElementById("videoPlayer");

    videoList.addEventListener("click", function(event) {
        event.preventDefault();
        if (event.target.tagName === "A") {
            var videoSrc ="../player/videos/" + event.target.getAttribute("data-src");
            var videoName = extractFileName(videoSrc);
            loadVideoPlayer(videoSrc, videoName);
        }
    });

    function extractFileName(url) {
        var index = url.lastIndexOf("/") + 1;
        return url.substr(index);
    }

    function loadVideoPlayer(videoSrc, videoName) {
        videoPlayerDiv.innerHTML = `
            <h2>${videoName}</h2>
            <button id="closeBtn">&times;</button>
            <video controls>
                <source src="${videoSrc}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        `;
        var closeBtn = document.getElementById("closeBtn");
        closeBtn.addEventListener('click', () => {
            videoPlayerDiv.innerHTML = ``;
        });
    }

});  

        
    </script>
</body>
</html>
