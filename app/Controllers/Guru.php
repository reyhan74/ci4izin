<?php

namespace App\Controllers;

class Guru extends BaseController
{
    public function dashboard()
    {
        return view('guru/dashboard',[
            'title' => 'Dashboard Guru',
            'totalSiswa' => model('SiswaModel')->countAll(),
            'izinHariIni' => model('IzinModel')
                ->where('DATE(waktu)',date('Y-m-d'))
                ->countAllResults()
        ]);
    }
}