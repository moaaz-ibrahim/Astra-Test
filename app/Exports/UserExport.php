<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $data;
    public function __construct($data)
    {
        $this->data = $data;

    }
    public function headings(): array
    {

        return $this->data['columns'];
    }
    public function collection()
    {
        $columns = $this->data['columns'];
        if (in_array('name', $columns)) {
            $key = array_search('name', $columns);
            $columns[$key] = 'full_name';
        }
        $query = User::query();
        $rowsLimit = $this->data['rowsLimit'];
        if(count($columns)> 0)
        $query->select($columns);

    $query->take($rowsLimit);
    return $query->get();
    }
}
