<?php
#get all categories function
function get_all_categories($con){
    $sql = "SELECT * FROM catagories";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    if($stmt->rowCount() > 0){
        $catagories = $stmt->fetchAll();

    }else{
        $catagories = 0;
    }

    return $catagories;

}

#get by category id
function get_category($con, $id){
    $sql = "SELECT * FROM catagories WHERE id=?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$id]);

    if($stmt->rowCount() > 0){
        $catagory = $stmt->fetch();

    }else{
        $catagory = 0;
    }

    return $catagory;

}