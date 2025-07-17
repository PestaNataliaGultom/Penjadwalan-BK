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
                console.log(details);
                const eventDate = info.event.start;
                const formattedDate = eventDate.toLocaleDateString('id-ID', {
                    day: 'numeric', month: 'long', year: 'numeric'
                });
                $("#exampleModalLabel").text('Detail Jadwal Tanggal ' + formattedDate);
                let html = "";

                if(details && details.length > 0){
                    $("#btn-all-approve").attr('disabled', false);
                    $("#btn-all-reject").attr('disabled', false);
                    details.forEach((detail, index) => {
                        let actionButtons = ''; 
                        if (detail.status == 0) {
                            actionButtons = `
                                <div class="btn-group-vertical btn-group-md-horizontal" role="group" aria-label="Aksi Jadwal">
                                    <a href="javascript:void(0)" onclick="onApprove(${detail.id})" class="btn btn-success btn-sm approve">
                                        <i class="fa fa-check"></i> Approve
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm reject">
                                        <i class="fa fa-times"></i> Reject
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-warning btn-sm reschedule">
                                        <i class="fa fa-clock"></i> Reschedule
                                    </a>
                                </div>
                            `;
                        } else if (detail.status == 1) {
                            actionButtons = `
                                <a href="javascript:void(0)" class="btn btn-warning btn-sm reschedule">
                                    <i class="fa fa-clock"></i> Reschedule
                                </a>
                            `;
                        }

                        html+=`<tr>
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
                }else{
                    $("#btn-all-approve").attr('disabled', true)
                    $("#btn-all-reject").attr('disabled', true)
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
</script>
@endpush