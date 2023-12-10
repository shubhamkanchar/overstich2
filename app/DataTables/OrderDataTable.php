<?php

namespace App\DataTables;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrderDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('user_name', function($order) {
                return ucfirst($order->user?->name);
            })
            ->addColumn('seller_name', function($order) {
                return ucfirst($order->seller?->name);
            })
            ->addColumn('payment_status', function($order) {
                return ucfirst($order->payments?->status);
            })
            ->addColumn('action', function($order) {
                return '<a href="' . route('admin.order.view', ['id' => $order->id]) . '" class="btn btn-success mt-2">View</a>';
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        $user = auth()->user();
        if($user->user_type == 'seller') {
            $model->where('seller_id', $user->id);
        }

        return $model->with(['seller', 'user', 'payments'])->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('order-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('order_number')->title('Order Number'),
            Column::make('user_name')->title('User'),
            Column::make('seller_name')->title('Seller'),
            Column::make('payment_method')->title('Payment Method'),
            Column::make('payment_status')->title('Payment Status'),
            Column::make('total_amount')->title('Total'),
            Column::make('total_discount')->title('Discount'),
            Column::make('address')->title('Address'),
            Column::make('status')->title('Status'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center')
            ->title('Action')
        ];
    
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Order_' . date('YmdHis');
    }
}
