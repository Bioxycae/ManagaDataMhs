<?php

// Connection to db
    include "connection.php";

// Menguji tombol save sewatku di klik
    if(isset($_POST['binsert'])){
    // Insert New Data
        $save = mysqli_query($conn, "INSERT INTO tmhs(npm, nama, alamat, prodi)
                                     VALUES('$_POST[tnpm]',
                                            '$_POST[tnama]',
                                            '$_POST[talamat]',
                                            '$_POST[tprodi]')" );


    // Kalo insert berhasil maka lakukan ini
        if($save){
            echo "<script>
                    alert('Data Berhasil di TAMBAH!')
                    document.location='index.php';
                  </script>";
        }
        else{
            echo "<script>
            alert('Data Gagal di TAMBAH!')
            document.location='index.php';
          </script>";
        }
    }

// Menguji tombol save  saat update sewatku di klik
    if(isset($_POST['bupdate'])){
    // Update Data
        $update = mysqli_query($conn, "UPDATE tmhs SET npm = '$_POST[tnpm]',
                                                       nama = '$_POST[tnama]',
                                                       alamat = '$_POST[talamat]',
                                                       prodi = '$_POST[tprodi]' 
                                                 WHERE id_mhs = '$_POST[id_mhs]'
                                                     ");


    // Kalo update berhasil maka lakukan ini
        if($update){
            echo "<script>
                    alert('Data Berhasil di UBAH!')
                    document.location='index.php';
                  </script>";
        }
        else{
            echo "<script>
            alert('Data Gagal di UBAH!')
            document.location='index.php';
          </script>";
        }
    }

// Menguji tombol delete saat mengahpus data
    if(isset($_POST['bdelete'])){
    // DELETE Data
        $Delete = mysqli_query($conn, "DELETE FROM tmhs WHERE id_mhs='$_POST[id_mhs]' ");


    // Kalo DELETE berhasil maka lakukan ini
        if($Delete){
            echo "<script>
                    alert('Data Berhasil di HAPUS!')
                    document.location='index.php';
                  </script>";
        }
        else{
            echo "<script>
            alert('Data Gagal di HAPUS!')
            document.location='index.php';
          </script>";
        }
    }

?>