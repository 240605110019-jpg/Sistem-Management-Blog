<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sistem Manajemen Blog (CMS)</title>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f2f5; color: #333; }

  /* HEADER */
  .header {
    background: #1e2a3a;
    color: #fff;
    padding: 0 20px;
    height: 56px;
    display: flex;
    align-items: center;
    gap: 12px;
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 100;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
  }
  .header-icon {
    width: 32px; height: 32px;
    background: #2d8cf0;
    border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px;
  }
  .header-title { font-size: 15px; font-weight: 600; line-height: 1.3; }
  .header-subtitle { font-size: 11px; color: #aab; }

  /* LAYOUT */
  .layout {
    display: flex;
    margin-top: 56px;
    min-height: calc(100vh - 56px);
  }

  /* SIDEBAR */
  .sidebar {
    width: 210px;
    background: #fff;
    border-right: 1px solid #e3e6ed;
    padding: 20px 12px;
    position: fixed;
    top: 56px; bottom: 0; left: 0;
    overflow-y: auto;
  }
  .sidebar-label {
    font-size: 10px;
    font-weight: 700;
    color: #aab;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding: 0 10px 10px;
  }
  .nav-item {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 12px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 13.5px;
    color: #555;
    transition: all 0.15s;
    margin-bottom: 2px;
  }
  .nav-item:hover { background: #f4f6fa; color: #333; }
  .nav-item.active { background: #e8f5e9; color: #2e7d32; font-weight: 600; border-left: 3px solid #4caf50; }
  .nav-item .nav-icon { font-size: 15px; }

  /* MAIN CONTENT */
  .main {
    margin-left: 210px;
    padding: 28px;
    flex: 1;
  }

  /* CONTENT SECTION */
  .section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
  }
  .section-title { font-size: 20px; font-weight: 700; color: #1e2a3a; }

  .btn-tambah {
    background: #4caf50;
    color: #fff;
    border: none;
    padding: 9px 18px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.15s;
  }
  .btn-tambah:hover { background: #388e3c; }

  /* TABLE CARD */
  .card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 1px 6px rgba(0,0,0,0.07);
    overflow: hidden;
  }
  table { width: 100%; border-collapse: collapse; }
  thead tr { background: #fafbfc; }
  th {
    padding: 12px 16px;
    text-align: left;
    font-size: 11px;
    font-weight: 700;
    color: #888;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    border-bottom: 1px solid #eee;
  }
  td {
    padding: 14px 16px;
    font-size: 13.5px;
    border-bottom: 1px solid #f0f2f5;
    vertical-align: middle;
  }
  tr:last-child td { border-bottom: none; }
  tr:hover td { background: #fafcff; }

  .foto-thumb {
    width: 44px; height: 44px;
    border-radius: 8px;
    background: #e0e4ea;
    display: flex; align-items: center; justify-content: center;
    font-size: 10px;
    color: #aaa;
    font-weight: 600;
    overflow: hidden;
    flex-shrink: 0;
  }
  .foto-thumb img { width: 100%; height: 100%; object-fit: cover; }

  .badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 600;
    background: #e3f2fd;
    color: #1565c0;
  }

  .password-mask { color: #aaa; font-size: 13px; }

  .btn-edit {
    background: #2196f3; color: #fff;
    border: none; padding: 6px 14px;
    border-radius: 5px; font-size: 12.5px;
    font-weight: 600; cursor: pointer; margin-right: 4px;
    transition: background 0.15s;
  }
  .btn-edit:hover { background: #1565c0; }
  .btn-hapus {
    background: #f44336; color: #fff;
    border: none; padding: 6px 14px;
    border-radius: 5px; font-size: 12.5px;
    font-weight: 600; cursor: pointer;
    transition: background 0.15s;
  }
  .btn-hapus:hover { background: #b71c1c; }

  /* MODAL OVERLAY */
  .modal-overlay {
    display: none;
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.45);
    z-index: 1000;
    align-items: center;
    justify-content: center;
  }
  .modal-overlay.show { display: flex; }

  .modal-box {
    background: #fff;
    border-radius: 10px;
    padding: 28px;
    width: 480px;
    max-width: 95vw;
    box-shadow: 0 8px 40px rgba(0,0,0,0.2);
    max-height: 90vh;
    overflow-y: auto;
  }
  .modal-title {
    font-size: 17px; font-weight: 700;
    margin-bottom: 20px; color: #1e2a3a;
  }

  .form-row { display: flex; gap: 14px; }
  .form-group { margin-bottom: 16px; flex: 1; }
  .form-group label {
    display: block; font-size: 12.5px;
    font-weight: 600; color: #555;
    margin-bottom: 6px;
  }
  .form-group input,
  .form-group select,
  .form-group textarea {
    width: 100%;
    padding: 9px 12px;
    border: 1px solid #dde1e8;
    border-radius: 6px;
    font-size: 13px;
    color: #333;
    transition: border 0.15s;
    font-family: inherit;
    background: #fff;
  }
  .form-group input:focus,
  .form-group select:focus,
  .form-group textarea:focus {
    outline: none;
    border-color: #4caf50;
    box-shadow: 0 0 0 3px rgba(76,175,80,0.1);
  }
  .form-group textarea { resize: vertical; min-height: 90px; }

  .modal-actions {
    display: flex; justify-content: flex-end; gap: 10px;
    margin-top: 22px;
  }
  .btn-batal {
    background: #e0e4ea; color: #555;
    border: none; padding: 9px 20px;
    border-radius: 6px; font-size: 13px;
    font-weight: 600; cursor: pointer;
    transition: background 0.15s;
  }
  .btn-batal:hover { background: #cdd2da; }
  .btn-simpan {
    background: #4caf50; color: #fff;
    border: none; padding: 9px 22px;
    border-radius: 6px; font-size: 13px;
    font-weight: 600; cursor: pointer;
    transition: background 0.15s;
  }
  .btn-simpan:hover { background: #388e3c; }

  /* HAPUS MODAL */
  .modal-hapus-box {
    background: #fff;
    border-radius: 10px;
    padding: 36px 28px;
    width: 380px;
    max-width: 95vw;
    text-align: center;
    box-shadow: 0 8px 40px rgba(0,0,0,0.2);
  }
  .hapus-icon {
    width: 60px; height: 60px;
    background: #fff0f0;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
    font-size: 26px;
  }
  .hapus-title { font-size: 16px; font-weight: 700; margin-bottom: 8px; }
  .hapus-desc { font-size: 13px; color: #888; margin-bottom: 24px; }
  .hapus-actions { display: flex; justify-content: center; gap: 12px; }
  .btn-ya-hapus {
    background: #f44336; color: #fff;
    border: none; padding: 9px 24px;
    border-radius: 6px; font-size: 13px;
    font-weight: 600; cursor: pointer;
  }
  .btn-ya-hapus:hover { background: #b71c1c; }

  /* TOAST */
  .toast {
    position: fixed; bottom: 28px; right: 28px;
    background: #323232; color: #fff;
    padding: 12px 22px; border-radius: 8px;
    font-size: 13.5px; font-weight: 500;
    z-index: 9999; display: none;
    box-shadow: 0 4px 16px rgba(0,0,0,0.3);
    animation: slideUp 0.3s ease;
  }
  .toast.show { display: block; }
  .toast.success { background: #388e3c; }
  .toast.error { background: #c62828; }
  @keyframes slideUp {
    from { transform: translateY(20px); opacity: 0; }
    to   { transform: translateY(0);    opacity: 1; }
  }

  .loading { text-align: center; padding: 40px; color: #aaa; font-size: 14px; }
  .empty { text-align: center; padding: 40px; color: #bbb; font-size: 14px; }
</style>
</head>
<body>

<!-- HEADER -->
<header class="header">
  <div class="header-icon">📋</div>
  <div>
    <div class="header-title">Sistem Manajemen Blog (CMS)</div>
    <div class="header-subtitle">Blog Keren</div>
  </div>
</header>

<div class="layout">
  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="sidebar-label">Menu Utama</div>
    <div class="nav-item active" id="nav-penulis" onclick="gotoMenu('penulis')">
      <span class="nav-icon">👤</span> Kelola Penulis
    </div>
    <div class="nav-item" id="nav-artikel" onclick="gotoMenu('artikel')">
      <span class="nav-icon">📄</span> Kelola Artikel
    </div>
    <div class="nav-item" id="nav-kategori" onclick="gotoMenu('kategori')">
      <span class="nav-icon">📁</span> Kelola Kategori
    </div>
  </aside>

  <!-- MAIN -->
  <main class="main">
    <!-- PENULIS SECTION -->
    <section id="section-penulis">
      <div class="section-header">
        <div class="section-title">Data Penulis</div>
        <button class="btn-tambah" onclick="bukaModalTambahPenulis()">+ Tambah Penulis</button>
      </div>
      <div class="card">
        <table>
          <thead>
            <tr>
              <th>Foto</th>
              <th>Nama</th>
              <th>Username</th>
              <th>Password</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="tabel-penulis">
            <tr><td colspan="5" class="loading">Memuat data...</td></tr>
          </tbody>
        </table>
      </div>
    </section>

    <!-- ARTIKEL SECTION -->
    <section id="section-artikel" style="display:none">
      <div class="section-header">
        <div class="section-title">Data Artikel</div>
        <button class="btn-tambah" onclick="bukaModalTambahArtikel()">+ Tambah Artikel</button>
      </div>
      <div class="card">
        <table>
          <thead>
            <tr>
              <th>Gambar</th>
              <th>Judul</th>
              <th>Kategori</th>
              <th>Penulis</th>
              <th>Tanggal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="tabel-artikel">
            <tr><td colspan="6" class="loading">Memuat data...</td></tr>
          </tbody>
        </table>
      </div>
    </section>

    <!-- KATEGORI SECTION -->
    <section id="section-kategori" style="display:none">
      <div class="section-header">
        <div class="section-title">Data Kategori Artikel</div>
        <button class="btn-tambah" onclick="bukaModalTambahKategori()">+ Tambah Kategori</button>
      </div>
      <div class="card">
        <table>
          <thead>
            <tr>
              <th>Nama Kategori</th>
              <th>Keterangan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="tabel-kategori">
            <tr><td colspan="3" class="loading">Memuat data...</td></tr>
          </tbody>
        </table>
      </div>
    </section>
  </main>
</div>

<!-- ============================================================ -->
<!-- MODAL TAMBAH PENULIS -->
<!-- ============================================================ -->
<div class="modal-overlay" id="modal-tambah-penulis">
  <div class="modal-box">
    <div class="modal-title">Tambah Penulis</div>
    <div class="form-row">
      <div class="form-group">
        <label>Nama Depan</label>
        <input type="text" id="tp-nama-depan" placeholder="Ahmad">
      </div>
      <div class="form-group">
        <label>Nama Belakang</label>
        <input type="text" id="tp-nama-belakang" placeholder="Fauzi">
      </div>
    </div>
    <div class="form-group">
      <label>Username</label>
      <input type="text" id="tp-username" placeholder="ahmad_f">
    </div>
    <div class="form-group">
      <label>Password</label>
      <input type="password" id="tp-password" placeholder="••••••••••">
    </div>
    <div class="form-group">
      <label>Foto Profil</label>
      <input type="file" id="tp-foto" accept="image/*">
    </div>
    <div class="modal-actions">
      <button class="btn-batal" onclick="tutupModal('modal-tambah-penulis')">Batal</button>
      <button class="btn-simpan" onclick="simpanPenulis()">Simpan Data</button>
    </div>
  </div>
</div>

<!-- MODAL EDIT PENULIS -->
<div class="modal-overlay" id="modal-edit-penulis">
  <div class="modal-box">
    <div class="modal-title">Edit Penulis</div>
    <input type="hidden" id="ep-id">
    <div class="form-row">
      <div class="form-group">
        <label>Nama Depan</label>
        <input type="text" id="ep-nama-depan">
      </div>
      <div class="form-group">
        <label>Nama Belakang</label>
        <input type="text" id="ep-nama-belakang">
      </div>
    </div>
    <div class="form-group">
      <label>Username</label>
      <input type="text" id="ep-username">
    </div>
    <div class="form-group">
      <label>Password Baru (kosongkan jika tidak diganti)</label>
      <input type="password" id="ep-password" placeholder="••••••••••">
    </div>
    <div class="form-group">
      <label>Foto Profil (kosongkan jika tidak diganti)</label>
      <input type="file" id="ep-foto" accept="image/*">
    </div>
    <div class="modal-actions">
      <button class="btn-batal" onclick="tutupModal('modal-edit-penulis')">Batal</button>
      <button class="btn-simpan" onclick="updatePenulis()">Simpan Perubahan</button>
    </div>
  </div>
</div>

<!-- ============================================================ -->
<!-- MODAL TAMBAH ARTIKEL -->
<!-- ============================================================ -->
<div class="modal-overlay" id="modal-tambah-artikel">
  <div class="modal-box">
    <div class="modal-title">Tambah Artikel</div>
    <div class="form-group">
      <label>Judul</label>
      <input type="text" id="ta-judul" placeholder="Judul artikel...">
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Penulis</label>
        <select id="ta-penulis"></select>
      </div>
      <div class="form-group">
        <label>Kategori</label>
        <select id="ta-kategori"></select>
      </div>
    </div>
    <div class="form-group">
      <label>Isi Artikel</label>
      <textarea id="ta-isi" placeholder="Tulis isi artikel di sini..." rows="4"></textarea>
    </div>
    <div class="form-group">
      <label>Gambar</label>
      <input type="file" id="ta-gambar" accept="image/*">
    </div>
    <div class="modal-actions">
      <button class="btn-batal" onclick="tutupModal('modal-tambah-artikel')">Batal</button>
      <button class="btn-simpan" onclick="simpanArtikel()">Simpan Data</button>
    </div>
  </div>
</div>

<!-- MODAL EDIT ARTIKEL -->
<div class="modal-overlay" id="modal-edit-artikel">
  <div class="modal-box">
    <div class="modal-title">Edit Artikel</div>
    <input type="hidden" id="ea-id">
    <div class="form-group">
      <label>Judul</label>
      <input type="text" id="ea-judul">
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Penulis</label>
        <select id="ea-penulis"></select>
      </div>
      <div class="form-group">
        <label>Kategori</label>
        <select id="ea-kategori"></select>
      </div>
    </div>
    <div class="form-group">
      <label>Isi Artikel</label>
      <textarea id="ea-isi" rows="4"></textarea>
    </div>
    <div class="form-group">
      <label>Gambar (kosongkan jika tidak diganti)</label>
      <input type="file" id="ea-gambar" accept="image/*">
    </div>
    <div class="modal-actions">
      <button class="btn-batal" onclick="tutupModal('modal-edit-artikel')">Batal</button>
      <button class="btn-simpan" onclick="updateArtikel()">Simpan Perubahan</button>
    </div>
  </div>
</div>

<!-- ============================================================ -->
<!-- MODAL TAMBAH KATEGORI -->
<!-- ============================================================ -->
<div class="modal-overlay" id="modal-tambah-kategori">
  <div class="modal-box" style="width:420px">
    <div class="modal-title">Tambah Kategori</div>
    <div class="form-group">
      <label>Nama Kategori</label>
      <input type="text" id="tk-nama" placeholder="Nama kategori...">
    </div>
    <div class="form-group">
      <label>Keterangan</label>
      <textarea id="tk-keterangan" placeholder="Deskripsi kategori..." rows="3"></textarea>
    </div>
    <div class="modal-actions">
      <button class="btn-batal" onclick="tutupModal('modal-tambah-kategori')">Batal</button>
      <button class="btn-simpan" onclick="simpanKategori()">Simpan Data</button>
    </div>
  </div>
</div>

<!-- MODAL EDIT KATEGORI -->
<div class="modal-overlay" id="modal-edit-kategori">
  <div class="modal-box" style="width:420px">
    <div class="modal-title">Edit Kategori</div>
    <input type="hidden" id="ek-id">
    <div class="form-group">
      <label>Nama Kategori</label>
      <input type="text" id="ek-nama">
    </div>
    <div class="form-group">
      <label>Keterangan</label>
      <textarea id="ek-keterangan" rows="3"></textarea>
    </div>
    <div class="modal-actions">
      <button class="btn-batal" onclick="tutupModal('modal-edit-kategori')">Batal</button>
      <button class="btn-simpan" onclick="updateKategori()">Simpan Perubahan</button>
    </div>
  </div>
</div>

<!-- ============================================================ -->
<!-- MODAL HAPUS KONFIRMASI -->
<!-- ============================================================ -->
<div class="modal-overlay" id="modal-hapus">
  <div class="modal-hapus-box">
    <div class="hapus-icon">🗑️</div>
    <div class="hapus-title">Hapus data ini?</div>
    <div class="hapus-desc">Data yang dihapus tidak dapat dikembalikan.</div>
    <div class="hapus-actions">
      <button class="btn-batal" onclick="tutupModal('modal-hapus')">Batal</button>
      <button class="btn-ya-hapus" id="btn-konfirmasi-hapus">Ya, Hapus</button>
    </div>
  </div>
</div>

<!-- TOAST -->
<div class="toast" id="toast"></div>

<script>
// ============================================================
// UTILITIES
// ============================================================
function esc(str) {
  const d = document.createElement('div');
  d.textContent = str || '';
  return d.innerHTML;
}

// Tampilkan default.png jika gambar gagal dimuat (flag agar tidak loop)
function fotoFallback(img) {
  if (!img.dataset.fallback) {
    img.dataset.fallback = '1';
    img.src = 'uploads_penulis/default.png';
  }
}

function showToast(msg, type = 'success') {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.className = 'toast show ' + type;
  setTimeout(() => t.className = 'toast', 3000);
}

function tutupModal(id) {
  document.getElementById(id).classList.remove('show');
}

function bukaModal(id) {
  document.getElementById(id).classList.add('show');
}

// Close modal on overlay click
document.querySelectorAll('.modal-overlay').forEach(el => {
  el.addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('show');
  });
});

// ============================================================
// NAVIGASI
// ============================================================
let menuAktif = 'penulis';

function gotoMenu(menu) {
  menuAktif = menu;
  ['penulis','artikel','kategori'].forEach(m => {
    document.getElementById('section-' + m).style.display = m === menu ? '' : 'none';
    document.getElementById('nav-' + m).classList.toggle('active', m === menu);
  });
  if (menu === 'penulis') muatPenulis();
  if (menu === 'artikel') muatArtikel();
  if (menu === 'kategori') muatKategori();
}

// ============================================================
// =================== KELOLA PENULIS ========================
// ============================================================
function muatPenulis() {
  const tbody = document.getElementById('tabel-penulis');
  tbody.innerHTML = '<tr><td colspan="5" class="loading">Memuat data...</td></tr>';
  fetch('ambil_penulis.php')
    .then(r => r.json())
    .then(res => {
      if (res.status !== 'ok' || !res.data.length) {
        tbody.innerHTML = '<tr><td colspan="5" class="empty">Belum ada data penulis.</td></tr>';
        return;
      }
      tbody.innerHTML = res.data.map(p => {
        const nama = esc(p.nama_depan) + ' ' + esc(p.nama_belakang);
        const fotoSrc = `uploads_penulis/${p.foto && p.foto !== '' ? p.foto : 'default.png'}`;
        const fotoHtml = `<div class="foto-thumb"><img src="${fotoSrc}" alt="foto" onerror="fotoFallback(this)"></div>`;
        const pass = esc(p.password).substring(0, 12) + '...';
        return `<tr>
          <td>${fotoHtml}</td>
          <td>${nama}</td>
          <td><span class="badge">${esc(p.user_name)}</span></td>
          <td class="password-mask">${pass}</td>
          <td>
            <button class="btn-edit" onclick="bukaEditPenulis(${p.id})">Edit</button>
            <button class="btn-hapus" onclick="konfirmasiHapus('penulis', ${p.id})">Hapus</button>
          </td>
        </tr>`;
      }).join('');
    })
    .catch(() => {
      tbody.innerHTML = '<tr><td colspan="5" class="empty">Gagal memuat data.</td></tr>';
    });
}

function bukaModalTambahPenulis() {
  document.getElementById('tp-nama-depan').value = '';
  document.getElementById('tp-nama-belakang').value = '';
  document.getElementById('tp-username').value = '';
  document.getElementById('tp-password').value = '';
  document.getElementById('tp-foto').value = '';
  bukaModal('modal-tambah-penulis');
}

function simpanPenulis() {
  const fd = new FormData();
  fd.append('nama_depan',    document.getElementById('tp-nama-depan').value.trim());
  fd.append('nama_belakang', document.getElementById('tp-nama-belakang').value.trim());
  fd.append('user_name',     document.getElementById('tp-username').value.trim());
  fd.append('password',      document.getElementById('tp-password').value);
  const foto = document.getElementById('tp-foto').files[0];
  if (foto) fd.append('foto', foto);

  fetch('simpan_penulis.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      showToast(res.pesan, res.status === 'ok' ? 'success' : 'error');
      if (res.status === 'ok') { tutupModal('modal-tambah-penulis'); muatPenulis(); }
    });
}

function bukaEditPenulis(id) {
  fetch('ambil_satu_penulis.php?id=' + id)
    .then(r => r.json())
    .then(res => {
      if (res.status !== 'ok') { showToast(res.pesan, 'error'); return; }
      const d = res.data;
      document.getElementById('ep-id').value          = d.id;
      document.getElementById('ep-nama-depan').value  = d.nama_depan;
      document.getElementById('ep-nama-belakang').value = d.nama_belakang;
      document.getElementById('ep-username').value    = d.user_name;
      document.getElementById('ep-password').value    = '';
      document.getElementById('ep-foto').value        = '';
      bukaModal('modal-edit-penulis');
    });
}

function updatePenulis() {
  const fd = new FormData();
  fd.append('id',            document.getElementById('ep-id').value);
  fd.append('nama_depan',    document.getElementById('ep-nama-depan').value.trim());
  fd.append('nama_belakang', document.getElementById('ep-nama-belakang').value.trim());
  fd.append('user_name',     document.getElementById('ep-username').value.trim());
  fd.append('password',      document.getElementById('ep-password').value);
  const foto = document.getElementById('ep-foto').files[0];
  if (foto) fd.append('foto', foto);

  fetch('update_penulis.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      showToast(res.pesan, res.status === 'ok' ? 'success' : 'error');
      if (res.status === 'ok') { tutupModal('modal-edit-penulis'); muatPenulis(); }
    });
}

// ============================================================
// =================== KELOLA ARTIKEL ========================
// ============================================================
function muatArtikel() {
  const tbody = document.getElementById('tabel-artikel');
  tbody.innerHTML = '<tr><td colspan="6" class="loading">Memuat data...</td></tr>';
  fetch('ambil_artikel.php')
    .then(r => r.json())
    .then(res => {
      if (res.status !== 'ok' || !res.data.length) {
        tbody.innerHTML = '<tr><td colspan="6" class="empty">Belum ada data artikel.</td></tr>';
        return;
      }
      tbody.innerHTML = res.data.map(a => {
        const gambarHtml = `<div class="foto-thumb"><img src="uploads_artikel/${a.gambar || ''}" alt="gambar" onerror="fotoFallback(this)"></div>`;
        const penulis = esc(a.nama_depan) + ' ' + esc(a.nama_belakang);
        return `<tr>
          <td>${gambarHtml}</td>
          <td>${esc(a.judul)}</td>
          <td><span class="badge">${esc(a.nama_kategori)}</span></td>
          <td>${penulis}</td>
          <td style="font-size:12px;color:#777">${esc(a.hari_tanggal)}</td>
          <td>
            <button class="btn-edit" onclick="bukaEditArtikel(${a.id})">Edit</button>
            <button class="btn-hapus" onclick="konfirmasiHapus('artikel', ${a.id})">Hapus</button>
          </td>
        </tr>`;
      }).join('');
    })
    .catch(() => {
      tbody.innerHTML = '<tr><td colspan="6" class="empty">Gagal memuat data.</td></tr>';
    });
}

function isiDropdownPenulis(selectId, selectedId = null) {
  fetch('ambil_penulis.php')
    .then(r => r.json())
    .then(res => {
      const sel = document.getElementById(selectId);
      sel.innerHTML = res.data.map(p =>
        `<option value="${p.id}" ${p.id == selectedId ? 'selected' : ''}>
          ${esc(p.nama_depan)} ${esc(p.nama_belakang)}
        </option>`
      ).join('');
    });
}

function isiDropdownKategori(selectId, selectedId = null) {
  fetch('ambil_kategori.php')
    .then(r => r.json())
    .then(res => {
      const sel = document.getElementById(selectId);
      sel.innerHTML = res.data.map(k =>
        `<option value="${k.id}" ${k.id == selectedId ? 'selected' : ''}>
          ${esc(k.nama_kategori)}
        </option>`
      ).join('');
    });
}

function bukaModalTambahArtikel() {
  document.getElementById('ta-judul').value = '';
  document.getElementById('ta-isi').value   = '';
  document.getElementById('ta-gambar').value = '';
  isiDropdownPenulis('ta-penulis');
  isiDropdownKategori('ta-kategori');
  bukaModal('modal-tambah-artikel');
}

function simpanArtikel() {
  const fd = new FormData();
  fd.append('judul',       document.getElementById('ta-judul').value.trim());
  fd.append('id_penulis',  document.getElementById('ta-penulis').value);
  fd.append('id_kategori', document.getElementById('ta-kategori').value);
  fd.append('isi',         document.getElementById('ta-isi').value.trim());
  const gambar = document.getElementById('ta-gambar').files[0];
  if (gambar) fd.append('gambar', gambar);

  fetch('simpan_artikel.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      showToast(res.pesan, res.status === 'ok' ? 'success' : 'error');
      if (res.status === 'ok') { tutupModal('modal-tambah-artikel'); muatArtikel(); }
    });
}

function bukaEditArtikel(id) {
  fetch('ambil_satu_artikel.php?id=' + id)
    .then(r => r.json())
    .then(res => {
      if (res.status !== 'ok') { showToast(res.pesan, 'error'); return; }
      const d = res.data;
      document.getElementById('ea-id').value    = d.id;
      document.getElementById('ea-judul').value = d.judul;
      document.getElementById('ea-isi').value   = d.isi;
      document.getElementById('ea-gambar').value = '';
      isiDropdownPenulis('ea-penulis', d.id_penulis);
      isiDropdownKategori('ea-kategori', d.id_kategori);
      bukaModal('modal-edit-artikel');
    });
}

function updateArtikel() {
  const fd = new FormData();
  fd.append('id',          document.getElementById('ea-id').value);
  fd.append('judul',       document.getElementById('ea-judul').value.trim());
  fd.append('id_penulis',  document.getElementById('ea-penulis').value);
  fd.append('id_kategori', document.getElementById('ea-kategori').value);
  fd.append('isi',         document.getElementById('ea-isi').value.trim());
  const gambar = document.getElementById('ea-gambar').files[0];
  if (gambar) fd.append('gambar', gambar);

  fetch('update_artikel.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      showToast(res.pesan, res.status === 'ok' ? 'success' : 'error');
      if (res.status === 'ok') { tutupModal('modal-edit-artikel'); muatArtikel(); }
    });
}

// ============================================================
// =================== KELOLA KATEGORI =======================
// ============================================================
function muatKategori() {
  const tbody = document.getElementById('tabel-kategori');
  tbody.innerHTML = '<tr><td colspan="3" class="loading">Memuat data...</td></tr>';
  fetch('ambil_kategori.php')
    .then(r => r.json())
    .then(res => {
      if (res.status !== 'ok' || !res.data.length) {
        tbody.innerHTML = '<tr><td colspan="3" class="empty">Belum ada data kategori.</td></tr>';
        return;
      }
      tbody.innerHTML = res.data.map(k => `<tr>
        <td><span class="badge">${esc(k.nama_kategori)}</span></td>
        <td style="color:#555">${esc(k.keterangan)}</td>
        <td>
          <button class="btn-edit" onclick="bukaEditKategori(${k.id})">Edit</button>
          <button class="btn-hapus" onclick="konfirmasiHapus('kategori', ${k.id})">Hapus</button>
        </td>
      </tr>`).join('');
    })
    .catch(() => {
      tbody.innerHTML = '<tr><td colspan="3" class="empty">Gagal memuat data.</td></tr>';
    });
}

function bukaModalTambahKategori() {
  document.getElementById('tk-nama').value       = '';
  document.getElementById('tk-keterangan').value = '';
  bukaModal('modal-tambah-kategori');
}

function simpanKategori() {
  const fd = new FormData();
  fd.append('nama_kategori', document.getElementById('tk-nama').value.trim());
  fd.append('keterangan',    document.getElementById('tk-keterangan').value.trim());

  fetch('simpan_kategori.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      showToast(res.pesan, res.status === 'ok' ? 'success' : 'error');
      if (res.status === 'ok') { tutupModal('modal-tambah-kategori'); muatKategori(); }
    });
}

function bukaEditKategori(id) {
  fetch('ambil_satu_kategori.php?id=' + id)
    .then(r => r.json())
    .then(res => {
      if (res.status !== 'ok') { showToast(res.pesan, 'error'); return; }
      const d = res.data;
      document.getElementById('ek-id').value          = d.id;
      document.getElementById('ek-nama').value        = d.nama_kategori;
      document.getElementById('ek-keterangan').value  = d.keterangan;
      bukaModal('modal-edit-kategori');
    });
}

function updateKategori() {
  const fd = new FormData();
  fd.append('id',            document.getElementById('ek-id').value);
  fd.append('nama_kategori', document.getElementById('ek-nama').value.trim());
  fd.append('keterangan',    document.getElementById('ek-keterangan').value.trim());

  fetch('update_kategori.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      showToast(res.pesan, res.status === 'ok' ? 'success' : 'error');
      if (res.status === 'ok') { tutupModal('modal-edit-kategori'); muatKategori(); }
    });
}

// ============================================================
// =================== HAPUS UNIVERSAL =======================
// ============================================================
function konfirmasiHapus(tipe, id) {
  const btn = document.getElementById('btn-konfirmasi-hapus');
  // Remove old listener
  const baru = btn.cloneNode(true);
  btn.parentNode.replaceChild(baru, btn);

  baru.addEventListener('click', () => {
    const endpoints = {
      penulis:  'hapus_penulis.php',
      artikel:  'hapus_artikel.php',
      kategori: 'hapus_kategori.php'
    };
    const fd = new FormData();
    fd.append('id', id);
    fetch(endpoints[tipe], { method: 'POST', body: fd })
      .then(r => r.json())
      .then(res => {
        showToast(res.pesan, res.status === 'ok' ? 'success' : 'error');
        tutupModal('modal-hapus');
        if (res.status === 'ok') {
          if (tipe === 'penulis')  muatPenulis();
          if (tipe === 'artikel')  muatArtikel();
          if (tipe === 'kategori') muatKategori();
        }
      });
  });

  bukaModal('modal-hapus');
}

// ============================================================
// INIT
// ============================================================
muatPenulis();
</script>
</body>
</html>
