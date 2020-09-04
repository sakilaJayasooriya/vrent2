<?php

namespace App\DataTables;

use App\Models\Ads;
use Yajra\Datatables\Services\DataTable;

class AdsDataTable extends DataTable
{
    protected $exportColumns = ['name','possition','content'];

    public function ajax()
    {
        $ads = $this->query();

        return $this->datatables
            ->of($ads)
            ->addColumn('content', function ($ads) {
                $content='<p>'.$ads->content. '</p>';
                return $content;
            })
            ->addColumn('action', function ($ads) {
                return '<a target="_blank" href="' . url('admin/settings/edit-ads/' . $ads->id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;<a href="' . url('admin/settings/delete-ads/' . $ads->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="glyphicon glyphicon-trash"></i></a>';
            })
            ->addColumn('possition', function ($ads) {
                $possition='<p>'.$ads->possition. '</p>';
                return $possition;
            })
            ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $ads = Ads::select();
        return $this->applyScopes($ads);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns([
                        'name',
                        'possition',
                        'status'

                    ])
                    ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
                    ->parameters([
                        'dom' => 'lBfrtip',
                        'buttons' => [],
                        'pageLength' => \Session::get('row_per_page'),
                    ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            // add your columns
            'content',
            //'updated_at',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'adsdatatables_' . time();
    }
}
