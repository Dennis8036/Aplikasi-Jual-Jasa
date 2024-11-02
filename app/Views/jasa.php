<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Jasa</title>
    <!-- Include your CSS files here -->
    
    <style>
        .card-container {
            margin: 20px; /* Adjust margin as needed */
            padding: 20px; /* Add padding to the card */
            border-radius: 8px; /* Optional: for rounded corners */
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); /* Optional: for shadow effect */
        }

        .service-card {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: box-shadow 0.3s ease;
        }

        .service-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .service-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .service-body {
            padding: 15px;
        }

        .service-body h5 {
            font-size: 18px;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .service-body .price {
            color: #28a745;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .service-body .rating {
            color: #f5c518; /* Gold for star rating */
            display: inline-block;
            margin-right: 10px;
        }

        .service-body .review-count {
            color: #6c757d;
            font-size: 0.875rem;
        }

        .author-info {
            display: flex;
            align-items: center;
            padding: 15px;
            border-top: 1px solid #e0e0e0;
        }

        .author-info img {
            border-radius: 50%;
            width: 30px;
            height: 30px;
            margin-right: 10px;
        }

        .author-info .author-name {
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <!-- Sidebar start -->
    <!-- Your sidebar code here -->
    <!-- Sidebar end -->

    <!-- Content body start -->
    <div class="container">
        <!-- Tombol Tambah -->
        <a href="<?= base_url('Home/t_jasa') ?>">
            <button class="btn btn-success mb-3">Tambah</button>
        </a>

        <!-- Row for service cards -->
        <div class="row">
            <?php 
            $no = 1;
            foreach ($jasa as $item) { ?>
                <div class="col-md-4">
                    <!-- Each service card -->
                     <a href="<?= base_url('Home/detailjasa/' . $item->id_jasa) ?>" style="text-decoration: none; color: inherit;">
                    <div class="card service-card">
                        <!-- Gambar -->
                        <img src="<?= base_url('images/img/' . $item->gambar) ?>" class="service-image" alt="Gambar">

                        <!-- Service details -->
                        <div class="service-body">
                            <!-- Nama -->
                            <h5 style="text-align: center;"><?= $item->nama ?></h5>
<br>
                            <!-- Harga -->
                            <div class="text-muted">Mulai dari</div>
                            <div class="price" style="font-size: 20px; color: black;">Rp <?= number_format($item->harga, 0, ',', '.') ?></div>

                            <!-- Ulasan dan rating -->
                            <div class="rating">⭐ <?= number_format($item->rating, 1) ?></div>
                            <div class="review-count">(<?= $item->ulasan ?> Ulasan)</div>
                        </div>

                        <!-- Informasi Author -->
                        <div class="author-info">
                            <img src="<?= base_url('images/img/' . (!empty($item->foto_profile) ? $item->foto_profile : 'fotouser.jfif')) ?>" alt="Author">

                            <div class="author-name"><?= $item->username ?></div>
                        </div>
</a>
                        <!-- Tombol Aksi -->
                        <div class="p-2">
                            <?php if(session()->get('id_level') == 1 || session()->get('id_level') == 2) { ?>
                                <button class="btn btn-primary ti-pencil" 
                                    data-toggle="modal" 
                                    data-target="#editModal" 
                                    data-id="<?= $item->id_jasa ?>"
                                    data-nama="<?= $item->nama ?>"
                                    data-deskripsi="<?= $item->deskripsi ?>"
                                    data-harga="<?= $item->harga ?>"
                                    data-gambar="<?= $item->gambar ?>"
                                    data-ulasan="<?= $item->ulasan ?>"
                                    data-kategori="<?= $item->kategori ?>"
                                    data-status="<?= $item->status ?>"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="Edit"></button>
                                
                                <a href="<?= base_url('Home/hapus_jasa/'.$item->id_jasa)?>">
                                    <button class="btn btn-danger ti-trash"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="Hapus"></button>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Jasa</h5>
                    <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="<?= base_url('Home/aksi_e_jasa') ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" value="" id="id" name="id_jasa">
                        <div class="mb-3">
                            <label for="edit_nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" value="" id="edit_nama" name="nama" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit_harga" class="form-label">Harga</label>
                            <input type="text" class="form-control" value="" id="edit_harga" name="harga" required>
                        </div>
                                                <div class="mb-3">
                            <label for="edit_gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" id="edit_gambar" name="gambar">
                        </div>
                                                <div class="mb-3">
                            <label for="edit_ulasan" class="form-label">Ulasan</label>
                            <input type="text" class="form-control" value="" id="edit_ulasan" name="ulasan" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_kategori" class="form-label">Kategori</label>
                            <input type="text" class="form-control" value="" id="edit_kategori" name="kategori" required>
                        </div>

                                                <div class="mb-3">
                            <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="edit_deskripsi" name="deskripsi" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_status" class="form-label">Status</label>
                            <select class="form-control" id="edit_status" name="status" required>
                                <option value="Tersedia">Tersedia</option>
                                <option value="Habis">Habis</option>
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include your JavaScript files here -->
    <script src="path/to/your/scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="path/to/your/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            $('#editModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var nama = button.data('nama');
                var deskripsi = button.data('deskripsi');
                var harga = button.data('harga');
                var ulasan = button.data('ulasan');
                var kategori = button.data('kategori');
                var status = button.data('status');

                var modal = $(this);
                modal.find('#id').val(id);
                modal.find('#edit_nama').val(nama);
                modal.find('#edit_deskripsi').val(deskripsi);
                modal.find('#edit_harga').val(harga);
                modal.find('#edit_ulasan').val(ulasan);
                modal.find('#edit_kategori').val(kategori);
                modal.find('#edit_status').val(status);
            });
        });
    </script>
</body>
</html>
