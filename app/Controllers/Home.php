<?php

namespace App\Controllers;

use Codeigniter\Controller;
use App\Models\Gudang;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Home extends BaseController
{
public function dashboard()
{
    $model = new Gudang();
    
    // Ambil data user berdasarkan sesi
    $whereUser = array('id_user' => session()->get('id_user'));
    $data['dennis'] = $model->getwhere('tb_user', $whereUser); 
    
    // Ambil data setting
    $whereSetting = array('id_setting' => 1);
    $data['setting'] = $model->getWhere('tb_setting', $whereSetting);
    
    // Ambil data jasa beserta informasi user
    $data['jasa'] = $model->getJasaWithUserInfo(); // Fungsi ini harus ada di model Gudang
    
    // Tampilkan view dengan data
    echo view('header', $data);
    echo view('menu');
    echo view('dashboard', $data); // Pastikan data dikirim ke view dashboard
    echo view('footer');
}


		public function login()
{
    $model = new Gudang;
    $where = array('id_setting' => 1);
    $data['setting'] = $model->getWhere('tb_setting',$where);
	echo view('header',$data);
	echo view('login');

}
public function logout()
{

 $this->log_activity('User melakukan logout');
session()->destroy();
return redirect()->to('Home/dashboard');

}
public function aksilogin()
{
    $u = $this->request->getPost('username');
    $p = $this->request->getPost('password');
    $captchaAnswer = $this->request->getPost('captcha_answer');

    
    $model = new Gudang();
    $where = array(
        'username' => $u,
        'password' => md5($p)
    );

    $cek = $model->getWhere('tb_user', $where);

    // Offline CAPTCHA answer (should match the one generated in the view)
    if (!$this->isOnline() && !empty($captchaAnswer)) {
        $correctAnswer = $this->request->getPost('correct_captcha_answer');
        if ($captchaAnswer != $correctAnswer) {
            return redirect()->to('Home/login')->with('error', 'Incorrect offline CAPTCHA.');
        }
    }

    if ($cek > 0) {
        session()->set('id_user', $cek->id_user);
        session()->set('username', $cek->username);
        session()->set('email', $cek->email);
        session()->set('id_level', $cek->id_level);

        return redirect()->to('Home/dashboard');
    } else {
        return redirect()->to('Home/login')->with('error', 'Invalid username or password.');
    }
}

private function isOnline()
{
    return @fopen("http://www.google.com:80/", "r");
}
















// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~KHUSUS ADMIN ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


    public function setting()
    {
        if(session()->get('id_level') == '1'){
        $model=new Gudang;
                  $where = array('id_user' => session()->get('id_user'));
         $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User membuka halaman Setting');
        echo view('headeradmin',$data);
        echo view('menuadmin',$data);
        echo view('setting',$data);
        echo view('footeradmin');
        // print_r($data);
    }else{
        return redirect()->to('home/error404');
    }
    }
                public function error404()
    {
        if(session()->get('id_level')> '1'){
            $model=new Gudang;
                      $where = array('id_user' => session()->get('id_user'));
         $data['dennis'] = $model->getwhere('tb_user', $where); 
            $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);

        $this->log_activity('User mencoba Ke Halaman data user');
    
        echo view('header',$data);
        echo view('error404');
        
    }else{
        return redirect()->to('Home/error404');
    }
    }
        public function resetpassword($id){
        $model = new Gudang;
        $this->log_activity('User melakukan Reset Password');
        $where = array('id_user' =>$id );
        $table = 'tb_user'; // Nama tabel
        $kolom = 'id_user';
        $data = array(
           
            'password' => md5('123'),
        );
    
        $model->resetpassword($table, $kolom, $where, $data);
        return redirect()->to('Home/user');
    }
        public function aksi_e_setting()
{
    $model = new Gudang();
    $a = $this->request->getPost('nama_web');
    $icon = $this->request->getFile('logo_tab');
    $dash = $this->request->getFile('logo_dashboard');
    $login = $this->request->getFile('logo_login');

    $this->log_activity('User melakukan Setting');

    // Debugging: Log received data
    log_message('debug', 'Website Name: ' . $a);
    log_message('debug', 'Tab Icon: ' . ($icon ? $icon->getName() : 'None'));
    log_message('debug', 'Dashboard Icon: ' . ($dash ? $dash->getName() : 'None'));
    log_message('debug', 'Login Icon: ' . ($login ? $login->getName() : 'None'));

    $data = ['nama_web' => $a];

    if ($icon && $icon->isValid() && !$icon->hasMoved()) {
        $icon->move(ROOTPATH . 'public/images/img/', $icon->getName());
        $data['logo_tab'] = $icon->getName();
    }

    if ($dash && $dash->isValid() && !$dash->hasMoved()) {
        $dash->move(ROOTPATH . 'public/images/img/', $dash->getName());
        $data['logo_dashboard'] = $dash->getName();
    }

    if ($login && $login->isValid() && !$login->hasMoved()) {
        $login->move(ROOTPATH . 'public/images/img/', $login->getName());
        $data['logo_login'] = $login->getName();
    }

    $where = ['id_setting' => 1];
    $model->edit('tb_setting', $data, $where);

    return redirect()->to('Home/setting');
}
    private function log_activity($activity)
    {
        $model = new Gudang();
        $data = [
            'id_user'    => session()->get('id_user'),
            'activity'   => $activity,
            'timestamp' => date('Y-m-d H:i:s')
           
        ];

        $model->tambah('tb_activity', $data);
    }
        public function activity()
    {
       if(session()->get('id_level') == '1'){
            $model = new Gudang();
                      $where = array('id_user' => session()->get('id_user'));
         $data['dennis'] = $model->getwhere('tb_user', $where); 
            $where = array('id_setting' => 1);
            $data['setting'] = $model->getWhere('tb_setting',$where);
            $where=array('id_user'=>session()->get('id_user'));
            $data['user']=$model->getWhere('tb_user', $where);
            
            $this->log_activity('User membuka Log Activity');
            $data['erwin'] = $model->join('tb_activity', 'tb_user',
            'tb_activity.id_user = tb_user.id_user',$where);

        echo view('headeradmin',$data);
        echo view('menuadmin',$data);
        echo view('activity',$data);
        echo view('footeradmin');
    
        }else{
            return redirect()->to('Home/error404');
        }
    }
    public function hapus_activity($id){
    $model = new Gudang();
    
    $where = array('id_activity'=>$id);
    $model->hapus('tb_activity',$where);
    $this->log_activity('User melakukan Penghapusan activity');
    
    return redirect()->to('Home/activity');
}
   public function clear_all_activities() {
    $model = new Gudang(); // Pastikan model sudah terdefinisi dengan benar
    
    // Panggil method untuk menghapus semua data dari tabel
    $model->clear_table('tb_activity');
    
    // Log aktivitas
    $this->log_activity('User melakukan Penghapusan seluruh data activity');
    
    // Redirect ke halaman activity setelah penghapusan
    return redirect()->to('Home/activity');
}
 public function user()
    {
        // if (session()->get('id_level')>0) {
            if(session()->get('id_level') == '1'){
        $model = new Gudang();
                  $where = array('id_user' => session()->get('id_user'));
         $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User membuka view User');
       
        $where=array('id_user'=>session()->get('id_user'));
        $data['erwin']=$model->tampil('tb_user');
        echo view('headeradmin',$data);
        echo view('menuadmin',$data);
        echo view('useradmin',$data);
        echo view('footeradmin');
    
        }else{
            return redirect()->to('Home/error404');
        }
    }
            public function t_user()
    {
        if (session()->get('id_level') == '1') {
        $model = new Gudang();
                  $where = array('id_user' => session()->get('id_user'));
         $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User membuka Form Penambahan Data User');
       
        echo view ('headeradmin',$data);
        echo view('menuadmin',$data);
        echo view('t_useradmin');
        echo view('footeradmin');
    }else{
        return redirect()->to('Home/error404');
    }
    }
        public function aksi_t_user()
    {
        $model = new Gudang();
        $this->log_activity('User melakukan Penambahan Data User');
        $a = $this->request->getPost('username');
        $b = $this->request->getPost('password');
        $c = $this->request->getPost('email');
        $d = $this->request->getPost('level');
        
        $isi = array(

                    'username' => $a,
                    'password' =>md5 ($b),
                    'email' => $c,
                    'id_level' => $d
                    
        );
        
        $model->tambah('tb_user', $isi);
        return redirect()->to('Home/user');

    }
    public function aksi_e_user()
{
    $model = new Gudang();
    $this->log_activity('User melakukan Pengeditan Data User');
    $id_user = $this->request->getPost('id_user');
    $username = $this->request->getPost('username');
    $email = $this->request->getPost('email');
    $id_level = $this->request->getPost('id_level');

    $where = array('id_user' => $id_user);
    $data = array(
        'username' => $username,
        'email' => $email,
        'id_level' => $id_level
    );

    $model->edit('tb_user', $data, $where);
    return redirect()->to('Home/user');
}
public function hapus_user($id){
    $model = new Gudang();
    
    // Log aktivitas penghapusan
    $this->log_activity('User melakukan Penghapusan Data User');

    // Hapus aktivitas terkait user yang dihapus
    $where_activity = array('id_user' => $id);
    $model->hapus('tb_activity', $where_activity);

    // Hapus user dari tb_user
    $where_user = array('id_user' => $id);
    $model->hapus('tb_user', $where_user);

    // Redirect setelah penghapusan
    return redirect()->to('Home/user');
}
    public function dashboardadmin()
{
    if (session()->get('id_level') == '1') {
        $model = new Gudang();
        $where = array('id_user' => session()->get('id_user'));
        $data['dennis'] = $model->getwhere('tb_user', $where);
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting', $where);
 
        echo view('headeradmin', $data);
        echo view('menuadmin', $data);
        echo view('dashboardadmin', $data); // Kirim data ke view
        echo view('footeradmin');

    } else {
        return redirect()->to('Home/error404');
    }
}

