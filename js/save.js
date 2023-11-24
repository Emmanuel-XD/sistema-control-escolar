document.addEventListener('DOMContentLoaded', function () {
  const url = window.location.href;
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  var pdf = document.getElementById("genCalif")
  pdf.disabled = true;
  pdf.classList.add('btn-secondary');
  pdf.classList.remove('btn-danger');
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
  var pdf = document.getElementById("genCalif")
  if(periodEval === "" && numEval === "" ){
      $(".is-completed").show()
      $(".is-completed").html("Selecciona un periodo y el numero de evaluación.")
      table.clear().draw();
      pdf.disabled = true;
      pdf.classList.add('btn-secondary');
      pdf.classList.remove('btn-danger');
  }
  if(periodEval === "" && numEval >= 1 ){
      $(".is-completed").show()
      $(".is-completed").html("Selecciona un periodo.")
      table.clear().draw();
      pdf.disabled = true;
      pdf.classList.add('btn-secondary');
      pdf.classList.remove('btn-danger');
  }
  if(periodEval >= 1 && numEval === "" ){
      $(".is-completed").show()
      $(".is-completed").html("Selecciona un numero de evaluación.")
      table.clear().draw();
      pdf.disabled = true;
      pdf.classList.add('btn-secondary');
      pdf.classList.remove('btn-danger');
  }
  if(periodEval >= 1 && numEval >= 1 ){
      $(".is-completed").hide()
      $(".is-completed").html("")
      pdf.disabled = false;
      pdf.classList.remove('btn-secondary');
      pdf.classList.add('btn-danger');
      gradesAssign(periodEval, numEval);
  }
}
function showLoadingAlert() {
  Swal.fire({
    title: 'Cargando datos...',
    allowOutsideClick: false,
    showConfirmButton: false,
    html: '<div class="spinner-border" role="status"><span class="visually-hidden"></span></div>',
    onBeforeOpen: () => {
      // You can customize the loading animation style further if needed
    },
  });
}
function hideLoadingAlert() {
  Swal.close();
}
function gradesAssign(periodEval, numEval){
  showLoadingAlert();
  
  var idStudent = urlParams.get('id') 

  const data = new FormData()
  data.append('perEval', periodEval)
  data.append('numEval', numEval)
  data.append('idStudent', idStudent)

  fetch('obtener_calificacion.php', {
      method: 'POST',
      body: data, 
    }).then(response => response.json()).then(data => {
      hideLoadingAlert();
        console.log('Response data: ', data);
        dataTable.clear().draw();
        if (Array.isArray(data)) {
          // Add rows to the DataTable
          data.forEach(item => {
              dataTable.row.add([
                  item.materia,
                  item.grade,
                  '<button type="button" class="btn btn-dark edit-btn" data-id="' + item.id + '">Editar / asignar calificación</button>'
              ]).draw(true);
          });
      } else {
          console.error('Error: Data is not an array');
      }
      })
      .catch(error => {
        console.error('Error:', error);
        hideLoadingAlert();
      });

}
$("#id_periodo, #id_evaluacion").change(function (e) { 
    e.preventDefault();
    updatetable();
       
});
$('#dataTable').on('click', '.edit-btn', function () {
  var rowId = $(this).data('id');
      var table = $('#dataTable').DataTable();
  var periodEval = $("#id_periodo").val()
  var numEval = $("#id_evaluacion").val()
    var rowData = dataTable.row($(this).closest('tr')).data();

    var firstColumnValue = rowData[0];
    var secondColumnValue = rowData[1];

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
 var idStudent = urlParams.get('id');
var data =  new FormData();
data.append('perEval', periodEval)
data.append('numEval', numEval)
data.append('idStudent', idStudent);
data.append("newcalif", newValue);
data.append("idmateria",rowId);
  fetch('updatecalif.php', {
    method: 'POST',
    body: data, 
  }).then(response => response.json()).then(data => {
    if (data.status === 'success') {

        updatetable();
        $('#editModal').modal('hide');
    } else {
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
$("#genCalif").click(function (e) {
  e.preventDefault();
  showLoadingAlert()
  
  var periodEval = $("#id_periodo").val();
  var idStudent = urlParams.get('id');
  
  const data = new FormData();
  data.append('perEval', periodEval);
  data.append('idStudent', idStudent);

  fetch('../includes/boleta.php', {
    method: 'POST',
    body: data,
  })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.blob();
    })
    .then(blob => {
      console.log('PDF fetched successfully');

      // Create a Blob URL for the PDF
      const url = URL.createObjectURL(blob);

      // Open the PDF in a new window
      const newWindow = window.open('', '_blank');
      newWindow.document.write('<iframe width="100%" height="100%" src="' + url + '"></iframe>');
      hideLoadingAlert()
    })
    .catch(error => {
      hideLoadingAlert()
      console.error('Error fetching or displaying the PDF:', error);

      // Handle specific error scenarios if needed
      if (error.name === 'AbortError') {
        console.log('Fetch aborted');
      } else {
        console.log('Other error occurred');
      }
    });
});

});
