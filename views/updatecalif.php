<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['idStudent']) && isset($_POST['newcalif']) && isset($_POST['idmateria']) && isset($_POST['perEval']) && isset($_POST['numEval'])) {
        $idProfile = $_POST['idStudent'];
        $newCalif = $_POST['newcalif'];
        $materia = $_POST['idmateria'];
        $period = $_POST['perEval'];
        $eval = $_POST['numEval'];

        $dsn = "mysql:host=czu.h.filess.io;port=3305;dbname=controlEscolar_valuableif";
        $user = "controlEscolar_valuableif";
        $password = "72659f651655f158ad383189884879d156b523bf";

        $pdo = new PDO($dsn, $user, $password);
        try {
            $sql = 'UPDATE calificacion_eval SET grade = :param WHERE id_materia = :param2 AND id_alumno = :param3 AND id_evaluacion = :param4 AND id_periodo = :param5';
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':param', $newCalif);
            $stmt->bindParam(':param2', $materia);
            $stmt->bindParam(':param3', $idProfile);
            $stmt->bindParam(':param4', $eval);
            $stmt->bindParam(':param5', $period);

            $stmt->execute();

            // Verificar si alguna fila fue afectada por la actualización
            $rowCount = $stmt->rowCount();

            if ($rowCount > 0) {
                // Si se afectaron filas, considerarlo un éxito
                $response = array('status' => 'success', 'message' => 'Update successful');
            } else {
                // Si no se afectaron filas, puedes considerarlo un fallo o manejarlo según sea necesario
                $response = array('status' => 'error', 'message' => 'No rows were updated');
            }

            echo json_encode($response);
        } catch (PDOException $e) {
            // Manejar cualquier excepción aquí
            $response = array('status' => 'error', 'message' => $e->getMessage());
            echo json_encode($response);
        }
    } else {
        echo "No correct POST data received.";
    }
} else {
    echo "No POST data received.";
}
?>
