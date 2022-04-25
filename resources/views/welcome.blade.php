<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Bem vindo</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>

<body>
    <div class="wrapper">
        <br>
        <div class="container-fluid mt--7">
            <div class="col-xl-8 offset-xl-2">

                <div class="card shadow border-0">
                    <div class="card-header">
                        <div class="col-12">
                            <h5 id="modalTitle" class="modal-title text-center">Por favor, escolha um nome de usuário para jogar.</h5>
                        </div>
                    </div>

                    <form method="POST" action="{{route('store')}}">
                        @csrf
                        <div class="card-body px-lg-5 py-lg-5 text-center">
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-6 offset-3">
                                    <div class="pb-3">
                                        <input name="name" class="form-control" type="text" placeholder="Seu nome aqui" required>
                                    </div>
                                    <div>
                                        <button class="btn btn-primary">Começar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
