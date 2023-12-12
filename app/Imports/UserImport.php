<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UserImport implements ToModel, WithStartRow, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function startRow(): int
    {
        return 2;
    }
    public function model(array $row)
    {
        try {
            $user = [];
            // Determine the column mapping based on the header row
            $name = $row['full_name'] ?? $row['Full_Name'] ?? $row['FullName'] ?? $row['fullname'] ?? $row['name'] ?? null;
            $email = $row['email'] ?? $row['Email'] ?? $row['EMAIL'] ?? null;
            $phone = $row['phone'] ?? $row['Phone'] ?? $row['PHONE'] ?? $row['telephone_number'] ?? $row['cell'] ?? null;

            if ($name != null)
                $user['full_name'] = $name;
            if ($email != null)
                $user['email'] = $email;
            if ($phone != null)
                $user['phone'] = $phone;
            // If the header-row approach fails (in case the excel doesn't have headers or have a strange header )
            // we'll get the data using regex for each cell
            if ($name == null) {

                $nameRegex = '/^[a-zA-Z\s]+$/';
                $name = null;
                foreach ($row as $columnName => $cell) {
                    if (preg_match($nameRegex, $cell)) {
                        $name = $cell;
                    }
                }
                $user['full_name'] = $name;
            }
            if ($email == null) {
                $emailRegex = '/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/';
                $email = null;
                foreach ($row as $columnName => $cell) {
                    if (preg_match($emailRegex, $cell)) {
                        $email = $cell;
                    }
                }
                $user['email'] = $email;
            }
            if ($phone == null) {
                $phoneRegex = '#^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]{4,}$#';
                $phone = null;
                foreach ($row as $columnName => $cell) {
                    if (preg_match($phoneRegex, $cell)) {
                        $phone = $cell;
                    }
                }
                $user['phone'] = $phone;
            }

            return new User($user);
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