public function aksi_e_jasa()
{
    // Memanggil model yang diperlukan
    $model = new Gudang(); // Pastikan Anda menggunakan model yang sesuai dengan tabel jasa

    // Mencatat aktivitas pengeditan
    $this->log_activity('User melakukan Pengeditan Data Jasa');

    // Mengambil data dari form
    $nama = $this->request->getPost('nama');
    $deskripsi = $this->request->getPost('deskripsi');
    $harga = $this->request->getPost('harga');
    $ulasan = $this->request->getPost('ulasan');
    $kategori = $this->request->getPost('kategori');
    $status = $this->request->getPost('status');
    $id_jasa = $this->request->getPost('id_jasa');

    // Menentukan kondisi untuk update
    $file = $this->request->getFile('gambar');
    $foto_jasa = '';

    if ($file->isValid() && !$file->hasMoved()) {
        $foto_jasa = $file->getRandomName();
        $file->move('images/img', $foto_jasa); // Folder tempat menyimpan file
    }

    // Menyiapkan data untuk diupdate
    $data = [
        'nama' => $nama,
        'deskripsi' => $deskripsi,
        'harga' => $harga,
        'ulasan' => $ulasan,
        'kategori' => $kategori,
        'status' => $status,
    ];

    // Memanggil method edit pada model untuk memperbarui data
if ($foto_jasa) {
        $data['gambar'] = $foto_jasa; // Simpan nama file jika ada
    }

    $where = ['id_jasa' => $id_jasa];
    $model->edit('tb_jasa', $data, $where);

    return redirect()->to('Home/jasa');
}
public function jasa()
{
    if (session()->get('id_level') == '1' || session()->get('id_level') == '2') {
        $model = new Gudang();
                  $where = array('id_user' => session()->get('id_user'));
         $data['dennis'] = $model->getwhere('tb_user', $where);
        // Ambil data jasa beserta informasi user
        $data['jasa'] = $model->getJasaWithUserInfo(); // Anda perlu menambahkan fungsi ini di model
        
        // Ambil setting
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting', $where);
        
        $this->log_activity('User membuka view jasa');

        echo view('headeradmin', $data);
        echo view('menuadmin', $data);
        echo view('jasa', $data);
        echo view('footeradmin');
    } else {
        return redirect()->to('Home/error404');
    }
}
public function detailjasa($id_jasa)
{
    if (session()->get('id_level') == '1') {
        $model = new Gudang();
        
        // Ambil data pengguna
        $whereUser = array('id_user' => session()->get('id_user'));
        $data['dennis'] = $model->getwhere('tb_user', $whereUser);
        
        // Ambil data setting
        $whereSetting = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting', $whereSetting);

        // Ambil data jasa berdasarkan id_jasa
        $whereJasa = array('id_jasa' => $id_jasa);
        $data['item'] = $model->getwhere('tb_jasa', $whereJasa); // Ganti dengan metode yang sesuai

        echo view('header', $data);
        echo view('detailjasa', $data); // Kirim data ke view
    } else {
        return redirect()->to('Home/login');
    }
}

