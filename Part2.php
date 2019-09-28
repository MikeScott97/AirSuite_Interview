<?php 

    $dsn = 'mysql:host=localhost;port=3306;dbname=AirSuite';
    $username = 'michael';
    $password ="Hellome11!";

    try{
        $conn = new PDO ($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = "CREATE TABLE IF NOT EXISTS AirSuite_Interview (
            ID INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            Value_Key VARCHAR(6) NOT NULL,
            Value_Data VARCHAR(120)
        )";

        $conn->exec($stmt);
        echo "Table created<br />";
    }
    catch(PDOException $e){
        echo $stmt . "<br>" . $e->getMessage();
    }

    try{
        $stmt = $conn->prepare("SELECT COUNT(*) FROM AirSuite_Interview"); 
        $stmt->execute();
        $exists = $stmt->fetch();

        if($exists[0] == 0){
            $stmt = "INSERT INTO AirSuite_Interview (Value_Key, Value_Data)
            VALUES('FIRSTK', null),
            ('SECOND', 'This is the second entry'),
            ('THIRDK', 'THIS is THE third ENTRY')";
            $conn->exec($stmt);
            echo "values inserted<br />";
        }     
    }
    catch(PDOException $e){
        echo $stmt . "<br>" . $e->getMessage();
    }

    try{
        $stmt = $conn->prepare("SELECT * FROM AirSuite_Interview WHERE ID = 3"); 
        $stmt->execute();
        $result3 = $stmt->fetch();
        echo "<br /><br />" . $result3[2] . "<br />";
        $words = explode(' ', $result3[2]);
        foreach($words as $word){
            $bool = ctype_upper($word);
            if($bool == true){
                $word = strtolower($word);
            }else{
                $word = strtoupper($word);
            }
            $reverseCaps = $reverseCaps.$word . " ";
        }
        echo $reverseCaps;

        $stmt = $conn->prepare("SELECT * FROM AirSuite_Interview WHERE Value_Key LIKE '%SECOND%'"); 
        $stmt->execute();
        $result2 = $stmt->fetch();

        echo "<br /><br />";
        $stmt = $conn->prepare("SELECT * FROM AirSuite_Interview"); 
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $json = json_encode($results);
        print_r($json);

    }
    catch(PDOException $e){
        echo $stmt . "<br>" . $e->getMessage();
    }

$conn = null;
?>