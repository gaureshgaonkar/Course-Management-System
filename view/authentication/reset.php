<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reset Password | IMS</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
:root{ --primary:#1e3a8a; }

body{
    margin:0;
    min-height:100vh;
    font-family:'Segoe UI',sans-serif;
    background:
        radial-gradient(circle at 10% 20%, #dbeafe, transparent 35%),
        radial-gradient(circle at 90% 10%, #e0f2fe, transparent 35%),
        linear-gradient(135deg,#eef2ff,#f8fafc);
    display:flex;
    align-items:center;
    justify-content:center;
    padding:20px;
}

.card-box{
    width:100%;
    max-width:440px;
    background:white;
    padding:45px;
    border-radius:18px;
    box-shadow:0 25px 60px rgba(0,0,0,0.12);
    animation:fade .5s ease;
}

.brand{
    text-align:center;
    margin-bottom:15px;
}
.brand h2{
    color:var(--primary);
    font-weight:700;
}

.form-control{
    padding:14px;
    border-radius:8px;
    border:1px solid #e2e8f0;
}
.form-control:focus{
    border-color:var(--primary);
    box-shadow:0 0 0 3px rgba(30,58,138,.08);
}

.btn-main{
    background:var(--primary);
    color:white;
    padding:13px;
    font-weight:600;
    border-radius:8px;
    border:none;
}
.btn-main:hover{ background:#162c6b; }

@keyframes fade{
    from{opacity:0;transform:translateY(20px);}
    to{opacity:1;transform:translateY(0);}
}
</style>
</head>

<body>

<div class="card-box">

    <div class="brand">
        <h2>Create New Password</h2>
        <small>Enter your new password</small>
    </div>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="d-grid">
            <button class="btn-main">Update Password</button>
        </div>

        <p class="text-center mt-4">
            <a href="login.php">Back to Login</a>
        </p>

    </form>

</div>

</body>
</html>

