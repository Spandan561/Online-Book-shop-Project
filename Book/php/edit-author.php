<?php
 session_start();
 if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

     #database connection
     include "../db_conn.php";

    /**Check if author name is submitted */

    if(isset($_POST['author_name']) &&
       isset($_POST['author_id'])){
        /**
         *  Get data from post request
         *  and store it in var */
        $name = $_POST['author_name'];
        $id = $_POST['author_id'];
        if(empty($name)){
            $em = "The author name is required";
            header("Location: ../edit-author.php?error=$em&id=$id");
            exit;

        }else{
            #update into database
            $sql = "UPDATE author SET name=?
                    WHERE id=?";
            $stmt = $conn->prepare($sql);
            $res  = $stmt->execute([$name, $id]);

            /**
             * if there is no error while inserting data
             */
            if($res){
                 #Success message
                 $sm = "Successfully updated!";
                 header("Location: ../edit-author.php?success=$sm&id=$id");
                 exit;

            }else{
                #error message
                $em = "Unknown error occured!";
                header("Location: ../edit-author.php?error=$em&id=$id");
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
 