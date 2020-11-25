<?php
namespace App\Http\Livewire;

use Illuminate\Validation\Rule;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortField = 'date';
    public string $sortDirection = 'desc';
    public bool $showEditModal = false;
    public Transaction $editing;

    protected $queryString = [
        'search', 'sortField', 'sortDirection'
    ];

    public function rules() : array
    {
        return [
            'editing.title' => ['required', 'min:3'],
            'editing.amount' => ['required'],
            'editing.status' => ['required', Rule::in(collect(Transaction::STATUS)->keys())],
            'editing.date_for_editing' => ['required'],
        ];
    }

    public function mount() : void
    {
        $this->editing = $this->makeBlankTransaction();
    }
    public function create()
    {
        if ($this->editing->getKey()) { // 处理新增数据临时退出的情况，保留已编辑的字段内容
            $this->editing = $this->makeBlankTransaction();
        }
        $this->showEditModal = true;
    }

    public function edit(Transaction $transaction)
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

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $transactions = Transaction::search('title', $this->search)
                                   ->orderBy($this->sortField, $this->sortDirection)
                                   ->paginate(10);

        return view('livewire.dashboard', compact('transactions'));
    }
}
