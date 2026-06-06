<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password | Institute Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root { --primary: #1e3a8a; --whatsapp: #25d366; }
        body {
            margin: 0; min-height: 100vh; font-family: 'Segoe UI', sans-serif;
            background: radial-gradient(circle at 10% 20%, #dbeafe, transparent 35%),
                        radial-gradient(circle at 90% 10%, #e0f2fe, transparent 35%),
                        linear-gradient(135deg, #eef2ff, #f8fafc);
            display: flex; align-items: center; justify-content: center; padding: 20px;
        }
        .card-box {
            width: 100%; max-width: 440px; background: white; padding: 40px;
            border-radius: 18px; box-shadow: 0 25px 60px rgba(0,0,0,0.12);
            animation: fade .5s ease;
        }
        .brand { text-align: center; margin-bottom: 25px; }
        .brand h2 { color: var(--primary); font-weight: 700; margin: 0; }
        .brand small { color: #64748b; font-size: 0.9rem; }
        
        .form-label { font-weight: 600; color: #475569; font-size: 0.85rem; }
        .form-control { padding: 12px 15px; border-radius: 10px; border: 1px solid #e2e8f0; background: #f8fafc; }
        .form-control:focus { border-color: var(--primary); background: #fff; box-shadow: 0 0 0 3px rgba(30,58,138,.08); }
        
        .btn-main {
            background: var(--primary); color: white; padding: 12px;
            font-weight: 600; border-radius: 10px; border: none; transition: .3s; width: 100%;
        }
        .btn-main:hover { background: #162c6b; transform: translateY(-2px); }

        /* Share Options UI */
        .share-section {
            background: #f1f5f9; padding: 15px; border-radius: 12px; margin-top: 20px;
            border: 1px dashed #cbd5e1;
        }
        .btn-whatsapp { background: var(--whatsapp); color: white; border: none; padding: 10px; border-radius: 8px; width: 100%; font-weight: 600; transition: .3s; }
        .btn-whatsapp:hover { background: #128c7e; color: white; }
        
        .back-link { text-align: center; margin-top: 25px; font-size: 0.9rem; }
        a { text-decoration: none; color: var(--primary); font-weight: 600; }
        
        @keyframes fade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>

<div class="card-box">
    <div class="brand">
        <div class="mb-3 text-primary">
            <i class="fa fa-shield-alt fa-3x"></i>
        </div>
        <h2>Account Recovery</h2>
        <small>Enter email to get your reset link</small>
    </div>

    <?php if(isset($msg)): ?>
        <div class="alert alert-success border-0 shadow-sm small fw-bold mb-0">
             <?= $msg ?>
        </div>

        <div class="share-section text-center">
            <p class="small fw-bold text-muted mb-2">QUICK SHARE OPTIONS</p>
            <div class="d-grid gap-2">
                <a href="https://api.whatsapp.com/send?text=Hi, here is your password reset link: <?= strip_tags($msg) ?>" target="_blank" class="btn btn-whatsapp">
                    <i class="fab fa-whatsapp me-2"></i> Share on WhatsApp
                </a>
                <button class="btn btn-light btn-sm border fw-bold" onclick="copyToClipboard()">
                    <i class="fa fa-copy me-2"></i> Copy Reset Link
                </button>
            </div>
        </div>
    <?php endif; ?>

    <?php if(isset($error)): ?>
        <div class="alert alert-danger text-center py-2 small fw-bold border-0">
            <i class="fa fa-exclamation-circle me-1"></i> <?= $error ?>
        </div>
    <?php endif; ?>

    <?php if(!isset($msg)): ?>
    <form method="POST">
        <div class="mb-4">
            <label class="form-label text-uppercase small">Registered Email</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fa fa-envelope text-muted"></i></span>
                <input type="email" name="email" class="form-control border-start-0 shadow-none" placeholder="example@mail.com" required>
            </div>
        </div>

        <button type="submit" name="recover_password" class="btn btn-main shadow">
            Generate Recovery Link
        </button>
    </form>
    <?php endif; ?>

    <div class="back-link">
        <a href="login.php" class="text-muted small">
            <i class="fa fa-arrow-left me-1"></i> Back to Login
        </a>
    </div>
</div>

<script>
function copyToClipboard() {
    // Extracting URL from the $msg link tag
    const link = document.querySelector('.alert-success a').href;
    navigator.clipboard.writeText(link).then(() => {
        alert("Reset link copied to clipboard!");
    });
}
</script>

</body>
</html>