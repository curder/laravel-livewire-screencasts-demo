<?php
namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use App\Http\Livewire\DataTable\WithSorting;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Livewire\DataTable\WithBulkActions;

/**
 * Class Dashboard
 *
 * @property Collection transactions
 * @property mixed rows
 * @property mixed rowsQuery
 *
 * @package App\Http\Livewire
 */
class Dashboard extends Component
{
    use WithPagination, WithSorting, WithBulkActions;

    public bool $showEditModal = false;
    public Transaction $editing;
    public bool $showFilters = false;
    public bool $showDeleteModal = false;
    public array $filters = [
        'search' => '',
        'status' => '',
        'amount-min' => '',
        'amount-max' => '',
        'date-min' => '',
        'date-max' => '',
    ];
    /**
     * @var string[]
     */
    protected $queryString = [];
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

    public function save() : void
    {
        $this->validate();
        $this->editing->save();
        $this->showEditModal = false;
    }

    protected function makeBlankTransaction() : Transaction
    {
        return Transaction::make(['date' => now(), 'status' => 'processing']);
    }
    public function exportSelected()
    {
        return response()->streamDownload(function () {
            echo $this->getSelectedRowsQuery()->toCsv();
        }, 'transactions.csv');
    }
    public function deleteSelected() : void
    {
        $this->getSelectedRowsQuery()->delete();

        $this->showDeleteModal = false;
    }
    /**
     * @return mixed
     */
    public function getRowsQueryProperty()
    {
        $query = Transaction::query()
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
                              fn($query, $search) => $query->where('title', 'like', '%'.$search.'%'));

            return $this->applySorting($query);
    }
    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate(10);
    }
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.dashboard', [
            'transactions' => $this->rows,
        ]);
    }
}
