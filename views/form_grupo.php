<div class="modal fade" id="grupo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h3 class="modal-title" id="exampleModalLabel">Agregar nuevo grupo</h3>
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">

                <form id="addForm">


                    <div class="form-group">
                        <label for="nombre" class="form-label">Grupo</label>
                        <input type="text" id="grupo" name="grupo" class="form-control" required>
                    </div>


                    <br>

                    <input type="hidden" name="accion" value="insert_grupo">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="register" name="registrar">Guardar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>

            </div>

            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#addForm').submit(function(e) {
            e.preventDefault(); 
            var formData = $(this).serialize(); 
            $.ajax({
                url: '../includes/functions.php',
                type: 'POST',
                data: formData,
                dataType: 'json', 
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Datos Guardados',
                            text: 'Los datos se guardaron correctamente'
                        }).then(function() {
                            window.location = "grupos.php"; 
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error inesperado'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error inesperado'
                    });
                }
            });
        });
    });
</script>