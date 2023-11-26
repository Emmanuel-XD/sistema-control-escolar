<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['idStudent']) && isset($_POST['perEval']) && isset($_POST['numEval'])) {
        $idProfile = $_POST['idStudent'];
        $evalPer = $_POST['perEval'];
        $evalNum = $_POST['numEval'];
        $grado = $_SESSION['grado'];

        $dsn = "mysql:host=czu.h.filess.io;port=3305;dbname=controlEscolar_valuableif";
        $user = "controlEscolar_valuableif";
        $password = "72659f651655f158ad383189884879d156b523bf";
        try {
            $checkMateriaSql = "SELECT COALESCE(MAX(calificacion.id), 0) AS last_calificacion_id
                                FROM calificacion
                                JOIN calificacion_eval ON calificacion.id = calificacion_eval.id_calificacion
                                WHERE calificacion_eval.id_periodo = :paramPeriod AND calificacion_eval.id_evaluacion = :paramEva AND calificacion_eval.id_alumno = :paramAlum;";
            $checkMateriaStmt = $pdo->prepare($checkMateriaSql);
            $checkMateriaStmt->bindParam(':paramAlum', $idProfile);
            $checkMateriaStmt->bindParam(':paramEva', $evalNum);
            $checkMateriaStmt->bindParam(':paramPeriod', $evalPer);
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

            // Validate $countResult
            if ($countResult['count_calificacion_eval'] > 0 && $countResult['count_calificacion_eval'] <= 10) {
                $idCalif = $materiaResult['last_calificacion_id'];
            } elseif ($countResult['count_calificacion_eval'] === 0 || $countResult['count_calificacion_eval'] < 11) {
                $checkMateriaSql = "SELECT COALESCE(MAX(calificacion.id), 0) + 1 AS next_calificacion_id
                                    FROM calificacion";
                $checkMateriaStmt = $pdo->prepare($checkMateriaSql);
                $checkMateriaStmt->execute();
                $materiaResult = $checkMateriaStmt->fetch(PDO::FETCH_ASSOC);
                $idCalif = $materiaResult['next_calificacion_id'];
            } else {
                // Handle other cases or provide appropriate error messages
                echo "Invalid count: " . $countResult['count_calificacion_eval'];
            }

            $insertMateriaSql = "INSERT INTO calificacion_eval (id_alumno, id_calificacion, id_evaluacion, id_periodo, id_materia, grade) 
                                SELECT 
                                    :paramAlum AS id_alumno, 
                                    :paramCalif AS id_calificacion, 
                                    :paramEval AS id_evaluacion, 
                                    :paramPeriod AS id_periodo, 
                                    materias.id AS id_materia, 
                                    COALESCE(calificacion_eval.grade, 0) AS grade
                                FROM materias 
                                LEFT JOIN calificacion_eval ON materias.id = calificacion_eval.id_materia 
                                                          AND calificacion_eval.id_alumno = :paramAlum
                                                          AND calificacion_eval.id_periodo = :paramPeriod 
                                                          AND calificacion_eval.id_evaluacion = :paramEval 
                                                          AND calificacion_eval.id_calificacion = :paramCalif
                                WHERE materias.id_periodo = :paramPeriod AND materias.id_grado = :paramGrado
                                AND NOT EXISTS (
                                    SELECT 1 FROM calificacion_eval  
                                    WHERE calificacion_eval.id_alumno = :paramAlum 
                                    AND calificacion_eval.id_materia = materias.id 
                                    AND calificacion_eval.id_periodo = :paramPeriod 
                                    AND calificacion_eval.id_evaluacion = :paramEval 
                                    AND calificacion_eval.id_calificacion = :paramCalif
                                );";
            $insertMateriaStmt = $pdo->prepare($insertMateriaSql);
            // Bind parameters for default values
            $insertMateriaStmt->bindParam(':paramAlum', $idProfile);
            $insertMateriaStmt->bindParam(':paramCalif', $idCalif);
            $insertMateriaStmt->bindParam(':paramGrado', $grado);
            $insertMateriaStmt->bindParam(':paramPeriod', $evalPer);
            $insertMateriaStmt->bindParam(':paramEval', $evalNum);

            // Execute the insert query
            $insertMateriaStmt->execute();

            $sql = "SELECT *
                    FROM calificacion_eval
                    JOIN calificacion ON calificacion_eval.id_calificacion = calificacion.id
                    JOIN materias ON materias.id = calificacion_eval.id_materia 
                    WHERE calificacion_eval.id_alumno = :param
                      AND calificacion_eval.id_evaluacion = :param2
                      AND calificacion_eval.id_periodo = :param3
                      AND calificacion_eval.is_history = 0;";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':param', $idProfile);
            $stmt->bindParam(':param2', $evalNum);
            $stmt->bindParam(':param3', $evalPer);

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) === 0) {
                $createCalification = "INSERT INTO calificacion (promedio) VALUES (0)";
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
    } else {
        echo "No correct POST data received.";
    }
} else {
    echo "No POST data received.";
}
?>
