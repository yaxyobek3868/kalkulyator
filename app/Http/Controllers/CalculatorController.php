<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function index()
    {
        session()->put('history', []); // tarixni tozalash (sahifa yangilanganda)
        return view('calculator');
    }

    public function calculate(Request $request)
    {
        $num1 = $request->input('num1');
        $num2 = $request->input('num2');
        $operator = $request->input('operator');
        $result = null;

        switch ($operator) {
            case '+':
                $result = $num1 + $num2;
                break;
            case '-':
                $result = $num1 - $num2;
                break;
            case '*':
                $result = $num1 * $num2;
                break;
            case '/':
                $result = $num2 != 0 ? $num1 / $num2 : '0 ga bo‘lish mumkin emas!';
                break;
        }

        // Tarixga qo‘shish
        $history = session()->get('history', []);
        $history[] = "$num1 $operator $num2 = $result";
        session()->put('history', $history);

        return view('calculator', compact('result', 'num1', 'num2', 'operator', 'history'));
    }
}
