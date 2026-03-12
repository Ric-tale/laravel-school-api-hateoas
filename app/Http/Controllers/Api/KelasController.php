<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelasController extends ApiController
{
    public function index()
    {
        $data = Kelas::all();
        
        $template = $this->createTemplate([
            'kode_kelas' => ['prompt' => 'Kode Kelas', 'required' => true, 'type' => 'string'],
            'nama_kelas' => ['prompt' => 'Nama Kelas', 'required' => true, 'type' => 'string'],
        ]);

        $queries = [
            $this->createQuery('search-kelas', '/api/kelas', [
                'kode_kelas' => ['prompt' => 'Kode Kelas'],
                'nama_kelas' => ['prompt' => 'Nama Kelas']
            ], 'Cari Kelas')
        ];

        // HATEOAS Links
        $links = [
            ['href' => url('/api/kelas'), 'rel' => 'self', 'prompt' => 'All Kelas'],
            ['href' => url('/api/siswa'), 'rel' => 'related', 'prompt' => 'All Siswa'],
            ['href' => url('/api/jadwal'), 'rel' => 'related', 'prompt' => 'All Jadwal']
        ];

        return $this->collectionResponse($data, '/api/kelas', [
            'template' => $template,
            'queries' => $queries,
            'links' => $links
        ]);
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'kode_kelas' => 'required|unique:kelas,kode_kelas',
            'nama_kelas' => 'required|string',
        ]);
        if ($v->fails()) {
            return $this->collectionError($v->errors()->first(), 422, '/api/kelas');
        }
        $kelas = Kelas::create($request->all());
        return $this->itemResponse($kelas, "/api/kelas/{$kelas->id}", ['status_code' => 201]);
    }

    public function show($id)
    {
        $k = Kelas::find($id);
        if (!$k) {
            return $this->collectionError('Data tidak ditemukan', 404, "/api/kelas/$id");
        }

        // HATEOAS Links
        $links = $this->createCrudLinks('/api/kelas', $id);
        $links[] = $this->addRelatedLink("/api/siswa?kelas_id=$id", 'Siswa di Kelas Ini');
        $links[] = $this->addRelatedLink("/api/jadwal?kelas_id=$id", 'Jadwal Kelas');

        return $this->itemResponse($k, "/api/kelas/$id", ['links' => $links]);
    }

    public function update(Request $request, $id)
    {
        $k = Kelas::find($id);
        if (!$k) {
            return $this->collectionError('Data tidak ditemukan', 404, "/api/kelas/$id");
        }
        $k->update($request->all());
        return $this->itemResponse($k, "/api/kelas/$id");
    }

    public function destroy($id)
    {
        $k = Kelas::find($id);
        if (!$k) {
            return $this->collectionError('Data tidak ditemukan', 404, "/api/kelas/$id");
        }
        $k->delete();
        return $this->collectionResponse([], '/api/kelas', ['status_code' => 200]);
    }
}
