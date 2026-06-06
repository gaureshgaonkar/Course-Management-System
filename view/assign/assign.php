<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dynamic Assignment - EduPortal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { background:#f4f6f9; font-family:"Segoe UI",sans-serif; margin:0; overflow-x: hidden; }

        /* --- SIDEBAR FIXED --- */
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
        .sidebar a { color:#cbd5e1; text-decoration:none; display:block; padding:12px 20px; border-radius:8px; transition: 0.2s; }
        .sidebar a:hover, .sidebar .active { background-color:#1b263b; color:#fff; }

        /* --- MAIN CONTENT AREA FIX --- */
        .main-content { 
            margin-left: 16.666667%; 
            width: 83.333333%; 
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar { background:white; padding:15px 25px; box-shadow:0 2px 6px rgba(0,0,0,0.08); }
        
        /* Cards & UI */
        .card-box { border:none; border-radius:15px; padding:25px; background:white; box-shadow:0 4px 15px rgba(0,0,0,0.05); animation: slideUp 0.5s ease-out; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        .list-box { height: 350px !important; border-radius: 12px !important; border: 2px solid #f1f5f9 !important; padding: 10px; font-size: 0.9rem; transition: 0.3s; }
        .list-box:focus { border-color: #0d6efd !important; box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1); }
        .list-box option { padding: 10px; margin-bottom: 4px; border-radius: 8px; animation: fadeIn 0.3s ease forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateX(-10px); } to { opacity: 1; transform: translateX(0); } }

        .btn-move-circle { width: 50px; height: 50px; border-radius: 50%; border: none; background: #fff; color: #0d6efd; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); font-size: 1.2rem; }
        .btn-move-circle:hover { background: #0d6efd; color: #fff; transform: scale(1.15) rotate(10deg); }

        .search-input { border-radius: 20px; border: 1px solid #e2e8f0; padding: 8px 15px; background: #f8fafc; transition: 0.3s; }
        .search-input:focus { background: #fff; border-color: #0d6efd; outline: none; }
    </style>
</head>
<body>

<div class="d-flex">
    <div class="sidebar p-3">
        <h5 class="mb-4 fw-bold">Dashboard</h5>
        <a href="../../public/dashboard.php">🏠 Home</a>
        
<h6 class="text-uppercase text-secondary mt-3 mx-3" >Main</h6>
        <a href="../../public/dashboard.php" class="active">📊 Dashboard</a>
        <a href="../../public/attendance.php">📝 Take Attendance</a>
        <a href="../../public/viewattendance.php">📅 View Attendance</a>
        <a href="../../public/assign.php">📚 Create Course</a>

        <h6 class="text-uppercase text-secondary mt-4 mx-3" >Reports & Assigns</h6>
        <a href="../../public/viewassign.php">👨‍🎓 Student Assigns</a>
        <a href="../../public/teacher_assign_report.php">👨‍🏫 Teacher Assigns</a>

        <h6 class="text-uppercase text-secondary mt-4 mx-3" >Management</h6>
        <a href="../../public/studentact.php">👨‍🎓 Students</a>
        <a href="../../public/teacheract.php">👨‍🏫 Teachers</a>
        <a href="../../public/courseact.php">📖 Courses</a>

        <hr class="text-secondary opacity-25">
        <a href="../../public/logout.php" class="text-danger">🚪 Logout</a>
    </div>

    <div class="main-content">
        <div class="topbar d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">Smart Assignment</h4>
            <div class="text-muted small"><?= date('l, d M Y') ?></div>
        </div>

        <div class="p-4 flex-grow-1">
            <form action="assign.php?action=save" method="POST" id="assignForm">
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="card-box">
                            <label class="small fw-bold text-muted text-uppercase mb-2 d-block">Target Course</label>
                            <select name="course_id" class="form-select border-0 bg-light fw-bold" required>
                                <option value="">-- Choose Course --</option>
                                <?php foreach($courses as $c): ?>
                                    <option value="<?= $c['course_id'] ?>"><?= $c['coursename'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-box">
                            <label class="small fw-bold text-muted text-uppercase mb-2 d-block">Lead Teacher</label>
                            <select name="teacher_id" class="form-select border-0 bg-light fw-bold" required>
                                <option value="">-- Choose Teacher --</option>
                                <?php foreach($teachers as $t): ?>
                                    <option value="<?= $t['teacher_id'] ?>"><?= $t['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-box">
                    <div class="row align-items-center">
                        <div class="col-md-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="fw-bold text-secondary small">Available Pool <span class="badge bg-light text-dark border ms-1" id="availCount">0</span></span>
                                <input type="text" class="search-input w-50" placeholder="Filter..." onkeyup="filterList('available', this.value)">
                            </div>
                            <select id="available" multiple class="form-control list-box">
                                <?php foreach($allStudents as $s): ?>
                                    <option value="<?= $s['student_id'] ?>"><?= $s['name'] ?> (<?= $s['rollno'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-2 text-center d-flex flex-column align-items-center gap-4">
                            <button type="button" class="btn-move-circle" onclick="move('available', 'selected')">
                                <i class="fa fa-chevron-right"></i>
                            </button>
                            <button type="button" class="btn-move-circle" onclick="move('selected', 'available')">
                                <i class="fa fa-chevron-left"></i>
                            </button>
                        </div>

                        <div class="col-md-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="fw-bold text-primary small">Selected Roster <span class="badge bg-primary ms-1" id="selectCount">0</span></span>
                                <span class="text-muted small">Total selected</span>
                            </div>
                            <select id="selected" name="student_ids[]" multiple class="form-control list-box border-primary" required></select>
                        </div>
                    </div>

                    <div class="mt-5 text-center">
                        <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill fw-bold shadow-lg">
                            <i class="fa fa-check-circle me-2"></i>Finalize & Save Assignment
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="p-4 pt-0">
            <button type="button" class="btn btn-outline-secondary btn-sm px-4 rounded-pill" onclick="history.back()">
               <i class="fa fa-arrow-left me-2"></i> Back
            </button>
        </div>
    </div>
</div>

<script>
function updateStats() {
    document.getElementById('availCount').innerText = document.getElementById('available').options.length;
    document.getElementById('selectCount').innerText = document.getElementById('selected').options.length;
}

function move(fromId, toId) {
    const from = document.getElementById(fromId);
    const to = document.getElementById(toId);
    Array.from(from.selectedOptions).forEach(opt => {
        opt.selected = false;
        to.appendChild(opt);
    });
    updateStats();
}

function filterList(id, query) {
    const opts = document.getElementById(id).options;
    query = query.toLowerCase();
    for (let o of opts) {
        o.style.display = o.text.toLowerCase().includes(query) ? "" : "none";
    }
}

document.getElementById('assignForm').onsubmit = function() {
    const opts = document.getElementById('selected').options;
    if(opts.length === 0) {
        alert("Please add at least one student.");
        return false;
    }
    for (let i = 0; i < opts.length; i++) { opts[i].selected = true; }
    return true;
};

updateStats();
</script>
</body>
</html>