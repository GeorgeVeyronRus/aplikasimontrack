<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PendapatanRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PendapatanCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PendapatanCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Pendapatan::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pendapatan');
        CRUD::setEntityNameStrings('pendapatan', 'pendapatan');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn([
        'name' => 'no',
        'label' => 'No',
        'type' => 'model_function',
        'function_name' => 'getRowNumber',
        'orderable' => false,
        ]);
        CRUD::column('tanggal')->type('date');
        CRUD::column('tipe_pendapatan')->label('Tipe Pendapatan');
        CRUD::addColumn([
        'name' => 'jumlah',
        'label' => 'Jumlah',
        'type' => 'closure',
        'function' => function($entry) {
            // format jumlah dengan titik sebagai ribuan separator tanpa desimal
                return number_format($entry->jumlah, 0, ',', '.') . ' Rp';
            }
        ]);
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
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
            'tanggal' => 'required|date',
            'tipe_pendapatan' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
        ]);

        CRUD::field('tanggal')->type('date')->label('Tanggal');

        CRUD::field('tipe_pendapatan')->type('select_from_array')->label('Tipe Pendapatan')->options([
            'Penjualan' => 'Penjualan',
            'Refund' => 'Refund',
            'Gaji' => 'Gaji',
            'lainnya' => 'Lainnya',
        ]);


        CRUD::addField([
            'name' => 'jumlah',
            'label' => 'Jumlah',
            'type' => 'number',
            'attributes' => [
                'min' => 0,
            ],
            'prefix' => 'Rp ',
            'suffix' => '',
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
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
