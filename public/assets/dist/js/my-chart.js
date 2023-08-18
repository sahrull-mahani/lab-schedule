// Mixed chart
// CHART DEFAULT
const options = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: true,
            position: 'bottom',
        }
    },
    interaction: {
        intersect: false,
        mode: 'index',
    },
    scales: {
        y: {
            grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [5, 5]
            },
            ticks: {
                display: true,
                padding: 10,
                color: '#999',
                font: {
                    size: 13,
                    family: "Open Sans",
                    style: 'normal',
                    lineHeight: 2
                },
            }
        },
        x: {
            grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: true,
                borderDash: [5, 5]
            },
            ticks: {
                display: true,
                color: '#999',
                padding: 10,
                font: {
                    size: 11,
                    family: "Open Sans",
                    style: 'bold',
                    lineHeight: 0
                },
            }
        },
    },
}//options chart default

const data = {
    labels: ['Minggu 1', 'Minggu 2'],
    datasets: [
        {
            type: 'bar',
            label: 'Nama',
            weight: 5,
            borderWidth: 0,
            borderRadius: 4,
            backgroundColor: '#ff0000',
            fill: false,
            maxBarThickness: 35,
            data: [12000, 13000],
        }
    ],
}

const config = {
    data,
    options: options,
}//config chart default

const mychart = new Chart($('#mixed-chart'), config) // init chart
// CHART DEFAULT

const $month = $('#month')
const $year = $('#tahun')
const $selected_bahan = $('#select-bahan')
const $bahan = $('#bahan')

$.get({
    url: location.origin + '/grafik/bahan/' + `${$bahan.val()}/${$month.val()}/${$year.val()}`,
    dataType: 'json',
    success: function (res) {
        if (res !== 404) {
            $('#select-bahan').empty()
            $.each(res, function (i, val) {
                $("#select-bahan").append(`<option value="${val.nama_barang}">${val.nama_barang}</option>`)
            })
        }
    }
})
$bahan.on('change', function () {
    let val = $(this).val()
    $.get({
        url: location.origin + '/grafik/bahan/' + `${val}/${$month.val()}/${$year.val()}`,
        dataType: 'json',
        success: function (res) {
            $('#select-bahan').empty()
            if (res !== 404) {
                $.each(res, function (i, val) {
                    $("#select-bahan").append(`<option value="${val.nama_barang}">${val.nama_barang}</option>`)
                })
            } else {
                mychart.update()
            }
        }
    })
})
$month.on('change', function () {
    let val = $(this).val()
    $.get({
        url: location.origin + '/grafik/bahan/' + `${$bahan.val()}/${val}/${$year.val()}`,
        dataType: 'json',
        success: function (res) {
            $('#select-bahan').empty()
            if (res !== 404) {
                $.each(res, function (i, val) {
                    $("#select-bahan").append(`<option value="${val.nama_barang}">${val.nama_barang}</option>`)
                })
            } else {
                mychart.update()
            }
        }
    })
})
$year.on('change', function () {
    let val = $(this).val()
    $.get({
        url: location.origin + '/grafik/bahan/' + `${$bahan.val()}/${$month.val()}/${val}`,
        dataType: 'json',
        success: function (res) {
            $('#select-bahan').empty()
            if (res !== 404) {
                $.each(res, function (i, val) {
                    $("#select-bahan").append(`<option value="${val.nama_barang}">${val.nama_barang}</option>`)
                })
            } else {
                mychart.update()
            }
        }
    })
})

// start chart
filter($year.val(), $month.val())

// change bila ada perubahan
$month.on('change', function () {
    filter($year.val(), $(this).val())
})
// change bila ada perubahan
$year.on('change', function () {
    filter($(this).val(), $month.val())
})
// change bila ada perubahan
$selected_bahan.on('change', function () {
    filter($year.val(), $month.val(), $(this).val())
})

function filter(year, month, bahans = null) {
    var result
    $.post({
        url: location.origin + '/grafik/inflasi_barang',
        dataType: 'json',
        data: { tahun: year, bulan: month, bahan: bahans },
        async: false,
        success: function (data) {
            result = data.hasil
            nama = data.nama
        }
    })

    var minggu = []
    var harga = []
    $.each(result, function (i, val) {
        // console.log("Outside ajax: " + (val != null ? val.harga : null))
        i++
        minggu.push(`Minggu ${i}`)
        let newharga = val != null ? val.harga.toString() : '0'
        newharga = newharga.split(',')
        harga.push(newharga)
    })

    var newdatasets = []
    $.each(nama, function (i, nm) {
        const newdataset = {
            type: 'bar',
            label: nm.nama_barang,
            weight: 5,
            borderWidth: 0,
            borderRadius: 4,
            backgroundColor: `#${Math.floor(Math.random() * 16777215).toString(16)}`,
            fill: false,
            maxBarThickness: 35,
            data: [(harga[0] ? harga[0][i] : ''), (harga[1] ? harga[1][i] : ''), (harga[2] ? harga[2][i] : ''), (harga[3] ? harga[3][i] : ''), (harga[4] ? harga[4][i] : ''), (harga[5] ? harga[5][i] : '')],
        }
        newdatasets.push(newdataset)
    })

    const newdata = {
        labels: minggu,
        datasets: newdatasets,
    }
    mychart.config.data = newdata

    if (bahans !== null) {
        mychart.update()
    }
}