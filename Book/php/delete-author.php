<?php
 session_start();
 if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

     #database connection
     include "../db_conn.php";

    /**Check if author id set */

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

            #delete category from database
            $sql = "DELETE FROM author 
                        WHERE id=?";
            $stmt = $conn->prepare($sql);
            $res  = $stmt->execute([$id]);

            /**
            * if there is no error while deleting data
            */
            if($res){

                #Success message
                $sm = "Successfully removed!";
                header("Location: ../admin.php?success=$sm");
                exit;

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
 