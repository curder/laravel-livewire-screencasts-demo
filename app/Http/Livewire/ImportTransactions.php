<?php
namespace App\Http\Livewire;

use App\Csv;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * @method notify(string $string)
 */
class ImportTransactions extends Component
{
    use WithFileUploads;

    public bool $showModal = false;
    public $upload;
    public array $columns = [];
    public array $fieldColumnMap = [
        'title' => '',
        'amount' => '',
        'status' => '',
        'date_for_editing' => '',
    ];

    protected array $rules = [
        'fieldColumnMap.title' => 'required',
        'fieldColumnMap.amount' => 'required',
    ];
    protected array $customAttributes = [
        'fieldColumnMap.title' => 'title',
        'fieldColumnMap.amount' => 'amount',
    ];

    public function updatingUpload($value) : void
    {
        Validator::make(
            ['upload' => $value],
            ['upload' => 'required|mimes:txt,csv'],
        )->validate();
    }

    public function updatedUpload() : void
    {
        $this->columns = Csv::from($this->upload)->columns();

        $this->guessWhichColumnsMapToWhichFields();
    }

    public function import() : void
    {
        $this->validate();

        $importCount = 0;

        Csv::from($this->upload)
           ->eachRow(function ($row) use (&$importCount) {
               Transaction::create(
                   $this->extractFieldsFromRow($row)
               );

               $importCount++;
           });

        $this->reset();

        $this->emit('refreshTransactions'); // 数据刷新事件

        $this->notify('Imported '.$importCount.' transactions!'); // 导入成功提醒
    }

    public function extractFieldsFromRow($row)
    {
        $attributes = collect($this->fieldColumnMap)
            ->filter()
            ->mapWithKeys(function ($heading, $field) use ($row) {
                return [$field => $row[$heading]];
            })
            ->toArray();

        return $attributes + ['status' => 'success', 'date_for_editing' => now()];
    }

    public function guessWhichColumnsMapToWhichFields() : void
    {
        $guesses = [
            'title' => ['title', 'label'],
            'amount' => ['amount', 'price'],
            'status' => ['status', 'state'],
            'date_for_editing' => ['date_for_editing', 'date', 'time'],
        ];

        foreach ($this->columns as $column) {
            $match = collect($guesses)->search(fn ($options) => in_array(strtolower($column), $options));

            if ($match) {
                $this->fieldColumnMap[$match] = $column;
            }
        }
    }
}
