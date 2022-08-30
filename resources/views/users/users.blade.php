@section('header')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script> 
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link href="{{ URL::to('/') }}/dist/css/style_datatables.css" rel="stylesheet" />
@stop
@include('../layout.header')

@include('../layout.sidebar')

@section('content')


<div class="row">
  <div class="col-lg-6"></div>
  <div class="col-lg-6"><button type="button" id="generarUsuarioNuevo" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#agregarUsuarioModal" >Agregar usuario</button></div>
</div>
<br>
<table class="table table-bordered table-hover" id="data-table">
  <thead>
      <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Email</th>  
          <th>Teléfono</th>
          <th>RFC</th>          
          <th></th>            
      </tr>
  </thead>
  <tbody>
  </tbody>
</table>

@stop
@include('../layout.body')

@include('../layout.footer')
@include('../layout.js')


@include('../layout.datatablejs')

<!-- Agregar Modal -->
<div class="modal fade" id="agregarUsuarioModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form action="#" method="POST" id="agregarUsuario">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="row">
                <div class="col-lg-6">
                    <label for="name">Nombre:</label>
                    <input type="text" class="form-control alpha-only" id="name" name="name" maxlength="255" required />
                    <div class="invalid-feedback" id="invalid-name-required">El nombre es requerido</div>
                </div>
                <div class="col-lg-6">
                  <label for="mail">Email:</label>
                  <input type="text" class="form-control email-only" id="mail" name="mail" maxlength="255" required />
                  <div class="invalid-feedback" id="invalid-email-required">El email es requerido</div>
                  <div class="invalid-feedback" id="invalid-email-valid-required">Ingresa un email válido</div>
              </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-6">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" maxlength="40" required onkeyup="validar_clave()" />
                    <div class="invalid-feedback" id="invalid-pass-required">El password es requerido</div>
                    <div class="invalid-feedback" id="invalid-passUs">La contraseña debe tener 10 caracteres minimo,
                        al menos una letra mayuscula, un número y un caracter especial permitido (@$!%*?&).</div>
                </div>
                <div class="col-lg-6">
                  <label for="confirm-password">Confirma password:</label>
                  <input type="password" class="form-control" id="confirm-password" name="confirm-password" maxlength="40" required />
                  <div class="invalid-feedback" id="invalid-pass-confirm-required">Es necesario confirmar el password</div>
                  <div class="invalid-feedback" id="invalid-pass-confirm-valid">Los password no coinciden</div>
                </div>
            </div>
        </div>
        <div class="form-group">
          <div class="row">
              <div class="col-lg-6">
                  <label for="rfc">RFC:</label>
                  <input type="text" class="form-control rfc-only" id="rfc" name="rfc" maxlength="13" />
                  <div class="invalid-feedback" id="invalid-rfc-required">El RFC es necesario</div>
                  <div class="invalid-feedback" id="invalid-rfc-valid">Ingresa un RFC válido</div>
              </div>
              <div class="col-lg-6">
                  <label for="phone">Teléfono:</label>
                  <input type="text" class="form-control numeric-only" id="phone" name="phone" maxlength="12" />
              </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
              <div class="col-lg-12">
                  <label for="note">Notas:</label>
                  <textarea class="form-control" id="note" name="note" rows="4" cols="50" maxlength="500">
                  </textarea>
              </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12 invalid-feedback showErrors"><br>
            Completa los campos que se te piden
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12 alert alert-danger alert-dismissible fade show" id="erroresAgregar" style="display: none;">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="guardarUsuario">Guardar</button>
      </div>
    </div>
    </form>
  </div>
</div>


