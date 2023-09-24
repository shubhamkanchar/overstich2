<?php

namespace App\DataTables;

use App\Models\Seller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SellersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function(){
                return '<a class="btn btn-sm btn-primary m-2">Approve</a>
                <a class="btn btn-sm btn-warning m-2">Reject</a>
                <a class="btn btn-sm btn-danger m-2">Delete</a>';
            })
            ->editColumn('updated_at',function($row){
                return Carbon::createFromDate($row->updated_at)->format('d-m-Y');
            })
            ->editColumn('GST',function($row){
                return $row->sellerInfo->gst;
            })
            ->editColumn('WhatsApp',function($row){
                return $row->sellerInfo->whatsapp;
            })
            ->editColumn('account',function($row){
                return $row->sellerInfo->account;
            })
            ->editColumn('IFSC',function($row){
                return $row->sellerInfo->ifsc;
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->where('user_type','seller')->with(['sellerInfo'])->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('sellers-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
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
        return [
            Column::make('name'),
            Column::make('email'),
            Column::make('GST'),
            Column::make('WhatsApp'),
            Column::make('account'),
            Column::make('IFSC'),
            Column::make('updated_at'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Sellers_' . date('YmdHis');
    }
}
