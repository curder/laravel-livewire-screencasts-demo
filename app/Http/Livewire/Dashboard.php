<?php
namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;

/**
 * Class Dashboard
 *
 * @property \Illuminate\Database\Eloquent\Collection transactions
 *
 * @package App\Http\Livewire
 */
class Dashboard extends Component
{
    use WithPagination;

    public string $sortField = 'date';
    public string $sortDirection = 'desc';
    public bool $showEditModal = false;
    public Transaction $editing;
    public bool $showFilters = false;
    public bool $selectPage = false;
    public array $selected = [];
    public bool $selectAll = false;
    public bool $showDeleteModal = false;
    public array $filters = [
        'search' => '',
        'status' => '',
        'amount-min' => '',
        'amount-max' => '',
        'date-min' => '',
        'date-max' => '',
    ];
    protected $queryString = [
        'sortField', 'sortDirection'
    ];
    public function rules() : array
    {
        return [
            'editing.title'            => [
                'required',
                'min:3'
            ],
            'editing.amount' => ['required'],
            'editing.status'           => [
                'required',
                Rule::in(collect(Transaction::STATUSES)->keys())
            ],
            'editing.date_for_editing' => ['required'],
        ];
    }
    public function mount() : void
    {
        $this->editing = $this->makeBlankTransaction();
    }
    public function showFilters() : void
    {
        $this->showFilters = true;
    }
    public function resetFilters() : void
    {
        $this->reset('filters');
    }
    public function updatedFilters() : void
    {
        $this->resetPage();
    }
    public function updatedSelectPage($value) : void
    {
        $this->selected = $value ? $this->transactions->pluck('id')->map(fn($id) => (string) $id)->toArray() : [];
    }
    public function updatedSelected() : void
    {
        $this->selectAll = false;
        $this->selectPage = false;
    }
    public function selectAll() : void
    {
        $this->selectAll = true;
    }
    public function create() : void
    {
        if ($this->editing->getKey()) { // 处理新增数据临时退出的情况，保留已编辑的字段内容
            $this->editing = $this->makeBlankTransaction();
        }
        $this->showEditModal = true;
    }
    public function edit(Transaction $transaction) : void
    {
        if ($this->editing->isNot($transaction)) { // 处理编辑数据临时退出的情况，保留已编辑的字段内容
            $this->editing = $transaction;
        }
        $this->showEditModal = !$this->showEditModal;
    }

    public function save()
    {
        $this->validate();
        $this->editing->save();
        $this->showEditModal = false;
    }
    /**
     * @param  string  $field
     */
    public function sortBy(string $field) : void
    {
        $this->sortDirection = $this->sortField === $field ? ($this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc') : 'asc';
        $this->sortField     = $field;
    }
    protected function makeBlankTransaction() : Transaction
    {
        return Transaction::make(['date' => now(), 'status' => 'processing']);
    }
    public function exportSelected()
    {
        return response()->streamDownload(function () {
            echo (clone $this->transactionsQuery)->unless($this->selectAll, fn($query) => $query->whereKey($this->selected))->toCsv();
        }, 'transactions.csv');
    }
    public function deleteSelected()
    {
        (clone $this->transactionsQuery)
            ->unless($this->selectAll, fn($query) => $query->whereKey($this->selected))->delete();

        $this->showDeleteModal = false;
    }
    /**
     * @return \Illuminate\Database\Concerns\BuildsQueries|\Illuminate\Database\Eloquent\Builder|mixed
     */
    public function getTransactionsQueryProperty()
    {
        return Transaction::query()
                          ->when($this->filters['status'], fn($query, $status) => $query->where('status', $status))
                          ->when($this->filters['amount-min'],
                              fn($query, $amount) => $query->where('amount', '>=', $amount))
                          ->when($this->filters['amount-max'],
                              fn($query, $amount) => $query->where('amount', '<=', $amount))
                          ->when($this->filters['date-min'],
                              fn($query, $date) => $query->where('date', '>=', Carbon::parse($date)))
                          ->when($this->filters['date-max'],
                              fn($query, $date) => $query->where('date', '<=', Carbon::parse($date)))
                          ->when($this->filters['search'],
                              fn($query, $search) => $query->where('title', 'like', '%'.$search.'%'))
                          ->orderBy($this->sortField, $this->sortDirection);
    }
    public function getTransactionsProperty()
    {
        return $this->transactionsQuery->paginate(10);
    }
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        if ($this->selectAll) {
            $this->selected = $this->transactionsQuery->pluck('id')->map(fn($id) => (string) $id)->toArray();
        }

        return view('livewire.dashboard', [
            'transactions' => $this->transactions,
        ]);
    }
}
