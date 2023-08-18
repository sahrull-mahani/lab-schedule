<?= form_open('mahasiswa/save', array('class' => 'form-horizontal')); ?>
<div class="modal-body">
    <?php foreach ($form_input as $form) : 
        echo $form;
    endforeach;
    ?>
</div>
<div class="modal-footer">
    <input type='hidden' name='action' value='<?= $action; ?>' />
    <button type='submit' class='btn btn-primary pull-right'><?= $btn; ?></a></button>
</div>
<?php echo form_close(); ?>
<script type='text/javascript'>
$('form').on('blur', 'input[required], input.optional, select.required', validator.checkField).on('change', 'select.required', validator.checkField).on('keypress', 'input[required][pattern]', validator.keypress);
$('.multi.required').on('keyup blur', 'input', function() {
    validator.checkField.apply($(this).siblings().last()[0]);
});
$('form').submit(function(e) {
    e.preventDefault();
    if (!validator.checkAll($(this))) {
        return false;
    } else {
        $.ajax({
            url: $(this).attr('action'),
            type: 'post',
            data: $('form').serialize(),
            success: function(response) {
                var data = $.parseJSON(response);
                Lobibox.notify(data.type, {
                    position: 'top right',
                    msg: data.text
                });
                $('#modal_content').modal('hide');
                $('#table').bootstrapTable('refresh');
            },
            error: function(jqXHR, exception, thrownError) {
                Lobibox.notify('error', {
                    position: 'top right',
                    msg: 'Error code' + jqXHR.status + ', ' + thrownError + ', ' + exception
                });
                $('#spinner').hide();
            }
        });
    }
});
</script>