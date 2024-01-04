<?php

namespace Database\Seeders;

use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder.
 */
class DatabaseSeeder extends Seeder
{
    use TruncateTable;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        Model::unguard();

        $this->truncateMultiple([
            'activity_log',
            'failed_jobs',
        ]);

        $this->call(AuthSeeder::class);
        $this->call(AnnouncementSeeder::class);
<<<<<<< HEAD
        $this->call(UbigeosSeeder::class);

        $this->call(PostSeeder::class);
=======
        $this->call(EmpresaSeeder::class);
        $this->call(PersonaSeeder::class);
        $this->call(ConductoreSeeder::class);
        $this->call(TablaMaestraSeeder::class);
>>>>>>> 9a4f1f2bb159b571d65fee9572af8b1a5a93ac9f

        Model::reguard();
    }
}
