// froala
new FroalaEditor('#froala-editor', {
    toolbarInline: true,
    charCounterCount: false,
    fontSizeSelection: true,
    fontFamilySelection: true,
    imageInsertButtons: ['imageBack', '|', 'imageUpload', 'imageByURL'],
    videoInsertButtons: ['videoByURL'],
    toolbarButtons: {
        moreText: {
            buttons: [
                'bold', 'italic', 'underline', 'textColor', 'backgroundColor',
                'strikeThrough', 'subscript', 'superscript', 'fontSize', 'fontFamily',
            ],
            buttonsVisible: 0
        },
        moreParagraph: {
            buttons: [
                'align', 'formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle',
                'lineHeight', 'outdent', 'indent', 'quote'
            ],
            align: 'left',
            buttonsVisible: 3
        },
        moreRich: {
            buttons: [
                'imageManager', 'insertLink', 'insertImage', 'insertVideo', 'insertTable',
                'emoticons', 'fontAwesome', 'specialCharacters', 'embedly', 'insertHR'
            ],
            align: 'left',
            buttonsVisible: 3
        },
        moreMisc: {
            buttons: [
                'undo', 'redo', 'fullscreen', 'print', 'getPDF',
                'spellChecker', 'selectAll', 'html', 'help'
            ],
            align: 'right',
            buttonsVisible: 2
        }
    },
    toolbarVisibleWithoutSelection: true,

    // #IMAGE MANAGER
    imageManagerPreloader: location.origin + '/assets/dist/img/ring.gif',
    imageManagerLoadURL: location.origin + '/uptdcontent/load_image',
    imageManagerDeleteParams: {
        param: 'src'
    },
    imageManagerDeleteURL: location.origin + '/uptdcontent/delete_image',
    imageManagerPageSize: 10,
    imageManagerScrollOffset: 5,
    // #END|IMAGE MANAGER

    // #IMAGE UPLOADED
    // Set the image upload URL.
    imageUploadURL: location.origin + '/uptdcontent/save_image',
    // Additional upload params.
    imageUploadParams: {
        id: 'my_editor'
    },
    // Set request type.
    imageUploadMethod: 'POST',
    // Set max image size to 3MB.
    imageMaxSize: 1024 * 1024 * 3,
    // Allow to upload PNG and JPG.
    imageAllowedTypes: ['jpeg', 'jpg', 'png'],
    // #END|IMAGE UPLOADED
})

$('#update-maklumat').on('click', function (e) {
    e.preventDefault()
    let data = $('.fr-view')

    $.post({
        url: location.origin + '/maklumat/save',
        data: { data: data.html() },
        dataType: 'json',
        success: function (data) {
            $("#spinner").hide()
            if (data.type == 'success') {
                Lobibox.notify(data.type, {
                    position: 'top right',
                    msg: data.text
                })
                data.html(data.data)
            } else {
                $.each(data.text, function (i, val) {
                    Lobibox.notify(data.type, {
                        position: 'top right',
                        msg: ($.type(i) != 'number' ? `${i} : ` : '') + val
                    })
                })
            }
        }
    })
})
// end froala