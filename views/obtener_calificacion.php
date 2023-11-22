
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && $POST) {
    // foreach ($_POST as $key => $value) {
    //     echo "POST parameter name: " . $key . " <br> ";
    //     echo "POST parameter value: " . $value . " <br> ";
    //     echo "<br>";
    // }
    if (isset($_POST['idStudent']) && isset($_POST['perEval']) && isset($_POST['numEval'])) {
        $idProfile = $_POST['idStudent'];
        $evalPer = $POST['perEval'];
        $evalNum = $_POST['evalNum'];

        $dsn = "mysql:host=czu.h.filess.io;port=3305;dbname=controlEscolar_valuableif";
        $user = "controlEscolar_valuableif";
        $password = "72659f651655f158ad383189884879d156b523bf";
        $pdo = new PDO($dsn, $username, $password);
        try{
            $sql = "SELECT calificacion_eval.idalumno FROM calificacion_eval JOIN calificacion ON calificacion_eval.id_califcacion = calificacion_eval.id_calificacion JOIN materias ON calificacion_eval.id_materia WHERE calificacion_eval.id_alumno =:param  AND calificacion_eval.id_evaluacion = :param2 AND calificacion_eval.id_periodo = :param3";
            $stmt = $pdo->prepare($sql);
    
            $paramValue = "your_value";
            $stmt->bindParam(':param', $paramValue);
            $stmt->bindParam(':param2', $paramValue2);
            $stmt->bindParam(':param3', $paramValue3);
    
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo $result;
        }
        catch (PDOException $e) {
            // Handle any database connection or query errors
            echo "Error: " . $e->getMessage();
        }
       
    }
    else   {
        echo "No correct POST data received.";
    }
} else {
    echo "No POST data received.";
}
?>