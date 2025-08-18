<?php 
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Region;
use App\Models\District;
use App\Models\Districts;
use App\Models\Regions;
use Illuminate\Support\Facades\Http;

class RegionDistrictSeeder extends Seeder
{
    public function run()
    {
        // Fetch data from the API
        $response = Http::get('https://api.first.org/data/v1/countries');

        // Decode response
        if ($response->successful()) {
            $countries = $response->json()['data'];

            $insertData = [];
            foreach ($countries as $code => $details) {
                $insertData[] = [
                    'code' => $code,
                    'name' => $details['country'],
                    'region' => $details['region'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Insert into the database
            DB::table('countries')->insert($insertData);
        } else {
            $this->command->error('Failed to fetch country data.');
        }

        $regions =[
            [
                "name"=> "Arusha",
                "districts" => [
                
                    ["name"=> "Arumeru Magharibi"],
                
                    ["name"=> "Arumeru Mashariki"],
                
                    ["name"=> "Arusha Mjini "],
                
                    ["name"=> "Karatu"],
                
                    ["name"=> "Longido"],
                
                    ["name"=> "Monduli"]
                ]
            ],    
            [
                "name"=> "Dar es Salaam",
                "districts" => [
                
                    ["name"=> "Kinondoni"],
                
                    ["name"=> "Temeke"],
                
                    ["name"=> "Ilala"],
                
                    ["name"=> "Ubungo"],
                
                    ["name"=> "Kigamboni"]
                ]
            ],
        
            [
                "name"=> "Dodoma",
                "districts" => [
                
                    ["name"=> "Bahi"],
                
                    ["name"=> "Chamwino"],
                
                    ["name"=> "Chemba"],
                
                    ["name"=> "Dodoma"],
                
                    ["name"=> "Kondoa"],
                
                    ["name"=> "Kongwa"],
                
                    ["name"=> "Mpwapwa"]
                ]
            ],
        
            [
                "name"=> "Iringa",
                "districts" => [
                
                    ["name"=> "Bahi"],
                
                    ["name"=> "Chamwino"],
                
                    ["name"=> "Chemba"],
                
                    ["name"=> "Dodoma Mjini"],
                
                    ["name"=> "Dodoma Vijijini"],
                
                    ["name"=> "Kondoa"],
                
                    ["name"=> "Kongwa"],
                
                    ["name"=> "Mpwapwa"]
                ]
            ],
        
            [   
                "name"=> "Kagera",
                "districts" => [
                
                    ["name"=> "Biharamulo"],
                
                    ["name"=> "Bukoba Mjini"],
                
                    ["name"=> "Bukoba Vijijini"],
                
                    ["name"=> "Karagwe"],
                
                    ["name"=> "Missenyi"],
                
                    ["name"=> "Muleba"],
                
                    ["name"=> "Ngara"],
                
                    ["name"=> "Kyerwa"]
                ]
            ],
            [
                "name"=> "Kaskazini Pemba",
                "districts" => [
                
                    ["name"=> "Micheweni"],
                
                    ["name"=> "Wete"]
                ]
            ],    
            [
                "name"=> "Kaskazini Unguja",
                "districts" => [
                
                    ["name"=> "Unguja Kaskazini A"],
                
                    ["name"=> "Unguja Kaskazini B"]
                ]
            ],
        
            [
                "name"=> "Kigoma",
                "districts" => [
                
                    ["name"=> "Kasulu"],
                
                    ["name"=> "Kibondo"],
                
                    ["name"=> "Kigoma Vijijini"],
                
                    ["name"=> "Kigoma Mjini"],
                
                    ["name"=> "Kigoma Ujiji"],
                
                    ["name"=> "Buhigwe"],
                
                    ["name"=> "Kakonko"],
                
                    ["name"=> "Uvinza"]
                ]
            ],
        
            [
                "name"=> "Kilimanjaro",
                "districts" => [
                
                    ["name"=> "Hai"],
                
                    ["name"=> "Moshi Mjini"],
                
                    ["name"=> "Moshi Vijijini"],
                
                    ["name"=> "Mwanga"],
                
                    ["name"=> "Rombo"],
                
                    ["name"=> "Same"],
                
                    ["name"=> "Siha"]
                ]
            ],
        
            [
                "name"=> "Kusini Pemba",
                "districts" => [
                
                    ["name"=> "Chake Chake"],
                
                    ["name"=> "Mkoani"]
                ]
            ],
        
            [
                "name"=> "Kusini Unguja",
                "districts" => [
                
                    ["name"=> "Kati Unguja"],
                
                    ["name"=> "Kusini Unguja"]
                ]
            ],
        
            [
                "name"=> "Lindi",
                "districts" => [
                
                    ["name"=> "Kilwa"],
                
                    ["name"=> "Lindi Mjini"],
                
                    ["name"=> "Lindi Vijijini"],
                
                    ["name"=> "Nachingwea"],
                
                    ["name"=> "Ruangwa"],
                
                    ["name"=> "Liwale"]
                ]
            ],
        
            [   "name"=> "Manyara",
                "districts" => [
                
                    ["name"=> "Babati"],
                
                    ["name"=> "Babati Vijijini"],
                
                    ["name"=> "Hanang"],
                
                    ["name"=> "Kiteto"],
                
                    ["name"=> "Mbulu"],
                
                    ["name"=> "Simanjiro"]
                ]
            ],
        
            [
                "name"=> "Mara",
                "districts" => [
                
                    ["name"=> "Bunda"],
                
                    ["name"=> "Musoma Mjini"],
                
                    ["name"=> "Musoma Vijijini"],
                
                    ["name"=> "Rorya"],
                
                    ["name"=> "Serengeti"],
                
                    ["name"=> "Tarime"]
                ]
            ],
        
            [
                "name"=> "Mbeya",
                "districts" => [
                
                    ["name"=> "Chunya"],
                
                    ["name"=> "Ileje"],
                
                    ["name"=> "Kyela"],
                
                    ["name"=> "Mbarali"],
                
                    ["name"=> "Mbeya Mjini"],
                
                    ["name"=> "Mbeya Vijijini"],
                
                    ["name"=> "Mbozi"]
                ]
            ],
        
            [
                "name"=> "Mjini Magharibi",
                "districts" => [
                
                    ["name"=> "Magharibi Unguja"],
                
                    ["name"=> "Mjini Unguja"]
                ]
            ],
        
            [
                "name"=> "Morogoro",
                "districts" => [
                
                    ["name"=> "Gairo"],
                
                    ["name"=> "Morogoro Mjini"],
                
                    ["name"=> "Morogoro Vijijini"],
                
                    ["name"=> "Kilombero"],
                
                    ["name"=> "Kilosa"],
                
                    ["name"=> "Mvomero"],
                
                    ["name"=> "Malinyi"],
                
                    ["name"=> "Ulanga"]
                ]
            ],
        
            [
                "name"=> "Mtwara",
                "districts" => [
                
                    ["name"=> "Masasi"],
                
                    ["name"=> "Masasi Mjini"],
                
                    ["name"=> "Mtwara Mikindani"],
                
                    ["name"=> "Mtwara Mjini"],
                
                    ["name"=> "Mtwara Vijijini"],
                
                    ["name"=> "Newala"],
                
                    ["name"=> "Tandahimba"]
                ]
            ],
        
            [
                "name"=> "Mwanza",
                "districts" => [
                
                    ["name"=> "Geita"],
                
                    ["name"=> "Ilemela"],
                
                    ["name"=> "Kwimba"],
                
                    ["name"=> "Magu"],
                
                    ["name"=> "Misungwi"],
                
                    ["name"=> "Nyamagana"],
                
                    ["name"=> "Sengerema"],
                
                    ["name"=> "Ukerewe"]
                ]
            ],
        
            [
                "name"=> "Pwani",
                "districts" => [
                
                    ["name"=> "Bagamoyo"],
                
                    ["name"=> "Kibaha"],
                
                    ["name"=> "Kibiti"],
                
                    ["name"=> "Kisarawe"],
                
                    ["name"=> "Mafia"],
                
                    ["name"=> "Mkuranga"],
                
                    ["name"=> "Rufiji"]
                ]
            ],
        
            [
                "name"=> "Rukwa",
                "districts" => [
                
                    ["name"=> "Mpanda"],
                
                    ["name"=> "Nkansi"],
                
                    ["name"=> "Sumbawanga Mjini"],
                
                    ["name"=> "Sumbawanga Vijijini"],
                
                    ["name"=> "Kalambo"]
                ]
            ],
        
            [
                "name"=> "Ruvuma",
                "districts" => [
                
                    ["name"=> "Mbinga"],
                
                    ["name"=> "Namtumbo"],
                
                    ["name"=> "Songea Mjini"],
                
                    ["name"=> "Songea Vijijini"],
                
                    ["name"=> "Tunduru"],
                
                    ["name"=> "Nyasa"]
                ]
            ],
        
            [
                "name"=> "Shinyanga",
                "districts" => [            
                    ["name"=> "Bariadi"],
                
                    ["name"=> "Shinyanga Mjini"],
                
                    ["name"=> "Shinyanga Vijijini"],
                
                    ["name"=> "Bukombe"],
                
                    ["name"=> "Kahama Mjini"],
                
                    ["name"=> "Kahama Vijijini"],
                
                    ["name"=> "Kishapu"],
                
                    ["name"=> "Maswa"],
                
                    ["name"=> "Meatu"]
                ]
            ],
        
            [
                "name"=> "Singida",
                "districts" => [
                
                    ["name"=> "Iramba"],
                
                    ["name"=> "Manyoni"],
                
                    ["name"=> "Singida Mjini"],
                
                    ["name"=> "Singida Vijijini"],
                
                    ["name"=> "Ikungi"],
                
                    ["name"=> "Mkalama"]
                ]
            ],
        
            [
                "name"=> "Tabora",
                "districts" => [
                
                    ["name"=> "Igunga"],
                
                    ["name"=> "Tabora Mjini"],
                
                    ["name"=> "Nzega"],
                
                    ["name"=> "Sikonge"],
                
                    ["name"=> "Urambo"],
                
                    ["name"=> "Uyui"],
                
                    ["name"=> "Kaliua"]
                ]
            ],
        
            [
                "name"=> "Tanga",
                "districts" => [
                
                    ["name"=> "Handeni"],
                
                    ["name"=> "Handeni Mjini"],
                
                    ["name"=> "Handeni Vijijini"],
                
                    ["name"=> "Korogwe"],
                
                    ["name"=> "Lushoto"],
                
                    ["name"=> "Mkinga"],
                
                    ["name"=> "Muheza"],
                
                    ["name"=> "Pangani"],
                
                    ["name"=> "Tanga"]
                ]
            ],
        ];

        foreach ($regions as $regionData) {
            $region = Regions::create(['name' => $regionData['name']]);

            foreach ($regionData['districts'] as $districtData) {
                Districts::create([
                    'name' => $districtData['name'],
                    'region_id' => $region->id
                ]);
            }
        }
    }
}
