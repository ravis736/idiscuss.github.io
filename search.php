<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- bootstrap@5.1.0 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <!-- bootstrap@4.6.0 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

        <style>
            #maincontainer{
                min-height: 85vh;
            }
        </style>

    <title>iDiscuss</title>
</head>

<body>
    <?php include 'partial/_dbconnect.php'; ?>
    <?php include 'partial/_header.php'; ?>

    


    <!-- search result -->
    <div class="container my-3" id="maincontainer">
        <h1>Search result for "<em><?php echo $_GET['search']?></em>"</h1>

        <?php
        $noresult = true;
        $query = $_GET['search'];
        $sql = "SELECT * FROM `threads` WHERE MATCH (thread_title, thread_desc) against ('$query')";
        $result = mysqli_query($conn, $sql);
        while ($row=mysqli_fetch_assoc($result)){
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_id = $row['thread_id'];
            $url = "thread.php?threadid=". $thread_id;
            $noresult = false;

            //display the search result
            echo '<div class="result">
                    <h3><a href="' .$url. '" class="text-dark">' .$title. '</a></h3>
                    <p>' .$desc. '</p>
                 </div>';
            }

            if ($noresult) {
                echo '<div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <h1 class="display-4">No results found</h1>
                            <p class="lead">Suggestions: <ul>
                                            <li>Make sure that all words are spelled correctly.</li>
                                            <li>Try different keywords.</li>
                                            <li>Try more general keywords.</li>
                                            <li>Try fewer keywords.</li>
                                            </ul>
                            </p>
                        </div>
                     </div>';
                }

        ?>

        
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