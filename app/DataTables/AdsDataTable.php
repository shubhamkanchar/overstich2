<?php

namespace App\DataTables;

use App\Models\AdsModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AdsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function($row){
                return '<a href="'.route('ads.edit',$row->id).'" class="btn btn-primary btn-sm m-1">edit</a>
                <form action="'.route('ads.destroy',$row->id).'" method="post">'.csrf_field().''.method_field('DELETE').'<button type="submit" class="btn btn-danger btn-sm m-1">Delete</button></form>';
            })
            ->editColumn('created_at',function($row){
                return Carbon::createFromFormat('Y-m-d H:i:s',$row->created_at)->format('d/m/Y');
            })
            ->editColumn('file',function($row){
                return '<img class="aspect-img" src="'.asset('image/banner/'.$row->file).'">';
            })
            ->setRowId('id')
            ->rawColumns(['action','created_at','file']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(AdsModel $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('ads-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
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
            Column::make('file')->width(100),
            Column::make('link'),
            Column::make('location'),
            Column::make('status'),
            Column::make('created_at'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                //   ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Ads_' . date('YmdHis');
    }
}
