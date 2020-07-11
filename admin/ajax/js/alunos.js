function presenca() {

  const urlLocal = "http://localhost/"; //Não esqueça da barra no fim do host

  var date = $('#date_pres').val();
  var hora = $('#hour_pres').val();

  $.ajax({
    url: urlLocal+'presenca/admin/ajax/php/alunos.php',
    data: {'date_pres':date, 'hour_pres':hora},
    method: 'post',
    success: function(data) {
      $('tr').remove('#resultado');
      $('#tableBody').append(data);
    }
  });

  return false;

}
