<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="max-w-6xl mx-auto">

    <!-- HEADER -->

    <div class="mb-8">

        <h2 class="text-3xl font-bold text-gray-800">
            Edit Lowongan
        </h2>

        <p class="text-gray-500 mt-1">
            Update data lowongan dan kriteria SAW
        </p>

    </div>

    <!-- FORM -->

    <form
        action="<?= base_url('lowongan/update/'.$lowongan['id']) ?>"
        method="post"
        id="form-lowongan"
    >

        <?= csrf_field() ?>

        <!-- DATA LOWONGAN -->

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-8">

            <div class="flex items-center gap-3 mb-6">

                <span class="material-symbols-outlined text-yellow-500">
                    work
                </span>

                <h3 class="text-xl font-bold">
                    Data Lowongan
                </h3>

            </div>

            <div class="space-y-6">

                <div>

                    <label class="block mb-2 font-semibold">
                        Nama Pekerjaan
                    </label>

                    <input
                        type="text"
                        name="nama_pekerjaan"
                        required
                        value="<?= $lowongan['nama_pekerjaan'] ?>"
                        class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                    >

                </div>

                <div>

                    <label class="block mb-2 font-semibold">
                        Deskripsi
                    </label>

                    <textarea
                        name="deskripsi"
                        rows="5"
                        required
                        class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                    ><?= $lowongan['deskripsi'] ?></textarea>

                </div>

                <div class="grid md:grid-cols-3 gap-5">

                    <div>
                        <label class="block mb-2 font-semibold">Start Date</label>
                        <input type="date" name="start_date"
                               value="<?= $lowongan['start_date'] ?? '' ?>"
                               class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">End Date <span class="text-xs text-gray-400">(expired)</span></label>
                        <input type="date" name="end_date"
                               value="<?= $lowongan['end_date'] ?? '' ?>"
                               class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">Status</label>
                        <select name="status"
                                class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            <option value="draft"   <?= ($lowongan['status'] ?? '') === 'draft'   ? 'selected' : '' ?>>Draft</option>
                            <option value="active"  <?= ($lowongan['status'] ?? '') === 'active'  ? 'selected' : '' ?>>Active Posted</option>
                            <option value="expired" <?= ($lowongan['status'] ?? '') === 'expired' ? 'selected' : '' ?>>Expired</option>
                        </select>
                    </div>

                </div>

            </div>

        </div>

        <!-- HEADER KRITERIA -->

        <div class="flex justify-between items-center mb-5">

            <div>

                <h3 class="text-2xl font-bold text-gray-800">
                    Data Kriteria
                </h3>

                <p class="text-gray-500 text-sm mt-1">
                    Total bobot harus 100%
                </p>

            </div>

            <div
                id="total-bobot"
                class="bg-yellow-100 text-yellow-700 px-5 py-3 rounded-2xl font-bold"
            >
                Total Bobot: 0%
            </div>

        </div>

        <!-- CONTAINER -->

        <div id="kriteria-container">

            <?php foreach($lowongan['kriteria'] as $i => $k): ?>

                <div class="kriteria-item bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-6">

                    <!-- HEADER -->

                    <div class="flex justify-between items-center mb-6">

                        <h4 class="text-xl font-bold text-gray-700">
                            Kriteria #<?= $i + 1 ?>
                        </h4>

                        <button
                            type="button"
                            onclick="hapusKriteria(this)"
                            class="bg-red-100 text-red-600 px-4 py-2 rounded-xl hover:bg-red-200 transition"
                        >
                            Hapus
                        </button>

                    </div>

                    <!-- FORM KRITERIA -->

                    <div class="grid md:grid-cols-3 gap-5 mb-6">

                        <div>

                            <label class="block mb-2 font-semibold">
                                Nama Kriteria
                            </label>

                            <input
                                type="text"
                                name="nama_kriteria[]"
                                required
                                value="<?= $k['nama_kriteria'] ?>"
                                class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                            >

                        </div>

                        <div>

                            <label class="block mb-2 font-semibold">
                                Bobot (%)
                            </label>

                            <input
                                type="number"
                                name="bobot[]"
                                required
                                value="<?= $k['bobot'] ?>"
                                oninput="hitungBobot()"
                                class="bobot-input w-full border border-gray-300 rounded-2xl px-4 py-3"
                            >

                        </div>

                        <div>

                            <label class="block mb-2 font-semibold">
                                Atribut
                            </label>

                            <select
                                name="atribut[]"
                                class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                            >

                                <option
                                    value="benefit"
                                    <?= $k['atribut'] == 'benefit' ? 'selected' : '' ?>
                                >
                                    Benefit
                                </option>

                                <option
                                    value="cost"
                                    <?= $k['atribut'] == 'cost' ? 'selected' : '' ?>
                                >
                                    Cost
                                </option>

                            </select>

                        </div>

                    </div>

                    <!-- SUB KRITERIA -->

                    <div class="bg-gray-50 rounded-2xl p-6">

                        <div class="flex justify-between items-center mb-5">

                            <h5 class="font-bold text-gray-700">
                                Sub Kriteria
                            </h5>

                            <button
                                type="button"
                                onclick="tambahSub(<?= $i ?>)"
                                class="bg-yellow-400 hover:bg-yellow-500 text-black px-4 py-2 rounded-xl font-semibold transition"
                            >
                                + Tambah Sub
                            </button>

                        </div>

                        <div class="sub-container space-y-4">

                            <?php foreach($k['sub'] as $sub): ?>

                                <div class="sub-item grid md:grid-cols-12 gap-4">

                                    <div class="md:col-span-5">

                                        <input
                                            type="text"
                                            name="nama_sub[<?= $i ?>][]"
                                            required
                                            value="<?= $sub['nama_sub'] ?>"
                                            class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                                        >

                                    </div>

                                    <div class="md:col-span-5">

                                        <input
                                            type="number"
                                            name="nilai_sub[<?= $i ?>][]"
                                            required
                                            value="<?= $sub['nilai'] ?>"
                                            class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                                        >

                                    </div>

                                    <div class="md:col-span-2">

                                        <button
                                            type="button"
                                            onclick="hapusSub(this)"
                                            class="w-full bg-red-100 text-red-600 py-3 rounded-2xl hover:bg-red-200 transition"
                                        >
                                            Hapus
                                        </button>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

        <!-- BUTTON TAMBAH KRITERIA -->

        <button
            type="button"
            onclick="tambahKriteria()"
            class="w-full border-2 border-dashed border-yellow-400 text-yellow-600 py-5 rounded-3xl font-bold hover:bg-yellow-50 transition mb-8"
        >
            + Tambah Kriteria
        </button>

        <!-- ACTION -->

        <div class="flex justify-end gap-4">

            <a
                href="<?= base_url('admin/lowongan') ?>"
                class="px-6 py-4 rounded-2xl bg-gray-200 hover:bg-gray-300 transition font-semibold"
            >
                Batal
            </a>

            <button
                type="submit"
                class="bg-yellow-400 hover:bg-yellow-500 text-black px-8 py-4 rounded-2xl font-bold transition"
            >
                Update Lowongan
            </button>

        </div>

    </form>

