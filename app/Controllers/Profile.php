<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $user = $this->userModel
            ->find(session()->get('id_user'));

        return view('profile/index', [
            'user' => $user
        ]);
    }

    public function update()
    {
        $id = session()->get('id_user');

        $data = [
            'nama'  => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
        ];

        $foto = $this->request->getFile('foto');

        if ($foto && $foto->isValid()) {

            $namaFoto = $foto->getRandomName();

            $foto->move('uploads/profile', $namaFoto);

            $data['foto'] = $namaFoto;
        }

        $this->userModel->update($id, $data);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }

    public function changePassword()
    {
        $id = session()->get('id_user');

        $user = $this->userModel->find($id);

        $oldPassword = $this->request->getPost('old_password');

        $newPassword = $this->request->getPost('new_password');

        if (!password_verify($oldPassword, $user['password'])) {

            return redirect()->back()->with('error', 'Password lama salah');
        }

        $this->userModel->update($id, [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah');
    }
}