<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Mapel</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-users"></i></a></li>
                    <li class="breadcrumb-item"><a href="#!">Mapel</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->
<!-- [ Main Content ] start -->
<div class="row mapel-isi">
    <!-- [ static-layout ] start -->

    <div class="col-sm-12">
        <div class="card">
            <div class="card-header text-center">
                <h3 class="text-primary"><strong>Mapel</strong></h3>
            </div>
            <div class="card-body">
                <div class="col-sm-12 mb-3">
                    <span>
                        <h5>Nama : </h5>
                        <p><?= $guru->nama; ?></p>
                    </span>
                    <h5>Alamat : </h5>
                    <p><?= $guru->alamat; ?></p>
                    <h5>Email : </h5>
                    <p><?= $guru->email; ?></p>
                </div>
                <hr>
                <div class="float-right mb-3">
                    <button type="button" class="btn btn-primary has-ripple" id="mapelAdd"><i class="feather mr-2 icon-plus"></i>Tambah Data<span class="ripple ripple-animate" style="height: 112.65px; width: 112.65px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255) none repeat scroll 0% 0%; opacity: 0.4; top: -38.825px; left: -2.85833px;"></span></button>

                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID</th>
                                <th>mapel</th>
                                <th>kelas</th>
                                <th>sekolah</th>
                                <th>created</th>
                                <th>updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- [ static-layout ] end -->
</div>
<div class="modal fade bd-example-modal-xl" id="myModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title judul">Mapel</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="validation">

                </div>
                <form id="submitForm">
                    <div class="form-group fill">
                        <input type="hidden" name="id_mapel_guru" id="id">
                        <label for="Nama">Nama</label>
                        <input type="hidden" class="form-control" id="guru_profile_id" name="guru_profile_id" value="<?= $guru->id_guru_profile; ?>">
                        <input type="text" class="form-control" id="Nama" placeholder="Nama" value="<?= $guru->nama; ?>" readonly>
                    </div>
                    <div class="form-group fill">
                        <label for="mapel">mapel</label>
                        <input type="text" class="form-control" id="mapel" name="mapel" placeholder="Mapel">
                        <small>isikan nama kelas jika anda guru SD, contoh: Kelas 1, IPA, Fisika, Sejarah, dll</small>
                    </div>
                    <div class="form-group fill">
                        <label for="kelas">kelas</label>
                        <select name="kelas_id" id="kelas" class="form-control">
                            <option value="">--pilih salah satu--</option>
                            <?php foreach ($kelas as $kel) { ?>
                                <option value="<?= $kel->id_kelas; ?>"><?= $kel->nama_kelas; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group fill">
                        <label for="sekolah">Sekolah</label>
                        <input type="text" class="form-control" id="sekolah" name="sekolah" placeholder="sekolah">
                    </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary reset" id="reset">Reset</button>
                <button type="button" class="btn btn-success simpan" id="save">Submit</button>
                <button type="button" class="btn btn-danger tutup" id="close">Close</button>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const site_url = "<?= site_url('mapel/'); ?>";
        $('.mapel-isi').on('click', '#mapelAdd', function() {
            $('.judul').html('Tambah mapel');
            $('.simpan').html('Tambah Data');
            $('.simpan').attr('id', 'add');
            $("#myModal").modal('show');
            $('.validation').html(null);

        });

        $('.mapel-isi').on('click', '.update', function() {
            $('.judul').html('Update mapel');
            $('.simpan').html('Update Data');
            $('.simpan').attr('id', 'update');
            $("#myModal").modal('show');
            $('.validation').html(null);

            let id = $(this).attr('value');

            $.ajax({
                type: "GET",
                url: site_url + "get",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(response) {
                    $('#id').val(response.id_mapel);
                    $('#username').val(response.username);
                    $('#name').val(response.name);
                }
            });

        });


        $('#myModal').on('click', '.simpan', function() {
            let url = '';
            let datastring = $("#submitForm").serialize();

            if ($(this).attr('id') == 'update') {
                url = 'update';
            } else if ($(this).attr('id') == 'add') {
                url = 'add';
            }
            $.ajax({
                type: "POST",
                url: site_url + url,
                data: datastring,
                dataType: "JSON",
                success: function(response) {
                    if (response >= 0) {
                        reloadTable();
                        $("#myModal").modal('hide');
                        $('#submitForm')[0].reset();
                        $('.validation').html(null);
                    } else {
                        $('.validation').html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    ${response}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>`);
                    }
                }
            });
        });

        $('.mapel-isi').on('click', '.delete', function() {
            let id = $(this).attr('value');

            console.log(id);

            swal({
                    title: "Apakah anda yakin?",
                    text: "data akan terkapus secara permanent!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "POST",
                            url: site_url + "delete",
                            data: {
                                id: id
                            },
                            dataType: "JSON",
                            success: function(response) {
                                reloadTable();
                                swal("Selamat, file berhasil di hapus!", {
                                    icon: "success",
                                });
                            }
                        });
                    } else {
                        swal("Data batal di hapus!");
                    }
                });
        });

        let table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= site_url('mapel/getAjax/') . $guru->id_guru_profile; ?>',
                type: 'POST'
            },
            columnDefs: [{
                    targets: [-1],
                    className: 'text-center'
                },
                {
                    targets: [0, -2, -1],
                    orderable: false
                }
            ]
        });

        $('.tutup-modal').on('click', function() {
            $('#submitForm')[0].reset();
        });

        $('.tutup').on('click', function() {
            $('#submitForm')[0].reset();
            $("#myModal").modal('hide');
            $('.validation').html(null);
        });

        $('#myModal').on('click', '.reset', function() {
            $('#submitForm')[0].reset();
            $('.validation').html(null);
        });

        function reloadTable() {
            table.ajax.reload();
        }
    })
</script>