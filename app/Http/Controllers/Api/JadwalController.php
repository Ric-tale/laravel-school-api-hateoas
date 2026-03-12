<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JadwalController extends ApiController
{
    public function index()
    {
        $data = Jadwal::all();
        
        $template = $this->createTemplate([
            'kelas_id' => ['prompt' => 'ID Kelas', 'required' => true, 'type' => 'number'],
            'mapel_id' => ['prompt' => 'ID Mata Pelajaran', 'required' => true, 'type' => 'number'],
            'guru_id' => ['prompt' => 'ID Guru', 'required' => true, 'type' => 'number'],
            'hari' => ['prompt' => 'Hari', 'required' => true, 'type' => 'string'],
            'jam_pelajaran' => ['prompt' => 'Jam Pelajaran', 'required' => true, 'type' => 'string'],
        ]);

        $queries = [
            $this->createQuery('search-jadwal', '/api/jadwal', [
                'kelas_id' => ['prompt' => 'ID Kelas'],
                'mapel_id' => ['prompt' => 'ID Mata Pelajaran'],
                'guru_id' => ['prompt' => 'ID Guru'],
                'hari' => ['prompt' => 'Hari']
            ], 'Cari Jadwal')
        ];

        // HATEOAS Links
        $links = [
            ['href' => url('/api/jadwal'), 'rel' => 'self', 'prompt' => 'All Jadwal'],
            ['href' => url('/api/kelas'), 'rel' => 'related', 'prompt' => 'All Kelas'],
            ['href' => url('/api/mapel'), 'rel' => 'related', 'prompt' => 'All Mapel'],
            ['href' => url('/api/guru'), 'rel' => 'related', 'prompt' => 'All Guru']
        ];

        return $this->collectionResponse($data, '/api/jadwal', [
            'template' => $template,
            'queries' => $queries,
            'links' => $links
        ]);
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapel,id',
            'guru_id'  => 'required|exists:guru,id',
            'hari' => 'required',
            'jam_pelajaran' => 'required'
        ]);
        if ($v->fails()) {
            return $this->collectionError($v->errors()->first(), 422, '/api/jadwal');
        }
        $jadwal = Jadwal::create($request->all());
        return $this->itemResponse($jadwal, "/api/jadwal/{$jadwal->id}", ['status_code' => 201]);
    }

    public function show($id)
    {
        $j = Jadwal::find($id);
        if (!$j) {
            return $this->collectionError('Data tidak ditemukan', 404, "/api/jadwal/$id");
        }

        // HATEOAS Links dengan semua related resources
        $links = $this->createCrudLinks('/api/jadwal', $id);
        $links[] = $this->addRelatedLink("/api/kelas/{$j->kelas_id}", 'Kelas');
        $links[] = $this->addRelatedLink("/api/mapel/{$j->mapel_id}", 'Mata Pelajaran');
        $links[] = $this->addRelatedLink("/api/guru/{$j->guru_id}", 'Guru Pengajar');

        return $this->itemResponse($j, "/api/jadwal/$id", ['links' => $links]);
    }

    public function update(Request $request, $id)
    {
        $j = Jadwal::find($id);
        if (!$j) {
            return $this->collectionError('Data tidak ditemukan', 404, "/api/jadwal/$id");
        }
        $j->update($request->all());
        return $this->itemResponse($j, "/api/jadwal/$id");
    }

    public function destroy($id)
    {
        $j = Jadwal::find($id);
        if (!$j) {
            return $this->collectionError('Data tidak ditemukan', 404, "/api/jadwal/$id");
        }
        $j->delete();
        return $this->collectionResponse([], '/api/jadwal', ['status_code' => 200]);
    }
}
