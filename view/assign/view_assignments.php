<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reports Center - EduPortal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root { --primary-bg: #f0f2f5; --sidebar-color: #0d1b2a; --accent-blue: #007bff; }
        body { background: var(--primary-bg); font-family: 'Inter', sans-serif; margin: 0; }
        
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
        
        /* CONTENT */
        .main-content { margin-left: 18%; width: 82%; min-height: 100vh; }
        .topbar { background: white; padding: 15px 40px; box-shadow: 0 2px 6px rgba(0,0,0,0.08); position: sticky; top: 0; z-index: 999; }
        .card-box { border: none; border-radius: 20px; padding: 30px; background: #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.03); }
        
        /* SOFT DELETE */
        .row-soft-delete { opacity: 0.3; transform: translateX(10px); pointer-events: none; transition: 0.4s; }
        #undoToast { position: fixed; bottom: 30px; right: 30px; display: none; background: #1e293b; color: #fff; padding: 15px 25px; border-radius: 50px; z-index: 9999; }

        /* --- PRINT LOGIC --- */
        #printHeader { display: none; }
        @media print {
            .sidebar, .topbar, .btn, .modal, #undoToast, .card-box label, #courseSelect, .text-end { display: none !important; }
            .main-content { margin-left: 0 !important; width: 100% !important; padding: 0 !important; }
            .card-box { box-shadow: none !important; border: none !important; padding: 0 !important; }
            #printHeader { display: block !important; text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
            th:last-child, td:last-child { display: none !important; } /* Hide Action column */
        }
    </style>
</head>
<body>

<div id="printHeader">
    <h2 style="margin:0;">EDUPORTAL STUDENT REPORT</h2>
    <p>Generated on: <?= date('d M Y, h:i A') ?></p>
    <h4 id="printCourseName" style="color: #007bff;"></h4>
</div>

<div class="modal fade" id="addStudentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold"><i class="fa fa-user-plus text-primary me-2"></i> Quick Add Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted small">Select students to add to <span id="targetCourseName" class="fw-bold"></span>.</p>
                <select id="unassignedList" class="form-select border-0 bg-light" multiple style="height: 200px;"></select>
                <small class="text-muted d-block mt-2">Hold Ctrl to select multiple.</small>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" onclick="saveNewStudents()">Add to Course</button>
            </div>
        </div>
    </div>
</div>

<div id="undoToast">
    <div class="d-flex justify-content-between align-items-center gap-3">
        <span><i class="fa fa-trash-can text-danger me-2"></i> Removing assignment...</span>
        <button class="btn btn-sm btn-warning rounded-pill px-3" onclick="undoDelete()">UNDO</button>
    </div>
</div>

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
            <h4 class="mb-0 fw-bold">Reports Center</h4>
            <div class="text-muted small"><?= date('l, d M Y') ?></div>
        </div>

        <div class="p-4">
            <div class="card-box mb-4">
                <label class="small fw-bold text-muted mb-2 d-block">SELECT COURSE</label>
                <select id="courseSelect" class="form-select border-0 bg-light fw-bold" onchange="loadTable(this.value)">
                    <option value="">-- Choose Course --</option>
                    <?php foreach($courses as $c): ?>
                        <option value="<?= $c['course_id'] ?>"><?= $c['coursename'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="card-box">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Assigned Students List</h5>
                    <div class="d-flex gap-2">
                        <button id="addStudentBtn" class="btn btn-primary rounded-pill px-4 btn-sm d-none" onclick="openAddModal()">
                            <i class="fa fa-plus me-1"></i> Add Student
                        </button>
                        <button id="printBtn" class="btn btn-dark rounded-pill px-4 btn-sm d-none" onclick="window.print()">
                            <i class="fa fa-print me-1"></i> Print Report
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light text-uppercase small fw-bold">
                            <tr>
                                <th>Course</th>
                                <th>Student</th>
                                <th>Roll No</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <tr><td colspan="4" class="text-center py-5 text-muted">Please select a course to view report.</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
let currentCourseId = null;
let deleteTimer = null;
let pendingDelete = null;

function loadTable(courseId) {
    currentCourseId = courseId;
    const tbody = document.getElementById('tableBody');
    const addBtn = document.getElementById('addStudentBtn');
    const printBtn = document.getElementById('printBtn');
    const select = document.getElementById('courseSelect');

    if(!courseId) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center py-5">Select a course.</td></tr>';
        addBtn.classList.add('d-none');
        printBtn.classList.add('d-none');
        return;
    }

    addBtn.classList.remove('d-none');
    printBtn.classList.remove('d-none');
    document.getElementById('printCourseName').innerText = "Course: " + select.options[select.selectedIndex].text;
    
    tbody.innerHTML = '<tr><td colspan="4" class="text-center py-5">Loading...</td></tr>';

    fetch(`viewassign.php?action=filter&course_id=${courseId}`)
        .then(res => res.json())
        .then(data => {
            tbody.innerHTML = '';
            if(data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" class="text-center py-5 text-danger fw-bold">No students assigned.</td></tr>';
                return;
            }
            data.forEach(row => {
                tbody.innerHTML += `
                    <tr id="row-${courseId}-${row.student_id}">
                        <td class="text-primary fw-bold">${row.coursename}</td>
                        <td class="fw-bold">${row.student_name}</td>
                        <td class="text-muted">#${row.rollno}</td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-danger border-0" onclick="softDelete(${courseId}, ${row.student_id})">
                                <i class="fa fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>`;
            });
        });
}

function openAddModal() {
    const select = document.getElementById('courseSelect');
    document.getElementById('targetCourseName').innerText = select.options[select.selectedIndex].text;
    const list = document.getElementById('unassignedList');
    list.innerHTML = '<option>Loading students...</option>';

    fetch(`viewassign.php?action=get_unassigned&course_id=${currentCourseId}`)
        .then(res => res.json())
        .then(data => {
            list.innerHTML = '';
            if(data.length === 0) {
                list.innerHTML = '<option disabled>All students already assigned.</option>';
            } else {
                data.forEach(s => {
                    list.innerHTML += `<option value="${s.student_id}">${s.name} (${s.rollno})</option>`;
                });
            }
            new bootstrap.Modal(document.getElementById('addStudentModal')).show();
        });
}

function saveNewStudents() {
    const selectedIds = Array.from(document.getElementById('unassignedList').selectedOptions).map(o => o.value);
    if(selectedIds.length === 0) return alert("Select at least one student.");

    let formData = new FormData();
    formData.append('course_id', currentCourseId);
    formData.append('student_ids', JSON.stringify(selectedIds));

    fetch(`viewassign.php?action=quick_add`, { method: 'POST', body: formData })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            bootstrap.Modal.getInstance(document.getElementById('addStudentModal')).hide();
            loadTable(currentCourseId);
        }
    });
}

function softDelete(cId, sId) {
    if(deleteTimer) finalDelete();
    document.getElementById(`row-${cId}-${sId}`).classList.add('row-soft-delete');
    pendingDelete = { cId, sId };
    document.getElementById('undoToast').style.display = 'block';
    deleteTimer = setTimeout(finalDelete, 5000);
}

function undoDelete() {
    clearTimeout(deleteTimer);
    document.getElementById(`row-${pendingDelete.cId}-${pendingDelete.sId}`).classList.remove('row-soft-delete');
    document.getElementById('undoToast').style.display = 'none';
    pendingDelete = null;
}

function finalDelete() {
    if(!pendingDelete) return;
    fetch(`viewassign.php?action=delete&course_id=${pendingDelete.cId}&student_id=${pendingDelete.sId}`)
    .then(res => res.json())
    .then(data => {
        if(data.success) document.getElementById(`row-${pendingDelete.cId}-${pendingDelete.sId}`).remove();
        document.getElementById('undoToast').style.display = 'none';
        pendingDelete = null;
    });
}
</script>
</body>
</html>