
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

            // Your existing code to get the last id_calificacion from calificacion table
$checkMateriaSql = "SELECT COALESCE(MAX(calificacion.id), 0) AS last_calificacion_id FROM calificacion";
$checkMateriaStmt = $pdo->prepare($checkMateriaSql);
$checkMateriaStmt->execute();
$materiaResult = $checkMateriaStmt->fetch(PDO::FETCH_ASSOC);
$lastCalificacionId = $materiaResult['last_calificacion_id'];

$countCalificacionEvalSql = "SELECT COUNT(*) AS count_calificacion_eval
                             FROM calificacion_eval
                             WHERE id_calificacion = :paramCalif";
$countCalificacionEvalStmt = $pdo->prepare($countCalificacionEvalSql);
$countCalificacionEvalStmt->bindParam(':paramCalif', $lastCalificacionId);
$countCalificacionEvalStmt->execute();
$countResult = $countCalificacionEvalStmt->fetch(PDO::FETCH_ASSOC);
$countCalificacionEval = $countResult['count_calificacion_eval'];
if ($countResult > 0 && $countResult < 11 ) {
    $idCalif = $materiaResult['last_calificacion_id'];



}
if($countResult == 0 || $countResult >11){
    $checkMateriaSql = "SELECT COALESCE(MAX(calificacion.id), 0) + 1 AS next_calificacion_id
    FROM calificacion";

    $checkMateriaStmt = $pdo->prepare($checkMateriaSql);
    $checkMateriaStmt->execute();
    $materiaResult = $checkMateriaStmt->fetch(PDO::FETCH_ASSOC);
    $idCalif = $materiaResult['next_calificacion_id'];
}
           


$insertMateriaSql = "INSERT INTO calificacion_eval (id_alumno, id_calificacion, id_evaluacion, id_periodo, id_materia, grade) 
SELECT 
:paramAlum AS id_alumno, 
:paramCalif AS id_calificacion, 
:paramEval AS id_evaluacion, 
:paramPeriod AS id_periodo, 
materias.id AS id_materia, 
COALESCE(calificacion_eval.grade, 000) AS calificacion
 FROM materias 
 LEFT JOIN calificacion_eval ON materias.id = calificacion_eval.id_materia 
                          AND calificacion_eval.id_alumno = :paramAlum
                          AND calificacion_eval.id_periodo = :paramPeriod 
                          AND calificacion_eval.id_evaluacion = :paramEval 
                          AND calificacion_eval.id_calificacion = :paramCalif
 WHERE NOT EXISTS (SELECT 1 FROM calificacion_eval  
                   WHERE calificacion_eval.id_alumno = :paramAlum 
                   AND calificacion_eval.id_materia = materias.id 
                   AND calificacion_eval.id_periodo = :paramPeriod 
                   AND calificacion_eval.id_evaluacion = :paramEval 
                   AND calificacion_eval.id_calificacion = :paramCalif)
 LIMIT 10";
$insertMateriaStmt = $pdo->prepare($insertMateriaSql);
// Bind parameters for default values
$insertMateriaStmt->bindParam(':paramAlum', $idProfile);
$insertMateriaStmt->bindParam(':paramCalif', $idCalif);
$insertMateriaStmt->bindParam(':paramPeriod', $evalPer);
$insertMateriaStmt->bindParam(':paramEval', $evalNum);
// Bind other default values as needed
// ...

// Execute the insert query
$insertMateriaStmt->execute();

            


            $sql = "SELECT *
            FROM calificacion_eval
            JOIN calificacion ON calificacion_eval.id_calificacion = calificacion.id
            JOIN materias ON materias.id = calificacion_eval.id_materia 
            WHERE calificacion_eval.id_alumno = :param
              AND calificacion_eval.id_evaluacion = :param2
              AND calificacion_eval.id_periodo = :param3;
            ";
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(':param', $idProfile);
            $stmt->bindParam(':param2', $evalNum);
            $stmt->bindParam(':param3', $evalPer);
    
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($result) === 0) {
        $createCalification = "INSERT INTO calificacion (promedio) VALUES (000)";

        $insertStmt = $pdo->prepare($createCalification);
        $insertStmt->execute();

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } else {
        echo json_encode($result);
    }
} catch (Exception $e) {

    echo "Failed: " . $e->getMessage();
}

       
    }
    else   {
        echo "No correct POST data received.";
    }
} else {
    echo "No POST data received.";
}
?>