</div>

<script>

let kriteriaIndex =
document.querySelectorAll(
    '.kriteria-item'
).length;

/* =========================
   HITUNG TOTAL BOBOT
========================= */

function hitungBobot(){

    let total = 0;

    document.querySelectorAll(
        '.bobot-input'
    ).forEach(input => {

        total +=
        parseFloat(input.value) || 0;

    });

    document.getElementById(
        'total-bobot'
    ).innerHTML =
    `Total Bobot: ${total}%`;

}

/* =========================
   LOAD AWAL
========================= */

hitungBobot();

/* =========================
   TAMBAH KRITERIA
========================= */

function tambahKriteria(){

    let nomor =
    document.querySelectorAll(
        '.kriteria-item'
    ).length + 1;

    let html = `

    <div class="kriteria-item bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-6">

        <div class="flex justify-between items-center mb-6">

            <h4 class="text-xl font-bold text-gray-700">
                Kriteria #${nomor}
            </h4>

            <button
                type="button"
                onclick="hapusKriteria(this)"
                class="bg-red-100 text-red-600 px-4 py-2 rounded-xl hover:bg-red-200 transition"
            >
                Hapus
            </button>

        </div>

        <div class="grid md:grid-cols-3 gap-5 mb-6">

            <div>

                <label class="block mb-2 font-semibold">
                    Nama Kriteria
                </label>

                <input
                    type="text"
                    name="nama_kriteria[]"
                    required
                    class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                >

            </div>

            <div>

                <label class="block mb-2 font-semibold">
                    Bobot (%)
                </label>

                <input
                    type="number"
                    name="bobot[]"
                    required
                    oninput="hitungBobot()"
                    class="bobot-input w-full border border-gray-300 rounded-2xl px-4 py-3"
                >

            </div>

            <div>

                <label class="block mb-2 font-semibold">
                    Atribut
                </label>

                <select
                    name="atribut[]"
                    class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                >

                    <option value="benefit">
                        Benefit
                    </option>

                    <option value="cost">
                        Cost
                    </option>

                </select>

            </div>

        </div>

        <div class="bg-gray-50 rounded-2xl p-6">

            <div class="flex justify-between items-center mb-5">

                <h5 class="font-bold text-gray-700">
                    Sub Kriteria
                </h5>

                <button
                    type="button"
                    onclick="tambahSub(${kriteriaIndex})"
                    class="bg-yellow-400 hover:bg-yellow-500 text-black px-4 py-2 rounded-xl font-semibold transition"
                >
                    + Tambah Sub
                </button>

            </div>

            <div class="sub-container space-y-4">

                <div class="sub-item grid md:grid-cols-12 gap-4">

                    <div class="md:col-span-5">

                        <input
                            type="text"
                            name="nama_sub[${kriteriaIndex}][]"
                            required
                            class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                        >

                    </div>

                    <div class="md:col-span-5">

                        <input
                            type="number"
                            name="nilai_sub[${kriteriaIndex}][]"
                            required
                            class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                        >

                    </div>

                    <div class="md:col-span-2">

                        <button
                            type="button"
                            onclick="hapusSub(this)"
                            class="w-full bg-red-100 text-red-600 py-3 rounded-2xl hover:bg-red-200 transition"
                        >
                            Hapus
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

    `;

    document.getElementById(
        'kriteria-container'
    ).insertAdjacentHTML(
        'beforeend',
        html
    );

    kriteriaIndex++;

}

