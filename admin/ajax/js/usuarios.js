const urlLocal = "http://localhost/"; //Não esqueça da barra no fim do host

//Fazer o update dos usuários
function passarValorUpdate(idNum){
  var id = document.getElementById("userUpdate"+idNum).value;
  document.getElementById("updateModal").value = id;

  var name = document.getElementById("nameUser"+idNum).innerHTML;
  document.getElementById("name").value = name;

  var last_name = document.getElementById("lastNameUser"+idNum).innerHTML;
  document.getElementById("last_name").value = last_name;

  var registration = document.getElementById("registrationUser"+idNum).innerHTML;
  document.getElementById("registration").value = registration;

  var email = document.getElementById("emailUser"+idNum).innerHTML;
  document.getElementById("email").value = email;
}

//Passa o id para excluir determinado usuário
// function passarValor(idNum){
//   var id = document.getElementById("userDel"+idNum).value;
//   document.getElementById("delModal").value = id;
// }

//Mostrar o campo para alterar a senha
var btn_pass = document.getElementById('btn_pass');
var div_pass = document.getElementById('div_pass');

btn_pass.addEventListener('click', function() {
  if(div_pass.style.display != 'block') {
    div_pass.style.display = 'block';
    document.getElementById("btn_pass").innerHTML = 'Esconder Senha';
    return;
  }
  div_pass.style.display = 'none';
  document.getElementById("btn_pass").innerHTML = 'Mostrar Senha';
});


//Verifica se a tecla digitada foi o ENTER, para não atualizar a página e enviar o formulário
function enterSubmit(){

$('#search').keypress(function(e){

if(e.keyCode == 10 || e.keyCode == 13){

e.preventDefault();

}

});

}



//Faz a pesquisa conforme o usuário digita na caixa de busca
function pesquisarUsuario() {

  var search = $('#search').val();

  $.ajax({
    url: urlLocal+'presenca/admin/ajax/php/usuarios.php',
    data: {'search':search},
    dataType: 'JSON',
    method: 'post',
    success: function(data) {

      $("tr").remove("#resultado");

      var usuarios = data;

      $.each(usuarios, function(i, usuario){

        var linhas = '<tr id="resultado">';
        linhas += '<th>'+usuario.id+'</th>';
        linhas += '<td id="nameUser'+usuario.id+'">'+usuario.name+'</td>';
        linhas += '<td id="lastNameUser'+usuario.id+'">'+usuario.last_name+'</td>';
        linhas += '<td id="registrationUser'+usuario.id+'">'+usuario.registration+'</td>';
        linhas += '<td id="emailUser'+usuario.id+'">'+usuario.email+'</td>';
        linhas += '<td> <button type="button" class="btn btn-info btn-block mb-1" id="userUpdate'+usuario.id+'" value="'+usuario.id+'" onclick="passarValorUpdate('+usuario.id+')" title="Editar usuário" data-toggle="modal" data-target="#alterarUsuario"><i class="fas fa-edit"></i></button> </td>';

        $("#tableBody").append(linhas);

      });

    }
  });

  if(search==""){
    $("tr").remove("#resultado");
  }

}


//Faz o update do usuário
function atualizarUsuario(){

  var name = $('#name').val();
  var last_name = $('#last_name').val();
  var registration = $('#registration').val();
  var email = $('#email').val();
  var id = $('#updateModal').val();

  $.ajax({
    url: urlLocal+'presenca/admin/ajax/php/update-user.php',
    data: {'name':name, 'last_name':last_name, 'registration':registration, 'email':email, 'update':id},
    method: 'post',
    success: function(data) {
      $("#closeModal").click();
      pesquisarUsuario();
    }

  });

  atualizarSenhaUsuario();
}


//Faz o update somente da senha
function atualizarSenhaUsuario(){

  var pass = $('#pass').val();
  var id = $('#updateModal').val();

  $.ajax({
    url: urlLocal+'presenca/admin/ajax/php/update-pass.php',
    data: {'pass':pass, 'update':id},
    method: 'post',
    success: function(data) {
      $("#closeModal").click();
      pesquisarUsuario();
    }

  });
}
