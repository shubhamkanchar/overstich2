<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AdminProductDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('category_id', function ($row) {
                return $row->category?->category;
            })
            ->addColumn('users.name', function ($row) {
                return $row->seller_name;
            })
            ->addColumn('images', function ($row) {
                $images = $row->images;
                $imageHtml = '';

                foreach ($images as $key => $image) {
                    $activeClass = $key === 0 ? 'active' : '';
                    $imageHtml .= '<div class="carousel-item ' . $activeClass . '">
                        <img src="' . asset($image->image_path) . '" class="d-block aspect-img" alt="image">
                        <div class="carousel-caption d-none d-md-block">
                        </div>
                    </div>';
                }
            
                $carousel = '<div id="carousel' . $row->id . '" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        ' . $imageHtml . '
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel' . $row->id . '" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel' . $row->id . '" data-bs-slide="next">
                        <span class="carousel-control-next-icon" ariahidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>';
                
                return $carousel;
            
            })
            ->addColumn('action', function($row){
                $editUrl = route('admin.product.view', $row->slug);
                $images = route('admin.product.images', $row->slug);
                return '<a href="' . $images . '" class="btn btn-sm btn-primary m-1">Images</a>
                        <a href="' . $editUrl . '" class="btn btn-sm btn-primary m-1">View</a>';
            })
            ->rawColumns(['images', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->leftjoin('users', 'users.id', '=', 'products.seller_id')
        ->select('users.name as seller_name','products.*')
            ->with(['category'])
            ->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('adminproduct-table')
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
            Column::make('title')->title('Name'),
            Column::make('brand')->title('Brand'),
            Column::make('users.name')->title('Seller')->name('users.name'),
            Column::make('category_id')->title('Category'),
            Column::make('images')->title('Image')->width(200),
            Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    ->width(100)
                    ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'AdminProduct_' . date('YmdHis');
    }
}
