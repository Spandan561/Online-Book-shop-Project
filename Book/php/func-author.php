<?php
#get all author by id function
function get_all_author($con){
    $sql = "SELECT * FROM author";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    if($stmt->rowCount() > 0){
        $authors = $stmt->fetchAll();

    }else{
        $authors = 0;
    }

    return $authors;

}

function get_author($con, $id){
    $sql = "SELECT * FROM author WHERE id=?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$id]);

    if($stmt->rowCount() > 0){
        $author = $stmt->fetch();

    }else{
        $author = 0;
    }

    return $author;

}