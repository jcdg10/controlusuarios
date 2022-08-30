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
                    mail : mail,
                    password: password, 
                    rfc : rfc,
                    phone: phone, 
                    note : note,
                    "_token": "{{ csrf_token() }}" },
            dataType: 'JSON',
            url: "/usersactions",
            success: function(msg){ 
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
                $("#agregarUsuarioModal").modal('hide');
              }
              if(msg == '0'){
                alert('Ocurrio un error');
              }
            }
        }); 
  });
  
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

      $.ajax({
          type: "GET",
          dataType: 'JSON',
          data: { "_token": "{{ csrf_token() }}" },
          url: "/product/" + id,
          success: function(msg){ 
            //console.log(msg);
            $("#nombreProductoEdit").val(msg.name);
            $("#precioEdit").val(msg.price);
            $("#idProductoEdit").val(msg.id);
            $("#editarProductoModal").modal("show");
            
          }
      }); 
    
    });

    $("#modificarProducto").click(function(){

          let nombre = $("#nombreProductoEdit").val();
          let precio = $("#precioEdit").val();
          let id = $("#idProductoEdit").val();
              $.ajax({
                  type: "PUT",
                  data: { nombre: nombre, 
                          precio : precio,
                          "_token": "{{ csrf_token() }}" },
                  dataType: 'JSON',
                  url: "/product/" + id,
                  success: function(msg){ 
                    if(msg == '1'){
                      table.ajax.reload();
                      $("#editarProductoModal").modal('hide');
                    }
                    if(msg == '0'){
                      alert('Ocurrio un error');
                    }
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