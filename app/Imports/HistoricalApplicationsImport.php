<?php

namespace App\Imports;

use App\Models\HistoricalApplication;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class HistoricalApplicationsImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;

    public function model(array $row): ?HistoricalApplication
    {
        // Skip rows with no identifying info
        if (empty($row['civil_id']) && empty($row['passport_no']) && empty($row['mobile_number'])) {
            return null;
        }

        $appliedDate = null;
        if (!empty($row['applied_date'])) {
            try {
                $appliedDate = \Carbon\Carbon::parse($row['applied_date'])->format('Y-m-d');
            } catch (\Exception $e) {
                $appliedDate = null;
            }
        }

        return new HistoricalApplication([
            'name'             => $row['name'] ?? null,
            'passport_no'      => isset($row['passport_no']) ? (string) $row['passport_no'] : null,
            'civil_id'         => isset($row['civil_id']) ? (string) $row['civil_id'] : null,
            'mobile_number'    => isset($row['mobile_number']) ? (string) $row['mobile_number'] : null,
            'category'         => $row['category'] ?? null,
            'application_type' => $row['application_type'] ?? null,
            'area_name'        => $row['area'] ?? null,
            'unit_name'        => $row['unit'] ?? null,
            'status'           => $row['status'] ?? null,
            'approved_amount'  => is_numeric($row['approved_amount'] ?? null) ? $row['approved_amount'] : null,
            'applied_date'     => $appliedDate,
            'notes'            => $row['notes'] ?? null,
        ]);
    }
}
