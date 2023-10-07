<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sites')->delete();

        DB::table('sites')->insert(array (
            array (
                'id' => 1,
                'name' => 'Verdun Siège',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 2,
                'name' => 'Selvah',
                'zone_count' => 8,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 3,
                'name' => 'Extrusel',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 4,
                'name' => 'Moulin Janet',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 5,
                'name' => 'Maintenance Chalon',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 6,
                'name' => 'Beaune Silo',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 7,
                'name' => 'Bligny sur Ouche',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 8,
                'name' => 'Branges',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 9,
                'name' => 'Broin',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 10,
                'name' => 'Bruailles',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 11,
                'name' => 'Chalon Nord',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 12,
                'name' => 'Chalon Sud',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 13,
                'name' => 'Chaudenay',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 14,
                'name' => 'Cormoz Oxyane ??',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 15,
                'name' => 'Crissey',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 16,
                'name' => 'Cuisia ??',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 17,
                'name' => 'Dracy Saint Loup ??',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 18,
                'name' => 'Etrigny',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 19,
                'name' => 'Flacey ??',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 20,
                'name' => 'Fontaines',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 21,
                'name' => 'Gergy',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 22,
                'name' => 'Givry',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 23,
                'name' => 'Jully les Buxy',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 24,
                'name' => 'Labergement les Seurre',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 25,
                'name' => 'Lays sur le Doubs',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 26,
                'name' => 'Lessard en Bresse',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 27,
                'name' => 'Macon Ceregrain ??',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 28,
                'name' => 'Marnay',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 29,
                'name' => 'Mervans',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 30,
                'name' => 'Meursanges',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 31,
                'name' => 'Montpont en Bresse',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 32,
                'name' => 'Nolay',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 33,
                'name' => 'Pagny',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 34,
                'name' => 'Pierre de Bresse',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 35,
                'name' => 'Romenay',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 36,
                'name' => 'St Benigne',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 37,
                'name' => 'St Gengoux le National',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 38,
                'name' => 'St Germain du Plain',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 39,
                'name' => 'St Leger sur Dheune',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 40,
                'name' => 'St Martin en Bresse',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 41,
                'name' => 'St Usage',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 42,
                'name' => 'Savigny en Revermont',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 43,
                'name' => 'Sennecey le Grand',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 44,
                'name' => 'Seurre',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 45,
                'name' => 'Sevrey',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 46,
                'name' => 'Simandre',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 47,
                'name' => 'Simard',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 48,
                'name' => 'Tournus',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 49,
                'name' => 'Tronchy',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 50,
                'name' => 'Verdun Silo',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
            array (
                'id' => 51,
                'name' => 'Val Union',
                'zone_count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ),
        ));
    }
}