public function t_jasa()
{
    if (session()->get('id_level') == '1' || session()->get('id_level') == '2') {
        $model = new Gudang();
        
        // Ambil data user yang sedang login
        $where = array('id_user' => session()->get('id_user'));
        $data['user'] = $model->getWhere('tb_user', $where); // Tidak perlu getFirstRow()
        
        // Ambil setting
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting', $where); // Tidak perlu getFirstRow()

                  $where = array('id_user' => session()->get('id_user'));
         $data['dennis'] = $model->getwhere('tb_user', $where);
        $this->log_activity('User membuka Form Pendaftaran jasa');
        
        echo view('headeradmin', $data);
        echo view('menuadmin', $data);
        echo view('t_jasa', $data); // Kirim data user ke view t_jasa
        echo view('footeradmin');
    } else {
        return redirect()->to('Home/error404');
    }
}

public function aksi_t_jasa()
{
    $model = new Gudang();
    $this->log_activity('User melakukan Penambahan Data Jasa');

    // Ambil data dari form
    $a = $this->request->getPost('nama');
    $b = $this->request->getPost('deskripsi');
    $c = str_replace(['RP', '.'], '', $this->request->getPost('harga')); // Menghapus RP dan titik
    $d = $this->request->getPost('ulasan');
    $e = $this->request->getPost('kategori');
    $user = session()->get('id_user'); // Ambil ID user dari session
    $f = $this->request->getPost('status');
    
    // Proses upload file
    $file = $this->request->getFile('gambar');
    $logoName = $file->getRandomName();
    $file->move('images/img', $logoName); // Folder tempat menyimpan file
    
    // Buat array untuk memasukkan data ke dalam tabel tb_jasa
    $isi = array(
        'nama' => $a,
        'deskripsi' => $b,
        'harga' => $c,
        'ulasan' => $d,
        'kategori' => $e,
        'id_user' => $user, // Simpan ID user ke database
        'status' => $f,
        'gambar' => $logoName // Simpan nama file ke database
    );
    
    // Simpan data ke dalam tabel tb_jasa
    $model->tambah('tb_jasa', $isi);
    return redirect()->to('Home/jasa');
}


