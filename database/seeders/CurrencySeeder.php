<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        $currencies = [
            ['code' => 'USD', 'name' => 'US Dollar', 'symbol' => '$', 'exchange_rate' => 1.0000],
            ['code' => 'EUR', 'name' => 'Euro', 'symbol' => '€', 'exchange_rate' => 0.9200],
            ['code' => 'GBP', 'name' => 'British Pound', 'symbol' => '£', 'exchange_rate' => 0.7900],
            ['code' => 'INR', 'name' => 'Indian Rupee', 'symbol' => '₹', 'exchange_rate' => 83.0000],
            ['code' => 'AUD', 'name' => 'Australian Dollar', 'symbol' => 'A$', 'exchange_rate' => 1.5400],
            ['code' => 'CAD', 'name' => 'Canadian Dollar', 'symbol' => 'C$', 'exchange_rate' => 1.3600],
        ];

        foreach ($currencies as $currency) {
            Currency::create(array_merge($currency, ['is_active' => true]));
        }
    }
}
