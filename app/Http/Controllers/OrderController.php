<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrder;
use App\Http\Responsables\OrderCreate;
use App\Http\Responsables\OrderPay;
use App\Models\Order;
use Facades\App\Strategies\Pay\Context;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class OrderController extends Controller
{
    /**
     * Estado creado.
     */
    public const STATUSCREATED = 'CREATED';

    /**
     * Estado creado.
     */
    public const STATUSPENDING = 'PENDING';

    /**
     * Modelo de orden.
     *
     * @var Order
     */
    protected $order;

    /**
     * Constructor de la clase.
     *
     * @param Order $order Modelo Order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('web.orders.list', [
            'orders' => $this->order->getAll(auth()->user()->can('viewAny', Order::class)),
        ]);
    }

    /**
     * Almacena una nueva orden.
     *
     * @param StoreOrder $request Request con la data y from request para validacion.
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrder $request, MessageBag $messageBag)
    {
        return new OrderCreate($messageBag, $this->order->store($this->getDataCreate($request)));
    }

    /**
     * Muestra el detalle de una orden.
     *
     * @param int $idOrder Id de la orden.
     * @return \Illuminate\Http\Response
     */
    public function show($idOrder)
    {
        if ($order = $this->order->getById($idOrder, auth()->user()->can('viewAny', Order::class))) {
            $this->authorize('view', $order);
            return view('web.orders.view', compact('order'));
        }

        abort(404);
    }

    /**
     * Iniciar un pago.
     *
     * @param Order $order Modelo para pagar.
     * @return \Illuminate\Http\Response
     */
    public function pay(Order $order, MessageBag $messageBag)
    {
        $this->authorize('pay', $order);

        if ($order->status !== self::STATUSCREATED) {
            return new OrderPay($messageBag, $order, [
                "No se puede realizar el pago ya que la orden se encuentra en estado {$order->status} el cual es un estado final y no permite reintentar el pago",
            ]);
        }

        $transaction = $order->getLastTransaction();
        if (! $transaction || ($transaction->current_status !== self::STATUSPENDING && $transaction->current_status !== self::STATUSCREATED)) {
            return $this->getResponsePay(Context::pay($order, 'place_to_pay'), $order, $messageBag);
        }
        if ($transaction->current_status !== self::STATUSCREATED) {
            return new OrderPay($messageBag, $order, [
                "No se puede realizar el pago ya que la ultima transaccion se encuentra en estado {$transaction->current_status} no permite crear otra transaccion",
            ]);
        }
        return redirect($transaction->url ?? '');
    }

    private function getDataCreate(Request $request)
    {
        $request->merge([
            'total' => $request->quantity * config('config.product_price'),
            'status' => self::STATUSCREATED,
            'user_id' => auth()->user()->id,
        ]);
        return $request->all();
    }

    private function getResponsePay($response, Order $order, MessageBag $messageBag)
    {
        if (! $response) {
            return new OrderPay($messageBag, $order, [
                'msg_0' => 'El metodo de pago no esta soportado o no esta accesible.',
            ]);
        }

        if (! $response->success) {
            return new OrderPay($messageBag, $order, [
                'msg_0' => 'Se genero un error al crear la transacion.',
                'msg_1' => $response->exception->getMessage(),
            ]);
        }
        return redirect($response->url);
    }
}
