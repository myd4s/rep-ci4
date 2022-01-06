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
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'file terlalu besar',
                    'is_image' => 'file harus berupa gambar',
                    'mime_in' => 'file harus dalam format jpg,jpeg,png'
                ]
            ]
        ])) {                   //ini tidak tervalidasi sehingga kembali ke view create
            $validation = \Config\Services::validation();
            // return redirect()->to('/komik/create')->withInput()->with('validation', $validation);
            return redirect()->to('/komik/create')->withInput();
        }
        //ambil gambar
        $fileSampul = $this->request->getFile('sampul');
        //cek ada tidaknya gambar yang diupload
        if ($fileSampul->getError() == 4) {
            $namaSampul = 'default.png';
        } else {
            //generate random nama sampul
            $namaSampul = $fileSampul->getRandomName();
            //pindahkan file ke folder img
            $fileSampul->move('img', $namaSampul);
        }
        //ambil nama file untuk save di database
        // $namaSampul = $fileSampul->getName();
        //membuat slug dari tittle dg parameter '-' sebagai separator
        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul,
        ]);
        return redirect()->to('/komik');
    }

    public function delete($id)
    {
        //cari gambar berdasarkan id
        $komik = $this->komikModel->find($id);
        //cek jika file gambar adalah default
        if ($komik['sampul'] != 'default.png') {

            //hapus gambar
            unlink('img/' . $komik['sampul']);
        }
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
                ],
                'sampul' => [
                    'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        'max_size' => 'file terlalu besar',
                        'is_image' => 'file harus berupa gambar',
                        'mime_in' => 'file harus dalam format jpg,jpeg,png'
                    ]
                ]
            ]
        ])) {

            return redirect()->to('/komik/edit/' . $this->request->getVar('slug'))->withInput();
        }
        $fileSampul = $this->request->getFile('sampul');
        //cek gambar, apakah tetap gambar lama
        if ($fileSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('sampulLama');
        } else {
            //generate nama random
            $namaSampul = $fileSampul->getRandomName();
            //pindahkan gambar baru
            $fileSampul->move('img', $namaSampul);
            //hapus file yang lama
            unlink('img/' . $this->request->getVar('sampulLama'));
        }
        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug'  => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul,
        ]);
        return redirect()->to('/komik');
    }
}