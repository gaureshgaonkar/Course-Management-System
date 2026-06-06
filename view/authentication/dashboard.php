<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: ../../public/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>EduPortal | Smart Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    :root {
        --primary-bg: #f0f2f5;
        --sidebar-color: #0d1b2a;
        --accent-blue: #007bff;
        --accent-purple: #6f42c1;
        --text-dark: #1e293b;
    }

    body {
        background-color: var(--primary-bg);
        font-family: 'Inter', 'Segoe UI', sans-serif;
        margin: 0;
        overflow-x: hidden;
    }

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


    /* --- MAIN CONTENT --- */
    .main-content { 
        margin-left: 18%; 
        width: 82%; 
        min-height: 100vh; 
        padding-bottom: 50px;
    }

    .topbar { 
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        padding: 15px 40px; 
        position: sticky;
        top: 0;
        z-index: 999;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .welcome-text h4 { font-weight: 800; color: var(--text-dark); margin: 0; }
    .user-profile { background: #fff; padding: 5px 15px; border-radius: 50px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); font-weight: 600; }

    /* --- INTERACTIVE CARDS --- */
    .dashboard-container { padding: 40px; }
    
    .card-box {
        border: none;
        border-radius: 20px;
        padding: 40px 25px;
        background: #fff;
        text-align: center;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    @keyframes fadeInUp {
        from { transform: translateY(30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .card-box:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .card-box i {
        font-size: 3rem;
        margin-bottom: 20px;
        background: linear-gradient(45deg, var(--accent-blue), var(--accent-purple));
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        transition: 0.3s;
    }

    .card-box:hover i { transform: scale(1.2) rotate(5deg); }

    .card-box h5 { font-weight: 700; color: var(--text-dark); margin-bottom: 15px; }
    .card-box p { color: #64748b; font-size: 0.9rem; margin-bottom: 25px; }

    .btn-open {
        background: linear-gradient(45deg, var(--sidebar-color), #1b263b);
        color: white;
        border: none;
        padding: 10px 30px;
        border-radius: 50px;
        font-weight: 600;
        transition: 0.3s;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
    }
    .btn-open:hover {
        background: var(--accent-blue);
        color: white;
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
    }

    /* Staggered animation for cards */
    .col-md-4:nth-child(1) .card-box { animation-delay: 0.1s; }
    .col-md-4:nth-child(2) .card-box { animation-delay: 0.2s; }
    .col-md-4:nth-child(3) .card-box { animation-delay: 0.3s; }
    .col-md-4:nth-child(4) .card-box { animation-delay: 0.4s; }
    .col-md-4:nth-child(5) .card-box { animation-delay: 0.5s; }
    .col-md-4:nth-child(6) .card-box { animation-delay: 0.6s; }

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
        <div class="topbar">
            <div class="welcome-text">
                <h4>Dashboard Overview</h4>
            </div>
            <div class="user-profile">
                <i class="fa fa-user-circle text-primary me-2"></i>
                <span class="text-dark">Hi, <?php echo htmlspecialchars($_SESSION['user']); ?></span>
            </div>
        </div>

        <div class="dashboard-container">
            <div class="row g-4">
                
                <div class="col-md-4">
                    <div class="card-box">
                        <i class="fa fa-clipboard-list"></i>
                        <h5>Take Attendance</h5>
                        <p>Efficiency starts here. Mark daily student records with one click.</p>
                        <a href="../../public/attendance.php" class="btn btn-open">Go to Console</a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card-box">
                        <i class="fa fa-user-plus"></i>
                        <h5>Course Enrollment</h5>
                        <p>Map students to their respective courses and build your roster.</p>
                        <a href="../../public/assign.php" class="btn btn-open">Manage Enrollment</a>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card-box" style="border: 1px solid rgba(0, 123, 255, 0.1);">
                        <i class="fa fa-layer-group"></i>
                        <h5>Manage Courses</h5>
                        <p>Curate your curriculum. Add or modify institutional course modules.</p>
                        <a href="../../public/courseact.php" class="btn btn-open">View Modules</a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card-box">
                        <i class="fa fa-brain"></i>
                        <h5>Attendance Insights</h5>
                        <p>Analyze trends with AI-driven percentage and history tracking.</p>
                        <a href="../../public/viewattendance.php" class="btn btn-open">Analytics</a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card-box">
                        <i class="fa fa-id-card"></i>
                        <h5>Student Database</h5>
                        <p>Verify and manage student registrations across all departments.</p>
                        <a href="../../public/viewassign.php" class="btn btn-open">Student Records</a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card-box" style="background: linear-gradient(to bottom right, #ffffff, #f8faff);">
                        <i class="fa fa-chalkboard-teacher"></i>
                        <h5>Faculty Assignments</h5>
                        <p>Keep track of leadership roles and faculty course distribution.</p>
                        <a href="../../public/teacher_assign_report.php" class="btn btn-open">Faculty List</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>