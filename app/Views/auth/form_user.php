<?= form_open("auth/save", array("class" => "form-horizontal")); ?>
<div class="modal-body">
    <?= form_label(lang('Auth.create_user_name_label'), 'id_peg', array("class" => "col-sm-3 col-form-label")); ?>
    <div class="input-group input-group-outline mb-3">
        <?php $defaults = array('none' => 'Pilih Pegawai');
        $dd = $action !== 'update' ? ddNotInUser() :  pegawai();
        echo form_dropdown('id_peg', $defaults + $dd, isset($user->id_peg) ? $user->id_peg : '', 'class="form-control" id="id_peg"'); ?>
    </div>
    <?php if ($identity_column !== 'email') { ?>
        <?= form_label(lang('Auth.create_user_identity_label'), 'identity', array("class" => "col-sm-3 col-form-label")); ?>
        <div class="input-group input-group-outline mb-3">
            <input type="text" name="identity" value="<?= isset($user->username) ? $user->username : ''; ?>" id="identity" class="form-control" required="required" />
        </div>
        <?= '<p>' . \Config\Services::validation()->getError('identity') . '</p>'; ?>
    <?php } ?>
    <?= form_label(lang('Auth.create_user_phone_label'), 'phone', array("class" => "col-sm-3 col-form-label")); ?>
    <div class="input-group input-group-outline mb-3">
        <input type="email" name="email" value="<?= isset($user->email) ? $user->email : ''; ?>" id="email" class="form-control" required="required" />
    </div>
    <?= form_label(lang('Auth.create_user_phone_label'), 'phone', array("class" => "col-sm-3 col-form-label")); ?>
    <div class="input-group input-group-outline mb-3">
        <input type="text" name="phone" value="<?= isset($user->phone) ? $user->phone : '08'; ?>" id="phone" class="form-control" required="required" />
    </div>
    <?php if ($action == 'update') : ?>
        <label for="jenis_user">Jenis User **</label>
        <div class="input-group input-group-outline mb-3">
            <?php $no = 1;
            foreach ($groups as $group) :
                $gID = $group->id;
                $checked = null;
                foreach ($currentGroups as $grp) {
                    if ($gID == $grp->id) {
                        $checked = ' checked="checked"';
                        break;
                    }
                } ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="groups[]" value="<?= $group->id; ?>" <?= $checked; ?> id="customCheckbox<?= $no; ?>" />
                    <label class="custom-control-label" for="customCheckbox<?= $no; ?>"><?= htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8'); ?></label>
                </div>
            <?php $no++;
            endforeach ?>
        </div>
    <?php endif ?>
    <?= form_label(lang('Auth.create_user_password_label'), 'password', array("class" => "col-sm-3 col-form-label")); ?>
    <div class="input-group input-group-outline mb-3">
        <input type="password" name="password" value="" id="password" class="form-control" <?= isset($required) ? $required : ''; ?> />
    </div>
    <?= form_label(lang('Auth.create_user_password_confirm_label'), 'password_confirm', array("class" => "col-sm-3 col-form-label")); ?>
    <div class="input-group input-group-outline mb-3">
        <input type="password" name="password_confirm" value="" id="password_confirm" class="form-control" <?= isset($required) ? $required : ''; ?> />
    </div>
</div>
<div class="modal-footer">
    <input type="hidden" name="action" value="<?= $action; ?>" />
    <input type="hidden" name="id" value="<?= isset($user->id) ? $user->id : ''; ?>" />
    <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-send"></i> <?= $btn; ?></a></button>
</div>
<?= form_close(); ?>
<script type="text/javascript">
    $('form').on('blur', 'input[required], input.optional, select.required', validator.checkField).on('change',
        'select.required', validator.checkField).on('keypress', 'input[required][pattern]', validator.keypress);
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
                    Lobibox.notify(data.type, {
                        position: 'top right',
                        msg: data.text,
                        icon: data.type
                    });
                    $('#modal_content').modal('hide')
                    $('#table').bootstrapTable('refresh');
                },
                error: function(jqXHR, exception, thrownError) {
                    swal({
                        title: "Error code" + jqXHR.status,
                        html: thrownError + ", " + exception,
                        type: "error"
                    }).then(function() {
                        $("#spinner").hide();
                    });
                }
            });
        }
    });
</script>