<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Natural sounds',
                'description' => 'Signing birds, following water, wind in vegetation'
            ],
            [
                'name' => 'Human beings',
                'description' => 'Conversation, laughter, children at play, footsteps'
            ],
            [
                'name' => 'Traffic noise',
                'description' => 'Car, buses, trains, air planes'
            ],
            [
                'name' => 'Other sounds',
                'description' => 'Siren, construction, industry, loadings of goods'
            ]
        ];

        foreach ($types as $type) {
            \App\Models\Type::create($type);
        }
    }
}
