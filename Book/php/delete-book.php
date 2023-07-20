<?php
 session_start();
 if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

     #database connection
     include "../db_conn.php";

    /**Check if book id set */

    if(isset($_GET['id'])){
        /**
         *  Get data from get request
         *  and store it in var */
        $id = $_GET['id'];
       
        if(empty($id)){
            $em = "Error occured";
            header("Location: ../admin.php?error=$em");
            exit;

        }else{
            #get book from database.
            $sql2 = "SELECT * FROM books
                    WHERE id=?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->execute([$id]);
            $the_book = $stmt2->fetch();
            if($stmt2->rowCount()>0){

                #delete book from database
                $sql = "DELETE FROM books 
                        WHERE id=?";
                $stmt = $conn->prepare($sql);
                $res  = $stmt->execute([$id]);

                /**
                 * if there is no error while deleting data
                 */
                if($res){
                    #delete the current book_cover
                    #and file
                    $cover = $the_book['cover'];
                    $file = $the_book['file'];
                    $c_b_c = "../uploads/cover/$cover";
                    $c_f = "../uploads/files/$cover";

                    unlink($c_b_c);
                    unlink($c_f);
                    #Success message
                    $sm = "Successfully removed!";
                    header("Location: ../admin.php?success=$sm");
                    exit;

                }else{
                    #error message
                    $em = "Unknown error occured!";
                    header("Location: ../edit-author.php?error=$em");
                    exit;
                }

            }else{
                $em = "Error occured";
                header("Location: ../admin.php?error=$em");
                exit;
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
 