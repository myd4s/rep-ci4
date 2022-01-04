<?php

namespace App\Controllers;

class Pages extends BaseController
{

    public function index()
    {
        $data = [
            'tittle' => 'Home'
        ];
        return view('\pages\home', $data);
    }

    public function about()
    {
        $data = [
            'tittle' => 'About'
        ];
        return view('\pages\about', $data);
    }
    public function kontak()
    {
        $data = [
            'tittle' => 'Kontak'
        ];
        return view('\pages\kontak', $data);
    }
}