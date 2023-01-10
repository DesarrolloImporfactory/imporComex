<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ModalidadSeeder::class);
        $this->call(IdiomaSeeder::class);
        $this->call(CargaSeeder::class);
        $this->call(PaisSeeder::class);
        $this->call(EstadoSeeder::class);
        $this->call(ContenedorSeeder::class);
        $this->call(IncotermSeeder::class);
        $this->call(TarifaSeeder::class);
        $this->call(ImpuestoSeeder::class);
    }
}
