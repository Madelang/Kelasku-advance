<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
            [
                "school_name" => "SMKN 11 SEMARANG"
            ],
            [
                "school_name" => "SMKN HIDAYAH SEMARANG"
            ],
            [
                "school_name" => "SMKN 3 Kendal"
            ],
            [
                "school_name" => "SMK Wikrama 1 Jepara"
            ],
            [
                "school_name" => "SMKN 1 Wonosobo"
            ],
            [
                "school_name" => "SMK Hidayah Semarang"
            ],
            [
                "school_name" => "SMK Syafi'i Akrom Pekalongan"
            ],
            [
                "school_name" => "SMK Cokroaminoto 2 Banjarnegara"
            ],
            [
                "school_name" => "SMK Muh Majenang"
            ],
            [
                "school_name" => "SMKN 1 Jatiroto Wonogiri"
            ],
            [
                "school_name" => "SMKN 10 Semarang"
            ],
            [
                "school_name" => "SMK Jakarta Pusat 1"
            ],
            [
                "school_name" => "SMKN 1 Purwokerto"
            ],
            [
                "school_name" => "SMK RUS Kudus"
            ],
            [
                "school_name" => "SMKN 1 Bangsri"
            ],
            [
                "school_name" => "SMKN 1 Blado"
            ],
            [
                "school_name" => "SMK Telkom Terpadu AKN Marzuqi Pati"
            ],
            [
                "school_name" => "SMKN 9 Semarang"
            ],
            [
                "school_name" => "SMKN 2 Semarang"
            ],
        ])->each(function ($item) {
            School::create($item);
        });
    }
}
