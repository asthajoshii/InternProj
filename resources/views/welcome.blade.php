<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#d9e4e6;
    padding:0;
}

/* Header */

.header{
    background:#17384a;
    height:120px;
    border-bottom-left-radius:35px;
    border-bottom-right-radius:35px;

    display:flex;
    align-items:center;
    justify-content:space-between;

    padding:20px 25px;
}

.back{
    width:50px;
    height:50px;
    background:#35566b;
    border-radius:15px;

    display:flex;
    justify-content:center;
    align-items:center;

    color:white;
    font-size:24px;
    cursor:pointer;
}

.title{
    flex:1;
    margin-left:18px;
}

.title h2{
    margin:0;
    color:white;
    font-size:32px;
    font-weight:bold;
}

.title p{
    margin-top:6px;
    color:#d7e1e8;
    font-size:16px;
}

.saved{
    text-align:center;
}

.saved h2{
    margin:0;
    color:#f9a43a;
    font-size:32px;
}

.saved p{
    margin-top:4px;
    color:white;
    font-size:12px;
    letter-spacing:1px;
}

/* Form */

.form-container{
    max-width:420px;
    margin:20px auto;
    background:white;
    padding:25px;
    border-radius:25px;
}

h1{
    text-align:center;
    margin-bottom:30px;
}

h2{
    margin-top:25px;
    margin-bottom:15px;
    font-size:22px;
    color:#17384a;
}

label{
    display:block;
    margin-bottom:8px;
    margin-top:10px;
    font-weight:bold;
    color:#555;
}

input,
select{
    width:100%;
    height:55px;
    padding:12px 16px;
    margin-bottom:15px;

    border:1px solid #d9d9d9;
    border-radius:15px;

    font-size:16px;
    background:white;
}

input:focus,
select:focus{
    outline:none;
    border:2px solid #f9a43a;
}

button{
    width:100%;
    height:55px;
    margin-top:15px;

    border:none;
    border-radius:15px;

    background:#f9a43a;
    color:white;

    font-size:18px;
    font-weight:bold;

    cursor:pointer;
}

button:hover{
    background:#f28d16;
}

</style>

<title>Student Registration Form</title>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<form method="POST" action="/students">
    @csrf


    <div class="header">

        <div class="back">
            < 
        </div>

        <div class="title">
            <h2>New Student</h2>
            <p>School - SVM204</p>
        </div>

        <div class="saved">
            <h2>1</h2>
            <p>SAVED</p>
        </div>

    </div>

    <div class="form-container">

        <h2>Student Name</h2>

        <label>First Name:</label>
        <input type="text" name="fname" required>

        <label>Middle Name:</label>
        <input type="text" name="mname">

        <label>Last Name:</label>
        <input type="text" name="lname" required>

        <label for="class">Class:</label>
        <select name="class" id="class">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>

        <label for="div">Division:</label>
        <select name="div" id="div">
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
            <option value="F">F</option>
        </select>

        <h2>Detailed Address</h2>

        <label>Address:</label>
        <input type="text" name="address1" required>

        <input type="text" name="address2">

        <label>Landmark:</label>
        <input type="text" name="landmark">

        <label>Country:</label>
        <input type="text" name="country">

        <label>State:</label>
        <input type="text" name="state">

        <label>City:</label>
        <input type="text" name="city">

        <label>Pin Code:</label>
        <input type="text" name="pincode">

        <label>Parents Name:</label>
        <input type="text" name="pname" required>

        <label>Parents Contact Number:</label>
        <input type="text" name="pcontact">

        <button type="submit">Save</button>

        <button type="reset">Reset</button>

        <button type="button" onclick="window.location.href='/students'">
            View Student Records
        </button>

    </div>

</form>