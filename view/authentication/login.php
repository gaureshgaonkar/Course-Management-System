<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login | Institute Management System</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

:root{
    --primary:#1e3a8a;
    --secondary:#0f172a;
    --soft:#f1f5f9;
    --text:#334155;
}

/* BACKGROUND */
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

/* CARD */
.login-card{
    width:100%;
    max-width:440px;
    background:white;
    padding:45px;
    border-radius:18px;
    box-shadow:0 25px 60px rgba(0,0,0,0.12);
    animation:fade .5s ease;
}

/* HEADER */
.brand{
    text-align:center;
    margin-bottom:15px;
}
.brand h2{
    color:var(--primary);
    font-weight:700;
    margin:0;
}
.brand small{
    color:#64748b;
}

/* INPUT */
.form-control{
    padding:14px;
    border-radius:8px;
    border:1px solid #e2e8f0;
}
.form-control:focus{
    border-color:var(--primary);
    box-shadow:0 0 0 3px rgba(30,58,138,.08);
}

/* BUTTON */
.btn-login{
    background:var(--primary);
    color:white;
    padding:13px;
    font-weight:600;
    border-radius:8px;
    border:none;
    transition:.3s;
}
.btn-login:hover{
    background:#162c6b;
}
.btn-login.loading{
    pointer-events:none;
    opacity:.8;
}

/* LINKS */
a{
    text-decoration:none;
    color:var(--primary);
    font-weight:500;
}
a:hover{ text-decoration:underline; }

/* FOOTER */
.footer-note{
    text-align:center;
    margin-top:20px;
    font-size:13px;
    color:#64748b;
}

/* CAPS WARNING */
.caps{
    font-size:12px;
    color:#ef4444;
    display:none;
}

/* ANIMATION */
@keyframes fade{
    from{opacity:0;transform:translateY(20px);}
    to{opacity:1;transform:translateY(0);}
}

</style>
</head>

<body>

<div class="login-card">

    <!-- BRAND -->
    <div class="brand">
        <h2>Institute Portal</h2>
        <small>Secure Academic Management System</small>
    </div>

    <!-- ERROR -->
    <?php if(isset($error)): ?>
        <div class="alert alert-danger text-center py-2">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <!-- FORM -->
    <form method="POST" onsubmit="loadingBtn()">

        <!-- EMAIL -->
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <!-- PASSWORD -->
        <div class="mb-1">
            <label class="form-label">Password</label>
            <div class="input-group">
                <input type="password" id="password" name="password" class="form-control" required onkeyup="checkCaps(event)">
                <button type="button" class="btn btn-outline-secondary" onclick="togglePass()">👁</button>
            </div>
        </div>

        <div id="caps" class="caps">Caps Lock is ON</div>

        <!-- REMEMBER -->
        <div class="d-flex justify-content-between mt-3 mb-4">
            <label><input type="checkbox" name="remember"> Remember me</label>
            <a href="forgot.php">Forgot password?</a>
        </div>

        <!-- BUTTON -->
        <div class="d-grid">
            <button id="loginBtn" class="btn-login">Login to Dashboard</button>
        </div>

        <p class="text-center mt-4">
            New user?
            <a href="register.php">Create account</a>
        </p>

        <p class="text-center">
            <a href="index.php">← Back to Home</a>
        </p>

    </form>

    <div class="footer-note">
        © <?php echo date("Y"); ?> Institute Management System
    </div>

</div>

<script>

/* SHOW PASSWORD */
function togglePass(){
    let p = document.getElementById("password");
    p.type = (p.type==="password") ? "text" : "password";
}

/* CAPS LOCK WARNING */
function checkCaps(e){
    let caps = document.getElementById("caps");
    if(e.getModifierState("CapsLock")){
        caps.style.display="block";
    } else {
        caps.style.display="none";
    }
}

/* LOADING BUTTON */
function loadingBtn(){
    let btn = document.getElementById("loginBtn");
    btn.classList.add("loading");
    btn.innerHTML="Logging in...";
}

</script>

</body>
</html>
