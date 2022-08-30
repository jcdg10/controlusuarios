@section('formulario')

<section class="page-section" id="contact">
<div class="container">

<br><br>

<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Registro</div>
                    <div class="card-body">
                        <form action="#" method="POST" id="agregarUsuario">
                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control alpha-only" id="name" name="name" maxlength="255" required />
                                    <div class="invalid-feedback" id="invalid-name-required">El nombre es requerido</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mail" class="col-md-4 col-form-label text-md-right">Email</label>
                                <div class="col-md-6">
                                    <input type="text" id="mail" class="form-control" name="mail" required>
                                    <div class="invalid-feedback" id="invalid-email-required">El email es requerido</div>
                                    <div class="invalid-feedback" id="invalid-email-valid-required">Ingresa un email válido</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" id="password" name="password" maxlength="40" required onkeyup="validar_clave()" />
                                    <div class="invalid-feedback" id="invalid-password-required">El password es requerido</div>
                                    <div class="invalid-feedback" id="invalid-passUs">La contraseña debe tener 10 caracteres minimo,
                                        al menos una letra mayuscula, un número y un caracter especial permitido (@$!%*?&).</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="confirm-password" class="col-md-4 col-form-label text-md-right">Confirma password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" id="confirm-password" name="confirm-password" maxlength="40" required />
                                    <div class="invalid-feedback" id="invalid-pass-confirm-required">Es necesario confirmar el password</div>
                                    <div class="invalid-feedback" id="invalid-pass-confirm-valid">Los password no coinciden</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="rfc" class="col-md-4 col-form-label text-md-right">RFC:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control rfc-only" id="rfc" name="rfc" maxlength="13" />
                                    <div class="invalid-feedback" id="invalid-rfc-required">El RFC es necesario</div>
                                    <div class="invalid-feedback" id="invalid-rfc-valid">Ingresa un RFC válido</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">Teléfono:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control numeric-only" id="phone" name="phone" maxlength="12" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="note" class="col-md-4 col-form-label text-md-right">Notas:</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" id="note" name="note" rows="4" cols="50" maxlength="500">
                                    </textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 alert alert-danger alert-dismissible fade show" id="erroresAgregar" style="display: none;">
                                </div>
                            </div>

                            <div class="col-md-12 text-center">
                                <button type="button" id="registrarUsuario" class="btn btn-primary">
                                    Registrar
                                </button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</main>

</div>
</section>

@stop

@section('script')
<script>
  let errores = 0;
  $("#note").val('');
  
  $("#registrarUsuario").click(function(){

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
            url: "/usersadd",
            success: function(msg){ 
               // console.log(msg);
              if(msg == '1'){

                Swal.fire({
                    position: 'top-center',
                    icon: 'success',
                    title: 'Registro exitoso! Ahora puedes ingresar al sistema.',
                    showConfirmButton: false,
                    timer: 1500
                })

                setTimeout(function(){
                    window.location = "/login";
                }, 1500);
              }
              else{
                let timerInterval
                Swal.fire({
                title: '',
                html: 'Ocurrio un error. Vuelva a intentarlo.',
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                    b.textContent = Swal.getTimerLeft()
                    }, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
                }).then((result) => {
                /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        console.log('I was closed by the timer')
                    }
                })
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

  $('#rfc').keyup(function(){
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
      const pass = $("#password").val();

      if(pass == '' || pass == null){
        $("#invalid-pass-required").addClass("showFeedback");
      }
      else{
        $("#invalid-pass-required").removeClass("showFeedback");
      }

      const reg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{10,}$/;
      if (reg.test(pass)) {
        document.getElementById("invalid-passUs").style.display = "none";
        return true;
      } else {
        document.getElementById("invalid-passUs").style.display = "block";
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

  $(document).on("click", "#cerrarAlerta", function () {
    $("#erroresAgregar").css('display','none')
  });

  function replaceContenido(contenido)
  {
    let nuevo_contenido;
    nuevo_contenido = contenido.replace("name", "nombre");
    nuevo_contenido = contenido.replace("rfc", "RFC");
    return nuevo_contenido;
  }
</script>
@stop
@include('../layout_welcome.layout')