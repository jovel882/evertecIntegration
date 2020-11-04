@switch($order->status)
    @case("CREATED")
        @if ($order->transactions->count() == 0 || $order->transactions->first()->current_status != "PENDING")
            <a href="{{ route('orders.pay',["order" => $order->id]) }}" class="btn bg-warning float-right">
                <i class="fa fa-fw fa-credit-card"></i> Pagar
            </a>
        @else
            <div class="alert alert-warning float-right">
                <h5><i class="icon fas fa-exclamation-triangle"></i> Esta orden tiene una transaccion pendientes, hasta que no se resuelva esta no se puede realizar otro intento de pago.</h5>
            </div>                                            
        @endif                                        
        @break
    @case("PAYED")
        <div class="alert alert-success float-right">
            <h5><i class="icon fas fa-thumbs-up"></i> Esta orden ya se encuentra pagada.</h5>
        </div>
        @break
    @default
        <div class="alert alert-danger float-right">
            <h5><i class="icon fas fa-ban"></i> Esta orden ya no puede ser pagada.</h5>
        </div>
@endswitch