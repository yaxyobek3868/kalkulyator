<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <title>Kalkulyator - Laravel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .calculator-card {
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        .result-badge {
            font-size: 1.2rem;
        }
        .history-box {
            background: #f9f9f9;
            border-radius: 10px;
            padding: 10px;
            max-height: 200px;
            overflow-y: auto;
        }
    </style>
</head>
<body class="bg-body-secondary">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="calculator-card">
                <h3 class="text-center mb-4 text-primary">Laravel Kalkulyator</h3>
                <form id="calc-form" action="{{ route('calculator.calculate') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="num1" class="form-label">1-son:</label>
                        <input type="number" id="num1" name="num1" class="form-control" required value="{{ $num1 ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="operator" class="form-label">Amal:</label>
                        <select name="operator" id="operator" class="form-select" required>
                            <option value="+" {{ (isset($operator) && $operator == '+') ? 'selected' : '' }}>➕ Qo‘shish</option>
                            <option value="-" {{ (isset($operator) && $operator == '-') ? 'selected' : '' }}>➖ Ayirish</option>
                            <option value="*" {{ (isset($operator) && $operator == '*') ? 'selected' : '' }}>✖️ Ko‘paytirish</option>
                            <option value="/" {{ (isset($operator) && $operator == '/') ? 'selected' : '' }}>➗ Bo‘lish</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="num2" class="form-label">2-son:</label>
                        <input type="number" id="num2" name="num2" class="form-control" required value="{{ $num2 ?? '' }}">
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-success btn-lg">Hisoblash</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="resetForm()">Tozalash</button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <span class="badge bg-info text-dark result-badge" id="liveResult">
                        @isset($result)
                            <strong>Natija:</strong> {{ $result }}
                        @endisset
                    </span>
                </div>

                @if (session('history'))
                    <div class="mt-4">
                        <h6>🕓 Tarix:</h6>
                        <div class="history-box">
                            @foreach(session('history') as $item)
                                <div>{{ $item }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    // Real vaqt hisoblash
    const num1 = document.getElementById("num1");
    const num2 = document.getElementById("num2");
    const operator = document.getElementById("operator");
    const liveResult = document.getElementById("liveResult");

    function calculateLive() {
        const val1 = parseFloat(num1.value);
        const val2 = parseFloat(num2.value);
        const op = operator.value;
        let res = '';

        if (!isNaN(val1) && !isNaN(val2)) {
            switch(op) {
                case '+': res = val1 + val2; break;
                case '-': res = val1 - val2; break;
                case '*': res = val1 * val2; break;
                case '/': res = val2 !== 0 ? (val1 / val2).toFixed(2) : 'Xato! 0 ga bo‘lish'; break;
            }
            liveResult.textContent = 'Natija: ' + res;
        }
    }

    num1.addEventListener('input', calculateLive);
    num2.addEventListener('input', calculateLive);
    operator.addEventListener('change', calculateLive);

    function resetForm() {
        document.getElementById("calc-form").reset();
        liveResult.textContent = 'Natija:';
    }
</script>
</body>
</html>
