<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Intelligence - EduPortal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { background:#f4f6f9; font-family:"Segoe UI",sans-serif; margin:0; overflow-x: hidden; }
        
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

        /* --- MAIN CONTENT AREA --- */
        .main-content { 
            margin-left: 16.666667%; 
            width: 83.333333%; 
            min-height: 100vh; 
            display: flex;
            flex-direction: column;
        }

        .topbar { background:white; padding:15px 25px; box-shadow:0 2px 6px rgba(0,0,0,0.08); }
        .card-box { border:none; border-radius:15px; padding:25px; background:white; box-shadow:0 4px 15px rgba(0,0,0,0.05); }
        
        /* Toggle Styling */
        .nav-pills .nav-link { border-radius: 50px; font-weight: 600; padding: 10px 25px; color: #64748b; background: #f1f5f9; margin-right: 10px; border: none; }
        .nav-pills .nav-link.active { background: #0d6efd; color: white; }
        .progress-slim { height: 6px; border-radius: 10px; background: #eee; margin-top: 5px; overflow: hidden; }

        /* --- PRINT LOGIC --- */
        @media print {
            .sidebar, .topbar, .nav-pills, .filter-area, .btn-print, .sidebar-label, .back-btn-area {
                display: none !important;
            }
            .main-content { margin-left: 0 !important; width: 100% !important; background: white !important; }
            .card-box { box-shadow: none !important; padding: 0 !important; }
            body { background: white !important; }
            .print-header { display: block !important; text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
            .table { border: 1px solid #dee2e6 !important; }
        }
        .print-header { display: none; }
    </style>
</head>
<body>

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
            <h4 class="fw-bold mb-0">Attendance Reports</h4>
            <div class="text-muted small"><?= date('d M Y') ?></div>
        </div>

        <div class="p-4 flex-grow-1">
            <div class="print-header">
                <h2>EDUPORTAL - ATTENDANCE REPORT</h2>
                <p id="printSubTitle">Generated on: <?= date('d M Y, h:i A') ?></p>
            </div>

            <ul class="nav nav-pills mb-4" id="reportTabs">
                <li class="nav-item">
                    <button class="nav-link active" onclick="switchView('overall', this)">Overall Attendance</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" onclick="switchView('particular', this)">Particular Date View</button>
                </li>
            </ul>

            <div class="card-box mb-4 filter-area">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="small fw-bold text-muted mb-1 text-uppercase">Select Course</label>
                        <select id="courseId" class="form-select border-0 bg-light fw-bold">
                            <?php if(!empty($courses)): foreach($courses as $c): ?>
                                <option value="<?= $c['course_id'] ?>"><?= $c['coursename'] ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>

                    <div id="overallInputs" class="col-md-6 row g-2">
                        <div class="col-6">
                            <label class="small fw-bold text-muted mb-1 text-uppercase">From</label>
                            <input type="date" id="fromDate" class="form-control border-0 bg-light" value="<?= date('Y-m-01') ?>">
                        </div>
                        <div class="col-6">
                            <label class="small fw-bold text-muted mb-1 text-uppercase">To</label>
                            <input type="date" id="toDate" class="form-control border-0 bg-light" value="<?= date('Y-m-d') ?>">
                        </div>
                    </div>

                    <div id="particularInputs" class="col-md-6 d-none">
                        <label class="small fw-bold text-muted mb-1 text-uppercase">Select Date</label>
                        <input type="date" id="singleDate" class="form-control border-0 bg-light" value="<?= date('Y-m-d') ?>">
                    </div>

                    <div class="col-md-2">
                        <button onclick="loadReport()" class="btn btn-primary w-100 rounded-pill fw-bold">Generate</button>
                    </div>
                </div>
            </div>

            <div class="card-box">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 id="reportTitle" class="fw-bold mb-0 text-primary">Student Records</h5>
                    <button onclick="window.print()" class="btn btn-dark btn-sm rounded-pill px-4 btn-print">
                        <i class="fa fa-print me-2"></i> Print Record
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead id="reportTableHead" class="table-light"></thead>
                        <tbody id="reportTbody">
                            <tr><td colspan="5" class="text-center py-5 text-muted">No data generated yet.</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="p-4 pt-0 back-btn-area">
            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="history.back()">
                <i class="fa fa-arrow-left me-2"></i> Back to Previous
            </button>
        </div>
    </div>
</div>

<script>
let currentMode = 'overall';

function switchView(mode, btn) {
    currentMode = mode;
    document.querySelectorAll('.nav-link').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    if(mode === 'overall') {
        document.getElementById('overallInputs').classList.remove('d-none');
        document.getElementById('particularInputs').classList.add('d-none');
    } else {
        document.getElementById('overallInputs').classList.add('d-none');
        document.getElementById('particularInputs').classList.remove('d-none');
    }
}

function loadReport() {
    const cid = document.getElementById('courseId').value;
    const courseSelect = document.getElementById('courseId');
    if(!courseSelect.options.length) return;
    const cName = courseSelect.options[courseSelect.selectedIndex].text;
    const tbody = document.getElementById('reportTbody');
    const thead = document.getElementById('reportTableHead');
    
    tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4">Processing...</td></tr>';

    if(currentMode === 'overall') {
        const from = document.getElementById('fromDate').value;
        const to = document.getElementById('toDate').value;
        document.getElementById('printSubTitle').innerText = `Course: ${cName} | Range: ${from} to ${to}`;
        
        thead.innerHTML = '<tr><th>Roll No</th><th>Student Name</th><th>Present/Total Days</th><th style="width:200px">Percentage</th></tr>';
        
        fetch(`viewattendance.php?action=filter&course_id=${cid}&from_date=${from}&to_date=${to}`)
            .then(res => res.json())
            .then(data => {
                tbody.innerHTML = '';
                if(!data || data.length === 0) { tbody.innerHTML = '<tr><td colspan="4" class="text-center">No records found.</td></tr>'; return; }
                data.forEach(r => {
                    let perc = r.total_working_days > 0 ? Math.round((r.attended_days/r.total_working_days)*100) : 0;
                    let color = perc < 75 ? 'bg-danger' : 'bg-success';
                    tbody.innerHTML += `<tr>
                        <td class="fw-bold">#${r.rollno}</td>
                        <td class="fw-semibold">${r.student_name}</td>
                        <td><span class="badge bg-light text-dark border px-3">${r.attended_days} / ${r.total_working_days} Days</span></td>
                        <td>
                            <div class="progress-slim"><div class="progress-bar ${color}" style="width:${perc}%"></div></div>
                            <small class="fw-bold ${perc < 75 ? 'text-danger' : 'text-success'}">${perc}%</small>
                        </td>
                    </tr>`;
                });
            });
    } else {
        const sDate = document.getElementById('singleDate').value;
        document.getElementById('printSubTitle').innerText = `Course: ${cName} | Date: ${sDate}`;
        thead.innerHTML = '<tr><th>Roll No</th><th>Student Name</th><th>Status</th></tr>';
        
        fetch(`viewattendance.php?action=date_view&course_id=${cid}&date=${sDate}`)
            .then(res => res.json())
            .then(data => {
                tbody.innerHTML = '';
                if(!data || data.length === 0) { tbody.innerHTML = '<tr><td colspan="3" class="text-center text-danger py-4">No records for this date.</td></tr>'; return; }
                data.forEach(r => {
                    tbody.innerHTML += `<tr>
                        <td class="fw-bold">#${r.rollno}</td>
                        <td>${r.name}</td>
                        <td><span class="badge bg-success px-3">PRESENT</span></td>
                    </tr>`;
                });
            });
    }
}
</script>
</body>
</html>