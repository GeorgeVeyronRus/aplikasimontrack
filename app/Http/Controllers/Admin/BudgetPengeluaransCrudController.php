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
        CRUD::setEntityNameStrings('budget pengeluarans', 'budget pengeluarans');
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
        CRUD::setValidation([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:2100',
            'jumlah' => 'required|numeric|min:0',
        ]);

        CRUD::addField(['name' => 'bulan', 'label' => 'Bulan', 'type' => 'number']);
        CRUD::addField(['name' => 'tahun', 'label' => 'Tahun', 'type' => 'number']);
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
