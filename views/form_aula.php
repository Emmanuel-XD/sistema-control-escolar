<div class="modal fade" id="aula" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h3 class="modal-title" id="exampleModalLabel">Agregar nueva aula</h3>
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">

                <form id="aulaForm">


                    <div class="form-group">
                        <label for="nombre" class="form-label">Descripcion</label>
                        <input type="text" id="aula" name="aula" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="nombre" class="form-label">Estado del Aula</label>
                        <select name="estado" id="estado" class="form-control">
                            <option value="">Selecciona una opcion</option>
                            <option value="Disponible">Disponible</option>
                            <option value="No Disponible">No Disponible</option>
                            <option value="En Mantenimiento">En Mantenimiento</option>
                        </select>
                    </div>


                    <br>

                    <input type="hidden" name="accion" value="insert_aula">
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
        $('#aulaForm').submit(function(e) {
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
                            location.reload();
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