<?php

return [
    'plugin' => [
        'name' => 'Aa',
        'description' => '',
        'menu_employees' => 'Menu employees',
        'centers' => 'Centers',
        'employees' => 'Employees',
        'salares' => 'Salares',
        'payrolls' => 'Payrolls',
        'select' => 'Select',
         'years' => 'Years',
         'months' => 'Months',
                   'message_unique' => 'The name must be unique.',
         'error_status_save' => 'The name must be unique.',
         'export_excel' => 'Export Excel',
         'create_and_new'=>'Create and new',
         'reports'=>'Reports',
         'analysises'=>'Analysises',

         
         'import_excel' => 'Import Excel',
         'general'=>'General',
         'log_changes_aa'=>'Log changes',
         'year_month_status'=>'please change status for year and month to true',
        'message_save_pyroll' => 'can not save becasue this record is already paid',

    ],
    'model' => [
                'year' => [
            'id' => 'Id',
            'name' => 'Name',
            'status'    => 'Status',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ],
        'month' => [
            'id' => 'Id',
            'year' => 'Year',
            'name' => 'Name',
            'status'    => 'Status',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
            'January' => 'January',
            'February' => 'February',
            'March' => 'March',
            'April' => 'April',
            'May' => 'May',
            'June' => 'June',
            'July' => 'July',
            'August' => 'August',
            'September' => 'September',
            'October' => 'October',
            'November' => 'November',
            'December' => 'December',
        ],
        'salare' => [
            'id' => 'Id',
            'currency' => 'Currency',
            'dollar' => 'Dollar',
            'syrian' => 'Syrian',
            'price' => 'Price',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ],
        'employee' => [
            'id' => 'Id',
            'comprehensive_issue' => 'Comprehensive issue',
            'file_number' => 'File number',
            'full_name' => 'Full name',
            'name' => 'Name',
            'father_name' => 'Father name',
            'last_name' => 'Last name',
            'mother_name' => 'Mother name',
            'date_of_birth' => 'Date of birth',
            'place_of_birth' => 'Place of birth',
            'national_id' => 'National id',
            'rank' => 'Rank',
            'entry_number' => 'Entry number',
            'level' => 'Level',
            'center' => 'Center',
            'kurdish'=> 'Kurdish',
            'arabic'=> 'Arabic',
            'christian'=> 'Christian',
            'date_of_enrollment' => 'Date of enrollment',
            'salare' => 'Salare',
            'gender' => 'Gender',
            'female' => 'Female',
            'male' => 'Male',
            'other' => 'Other',
            'nationality' => 'Nationality',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ],
        'center' => [
            'id' => 'Id',
            'name' => 'Name',
            'parent' => 'Parent',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ],
        'payroll' => [
            'id' => 'Id',
            'employee' => 'Employee',
            'salare' => 'Salare',
            'year' => 'Year',
            'month' => 'Month',
            'price' => 'Price',
            'status' => 'Status',
            'paid' => 'Paid',
            'unpaid' => 'Unpaid',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ],

    ],

    'controller' => [
                        'years' => [
            'years' => 'Years',
        ],
        'months' => [
            'months' => 'Months',
        ],
        'salares' => [
            'salares' => 'Salares',
        ],
        'employees' => [
            'employees' => 'Employees',
        ],
        'centers' => [
            'centers' => 'Centers',
        ],
        'payrolls' => [
            'payrolls' => 'Payrolls',
        ],
        'reports' => [
            'reports' => 'reports',
        ],
        'analysises' => [
            'analysises' => 'Analysises',
        ],

        
    ]
];
