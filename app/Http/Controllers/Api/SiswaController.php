<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiswaController extends ApiController
{
    public function index()
    {
        $data = Siswa::all();
        
        $template = $this->createTemplate([
            'nis' => ['prompt' => 'Nomor Induk Siswa', 'required' => true, 'type' => 'string'],
            'nama' => ['prompt' => 'Nama Lengkap', 'required' => true, 'type' => 'string'],
            'gender' => ['prompt' => 'Jenis Kelamin', 'required' => true, 'type' => 'string'],
            'tempat_lahir' => ['prompt' => 'Tempat Lahir', 'required' => true, 'type' => 'string'],
            'tgl_lahir' => ['prompt' => 'Tanggal Lahir', 'required' => true, 'type' => 'date'],
            'nama_ortu' => ['prompt' => 'Nama Orang Tua', 'required' => true, 'type' => 'string'],
            'phone_number' => ['prompt' => 'Nomor Telepon', 'required' => true, 'type' => 'string'],
            'email' => ['prompt' => 'Email', 'required' => true, 'type' => 'email'],
            'alamat' => ['prompt' => 'Alamat', 'required' => true, 'type' => 'text'],
            'kelas_id' => ['prompt' => 'ID Kelas', 'required' => true, 'type' => 'number'],
        ]);

        $queries = [
            $this->createQuery('search-siswa', '/api/siswa', [
                'nama' => ['prompt' => 'Nama Siswa'],
                'nis' => ['prompt' => 'NIS'],
                'kelas_id' => ['prompt' => 'ID Kelas']
            ], 'Cari Siswa')
        ];

        // HATEOAS Links
        $links = [
            ['href' => url('/api/siswa'), 'rel' => 'self', 'prompt' => 'All Siswa'],
            ['href' => url('/api/kelas'), 'rel' => 'related', 'prompt' => 'All Kelas']
        ];

        return $this->collectionResponse($data, '/api/siswa', [
            'template' => $template,
            'queries' => $queries,
            'links' => $links
        ]);
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'nis' => 'required|unique:siswa,nis',
            'gender' => 'required',
            'nama' => 'required|string',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required|date',
            'nama_ortu' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email|unique:siswa,email',
            'alamat' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
        ]);
        if ($v->fails()) {
            return $this->collectionError($v->errors()->first(), 422, '/api/siswa');
        }
        $siswa = Siswa::create($request->all());
        return $this->itemResponse($siswa, "/api/siswa/{$siswa->id}", ['status_code' => 201]);
    }

    public function show($id)
    {
        $s = Siswa::find($id);
        if (!$s) {
            return $this->collectionError('Data tidak ditemukan', 404, "/api/siswa/$id");
        }

        // HATEOAS Links
        $links = $this->createCrudLinks('/api/siswa', $id);
        
        if ($s->kelas_id) {
            $links[] = $this->addRelatedLink("/api/kelas/{$s->kelas_id}", 'Kelas');
        }

        return $this->itemResponse($s, "/api/siswa/$id", ['links' => $links]);
    }

    public function update(Request $request, $id)
    {
        $s = Siswa::find($id);
        if (!$s) {
            return $this->collectionError('Data tidak ditemukan', 404, "/api/siswa/$id");
        }
        $s->update($request->all());
        return $this->itemResponse($s, "/api/siswa/$id");
    }

    public function destroy($id)
    {
        $s = Siswa::find($id);
        if (!$s) {
            return $this->collectionError('Data tidak ditemukan', 404, "/api/siswa/$id");
        }
        $s->delete();
        return $this->collectionResponse([], '/api/siswa', ['status_code' => 200]);
    }
}
