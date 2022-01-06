<?php

namespace App\Controllers;

use App\Models\komikModel;

class Komik extends BaseController
{
    protected $komikModel;

    public function __construct()
    {
        $this->komikModel = new komikModel();
    }

    public function index()
    {
        $data = [
            'tittle' => 'List Komik',
            'komik'  => $this->komikModel->getKomik(),
        ];
        return view('komik/index', $data);
    }

    public function detail($slug)
    {
        $data = [
            'tittle' => 'Detail Komik',
            'komik' => $this->komikModel->getKomik($slug),
        ];

        return view('komik/detail', $data);
    }

    public function create()
    {
        $data = [
            'tittle' => 'Tambah Data Komik',
            'validation' => \Config\Services::validation(),
        ];

        return view('komik/create', $data);
    }

    public function save()
    {
        //membuat validasi input
        if (!$this->validate([      //apabila tidak tervalidasi
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => '{field} komik harus diisi',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ]
        ])) {                   //ini tidak tervalidasi sehingga kembali ke view create
            $validation = \Config\Services::validation();
            return redirect()->to('/komik/create')->withInput()->with('validation', $validation);
        }

        //membuat slug dari tittle dg parameter '-' sebagai separator
        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul'),
        ]);
        return redirect()->to('/komik');
    }

    public function delete($id)
    {
        $this->komikModel->delete($id);
        return redirect()->to('/komik');
    }
    public function edit($slug)
    {
        $data = [
            'tittle' => 'Edit Data',
            'validation' => \Config\Services::validation(),
            'komik' => $this->komikModel->getKomik($slug),
        ];
        return view('/komik/edit', $data);
    }
    public function update($id)
    {
        //cek dulu judlnya
        $komikLama = $this->komikModel->getKomik($this->request->getVar('slug'));
        if ($komikLama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[komik.judul]';
        }

        if (!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} komik harus diisi',
                    'is_unique' => '{field} sudah terdaftar',
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('/komik/edit/' . $this->request->getVar('slug'))->withInput()->with('validation', $validation);
        }
        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug'  => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul'),
        ]);
        return redirect()->to('/komik');
    }
}