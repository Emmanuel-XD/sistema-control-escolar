<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {

        case 'insert_mat':
            insert_mat();
            break;

        case 'insert_hor':
            insert_hor();
            break;

        case 'insert_grado':
            insert_grado();
            break;

        case 'insert_grupo':
            insert_grupo();
            break;

        case 'insert_cargo':
            insert_cargo();
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

        case 'editar_grupo':
            editar_grupo();
            break;

        case 'editar_cargo':
            editar_cargo();
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

        case 'editar_datos':
            editar_datos();
            break;

        case 'editar_perfil':
            editar_perfil();
            break;

        case 'devolver_cant':
            devolver_cant();
            break;

        case 'change_password':
            change_password();
            break;

        case 'savePago':
            savePago();
            break;
    }
}

function savePago()
{
    include "db.php";
    date_default_timezone_set('America/Mexico_City');
    $currentDate = date("Y-m-d H:i:s");
    extract($_POST);

    $pago = $_POST['pago'];

    if ($id_alumno != "undefined" || $id_grado != "undefined") {
        $consulta = "INSERT INTO pagos (id_alumno, id_grado, id_cargo, beca, total, pago, fecha) 
        VALUES ('$id_alumno', '$id_grado', '$id_cargo', '$beca','$descuento', '$pago', '$currentDate')";
        $resultado = mysqli_query($conexion, $consulta);
        $id = $conexion->insert_id;
        if ($resultado) {
            $response = array(
                'status' => 'success',
                'reportId' => $id
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Ocurrió un error inesperado'
            );
        }
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Ocurrió un error inesperado'
        );
    }
    echo json_encode($response);
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

function insert_hor()
{
    global $conexion;
    include "db.php";

    $id_grado = $_POST['id_grado'];
    if (isset($_POST['selected_days']) && is_array($_POST['selected_days'])) {
        foreach ($_POST['selected_days'] as $selected_day) {
            if (isset($_POST['id_materia']) && is_array($_POST['id_materia'])) {
                foreach ($_POST['id_materia'] as $id_hour => $id_materia) {
                    $consulta = "INSERT INTO alumno_horario (id_grado, id_materia, id_hour, id_day) VALUES ('$id_grado', '$id_materia', '$id_hour', '$selected_day')";
                    $resultado = mysqli_query($conexion, $consulta);
                    if (!$resultado) {
                        echo "Error en la consulta: " . mysqli_error($conexion);
                    }
                }
            }
        }
        echo "Datos insertadosz";
    } else {
        echo "No se han seleccionado días.";
    }
}



