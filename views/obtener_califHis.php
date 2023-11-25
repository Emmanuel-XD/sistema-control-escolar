
<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['idStudent']) && isset($_POST['perEval']) && isset($_POST['numGrade'])) {

        $idProfile = $_POST['idStudent'];
        $evalPer = $_POST['perEval'];
        $evalNum = $_POST['numGrade'];
        $dsn = "mysql:host=czu.h.filess.io;port=3305;dbname=controlEscolar_valuableif";
        $user = "controlEscolar_valuableif";
        $password = "72659f651655f158ad383189884879d156b523bf";
        $pdo = new PDO($dsn, $user, $password);
        try{

            $sql = "SELECT *
            FROM calificacion_eval
            JOIN calificacion ON calificacion_eval.id_calificacion = calificacion.id
            JOIN materias ON materias.id = calificacion_eval.id_materia 
            JOIN grados ON grados.id = materias.id_grado
            WHERE calificacion_eval.id_alumno = :param
              AND grados.id = :param2
              AND calificacion_eval.id_periodo = :param3
              AND  calificacion_eval.is_history = 1;
            ";
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(':param', $idProfile);
            $stmt->bindParam(':param2', $evalNum);
            $stmt->bindParam(':param3', $evalPer);
    
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
        echo json_encode($result);

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