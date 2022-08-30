@section('formulario')

<section class="page-section" id="contact">
<div class="container">

<br><br>

<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form action="" method="">
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">Email</label>
                                <div class="col-md-6">
                                    <input type="text" id="email" class="form-control" name="email" required>
                                    <div class="invalid-feedback" id="invalid-email-required">El email es requerido</div>
                                    <div class="invalid-feedback" id="invalid-email-valid-required">Ingresa un email válido</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" name="password" required>
                                    <div class="invalid-feedback" id="invalid-password-required">El password es requerido</div>
                                </div>
                            </div>

                            <div class="col-md-12 text-center">
                                <button type="button" id="login" class="btn btn-primary">
                                    Ingresa
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
<script type="text/javascript">
    let errores = 0;
    $("#login").click(function(){
    
        let password = $("#password").val().trim();
        let mail = $("#email").val().trim();
        
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

        //validar name
        if(password == '' || password == null){
            $("#invalid-password-required").addClass("showFeedback");
            errores++;
        }
        else{
            $("#invalid-password-required").removeClass("showFeedback");
        }

        if(errores > 0){
            errores = 0;
            return;
        }
            $.ajax({
                type: "POST",
                data: { password: password, 
                        email : mail,
                        "_token": "{{ csrf_token() }}" },
                dataType: 'JSON',
                url: "/login",
                success: function(msg){ 
                    console.log(msg);
                    if(msg == '1'){
        
                        Swal.fire({
                            position: 'top-center',
                            icon: 'success',
                            title: '¡Ingreso exitoso! Ahora serás redigirido.',
                            showConfirmButton: false,
                            timer: 1500
                        })

                        setTimeout(function(){
                            window.location = "/usuarios";
                        }, 1500);
                    }

                    if(msg == '0'){
                        
                        let timerInterval
                        Swal.fire({
                        title: '',
                        html: 'Tu email y/o password son incorrectos. Vuelva a intentarlo.',
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
                }
            }); 
      });

      $(document).on("change", "#email", function () {
            let email = $("#email").val().trim();
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

       $(document).on("change", "#password", function () {
            let password = $("#password").val().trim();

            if(password == '' || password == null){
                $("#invalid-password-required").addClass("showFeedback");
            }
            else{
                $("#invalid-password-required").removeClass("showFeedback");
            }
       });

       function isEmail(email) {
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

            return emailReg.test(email);
       }
</script>
@stop
@include('../layout_welcome.layout')