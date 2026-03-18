<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><style>
body{font-family:Arial,sans-serif;background:#f4f4f4;margin:0;padding:0}
.wrap{max-width:600px;margin:30px auto;background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.08)}
.header{background:#059669;padding:32px 40px;color:#fff}
.header h1{margin:0;font-size:24px}
.body{padding:32px 40px;color:#374151;line-height:1.7}
.box{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:6px;padding:16px 20px;margin:16px 0}
.btn{display:inline-block;background:#059669;color:#fff;padding:12px 28px;border-radius:6px;text-decoration:none;font-weight:600;margin:16px 0}
.footer{background:#f9fafb;padding:20px 40px;color:#9ca3af;font-size:13px;border-top:1px solid #e5e7eb}
</style></head>
<body>
<div class="wrap">
  <div class="header"><h1>Enrollment Confirmed!</h1></div>
  <div class="body">
    <p>Hi {{ $mentee->name }},</p>
    <p>You have successfully enrolled in the following package:</p>
    <div class="box">
      <strong>{{ $package->title }}</strong><br>
      Mentor: {{ $package->user->name ?? 'N/A' }}<br>
      Sessions: {{ $package->sessions }} &bull; Duration: {{ $package->duration }} mins/session<br>
      Level: {{ ucfirst($package->level) }}
    </div>
    <p>Your mentor will reach out to schedule your first session. You can also send them a message through the chat on your dashboard.</p>
    <a href="{{ config('app.url') }}/dashboard" class="btn">Go to Dashboard</a>
    <p>Best regards,<br>The {{ config('app.name') }} Team</p>
  </div>
  <div class="footer">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</div>
</div>
</body>
</html>
