<?php include "../includes/header.php";
include_once "../includes/db.php";

error_reporting(0);
session_start();

$sql = "SELECT u.id, u.usuario, u.correo, u.password, u.fecha, p.rol,a.id AS id_alumno, a.nombre, a.apellido, a.id_grado, a.correo, g.descripcion 
FROM users u LEFT JOIN permisos p ON u.id_rol= p.id INNER JOIN alumnos a ON a.correo = u.correo INNER JOIN grados g 
ON a.id_grado = g.id WHERE u.correo = '$usuario'";
$usuarios = mysqli_query($conexion, $sql);
if ($usuarios->num_rows > 0) {
    foreach ($usuarios as $key => $row) {
        $id_alumno = $row["id_alumno"];
        $id_grado = $row["id_grado"];
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Informacion</title>
    <script src="../js/cont/jquery.min.js"></script>

</head>

<body>
    <div class="container">
        <h1 class="text-center">Consulta tu Informacion <?php echo $fila['usuario']; ?></h1>

        <br>
        <p style="text-align: justify;">A continuación, los alumnos tienen la posibilidad de consultar el estado de su perfil,
            gestionar calificaciones, y editar su información personal dentro del sistema. Además, podrán revisar cualquier cambio
            realizado en sus calificaciones y ajustes en sus perfiles.</p>

        <a href="grades_history.php?id=<?php echo $id_alumno; ?>" class="btn btn-primary">Historial de Calificaciones <i class="fa fa-list-alt"></i></a>
        <a href="student_degrees.php?id=<?php echo $id_grado; ?>" class="btn btn-primary">Mis Calificaciones <i class="fa fa-file"></i></a>
        <br>
        <br>
        <div data-id="<?php echo $_SESSION['correo']; ?>" id="datos"></div>

    </div>
</body>

<script>
    var buscar = $("#datos").data("id");
    $(document).onload(buscar_ahora(buscar))

    function buscar_ahora(buscar) {
        var parametros = {
            "buscar": buscar
        };
        $.ajax({
            data: parametros,
            type: 'POST',
            url: 'search.php',
            success: function(data) {
                document.getElementById("datos").innerHTML = data;
            }
        });
    }
</script>

<?php include "../includes/footer.php"; ?>

</html>