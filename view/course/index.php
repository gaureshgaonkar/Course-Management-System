<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }

        .sidebar {
            height: 100vh;
            background-color: #0d1b2a;
            color: white;
        }

        .sidebar a {
            color: #cbd5e1;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            border-radius: 8px;
        }

        .sidebar a:hover,
        .sidebar .active {
            background-color: #1b263b;
            color: #fff;
        }

        .topbar {
            background-color: #0d1b2a;
            color: white;
            padding: 15px 25px;
        }

        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .table thead {
            background-color: #e9ecef;
        }
    </style>
</head>

<body>
<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-md-2 sidebar p-3">

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
            <hr class="text-secondary">

            <a href="../../public/logout.php" class="text-danger">🚪 Logout</a>

        </div>


        <!-- Main Content -->
        <div class="col-md-10 p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Course List</h3>
                <a href="courseact.php?action=form" class="btn btn-primary">
                    + Add Course
                </a>
            </div>

            <div class="card card-custom p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Course Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($courses as $c): ?>
                            <tr>
                                <td><?= $c['course_id'] ?></td>
                                <td><?= $c['coursename'] ?></td>
                                <td>
                                    <a href="courseact.php?action=form&courseid=<?= $c['course_id'] ?>" 
                                       class="btn btn-sm btn-warning">
                                       Edit
                                    </a>

                                    <a href="courseact.php?action=delete&courseid=<?= $c['course_id'] ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Delete this course?')">
                                       Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            </div>

            <button type="button" class="btn btn-secondary mt-3" onclick="goBack()">
                ← Back
            </button>

        </div>
    </div>
</div>

<script>
function goBack() {
    if (window.history.length > 1) {
        window.history.back();
    } else {
        window.location.href = "index.php";
    }
}
</script>

</body>
</html>