<!-- Agregar Modal -->
<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form action="#" method="POST" id="editarUsuario">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="row">
                <div class="col-lg-6">
                    <label for="name">Nombre:</label>
                    <input type="text" class="form-control alpha-only" id="nameEdit" name="nameEdit" maxlength="255" required />
                    <div class="invalid-feedback" id="invalid-name-required-Edit">El nombre es requerido</div>
                </div>
                <div class="col-lg-6">
                  <label for="mail">Email:</label>
                  <input type="text" class="form-control email-only" id="mailEdit" name="mailEdit" maxlength="255" required />
                  <div class="invalid-feedback" id="invalid-email-required-Edit">El email es requerido</div>
                  <div class="invalid-feedback" id="invalid-email-valid-required-Edit">Ingresa un email válido</div>
              </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-6">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="passwordEdit" name="passwordEdit" maxlength="40" required onkeyup="validar_clave_edit()" />
                    <div class="invalid-feedback" id="invalid-pass-required-Edit">El password es requerido</div>
                    <div class="invalid-feedback" id="invalid-passUs-Edit">La contraseña debe tener 10 caracteres minimo,
                        al menos una letra mayuscula, un número y un caracter especial permitido (@$!%*?&).</div>
                </div>
                <div class="col-lg-6">
                  <label for="confirm-password">Confirma password:</label>
                  <input type="password" class="form-control" id="confirm-passwordEdit" name="confirm-passwordEdit" maxlength="40" required />
                  <div class="invalid-feedback" id="invalid-pass-confirm-required-Edit">Es necesario confirmar el password</div>
                  <div class="invalid-feedback" id="invalid-pass-confirm-valid-Edit">Los password no coinciden</div>
                </div>
            </div>
        </div>
        <div class="form-group">
          <div class="row">
              <div class="col-lg-6">
                  <label for="rfc">RFC:</label>
                  <input type="text" class="form-control rfc-only" id="rfcEdit" name="rfcEdit" maxlength="13" />
                  <div class="invalid-feedback" id="invalid-rfc-required-Edit">El RFC es necesario</div>
                  <div class="invalid-feedback" id="invalid-rfc-valid-Edit">Ingresa un RFC válido</div>
              </div>
              <div class="col-lg-6">
                  <label for="phone">Teléfono:</label>
                  <input type="text" class="form-control numeric-only" id="phoneEdit" name="phoneEdit" maxlength="12" />
              </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
              <div class="col-lg-12">
                  <label for="note">Notas:</label>
                  <textarea class="form-control" id="noteEdit" name="noteEdit" rows="4" cols="50" maxlength="500">
                  </textarea>
              </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12 invalid-feedback showErrorsEdit"><br>
            Completa los campos que se te piden
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12 alert alert-danger alert-dismissible fade show" id="erroresAgregarEditar" style="display: none;">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="idUsuarioEdit" id="idUsuarioEdit" />
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="modificarUsuario">Modificar</button>
      </div>
    </div>
    </form>
  </div>
</div>

