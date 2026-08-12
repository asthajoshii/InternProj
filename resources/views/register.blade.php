<!DOCTYPE html>
<html>

<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Registration</title>
    <style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{

    background:#ffffff;
    margin:0;
    padding:0;
    display:flex;
    justify-content:center;
}

.phone{

    width:100%;
    max-width:390px;
    background:#ffffff;

    border-radius:35px;

    overflow:hidden;

    box-shadow:0 5px 20px rgba(0,0,0,.08);
}

/* ================= HEADER ================= */

.header{

    background:#17384a;

    height:120px;

    border-bottom-left-radius:35px;
    border-bottom-right-radius:35px;

    display:flex;

    align-items:center;

    padding:20px;
}

.back-btn{
    width:52px;
    height:52px;
    background:#2b4b5d;
    border-radius:15px;

    color:#fff;
    text-decoration:none;   /* Remove underline */
    
    display:flex;
    justify-content:center;
    align-items:center;

    font-size:26px;
    margin-right:18px;
    cursor:pointer;
}

.header-title{

    flex:1;
}

.header-title h2{

    color:white;

    font-size:22px;

    margin-bottom:5px;
}

.header-title p{

    color:#d8e1e6;

    font-size:14px;
}

.saved{

    text-align:center;
}

.saved h2{

    color:#f9a43a;

    font-size:28px;
}

.saved p{

    color:white;

    font-size:12px;

    letter-spacing:1px;
}

/* ================= FORM ================= */

form{

    padding:22px;
}

/* ================= SECTION ================= */

.section-title{

    color:#17384a;

    font-size:13px;

    letter-spacing:4px;

    margin-top:28px;

    margin-bottom:18px;

    font-weight:bold;
}

/* ================= ROW ================= */

.row{

    display:flex;
    allign-items:flex-Start;
    gap:18px;
}

/* ================= FIELD ================= */

.field{

    flex:1;

    margin-bottom:16px;
}

.field label{

    display:block;

    color:#7b8794;

    font-size:10px;
    letter-spacing:0.5px;
    font-weight:bold;

    margin-bottom:8px;
}

.field input,
.field select{

    width:100%;

    height:48px;

    border:1px solid #E4E6EB;

    border-radius:16px;

    padding:0 18px;

    font-size:16px;

    color:#17384a;

    outline:none;

    background:#fff;
}

.field input::placeholder{

    color:#A8B3C0;

    font-size:15px;

    font-weight:400;
}
.field select{

    color:#A8B3C0;
}


.field input:focus,
.field select:focus{

    border:2px solid #f9a43a;
}

/* ================= PHOTO ================= */

.photo-box{

    border:2px dashed #d7dde2;

    border-radius:20px;

    padding:20px;

    display:flex;

    align-items:center;

    gap:15px;

    margin-top:10px;
    cursor: pointer;
    margin-bottom:30px;
}

.camera-box{

    width:60px;

    height:60px;

    background:#fff3e9;

    border-radius:18px;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:28px;
}

.photo-text h4{

    color:#17384a;

    font-size:18px;

    margin-bottom:5px;
}

.photo-text p{

    color:#7b8794;

    font-size:13px;

    line-height:20px;
}

/* ================= BUTTON ================= */

.submit-btn{

    width:100%;

    height:54px;

    border:none;

    border-radius:18px;

    background:#f9a43a;

    color:white;

    font-size:20px;

    font-weight:bold;

    cursor:pointer;

    margin:15px 0 30px;
}

.submit-btn:hover{

    background:#f39218;
}

/* ================= PLACEHOLDER ================= */

::placeholder{

    color:#b9b9b9;
}
.error{
    display:block;
    margin-top:6px;
    color:#e74c3c;
    font-size:12px;
    font-weight:500;
}

.input-error{
    border:2px solid #e74c3c !important;
}

</style>

</head>

<body>

