<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Take Attendance - EduPortal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { background:#f4f6f9; font-family:"Segoe UI",sans-serif; margin:0; padding:0; overflow-x: hidden; }

        /* --- SIDEBAR FIXED (EXACT MATCH) --- */
        .sidebar { 
            height: 100vh; 
            background-color: #0d1b2a; 
            color: white; 
            position: fixed; 
            width: 16.666667%; 
            left: 0; 
            top: 0; 
            z-index: 1000; 
        }
        .sidebar-brand { padding: 25px 20px 10px; font-weight: bold; font-size: 1.3rem; }
       .sidebar a { color:#cbd5e1; text-decoration:none; display:block; padding:12px 20px; border-radius:8px; transition: 0.2s; }
        .sidebar a:hover, .sidebar .active { background-color: rgba(255,255,255,0.1); color: #fff; }

        /* --- MAIN CONTENT AREA (NO GAPS) --- */
        .main-content { 
            margin-left: 16.666667%; 
            width: 83.333333%; 
            min-height: 100vh; 
            display: flex;
            flex-direction: column;
        }

        .topbar { background:white; padding:15px 25px; box-shadow:0 2px 6px rgba(0,0,0,0.08); }
        .card-box { border:none; border-radius:15px; padding:25px; background:white; box-shadow:0 4px 15px rgba(0,0,0,0.05); }

        /* Box Mode Styles */
        .list-box { height: 350px !important; border-radius: 12px !important; border: 2px solid #f1f5f9 !important; padding: 10px; outline: none; transition: 0.3s; }
        .list-box:focus { border-color: #0d6efd; }
        .list-box option { padding: 10px; border-radius: 8px; margin-bottom: 2px; cursor: pointer; transition: 0.2s; }
        .list-box option:hover { background: #f8fafc; }
        .list-box option:checked { background-color: #0d6efd !important; color: white; }
        
        .btn-move { width: 45px; height: 45px; border-radius: 50%; border: none; background: #fff; color: #0d6efd; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin: 10px 0; transition: 0.3s; }
        .btn-move:hover { background: #0d6efd; color: #fff; transform: scale(1.1); }
        
        #successAlert { transition: opacity 0.5s ease-out; }
    </style>
</head>
<body>

<div class="d-flex">
    <div class="sidebar p-3">
        <h5 class="mb-4 fw-bold">Dashboard</h5>
        <a href="../../public/index.php" class="mt-2">🏠 Home</a>

        <h6 class="text-uppercase text-secondary mt-3 mx-3">Main</h6>
        <a href="../../public/dashboard.php" class="active">📊 Dashboard</a>
        <a href="../../public/attendance.php">📝 Take Attendance</a>
        <a href="../../public/viewattendance.php">📅 View Attendance</a>
        <a href="../../public/assign.php">📚 Create Course</a>

        <h6 class="text-uppercase text-secondary mt-4 mx-3">Reports & Assigns</h6>
        <a href="../../public/viewassign.php">👨‍🎓 Student Assigns</a>
        <a href="../../public/teacher_assign_report.php">👨‍🏫 Teacher Assigns</a>

        <h6 class="text-uppercase text-secondary mt-4 mx-3">Management</h6>
        <a href="../../public/studentact.php">👨‍🎓 Students</a>
        <a href="../../public/teacheract.php">👨‍🏫 Teachers</a>
        <a href="../../public/courseact.php">📖 Courses</a>

        <hr class="text-secondary opacity-25">
        <a href="../../public/logout.php" class="text-danger">🚪 Logout</a>
    </div>

    <div class="main-content">
        <div class="topbar d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">Attendance Entry</h4>
            
            <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                <div id="successAlert" class="alert alert-success py-1 px-4 mb-0 rounded-pill fw-bold border-0 shadow-sm">
                    <i class="fa fa-check-circle me-2"></i> Attendance Saved Successfully!
                </div>
            <?php endif; ?>

            <div class="text-muted small"><?= date('l, d M Y') ?></div>
        </div>

        <div class="p-4 flex-grow-1">
            <form action="attendance.php?action=save" method="POST" id="attForm">
                <div class="card-box mb-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="small fw-bold text-muted mb-2">SELECT COURSE</label>
                            <select name="course_id" id="courseId" class="form-select border-0 bg-light fw-bold" required onchange="fetchStudents(this.value)">
                                <option value="">-- Choose Course --</option>
                                <?php if(!empty($courses)): foreach($courses as $c): ?>
                                    <option value="<?= $c['course_id'] ?>"><?= $c['coursename'] ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold text-muted mb-2">DATE</label>
                            <input type="date" name="att_date" class="form-control border-0 bg-light fw-bold" value="<?= date('Y-m-d') ?>">
                        </div>
                    </div>
                </div>

                <div class="card-box">
                    <div class="row align-items-center">
                        <div class="col-md-5">
                            <label class="small fw-bold text-muted mb-2">ABSENT / NOT MARKED (Double Click to Move)</label>
                            <select id="available" multiple class="form-control list-box" ondblclick="moveSingle('available', 'selected')"></select>
                        </div>
                        <div class="col-md-2 text-center d-flex flex-column align-items-center">
                            <button type="button" class="btn-move" onclick="moveRight()" title="Move Selected Right"><i class="fa fa-chevron-right"></i></button>
                            <button type="button" class="btn-move" onclick="moveLeft()" title="Move Selected Left"><i class="fa fa-chevron-left"></i></button>
                        </div>
                        <div class="col-md-5">
                            <label class="small fw-bold text-primary mb-2">PRESENT ROSTER (Double Click to Remove)</label>
                            <select id="selected" name="student_ids[]" multiple class="form-control list-box border-primary" ondblclick="moveSingle('selected', 'available')"></select>
                        </div>
                    </div>
                    <div class="text-center mt-5">
                        <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill fw-bold shadow-lg">
                            <i class="fa fa-check-circle me-2"></i> Finalize Attendance
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="p-4 pt-0 mt-auto">
            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="history.back()">
                <i class="fa fa-arrow-left me-2"></i> Back to Previous
            </button>
        </div>
    </div>
</div>

<script>
// --- Success Alert Auto-Hide ---
if (document.getElementById('successAlert')) {
    setTimeout(() => {
        const alert = document.getElementById('successAlert');
        alert.style.opacity = '0';
        setTimeout(() => alert.style.display = 'none', 500);
    }, 3000);
}

// --- Fetch Students via AJAX ---
function fetchStudents(cid) {
    if(!cid) return;
    const avail = document.getElementById('available');
    const select = document.getElementById('selected');
    avail.innerHTML = ""; select.innerHTML = "";

    fetch(`attendance.php?action=fetch&course_id=${cid}`)
        .then(res => res.json())
        .then(data => {
            data.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s.student_id;
                opt.text = `${s.name} (${s.rollno})`;
                avail.appendChild(opt);
            });
        });
}

// --- Move Buttons ---
function moveRight() {
    const from = document.getElementById('available');
    const to = document.getElementById('selected');
    Array.from(from.selectedOptions).forEach(opt => to.appendChild(opt));
}

function moveLeft() {
    const from = document.getElementById('selected');
    const to = document.getElementById('available');
    Array.from(from.selectedOptions).forEach(opt => to.appendChild(opt));
}

// --- Double Click Feature ---
function moveSingle(fromId, toId) {
    const from = document.getElementById(fromId);
    const to = document.getElementById(toId);
    if (from.selectedIndex === -1) return;
    to.appendChild(from.options[from.selectedIndex]);
}

// --- Form Validation & Submission ---
document.getElementById('attForm').onsubmit = function() {
    const opts = document.getElementById('selected').options;
    if (opts.length === 0) {
        if (!confirm("No students selected as Present. Mark everyone as Absent?")) {
            return false;
        }
    }
    for (let i = 0; i < opts.length; i++) {
        opts[i].selected = true; // Marks all items as selected so PHP can read the array
    }
    return true;
};
</script>
</body>
</html>