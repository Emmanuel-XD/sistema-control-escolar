<?php
if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {

        case 'insert_mat':
            insert_mat();
            break;

        case 'insert_grado':
            insert_grado();
            break;

        case 'insert_per':
            insert_per();
            break;

        case 'insert_inv':
            insert_inv();
            break;

        case 'insert_esp':
            insert_esp();
            break;

        case 'insert_cat':
            insert_cat();
            break;

        case 'insert_prof':
            insert_prof();
            break;

        case 'insert_prest':
            insert_prest();
            break;

        case 'insert_alumno':
            insert_alumno();
            break;

        case 'editar_profe':
            editar_profe();
            break;

        case 'editar_alum':
            editar_alum();
            break;

        case 'editar_mat':
            editar_mat();
            break;

        case 'editar_grado':
            editar_grado();
            break;

        case 'editar_inv':
            editar_inv();
            break;


        case 'editar_esp':
            editar_esp();
            break;


        case 'editar_cat':
            editar_cat();
            break;

        case 'editar_per':
            editar_per();
            break;

        case 'editar_prest':
            editar_prest();
            break;

        case 'editar_user':
            editar_user();
            break;
    }
}


function insert_esp()
{
    require_once("db.php");
    extract($_POST);

    $consulta = "INSERT INTO especialidades (especialidad) VALUES ('$especialidad')";

    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        $response = array(
            'status' => 'success',
            'message' => 'Los datos se guardaron correctamente'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Ocurrió un error inesperado'
        );
    }

    echo json_encode($response);
}

function insert_cat()
{
    require_once("db.php");
    extract($_POST);

    $consulta = "INSERT INTO categorias (categoria) VALUES ('$categoria')";

    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        $response = array(
            'status' => 'success',
            'message' => 'Los datos se guardaron correctamente'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Ocurrió un error inesperado'
        );
    }

    echo json_encode($response);
}

function insert_mat()
{
    global $conexion;
    extract($_POST);
    include "db.php";

    $consulta = "INSERT INTO materias (materia,id_profesor, id_periodo ,id_grado) VALUES ('$materia','$id_profesor',
    '$id_periodo','$id_grado')";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        $response = array(
            'status' => 'success',
            'message' => 'Los datos se guardaron correctamente'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Ocurrió un error inesperado'
        );
    }

    echo json_encode($response);
}
function insert_prest()
{
    global $conexion;
    extract($_POST);
    include "db.php";

    if ($cant == 0) {
        $response = array(
            'status' => 'error',
            'message' => 'La cantidad que solicitas no puede ser 0 tiene que ser mayor o igual a la existencia en el inventario'
        );
        echo json_encode($response);
        return;
    }

    $consult = "SELECT cantidad FROM inventario WHERE id = $id_material";
    $results = mysqli_query($conexion, $consult);

    if ($row_cantidad = mysqli_fetch_assoc($results)) {
        $cantDisponible = $row_cantidad['cantidad'];

        if ($cantDisponible >= $cant) {
            $consulta = "INSERT INTO prestamos (id_profesor, id_materia, id_material, fecha_slt, fecha_fin, hora_in, hora_fin, cant, status) 
                VALUES ('$id_profesor', '$id_materia', '$id_material', '$fecha_slt', '$fecha_fin', '$hora_in', '$hora_fin', '$cant', '$status')";

            $resultado = mysqli_query($conexion, $consulta);

            if ($resultado) {
                // Update al campo cantidad en el inventario
                $nueva_cantidad = $cantDisponible - $cant;
                $sql = "UPDATE inventario SET cantidad = $nueva_cantidad WHERE id = $id_material";
                mysqli_query($conexion, $sql);
                $response = array(
                    'status' => 'success',
                    'message' => 'El préstamo se realizó con éxito'
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Ocurrió un error al guardar el préstamo'
                );
            }
        } else {
            if ($cantDisponible == 0) {
                $response = array(
                    'status' => 'stock_agotado',
                    'message' => 'El material que solicitas para el préstamo se encuentra agotado en el inventario'
                );
            } else {
                $response = array(
                    'status' => 'cantidad_superada',
                    'message' => 'La cantidad que solicitas es mayor a la existencia en el inventario'
                );
            }
        }
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Error al verificar la cantidad en el inventario'
        );
    }

    echo json_encode($response);
}




function insert_per()
{
    global $conexion;
    extract($_POST);
    include "db.php";

    $consulta = "INSERT INTO periodos (periodo, date_in, date_fin) VALUES ('$periodo','$date_in','$date_fin')";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        $response = array(
            'status' => 'success',
            'message' => 'Los datos se guardaron correctamente'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Ocurrió un error inesperado'
        );
    }

    echo json_encode($response);
}


function insert_grado()
{
    global $conexion;
    extract($_POST);
    include "db.php";

    $consulta = "INSERT INTO grados (descripcion, duracion) VALUES ('$descripcion', '$duracion')";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        $response = array(
            'status' => 'success',
            'message' => 'Los datos se guardaron correctamente'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Ocurrió un error inesperado'
        );
    }

    echo json_encode($response);
}

