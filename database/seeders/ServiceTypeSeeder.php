<?php

namespace Database\Seeders;

use App\Models\ServiceType;
use App\Models\User;
use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first admin user or create a fallback ID
        $adminUser = User::first();
        $addedBy = $adminUser ? $adminUser->id : 1;

        $serviceTypes = [
            [
                'name' => 'System Installation',
                'description' => 'Complete system setup and installation services including hardware configuration, software deployment, and initial system testing.',
                'default_duration_months' => 12,
                'is_recurring' => false,
                'base_price' => 500000,
                'icon' => 'bx-server',
            ],
            [
                'name' => 'Maintenance',
                'description' => 'Regular system maintenance including updates, backups, performance optimization, and preventive checks.',
                'default_duration_months' => 12,
                'is_recurring' => true,
                'base_price' => 200000,
                'icon' => 'bx-wrench',
            ],
            [
                'name' => 'Training',
                'description' => 'User training sessions covering system operations, best practices, and troubleshooting basics.',
                'default_duration_months' => null,
                'is_recurring' => false,
                'base_price' => 150000,
                'icon' => 'bx-book-reader',
            ],
            [
                'name' => 'Software License',
                'description' => 'Annual software licensing including access to updates, security patches, and premium features.',
                'default_duration_months' => 12,
                'is_recurring' => true,
                'base_price' => 300000,
                'icon' => 'bx-key',
            ],
            [
                'name' => 'Hardware Support',
                'description' => 'Hardware maintenance and support including repairs, replacements, and warranty services.',
                'default_duration_months' => 12,
                'is_recurring' => true,
                'base_price' => 250000,
                'icon' => 'bx-chip',
            ],
            [
                'name' => 'Consulting',
                'description' => 'Technical consulting services for system planning, architecture design, and technology recommendations.',
                'default_duration_months' => null,
                'is_recurring' => false,
                'base_price' => 100000,
                'icon' => 'bx-support',
            ],
        ];

        foreach ($serviceTypes as $serviceType) {
            ServiceType::updateOrCreate(
                ['name' => $serviceType['name']],
                array_merge($serviceType, ['added_by' => $addedBy])
            );
        }
    }
}
