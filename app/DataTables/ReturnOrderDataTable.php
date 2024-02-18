<?php

namespace App\DataTables;

use App\Models\ReturnOrder;
use App\Models\ReturnOrderModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ReturnOrderDataTable extends DataTable
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
            ->editColumn('status', function($order) {
                return ucwords($order->status).' '.$order->status_condition ;
            })
            ->editColumn('created_at',function($row){
                return Carbon::createFromFormat('Y-m-d H:i:s',$row->created_at)->format('d/m/Y');
            })
            ->addColumn('action', function($row){
                return '<a href="' . route('seller.order.return-view',$row->order_number) . '" class="btn btn-sm btn-primary m-1" title="View Order"><i class="bi bi-eye-fill fs-5"></i></a>';
            })
            ->rawColumns(['action','created_at','status'])
            ->setRowId('id');
            
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ReturnOrderModel $model): QueryBuilder
    {
        return $model->select('orders.id','orders.user_id','return_order_models.order_id','return_order_models.status','orders.order_number','return_order_models.created_at','orders.payment_method','orders.total_amount','return_order_models.status_condition','return_order_models.status')
            ->join('orders','orders.id','=','return_order_models.order_id')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('returnorder-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(7)
                    // ->selectStyleSingle()
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
            Column::make('status')->title('Status'),
            Column::make('created_at'),
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
        return 'ReturnOrder_' . date('YmdHis');
    }
}
