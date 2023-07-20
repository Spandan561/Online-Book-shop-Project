<?php
 session_start();
 if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

     #database connection
     include "../db_conn.php";

    /**Check if category name is submitted */

    if(isset($_POST['category_name'])){
        /**
         *  Get data from post request
         *  and store it in var */
        $name = $_POST['category_name'];
        if(empty($name)){
            $em = "The category name is required";
            header("Location: ../add-category.php?error=$em");
            exit;

        }else{
            #insert into database
            $sql = "INSERT INTO catagories (name)
                    VALUES (?)";
            $stmt = $conn->prepare($sql);
            $res  = $stmt->execute([$name]);

            /**
             * if there is no error while inserting data
             */
            if($res){
                 #Success message
                 $sm = "Successfully Created!";
                 header("Location: ../add-category.php?success=$sm");
                 exit;

            }else{
                #error message
                $em = "Unknown error occured!";
                header("Location: ../add-category.php?error=$em");
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
 