/* =========================
   TAMBAH SUB
========================= */

function tambahSub(index){

    let containers =
    document.querySelectorAll(
        '.sub-container'
    );

    let subContainer =
    containers[index];

    let html = `

    <div class="sub-item grid md:grid-cols-12 gap-4">

        <div class="md:col-span-5">

            <input
                type="text"
                name="nama_sub[${index}][]"
                required
                class="w-full border border-gray-300 rounded-2xl px-4 py-3"
            >

        </div>

        <div class="md:col-span-5">

            <input
                type="number"
                name="nilai_sub[${index}][]"
                required
                class="w-full border border-gray-300 rounded-2xl px-4 py-3"
            >

        </div>

        <div class="md:col-span-2">

            <button
                type="button"
                onclick="hapusSub(this)"
                class="w-full bg-red-100 text-red-600 py-3 rounded-2xl hover:bg-red-200 transition"
            >
                Hapus
            </button>

        </div>

    </div>

    `;

    subContainer.insertAdjacentHTML(
        'beforeend',
        html
    );

}

/* =========================
   HAPUS KRITERIA
========================= */

function hapusKriteria(button){

    let total =
    document.querySelectorAll(
        '.kriteria-item'
    ).length;

    if(total <= 1){

        alert('Minimal 1 kriteria');

        return;

    }

    button.closest(
        '.kriteria-item'
    ).remove();

    hitungBobot();

}

/* =========================
   HAPUS SUB
========================= */

function hapusSub(button){

    let subContainer =
    button.closest(
        '.sub-container'
    );

    let total =
    subContainer.querySelectorAll(
        '.sub-item'
    ).length;

    if(total <= 1){

        alert(
            'Minimal 1 sub kriteria'
        );

        return;

    }

    button.closest(
        '.sub-item'
    ).remove();

}

/* =========================
   VALIDASI BOBOT
========================= */

document.getElementById(
    'form-lowongan'
).addEventListener(
    'submit',
    function(e){

        let total = 0;

        document.querySelectorAll(
            '.bobot-input'
        ).forEach(input => {

            total +=
            parseFloat(input.value) || 0;

        });

        let bobotInputs = document.querySelectorAll('.bobot-input');
        if(bobotInputs.length > 0 && total != 100){

            e.preventDefault();

            alert(
                'Total bobot harus 100%'
            );

        }

    }
);

</script>

<?= $this->endSection() ?>