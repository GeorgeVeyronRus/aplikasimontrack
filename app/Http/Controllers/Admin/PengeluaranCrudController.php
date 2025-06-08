<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PengeluaranRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PengeluaranCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PengeluaranCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Pengeluaran::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pengeluaran');
        CRUD::setEntityNameStrings('pengeluaran', 'pengeluaran');

         $this->crud->addClause('where', 'user_id', backpack_user()->id);
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
        CRUD::column('kategori_pengeluaran')->label('Kategori Pengeluaran');
        CRUD::column('deskripsi')->label('Deskripsi');
        CRUD::addColumn([
        'name' => 'jumlah',
        'label' => 'Jumlah',
        'type' => 'closure',
        'function' => function($entry) {
            // format jumlah dengan titik sebagai ribuan separator tanpa desimal
                return 'Rp ' .number_format($entry->jumlah, 0, ',', '.');
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
            'kategori_pengeluaran_id' => 'required|exists:kategori_pengeluaran,id',
            'deskripsi' => 'required',
            'jumlah' => 'required|numeric|min:0',
        ]);

        CRUD::field('tanggal')->type('date')->label('Tanggal');

        CRUD::addfield([
            'name' => 'kategori_pengeluaran_id',
            'label' => 'Kategori Pengeluaran',
            'type' => 'select',
            'entity' => 'kategori_pengeluaran',
            'model' => \App\Models\KategoriPengeluaran::class,
            'attribute' => 'nama',
        ]);


        CRUD::field('deskripsi')->label('Deskripsi');


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
