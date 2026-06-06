<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Workload Intelligence</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { background:#f4f6f9; font-family:"Segoe UI",sans-serif; margin:0; }
        
        /* SIDEBAR & LAYOUT */
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

        .main-content { margin-left: 16.66%; width: 83.33%; min-height: 100vh; }
        .topbar { background:white; padding:15px 25px; box-shadow:0 2px 6px rgba(0,0,0,0.08); }
        .card-box { border:none; border-radius:15px; padding:25px; background:white; box-shadow:0 4px 15px rgba(0,0,0,0.05); }

        /* PRINT LOGIC */
        @media print {
            .sidebar, .topbar, .btn, .filter-section, #undoToast, .action-col { display: none !important; }
            .main-content { margin-left: 0 !important; width: 100% !important; background: white !important; }
            .card-box { box-shadow: none !important; border: none !important; padding: 0 !important; }
            #printHeader { display: block !important; text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
            .table { border: 1px solid #dee2e6 !important; width: 100% !important; }
        }
        #printHeader { display: none; }

        /* Undo Toast */
        #undoToast { position: fixed; bottom: 30px; right: 30px; display: none; background: #1e293b; color: #fff; padding: 15px 25px; border-radius: 50px; z-index: 9999; }
        .row-soft-delete { opacity: 0.2; transform: scale(0.98); pointer-events: none; transition: 0.4s; }
    </style>
</head>
<body>

<div id="undoToast">
    <div class="d-flex align-items-center gap-3">
        <span class="small"><i class="fa fa-info-circle text-warning me-2"></i> Removing teacher from course...</span>
        <button class="btn btn-sm btn-warning rounded-pill fw-bold px-3" onclick="undoDelete()">UNDO</button>
    </div>
</div>

<div class="d-flex">
    <div class="sidebar p-3">
        <h5 class="mb-4 fw-bold">Dashboard</h5>
        <a href="../../public/dashboard.php">🏠 Home</a>

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
        <div class="topbar d-flex justify-content-between">
            <h4 class="fw-bold mb-0">Teacher Workload Summary</h4>
            <div class="text-muted small"><?= date('l, d M Y') ?></div>
        </div>

        <div class="p-4">
            <div id="printHeader">
                <h2>EDUPORTAL - TEACHER ASSIGNMENT REPORT</h2>
                <p>Generated on: <?= date('d M Y, h:i A') ?></p>
            </div>

            <div class="card-box mb-4 filter-section">
                <label class="fw-bold mb-2 text-primary small text-uppercase">Analyze Teacher Workload</label>
                <select id="teacherSelect" class="form-select border-0 bg-light fw-bold py-2" onchange="loadTable(this.value)">
                    <option value="">-- Select a Teacher --</option>
                    <?php foreach($teachers as $t): ?>
                        <option value="<?= $t['teacher_id'] ?>"><?= $t['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="card-box">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0 text-dark">Assigned Courses <span id="statBadge"></span></h5>
                    <button onclick="window.print()" class="btn btn-dark rounded-pill px-4 btn-sm fw-bold">
                        <i class="fa fa-print me-2"></i> Print Report
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light text-uppercase small">
                            <tr>
                                <th>Course Module</th>
                                <th>Teacher Name</th>
                                <th class="text-end action-col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <tr><td colspan="3" class="text-center py-5 text-muted">Select a teacher to analyze workload.</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4 filter-section">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="history.back()">
                    <i class="fa fa-arrow-left me-2"></i> Back
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let deleteTimer = null;
let pendingDelete = null;

function loadTable(tId) {
    const tbody = document.getElementById('tableBody');
    const badge = document.getElementById('statBadge');
    
    if(!tId) { 
        tbody.innerHTML = '<tr><td colspan="3" class="text-center py-5 text-muted">Select a teacher.</td></tr>'; 
        badge.innerHTML = '';
        return; 
    }

    tbody.innerHTML = '<tr><td colspan="3" class="text-center py-4">Processing...</td></tr>';

    fetch(`teacher_assign_report.php?action=filter&teacher_id=${tId}`)
        .then(res => res.json())
        .then(data => {
            tbody.innerHTML = '';
            badge.innerHTML = `<span class="badge bg-primary ms-2 rounded-pill">${data.length}</span>`;

            if(data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="3" class="text-center py-5 text-danger fw-bold">No courses assigned to this teacher.</td></tr>';
                return;
            }
            
            data.forEach(row => {
                tbody.innerHTML += `
                    <tr id="row-${row.course_id}-${row.teacher_id}">
                        <td class="text-primary fw-bold">${row.coursename}</td>
                        <td class="text-muted">${row.teacher_name}</td>
                        <td class="text-end action-col">
                            <button class="btn btn-sm btn-outline-danger border-0" onclick="softDelete(${row.course_id}, ${row.teacher_id})">
                                <i class="fa fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>`;
            });
        });
}

function softDelete(cId, tId) {
    if(deleteTimer) finalDelete();
    const row = document.getElementById(`row-${cId}-${tId}`);
    if(row) row.classList.add('row-soft-delete');
    
    pendingDelete = { cId, tId };
    document.getElementById('undoToast').style.display = 'block';
    deleteTimer = setTimeout(() => finalDelete(), 6000);
}

function undoDelete() {
    clearTimeout(deleteTimer);
    if(pendingDelete) {
        const row = document.getElementById(`row-${pendingDelete.cId}-${pendingDelete.tId}`);
        if(row) row.classList.remove('row-soft-delete');
    }
    document.getElementById('undoToast').style.display = 'none';
    pendingDelete = null; deleteTimer = null;
}

function finalDelete() {
    if(!pendingDelete) return;
    const { cId, tId } = pendingDelete;
    fetch(`teacher_assign_report.php?action=delete&course_id=${cId}&teacher_id=${tId}`)
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                const row = document.getElementById(`row-${cId}-${tId}`);
                if(row) row.remove();
            }
            document.getElementById('undoToast').style.display = 'none';
            pendingDelete = null; deleteTimer = null;
        });
}
</script>
</body>
</html>