
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // foreach ($_POST as $key => $value) {
    //     echo "POST parameter name: " . $key . " <br> ";
    //     echo "POST parameter value: " . $value . " <br> ";
    //     echo "<br>";
    // }
    if (isset($_POST['idStudent']) && isset($_POST['perEval']) && isset($_POST['numEval'])) {
        $idProfile = $_POST['idStudent'];
        $evalPer = $_POST['perEval'];
        $evalNum = $_POST['numEval'];

        $dsn = "mysql:host=czu.h.filess.io;port=3305;dbname=controlEscolar_valuableif";
        $user = "controlEscolar_valuableif";
        $password = "72659f651655f158ad383189884879d156b523bf";
        $pdo = new PDO($dsn, $user, $password);
        try{
            $sql = "SELECT * FROM calificacion_eval JOIN calificacion ON calificacion_eval.id_calificacion = calificacion_eval.id_calificacion JOIN materias ON materias.id = calificacion_eval.id_materia WHERE calificacion_eval.id_alumno =:param  AND calificacion_eval.id_evaluacion = :param2 AND calificacion_eval.id_periodo = :param3";
            $stmt = $pdo->prepare($sql);
    
            $stmt->bindParam(':param', $idProfile);
            $stmt->bindParam(':param2', $evalNum);
            $stmt->bindParam(':param3', $evalPer);
    
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($result);
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