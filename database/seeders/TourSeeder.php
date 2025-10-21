<?php
// =============================================================================
// 3️⃣ database/seeders/TourSeeder.php
// =============================================================================
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;

class TourSeeder extends Seeder
{
    public function run(): void
    {
        $tours = [
            // Tours de Machupicchu
            [
                'nombreTour' => 'Machupicchu Full Day',
                'descripcion' => 'Tour de un día completo a Machupicchu con tren turístico, guía y entrada incluida.',
            ],
            [
                'nombreTour' => 'Machupicchu 2D/1N',
                'descripcion' => 'Tour de 2 días y 1 noche a Machupicchu, incluye hospedaje en Aguas Calientes.',
            ],
            [
                'nombreTour' => 'Machupicchu By car',
                'descripcion' => 'Tour a Machupicchu por carretera vía Hidroeléctrica, económico y aventurero.',
            ],
            [
                'nombreTour' => 'Machupicchu Conexión',
                'descripcion' => 'Tour conexión para pasajeros que vienen de camino inca u otras rutas.',
            ],

            // Tours con Boleto Turístico
            [
                'nombreTour' => 'City Tour',
                'descripcion' => 'Recorrido por los principales atractivos de Cusco: Catedral, Qoricancha, Sacsayhuamán, Qenqo, Puka Pukara y Tambomachay.',
            ],
            [
                'nombreTour' => 'Valle Sagrado',
                'descripcion' => 'Tour al Valle Sagrado visitando Pisac, Ollantaytambo, Chinchero y Moray.',
            ],
            [
                'nombreTour' => 'Valle Sagrado VIP',
                'descripcion' => 'Valle Sagrado en servicio privado con almuerzo gourmet incluido.',
            ],
            [
                'nombreTour' => 'Valle Sur',
                'descripcion' => 'Recorrido por el Valle Sur: Tipón, Pikillacta y Andahuaylillas (Capilla Sixtina de América).',
            ],
            [
                'nombreTour' => 'Maras Moray',
                'descripcion' => 'Tour a las salineras de Maras y los andenes circulares de Moray.',
            ],

            // Tours adicionales
            [
                'nombreTour' => 'Montaña de Colores',
                'descripcion' => 'Caminata a la famosa Montaña de 7 Colores (Vinicunca), 5200 msnm.',
            ],
            [
                'nombreTour' => 'Laguna Humantay',
                'descripcion' => 'Caminata a la hermosa laguna turquesa Humantay, 4200 msnm.',
            ],
            [
                'nombreTour' => 'Cuatrimotos',
                'descripcion' => 'Tour en cuatrimotos visitando Moray, Salineras y mirador.',
            ],
            [
                'nombreTour' => 'Camino Inca 4D/3N',
                'descripcion' => 'Trekking clásico de 4 días al Camino Inca llegando a Machupicchu.',
            ],
            [
                'nombreTour' => 'Salkantay Trek 5D/4N',
                'descripcion' => 'Trekking alternativo de 5 días por la ruta de Salkantay.',
            ],
        ];

        foreach ($tours as $tour) {
            Tour::create($tour);
        }

        $this->command->info('✅ Tours creados: ' . count($tours) . ' tours');
    }
}
