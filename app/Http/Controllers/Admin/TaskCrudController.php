<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TaskRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TaskCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TaskCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Task::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/task');
        CRUD::setEntityNameStrings('task', 'tasks');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('title')->label('Title');
        CRUD::column('description')->label('Description');
        CRUD::column('status')->label('Status');
        CRUD::column('created_at')->label('Created At');

        CRUD::addColumn([
            'name' => 'task_owner',
            'label' => 'Task Owner',
            'type' => 'text',
            'value' => function ($entry) {
                return $entry->user_id ? 'User' : 'Guest';
            },
        ]);

        $user = backpack_auth()->user();
        $sessionId = session()->getId();

        if( $user->id != 0){
            $this->crud->addClause('where', function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('user_id', 0); // Гостевые таски (user_id = 0)
            });
        } else {
            $this->crud->addClause('where', 'session_id', $sessionId);
        }

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
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
        CRUD::setValidation(TaskRequest::class);
        CRUD::field('title')->type('text');
        CRUD::field('description')->type('textarea');
        CRUD::field('status')->type('select_from_array')->options([
            'new' => 'New',
            'in_progress' => 'In Progress',
            'done' => 'Done',
        ]);

        if(auth('backpack')->id() != 0 ){
            $this->crud->addField([
                'name' => 'user_id',
                'type' => 'hidden',
                'default' => auth('backpack')->id(),
            ]);
        } else {
            $this->crud->addField([
                'name' => 'user_id',
                'type' => 'hidden',
                'default' => 0,
            ]);
            $this->crud->addField([
                'name' => 'session_id',
                'type' => 'hidden',
                'default' => session()->getId(),
            ]);
        }

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
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
        $this->crud->addField([
            'name'        => 'status',
            'label'       => 'Status',
            'type'        => 'select_from_array',
            'options'     => [
                'new'         => 'New',
                'in_progress' => 'In Progress',
                'done'        => 'Done',
            ],
            'allows_null' => false, // Set to true if you want a "null" option
            'default'     => 'new', // Default value
        ]);

        if(auth('backpack')->id() != 0 ){
            $this->crud->addField([
                'name' => 'user_id',
                'type' => 'hidden',
                'default' => auth('backpack')->id(),
            ]);
        } else {
            $this->crud->addField([
                'name' => 'user_id',
                'type' => 'hidden',
                'default' => 0,
            ]);
            $this->crud->addField([
                'name' => 'session_id',
                'type' => 'hidden',
                'default' => session()->getId(),
            ]);
        }


    }
}
