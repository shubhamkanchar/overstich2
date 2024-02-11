<?php

namespace App\DataTables;

use App\Models\Category;
use App\Models\SellerCategoryTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SellerCategoryTableDataTable extends DataTable
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
                return '<a href="'.route('categories.edit',$row->id).'" class="btn btn-sm btn-primary m-1">Edit</a><button class="btn btn-sm btn-danger m-1 delete-category" data-url="'.route('categories.destroy',$row->id).'">Delete</button>';
            })
            ->editColumn('parent_id', function($row){
                return $row->masterCategory?->category ?? '-';
            })
            ->editColumn('subcategory_id', function($row){
                return $row->parentSubCategory?->category ?? '-';
            })
            ->editColumn('created_at', function($row){
                return date('d-m-Y',strtotime($row->created_at));
            })
            ->rawColumns(['parent_id','action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Category $model): QueryBuilder
    {
        return $model->with(['masterCategory', 'parentSubCategory'])->whereNotNull('parent_id')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('sellercategorytable')
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
        return [
            
            Column::make('id'),
            Column::make('category'),
            Column::make('parent_id')->title('Master category'),
            Column::make('subcategory_id')->title('Sub Category'),
            Column::make('created_at'),
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
        return 'SellerCategoryTable_' . date('YmdHis');
    }
}