function insert_inv()
{
    global $conexion;
    extract($_POST);
    include "db.php";

    $consulta = "INSERT INTO inventario (codigo, descripcion, cantidad,unidad,id_profesor,id_categoria) 
    VALUES ('$codigo', '$descripcion','$cantidad','$unidad','$id_profesor','$id_categoria')";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        $response = array(
            'status' => 'success',
            'message' => 'Los datos se guardaron correctamente'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Ocurrió un error inesperado'
        );
    }

    echo json_encode($response);
}


function insert_prof()
{
    global $conexion;
    extract($_POST);
    include "db.php";

    $consulta = "INSERT INTO profesores (cedula, nombres, apellidos,correo,curp,edad,fecha_na, id_especialidad) 
    VALUES ('$cedula', '$nombres','$apellidos','$correo','$curp','$edad','$fecha_na', '$id_especialidad')";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        $response = array(
            'status' => 'success',
            'message' => 'Los datos se guardaron correctamente'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Ocurrió un error inesperado'
        );
    }

    echo json_encode($response);
}

function insert_alumno()
{
    global $conexion;
    extract($_POST);
    include "db.php";

    $consulta = "INSERT INTO alumnos (nombre, apellido,correo,telefono,curp,edad,birthdate, id_grado) 
    VALUES ('$nombre','$apellido','$correo','$telefono', '$curp','$edad','$birthdate', '$id_grado')";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        $response = array(
            'status' => 'success',
            'message' => 'Los datos se guardaron correctamente'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Ocurrió un error inesperado'
        );
    }

    echo json_encode($response);
}


function editar_profe()
{
    require_once("db.php");

    extract($_POST);


    $consulta = "UPDATE profesores SET cedula = '$cedula', nombres = '$nombres', apellidos = '$apellidos', correo = '$correo',
    curp = '$curp', edad='$edad', fecha_na = '$fecha_na',id_especialidad = '$id_especialidad' WHERE id = '$id' ";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo json_encode("correcto");
    } else {
        echo json_encode("error");
    }
}

function editar_inv()
{
    require_once("db.php");

    extract($_POST);


    $consulta = "UPDATE inventario SET codigo = '$codigo', descripcion = '$descripcion', cantidad = '$cantidad', unidad = '$unidad',
    id_profesor = '$id_profesor', id_categoria='$id_categoria' WHERE id = '$id' ";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo json_encode("correcto");
    } else {
        echo json_encode("error");
    }
}

function editar_alum()
{
    require_once("db.php");

    extract($_POST);


    $consulta = "UPDATE alumnos SET nombre = '$nombre', apellido = '$apellido', correo = '$correo', telefono = '$telefono',
    curp = '$curp', edad='$edad', birthdate = '$birthdate',id_grado = '$id_grado' WHERE id = '$id' ";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo json_encode("correcto");
    } else {
        echo json_encode("error");
    }
}

function editar_prest()
{
    require_once("db.php");

    extract($_POST);


    $consulta = "UPDATE prestamos SET fecha_slt = '$fecha_slt', fecha_fin = '$fecha_fin', id_profesor = '$id_profesor', 
    id_material = '$id_material', id_materia = '$id_materia', hora_in='$hora_in', hora_fin = '$hora_fin',cant = '$cant',
    status = '$status' WHERE id = '$id' ";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo json_encode("correcto");
    } else {
        echo json_encode("error");
    }
}

function editar_mat()
{
    require_once("db.php");

    extract($_POST);


    $consulta = "UPDATE materias SET materia = '$materia', id_profesor = '$id_profesor', 
    id_periodo = '$id_periodo',id_grado = '$id_grado' WHERE id = '$id' ";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo json_encode("correcto");
    } else {
        echo json_encode("error");
    }
}

function editar_per()
{
    require_once("db.php");

    extract($_POST);


    $consulta = "UPDATE periodos SET periodo = '$periodo', date_in = '$date_in', 
    date_fin = '$date_fin' WHERE id = '$id' ";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo json_encode("correcto");
    } else {
        echo json_encode("error");
    }
}


function editar_grado()
{
    require_once("db.php");

    extract($_POST);


    $consulta = "UPDATE grados SET descripcion = '$descripcion',duracion = '$duracion' WHERE id = '$id' ";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo json_encode("correcto");
    } else {
        echo json_encode("error");
    }
}

function editar_esp()
{
    require_once("db.php");

    extract($_POST);


    $consulta = "UPDATE especialidades SET especialidad = '$especialidad' WHERE id = '$id' ";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo json_encode("correcto");
    } else {
        echo json_encode("error");
    }
}

function editar_cat()
{
    require_once("db.php");

    extract($_POST);


    $consulta = "UPDATE categorias SET categoria = '$categoria' WHERE id = '$id' ";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo json_encode("correcto");
    } else {
        echo json_encode("error");
    }
}

function editar_user()
{
    require_once("db.php");
    extract($_POST);
    $consulta = "UPDATE users SET usuario = '$usuario', correo = '$correo', id_rol='$id_rol' WHERE id = '$id' ";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo json_encode("correcto");
    } else {
        echo json_encode("error");
    }
}
/*function delete()
{
    $id = $_POST['id'];
    require_once("db.php");


    $consulta = "DELETE FROM materias WHERE id = '$id' ";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo 'success';
    } else {
        echo 'error';
    }
}

function delete_s()
{
    $id = $_POST['id'];
    require_once("db.php");


    $consulta = "DELETE FROM grados WHERE id = '$id' ";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo 'success';
    } else {
        echo 'error';
    }
}
*/