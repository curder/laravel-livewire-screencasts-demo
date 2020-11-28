<?php
namespace App\Http\Livewire\DataTable;

use Illuminate\Database\Eloquent\Builder;

trait WithSorting
{
    public array $sorts = [];
    /**
     * @param  string  $field
     */
    public function sortBy(string $field) : void
    {
        if (!isset($this->sorts[ $field ])) {
            $this->sorts[ $field ] = 'asc';

            return;
        }
        if ($this->sorts[ $field ] === 'asc') {
            $this->sorts[ $field ] = 'desc';

            return;
        }
        unset($this->sorts[ $field ]);
    }
    public function applySorting(Builder $query) : Builder
    {
        foreach ($this->sorts as $field => $direction) {
            $query->orderBy($field, $direction);
        }

        return $query;
    }
}
