<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateTypesToCatalanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = Type::all();

        $catTexts = [
            [
                'name' => 'Sons naturals',
                'description' => 'Cant dels ocells, seguiment de l\'aigua, vent en la vegetació'
            ],
            [
                'name' => 'Éssers humans',
                'description' => 'Converses, riures, nens/as, jugant, trepitjades'
            ],
            [
                'name' => 'Soroll del trànsit',
                'description' => 'Cotxes, autobusos, trens, avions'
            ],
            [
                'name' => 'Altres sorolls',
                'description' => 'Sirenes, construcció, indústria, càrrega de mercaderies'
            ]
        ];

        $types->each(function ($type_update, $key) use ($catTexts) {
            $type_update->name = $catTexts[$key]['name'];
            $type_update->description = $catTexts[$key]['description'];
            $type_update->save();
        });
    }
}