<script type="text/javascript">
  let table;

  $(function () {
     
    table = $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            {
              extend: 'pdfHtml5',
              text: 'PDF',
              title: 'Usuarios',
              exportOptions: {
                    columns: [ 0, 1, 2, 3, 4]
              },
              customize: function (doc) {
                           doc.defaultStyle.fontSize = 8; //2, 3, 4,etc
                           doc.styles.tableHeader.fontSize = 12; //2, 3, 4, etc
                           doc.content[1].table.widths = [ '5%',  '35%', '30%', '15%', 
                                                           '15%'];
              }
            },
            {
                extend: 'csv',
                text: 'CSV',
                title: 'Usuarios',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4]
                },
                customize: function (csv) {
                  var split_csv = csv.split("\n");
 
                  //Remove the row one to personnalize the headers
                  split_csv[0] = '"ID","Nombre","Email","Telefono","RFC"';
                  csv = split_csv.join("\n");
                  return csv;
                }
            }
        ],
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
        ajax: "/usuarios",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'rfc', name: 'rfc'},
            {data: 'action', name: 'action'},          
        ]
    });
     
  });

  let errores = 0;
  $("#guardarUsuario").click(function(){

    let name = $("#name").val().trim();
    let mail = $("#mail").val().trim();
    let password = $("#password").val().trim();
    let confirm_password = $("#confirm-password").val().trim();
    let rfc = $("#rfc").val().trim();
    let phone = $("#phone").val().trim();
    let note = $("#note").val().trim();

    //validar name
    if(name == '' || name == null){
      $("#invalid-name-required").addClass("showFeedback");
      errores++;
    }
    else{
      $("#invalid-name-required").removeClass("showFeedback");
    }

    //validar email
    if(mail == '' || mail == null){
      $("#invalid-email-required").addClass("showFeedback");
      errores++;
    }
    else{
      $("#invalid-email-required").removeClass("showFeedback");
    }

    if(!isEmail(mail)){
      $("#invalid-email-valid-required").addClass("showFeedback");
      errores++;
    }
    else{
      $("#invalid-email-valid-required").removeClass("showFeedback");
    }

    //validar password
    if(password == '' || password == null){
      $("#invalid-pass-required").addClass("showFeedback");
      errores++;
    }
    else{
      $("#invalid-pass-required").removeClass("showFeedback");
    }

    if(validar_clave()){
      $("#invalid-passUs").removeClass("showFeedback");
    }
    else{
      $("#invalid-passUs").addClass("showFeedback");
      errores++;
    }

    if(confirm_password == '' || confirm_password == null){
      $("#invalid-pass-confirm-required").addClass("showFeedback");
      errores++;
    }
    else{
      $("#invalid-pass-confirm-required").removeClass("showFeedback");
    }

    if(password != confirm_password){
      $("#invalid-pass-confirm-valid").addClass("showFeedback");
      errores++;
    }
    else{
      $("#invalid-pass-confirm-valid").removeClass("showFeedback");
    }

    //validar rfc
    if(rfc == '' || rfc == null){
      $("#invalid-rfc-required").addClass("showFeedback");
      errores++;
    }
    else{
      $("#invalid-rfc-required").removeClass("showFeedback");
    }

    if(rfcValido(rfc)){
      $("#invalid-rfc-valid").removeClass("showFeedback");
    }
    else{
      $("#invalid-rfc-valid").addClass("showFeedback");
      errores++;
    }

    if(errores > 0){
      errores = 0;
      $(".showErrors").css("display","flex");
      setTimeout(function(){
        $(".showErrors").css("display","none");
      }, 5000);
      return;
    }

        $.ajax({
            type: "POST",
            data: { name: name, 
                    email : mail,
                    password: password, 
                    rfc : rfc,
                    phone: phone, 
                    note : note,
                    "_token": "{{ csrf_token() }}" },
            dataType: 'JSON',
            url: "/usersactions",
            success: function(msg){ 
              //console.log(msg);
              if(msg == '1'){

                Lobibox.notify("success", {
                  size: "mini",
                  rounded: true,
                  delay: 3000,
                  delayIndicator: false,
                  position: "center top",
                  msg: "¡Usuario agregado correctamente!",
                });
                table.ajax.reload();
                $("#agregarUsuario").trigger("reset");
                $("#agregarUsuarioModal").modal('hide');
              }
              if(msg == '0'){
                alert('Ocurrio un error');
              }
            },
            error: function (err) {
              console.log(err);
                let mensaje = '';
                let contenido;
                $.each(err.responseJSON.errors, function (key, value) {
                    
                    contenido = replaceContenido(value[0]);
                    mensaje = mensaje + contenido + "<br>";
                    /*$("#" + key).next().html(value[0]);
                    $("#" + key).next().removeClass('d-none');*/
                });
                mensaje = mensaje + '<button type="button" class="close" data-dismiss="alert" aria-label="Close" id="cerrarAlerta">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>';
                $("#erroresAgregar").html(mensaje);
                $("#erroresAgregar").css("display","flex");
            }
        }); 
  });

  function replaceContenido(contenido)
  {
    let nuevo_contenido;
    nuevo_contenido = contenido.replace("name", "nombre");
    nuevo_contenido = contenido.replace("rfc", "RFC");
    return nuevo_contenido;
  }
  
  $(document).on("click", ".eliminar", function(){
    let id = this.id;

    Swal.fire({
      title: '¿Quieres eliminar permanentemente este usuario?',
      showCancelButton: true,
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si'
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {

        $.ajax({
            type: "DELETE",
            dataType: 'JSON',
            data: { "_token": "{{ csrf_token() }}" },
            url: "/usersactions/" + id,
            success: function(msg){ 
              if(msg == '1'){
                Lobibox.notify("success", {
                  size: "mini",
                  rounded: true,
                  delay: 3000,
                  delayIndicator: false,
                  position: "center top",
                  msg: "¡Usuario eliminado!",
                });
                table.ajax.reload();
              }
              if(msg == '0'){
                alert('Ocurrio un error');
              }
            }
        });

      } else if (result.isDenied) {
        
      }
    })
    
  });

  $(document).on("click", ".editar", function(){
    let id = this.id;

    $("#editarUsuario").trigger("reset");
    $("#erroresAgregarEditar").css('display','none');
      $.ajax({
          type: "GET",
          dataType: 'JSON',
          data: { "_token": "{{ csrf_token() }}" },
          url: "/usersactions/" + id,
          success: function(msg){ 
            //console.log(msg);
            
            $("#nameEdit").val(msg.name);
            $("#mailEdit").val(msg.email);
            $("#rfcEdit").val(msg.rfc);
            $("#phoneEdit").val(msg.phone);
            $("#noteEdit").val(msg.note);
            $("#idUsuarioEdit").val(msg.id);
            $("#passwordEdit").val('');
            $("#confirm-passwordEdit").val('');

            $("#editarUsuarioModal").modal("show");
            
          }
      }); 
    
    });

  let erroresEdit = 0;
  $("#modificarUsuario").click(function(){

    let idUsuario = $("#idUsuarioEdit").val().trim();
    let name = $("#nameEdit").val().trim();
    let mail = $("#mailEdit").val().trim();
    let password = $("#passwordEdit").val().trim();
    let confirm_password = $("#confirm-passwordEdit").val().trim();
    let rfc = $("#rfcEdit").val().trim();
    let phone = $("#phoneEdit").val().trim();
    let note = $("#noteEdit").val().trim();

    //validar name
    if(name == '' || name == null){
      $("#invalid-name-required-Edit").addClass("showFeedback");
      erroresEdit++;
    }
    else{
      $("#invalid-name-required-Edit").removeClass("showFeedback");
    }

    //validar email
    if(mail == '' || mail == null){
      $("#invalid-email-required-Edit").addClass("showFeedback");
      erroresEdit++;
    }
    else{
      $("#invalid-email-required-Edit").removeClass("showFeedback");
    }

    if(!isEmail(mail)){
      $("#invalid-email-valid-required-Edit").addClass("showFeedback");
      erroresEdit++;
    }
    else{
      $("#invalid-email-valid-required-Edit").removeClass("showFeedback");
    }

    //validar password
    if(password != ''){

        if(validar_clave_edit()){
          $("#invalid-passUs-Edit").removeClass("showFeedback");
        }
        else{
          $("#invalid-passUs-Edit").addClass("showFeedback");
          erroresEdit++;
        }
    
        if(password != confirm_password){
          $("#invalid-pass-confirm-valid-Edit").addClass("showFeedback");
          erroresEdit++;
        }
        else{
          $("#invalid-pass-confirm-valid-Edit").removeClass("showFeedback");
        }
    }

    //validar rfc
    if(rfc == '' || rfc == null){
      $("#invalid-rfc-required-Edit").addClass("showFeedback");
      erroresEdit++;
    }
    else{
      $("#invalid-rfc-required-Edit").removeClass("showFeedback");
    }

    if(rfcValido(rfc)){
      $("#invalid-rfc-valid-Edit").removeClass("showFeedback");
    }
    else{
      $("#invalid-rfc-valid-Edit").addClass("showFeedback");
      erroresEdit++;
    }


    if(erroresEdit > 0){
      erroresEdit = 0;
      $(".showErrorsEdit").css("display","flex");
      setTimeout(function(){
        $(".showErrorsEdit").css("display","none");
      }, 5000);
      return;
    }

        $.ajax({
            type: "PUT",
            data: { name: name, 
                    email : mail,
                    password: password, 
                    rfc : rfc,
                    phone: phone, 
                    note : note,
                    "_token": "{{ csrf_token() }}" },
            dataType: 'JSON',
            url: "/usersactions/" + idUsuario,
            success: function(msg){ 
              if(msg == '1'){

                Lobibox.notify("success", {
                  size: "mini",
                  rounded: true,
                  delay: 3000,
                  delayIndicator: false,
                  position: "center top",
                  msg: "¡Usuario modificado correctamente!",
                });
                table.ajax.reload();
                $("#editarUsuario").trigger("reset");
                $("#editarUsuarioModal").modal('hide');
              }
              if(msg == '0'){
                Lobibox.notify("error", {
                  size: "mini",
                  rounded: true,
                  delay: 3000,
                  delayIndicator: false,
                  position: "center top",
                  msg: "Ocurrio un error, intentalo nuevamente.",
                });
              }
            },
            error: function (err) {
              console.log(err);
                let mensaje = '';
                let contenido;
                $.each(err.responseJSON.errors, function (key, value) {
                    
                    contenido = replaceContenido(value[0]);
                    mensaje = mensaje + contenido + "<br>";
                    /*$("#" + key).next().html(value[0]);
                    $("#" + key).next().removeClass('d-none');*/
                });
                mensaje = mensaje + '<button type="button" class="close" data-dismiss="alert" aria-label="Close" id="cerrarAlertaEditar">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>';
                $("#erroresAgregarEditar").html(mensaje);
                $("#erroresAgregarEditar").css("display","flex");
            }
        }); 

  });

  $('#rfc,#rfcEdit').keyup(function(){
      $(this).val($(this).val().toUpperCase());
  });

  function isEmail(email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

    return emailReg.test(email);
  }

  $(document).on("change", "#name", function () {
      let name = $("#name").val().trim();

      if(name == '' || name == null){
        $("#invalid-name-required").addClass("showFeedback");
      }
      else{
        $("#invalid-name-required").removeClass("showFeedback");
      }
  });

  $(document).on("change", "#mail", function () {
      let email = $("#mail").val().trim();
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

      if(email == '' || email == null){
        $("#invalid-email-required").addClass("showFeedback");
      }
      else{
        $("#invalid-email-required").removeClass("showFeedback");
      }

      //validar si el email esta validado
      if (!isEmail(email)) {
        $("#invalid-email-valid-required").addClass("showFeedback");
      }
      else {
        $("#invalid-email-valid-required").removeClass("showFeedback");
      }
  });

  function validar_clave() {
      let pass = $("#password").val();

      if(pass == '' || pass == null){
        $("#invalid-pass-required").addClass("showFeedback");
      }
      else{
        $("#invalid-pass-required").removeClass("showFeedback");
      }

      const reg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{10,}$/;
      if (reg.test(pass)) {
        $("#invalid-passUs").removeClass("showFeedback");
        return true;
      } else {
        $("#invalid-passUs").addClass("showFeedback");
        return false;
      }
  }

  $(document).on("change", "#confirm-password", function () {
      let confirm_password = $("#confirm-password").val().trim();
      let password = $("#password").val().trim();

      if(confirm_password == '' || confirm_password == null){
        $("#invalid-pass-confirm-required").addClass("showFeedback");
      }
      else{
        $("#invalid-pass-confirm-required").removeClass("showFeedback");
      }

      if(password != confirm_password){
        $("#invalid-pass-confirm-valid").addClass("showFeedback");
      }
      else{
        $("#invalid-pass-confirm-valid").removeClass("showFeedback");
      }
  });

  $(document).on("change", "#rfc", function () {
      let rfc = $("#rfc").val().trim();

      if(rfc == '' || rfc == null){
      $("#invalid-rfc-required").addClass("showFeedback");
      }
      else{
        $("#invalid-rfc-required").removeClass("showFeedback");
      }

      if(rfcValido(rfc)){
        $("#invalid-rfc-valid").removeClass("showFeedback");
      }
      else{
        $("#invalid-rfc-valid").addClass("showFeedback");
      }
  });

  function rfcValido(rfc, aceptarGenerico = true) {
    var rfcM = rfc.toUpperCase();
    const re =
      /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
    var validado = rfcM.match(re);

    if (!validado)
      //Coincide con el formato general del regex?
      return false;

    //Separar el dígito verificador del resto del RFC
    const digitoVerificador = validado.pop(),
      rfcSinDigito = validado.slice(1).join(""),
      len = rfcSinDigito.length,
      //Obtener el digito esperado
      diccionario = "0123456789ABCDEFGHIJKLMN&OPQRSTUVWXYZ Ñ",
      indice = len + 1;
    var suma, digitoEsperado;

    if (len == 12) suma = 0;
    else suma = 481; //Ajuste para persona moral

    for (var i = 0; i < len; i++)
      suma += diccionario.indexOf(rfcSinDigito.charAt(i)) * (indice - i);
    digitoEsperado = 11 - (suma % 11);
    if (digitoEsperado == 11) digitoEsperado = 0;
    else if (digitoEsperado == 10) digitoEsperado = "A";

    //El dígito verificador coincide con el esperado?
    // o es un RFC Genérico (ventas a público general)?
    if (
      digitoVerificador != digitoEsperado &&
      (!aceptarGenerico || rfcSinDigito + digitoVerificador != "XAXX010101000")
    )
      return false;
    else if (
      !aceptarGenerico &&
      rfcSinDigito + digitoVerificador == "XEXX010101000"
    )
      return false;
    return rfcSinDigito + digitoVerificador;
  }

  function validar_clave_edit() {
      let pass = $("#passwordEdit").val();

      if(pass != ''){

          const reg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{10,}$/;
          if (reg.test(pass)) {
            $("#invalid-passUs-Edit").removeClass("showFeedback");
            return true;
          } else {
            $("#invalid-passUs-Edit").addClass("showFeedback");
            return false;
          }
      }
  }

  //campos de modificacion
  $(document).on("change", "#nameEdit", function () {
      let name = $("#nameEdit").val().trim();

      if(name == '' || name == null){
        $("#invalid-name-required-Edit").addClass("showFeedback");
      }
      else{
        $("#invalid-name-required-Edit").removeClass("showFeedback");
      }
  });

  $(document).on("change", "#mailEdit", function () {
      let email = $("#mailEdit").val().trim();
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

      if(email == '' || email == null){
        $("#invalid-email-required-Edit").addClass("showFeedback");
      }
      else{
        $("#invalid-email-required-Edit").removeClass("showFeedback");
      }

      //validar si el email esta validado
      if (!isEmail(email)) {
        $("#invalid-email-valid-required-Edit").addClass("showFeedback");
      }
      else {
        $("#invalid-email-valid-required-Edit").removeClass("showFeedback");
      }
  });

  $(document).on("change", "#confirm-passwordEdit", function () {
      let confirm_password = $("#confirm-passwordEdit").val().trim();
      let password = $("#passwordEdit").val().trim();

      if(password != confirm_password){
        $("#invalid-pass-confirm-valid-Edit").addClass("showFeedback");
      }
      else{
        $("#invalid-pass-confirm-valid-Edit").removeClass("showFeedback");
      }
  });

  $(document).on("change", "#rfcEdit", function () {
      let rfc = $("#rfcEdit").val().trim();

      if(rfc == '' || rfc == null){
      $("#invalid-rfc-required-Edit").addClass("showFeedback");
      }
      else{
        $("#invalid-rfc-required-Edit").removeClass("showFeedback");
      }

      if(rfcValido(rfc)){
        $("#invalid-rfc-valid-Edit").removeClass("showFeedback");
      }
      else{
        $("#invalid-rfc-valid-Edit").addClass("showFeedback");
      }
  });

  $(document).on("click", "#cerrarAlerta", function () {
    $("#erroresAgregar").css('display','none');
  });

  $(document).on("click", "#generarUsuarioNuevo", function () {
    $("#erroresAgregar").css('display','none');
  });

  $(document).on("click", "#cerrarAlertaEditar", function () {
    $("#erroresAgregarEditar").css('display','none');
  });
</script>