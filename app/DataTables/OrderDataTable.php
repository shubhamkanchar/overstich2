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
        $user = auth()->user(); 
        
        $dataTable = (new EloquentDataTable($query))
            ->addColumn('user_name', function($order) {
                return ucfirst($order->user?->name);
            })
            ->addColumn('seller_name', function($order) {
                return ucfirst($order->seller?->name);
            })
            ->addColumn('payment_status', function($order) {
                return ucfirst($order->payments?->status);
            })
            ->addColumn('action', function($order) use ($user) {
                $route = route('admin.order.view', ['id' => $order->id]);
                $html = '';
                if($user->user_type == 'seller') {
                    $route = route('seller.order.view', ['id' => $order->id]);    
                    $html .= '<a href="' .route('seller.order.shipment',$order->id). '" class="btn btn-sm btn-success m-1" title="Create Shipment"><i class="bi bi-truck fs-5"></i></a>';
                }
                $html .= '<a href="' . route('seller.order.slip',$order->id) . '" class="btn btn-sm btn-danger m-1" title="Generate Shipping Label"><i class="bi bi-filetype-pdf fs-5"></i></a>';
                $html .= '<a href="' . $route . '" class="btn btn-sm btn-primary m-1" title="View Order"><i class="bi bi-eye-fill fs-5"></i></a>';
                return $html;
            })
            ->setRowId('id');

            
            if ($user->user_type == 'admin') {
                $dataTable->addColumn('seller_name', function ($order) {
                    return ucfirst($order->seller?->name);
                });
            }
    
            return $dataTable;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        $user = auth()->user();
        if($user->user_type == 'seller') {
           $model = $model->where('seller_id', $user->id);
        }
        return $model->where(['is_order_confirmed' => 1])
            ->leftjoin('users', 'users.id', '=', 'orders.user_id')
            ->select('users.name as username', 'orders.*')
            ->with(['seller', 'user', 'payments'])->newQuery();
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
                    // ->selectStyleSingle()
                    ->responsive(true)
                    ->buttons([
                        // Button::make('excel'),
                        // Button::make('csv'),
                        // Button::make('pdf'),
                        // Button::make('print'),
                        // Button::make('reset'),
                        // Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        $columns = [
            Column::make('order_number')->title('Order Number'),
            Column::make('user_name')->title('User')->name('users.name'),
            // Column::make('seller_name')->title('Seller'),
        ];

        $user = auth()->user();
        if ($user->user_type == 'admin') {
            $columns[] = Column::make('seller_name')->title('Seller')->orderable(false);
        }

        $columns = array_merge($columns, [
            Column::make('payment_method')->title('Payment Method'),
            Column::make('payment_status')->title('Payment Status'),
            Column::make('total_amount')->title('Total'),
            Column::make('total_discount')->title('Discount'),
            Column::make('address')->title('Address'),
            Column::make('status')->title('Status'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            // ->width(60)
            ->addClass('text-center')
            ->title('Action')
        ]);

        return $columns;
    
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Order_' . date('YmdHis');
    }
}
