<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BudgetPengeluaransRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;



/**
 * Class BudgetPengeluaransCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BudgetPengeluaransCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BudgetPengeluarans::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/budget-pengeluarans');
        CRUD::setEntityNameStrings('budget pengeluaran', 'budget pengeluaran');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn(['name' => 'bulan', 'label' => 'Bulan']);
        CRUD::addColumn(['name' => 'tahun', 'label' => 'Tahun']);
        CRUD::addColumn([
            'name' => 'jumlah',
            'label' => 'Jumlah',
            'type' => 'closure',
            'function' => function($entry) {
                return 'Rp ' . number_format($entry->jumlah, 0, ',', '.');
            }
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(\App\Http\Requests\BudgetPengeluaransRequest::class);
        
        // Dropdown bulan (1-12)
        $bulanOptions = [];
        foreach (range(1, 12) as $i) {
            $bulanOptions[$i] = $i;
        }

        CRUD::addField([
            'name' => 'bulan',
            'label' => 'Bulan',
            'type' => 'select_from_array',
            'options' => $bulanOptions,
            'allows_null' => false,
            'default' => date('n'), // bulan sekarang
        ]);

        // Dropdown tahun (2020 - sekarang + 10)
        $currentYear = date('Y');
        $tahunOptions = [];
        foreach (range(2020, $currentYear + 10) as $year) {
            $tahunOptions[$year] = $year;
        }

        CRUD::addField([
            'name' => 'tahun',
            'label' => 'Tahun',
            'type' => 'select_from_array',
            'options' => $tahunOptions,
            'allows_null' => false,
            'default' => $currentYear,
        ]);
        CRUD::addField([
            'name' => 'jumlah',
            'label' => 'Jumlah',
            'type' => 'number',
            'prefix' => 'Rp ',
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
