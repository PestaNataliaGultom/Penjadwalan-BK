@extends('guru.layouts.app')

@section('title', 'Jadwal Guru BK')
@section('content') 
<div class="col-md-12">
    <div class="main-content">
        <div class="page-header">
            <h1>Jadwal</h1>
            <p class="page-subtitle">Jadwal konseling</p>
        </div>
        <div class="mt-4">
            <h4>Kalender Jadwal Konseling</h4>
            <div id='calendar'></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-detail-schedule" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Jadwal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="row">
                    <div class="col-lg-12">
                        <h4>Lis Data Detail Jadwal</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Jurusan</th>
                                    <th>Durasi</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-schedule">
                                
                            </tbody>
                        </table>
                    </div>
               </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn-all-approve"><i class="fa fa-check"></i> Approve Semua</button>
                <button type="button" class="btn btn-danger" id="btn-all-reject"><i class="fa fa-times"></i> Reject Semua</button>
            </div>
           
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: '{{route("guru.jadwal.json")}}', 
            eventClick: function(info) {
           
                const details = info.event.extendedProps.details;
                const eventDate = info.event.start;
                const formattedDate = eventDate.toLocaleDateString('id-ID', {
                    day: 'numeric', month: 'long', year: 'numeric'
                });
                $("#exampleModalLabel").text('Detail Jadwal Tanggal ' + formattedDate);
                let html = "";

                if (details && details.length > 0) {
                // BARU: Cukup satu variabel untuk melacak apakah ada jadwal yang masih 'pending'.
                let hasPendingItems = false;

                details.forEach((detail, index) => {
                    let actionButtons = '';
                    if (detail.status == 0) {
                        // BARU: Tandai bahwa kita menemukan item yang 'pending'.
                        hasPendingItems = true; 
                        actionButtons = `
                            <div class="btn-group-vertical btn-group-md-horizontal" role="group" aria-label="Aksi Jadwal">
                                <a href="javascript:void(0)" onclick="onApprove(${detail.id})" class="btn btn-success btn-sm approve">
                                    <i class="fa fa-check"></i> Approve
                                </a>
                                <a href="javascript:void(0)" onclick="onReject(${detail.id})" class="btn btn-danger btn-sm reject">
                                    <i class="fa fa-times"></i> Reject
                                </a>
                                <a href="javascript:void(0)" onclick="onReschedule(${detail.id})" class="btn btn-warning btn-sm reschedule">
                                    <i class="fa fa-clock"></i> Reschedule
                                </a>
                            </div>
                        `;
                    } else if (detail.status == 1) {
                        actionButtons = `
                             <a href="javascript:void(0)" onclick="onReschedule(${detail.id})" class="btn btn-warning btn-sm reschedule">
                                    <i class="fa fa-clock"></i> Reschedule
                                </a>
                        `;
                    }

                    html += `<tr>
                        <td>${index + 1}</td>
                        <td>${detail.student_name}</td>
                        <td>${detail.kelas_name}</td>
                        <td>${detail.jurusan_name}</td>
                        <td>${detail.duration} Menit</td>
                        <td>${detail.description}</td>
                        <td>${detail.status_badge}</td>
                        <td>
                            ${actionButtons}
                        </td>
                    </tr>`;
                });

                // BARU: Logika yang jauh lebih sederhana untuk menampilkan/menyembunyikan tombol.
                if (hasPendingItems) {
                    // Jika ada item yang pending, tampilkan kedua tombol.
                    $("#btn-all-approve").show();
                    $("#btn-all-reject").show();
                } else {
                    // Jika tidak ada item pending (semua sudah approved/rejected), sembunyikan kedua tombol.
                    $("#btn-all-approve").hide();
                    $("#btn-all-reject").hide();
                }
    
            } else {
                $("#btn-all-approve").attr('disabled', true).hide();
                $("#btn-all-reject").attr('disabled', true).hide();
                html = '<tr><td colspan="8" class="text-center">Tidak ada detail jadwal untuk ditampilkan.</td></tr>';
            }
            
                $("#tbody-schedule").html(html);
        
                
                // Tampilkan modal
                const modal = new bootstrap.Modal(document.getElementById('modal-detail-schedule'));
                modal.show();
            }
        })
        calendar.render();
    });

    function onApprove(id){
        const isConfirmed = confirm("Anda yakin ingin menyetujui jadwal ini?");
        if (isConfirmed) {
            $.ajax({
                url: "{{route('guru.approve')}}",
                type: 'POST',
                data : {
                    "_token": '{{csrf_token()}}',
                    "id": id
                },
                dataType: 'json',
                success: function(data) {
                    alert(data.message); 
                    location.reload()
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                    let errorMessage = 'Gagal menyetujui jadwal. Silakan coba lagi.';
                    if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                        errorMessage = jqXHR.responseJSON.message;
                    }
                    alert(errorMessage);
                }
            });
        }
    }
    function onReject(id){
        const isConfirmed = confirm("Anda yakin ingin menolak jadwal ini?");
        if (isConfirmed) {
            $.ajax({
                url: "{{route('guru.reject')}}",
                type: 'POST',
                data : {
                    "_token": '{{csrf_token()}}',
                    "id": id
                },
                dataType: 'json',
                success: function(data) {
                    alert(data.message); 
                    location.reload()
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                    let errorMessage = 'Gagal menolak jadwal. Silakan coba lagi.';
                    if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                        errorMessage = jqXHR.responseJSON.message;
                    }
                    alert(errorMessage);
                }
            });
        }
    }
    function onReschedule(id){
        // Buat modal untuk pemilihan tanggal
        let modalHtml = `
            <div class="modal fade" id="rescheduleModal" tabindex="-1" aria-labelledby="rescheduleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rescheduleModalLabel">Atur Ulang Jadwal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="rescheduleForm">
                                <div class="mb-3">
                                    <label for="rescheduleDate" class="form-label">Pilih Tanggal</label>
                                    <input type="date" class="form-control" id="rescheduleDate" required>
                                    <div class="form-text">Pilih tanggal untuk jadwal baru.</div>
                                </div>
                                <div id="timeSlotInfo" class="alert alert-info d-none">
                                    Memeriksa ketersediaan jadwal...
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary" id="btnSubmitReschedule" disabled>Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        console.log(modalHtml)
        // Tambahkan modal ke body jika belum ada
        if (!$('#rescheduleModal').length) {
            $('body').append(modalHtml);
        }
        
        // Tampilkan modal
        const rescheduleModal = new bootstrap.Modal(document.getElementById('rescheduleModal'));
        rescheduleModal.show();
        
        // Set tanggal minimum hari ini
        const today = new Date();
        const formattedDate = today.toISOString().split('T')[0];
        $('#rescheduleDate').attr('min', formattedDate);
        
        // Hapus event handler lama jika ada
        $('#rescheduleDate').off('change');
        $('#btnSubmitReschedule').off('click');
        
        // Event handler untuk perubahan tanggal
        $('#rescheduleDate').on('change', function() {
            const selectedDate = $(this).val();
            if (!selectedDate) return;
            
            // Tampilkan info sedang memeriksa
            $('#timeSlotInfo').removeClass('d-none alert-danger alert-success').addClass('alert-info').text('Memeriksa ketersediaan jadwal...');
            
            // Periksa ketersediaan jadwal
            $.ajax({
                url: "{{route('guru.check-availability')}}",
                type: 'POST',
                data: {
                    "_token": '{{csrf_token()}}',
                    "date": selectedDate
                },
                dataType: 'json',
                success: function(data) {
                    if (data.available) {
                        // Jadwal tersedia
                        $('#timeSlotInfo').removeClass('alert-info alert-danger').addClass('alert-success')
                            .html(`Jadwal tersedia pada tanggal ini.<br>Jam tersedia: ${data.available_slots}`);
                        $('#btnSubmitReschedule').prop('disabled', false);
                    } else {
                        // Jadwal tidak tersedia
                        $('#timeSlotInfo').removeClass('alert-info alert-success').addClass('alert-danger')
                            .text('Jadwal pada tanggal ini sudah penuh. Silakan pilih tanggal lain.');
                        $('#btnSubmitReschedule').prop('disabled', true);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                    $('#timeSlotInfo').removeClass('alert-info alert-success').addClass('alert-danger')
                        .text('Gagal memeriksa ketersediaan jadwal. Silakan coba lagi.');
                    $('#btnSubmitReschedule').prop('disabled', true);
                }
            });
        });
        
        // Event handler untuk tombol submit
        $('#btnSubmitReschedule').on('click', function() {
            const selectedDate = $('#rescheduleDate').val();
            if (!selectedDate) {
                alert('Silakan pilih tanggal terlebih dahulu.');
                return;
            }
            
            // Kirim permintaan reschedule
            $.ajax({
                url: "{{route('guru.rescheckAvailabilitychedule')}}",
                type: 'POST',
                data: {
                    "_token": '{{csrf_token()}}',
                    "id": id,
                    "new_date": selectedDate
                },
                dataType: 'json',
                success: function(data) {
                    rescheduleModal.hide();
                    alert(data.message);
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                    let errorMessage = 'Gagal mengatur ulang jadwal. Silakan coba lagi.';
                    if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                        errorMessage = jqXHR.responseJSON.message;
                    }
                    alert(errorMessage);
                }
            });
        });
    }
    
    // Event handler untuk tombol Approve Semua
    $("#btn-all-approve").on('click', function() {
        const isConfirmed = confirm("Anda yakin ingin menyetujui semua jadwal?");
        if (isConfirmed) {
            // Dapatkan semua ID jadwal yang belum diapprove
            const scheduleIds = [];
            $("#tbody-schedule tr").each(function() {
                const approveBtn = $(this).find('.approve');
                if (approveBtn.length > 0) {
                    // Ekstrak ID dari onclick attribute
                    const onclickAttr = approveBtn.attr('onclick');
                    const idMatch = onclickAttr.match(/onApprove\((\d+)\)/);
                    if (idMatch && idMatch[1]) {
                        scheduleIds.push(idMatch[1]);
                    }
                }
            });
            
            if (scheduleIds.length === 0) {
                alert("Tidak ada jadwal yang perlu disetujui.");
                return;
            }
            
            // Proses approve satu per satu
            let processed = 0;
            let success = 0;
            let errors = [];
            
            function processNext() {
                if (processed >= scheduleIds.length) {
                    // Semua selesai diproses
                    if (success === scheduleIds.length) {
                        alert("Semua jadwal berhasil disetujui.");
                    } else {
                        alert(`${success} dari ${scheduleIds.length} jadwal berhasil disetujui.\n\nError: ${errors.join('\n')}`);
                    }
                    location.reload();
                    return;
                }
                
                const id = scheduleIds[processed];
                processed++;
                
                $.ajax({
                    url: "{{route('guru.approve')}}",
                    type: 'POST',
                    data: {
                        "_token": '{{csrf_token()}}',
                        "id": id
                    },
                    dataType: 'json',
                    success: function(data) {
                        success++;
                        processNext();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        let errorMessage = 'Gagal menyetujui jadwal ID ' + id;
                        if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                            errorMessage += ': ' + jqXHR.responseJSON.message;
                        }
                        errors.push(errorMessage);
                        processNext();
                    }
                });
            }
            
            processNext();
        }
    });
    
    // Event handler untuk tombol Reject Semua
    $("#btn-all-reject").on('click', function() {
        const isConfirmed = confirm("Anda yakin ingin menolak semua jadwal?");
        if (isConfirmed) {
            // Dapatkan semua ID jadwal yang belum direject
            const scheduleIds = [];
            $("#tbody-schedule tr").each(function() {
                const rejectBtn = $(this).find('.reject');
                if (rejectBtn.length > 0) {
                    // Ekstrak ID dari onclick attribute
                    const onclickAttr = rejectBtn.attr('onclick');
                    const idMatch = onclickAttr.match(/onReject\((\d+)\)/);
                    if (idMatch && idMatch[1]) {
                        scheduleIds.push(idMatch[1]);
                    }
                }
            });
            
            if (scheduleIds.length === 0) {
                alert("Tidak ada jadwal yang perlu ditolak.");
                return;
            }
            
            // Proses reject satu per satu
            let processed = 0;
            let success = 0;
            let errors = [];
            
            function processNext() {
                if (processed >= scheduleIds.length) {
                    // Semua selesai diproses
                    if (success === scheduleIds.length) {
                        alert("Semua jadwal berhasil ditolak.");
                    } else {
                        alert(`${success} dari ${scheduleIds.length} jadwal berhasil ditolak.\n\nError: ${errors.join('\n')}`);
                    }
                    location.reload();
                    return;
                }
                
                const id = scheduleIds[processed];
                processed++;
                
                $.ajax({
                    url: "{{route('guru.reject')}}",
                    type: 'POST',
                    data: {
                        "_token": '{{csrf_token()}}',
                        "id": id
                    },
                    dataType: 'json',
                    success: function(data) {
                        success++;
                        processNext();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        let errorMessage = 'Gagal menolak jadwal ID ' + id;
                        if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                            errorMessage += ': ' + jqXHR.responseJSON.message;
                        }
                        errors.push(errorMessage);
                        processNext();
                    }
                });
            }
            
            processNext();
        }
    });
</script>
@endpush