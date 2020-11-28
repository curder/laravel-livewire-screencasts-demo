<?php
namespace App;

class Csv
{
    public $file;
    public function __construct($file)
    {
        $this->file = $file;
    }
    public static function from($file) : Csv
    {
        return new static($file);
    }
    public function columns()
    {
        return $this->openFile(function ($handle) {
            return array_filter(fgetcsv($handle, 1000, ','));
        });
    }
    protected function openFile($callback)
    {
        $handle = fopen($this->file->getRealPath(), 'r');

        return $callback($handle);
        fclose($handle);
    }
    public function eachRow($callback) : Csv
    {
        $this->openFile(function ($handle) use ($callback) {
            $columns = array_filter(fgetcsv($handle, 1000, ','));
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $row = [];
                for ($i = 0, $iMax = count($data); $i < $iMax; $i++) {
                    if (!isset($columns[ $i ])) {
                        continue;
                    }
                    $row[ $columns[ $i ] ] = $data[ $i ];
                }
                $callback($row);
            }
        });

        return $this;
    }
}
