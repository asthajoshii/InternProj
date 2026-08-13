<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Submitted</title>

    <style>

        /* ================= RESET ================= */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

/* ================= BODY ================= */

body{
    margin:0;
    padding:0;
    background:#ffffff;

}

/* ================= PHONE ================= */

.phone{

    width:100%;

    min-height:100vh;

    background:#ffffff;

    padding:40px 28px;
    box-sizing:border-box;

}

/* ================= SUCCESS ICON ================= */

.success-icon{

    width:108px;

    height:108px;

    margin:10px auto 28px;

    border-radius:50%;

    background:#fde9d8;

    display:flex;

    justify-content:center;

    align-items:center;

}

.tick{

    width:64px;

    height:64px;

    border-radius:50%;

    background:#f9a43a;

    color:#ffffff;

    font-size:34px;

    font-weight:bold;

    display:flex;

    justify-content:center;

    align-items:center;

}

/* ================= TITLE ================= */

h1{

    text-align:center;

    color:#18364a;

    font-size:54px;

    font-weight:700;

    margin-bottom:14px;

}

/* ================= SUBTITLE ================= */

.subtitle{

    text-align:center;

    color:#6f8090;

    font-size:18px;

    line-height:30px;

    margin-bottom:40px;

}

/* ================= STUDENT CARD ================= */

.student-card{

    width:100%;

    background:#17384d;

    border-radius:26px;

    padding:18px;

    display:flex;

    align-items:center;

    gap:16px;

    margin-bottom:40px;

}

/* ================= PHOTO ================= */

.student-photo{

    width:72px;

    height:72px;

    border-radius:18px;

    overflow:hidden;

    background:#ffffff;

    flex-shrink:0;

}

.student-photo img{

    width:100%;

    height:100%;

    object-fit:cover;

}

/* ================= INFO ================= */

.student-info{

    flex:1;

}

.student-info h3{

    color:white;

    font-size:24px;

    margin-bottom:8px;

}

.student-info p{

    color:#cdd8df;

    font-size:16px;

    margin-bottom:12px;

}

/* ================= BADGE ================= */

.badge{

    display:inline-block;

    background:#4c5a34;

    color:#f6b53d;

    font-size:12px;

    font-weight:bold;

    padding:8px 14px;

    border-radius:10px;

    letter-spacing:1px;

}

/* ================= BUTTON ================= */

.add-btn{

    width:100%;

    height:64px;

    border-radius:32px;

    background:#f9a43a;

    color:white;

    text-decoration:none;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:22px;

    font-weight:700;

    margin-bottom:28px;

}

/* ================= LINK ================= */

.change-code{

    display:block;

    text-align:center;

    text-decoration:none;

    color:#6f8090;

    font-size:20px;

    font-weight:600;

}

    </style>

</head>

<body>

    <div class="phone">

    <!-- Header / Back Navigation -->
    <div style="display:flex; align-items:center; justify-content:space-between; width:100%; margin-bottom:14px;">
        <a href="{{ url('/students') }}" style="width:40px; height:40px; border-radius:50%; background:#f0f4f8; color:#17384a; display:flex; align-items:center; justify-content:center; text-decoration:none; font-size:18px; font-weight:bold;" onclick="if(window.history.length > 1){ window.history.back(); return false; }">←</a>
        <a href="{{ url('/students') }}" style="text-decoration:none; color:#17384a; font-weight:bold; font-size:14px;">📋 View Saved Forms</a>
    </div>

    <!-- ================= SUCCESS ICON ================= -->

    <div class="success-icon">

        <div class="tick">
            ✓
        </div>

    </div>

    <!-- ================= TITLE ================= -->

    <h1>Submitted</h1>

    <p class="subtitle">

        Saved on this device.<br>

        {{ $count }} record{{ $count > 1 ? 's' : '' }} ready to sync for printing.

    </p>

    <!-- ================= STUDENT CARD ================= -->

    <div class="student-card">

        <div class="student-photo">

            @if(!empty($student->photo))

                <img src="/storage/{{ $student->photo }}" alt="Student">

            @else

                <img src="https://via.placeholder.com/80x80.png?text=%F0%9F%91%A4" alt="Student">

            @endif

        </div>

        <div class="student-info">

            <h3>

                {{ $student->fname }}
                {{ $student->lname }}

            </h3>

            <p>

                Class {{ $student->class }}

                •

                Division {{ $student->div }}

                @if(!empty($student->rollno))
                    • Roll {{ $student->rollno }}
                @endif

            </p>

            <span class="badge">

                QUEUED FOR PRINT

            </span>

        </div>

    </div>

    <!-- ================= BUTTON ================= -->

    <a href="{{ url('/register?school_code=' . $student->schoolcode) }}" class="add-btn">
    Add Another Student
    </a>

    <!-- ================= CHANGE SCHOOL ================= -->

    <a href="{{ url('/dashboard') }}" class="change-code">
    Change School Code
    </a>

</div>

</body>

</html>