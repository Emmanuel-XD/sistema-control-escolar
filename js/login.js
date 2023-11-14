const btnSub = document.getElementById("loginForm");
btnSub.addEventListener('submit', function (e) {
    e.preventDefault();
    let userData = new FormData(document.forms.namedItem("loginData"));
    userData.append("login", "login");
    fetch('../sesion/sesionValidate.php', {
            method: 'POST',
            body: userData
        })
        .then((res) => res.json())
        .then((response) => {
            if (response.response === "success") {
                // Redirige al cliente a una vista diferente
                if (response.type === "3") {
                    window.location.replace("../../home/consult_student.php");
                } else {
                    window.location.replace("../../views/index.php"); // Redirige al administrador y empleado
                }
            } else {
                // Muestra la alerta en caso de error
                var valHtml = `<div class="text-center alert alert-danger" role="alert">Hay un error con tu usuario o contraseña. Inténtalo de nuevo</div>`;
                document.getElementById("alert").innerHTML = valHtml;
                setTimeout(() => {
                    document.getElementById("alert").innerHTML = ``;
                }, 2500);
            }
        })
        .catch((error) => {
            console.error("Error en la solicitud:", error);
            // Puedes mostrar un mensaje de error genérico en caso de un problema en la solicitud
            var valHtml = `<div class="text-center alert alert-danger" role="alert">Error en la solicitud. Inténtalo de nuevo.</div>`;
            document.getElementById("alert").innerHTML = valHtml;
            setTimeout(() => {
                document.getElementById("alert").innerHTML = ``;
            }, 2500);
        });
});