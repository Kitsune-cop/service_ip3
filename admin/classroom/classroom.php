<?php

function insert($params){
    echo 'function insert classroom' . '<br>';
    try{
    global $conn;
        $sql = $conn->prepare("INSERT INTO `class`(`school_year`, `grade`, `room`) VALUES (:school_year,:grade,:room)");
        $sql->execute($params);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage() . '<br>';
    }
};
function check_classroom($params){
    try{
        global $conn;
        $sql = $conn->prepare("SELECT * FROM `class` WHERE `school_year` = :school_year AND `grade` = :grade AND `room` = :room");
        $sql->execute($params);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        echo 'function check_classroom classroom count =' . count($result);
    return count($result);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage() . '<br>';
    }
};

function check_classroom_and_add($params){
    if(!check_classroom($params)){
        insert($params);
    }
};

function show_classroom($params){
    try{
        global $conn;
        $sql = "SELECT * FROM `class`";
        $statement = $conn->prepare($sql);
        $statement->execute($params);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch(PDOException $e){
        echo "Error show classroom: ". $e->getMessage();
    }
}
?>