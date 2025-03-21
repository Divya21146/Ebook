<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pdf;

class PdfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Pdf::create([
            'title' => 'Sample PDF 1',
            'filename' => 'sample1.pdf',
            'filepath' => 'pdfs/sample1.pdf', // relative path within storage
            'price' => 5.00,
            'description' => 'A sample PDF document.'
        ]);

        Pdf::create([
            'title' => 'Sample PDF 2',
            'filename' => 'sample2.pdf',
            'filepath' => 'pdfs/sample2.pdf',
            'price' => 7.50,
            'description' => 'Another sample PDF document.'
        ]);
    }
}
