<?php 

    $dsn = 'mysql:host=localhost;port=3306;dbname=AirSuite';
    $username = '';
    $password ="";

    try{
        $conn = new PDO ($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //sql statement to build the AirSuite_Interview table if it doesnt exist
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
        //statement to check how many rows are in the table
        $stmt = $conn->prepare("SELECT COUNT(*) FROM AirSuite_Interview"); 
        $stmt->execute();
        $exists = $stmt->fetch();

        //if 0 rows populate the table, to prevent reinserting the same 3 values
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
        //statement to find the record with an id of 3
        $stmt = $conn->prepare("SELECT * FROM AirSuite_Interview WHERE ID = 3"); 
        $stmt->execute();
        $result3 = $stmt->fetch();

        echo "<br /><br />" . $result3[2] . "<br />";

        //splits the phrase into an array by the spaces
        $words = explode(' ', $result3[2]);
        /*for loop to check if each word is all cap or lowercase
        if all caps then make all lowercase and vice versa
        then concatenates the word back into a sentence*/
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

        //grabs all the records with value keys containing the word SECOND
        $stmt = $conn->prepare("SELECT * FROM AirSuite_Interview WHERE Value_Key LIKE '%SECOND%'"); 
        $stmt->execute();
        $result2 = $stmt->fetch();

        echo "<br /><br />";

        //statement to get every row of the table
        $stmt = $conn->prepare("SELECT * FROM AirSuite_Interview"); 
        $stmt->execute();
        //assign all rows to results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //convert results to json encoding and print
        $json = json_encode($results);
        print_r($json);

    }
    catch(PDOException $e){
        echo $stmt . "<br>" . $e->getMessage();
    }
//dump connection
$conn = null;
?>