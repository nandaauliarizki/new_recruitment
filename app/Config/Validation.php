<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public array $register = [
        'nama' => [
            'label'  => 'Nama Lengkap',
            'rules'  => 'required|min_length[3]|max_length[100]|regex_match[/^[A-Za-zÀ-ÿ\s.\'-]+$/u]',
            'errors' => [
                'regex_match' => 'Nama hanya boleh berisi huruf dan spasi.',
            ],
        ],
        'email' => [
            'label' => 'Email',
            'rules' => 'required|valid_email|max_length[150]|is_unique[users.email]',
        ],
        'no_telepon' => [
            'label'  => 'Nomor Telepon',
            'rules'  => 'required|regex_match[/^[0-9]{10,15}$/]',
            'errors' => [
                'regex_match' => 'Nomor telepon hanya boleh angka (10–15 digit).',
            ],
        ],
        'tanggal_lahir' => [
            'label' => 'Tanggal Lahir',
            'rules' => 'required|valid_date[Y-m-d]',
        ],
        'password' => [
            'label'  => 'Password',
            'rules'  => 'required|min_length[6]|max_length[72]',
        ],
        'password_confirm' => [
            'label'  => 'Konfirmasi Password',
            'rules'  => 'required|matches[password]',
        ],
    ];

    public array $lamaran_profil = [
        'pendidikan' => [
            'label'  => 'Pendidikan Terakhir',
            'rules'  => 'required|min_length[2]|max_length[100]',
            'errors' => [
                'required' => 'Pendidikan terakhir wajib diisi.',
            ],
        ],
        // 'pengalaman' => [
        //     'label'  => 'Pengalaman Kerja',
        //     'rules'  => 'required|is_natural|less_than_equal_to[50]',
        //     'errors' => [
        //         'required'         => 'Lama pengalaman kerja wajib diisi.',
        //         'is_natural'       => 'Pengalaman harus berupa angka tahun (0 jika belum ada).',
        //         'less_than_equal_to' => 'Pengalaman maksimal 50 tahun.',
        //     ],
        // ],
    ];

    public array $lamaran_dokumen = [
        'cv' => [
            'label' => 'CV',
            'rules' => 'uploaded[cv]|max_size[cv,5120]|ext_in[cv,pdf]|mime_in[cv,application/pdf]',
            'errors' => [
                'uploaded'  => 'CV wajib diunggah.',
                'max_size'  => 'Ukuran CV maksimal 5 MB.',
                'ext_in'    => 'CV harus berformat PDF.',
                'mime_in'   => 'CV harus berformat PDF.',
            ],
        ],
        'surat_lamaran' => [
            'label' => 'Surat Lamaran Kerja',
            'rules' => 'uploaded[surat_lamaran]|max_size[surat_lamaran,5120]|ext_in[surat_lamaran,pdf]|mime_in[surat_lamaran,application/pdf]',
            'errors' => [
                'uploaded' => 'Surat lamaran wajib diunggah.',
                'max_size' => 'Ukuran surat lamaran maksimal 5 MB.',
                'ext_in'   => 'Surat lamaran harus berformat PDF.',
                'mime_in'  => 'Surat lamaran harus berformat PDF.',
            ],
        ],
        'ijazah' => [
            'label' => 'Ijazah',
            'rules' => 'uploaded[ijazah]|max_size[ijazah,5120]|ext_in[ijazah,pdf]|mime_in[ijazah,application/pdf]',
            'errors' => [
                'uploaded' => 'Ijazah wajib diunggah.',
                'max_size' => 'Ukuran ijazah maksimal 5 MB.',
                'ext_in'   => 'Ijazah harus berformat PDF.',
                'mime_in'  => 'Ijazah harus berformat PDF.',
            ],
        ],
        'dokumen_pendukung' => [
            'label' => 'Dokumen Pendukung',
            'rules' => 'permit_empty|max_size[dokumen_pendukung,5120]|ext_in[dokumen_pendukung,pdf]|mime_in[dokumen_pendukung,application/pdf]',
            'errors' => [
                'max_size' => 'Ukuran dokumen pendukung maksimal 5 MB.',
                'ext_in'   => 'Dokumen pendukung harus berformat PDF.',
                'mime_in'  => 'Dokumen pendukung harus berformat PDF.',
            ],
        ],
    ];

    public array $dokumen_seleksi = [

        'jenis_dokumen' => [
            'label' => 'Jenis Dokumen',
            'rules' => 'permit_empty|in_list[surat_panggilan_interview,hasil_tes,surat_penerimaan,surat_penolakan,lainnya]',
        ],

        'dokumen' => [
            'label' => 'Dokumen Seleksi',
            'rules' => 'permit_empty|max_size[dokumen,5120]|ext_in[dokumen,pdf]|mime_in[dokumen,application/pdf]',
            'errors' => [
                'max_size' => 'Ukuran file maksimal 5 MB.',
                'ext_in'   => 'File harus berformat PDF.',
                'mime_in'  => 'File harus berformat PDF.',
            ],
        ],

    ];
}
