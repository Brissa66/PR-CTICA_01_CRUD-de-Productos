<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        Producto::query()->delete();

        $productos = [
            ['nombre' => 'Laptop Pro 14', 'descripcion' => 'Equipo para desarrollo y productividad', 'precio' => 18999.99, 'stock' => 8],
            ['nombre' => 'Mouse Inalámbrico', 'descripcion' => 'Sensor óptico y conexión Bluetooth', 'precio' => 399.50, 'stock' => 35],
            ['nombre' => 'Teclado Mecánico', 'descripcion' => 'Switches táctiles y retroiluminación', 'precio' => 1299.00, 'stock' => 14],
            ['nombre' => 'Monitor 27"', 'descripcion' => 'Pantalla IPS Full HD', 'precio' => 3599.00, 'stock' => 11],
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }
    }
}
