<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrder;
use App\Http\Responsables\OrderCreate;
use App\Models\Order;
use Facades\App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class OrderController extends Controller
{
    /**
     * Estado creado.
     *
     */
    public const STATUSCREATED = 'CREATED';
    /**
     * Estado creado.
     *
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
    public function index(Request $request)
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
        return new OrderCreate($this->order->store($this->getDataCreate($request)), $messageBag);
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
    public function pay(Order $order)
    {
        if (\Gate::denies('pay', $order)) {
            abort(403);
        }

        if ($order->status !== self::STATUSCREATED) {
            return redirect()->route('orders.show', ['order' => $order->id]);
        }

        $transaction = $order->getLastTransaction();
        if (! $transaction || ($transaction->current_status !== self::STATUSPENDING && $transaction->current_status !== self::STATUSCREATED)) {
            $response = Payment::pay('place_to_pay', $order);
            if (! $response) {
                return redirect()
                    ->route('orders.show', ['order' => $order->id])
                    ->withInput()
                    ->withErrors(new \Illuminate\Support\MessageBag([
                        'msg_0' => 'El metodo de pago no esta soportado.',
                    ]));
            }

            if (! $response->success) {
                return redirect()
                    ->route('orders.show', ['order' => $order->id])
                    ->withInput()
                    ->withErrors(new \Illuminate\Support\MessageBag([
                        'msg_0' => 'Se genero un error al crear la transacion.',
                        'msg_1' => $response->exception->getMessage(),
                    ]));
            }
            return redirect($response->url);
        }
        if ($transaction->current_status !== self::STATUSCREATED) {
            return redirect()->route('orders.show', ['order' => $order->id]);
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
}
