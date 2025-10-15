<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Konyv;
use App\Models\FelhasznaloKonyv;
use App\Models\KonyvKeres;
use App\Models\Kicsereles;
use App\Models\Jelentes;
use App\Models\Statisztika;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@konyvtarcsere.hu',
            'password' => Hash::make('admin123'),
            'telefon' => '+36301234567',
            'varos' => 'Budapest',
            'cim' => 'Admin utca 1.',
            'szerep' => 'admin',
        ]);

        $user1 = User::create([
            'name' => 'Kiss János',
            'email' => 'kiss.janos@example.com',
            'password' => Hash::make('password123'),
            'telefon' => '+36309876543',
            'varos' => 'Debrecen',
            'cim' => 'Petőfi utca 12.',
            'szerep' => 'felhasznalo',
        ]);

        $user2 = User::create([
            'name' => 'Nagy Anna',
            'email' => 'nagy.anna@example.com',
            'password' => Hash::make('password123'),
            'telefon' => '+36201234567',
            'varos' => 'Szeged',
            'cim' => 'Kossuth tér 5.',
            'szerep' => 'felhasznalo',
        ]);

        $user3 = User::create([
            'name' => 'Tóth Gábor',
            'email' => 'toth.gabor@example.com',
            'password' => Hash::make('password123'),
            'telefon' => '+36701234567',
            'varos' => 'Pécs',
            'cim' => 'Dóm tér 8.',
            'szerep' => 'felhasznalo',
        ]);

        // 2. KÖNYVEK
        $konyv1 = Konyv::create([
            'cim' => 'A Gyűrűk Ura',
            'szerzo' => 'J. R. R. Tolkien',
            'kiado' => 'Európa Könyvkiadó',
            'kiadas_ev' => 2020,
            'kategoria' => 'fantasy',
            'leiras' => 'A középföldei kalandok epikus története.',
            'kep' => 'kepek/capaca.jpg',
            'allapot' => 'jó',
        ]);

        $konyv2 = Konyv::create([
            'cim' => 'Harry Potter és a bölcsek köve',
            'szerzo' => 'J. K. Rowling',
            'kiado' => 'Animus',
            'kiadas_ev' => 2018,
            'kategoria' => 'fantasy',
            'leiras' => 'Egy fiú varázslatos kalandjai a Roxfortban.',
            'kep' => 'kepek/capaca.jpg',
            'allapot' => 'új',
        ]);

        $konyv3 = Konyv::create([
            'cim' => '1984',
            'szerzo' => 'George Orwell',
            'kiado' => 'Európa Könyvkiadó',
            'kiadas_ev' => 2019,
            'kategoria' => 'sci-fi',
            'leiras' => 'Disztópikus jövőbeli társadalom története.',
            'kep' => 'kepek/capaca.jpg',
            'allapot' => 'közepes',
        ]);

        $konyv4 = Konyv::create([
            'cim' => 'A dűne',
            'szerzo' => 'Frank Herbert',
            'kiado' => 'Agave Könyvek',
            'kiadas_ev' => 2021,
            'kategoria' => 'sci-fi',
            'leiras' => 'A sivatag bolygó epikus története.',
            'kep' => 'kepek/capaca.jpg',
            'allapot' => 'jó',
        ]);

        $konyv5 = Konyv::create([
            'cim' => 'Az utolsó kívánság',
            'szerzo' => 'Andrzej Sapkowski',
            'kiado' => 'Könyvmolyképző',
            'kiadas_ev' => 2020,
            'kategoria' => 'fantasy',
            'leiras' => 'Vaják történetek gyűjteménye.',
            'kep' => 'kepek/capaca.jpg',
            'allapot' => 'elhasznált',
        ]);

        // 3. FELHASZNÁLÓK KÖNYVEI
        $fk1 = FelhasznaloKonyv::create([
            'felhasznalo_id' => $user1->id,
            'konyv_id' => $konyv1->konyv_id,
            'statusz' => 'elerheto',
            'megjegyzes' => 'Kissé kopott a sarka, de olvasható állapotú.',
        ]);

        $fk2 = FelhasznaloKonyv::create([
            'felhasznalo_id' => $user1->id,
            'konyv_id' => $konyv3->konyv_id,
            'statusz' => 'elerheto',
            'megjegyzes' => 'Tökéletes állapotú.',
        ]);

        $fk3 = FelhasznaloKonyv::create([
            'felhasznalo_id' => $user2->id,
            'konyv_id' => $konyv2->konyv_id,
            'statusz' => 'elerheto',
            'megjegyzes' => 'Új, még becsomagolva.',
        ]);

        $fk4 = FelhasznaloKonyv::create([
            'felhasznalo_id' => $user3->id,
            'konyv_id' => $konyv4->konyv_id,
            'statusz' => 'elerheto',
            'megjegyzes' => 'Pár hajtásnyom van benne.',
        ]);

        $fk5 = FelhasznaloKonyv::create([
            'felhasznalo_id' => $user3->id,
            'konyv_id' => $konyv5->konyv_id,
            'statusz' => 'foglalt',
            'megjegyzes' => 'A borítója kissé elnyűtt.',
        ]);

        // 4. KÖNYVKERESÉSEK
        KonyvKeres::create([
            'felhasznalo_id' => $user2->id,
            'konyv_id' => $konyv1->konyv_id,
            'statusz' => 'aktiv',
        ]);

        KonyvKeres::create([
            'felhasznalo_id' => $user3->id,
            'konyv_id' => $konyv2->konyv_id,
            'statusz' => 'aktiv',
        ]);

        // 5. CSERÉK
        Kicsereles::create([
            'felado_id' => $user1->id,
            'fogado_id' => $user2->id,
            'felado_konyv_id' => $fk1->felhasznalo_konyv_id,
            'fogado_konyv_id' => $fk3->felhasznalo_konyv_id,
            'statusz' => 'fuggo',
        ]);

        // 6. JELENTÉSEK
        Jelentes::create([
            'bejelento_id' => $user1->id,
            'cel_konyv_id' => $konyv5->konyv_id,
            'tipus' => 'hamis_adat',
            'leiras' => 'A könyv állapota rosszabb, mint amennyire hirdetik.',
            'statusz' => 'fuggo',
        ]);

        // 7. STATISZTIKA
        Statisztika::create([
            'datum' => now()->format('Y-m-d'),
            'regisztralt_felhasznalok' => 4,
            'hozzaadott_konyvek' => 5,
            'aktiv_cserék' => 1,
            'lezart_cserék' => 0,
        ]);
    }
}
