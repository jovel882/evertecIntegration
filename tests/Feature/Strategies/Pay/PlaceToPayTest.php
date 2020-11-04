<?php

namespace Tests\Feature\Strategies\Pay;

use App\Models\Transaction;
use Facades\App\Strategies\Pay\Context;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlaceToPayTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }


    public function testAccessTheGateway()
    {
        $response = Context::getInfoPay(
            Transaction::factory()->create([
                'requestId' => '12345',
                'gateway' => 'place_to_pay',
            ]),
            'place_to_pay'
        );
        $this->assertIsObject($response, 'No se pudo resolver en el GatewaySeriveProvider.');
        $this->assertSame($response->data['message'], 'La sesión no pertenece a su sitio', 'Fallo la conexion con la pasarela.');
        $this->assertSame($response->success, true, 'No se pudo actualizar la transaccion.');
    }
}
