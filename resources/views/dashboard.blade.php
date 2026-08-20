<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>

    <style>

       *{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#d9e4e6;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.phone{
    width:390px;
    height:844px;
    background:white;
    border-radius:40px;
    padding:20px;
    overflow:auto;
    box-shadow:0 15px 40px rgba(0,0,0,0.15);
    display:flex;
    flex-direction:column;
    justify-content:flex-start;
}

.logo{
    width:70px;
    height:70px;
    background:#17384a;
    border-radius:20px;

    display:flex;
    justify-content:center;
    align-items:center;

    font-size:30px;
    color:white;

    margin-top:70px;
}

h1{
    margin-top:30px;
    font-size:36px;
    line-height:1.2;
    color:#17384a;
}

h1 span{
    color:#f9a43a;
}

.description{
    margin-top:20px;
    color:#6d7d87;
    font-size:15px;
    line-height:1.5;
}

.school-code{
    margin-top:45px;
}

.school-code label{
    display:block;
    margin-bottom:12px;
    font-size:13px;
    font-weight:bold;
    letter-spacing:2px;
    color:#8a9ba5;
}

.school-code input{
    width:100%;
    height:70px;

    border:1px solid #dddddd;
    border-radius:18px;

    padding-left:20px;

    font-size:22px;
    font-weight:bold;
    color:#17384a;

    outline:none;
}

.school-code input::placeholder{
    color:#dddddd;
    letter-spacing:3px;
}

.school-code input:focus{
    border:2px solid #f9a43a;
}

.info-box{
    margin-top:120px;
    background:#fdf2e7;
    border-radius:18px;
    padding:14px 16px;

    display:flex;
    align-items:center;
    gap:10px;
}

.info-icon{
    width:26px;
    height:26px;

    border-radius:50%;

    background:#ffa735;
    color:white;

    display:flex;
    justify-content:center;
    align-items:center;
    flex-shrink:0;
    font-size:15px;
    font-weight:bold;
}

.info-text{
    color:#7a5b3a;
    font-size:15px;
    line-height:1.4;
}

.continue-btn{
    width:100%;
    height:65px;
    margin-top:14px;
    border:none;
    border-radius:22px;
    background:#f9a43a;
    color:white;
    font-size:20px;
    font-weight:bold;
    cursor:pointer;
    box-shadow:0 10px 20px rgba(249,164,58,0.3);
    transition:.3s;
}

.continue-btn:hover{
    background:#f38f16;
}

    </style>

</head>

<body>

<div class="phone">
   <div class="logo">
        🎫
    </div>
    <h1>
    Let's start with your
    <br>
    <span>school code</span>
</h1>

<p class="description">
    Your school shared a 6-character code.
    <br>
    It links every student record to the right
    <br>
    ID card batch.
</p>

<form method="POST" action="{{ url('/dashboard') }}">

    @csrf

    <div class="school-code">
        <label>SELECT SCHOOL</label>

        <select
            name="school_code"
            required
            style="
                width:100%;
                height:70px;
                border:1px solid #dddddd;
                border-radius:18px;
                padding:0 20px;
                font-size:17px;
                font-weight:bold;
                color:#17384a;
                background:white;
                outline:none;
            "
        >
            <option value="">Select a school...</option>

            @foreach($schools as $school)
                <option value="{{ $school['code'] }}"
                    {{ old('school_code') == $school['code'] ? 'selected' : '' }}>
                    {{ $school['name'] }} ({{ $school['code'] }})
                </option>
            @endforeach
        </select>
    </div>

    @error('school_code')
        <div style="
            margin-top:10px;
            background:#fee2e2;
            border:1px solid #fca5a5;
            color:#991b1b;
            padding:12px 14px;
            border-radius:12px;
            font-size:13px;
        ">
            {{ $message }}
        </div>
    @enderror

    <div class="info-box">
        <div class="info-icon">i</div>

        <div class="info-text">
            Entries are saved on this device.
            You can fill forms offline and sync later.
        </div>
    </div>

    <button class="continue-btn" type="submit">
        Continue
    </button>

    <a href="/students" style="display:block; width:100%; text-align:center; margin-top:14px; padding:14px; background:#f0f4f8; color:#17384a; border-radius:18px; font-weight:bold; font-size:15px; text-decoration:none;">
        📋 View Saved Forms
    </a>

</form>
</div>

</body>
</html>