<?php

namespace App\Http\ViewComposers;

use App\Models\Order;
use Illuminate\View\View;

class OrderComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'viewAny' => auth()->user()->can('viewAny', Order::class),
        ]);
    }
}