<?php
 session_start();
 if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

     #database connection
     include "../db_conn.php";

     #validation helper function
     include "func-validation.php";

     #File upload helper function
     include "func-file-upload.php";

    /**if all input fields are filled */

    if (isset($_POST['book_title'])        &&
        isset($_POST['book_description']) &&
        isset($_POST['book_author'])      &&
        isset($_POST['book_category'])    &&
        isset($_FILES['book_cover'])       &&
        isset($_FILES['file'])){
        /**
         *  Get data from post request
         *  and store them in var */
        $title       = $_POST['book_title'];
		$description = $_POST['book_description'];
		$author      = $_POST['book_author'];
		$category    = $_POST['book_category'];

		# making URL data format
		$user_input = 'title='.$title.'&category_id='.$category.'&desc='.$description.'&author_id='.$author;

		#simple form Validation

        $text = "Book title";
        $location = "../add-book.php";
        $ms = "error";
		is_empty($title, $text, $location, $ms, $user_input);

        $text = "Book Description";
        $location = "../add-book.php";
        $ms = "error";
		is_empty($description, $text, $location, $ms, $user_input);
        
        $text = "Book author";
        $location = "../add-book.php";
        $ms = "error";
		is_empty($author, $text, $location, $ms, $user_input);

        $text = "Book category";
        $location = "../add-book.php";
        $ms = "error";
		is_empty($category, $text, $location, $ms, $user_input);

        #book cover uploading
        $allowed_image_exs = array("jpg","jpeg","png");
        $path = "cover";
        $book_cover = upload_file($_FILES['book_cover'],
                     $allowed_image_exs, $path);

        /**if error occured while uploading book cover */
        if($book_cover['status'] == 'error'){
            $em = $book_cover['data'];

            /** redirect to '../add-book.php' and
             * passing error msg & user_input
             */
            header("Location: ../add-book.php?error=$em&$user_input");
            exit;

        }else{

            #file uploading
            $allowed_file_exs = array("pdf","docx","pptx");
            $path = "files";
            $file = upload_file($_FILES['file'],
                        $allowed_file_exs, $path);
            
            
            /**if error occured while uploading files */
            if($file['status'] == 'error'){
                    $em = $file['data'];
                
                     /** redirect to '../add-book.php' and
                    * passing error msg & user_input
                     */
                    header("Location: ../add-book.php?error=$em&$user_input");
                    exit;
                
                }else{
                    /**
                     * Getting the new file name and book 
                     * cover name
                     */
                    $file_url = $file['data'];
                    $book_cover_url = $book_cover['data'];

                    #insert data into database
                    $sql = "INSERT INTO books(title, author_id,
                             description, category_id, cover, file)
                            VALUES (?,?,?,?,?,?)";
                    
                    $stmt = $conn->prepare($sql);
                    $res  = $stmt->execute([$title, $author, $description, 
                                $category, $book_cover_url, $file_url]);
        
                    /**
                     * if there is no error while inserting data
                     */
                    if($res){
                         #Success message
                         $sm = "The book Successfully uploaded!";
                         header("Location: ../add-book.php?success=$sm");
                         exit;
        
                    }else{
                        #error message
                        $em = "Unknown error occured!";
                        header("Location: ../add-book.php?error=$em");
                        exit;
                    }
                    

                    

                }


        }

         
       

        

    }else{
        header("Location: ../admin.php");
        exit;

    }

}else{
    header("Location: ../login.php");
    exit;
 }
 