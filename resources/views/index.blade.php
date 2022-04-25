<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>BombMap</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d5043ff803.js" crossorigin="anonymous"></script>
</head>

<body>

    @php
    use App\Http\Controllers\BombController;
    $bombController = new BombController;
    @endphp

    <h1 class="text-center text-muted">Clique em um botão para colocar uma bomba.</h1>

    <form method="POST" action="{{route('update',$name)}}">
        @csrf
        <input type="hidden" name="name" value="{{$name}}">
        <table class="table table-bordered">
            <tr>
                <th>#</th>
                @foreach($letters as $letter)
                <th>{{$letter}}</th>
                @endforeach
            </tr>
            @for($i=1;$i<=15;$i++) <tr>
                <td>{{$i}}</td>
                @foreach($letters as $letter)
                <td>
                    <button class="btn btn-sm btn-block" style="color: {{$bombController->getColor($name,$letter.$i)}};" id="{{$letter}}{{$i}}" name="position" value="{{$letter}}{{$i}}">
                        {{in_array(($letter.$i),$positionsArray)?'X':$bombController->countBombsAround($name,$letter . $i)}}
                    </button>
                </td>
                @endforeach
                </tr>
                @endfor
        </table>
    </form>

    <div class="text-center">
        <a class="btn btn-primary text-white" href="/">Começar novamente</a>
    </div>


</body>

</html>

<script>
    $(document).ready(function() {
        let letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O'];
        let numbers = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15'];

        letters.forEach(letter => {
            numbers.forEach(number => {
                position = letter + number;
                let cell = $("#" + position);
                console.log(cell);

                if (cell.text() == '\n                        X\n                    ') {
                    cell.html('<i class="fa-solid fa-bomb"></i>');
                }
            });
        });
    });
</script>
