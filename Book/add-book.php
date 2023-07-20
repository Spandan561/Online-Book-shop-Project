<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {
         #database connection
         include "db_conn.php";

        #category helper
        include "php/func-category.php";
        $catagories = get_all_categories($conn);

        #author helper
        include "php/func-author.php";
        $authors = get_all_author($conn);

        if(isset($_GET['title'])){
            $title = $_GET['title'];
        }else $title = '';

        if(isset($_GET['desc'])){
            $desc = $_GET['desc'];
        }else $desc = '';

        if(isset($_GET['author_id'])){
            $author_id = $_GET['author_id'];
        }else $author_id = 0;


  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <!--Bootstrap 5 cdn-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!--Bootstrap 5 js cdn-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="admin.php">Admin</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">Store</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="add-book.php">Add Book</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="add-category.php">Add Category</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="add-author.php">Add Author</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Log out</a>
                        </li>

                    </ul>
                    
                </div>
            </div>
        </nav>
        <form action="php/add-book.php"
              method="post"
              enctype="multipart/form-data"
               class = "shadow p-4 rounded mt-5" 
               style="width: 90%; max-width: 50rem;">
            <h1 class="text-center pb-5 display-4 fs-3">
                Add New Book
            </h1>
            <?php if (isset($_GET['error'])){ ?>
                <div class="alert alert-danger" 
                    role="alert"><?=htmlspecialchars($_GET['error']);?>
            </div>
            <?php } ?>

            <?php if (isset($_GET['success'])){ ?>
                <div class="alert alert-success" 
                    role="alert"><?=htmlspecialchars($_GET['success']);?>
            </div>
            <?php } ?>

            <div class="mb-3">
                <label class="form-label">
                    Book Title
                
                </label>
                <input type="text"
                       class="form-control" 
                       value = "<?=$title?>"
                       name="book_title">
        
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Book Description
                
                </label>
                <input type="text"
                       class="form-control" 
                       value = "<?=$desc?>"
                       name="book_description">
        
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Book Author
                
                </label>
            
                
                <select name="book_author"
                        class="form-control">
                    <option value="0">
                        Select author
                    </option>
                    <?php 
                    if($authors == 0){
                        # do nothing


                    }else{
                    foreach($authors as $author){
                            if($author_id == $author['id']){

                        ?>
                        <option 
                            selected
                            value="<?=$author['id']?>">
                            <?=$author['name']?>
                        </option>


                   <?php }else{?>
                    <option 

                        value="<?=$author['id']?>">
                            <?=$author['name']?>
                    </option>


                   <?php }} } ?>
                </select>
                
        
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Book Category
                
                </label>
                <select name="book_category"
                        class="form-control">
                    <option value="0">
                        Select category
                    </option>
                    <?php 
                    if($catagories == 0){
                        # do nothing


                    }else{
                        foreach($catagories as $category){
                            if($category_id == $category['id']){

                        ?>
                        <option 
                            selected
                            value="<?=$category['id']?>">
                            <?=$category['name']?>
                        </option>


                   <?php }else{?>
                    <option 

                        value="<?=$category['id']?>">
                            <?=$category['name']?>
                    </option>


                   <?php }} } ?>
                </select>
        
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Book Cover
                
                </label>
                <input type="file"
                       class="form-control" 
                       name="book_cover">
        
            </div>

            <div class="mb-3">
                <label class="form-label">
                    File
                
                </label>
                <input type="file"
                       class="form-control" 
                       name="file">
        
            </div>


            <button type="submit" 
                    class="btn btn-primary">
                    Add Book</button>
        </form>
        
    </div>
</body>
</html>

 <?php }else{
   header("Location: login.php");
   exit;
} ?>
