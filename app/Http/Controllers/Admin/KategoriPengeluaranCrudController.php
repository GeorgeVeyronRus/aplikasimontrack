<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\KategoriPengeluaranRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class KategoriPengeluaranCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class KategoriPengeluaranCrudController extends CrudController
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
        CRUD::setModel(\App\Models\KategoriPengeluaran::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/kategori-pengeluaran');
        CRUD::setEntityNameStrings('kategori pengeluaran', 'kategori pengeluaran');
    }
    public function fetchKategori()
    {
        return \App\Models\KategoriPengeluaran::query()
            ->where('nama', 'like', '%'.request('q').'%')
            ->paginate(10);
    }


    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {   
        CRUD::column('nama')->label('Nama Kategori');
        CRUD::column('deskripsi')->type('textarea')->label('Deskripsi');

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
        'nama' => 'required|max:30',
        'deskripsi' => 'string|max:100'
        ]);

        CRUD::addField([
            'name' => 'nama',
            'label' => 'Nama',
            'type' => 'text',
            'attributes' => [
                'placeholder' => 'Masukkan nama kategori',
            ],
        ]);

        CRUD::addField([
            'name' => 'deskripsi',
            'label' => 'Deskripsi',
            'type' => 'textarea', // atau 'text' tergantung kebutuhan kamu
            'attributes' => [
                'placeholder' => 'Masukkan deskripsi (opsional)',
            ],
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