<div class="phone">

    <!-- Header -->

    <div class="header">
        <a href="{{ url('/') }}" class="back-btn">
            ←
        </a>
        

        <div class="header-title">

            <h2>New Student</h2>

            <p>
            School - {{ $schoolCode }}
            </p>

        </div>

        <div class="saved">

            <h2>{{ $count }}</h2>

            <p>SAVED</p>

        </div>

    </div>

    <form method="POST" action="/students" enctype="multipart/form-data">

        @csrf
        <input type="hidden"
       name="schoolcode"
       value="{{ $schoolCode }}">

        <!-- ================= IDENTITY ================= -->

        <h3 class="section-title">IDENTITY</h3>

        <div class="row">

            <div class="field">

                <label>ERP ID</label>

                <input
                    type="text"
                    name="erpid"
                    placeholder="ERP ID">

            </div>

            <div class="field">

                <label>ROLL NO.</label>

                <input
                    type="text"
                    name="rollno"
                    placeholder="Roll No">

            </div>

        </div>

        <div class="row">

            <div class="field">

                <label>FIRST NAME</label>

                <input
                    type="text"
                    name="fname"
                    placeholder="First Name"
                    required>

            </div>

            <div class="field">

                <label>MIDDLE NAME</label>

                <input
                    type="text"
                    name="mname"
                    placeholder="Middle Name">

            </div>

        </div>

        <div class="field">

            <label>LAST NAME</label>

            <input
                type="text"
                name="lname"
                placeholder="Last Name"
                required>

        </div>
        <!-- FULL NAME -->

        <div class="field">

    <label>
        FULL NAME - prints on the card
    </label>

    <input
        type="text"
        id="fullname"
        placeholder="Auto-filled"
        readonly>

        </div>

        <!-- ================= CLASS DETAILS ================= -->

        <h3 class="section-title">CLASS DETAILS</h3>

        <div class="field">

            <label>STANDARD</label>

            <select name="class" required>

                <option value="">Select Standard</option>

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

        </div>

        <div class="field">

            <label>DIVISION</label>

            <select name="div" required>

                <option value="">Select Division</option>

                <option>A</option>
                <option>B</option>
                <option>C</option>
                <option>D</option>
                <option>E</option>
                <option>F</option>

            </select>

        </div>

        <div class="row">

            <div class="field">

                <label>DATE OF BIRTH</label>

                <input
                    type="date"
                    name="dob"
                    id="dob">
                    <small id="dobError" class="error"></small>

            </div>

            <div class="field">

                <label>BLOOD GROUP</label>

                <select name="bloodgroup">

                    <option value="">Select</option>

                    <option>A+</option>
                    <option>A-</option>
                    <option>B+</option>
                    <option>B-</option>
                    <option>AB+</option>
                    <option>AB-</option>
                    <option>O+</option>
                    <option>O-</option>

                </select>

            </div>

        </div>
                <!-- ================= PARENT / GUARDIAN ================= -->

        <h3 class="section-title">PARENT / GUARDIAN</h3>

        <div class="field">

            <label>PARENT NAME</label>

            <input
                type="text"
                name="pname"
                placeholder="Parent Name"
                required>

        </div>

        <div class="field">

            <label>MOBILE NUMBER</label>

            <input
                type="text"
                name="pcontact"
                id="pcontact"
                placeholder="9876543210"
                maxlength="10">
            <small id="mobileError" class="error"></small>

        </div>


        <!-- ================= ADDRESS ================= -->

        <h3 class="section-title">ADDRESS</h3>
        <div class="field">
       <input
    type="text"
    name="address1"
    placeholder="Flat / house no., building"
    required>
    </div>
<div class="field">
<input
    type="text"
    name="address2"
    placeholder="Street, area">
</div>

<div class="row">

    <div class="field">

        <input
            type="text"
            name="landmark"
            placeholder="Landmark">

    </div>

    <div class="field">

        <input
            type="text"
            name="pincode"
            placeholder="PIN code">

    </div>

</div>

<!-- ================= PHOTO ================= -->
<h3 class="section-title">PHOTO FOR THE CARD</h3>
<div style="
        background:#fce9d9;
        padding:15px;
        border-radius:15px;
    ">
        📷
    </div>
    <div>
        <p style="font-weight:600; margin:0;">Capture photo</p>
        <p style="margin:0; color:#777; font-size:14px;">
            Front-facing, plain background. You'll crop it next.
        </p>
    </div>

<!-- ================= BUTTON ================= -->

        <button
            type="submit"
            class="submit-btn">

            Submit Enrollment

        </button>

    </form>

</div>

<script>
const first = document.querySelector('input[name="fname"]');
const middle = document.querySelector('input[name="mname"]');
const last = document.querySelector('input[name="lname"]');
const full = document.getElementById('fullname');

function updateFullName() {
    if (!full) return;

    full.value = [
        first?.value,
        middle?.value,
        last?.value
    ].filter(name => name && name.trim() !== "").join(" ");
}

if (first) first.addEventListener("input", updateFullName);
if (middle) middle.addEventListener("input", updateFullName);
if (last) last.addEventListener("input", updateFullName);
</script>


<script>

const mobile = document.getElementById("pcontact");
const mobileError = document.getElementById("mobileError");

mobile.addEventListener("input", function(){

    const value = mobile.value.trim();

    const valid = /^[6-9][0-9]{9}$/.test(value);

    if(value === ""){

        mobile.classList.remove("input-error");
        mobileError.innerHTML = "";
        return;

    }

    if(valid){

        mobile.classList.remove("input-error");
        mobileError.innerHTML = "";

    }else{

        mobile.classList.add("input-error");
        mobileError.innerHTML =
        "Must be 10 digits starting with 6, 7, 8 or 9.";

    }

});
// ===== DOB Validation =====

const dob = document.getElementById("dob");
const dobError = document.getElementById("dobError");

dob.addEventListener("change", function () {

    if (this.value === "") {
        dobError.textContent = "";
        this.classList.remove("input-error");
        return;
    }

    const birthDate = new Date(this.value);
    const today = new Date();

    let age = today.getFullYear() - birthDate.getFullYear();

    const month = today.getMonth() - birthDate.getMonth();

    if (month < 0 || (month === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }

    if (age < 3 || age > 25) {

        dobError.textContent = "Age should be between 3 and 25 years.";

        this.classList.add("input-error");

    } else {

        dobError.textContent = "";

        this.classList.remove("input-error");

    }

});




</script>
</body>
</html>