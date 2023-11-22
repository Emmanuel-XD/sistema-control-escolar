document.addEventListener('DOMContentLoaded', function () {
  const url = window.location.href;
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  // Initialize DataTable
  var dataTable = $('#dataTable').DataTable({
      columns: [
        { title: 'Materia' }, // Assuming the 'id' property is the unique identifier
        { title: 'Calificación' },
        {title: 'Actions'}
          // Add more columns as needed
      ]
  });
function updatetable() {
  var table = $('#dataTable').DataTable();
  var periodEval = $("#id_periodo").val()
  var numEval = $("#id_evaluacion").val()

  if(periodEval === "" && numEval === "" ){
      $(".is-completed").show()
      $(".is-completed").html("Selecciona un periodo y el numero de evaluación.")
      table.clear().draw();
      console.log("1")
  }
  if(periodEval === "" && numEval >= 1 ){
      $(".is-completed").show()
      $(".is-completed").html("Selecciona un periodo.")
      console.log("2")
      table.clear().draw();
  }
  if(periodEval >= 1 && numEval === "" ){
      $(".is-completed").show()
      $(".is-completed").html("Selecciona un numero de evaluación.")
      console.log("3")
      table.clear().draw();
  }
  if(periodEval >= 1 && numEval >= 1 ){
      $(".is-completed").hide()
      $(".is-completed").html("")
      console.log("4")
      gradesAssign(periodEval, numEval);
  }
}
function gradesAssign(periodEval, numEval){

  
  var idStudent = urlParams.get('id') 

  const data = new FormData()
  data.append('perEval', periodEval)
  data.append('numEval', numEval)
  data.append('idStudent', idStudent)

  fetch('obtener_calificacion.php', {
      method: 'POST',
      body: data, // Include the FormData object as the request body
    }).then(response => response.json()).then(data => {
      
        console.log('Response data: ', data);
        dataTable.clear().draw();
        if (Array.isArray(data)) {
          // Add rows to the DataTable
          data.forEach(item => {
              dataTable.row.add([
                  item.materia,
                  item.grade,
                  '<button type="button" class="btn btn-dark edit-btn" data-id="' + item.id + '">Editar / asignar calificación</button>'
                  // Add more data fields as needed
              ]).draw(true); // 'false' to append rows without redrawing the table
          });
      } else {
          console.error('Error: Data is not an array');
      }
      })
      .catch(error => {
        console.error('Error:', error);
      });

}
$("#id_periodo, #id_evaluacion").change(function (e) { 
    e.preventDefault();
    updatetable();
       
});

$('#dataTable').on('click', '.edit-btn', function () {
  var rowId = $(this).data('id');
    
    // Get the data of the clicked row
    var rowData = dataTable.row($(this).closest('tr')).data();

    // Extract the value of the second column (index 1)
    var firstColumnValue = rowData[0];
    var secondColumnValue = rowData[1];

    // Print the value and add an input field
    $('#modalContent').html(`
        <p>Seleccionada la materia:<b> ${firstColumnValue} </b></p>
        <p>Calificación actual: ${secondColumnValue}</p>
        <div class="form-group">
            <label for="newInput">Nueva calificación:</label>
            <input type="number" class="form-control" id="newInput" max="100" min="0" placeholder="Ingresa la nueva calificación">
        </div>
    `);

   // Add "Confirm Changes" button
   $('#modalContent').append(`
   <button class="btn btn-primary" id="confirmChangesBtn">Confirmar cambios</button>
`);

// Open the modal
$('#editModal').modal('show');
  // Add click event listener to the "Confirm Changes" button
  $('#confirmChangesBtn').on('click', function () {
    // Retrieve the value entered in the input field
    var newValue = $('#newInput').val();

    if (!newValue.trim()) {
      Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Verifica que el valor de la calificación sea valido!',
      });
      return; // Stop further execution if the input is empty
  }
  console.log('New Value:', newValue);
 var idStudent = urlParams.get('id');
var data =  new FormData();
data.append('idStudent', idStudent);
data.append("newcalif", newValue);
data.append("idmateria",rowId);
  fetch('updatecalif.php', {
    method: 'POST',
    body: data, // Include the FormData object as the request body
  }).then(response => response.json()).then(data => {
    if (data.status === 'success') {
        // The update was successful, you can show a success message
        updatetable();
        $('#editModal').modal('hide');
    } else {
        // The update failed, you can show an error message
        console.error(data.message);
    }
})
.catch((error) => {
    console.error('Error:', error);
});


});
});

$('#dataTable').on('click', '.delete-btn', function () {
  var rowId = $(this).data('id');
  // Handle delete action for the row with ID = rowId
  console.log('Delete clicked for row ID:', rowId);
});
});
