<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {

        case 'insert_serv':
            insert_serv();
            break;

        case 'insert_falla':
            insert_falla();
            break;

        case 'insert_clie':
            insert_clie();
            break;

        case 'insert_report':
            insert_report();
            break;

        case 'insert_CC':
            insert_CC();
            break;

        case 'editar_user':
            editar_user();
            break;

        case 'editar_serv':
            editar_serv();
            break;

        case 'editar_falla':
            editar_falla();
            break;

        case 'editar_cli':
            editar_cli();
            break;

        case 'editar_report':
            editar_report();
            break;

        case 'editar_perfil':
            editar_perfil();
            break;

        case 'editar_datos_sistema';
            editar_datos_sistema();
            break;

        case 'change_password':
            change_password();
            break;

        case 'savePago':
            savePago();
            break;
    }
}

function editar_datos_sistema()
{
    include "db.php";
    extract($_POST);

    // Verificar si se ha seleccionado una nueva imagen
    if (!empty($_FILES['imagen1']['name'])) {
        $imagen_tmps = $_FILES['imagen1']['tmp_name'];
        $imagen_ruta2 = '../img/' . $_FILES['imagen1']['name'];
        move_uploaded_file($imagen_tmps, $imagen_ruta2);

        // Actualizar la ruta de la imagen en la base de datos
        $consultas = "UPDATE datos SET empresa = '$empresa', telefono = '$telefono', cp = '$cp', calles = '$calles', direccion = '$direccion', 
    imagen1 = '$imagen_ruta2' WHERE id = '$id'";
    } else {
        // No se ha seleccionado una nueva imagen, actualizar solo los datos sin cambiar la imagen
        $consultas = "UPDATE datos SET empresa = '$empresa', telefono = '$telefono', cp = '$cp', calles = '$calles', direccion = '$direccion' WHERE id = '$id' ";
    }

    $resultado = mysqli_query($conexion, $consultas);
    if ($resultado === true) {
        echo json_encode("change");
    } else {
        echo json_encode("error");
    }
}


function savePago()
{
    extract($_POST);
    include "db.php";
    date_default_timezone_set('America/Mexico_City');
    $currentDate = date("Y-m-d H:i:s");
    $contar = date("Y-m-d");
    if ($id_cliente != "undefined" || $id_servicio != "undefined") {
        $consulta = "INSERT INTO pagos (id_cliente, id_servicio, pago, contar, fecha) VALUES ('$id_cliente', '$id_servicio', '$pago', '$contar','$currentDate')";
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

function insert_serv()
{
    global $conexion;
    extract($_POST);
    include "db.php";

    $consulta = "INSERT INTO servicios (servicio, precio, estado) VALUES ('$servicio','$precio','$estado')";
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

function insert_falla()
{
    global $conexion;
    extract($_POST);
    include "db.php";

    $consulta = "INSERT INTO fallas (falla) VALUES ('$falla')";
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

function insert_clie()
{
    global $conexion;
    extract($_POST);
    include "db.php";

    // Verificar si el usuario ya está registrado como cliente
    $checkQuery = "SELECT * FROM clientes WHERE id_user = '$id_user'";
    $checkResult = mysqli_query($conexion, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // El usuario ya está registrado como cliente, mostrar una alerta
        $response = array(
            'status' => 'user',
            'message' => 'El usuario seleccionado ya está registrado como cliente.'
        );
        echo json_encode($response);
        return; // Termina la ejecución de la función
    }

    // El usuario no está registrado como cliente, proceder con la inserción
    $folio = mt_rand(100000000, 999999999);
    $consulta = "INSERT INTO clientes (id_user, folio, nombres, apellidos, edad, telefono, correo, domicilio, id_servicio,
        status, fecha_pago) VALUES ('$id_user','$folio','$nombres','$apellidos','$edad','$telefono','$correo','$domicilio','$id_servicio',
        '$status','$fecha_pago')";
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


function insert_CC()
{
    global $conexion;
    extract($_POST);
    include "db.php";
    $folio = mt_rand(100000000, 999999999);
    $status = 'Pendiente';
    $fecha_pago = 'Pendiente';
    $consulta = "INSERT INTO clientes (folio, id_user, nombres, apellidos, edad, telefono, correo, domicilio, id_servicio,
    status, fecha_pago) VALUES ('$folio','$id_user','$nombres','$apellidos','$edad','$telefono','$correo','$domicilio','$id_servicio',
    '$status','$fecha_pago')";
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

function insert_report()
{
    global $conexion;
    extract($_POST);
    include "db.php";

    $consulta = "INSERT INTO reportes (id_cliente, id_servicio, id_falla, observacion, estado, fecha_reporte) 
    VALUES ('$id_cliente','$id_servicio','$id_falla','$observacion','$estado','$fecha_reporte')";
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

function editar_serv()
{
    require_once("db.php");
    extract($_POST);
    $consulta = "UPDATE servicios SET servicio = '$servicio', precio = '$precio', estado = '$estado' WHERE id = '$id' ";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo json_encode("correcto");
    } else {
        echo json_encode("error");
    }
}

function editar_falla()
{
    require_once("db.php");
    extract($_POST);
    $consulta = "UPDATE fallas SET falla = '$falla' WHERE id = '$id' ";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo json_encode("correcto");
    } else {
        echo json_encode("error");
    }
}

function editar_cli()
{
    require_once("db.php");
    extract($_POST);
    $consulta = "UPDATE clientes SET nombres = '$nombres', apellidos = '$apellidos', edad = '$edad', telefono = '$telefono', correo = '$correo'
    , domicilio = '$domicilio', id_servicio = '$id_servicio', status = '$status', fecha_pago = '$fecha_pago' WHERE id = '$id' ";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo json_encode("correcto");
    } else {
        echo json_encode("error");
    }
}

function editar_report()
{
    require_once("db.php");
    extract($_POST);
    $consulta = "UPDATE reportes SET id_cliente = '$id_cliente', id_servicio = '$id_servicio', id_falla = '$id_falla', 
    observacion = '$observacion', estado = '$estado', fecha_reporte = '$fecha_reporte' WHERE id = '$id' ";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo json_encode("correcto");
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

function editar_perfil()
{
    require_once("db.php");
    extract($_POST);

    // Verificar si se ha seleccionado una nueva imagen
    if (!empty($_FILES['imagen']['name'])) {
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $imagen_ruta = '../img/perfiles/' . $_FILES['imagen']['name'];
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
