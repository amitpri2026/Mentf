<?php
namespace App\Http\Controllers;

use App\Helpers\MailHelper;
use App\Mail\EnrollmentMail;
use App\Mail\MentorEnrollmentNotifMail;
use App\Models\Package;
use App\Models\PackageRegister;
use App\Services\AdminNotificationService;
use Illuminate\Support\Facades\Mail;

class EnrollController extends Controller
{
    public function store(Package $package)
    {
        $user = auth()->user();

        if ($package->user_id === $user->id) {
            return back()->with('error', 'You cannot enroll in your own package.');
        }

        $already = PackageRegister::where('package_id', $package->id)
            ->where('user_id', $user->id)
            ->whereIn('status', ['active', 'completed'])
            ->exists();

        if ($already) {
            return back()->with('error', 'You are already enrolled in this package.');
        }

        PackageRegister::create([
            'package_id'     => $package->id,
            'user_id'        => $user->id,
            'status'         => 'active',
            'amount_paid'    => $package->price,
            'currency'       => $package->currency,
            'payment_status' => 'pending',
            'payment_method' => 'direct',
            'enrolled_at'    => now(),
        ]);

        $package->increment('total_enrollments');
        $package->load('user');

        // Send enrollment confirmation email to mentee (BCC admin)
        try {
            $mail = Mail::to($user->email);
            $adminBcc = MailHelper::adminBcc();
            if ($adminBcc && $adminBcc !== $user->email) $mail->bcc($adminBcc);
            $mail->send(new EnrollmentMail($user, $package));
        } catch (\Exception $e) {}

        // Notify mentor
        try {
            if ($package->user) {
                Mail::to($package->user->email)->send(new MentorEnrollmentNotifMail($user, $package));
            }
        } catch (\Exception $e) {}

        // Admin notification
        AdminNotificationService::newEnrollment($user->name, $package->title, $package->user?->name ?? 'N/A');

        return redirect()->route('dashboard')
            ->with('success', "You're enrolled in \"{$package->title}\"! Your mentor has been notified.");
    }
}
