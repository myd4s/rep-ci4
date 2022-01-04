<?php

namespace App\Models;

use CodeIgniter\Model;

class komikModel extends Model
{
    //define semua properti
    protected $table = 'komik';
    protected $allowedFields = ['judul', 'slug', 'penulis', 'penerbit', 'sampul'];
    protected $UseTimeStamps = true;

    public function getKomik($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        } else {
            return $this->where(['slug' => $slug])->first();
        }
    }
}