<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(protected ?string $schoolCode = null)
    {
    }

    public function collection(): \Illuminate\Support\Enumerable
    {
        return Student::query()
            ->when($this->schoolCode, fn ($query) => $query->where('schoolcode', $this->schoolCode))
            ->orderBy('fname')
            ->get();
    }

    public function headings(): array
    {
        return [
            'School Code',
            'ERP ID',
            'Roll No',
            'First Name',
            'Middle Name',
            'Last Name',
            'Class',
            'Division',
            'DOB',
            'Blood Group',
            'Parent Name',
            'Parent Contact',
            'Address 1',
            'Address 2',
            'Landmark',
            'Pincode',
        ];
    }

    public function map($student): array
    {
        return [
            $student->schoolcode,
            $student->erpid,
            $student->rollno,
            $student->fname,
            $student->mname,
            $student->lname,
            $student->class,
            $student->div,
            $student->dob,
            $student->bloodgroup,
            $student->pname,
            $student->pcontact,
            $student->address1,
            $student->address2,
            $student->landmark,
            $student->pincode,
        ];
    }
}