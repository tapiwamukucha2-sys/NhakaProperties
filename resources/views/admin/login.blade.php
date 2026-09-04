<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login — {{ config('app.name') }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600,700&family=Archivo:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root{ --forest:#123A6B; --forest-dark:#0B2545; --gold:#C08A28; --ink:#131C2B; }
  *{box-sizing:border-box; margin:0; padding:0;}
  body{
    min-height:100vh; display:flex; align-items:center; justify-content:center;
    background:radial-gradient(circle at 30% 20%, #16406f 0%, var(--forest-dark) 55%, #061223 100%);
    font-family:'Archivo', sans-serif; color:#fff;
  }
  .panel{width:100%; max-width:380px; padding:0 24px;}
  .logo{display:flex; align-items:center; justify-content:center; gap:10px; margin-bottom:28px; font-family:'Fraunces',serif; font-weight:700; font-size:22px;}
  .badge{display:inline-flex; align-items:center; gap:6px; background:rgba(192,138,40,0.18); color:var(--gold); border:1px solid rgba(192,138,40,0.4); font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; padding:5px 12px; border-radius:20px; margin:0 auto 18px; width:fit-content;}
  .card{background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.12); border-radius:16px; padding:32px; backdrop-filter:blur(6px);}
  h1{font-family:'Fraunces',serif; font-size:22px; font-weight:600; text-align:center;}
  .sub{text-align:center; font-size:13.5px; color:rgba(255,255,255,0.6); margin-top:6px; margin-bottom:26px;}
  label{display:block; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:.04em; color:rgba(255,255,255,0.55); margin-bottom:6px;}
  input{width:100%; padding:12px 14px; border-radius:8px; border:1px solid rgba(255,255,255,0.15); background:rgba(255,255,255,0.06); color:#fff; font-family:inherit; font-size:14.5px; margin-bottom:18px;}
  input:focus{outline:none; border-color:var(--gold);}
  input::placeholder{color:rgba(255,255,255,0.35);}
  .remember{display:flex; align-items:center; gap:8px; font-size:13px; color:rgba(255,255,255,0.7); margin-bottom:22px;}
  button{width:100%; background:var(--gold); color:var(--forest-dark); border:none; padding:13px; border-radius:8px; font-weight:700; font-size:14.5px; cursor:pointer;}
  button:hover{background:#dbae5a;}
  .error{background:rgba(220,38,38,0.15); border:1px solid rgba(220,38,38,0.4); color:#fca5a5; font-size:13px; padding:10px 14px; border-radius:8px; margin-bottom:18px;}
  .back{display:block; text-align:center; margin-top:22px; font-size:13px; color:rgba(255,255,255,0.5); text-decoration:none;}
  .back:hover{color:#fff;}
  .pw-wrap{position:relative;}
  .pw-wrap input{padding-right:42px;}
  .pw-toggle{position:absolute; right:12px; top:0; bottom:18px; display:flex; align-items:center; background:none; border:none; padding:0; width:auto; margin:0; color:rgba(255,255,255,0.5); cursor:pointer;}
  .pw-toggle:hover{color:#fff;}
  .pw-toggle svg{width:19px; height:19px;}
</style>
</head>
<body>
  <div class="panel">
    <div class="badge">Restricted access</div>
    <div class="logo"><x-logo :size="30" /> {{ config('app.name') }}</div>

    <div class="card">
      <h1>Admin sign in</h1>
      <p class="sub">This is the {{ config('app.name') }} back office — not the public site.</p>

      @if ($errors->any())
        <div class="error">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('admin.login.store') }}">
        @csrf
        <label for="username">Username</label>
        <input id="username" name="username" type="text" value="{{ old('username') }}" placeholder="Nhaka" required autofocus>

        <label for="password">Password</label>
        <div class="pw-wrap">
          <input id="password" name="password" type="password" placeholder="••••••••" required>
          <button type="button" class="pw-toggle" onclick="
            const i = document.getElementById('password');
            i.type = i.type === 'password' ? 'text' : 'password';
            this.querySelector('.eye-open').style.display = i.type === 'password' ? 'block' : 'none';
            this.querySelector('.eye-closed').style.display = i.type === 'password' ? 'none' : 'block';
          " aria-label="Toggle password visibility">
            <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="3"/></svg>
            <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none;"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a21 21 0 0 1 5.06-6.06M9.9 4.24A10.4 10.4 0 0 1 12 4c7 0 11 8 11 8a21 21 0 0 1-2.61 3.68M14.12 14.12a3 3 0 1 1-4.24-4.24" stroke-linecap="round" stroke-linejoin="round"/><path d="M1 1l22 22" stroke-linecap="round"/></svg>
          </button>
        </div>

        <label class="remember">
            <input type="checkbox" name="remember" style="width:auto; margin:0;">
            Keep me signed in
        </label>

        <button type="submit">Sign in to backend</button>
      </form>
    </div>

    <a href="{{ route('home') }}" class="back">← Back to {{ config('app.name') }}</a>
  </div>
</body>
</html>