function insert_prest()
{
    global $conexion;
    extract($_POST);
    $hora_fin = $_POST['hora_fin'];
    include "db.php";

    if ($cant == 0) {
        $response = array(
            'status' => 'error',
            'message' => 'La cantidad que solicitas no puede ser 0 tiene que ser mayor o igual a la existencia en el inventario'
        );
        echo json_encode($response);
        return;
    }

    $consult = "SELECT existencia FROM inventario WHERE id = $id_material";
    $results = mysqli_query($conexion, $consult);

    if ($row_cantidad = mysqli_fetch_assoc($results)) {
        $cantDisponible = $row_cantidad['existencia'];

        if ($cantDisponible >= $cant) {
            $consulta = "INSERT INTO prestamos (id_profesor, id_materia, id_material, fecha_slt, fecha_fin, hora_in, hora_fin, cant, status)
VALUES ('$id_profesor', '$id_materia', '$id_material', '$fecha_slt', '$fecha_fin', '$hora_in', '$hora_fin', '$cant', '$status')";

            $resultado = mysqli_query($conexion, $consulta);

            if ($resultado) {
                // Update al campo cantidad en el inventario
                $nueva_cantidad = $cantDisponible - $cant;
                $sql = "UPDATE inventario SET existencia = $nueva_cantidad WHERE id = $id_material";
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

function insert_grupo()
{
    global $conexion;
    extract($_POST);
    include "db.php";

    $consulta = "INSERT INTO grupos (grupo) VALUES ('$grupo')";
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

function insert_cargo()
{
    global $conexion;
    extract($_POST);
    include "db.php";

    $consulta = "INSERT INTO cargos (cargo, monto) VALUES ('$cargo', '$monto')";
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

    $consulta = "INSERT INTO inventario (codigo, descripcion, cantidad, existencia, unidad,id_profesor,id_categoria, status)
VALUES ('$codigo', '$descripcion','$cantidad', '$existencia','$unidad','$id_profesor','$id_categoria','$status')";
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

    $consult = "SELECT matricula FROM alumnos WHERE matricula = '$matricula'";
    $result = mysqli_query($conexion, $consult);

    if (mysqli_num_rows($result) > 0) {
        $response = array(
            'status' => 'error',
            'message' => 'La matrícula ya está en uso. Por favor, ingrese otra matrícula.'
        );
    } else {
        $consulta = "INSERT INTO alumnos (matricula, nombre, apellido, correo, telefono, curp, edad, birthdate,
        beca, id_grado, id_grupo) VALUES ('$matricula', '$nombre', '$apellido', '$correo', '$telefono', '$curp', '$edad', 
        '$birthdate', '$beca', '$id_grado', '$id_grupo')";
        $resultado = mysqli_query($conexion, $consulta);

        if ($resultado) {
            $response = array(
                'status' => 'success',
                'message' => 'Los datos se guardaron correctamente'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Ocurrió un error inesperado al insertar los datos'
            );
        }
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

function devolver_cant()
{
    require_once("db.php");
    extract($_POST);

    if (isset($_POST['confirmacion']) && $_POST['confirmacion'] === 'confirmado') {

        $consulta = "SELECT * FROM prestamos WHERE id = $id";
        $resultado = mysqli_query($conexion, $consulta);
        $row_prestamo = mysqli_fetch_assoc($resultado);

        $cant_dev = $row_prestamo['cant'];
        $id_material = $row_prestamo['id_material'];

        $consult = "SELECT existencia FROM inventario WHERE id = $id_material";
        $result = mysqli_query($conexion, $consult);
        $row_inventario = mysqli_fetch_assoc($result);
        $cantDisponible = $row_inventario['existencia'];


        if ($cantDisponible >= $cant_dev) {

            mysqli_begin_transaction($conexion);

            $newCantDev = $cantDisponible + $cant_dev;
            $sql = "UPDATE inventario SET existencia = $newCantDev WHERE id = $id_material";
            $resultados = mysqli_query($conexion, $sql);

            $SQL = "DELETE FROM prestamos WHERE id = $id";
            $respuesta = mysqli_query($conexion, $SQL);

            if ($resultados && $respuesta) {

                mysqli_commit($conexion);

                $response = array(
                    'status' => 'success',
                    'message' => 'El material fue devuelto y borrado del historial'
                );
            } else {

                mysqli_rollback($conexion);

                $response = array(
                    'status' => 'error',
                    'message' => 'Ocurrió un error al devolver el material'
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Error al verificar la cantidad en el inventario'
            );
        }
    } else {

        $response = array(
            'status' => 'confirmacion',
            'message' => 'Confirmar la devolución'
        );
    }

    echo json_encode($response);
}



function editar_inv()
{
    require_once("db.php");

    extract($_POST);


    $consulta = "UPDATE inventario SET codigo = '$codigo', descripcion = '$descripcion', cantidad = '$cantidad', existencia = '$existencia',
unidad = '$unidad', id_profesor = '$id_profesor', id_categoria='$id_categoria', status='$status' WHERE id = '$id' ";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo json_encode("correcto");
    } else {
        echo json_encode("error");
    }
}

function editar_datos()
{
    require_once("db.php");
    extract($_POST);

    // Verificar si se ha seleccionado una nueva imagen
    if (!empty($_FILES['imagen']['name'])) {
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $imagen_ruta = 'images/' . $_FILES['imagen']['name'];
        move_uploaded_file($imagen_tmp, $imagen_ruta);

        // Actualizar la ruta de la imagen en la base de datos
        $consulta = "UPDATE settings SET instituto = '$instituto', direccion = '$direccion', clave = '$clave', tema = '$tema',
imagen = '$imagen_ruta' WHERE id = '$id' ";
    } else {
        // No se ha seleccionado una nueva imagen, actualizar solo los datos sin cambiar la imagen
        $consulta = "UPDATE settings SET instituto = '$instituto', direccion = '$direccion', clave = '$clave', tema = '$tema' WHERE id = '$id' ";
    }

    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado === true) {
        echo json_encode("updated");
    } else {
        echo json_encode("error");
    }
}


function editar_alum()
{
    require_once("db.php");

    extract($_POST);
    $id_grupo = $_POST['id_grupo'];

    $consulta = "UPDATE alumnos SET matricula = '$matricula', nombre = '$nombre', apellido = '$apellido', correo = '$correo', 
    telefono = '$telefono', curp = '$curp', edad='$edad', birthdate = '$birthdate',
    beca = '$beca',id_grado = '$id_grado',id_grupo = '$id_grupo' WHERE id = '$id' ";
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

function editar_grupo()
{
    require_once("db.php");

    extract($_POST);


    $consulta = "UPDATE grupos SET grupo = '$grupo' WHERE id = '$id' ";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo json_encode("correcto");
    } else {
        echo json_encode("error");
    }
}

function editar_cargo()
{
    require_once("db.php");

    extract($_POST);


    $consulta = "UPDATE cargos SET cargo = '$cargo', monto = '$monto' WHERE id = '$id' ";
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

function editar_perfil()
{
    require_once("db.php");
    extract($_POST);

    // Verificar si se ha seleccionado una nueva imagen
    if (!empty($_FILES['imagen']['name'])) {
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $imagen_ruta = '../views/imagen/' . $_FILES['imagen']['name'];
        move_uploaded_file($imagen_tmp, $imagen_ruta);

        // Actualizar la ruta de la imagen en la base de datos
        $consulta = "UPDATE users SET usuario = '$usuario', correo = '$correo', imagen = '$imagen_ruta' WHERE id = '$id' ";
    } else {
        // No se ha seleccionado una nueva imagen, actualizar solo los datos sin cambiar la imagen
        $consulta = "UPDATE users SET usuario = '$usuario', correo = '$correo' WHERE id = '$id' ";
    }

    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado === true) {
        echo json_encode("updated");
    } else {
        echo json_encode("error");
    }
}

function change_password()
{
    require_once("db.php");
    extract($_POST);
    $password = trim($_POST['password']);
    $password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 5]);
    $consulta = "UPDATE users SET password = '$password' WHERE id = '$id' ";
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