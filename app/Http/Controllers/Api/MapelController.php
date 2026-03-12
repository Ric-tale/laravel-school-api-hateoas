<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MapelController extends ApiController
{
    public function index()
    {
        $data = Mapel::all();
        
        $template = $this->createTemplate([
            'kode_mapel' => ['prompt' => 'Kode Mata Pelajaran', 'required' => true, 'type' => 'string'],
            'nama_mapel' => ['prompt' => 'Nama Mata Pelajaran', 'required' => true, 'type' => 'string'],
        ]);

        $queries = [
            $this->createQuery('search-mapel', '/api/mapel', [
                'kode_mapel' => ['prompt' => 'Kode Mapel'],
                'nama_mapel' => ['prompt' => 'Nama Mapel']
            ], 'Cari Mata Pelajaran')
        ];

        // HATEOAS Links
        $links = [
            ['href' => url('/api/mapel'), 'rel' => 'self', 'prompt' => 'All Mata Pelajaran'],
            ['href' => url('/api/jadwal'), 'rel' => 'related', 'prompt' => 'All Jadwal']
        ];

        return $this->collectionResponse($data, '/api/mapel', [
            'template' => $template,
            'queries' => $queries,
            'links' => $links
        ]);
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'kode_mapel' => 'required|unique:mapel,kode_mapel',
            'nama_mapel' => 'required|string',
        ]);
        if ($v->fails()) {
            return $this->collectionError($v->errors()->first(), 422, '/api/mapel');
        }
        $mapel = Mapel::create($request->all());
        return $this->itemResponse($mapel, "/api/mapel/{$mapel->id}", ['status_code' => 201]);
    }

    public function show($id)
    {
        $m = Mapel::find($id);
        if (!$m) {
            return $this->collectionError('Data tidak ditemukan', 404, "/api/mapel/$id");
        }

        // HATEOAS Links
        $links = $this->createCrudLinks('/api/mapel', $id);
        $links[] = $this->addRelatedLink("/api/jadwal?mapel_id=$id", 'Jadwal Mata Pelajaran');

        return $this->itemResponse($m, "/api/mapel/$id", ['links' => $links]);
    }

    public function update(Request $request, $id)
    {
        $m = Mapel::find($id);
        if (!$m) {
            return $this->collectionError('Data tidak ditemukan', 404, "/api/mapel/$id");
        }
        $m->update($request->all());
        return $this->itemResponse($m, "/api/mapel/$id");
    }

    public function destroy($id)
    {
        $m = Mapel::find($id);
        if (!$m) {
            return $this->collectionError('Data tidak ditemukan', 404, "/api/mapel/$id");
        }
        $m->delete();
        return $this->collectionResponse([], '/api/mapel', ['status_code' => 200]);
    }
}
