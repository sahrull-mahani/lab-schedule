<div class="modal-body">
    <a href="<?= site_url('auth/create_group'); ?>" class="btn btn-primary btn-sm create-groups mb-3"><i class="fa fa-plus"></i> Create</a>
    <table class="table table-border table-sm">
        <tr>
            <th style="width: 10px">No</th>
            <th>Groups</th>
            <th>Groups Description</th>
            <th style="width: 200px">Action</th>
        </tr>
        <?php $no = 1;
        foreach ($groups as $rows) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $rows->name; ?></td>
                <td><?= $rows->description; ?></td>
                <td>
                    <a href="<?= site_url('auth/edit_group/' . $rows->id); ?>" class="btn btn-info btn-sm edit-groups"><i class="fa fa-edit"></i> Edit</a>
                    <a href="<?= site_url('auth/save_groups'); ?>" data="<?= $rows->id; ?>" class="btn btn-danger btn-sm del-groups"><i class="fa fa-trash"></i> Del</a>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
</div>
<div class="modal-footer">
</div>
<script type="text/javascript">
    $('a.create-groups').bind('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('href'),
            type: 'GET',
            dataType: "html",
            cache: true,
            success: function(response) {
                var data = $.parseJSON(response);
                $('#modal_content').modal({
                    backdrop: 'static'
                })
                $('.isi-modal').html(data.html)
                $('.modal-title').html(data.modal_title)
                $('#modal-size').addClass(data.modal_size)
            },
            error: function(jqXHR, exception, thrownError) {
                ajax_error_handling(jqXHR, exception, thrownError);
            }
        });
    });
    $('a.edit-groups').bind('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('href'),
            type: 'GET',
            dataType: "html",
            cache: true,
            success: function(response) {
                var data = $.parseJSON(response);
                $('#modal_content').modal({
                    backdrop: 'static'
                })
                $('.isi-modal').html(data.html)
                $('.modal-title').html(data.modal_title)
                $('#modal-size').addClass(data.modal_size)
            },
            error: function(jqXHR, exception, thrownError) {
                ajax_error_handling(jqXHR, exception, thrownError);
            }
        });
    })
    $('a.del-groups').bind('click', function(e) {
        e.preventDefault();
        var id = $(this).attr('data');
        Swal.fire({
            title: 'Delete?',
            text: "Anda yakin? Bila dihapus data tidak akan bisa dikembalikan..! ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: $(this).attr('href'),
                    type: 'post',
                    data: {
                        id: id,
                        action: 'delete'
                    },
                    success: function(response) {
                        var data = $.parseJSON(response);
                        Lobibox.notify(data.type, {
                            position: 'top right',
                            msg: data.text,
                            icon: data.type
                        });
                        $('#table').bootstrapTable('refresh');
                    },
                    error: function(jqXHR, exception, thrownError) {
                        ajax_error_handling(jqXHR, exception, thrownError);
                    }
                });
            }
        })
    })
</script>