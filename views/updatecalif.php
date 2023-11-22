<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // foreach ($_POST as $key => $value) {
    //     echo "POST parameter name: " . $key . " <br> ";
    //     echo "POST parameter value: " . $value . " <br> ";
    //     echo "<br>";
    // }
    if (isset($_POST['idStudent']) && isset($_POST['newcalif']) && isset($_POST['idmateria'])) {
        $idProfile = $_POST['idStudent'];
        $newCalif = $_POST['newcalif'];
        $materia = $_POST['idmateria'];

        $dsn = "mysql:host=czu.h.filess.io;port=3305;dbname=controlEscolar_valuableif";
        $user = "controlEscolar_valuableif";
        $password = "72659f651655f158ad383189884879d156b523bf";
        $pdo = new PDO($dsn, $user, $password);
        try{
            $sql = 'UPDATE calificacion_eval SET grade = :param  WHERE id_materia = :param2 AND id_alumno = :param3';
            $stmt = $pdo->prepare($sql);
    
            $stmt->bindParam(':param', $newCalif);
            $stmt->bindParam(':param2', $materia);
            $stmt->bindParam(':param3', $idProfile);
    
            $stmt->execute();
           // Check if any rows were affected by the update
    $rowCount = $stmt->rowCount();

            if ($rowCount > 0) {
                // If rows were affected, consider it a success
                $response = array('status' => 'success', 'message' => 'Update successful');
            } else {
                // If no rows were affected, you may consider it a failure or handle it accordingly
                $response = array('status' => 'error', 'message' => 'No rows were updated');
            }

            echo json_encode($response);
        } catch (PDOException $e) {
            // Handle any exceptions here
            $response = array('status' => 'error', 'message' => $e->getMessage());
            echo json_encode($response);
        }
    }
    else   {
        echo "No correct POST data received.";
    }
} else {
    echo "No POST data received.";
}

?>