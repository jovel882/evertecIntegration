@php
    switch (session('update')['status']) {
        case 'PAYED':
            $class = 'success';
            $icon = 'thumbs-up';
            break;
        case 'PENDING':
            $class = 'warning';
            $icon = 'hourglass-half';
            break;
        case 'REJECTED':
            $class = 'danger';
            $icon = 'times-circle';
            break;                                
        case 'REFUNDED':
            $class = 'danger';
            $icon = 'history';
            break;                                
        default:
            $class = 'info';
            $icon = 'plus-circle';
            break;
    }
@endphp
<div class="alert alert-{{ $class }} alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-fw fa-times-circle"></i></button>
    <h5>{{ session('update')['status'] }}</h5>
    <i class="fa fa-fw fa-{{ $icon }}"></i> El estado de esta transaccion es {{ session('update')['status'] }}.
    <div style="margin-bottom: 1em;">
        Esta es la razon:  {{ session('update')['message'] }}
    </div> 
</div>