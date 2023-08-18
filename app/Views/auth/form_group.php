<?= form_open("auth/save_groups", array("class" => "form-horizontal")); ?>
<div class="modal-body">
    <?= form_label(lang('Auth.create_group_name_label'), 'group_name', array("class" => "col-sm-3 control-form-label")); ?>
    <div class="input-group input-group-outline mb-3">
        <input type="text" name="group_name" value="<?= isset($group_name) ? $group_name : ''; ?>" id="group_name" class="form-control" required="required" <?= isset($readonly) ? $readonly : ''; ?> />
    </div>

    <?= form_label(lang('Auth.create_group_desc_label'), 'description', array("class" => "col-sm-3 control-form-label")); ?>
    <div class="input-group input-group-outline mb-3">
        <input type="text" name="description" value="<?= isset($group_description) ? $group_description : ''; ?>" id="description" class="form-control" required="required" />
    </div>
</div>
<div class="modal-footer">
    <input type="hidden" name="action" value="<?= $action; ?>" />
    <input type="hidden" name="id" value="<?= isset($id) ? $id : ''; ?>" />
    <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-send"></i> <?= $btn; ?></a></button>
</div>
<?= form_close(); ?>
<script type="text/javascript">
    $('form').on('blur', 'input[required], input.optional, select.required', validator.checkField).on('change', 'select.required', validator.checkField).on('keypress', 'input[required][pattern]', validator.keypress);
    $('.multi.required').on('keyup blur', 'input', function() {
        validator.checkField.apply($(this).siblings().last()[0]);
    });
    $('form').submit(function(e) {
        e.preventDefault();
        if (!validator.checkAll($(this))) {
            false;
        } else {
            $.ajax({
                url: $(this).attr("action"),
                type: 'post',
                data: $("form").serialize(),
                success: function(response) {
                    var data = $.parseJSON(response);
                    Swal.fire({
                        position: 'top-end',
                        icon: data.type,
                        title: data.title,
                        text: data.text,
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        $('#modal_content').modal('hide')
                    })
                },
                error: function(jqXHR, exception, thrownError) {
                    Swal.fire({
                        title: "Error code" + jqXHR.status,
                        html: thrownError + ", " + exception,
                        icon: "error"
                    }).then((result) => {
                        $("#spinner").hide();
                    });
                }
            });
        }
    });
</script>