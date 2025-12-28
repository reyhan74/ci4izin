<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function dashboard()
    {
        return view('admin/dashboard',[
            'title' => 'Dashboard Admin',
            'totalSiswa' => model('SiswaModel')->countAll(),
            'izinHariIni' => model('IzinModel')
                ->where('DATE(waktu)',date('Y-m-d'))
                ->countAllResults()
        ]);
    }
}