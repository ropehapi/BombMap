<?php

namespace App\Http\Controllers;

use App\Models\Bomb;
use Illuminate\Http\Request;

class BombController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(string $name)
    {
        $game = $this->getGame($name);

        $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O'];
        $positionsArray = $this->getCleanPositionsArray($game->positions??'');

        return view('index', [
            'name' => $game->name,
            'positionsArray' => $positionsArray,
            "letters" => $letters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('welcome');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->name;
        $game = $this->getGame($name);

        if (isset($game)) {
            return redirect()->route('index', $name);
        }

        $bombMap = new Bomb();
        $bombMap->name = $name;

        $bombMap->save();

        return redirect()->route('index', $name);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param string $name
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(string $name, Request $request)
    {
        $game = $this->getGame($name);

        if ($game->positions != null) {
            $positionsArray = explode(',', $game->positions);
            array_push($positionsArray, $request->position);
        } else {
            $positionsArray = [];
            array_push($positionsArray, $request->position);
        }

        $game->positions = str_replace(['"', '[', ']', '\\'], '', $positionsArray);

        $game->update();

        return redirect()->route('index', $name);
    }

    public function getGame(string $name)
    {
        return Bomb::where('name', $name)->first();
    }

    public function getCleanPositionsArray(string $positions = '')
    {
        return explode(',', str_replace(['"', '[', ']', '\\'], '', $positions));
    }

    public function countBombsAround(string $name, string $value)
    {
        $game = $this->getGame($name);
        $positionsArray = $this->getCleanPositionsArray($game->positions??'');

        $validPositions = [];
        $letters = ['', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', ''];
        $numbers = ['', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', ''];
        foreach ($letters as $letter) {
            foreach ($numbers as $number) {
                $validPositions[] = $letter . $number;
            }
        }

        $letter = $value[0];
        $number1 = $value[1];
        $number2 = isset($value[2]) ? $value[2] : '';
        $number = $number1 . $number2;

        $letterIndex = array_search($letter, $letters);
        $numberIndex = array_search($number, $numbers);

        $top_left = $letters[$letterIndex - 1] . $numbers[$numberIndex - 1];
        $top = $letters[$letterIndex] . $numbers[$numberIndex - 1];
        $top_right = $letters[$letterIndex + 1] . $numbers[$numberIndex - 1];

        $left = $letters[$letterIndex - 1] . $numbers[$numberIndex];
        $right = $letters[$letterIndex + 1] . $numbers[$numberIndex];

        $bottom_left = $letters[$letterIndex - 1] . $numbers[$numberIndex + 1];
        $bottom = $letters[$letterIndex] . $numbers[$numberIndex + 1];
        $bottom_right = $letters[$letterIndex + 1] . $numbers[$numberIndex + 1];

        $arounds = [$top_left, $top, $top_right, $left, $right, $bottom_left, $bottom, $bottom_right];

        $bombsAround = 0;
        foreach ($arounds as $around) {
            if (in_array($around, $positionsArray) && $around !='') {
                $bombsAround++;
            }
        }

        if($bombsAround!=0){
            return $bombsAround;
        }

        return '-';
    }

    public function getColor(string $name, string $value)
    {
        $game = $this->getGame($name);
        $positionsArray = $this->getCleanPositionsArray($game->positions??'');

        if(in_array($value,$positionsArray)){
            return 'black';
        }

        $bombsAround = $this->countBombsAround($name, $value);

        switch ($bombsAround) {
            case 1:
                return 'purple';
                break;

            case 2:
                return 'blue';
                break;

            case 3:
                return 'green';
                break;

            case 4:
                return 'yellow';
                break;

            case 5:
                return 'orange';
                break;

            case 6:
                return 'red';
                break;

            case 7:
                return '#800000';
                break;

            case 8:
                return 'pink';
                break;

            default:
                return 'black';
                break;
        }
    }
}
