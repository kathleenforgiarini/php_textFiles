<?php
require_once 'dbconfigEx1.php';

$fileName = "teacherCourses.txt";

addTeacherToFile($fileName);
displayArray(readTeacherFile($fileName));

function addTeacherToFile($fileName)
{
    global $connection;
    $fileId = fopen($fileName, "w");

    $sqlStmt = "SELECT teacher.teacher_id, name, phone, email, course.course_desc FROM teacher JOIN to_teach ON to_teach.teacher_id=teacher.teacher_id JOIN course ON to_teach.course_id=course.course_id";
    $queryId = mysqli_query($connection, $sqlStmt);
    $count = mysqli_num_rows($queryId);
    if ($count > 0) {
        while ($rec = mysqli_fetch_row($queryId)) {
            $line = implode("$", $rec);
            fwrite($fileId, $line . "\n");
            echo "One line has been added to the file successfully <br/>";
        }
        fclose($fileId);
    } else {
        echo "No records found";
    }
}

function readTeacherFile($fileName)
{
    $fileId = fopen($fileName, "r");
    $cpt = 0;
    while (feof($fileId) == false) {
        $oneLine = fgets($fileId);
        $oneLine = explode("$", $oneLine);
        $listOfTeacher[$cpt ++] = $oneLine;
    }

    fclose($fileId);
    return $listOfTeacher;
}

function displayArray($listOfTeacher)
{
    echo "<table border='1'> <tr> <th>Teacher Id</th> <th>Name</th> <th>Phone</th> <th>Email</th> <th>Course Desc</th></tr>";
    foreach ($listOfTeacher as $oneTeacher) {
        $oneT = implode("$", $oneTeacher);
        if (! empty($oneT)) {
            echo "$oneT <br/>";
            $id = $oneTeacher[0];
            $name = $oneTeacher[1];
            $phone = $oneTeacher[2];
            $email = $oneTeacher[3];
            $course = $oneTeacher[4];

            echo "<tr> <td>$id</td> <td>$name</td> <td>$phone</td> <td>$email</td> <td>$course</td> </tr>";
        }
    }
    echo "</table>";
}













