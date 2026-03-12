<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuruController extends ApiController
{
    public function index()
    {
        $data = Guru::all();
        
        // Template untuk menambah guru baru
        $template = $this->createTemplate([
            'user_id' => ['prompt' => 'User ID', 'required' => true, 'type' => 'number'],
            'nip' => ['prompt' => 'NIP', 'required' => true, 'type' => 'string'],
            'nama' => ['prompt' => 'Nama Lengkap', 'required' => true, 'type' => 'string'],
            'tempat_lahir' => ['prompt' => 'Tempat Lahir', 'type' => 'string'],
            'tgl_lahir' => ['prompt' => 'Tanggal Lahir', 'type' => 'date'],
            'gender' => ['prompt' => 'Jenis Kelamin', 'type' => 'string'],
            'phone_number' => ['prompt' => 'Nomor Telepon', 'type' => 'string'],
            'email' => ['prompt' => 'Email', 'required' => true, 'type' => 'email'],
            'alamat' => ['prompt' => 'Alamat', 'type' => 'text'],
            'pendidikan' => ['prompt' => 'Pendidikan Terakhir', 'type' => 'string'],
        ]);

        // Query untuk pencarian
        $queries = [
            $this->createQuery('search-guru', '/api/guru', [
                'nama' => ['prompt' => 'Nama Guru'],
                'email' => ['prompt' => 'Email']
            ], 'Cari Guru')
        ];

        // Links untuk navigasi
        $links = [
            ['href' => url('/api/guru'), 'rel' => 'self', 'prompt' => 'All Guru'],
            ['href' => url('/api/user'), 'rel' => 'related', 'prompt' => 'All Users'],
            ['href' => url('/api/jadwal'), 'rel' => 'related', 'prompt' => 'All Jadwal']
        ];

        return $this->collectionResponse($data, '/api/guru', [
            'template' => $template,
            'queries' => $queries,
            'links' => $links
        ]);
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'nama' => 'required|string',
            'email' => 'required|email|unique:guru,email',
        ]);

        if ($v->fails()) {
            return $this->collectionError($v->errors()->first(), 422, '/api/guru');
        }

        $guru = Guru::create($request->all());
        
        return $this->itemResponse($guru, "/api/guru/{$guru->id}", [
            'status_code' => 201
        ]);
    }

    public function show($id)
    {
        $guru = Guru::find($id);
        if (!$guru) {
            return $this->collectionError('Data tidak ditemukan', 404, "/api/guru/$id");
        }

        // Links ke resource terkait dengan HATEOAS lengkap
        $links = $this->createCrudLinks('/api/guru', $id);
        
        // Add related resources
        if ($guru->user_id) {
            $links[] = $this->addRelatedLink("/api/user/{$guru->user_id}", 'User Account');
        }
        $links[] = $this->addRelatedLink("/api/jadwal?guru_id=$id", 'Jadwal Mengajar');

        return $this->itemResponse($guru, "/api/guru/$id", [
            'links' => $links
        ]);
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::find($id);
        if (!$guru) {
            return $this->collectionError('Data tidak ditemukan', 404, "/api/guru/$id");
        }

        $guru->update($request->all());
        
        return $this->itemResponse($guru, "/api/guru/$id", [
            'status_code' => 200
        ]);
    }

    public function destroy($id)
    {
        $guru = Guru::find($id);
        if (!$guru) {
            return $this->collectionError('Data tidak ditemukan', 404, "/api/guru/$id");
        }

        $guru->delete();
        
        return $this->collectionResponse([], '/api/guru', [
            'status_code' => 200
        ]);
    }
}
