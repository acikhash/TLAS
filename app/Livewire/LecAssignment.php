<?php

namespace App\Livewire;

use App\Models\Department;
use App\Models\Gred;
use App\Models\Major;
use App\Models\Semester;
use App\Models\Title;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class LecAssignment extends PowerGridComponent
{
    use WithExport;

    public bool $showFilters = true;
    public string  $year;

    public function __construct()
    {
        $this->year = date('Y');

    }

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return DB::table('Assignments')
            ->where('year', '=', $this->year);
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('course_id')
            ->add('staff_id')
            ->add('semester_id')
            ->add('course_code')
            ->add('staff_name')
            ->add('year')
            ->add('semester')
            ->add('credit')
            ->add('notes')
            ->add('created_by')
            ->add('updated_by')
            ->add('deleted_at')
            ->add('created_at')
            ->add('updated_at');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')->index(),
            Column::make('Course id', 'course_id')->hidden(),
            Column::make('Staff id', 'staff_id')->hidden(),
            Column::make('Semester id', 'semester_id')->hidden(),
            Column::make('Course code', 'course_code')
                ->sortable()
                ->searchable(),

            Column::make('Staff name', 'staff_name','staff_name')
                ->sortable(),

            Column::make('Year', 'year','year')
                ->sortable(),

            Column::make('Semester', 'semester')
                ->sortable()->searchable(),

            Column::make('Credit', 'credit')
                ->sortable()
                ->searchable(),

            Column::make('Notes', 'notes')
                ->sortable()
                ->searchable(),



            Column::make('Deleted at', 'deleted_at_formatted', 'deleted_at')
                ->sortable(),



        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('year', 'year')
                ->dataSource(
                    Semester::distinct()
                        ->pluck('year')
                        ->map(fn($year) => ['year' => $year])
                        ->toArray()
                )
                ->optionLabel('year')
                ->optionValue('year'),
            // Filter::select('department', 'department')
            // ->dataSource(Department::all())
            //     ->optionLabel('code')
            //     ->optionValue('code'),

            // Filter::select('gred', 'gred')
            //     ->dataSource(Gred::all())
            //     ->optionLabel('name')
            //     ->optionValue('name'),
            // Filter::select('title', 'title')
            //     ->dataSource(Title::all())
            //     ->optionLabel('name')
            //     ->optionValue('name'),
            Filter::inputText('staff_name')->placeholder('staff_name'),
        ];
    }

    // #[\Livewire\Attributes\On('edit')]
    // public function edit($rowId): void
    // {
    //     $this->js('alert(' . $rowId . ')');
    // }

    // public function actions($row): array
    // {
    //     return [
    //         Button::add('edit')
    //             ->slot('Edit: ' . $row->id)
    //             ->id()
    //             ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
    //             ->dispatch('edit', ['rowId' => $row->id])
    //     ];
    // }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
