<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Course Management System</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

:root{
    --primary:#1e3a8a;
    --secondary:#0f172a;
    --accent:#22c55e;
    --soft:#f1f5f9;
    --text:#334155;
}

/* BODY WITH GRADIENT BACKGROUND */
body{
    font-family:'Segoe UI',sans-serif;
    background: radial-gradient(circle at 20% 20%, #dbeafe, transparent 40%),
                radial-gradient(circle at 80% 0%, #e0f2fe, transparent 40%),
                linear-gradient(135deg,#eef2ff,#f8fafc);
    min-height:100vh;
    color:var(--text);
}

/* NAVBAR */
.navbar{
    background:white;
    border-bottom:1px solid #e2e8f0;
    padding:16px 30px;
}
.brand{
    font-weight:700;
    font-size:20px;
    color:var(--primary);
}

/* MAIN PANEL */
.portal{
    max-width:1150px;
    margin:70px auto;
    background:white;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 30px 70px rgba(0,0,0,0.12);
    animation:fade .7s ease;
}

/* LEFT PANEL */
.left{
    background:linear-gradient(135deg,var(--secondary),var(--primary));
    color:white;
    padding:70px 50px;
}
.left h1{
    font-size:40px;
    font-weight:700;
}
.left p{
    margin-top:15px;
    opacity:.9;
    line-height:1.6;
}

/* FEATURES */
.features{
    margin-top:35px;
}
.feature{
    background:rgba(255,255,255,0.15);
    padding:14px 16px;
    border-radius:8px;
    margin-bottom:10px;
    font-size:15px;
}

/* RIGHT PANEL */
.right{
    padding:70px 50px;
}

.portal-btn{
    display:block;
    width:100%;
    padding:16px;
    border-radius:10px;
    text-decoration:none;
    text-align:center;
    font-weight:600;
    margin-bottom:16px;
    transition:.3s;
    font-size:16px;
}

.login-btn{
    background:var(--primary);
    color:white;
}
.login-btn:hover{
    background:#162c6b;
    transform:translateY(-2px);
}

.register-btn{
    border:2px solid var(--primary);
    color:var(--primary);
}
.register-btn:hover{
    background:var(--primary);
    color:white;
    transform:translateY(-2px);
}

/* FOOTER */
footer{
    text-align:center;
    margin:35px 0 20px;
    color:#64748b;
    font-size:14px;
}

/* FADE ANIMATION */
@keyframes fade{
    from{opacity:0;transform:translateY(20px);}
    to{opacity:1;transform:translateY(0);}
}

</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar">
    <span class="brand">Course Management System</span>
</nav>

<!-- PORTAL PANEL -->
<div class="portal row g-0">

    <!-- LEFT -->
    <div class="col-md-6 left">
        <h1>Academic ERP Portal</h1>
        <p>
            Manage students, teachers, attendance, and courses in one centralized academic system designed for institutes and training centers.
        </p>

        <div class="features">
            <div class="feature">✔ Student Information & Records</div>
            <div class="feature">✔ Faculty & Course Management</div>
            <div class="feature">✔ Smart Attendance Monitoring</div>
            <div class="feature">✔ Academic Reporting Dashboard</div>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="col-md-6 right">
        <h3 class="mb-4">Portal Access</h3>

        <a href="/public/login.php" class="portal-btn login-btn">
            Login to System
        </a>

        <a href="/public/register.php" class="portal-btn register-btn">
            Create New Account
        </a>

        <p class="text-muted mt-4" style="font-size:14px">
            Authorized institute members only. Contact administrator if you need access.
        </p>
    </div>

</div>

<footer>
    © <?php echo date("Y"); ?> Institute Management System
</footer>

</body>
</html>
