<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Teacher Management</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{ background:#f4f6f9; }
.sidebar{ height:100vh; background:#0d1b2a; color:white; }
.sidebar a{
    color:#cbd5e1; text-decoration:none; display:block;
    padding:12px 20px; border-radius:8px;
}
.sidebar a:hover,.sidebar .active{
    background:#1b263b;color:#fff;
}
.card-custom{
    border:none;border-radius:15px;
    box-shadow:0 4px 15px rgba(0,0,0,0.05);
}
</style>
</head>
<body>

<div class="container-fluid">
<div class="row">

<!-- SIDEBAR -->
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
    <a href="logout.php" class="text-danger">🚪 Logout</a>

</div>

<!-- MAIN -->
<div class="col-md-10 p-4">

<h3 class="mb-4">
<?= isset($teacher['id']) ? 'Edit Teacher' : 'Add Teacher' ?>
</h3>

<div class="card card-custom p-4">

<form method="post" action="teacheract.php?action=save">

<input type="hidden" name="id" value="<?= $teacher['teacher_id'] ?? '' ?>">

<div class="row mb-3">
<div class="col-md-6">
<label class="form-label">Teacher Name</label>
<input type="text" name="name" class="form-control"
value="<?= $teacher['name'] ?? '' ?>" required>
</div>

<div class="col-md-6">
<label class="form-label">Email</label>
<input type="email" name="email" class="form-control"
value="<?= $teacher['email'] ?? '' ?>" required>
</div>
</div>

<div class="row mb-3">
<div class="col-md-6">
<label class="form-label">Mobile</label>
<input type="text" name="mobile" class="form-control"
value="<?= $teacher['mobileno'] ?? '' ?>" required>
</div>

<div class="col-md-6">
<label class="form-label">Subject</label>
<input type="text" name="subject" class="form-control"
value="<?= $teacher['subject'] ?? '' ?>" required>
</div>
</div>

<div class="d-flex gap-2">
<button class="btn btn-success">
<?= isset($teacher['id']) ? 'Update' : 'Save' ?>
</button>

<button type="button" class="btn btn-secondary" onclick="history.back()">
← Back
</button>
</div>

</form>
</div>
</div>
</div>
</div>

</body>
</html>
