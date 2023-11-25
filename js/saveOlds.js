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
          // Add more columns as needed
      ]
  });
function updatetable() {
  var table = $('#dataTable').DataTable();
  var periodEval = $("#id_periodo").val()
  var numGrade = $("#id_grade").val()
  var pdf = document.getElementById("genCalif")
  if(periodEval === "" && numGrade === "" ){
      $(".is-completed").show()
      $(".is-completed").html("Selecciona un periodo y el numero de evaluación.")
      table.clear().draw();
      pdf.disabled = true;
      pdf.classList.add('btn-secondary');
      pdf.classList.remove('btn-danger');
  }
  if(periodEval === "" && numGrade >= 1 ){
      $(".is-completed").show()
      $(".is-completed").html("Selecciona un periodo.")
      table.clear().draw();
      pdf.disabled = true;
      pdf.classList.add('btn-secondary');
      pdf.classList.remove('btn-danger');
  }
  if(periodEval >= 1 && numGrade === "" ){
      $(".is-completed").show()
      $(".is-completed").html("Selecciona un numero de evaluación.")
      table.clear().draw();
      pdf.disabled = true;
      pdf.classList.add('btn-secondary');
      pdf.classList.remove('btn-danger');
  }
  if(periodEval >= 1 && numGrade >= 1 ){
      $(".is-completed").hide()
      $(".is-completed").html("")
      pdf.disabled = false;
      pdf.classList.remove('btn-secondary');
      pdf.classList.add('btn-danger');
      gradesAssign(periodEval, numGrade);
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
function gradesAssign(periodEval, numGrade){
  showLoadingAlert();
  
  var idStudent = urlParams.get('id') 

  const data = new FormData()
  data.append('perEval', periodEval)
  data.append('numGrade', numGrade)
  data.append('idStudent', idStudent)

  fetch('../views/obtener_califHis.php', {
      method: 'POST',
      body: data, 
    }).then(response => response.json()).then(data => {
      hideLoadingAlert();
        dataTable.clear().draw();
        if (Array.isArray(data)) {
          // Add rows to the DataTable
          data.forEach(item => {
              dataTable.row.add([
                  item.materia,
                  item.grade,
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
$("#id_periodo, #id_grade").change(function (e) { 
    e.preventDefault();
    updatetable();
       
});
$("#genCalif").click(function (e) {
  e.preventDefault();
  showLoadingAlert()
  
  var periodEval = $("#id_periodo").val();
  var idStudent = urlParams.get('id');
  var numGrade = $("#id_grade").val()
  const data = new FormData();
  data.append('perEval', periodEval);
  data.append('grado', numGrade);
  data.append('idStudent', idStudent);

  fetch('../includes/boletaHistory.php', {
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
