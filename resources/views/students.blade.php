<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Forms - Student Records</title>
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

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .back-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f0f4f8;
            color: #17384a;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
        }

        .header-title h2 {
            font-size: 22px;
            color: #17384a;
            font-weight: bold;
        }

        .header-title p {
            font-size: 13px;
            color: #6d7d87;
        }

        .badge-count {
            background: #f9a43a;
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
        }

        /* Filter Section */
        .filter-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 14px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .filter-form {
            display: flex;
            gap: 8px;
        }

        .filter-input {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid #cbd5e1;
            border-radius: 14px;
            font-size: 14px;
            outline: none;
        }

        .filter-btn {
            padding: 12px 18px;
            background: #17384a;
            color: white;
            border: none;
            border-radius: 14px;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
        }

        .school-tags {
            display: flex;
            gap: 6px;
            overflow-x: auto;
            padding-bottom: 4px;
        }

        .school-tag {
            padding: 5px 12px;
            background: #e2e8f0;
            color: #334155;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            text-decoration: none;
            white-space: nowrap;
        }

        .school-tag.active {
            background: #17384a;
            color: white;
        }

        /* Student Cards */
        .records-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .student-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 22px;
            padding: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            display: flex;
            gap: 14px;
            align-items: center;
        }

        .student-thumb {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            object-fit: cover;
            border: 2px solid #f9a43a;
            background: #f1f5f9;
        }

        .student-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .student-name {
            font-size: 16px;
            font-weight: bold;
            color: #17384a;
        }

        .student-details {
            font-size: 12px;
            color: #64748b;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .info-pill {
            background: #f1f5f9;
            padding: 3px 8px;
            border-radius: 6px;
            font-weight: bold;
            color: #334155;
        }

        .edit-btn {
            padding: 10px 14px;
            background: #f0f4f8;
            color: #17384a;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            font-size: 13px;
            font-weight: bold;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .edit-btn:hover {
            background: #17384a;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #64748b;
        }

        .new-btn {
            width: 100%;
            padding: 16px;
            background: #f9a43a;
            color: white;
            border: none;
            border-radius: 18px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
            display: block;
        }
    </style>
    @livewireStyles
</head>
<body>

<div class="phone">

    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <a href="{{ url('/dashboard') }}" class="back-btn" onclick="if(window.history.length > 1){ window.history.back(); return false; }">←</a>
            <div class="header-title">
                <h2>Saved Forms</h2>
                <p>Database Records</p>
            </div>
        </div>
        <div class="badge-count">
            {{ $count }} Total
        </div>
    </div>

    <!-- Filter Box -->
    <div class="filter-box">
        <form method="GET" action="/students" class="filter-form" style="position:relative; width:100%;">
            <input type="text" 
                   id="studentSearchInput" 
                   name="search" 
                   class="filter-input" 
                   placeholder="Search Name, ERP, Roll No, School..." 
                   value="{{ $search ?? $schoolCode ?? '' }}" 
                   autocomplete="off">
            @if(!empty($search ?? $schoolCode ?? ''))
                <a href="/students" style="position:absolute; right:85px; top:50%; transform:translateY(-50%); color:#94a3b8; text-decoration:none; font-weight:bold; font-size:16px; padding:4px 8px;">✕</a>
            @endif
            <button type="submit" class="filter-btn">Search</button>
        </form>

        @if(isset($schools) && count($schools) > 0)
        <div class="school-tags">
            <a href="/students" class="school-tag {{ empty($search) ? 'active' : '' }}">All Schools</a>
            @foreach($schools as $sch)
                <a href="/students?search={{ urlencode($sch) }}" class="school-tag {{ ($search ?? '') == $sch ? 'active' : '' }}">
                    {{ $sch }}
                </a>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('students.export') }}">
            @csrf
            <input type="hidden" name="schoolcode" value="{{ $search ?? $schoolCode ?? '' }}">
            <button type="submit" class="filter-btn" style="width:100%;">📤 Export to Excel</button>
        </form>
    </div>

    <!-- Student Cards List -->
    <div class="records-list" id="recordsList">
        @if(count($students) > 0)
            @foreach($students as $student)
                @php
                    $photoSrc = getStudentPhotoSrc($student->photo);
                @endphp
                <div class="student-card" data-search="{{ strtolower($student->fname.' '.$student->mname.' '.$student->lname.' '.$student->erpid.' '.$student->rollno.' '.$student->schoolcode.' '.$student->class.' '.$student->div.' '.$student->pcontact) }}">
                    @if($photoSrc)
                        <img src="{{ $photoSrc }}" class="student-thumb" alt="Photo" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($student->fname.' '.$student->lname) }}&background=17384a&color=fff';" />
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($student->fname.' '.$student->lname) }}&background=17384a&color=fff" class="student-thumb" alt="Avatar" />
                    @endif

                    <div class="student-info">
                        <div class="student-name">
                            {{ $student->fname }} {{ $student->mname }} {{ $student->lname }}
                        </div>
                        <div class="student-details">
                            <span class="info-pill">Class {{ $student->class }}-{{ $student->div }}</span>
                            <span class="info-pill">Roll: {{ $student->rollno }}</span>
                            <span class="info-pill">ERP: {{ $student->erpid }}</span>
                        </div>
                        <div style="font-size:11px; color:#94a3b8; margin-top:2px;">
                            School: <strong>{{ $student->schoolcode }}</strong>
                        </div>
                    </div>

                    <a href="/students/{{ $student->id }}/edit" class="edit-btn">
                        ✏️ Edit
                    </a>
                </div>
            @endforeach
            
            <div id="noMatchMessage" class="empty-state" style="display:none;">
                <p style="font-size:32px; margin-bottom:8px;">🔍</p>
                <p style="font-weight:bold; color:#17384a;">No matching records</p>
                <p style="font-size:13px; margin-top:4px;">Try searching for a different name, ERP, or school code.</p>
            </div>
        @else
            <div class="empty-state">
                <p style="font-size:32px; margin-bottom:8px;">📋</p>
                <p style="font-weight:bold; color:#17384a;">No records found</p>
                <p style="font-size:13px; margin-top:4px;">No student forms have been saved for this filter yet.</p>
            </div>
        @endif
    </div>

    <!-- Action Button -->
    <a href="/dashboard" class="new-btn">
        + New Form Enrollment
    </a>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('studentSearchInput');
    const cards = document.querySelectorAll('.student-card');
    const noMatch = document.getElementById('noMatchMessage');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            let count = 0;

            cards.forEach(card => {
                const searchData = card.getAttribute('data-search') || '';
                if (searchData.includes(query)) {
                    card.style.display = 'flex';
                    count++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (noMatch) {
                noMatch.style.display = (count === 0 && cards.length > 0) ? 'block' : 'none';
            }
        });
    }
});
</script>

 @livewireScripts
</body>
</html>