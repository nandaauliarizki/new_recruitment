<?php

namespace App\Controllers;

use App\Models\PelamarModel;
use App\Models\UserModel;
use Config\Services;

class Auth extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'database']);
    }

    public function login()
    {
        return view('auth/login');
    }

    public function prosesLogin()
    {
        $email    = $this->request->getPost('email');
        $password = md5((string) $this->request->getPost('password'));

        $user = $this->userModel
            ->where('email', $email)
            ->where('password', $password)
            ->first();

        if ($user) {
            session()->set([
                'id_user'   => $user['id_user'],
                'nama'      => $user['nama'],
                'role'      => $user['role'],
                'foto'    => $user['foto'],
                'logged_in' => true,
            ]);

            return $user['role'] === 'admin'
                ? redirect()->to('/dashboard')
                : redirect()->to('/pelamar/dashboard');
        }

        return redirect()->back()->with('error', 'Email atau password salah.');
    }

    public function register()
    {
        $fieldErrors = session()->getFlashdata('errors');

        return view('auth/register', [
            'fieldErrors'       => is_array($fieldErrors) ? $fieldErrors : [],
            'has_no_telepon'    => table_has_column('pelamar', 'no_telepon'),
            'has_tanggal_lahir' => table_has_column('pelamar', 'tanggal_lahir'),
        ]);
    }

    public function prosesRegister()
    {
        $validation = Services::validation();
        $rules      = config('Validation')->register;

        if (! table_has_column('pelamar', 'no_telepon')) {
            unset($rules['no_telepon']);
        }
        if (! table_has_column('pelamar', 'tanggal_lahir')) {
            unset($rules['tanggal_lahir']);
        }

        $validation->setRules($rules);

        if (! $validation->withRequest($this->request)->run()) {
            return redirect()->to('/register')
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $nama     = trim((string) $this->request->getPost('nama'));
        $email    = trim((string) $this->request->getPost('email'));
        $password = md5((string) $this->request->getPost('password'));

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $this->userModel->insert([
                'nama'     => $nama,
                'email'    => $email,
                'password' => $password,
                'role'     => 'pelamar',
            ]);

            if ($this->userModel->errors() !== []) {
                throw new \RuntimeException(implode(' ', $this->userModel->errors()));
            }

            $idUser = (int) $this->userModel->getInsertID();

            if ($idUser <= 0) {
                throw new \RuntimeException('Gagal membuat akun pengguna.');
            }

            $pelamarPayload = [
                'nama_pelamar'  => $nama,
                'email'         => $email,
                'no_telepon'    => $this->request->getPost('no_telepon'),
                'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
                'pendidikan'    => '',
                'pengalaman'    => 0,
                'tanggal_lamar' => date('Y-m-d'),
                'status'        => 'baru',
                'id_user'       => $idUser,
            ];

            $pelamarModel = new PelamarModel();
            $pelamarModel->insert(filter_table_columns('pelamar', $pelamarPayload));

            if ($pelamarModel->errors() !== []) {
                throw new \RuntimeException(implode(' ', $pelamarModel->errors()));
            }

            if ((int) $pelamarModel->getInsertID() <= 0) {
                throw new \RuntimeException('Gagal menyimpan data pelamar.');
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \RuntimeException('Transaksi database gagal.');
            }

            return redirect()->to('/login')
                ->with('success', 'Registrasi berhasil. Silakan login.');

        } catch (\Throwable $e) {
            $db->transRollback();

            log_message('error', 'Register gagal: {message}', ['message' => $e->getMessage()]);

            $message = 'Registrasi gagal. ';

            if (str_contains($e->getMessage(), 'Duplicate') || str_contains($e->getMessage(), '1062')) {
                $message .= 'Email sudah terdaftar.';
            } else {
                $message .= $e->getMessage();
            }

            return redirect()->to('/register')
                ->withInput()
                ->with('error', $message);
        }
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login');
    }
}
