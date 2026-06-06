<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register | Institute Management System</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

:root{
    --primary:#1e3a8a;
    --soft:#f1f5f9;
}

/* BACKGROUND */
body{
    margin:0;
    min-height:100vh;
    font-family:'Segoe UI',sans-serif;
    background:
        radial-gradient(circle at 15% 20%, #dbeafe, transparent 35%),
        radial-gradient(circle at 85% 10%, #e0f2fe, transparent 35%),
        linear-gradient(135deg,#eef2ff,#f8fafc);
    display:flex;
    align-items:center;
    justify-content:center;
    padding:20px;
}

/* CARD */
.register-card{
    width:100%;
    max-width:470px;
    background:white;
    padding:45px;
    border-radius:18px;
    box-shadow:0 25px 60px rgba(0,0,0,0.12);
    animation:fade .5s ease;
}

/* HEADER */
.brand{
    text-align:center;
    margin-bottom:20px;
}
.brand h2{
    color:var(--primary);
    font-weight:700;
    margin:0;
}
.brand small{ color:#64748b; }

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
.btn-register{
    background:var(--primary);
    color:white;
    padding:13px;
    font-weight:600;
    border-radius:8px;
    border:none;
    transition:.3s;
}
.btn-register:hover{ background:#162c6b; }
.btn-register.loading{ opacity:.8; pointer-events:none; }

/* PASSWORD STRENGTH */
.strength{
    height:6px;
    border-radius:6px;
    margin-top:5px;
    background:#e5e7eb;
}
.strength-bar{
    height:100%;
    width:0%;
    border-radius:6px;
    transition:.3s;
}

/* FOOTER */
.footer-note{
    text-align:center;
    margin-top:18px;
    font-size:13px;
    color:#64748b;
}

@keyframes fade{
    from{opacity:0;transform:translateY(20px);}
    to{opacity:1;transform:translateY(0);}
}

</style>
</head>

<body>

<div class="register-card">

    <!-- BRAND -->
    <div class="brand">
        <h2>Create Account</h2>
        <small>Institute Management System</small>
    </div>

    <!-- ERROR -->
    <?php if(isset($error)): ?>
        <div class="alert alert-danger text-center py-2">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <!-- SUCCESS -->
    <?php if(isset($success)): ?>
        <div class="alert alert-success text-center py-2">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <!-- FORM -->
    <form method="POST" onsubmit="return validateForm()">

        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Password</label>
            <div class="input-group">
                <input type="password" id="password" name="password" class="form-control" required onkeyup="checkStrength()">
                <button type="button" class="btn btn-outline-secondary" onclick="togglePass('password')">👁</button>
            </div>
            <div class="strength"><div id="bar" class="strength-bar"></div></div>
        </div>

        <div class="mb-3 mt-3">
            <label class="form-label">Confirm Password</label>
            <div class="input-group">
                <input type="password" id="confirm" name="confirm" class="form-control" required>
                <button type="button" class="btn btn-outline-secondary" onclick="togglePass('confirm')">👁</button>
            </div>
        </div>

        <div class="d-grid">
            <button id="regBtn" class="btn-register">Create Account</button>
        </div>

        <p class="text-center mt-4">
            Already registered? <a href="login.php">Login</a>
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

function togglePass(id){
    let p=document.getElementById(id);
    p.type = (p.type==="password")?"text":"password";
}

/* PASSWORD STRENGTH */
function checkStrength(){
    let p=document.getElementById("password").value;
    let bar=document.getElementById("bar");
    let strength=0;

    if(p.length>5) strength++;
    if(/[A-Z]/.test(p)) strength++;
    if(/[0-9]/.test(p)) strength++;
    if(/[^A-Za-z0-9]/.test(p)) strength++;

    let colors=["red","orange","#facc15","#22c55e"];
    bar.style.width=(strength*25)+"%";
    bar.style.background=colors[strength-1]||"#e5e7eb";
}

/* VALIDATE */
function validateForm(){
    let p=document.getElementById("password").value;
    let c=document.getElementById("confirm").value;

    if(p!==c){
        alert("Passwords do not match");
        return false;
    }

    document.getElementById("regBtn").innerHTML="Creating Account...";
    document.getElementById("regBtn").classList.add("loading");
    return true;
}

</script>

</body>
</html>
