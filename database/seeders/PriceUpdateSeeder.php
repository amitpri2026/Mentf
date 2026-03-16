<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Seeder;

class PriceUpdateSeeder extends Seeder
{
    /**
     * Round a value to the nearest multiple of 50.
     */
    private function round50(int $value): int
    {
        return (int) (round($value / 50) * 50);
    }

    /**
     * Random integer rounded to nearest 50.
     */
    private function randRound50(int $min, int $max): int
    {
        return $this->round50(rand($min, $max));
    }

    public function run(): void
    {
        // ── Update mentor hourly rates (₹100–500, INR) ────────────────────────
        $mentors = User::where('role', 'mentor')->get();

        foreach ($mentors as $mentor) {
            $mentor->update([
                'hourly_rate' => $this->randRound50(100, 500),
                'currency'    => 'INR',
            ]);
        }

        $this->command->info("Updated hourly rates for {$mentors->count()} mentors.");

        // ── Update package prices (sessions × ₹200–500 per class, INR) ───────
        $packages = Package::all();

        foreach ($packages as $package) {
            $sessions      = max(1, (int) $package->sessions);
            $perClassRate  = $this->randRound50(200, 500);
            $totalPrice    = $this->round50($sessions * $perClassRate);

            $package->update([
                'price'    => $totalPrice,
                'currency' => 'INR',
            ]);
        }

        $this->command->info("Updated prices for {$packages->count()} packages.");
    }
}
