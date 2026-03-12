<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends ApiController
{
    public function index()
    {
        $data = User::all();
        
        // Template untuk menambah user baru
        $template = $this->createTemplate([
            'type' => ['prompt' => 'Tipe User (admin/guru)', 'required' => true, 'type' => 'string'],
            'username' => ['prompt' => 'Username', 'required' => true, 'type' => 'string'],
            'password' => ['prompt' => 'Password', 'required' => true, 'type' => 'password'],
        ]);

        // Query untuk pencarian
        $queries = [
            $this->createQuery('search-user', '/api/user', [
                'username' => ['prompt' => 'Username'],
                'type' => ['prompt' => 'Tipe User']
            ], 'Cari User')
        ];

        // Links untuk navigasi
        $links = [
            ['href' => url('/api/user'), 'rel' => 'self', 'prompt' => 'All Users'],
            ['href' => url('/api/guru'), 'rel' => 'related', 'prompt' => 'All Guru']
        ];

        return $this->collectionResponse($data, '/api/user', [
            'template' => $template,
            'queries' => $queries,
            'links' => $links
        ]);
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'type' => 'required|in:admin,guru',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:6',
        ]);

        if ($v->fails()) {
            return $this->collectionError($v->errors()->first(), 422, '/api/user');
        }

        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);
        
        return $this->itemResponse($user, "/api/user/{$user->id}", [
            'status_code' => 201
        ]);
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->collectionError('Data tidak ditemukan', 404, "/api/user/$id");
        }

        // Links dengan HATEOAS lengkap
        $links = $this->createCrudLinks('/api/user', $id);

        if ($user->type === 'guru' && $user->guru) {
            $links[] = $this->addRelatedLink("/api/guru/{$user->guru->id}", 'Data Guru');
        }

        return $this->itemResponse($user, "/api/user/$id", [
            'links' => $links
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->collectionError('Data tidak ditemukan', 404, "/api/user/$id");
        }

        $data = $request->all();
        
        // Hash password jika diupdate
        if ($request->has('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        
        return $this->itemResponse($user, "/api/user/$id", [
            'status_code' => 200
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->collectionError('Data tidak ditemukan', 404, "/api/user/$id");
        }

        $user->delete();
        
        return $this->collectionResponse([], '/api/user', [
            'status_code' => 200
        ]);
    }
}
