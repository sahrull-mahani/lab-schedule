function waitForElm(selector) {
    return new Promise((resolve) => {
        if (document.querySelector(selector)) {
            return resolve(document.querySelector(selector))
        }

        const observer = new MutationObserver((mutations) => {
            if (document.querySelector(selector)) {
                resolve(document.querySelector(selector))
                observer.disconnect()
            }
        })

        observer.observe(document.body, {
            childList: true,
            subtree: true,
        })
    })
}

$('input.search-input').addClass('bg-dark')

// $('#select2-multiple').select2({
//     placeholder: 'Pilih Bahan',
//     allowClear: true
// })
// waitForElm(".select2-selection--multiple").then((elm) => {
//     // $('textarea.select2-search__field').attr('placeholder', 'oko')
//     $('.select2-selection--multiple').css({
//         'height' : '40px',
//         'width' : '200px',
//         'border-bottom-right-radius': '0',
//         'border-top-right-radius': '0',
//     })
// })