<?php 

    $dsn = 'mysql:host=localhost;port=3306;dbname=AirSuite';
    $username = 'michael';
    $password ="Hellome11!";

    try{
        $conn = new PDO ($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "CREATE TABLE IF NOT EXISTS AirSuite_Interview (
            ID INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            Value_Key VARCHAR(6) NOT NULL,
            Value_Data VARCHAR(120)
        )";

        $conn->exec($sql);
        echo "Table created";
    }
    catch(PDOException $e){
        echo $sql . "<br>" . $e->getMessage();
    }

    try{
        $exists = $conn->query("SELECT COUNT(*) 
        FROM AirSuite_Interview");

        if($exists == 1){
            $sql = "INSERT INTO AirSuite_Interview (Value_Key, Value_Data)
            VALUES('FIRSTK', null),
            ('SECOND', 'This is the second entry'),
            ('THIRDK', 'THIS is THE third ENTRY')";
            $conn->exec($sql);
            echo "values inserted";
        }     
    }
    catch(PDOException $e){
        echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
?>