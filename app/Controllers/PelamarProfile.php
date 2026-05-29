<?php

namespace App\Controllers;

use App\Models\UserModel;

class PelamarProfile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // HALAMAN PROFILE
    public function index()
    {
        $id = session()->get('id_user');

        $user = $this->userModel->find($id);

        return view('pelamar/profile', [
            'title' => 'Profile Pelamar',
            'user'  => $user
        ]);
    }

    // UPDATE PROFILE
    public function update()
    {
        $id = session()->get('id_user');

        $user = $this->userModel->find($id);

        $foto = $this->request->getFile('foto');

        $namaFoto = $user['foto'];

        // UPLOAD FOTO
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {

            $namaFoto = $foto->getRandomName();

            $foto->move('uploads/profile', $namaFoto);

            // HAPUS FOTO LAMA
            if (
                !empty($user['foto']) &&
                file_exists('uploads/profile/' . $user['foto'])
            ) {
                unlink('uploads/profile/' . $user['foto']);
            }
        }

        // UPDATE DATABASE
        $this->userModel->update($id, [
            'nama'   => $this->request->getPost('nama'),
            'email'  => $this->request->getPost('email'),
            'no_hp'  => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
            'foto'   => $namaFoto
        ]);

        // UPDATE SESSION
        session()->set([
            'nama'  => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'foto'  => $namaFoto
        ]);

        return redirect()->back()->with(
            'success',
            'Profile berhasil diperbarui'
        );
    }

    // UPDATE PASSWORD
    public function changePassword()
    {
        $id = session()->get('id_user');

        $user = $this->userModel->find($id);

        $oldPassword = $this->request->getPost('old_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // VALIDASI PASSWORD LAMA
        if (!password_verify($oldPassword, $user['password'])) {

            return redirect()->back()->with(
                'error',
                'Password lama salah'
            );
        }

        // VALIDASI KONFIRMASI PASSWORD
        if ($newPassword != $confirmPassword) {

            return redirect()->back()->with(
                'error',
                'Konfirmasi password tidak cocok'
            );
        }

        // UPDATE PASSWORD
        $this->userModel->update($id, [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);

        return redirect()->back()->with(
            'success',
            'Password berhasil diperbarui'
        );
    }
}