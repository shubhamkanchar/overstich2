<?php

namespace App\DataTables;

use App\Models\CategoryFilter;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CategoryFilterDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('category', function($row) {
                return ucfirst($row->category?->category);
            })
            ->addColumn('type', function($row) {
                return ucfirst($row->type);
            })
            ->addColumn('value', function($row) {
                return implode(",", json_decode($row->value));
            })
            ->addColumn('action', function($row){
                return '<a href="' . route('category.filters.edit', $row->id) . '" class="btn btn-sm btn-primary m-1">Edit</a>
                <button class="btn btn-sm btn-danger m-1 delete-filter" data-url="' . route('category.filters.destroy', $row->id) . '">Delete</button>';
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(CategoryFilter $model): QueryBuilder
    {
        return $model->with('category')->whereHas('category', function($query){
            $query->whereNull('parent_id');
        })->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('categoryfilter-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1);
                    // ->buttons([
                    //     // Button::make('excel'),
                    //     // Button::make('csv'),
                    //     // Button::make('pdf'),
                    //     // Button::make('print'),
                    //     // Button::make('reset'),
                    //     // Button::make('reload')
                    // ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('category')->title('Category'),
            Column::make('type')->title('Type'),
            Column::make('value')->title('Values'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'CategoryFilter_' . date('YmdHis');
    }
}
