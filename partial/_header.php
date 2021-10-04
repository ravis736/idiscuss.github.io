<?php
session_start();

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-0">
<div class="container-fluid px-2">
  <a class="navbar-brand" href="/forum">iDiscuss</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/forum">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Top Categories
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';

            $sql = "SELECT category_name, category_id FROM `category` LIMIT 3";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<a class="dropdown-item" href="threadlist.php?catid=' .$row['category_id']. '">' .$row['category_name']. '</a>';
            }
            
            
            echo '</ul>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact</a>
        </li>
        </ul>
        <div class="mx-0" style="display: flex">';

        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
            echo '<form class="d-flex" action="search.php" method="GET">
                    <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-success" type="submit">Search</button>
                    <p class="text-light my-2 mx-2">Welcome'.$_SESSION['useremail'].'</p>
                    <a href="partial/_logout.php" class="btn btn-outline-success ml-2">Logout</a>
                 </form>';
        }
        else {
            echo '<form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-success" type="submit">Search</button>
                </form>
                    <button class="btn btn-outline-success mx-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                    <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>';
        }
            
        
        echo '</div>
    </div>
</div>
</nav>';

include 'partial/_loginModal.php';
include 'partial/_signupModal.php';

if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true") {
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong>Success!</strong> You can login now.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>';
}

?>