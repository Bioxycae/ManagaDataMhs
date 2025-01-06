<?php

// Connection to db
    include "connection.php";

?>



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Management Data</title>

    <!-- Link Icon dan Framework -->
    <link rel="shortcut icon" type="x-icon" href="../img/2.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../frontend/css/bootstrap.min.css">
  </head>
  <body>

    <div class="container">
        <div class="mt-3">
            <h3 class="text-center">Managemen Data Mahasiswa</h3>
        </div>
        

        <div class="card mt-4">
            <!-- <div class="card-header bg-warning-subtle">
                Manajemen Data Mahasiswa
            </div> -->
            
            <div class="card-body">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalInsert">
                    Insert Data
                </button>

                <div class="col-md-6 mx-auto">
                    <form method="POST" action="">
                        <div class="input-group mb-3">
                            <input type="text" name="tcari" class="form-control" placeholder="Cari sesuai NPM / Nama" autocomplete="off">
                            <button class="btn bg-primary-subtle btn-s" name="bsearch" type="submit">🔍</button>
                            <button class="btn btn-danger" name="breset" type="submit">Reset</button>
                        </div>
                    </form>
                </div>

                <table class="table table-bordered table-striped tabel-hover mt-3">
                    <tr class="text-center table-dark">
                        <th class="text-warning">No.</th>
                        <th class="text-warning">NPM</th>
                        <th class="text-warning">Nama Lengkap</th>
                        <th class="text-warning">Alamat</th>
                        <th class="text-warning">Program Studi</th>
                        <th class="text-warning">Action</th>
                    </tr>

                    <?php
                    // Read Data Mahasiswa dari database

                    $no = 1;

                    // Pagination konfigurasi dengan limit per row nya
                    $limit = 5; 
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $start = ($page - 1) * $limit; 

                    // Search Data jika tombol cari di klik dengan batasan limit
                    if(isset($_POST['bsearch'])){
                        $keyword = $_POST['tcari'];
                        $query = "SELECT * FROM tmhs WHERE npm like '%$keyword%' OR nama like '%$keyword%' LIMIT $start, $limit";
                    } else {
                        $query = "SELECT * FROM tmhs ORDER BY id_mhs DESC LIMIT $start, $limit";
                    }

                    // total halaman
                    $totalQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tmhs");
                    $totalData = mysqli_fetch_assoc($totalQuery)['total'];
                    $totalPages = ceil($totalData / $limit);

                    $read = mysqli_query($conn, $query);
                    while( $data = mysqli_fetch_assoc($read) ) :
                    ?>

                    <tr class="">
                        <td class="text-center"><?= $no++; ?></td>
                        <td class=""><?= $data['npm']; ?></td>
                        <td class=""><?= $data['nama']; ?></td>
                        <td class=""><?= $data['alamat']; ?></td>
                        <td class=""><?= $data['prodi']; ?></td>
                        <td class="text-center">
                            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUpdate<?= $no ?>" href="">Update</a>
                            <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDelete<?= $no ?>"  href="">Delete</a>
                        </td>
                    </tr>

                    <!-- Start Modal UPDATE -->
                    <div class="modal fade modal-lg" id="modalUpdate<?= $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Form Data Mahasiswa</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post" action="action.php">
                                    <input type="hidden" name="id_mhs" value="<?= $data['id_mhs']?>" >
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="form_npm" class="form-label">NPM</label>
                                            <input type="text" class="form-control" id="form_npm" placeholder="Masukkan NPM Anda" name="tnpm" value="<?= $data['npm']?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" id="form_nama" placeholder="Masukkan Nama Anda" name="tnama" value="<?= $data['nama']?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="form_alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" id="form_alamat" rows="3" placeholder="Masukkan Alamat Anda" name="talamat"><?= $data['alamat']?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="form_prodi" class="form-label">Program Studi</label>
                                            <select class="form-select" name="tprodi" id="form_prodi">
                                                <option value="<?= $data['prodi']?>"><?= $data['prodi']?></option>
                                                <option value="S1 - Informatika">S1 - Informatika</option>
                                                <option value="S1 - Psikologi">S1 - Psikologi</option>
                                                <option value="S1 - Teknik Sipil">S1 - Teknik Sipil</option>
                                                <option value="S1 - Sistem Informasi">S1 - Sistem Informasi</option>
                                                <option value="S1 - Sistem Komputer">S1 - Sistem Komputer</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success" name="bupdate">Save</button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Last Modal -->

                    <!-- Start Modal DELETE -->
                    <div class="modal fade modal" id="modalDelete<?= $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Hapus Data Mahasiswa</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post" action="action.php">
                                    <input type="hidden" name="id_mhs" value="<?= $data['id_mhs']?>" >
                                    <div class="modal-body">
                                        
                                        <h5 class="text-center">Apakah Anda yakin akan menghapus data ini?
                                            <span class="text-danger text-center"><?= $data['npm'] ?> - <?= $data['nama'] ?></span>
                                        </h5>
                                        

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success" name="bdelete">Delete</button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Last Modal -->

                    <?php
                        endwhile;
                    ?>
                </table>    

                <!-- untuk membuat pagination -->
                <nav>
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="index.php?page=<?= $page - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php for($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="index.php?page=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="index.php?page=<?= $page + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>

                <!-- Start Modal INSERT -->
                <div class="modal fade modal-lg" id="modalInsert" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Form Data Mahasiswa</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="post" action="action.php">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="form_npm" class="form-label">NPM</label>
                                        <input type="text" class="form-control" id="form_npm" placeholder="Masukkan NPM Anda" name="tnpm">
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="form_nama" placeholder="Masukkan Nama Anda" name="tnama">
                                    </div>
                                    <div class="mb-3">
                                        <label for="form_alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="form_alamat" rows="3" placeholder="Masukkan Alamat Anda" name="talamat"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="form_prodi" class="form-label">Program Studi</label>
                                        <select class="form-select" name="tprodi" id="form_prodi">
                                            <option>Pilih Program Studi</option>
                                            <option value="S1 - Informatika">S1 - Informatika</option>
                                            <option value="S1 - Psikologi">S1 - Psikologi</option>
                                            <option value="S1 - Teknik Sipil">S1 - Teknik Sipil</option>
                                            <option value="S1 - Sistem Informasi">S1 - Sistem Informasi</option>
                                            <option value="S1 - Sistem Komputer">S1 - Sistem Komputer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success" name="binsert">Save</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Last Modal -->


            </div>
        </div>
    </div>
   







    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../frontend/js/bootstrap.bundle.min.js">
  </body>
</html>