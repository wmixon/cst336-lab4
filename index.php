<?php
    session_start();
    $backgroundImage = "./img/sea.jpg";
    $_SESSION['flag'];
    
    if($_GET['keyword'] != '' && $_GET['category'] != '') {
        $_GET['search'] = $_GET['keyword'];
    }
    else if($_GET['keyword'] != '') {
        $_GET['search'] = $_GET['keyword'];
    }
    else if($_GET['category'] != '') {
        $_GET['search'] = $_GET['category'];
    }
    
    if(isset($_GET['search'])){
        include 'api/pixabayAPI.php';
        $imageURLs = getImageURLs($_GET['search'], $_GET['layout']);
        $backgroundImage = $imageURLs[array_rand($imageURLs)];
        $_SESSION['flag'] = 0;
    }
    else {
        $_SESSION['flag']++;
    }
    unset($_GET['search']);
        // Display Carousel Here
?>

<!DOCTYPE html>
<html>
    <head>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <style>
            @import url("./css/styles.css"); 
        </style>
        <style>
            body {
                background-image: url("<?=$backgroundImage?>");
                background-size: 100% 100%;
                background-attachment: fixed;
            }
        </style>
    </head>
    <body>
        <br>
        <?php
        if($_GET['keyword'] == '' && $_GET['category'] == ''){
            if($_SESSION['flag'] > 1){
                echo "<h2> You must type a keyword or select a category </h2>";
            }
            else {
                echo "<h2> Type a keyword to display a slideshow <br /> with random images from Pixabay.com </h2>";
                $_SESSION['flag']++;
            }
        }
        else if(isset($imageURLs)) {
        ?>
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators Here -->
            <ol class="carousel-indicators">
                <?php
                for ($i = 0; $i < 7; $i++){
                    echo "<li data-target='#carousel-example-generic' data-slide-to='$i'";
                    echo ($i == 0)?" class='active'": "";
                    echo "></li>";
                }
                ?>
            </ol>
            
            <!-- Wrapper for Images -->
            <div class="carousel-inner" role="listbox">
                <?php
                    for ($i = 0; $i < 7; $i++) {
                        do {
                            $randomIndex = rand(0,count($imageURLs));
                        }
                        while (!isset($imageURLs[$randomIndex]));
                        
                        echo '<div class="item ';
                        echo ($i == 0)?"active": "";
                        echo '">';
                        echo '<img src="' . $imageURLs[$randomIndex] . '" style="max-height: 500x; max-width: 800px;">';
                        echo '</div>';
                        unset($imageURLs[$randomIndex]);
                    }
                ?>
            </div>
            <!-- Controls -->
              <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
        </div>
        <?php
        } else {
            echo "<h2> Type a keyword to display a slideshow <br /> with random images from Pixabay.com </h2>";
        }
        ?>
        <form id="f1">
            <input type="text" name="keyword" placeholder="Search">
            <input type="radio" id="lhorizontal" name="layout" value="horizontal">
            <label for="Horizontal"></label><label for="lhorizontal"> Horizontal</label>
            <input type="radio" id="lverticle" name="layout" value="vertical">
            <label for="Vertical"></label><label for="lverticle"> Verticle</label>
            <select name="category">
                <option value="">Select One</option>
                <option value="ocean">Sea</option>
                <option>Taco</option>
                <option>Salt</option>
                <option>Yellow</option>
                <option>Loaf</option>
                <option>Money</option>
                <option>Trump</option>
            </select>
            <input type="submit" value="Submit">
        </form>
        
        
        
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>