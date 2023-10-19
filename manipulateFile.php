<?php
require_once 'dbconfig.php';

$listOfPerson = readPersonFile("person.txt");
displayArray($listOfPerson);
//addPersonToDatabase($listOfPerson);
writeDataToFile($listOfPerson, "newperson.txt");


// This function will return an array
function readPersonFile($fileName){
    $fileId = fopen($fileName, "r");
    
    $cpt = 0;
    while(feof($fileId) == false){
        $oneLine = fgets($fileId);
        //echo "$oneLine <br/>";
        // explode : extracs the different information of person and store them in an array
        $oneLine = explode(",", $oneLine);
        $listOfPerson[$cpt++] = $oneLine;
    }
    
    fclose($fileId);
    return $listOfPerson;
}

function displayArray($listOfPerson){
    
    echo "<table border='1'> <tr> <th>Person Id</th> <th>Name</th> <th>Phone</th> <th>Email</th></tr>";
    foreach ($listOfPerson as $onePerson){
        $id = $onePerson[0];
        $name = $onePerson[1];
        $phone = $onePerson[2];
        $email = $onePerson[3];
        
        echo "<tr> <td>$id</td> <td>$name</td> <td>$phone</td> <td>$email</td> </tr>";
    }
    echo "</table>";
}


function addPersonToDatabase($listOfPerson){
    global $connection;
    
    foreach ($listOfPerson as $onePerson){
        $id = $onePerson[0];
        $name = $onePerson[1];
        $phone = $onePerson[2];
        $email = $onePerson[3];
        
        $sqlStmt = "INSERT INTO person VALUES ($id, '$name', '$phone', '$email')";
        $queryId = mysqli_query($connection, $sqlStmt);
        
        if ($queryId){
            echo "The person with the id $id has been added successfully <br/>";
        } else {
            echo mysqli_error($connection);
        }
    }
    
    mysqli_close($connection);
    
}

function writeDataToFile($listOfPerson, $fileName){
    $fileId = fopen($fileName, "w");
    
    foreach ($listOfPerson as $onePerson){
        $onePerson = implode("#", $onePerson);
        fwrite($fileId, $onePerson);
        echo "One line has been added to the file successfully <br/>";
    }
    fclose($fileId);
}













