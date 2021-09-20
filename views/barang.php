<?php
include "models/m_barang.php";

$brg = new Barang($connection);
?>

<div class="row">
          <div class="col-lg-12">
            <h1>Barang <small>Data Barang</small></h1>
            <ol class="breadcrumb">
              <li><a href="index.html"><i class="icon-dashboard"></i> Barang</a></li>
            </ol>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">

          <div class="table-respondive">
                <table class="table table-bordered table-hover table-striped">
                    <tr>
                        <th>No.</th>
                        <th>Nama Barang</th>
                        <th>Harga Barang</th>
                        <th>Stok barang</th>
                        <th>Gambar Barang</th>
                        <th>Opsi</th>
                    </tr>
                    <?php
                    $no = 1;
                    $tampil = $brg->tampil();
                    while($data = $tampil->fetch_object()){
                    ?>
                    <tr>
                        <td align="center"><?php echo $no++."."; ?></td>
                        <td><?php echo $data->nama_brg; ?></td>
                        <td><?php echo $data->harga_brg; ?></td>
                        <td><?php echo $data->stok_brg; ?></td>
                        <td align="center">
                          <img src="assets/img/barang/<?php echo $data->gbr_brg; ?>" width="70px">
                        </td>
                        <td align="center">
                            <a id="edit_brg"data-toggle="modal" data-target="#edit" data-id="<?php echo $data->id_brg; ?>" data-nama="<?php echo $data->nama_brg; ?>" data-harga="<?php echo $data->harga_brg; ?>" data-stok="<?php echo $data->stok_brg; ?>" data-gbr="<?php echo $data->gbr_brg; ?>">
                             <button class="btn btn-info btn-xs"><i class="fa fa-edit"></i>Edit</button></a>
                            <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i>Hapus</button>
                        </td>

                    </tr>
                    <?php
                    }?>

                </table>
            </div>

            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah">Tambah Data</button>

            <div id="tambah" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tambah Data Barang</h4>
                  </div>
                  <form action="" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                      <div class="form-group">
                        <label class="control-label" for="nm_brg">Nama Barang</label>
                        <input type="text" name="nm_brg" class="form-control" id="nm_brg" required>
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="hrg_brg">Harga Barang</label>
                        <input type="number" name="hrg_brg" class="form-control" id="hrg_brg" required>
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="stok_brg">Stok Barang</label>
                        <input type="number" name="stok_brg" class="form-control" id="stok_brg" required>
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="gbr_brg">Gambar Barang</label>
                        <input type="file" name="gbr_brg" class="form-control" id="gbr_brg" required>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="reset" class="btn btn-danger">Reset</button>
                      <input type="submit" class="btn btn-success" name="tambah" value="simpan">
                    </div>
                  </form>

                  <?php
                    if(@$_POST['tambah']){
                      $nm_brg = $connection->conn->real_escape_string($_POST['nm_brg']);
                      $stok_brg = $connection->conn->real_escape_string($_POST['stok_brg']);
                      $hrg_brg = $connection->conn->real_escape_string($_POST['hrg_brg']);

                      $extensi = explode(".", $_FILES['gbr_brg']['name']);
                      $gbr_brg = "brg-".round(microtime(true)).".".end($extensi);
                      $sumber = $_FILES['gbr_brg']['tmp_name'];

                      $upload = move_uploaded_file($sumber, "assets/img/barang/".$gbr_brg);
                      if($upload){
                        $brg->tambah($nm_brg, $hrg_brg, $stok_brg, $gbr_brg);
                        header("location: ?page=barang");
                      } else{
                        echo "<script>alert('Upload Gambar gagal ! ')</script>";
                      }
                    }
                  ?>
                </div>
              </div>
            </div>



            <div id="edit" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Data Barang</h4>
                  </div>
                  <form id="form" enctype="multipart/form-data">
                    <div class="modal-body" id="modal-edit">
                      <div class="form-group">
                        <label class="control-label" for="nm_brg">Nama Barang</label>
                        <input type= "hidden" name="id_brg" id="id_brg" >
                        <input type="text" name="nm_brg" class="form-control" id="nm_brg" required>
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="hrg_brg">Harga Barang</label>
                        <input type="number" name="hrg_brg" class="form-control" id="hrg_brg" required>
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="stok_brg">Stok Barang</label>
                        <input type="number" name="stok_brg" class="form-control" id="stok_brg" required>
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="gbr_brg">Gambar Barang</label>
                        <div style="padding-bottom:5px">
                          <img src=""  width="80px" id="pict">
                        </div>
                        <input type="file" name="gbr_brg" class="form-control" id="gbr_brg">
                      </div>
                    </div>
                    <div class="modal-footer">
                      
                      <input type="submit" class="btn btn-success" name="edit" value="simpan">
                    </div>
                  </form>

                 

                </div>
              </div>
            </div>
            <script src="assets/js/jquery-1.10.2.js"></script>
            <script type="text/javascript">
            $(document).on("click", "#edit_brg", function() {
                var idbrg = $(this).data('id');
                var nmbrg = $(this).data('nama');
                var hrgbrg = $(this).data('harga');
                var stokbrg = $(this).data('stok');
                var gbrbrg = $(this).data('gbr');
                $("#modal-edit #nm_brg").val(nmbrg);
                $("#modal-edit #id_brg").val(idbrg);
                $("#modal-edit #hrg_brg").val(hrgbrg);
                $("#modal-edit #stok_brg").val(stokbrg);
                $("#modal-edit #pict").attr("src", "assets/img/barang/"+gbrbrg);
            })

            $(document).ready(function(e) {
                $("#form").on("submit", (function(e) {
                  e.preventDefault();
                  $.ajax({
                      url : 'models/proses_edit_barang.php',
                      type : 'POST',
                      data : new FormData(this),
                      contentType : false,
                      cache : false,
                      processData : false,
                      success : function(msg) {
                        $('.table').html(msg);
                      }
                  });
                }));
            })
          </script>
          </div>
        </div>