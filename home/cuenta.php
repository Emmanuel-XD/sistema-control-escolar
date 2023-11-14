<?php
error_reporting(0);
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #f2f2f2;
        }

        .container {
            margin-top: 10px;
        }

        #login-box {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        h3 {
            color: #333333;
            font-family: Arial, sans-serif;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }

        p {
            color: #666666;
            font-family: Arial, sans-serif;
            font-size: 16px;
            text-align: center;
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-control:focus {
            outline: none;
            box-shadow: 0 0 5px #b4d5ff;
        }

        .btn {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: #ffffff;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: #ffffff;
        }

        .btn-success:hover,
        .btn-danger:hover {
            opacity: 0.8;
        }

        .text-center {
            text-align: center;
        }

        .justify-content-center {
            justify-content: center;
        }

        .align-items-center {
            align-items: center;
        }
    </style>
</head>

<body>
    <form id="registro" action="registros.php" method="POST">
        <br>
        <br>
        <br>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <h3 class="text-center">Crear Cuenta de Usuario</h3>
                        <br>
                        <p>Para poder generar tu cuenta primero debes completar algunos pasos. Rellena todos los campos</p>
                        <br>
                        <div class="form-group">
                            <label for="nombre" class="form-label">Nombre *</label>
                            <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Escribe tu nombre de usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="username" class="form-label">Correo:</label><br>
                            <input type="email" name="correo" id="correo" class="form-control" placeholder="Escribe un correo válido">
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Contraseña:</label><br>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Escribe tu contraseña" required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Confirmar contraseña:</label><br>
                            <input type="password" name="password2" id="password2" class="form-control" placeholder="Escribe tu contraseña" required>
                        </div>
                        <div class="form-group">
                            <label for="rol" class="form-label">Tipo de Usuario:</label>
                            <select name="id_rol" id="id_rol" class="form-control" disabled required>
                                <option value="3">Cliente</option>
                            </select>
                        </div>
                        <br>
                        <br>
                        <div class="mb-3">
                            <center>
                                <button type="button" id="register" class="btn btn-success" name="registrar">Guardar</button>
                                <a href="../includes/sesion/login.php" class="btn btn-danger">Regresar</a>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script src="../package/dist/sweetalert2.all.js"></script>
    <script src="../package/dist/sweetalert2.all.min.js"></script>

    <script type="text/javascript">
        $('#registro input').blur(function() {
            if ($(this).val().length === 0) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        $('#register').click(function(e) {
            e.preventDefault();
            var valid = this.form.checkValidity();
            if (valid) {
                var datos = new FormData();
                datos.append('usuario', $('#usuario').val())
                datos.append('correo', $('#correo').val())
                datos.append('password', $('#password').val())
                datos.append('password2', $('#password2').val())
                datos.append('id_rol', $('#id_rol').val())

                fetch('validar.php', {
                    method: 'POST',
                    body: datos,
                }).then((response) => response.json()).then((response => {
                    confirmation(response);
                }))
            } else {
                var errors = 0;
                $('#registro input').map(function() {
                    if ($(this).val().length === 0) {
                        $(this).addClass('is-invalid');
                        errors++
                    }
                });
            }
        });

        function confirmation(r) {
            if (r === 'success') {
                Swal.fire({
                    'title': 'Datos Guardados',
                    'text': 'El registro fue guardado exitosamente.',
                    'icon': 'success',
                    'showConfirmButton': 'false',
                    'timer': '1500'
                }).then(function() {
                    window.location = "contrato.php";
                });
            }
            if (r === 'error') {
                Swal.fire({
                    'title': 'Error',
                    'text': 'No se creo el usuario',
                    'icon': 'error'
                })
            }
            if (r === 'mail') {
                Swal.fire({
                    'title': 'Usuario Existente',
                    'text': 'Este usuario ya esta registrado prueba con otro o inicia sesión',
                    'icon': 'warning'
                })
            }
            if (r === 'pass') {
                Swal.fire({
                    'title': 'Password Invalido',
                    'text': 'Las contraseñas no coinciden',
                    'icon': 'info'
                })
            }


        }
    </script>
</body>

</html>