public function hapus_jasa($id){
    $model = new Gudang();
    $this->log_activity('User melakukan Penghapusan Data jasa');
    $where = array('id_jasa'=>$id);
    $model->hapus('tb_jasa',$where);
    
    return redirect()->to('Home/jasa');
}
public function profileadmin()
    {
        if (session()->get('id_level') > 0) {
            $model = new GUdang();
            
            $this->log_activity('User masuk ke profile');
            $where = array('id_user' => session()->get('id_user'));
            $data['dennis'] = $model->getwhere('tb_user', $where);
            $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);

            echo view('headeradmin', $data);
            echo view('menuadmin', $data);
            echo view('profileadmin', $data);
            echo view('footeradmin');
        } else {
            return redirect()->to('Home/login');
        }
    }
    public function deletefotoadmin()
{
    $model = new Gudang(); // Pastikan model ini menangani tabel tb_user
    $this->log_activity('Menghapus Foto Profil');

    // Ambil ID user dari form
    $userId = $this->request->getPost('id');

    // Ambil data user dari database
    $userData = $model->getById($userId);

    // Pastikan userData valid
    if ($userData && $userData->foto_profile) {
        // Hapus file gambar dari file system
        $filePath = ROOTPATH . 'public/images/img/' . $userData->foto_profile;
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Update database untuk menghapus nama file gambar
        $userDataUpdate = ['foto_profile' => null];
        $model->edit('tb_user', $userDataUpdate, ['id_user' => $userId]);
    }

    return redirect()->to(base_url('Home/profileadmin'))->with('status', 'Foto profil berhasil dihapus');
}

public function editfotoadmin()
{
    $model = new Gudang(); // Pastikan model ini menangani tabel tb_user
    $this->log_activity('Mengedit Foto');
    
    // Ambil user saat ini dari session
    $userId = session()->get('id_user');
    $userData = $model->getById($userId); // Pastikan ini mengambil data user dengan benar

    // Cek apakah file di-upload
    if ($file = $this->request->getFile('foto')) {
        if ($file->isValid() && !$file->hasMoved()) {
            // Generate nama file baru
            $newFileName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/images/img/', $newFileName); // Simpan ke file system
            
            // Jika ada foto lama, hapus
            if ($userData->foto_profile && file_exists(ROOTPATH . 'public/images/img/' . $userData->foto_profile)) {
                unlink(ROOTPATH . 'public/images/img/' . $userData->foto_profile);
            }
            
            // Update database dengan nama file baru
            $userDataUpdate = ['foto_profile' => $newFileName];
            $model->edit('tb_user', $userDataUpdate, ['id_user' => $userId]);
        }
    }

    return redirect()->to(base_url('Home/profileadmin'))->with('status', 'Foto berhasil diperbarui');
}



    public function aksi_e_profileadmin()
    {
        if (session()->get('id_level') > 0) {
            $model = new Gudang();
            $this->log_activity('Mengedit Profile');
            $cek = $this->request->getPost('username');
            $cek1 = $this->request->getPost('email');
            $id = $this->request->getPost('id');

            $where = array('id_user' => $id); // Jika id_user adalah kunci utama untuk menentukan record


            $isi = array(
                'username' => $cek,
                'email' => $cek1,
            );

            $model->edit('tb_user', $isi, $where);
            return redirect()->to('Home/profileadmin');
            // print_r($yoga);
            // print_r($id);
        } else {
            return redirect()->to('Home/login');
        }
    }
}
