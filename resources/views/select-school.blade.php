<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select School</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background: #d9e4e6;
            margin: 0;
            padding: 20px 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .phone {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border-radius: 35px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
            padding: 24px 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .header-title h2 {
            font-size: 22px;
            color: #17384a;
            font-weight: bold;
        }

        .header-title p {
            font-size: 13px;
            color: #6d7d87;
            margin-top: 4px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .select-wrapper {
        position: relative;
        width: 100%;
        }

        .filter-input {
            width: 100%;
            padding: 14px 40px 14px 16px;
            border: 1px solid #cbd5e1;
            border-radius: 14px;
            font-size: 16px;
            outline: none;
            appearance: none;
           -webkit-appearance: none;
           -moz-appearance: none;
           background: #ffffff;
           color: #17384a;
        }

        .filter-btn {
            width: 100%;
            padding: 14px 18px;
            background: #17384a;
            color: white;
            border: none;
            border-radius: 14px;
            font-weight: bold;
            font-size: 15px;
            cursor: pointer;
        }
        .select-wrapper::after {
        content: "";
        position: absolute;
        top: 50%;
        right: 16px;
        width: 10px;
        height: 10px;
        border-right: 2px solid #6d7d87;
        border-bottom: 2px solid #6d7d87;
        transform: translateY(-70%) rotate(45deg);
        pointer-events: none;
      }

        .error-box {
            background: #fee2e2;
            border: 1px solid #fca5a5;
            color: #991b1b;
            padding: 12px 14px;
            border-radius: 12px;
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="phone">

    <div class="header-title">
        <h2>Select School</h2>
        <p>Enter the school code to load its configuration</p>
    </div>

    @if ($errors->any())
        <div class="error-box">
            {{ $errors->first('school_code') }}
        </div>
    @endif

    <form method="POST" action="{{ url('/select-school') }}" class="form-group">
        @csrf
        <div class="select-wrapper">
            <select name="school_code" class="filter-input" autofocus>
            <option value="">Select a school...</option>
            @foreach($schools as $school)
            <option value="{{ $school['code'] }}" {{ old('school_code') == $school['code'] ? 'selected' : '' }}>
            {{ $school['name'] }} ({{ $school['code'] }})
            </option>
            @endforeach
            </select>
        </div>
        <button type="submit" class="filter-btn">Continue</button>
    </form>

</div>

</body>
</html>