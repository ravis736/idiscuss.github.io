<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <!-- bootstrap@5.1.0 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <!-- bootstrap@4.6.0 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>iDiscuss- ThreadList</title>
</head>

<body>
    <?php include 'partial/_dbconnect.php'; ?>
    <?php include 'partial/_header.php'; ?>

    <?php
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
    $result = mysqli_query($conn, $sql);
    while ($row=mysqli_fetch_assoc($result)){
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
    }
    
    ?>

    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method=="POST") {
        //insert comment into db
        $comment = $_POST['comment'];
        $sno = $_POST['sno'];
        $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if ($showAlert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your comment has been added.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                 </div>';
        }
    }
    ?>

    <!-- category container -->
    <div class="container my-2">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo "$title";?></h1>
            <p class="lead"><?php echo "$desc";?></p>
            <hr class="my-4">
            <p>No Spam / Advertising / Self-promote in the forums.
                Do not post copyright-infringing material.
                Do not post “offensive” posts, links or images.
                Do not cross post questions.
                Remain respectful of other members at all times.</p>
            <p> Posted by: <b>Harry</b></p>
        </div>

        <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
            echo '<div class="container">
            <h2>Post a comment</h2>
            <form action="'.$_SERVER["REQUEST_URI"].'" method="POST">
                <div class="form-group">
                    <label for="desc">Type your comment</label>
                    <textarea class="form-control" id="comment" name="comment" style="height: 100px"></textarea>
                    <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
                </div>
                <button type="submit" class="btn btn-success">Post comment</button>
            </form>
        </div>';
        }
        else {
            echo '<div class="container">
            <h2>Post a comment</h2>
            <p class="lead">You are not loggedin. Please login to post comments.</p>
            </div>';
        }
        ?>


        <div class="container">
            <h1 class="py-2">Discussion</h1>
            <?php
            $id = $_GET['threadid'];
            $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
            $result = mysqli_query($conn, $sql);
            $noResult = true;
            while ($row=mysqli_fetch_assoc($result)){
                $noResult = false;
                $id = $row['comment_id'];
                $content = $row['comment_content'];
                $commentTime = $row['comment_time'];
                $comment_by = $row['comment_by'];
                $sql2 = "SELECT user_email FROM `users` WHERE sno=$comment_by";
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($result2);
            
            echo '<div class="d-flex my-3">
                <div class="flex-shrink-0">
                    <img src="img/userdefault.png" width="64px" alt="...">
                </div>
                <div class="flex-grow-1 ms-3">
                <p class="fw-bold my-0">Comment by: '.$row2['user_email'].' at '.$commentTime.' </p>
                    '.$content.'
                </div>
            </div>';
            }

            if ($noResult) {
                echo '<div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <h1 class="display-4">No comments found</h1>
                            <p class="lead">Be the first person to comment.</p>
                        </div>
                     </div>';
            }
                
            ?>


        </div>

    </div>

    <?php include 'partial/_footer.php'; ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
    -->
</body>

</html>