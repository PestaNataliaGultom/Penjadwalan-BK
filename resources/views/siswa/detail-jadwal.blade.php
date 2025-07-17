<div class="modal fade" id="modal-detail-schedule" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Jadwal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                   <table class="table table-bordered">
                        <tr>
                            <th>Nama Siswa : </th>
                            <td id="t-siswa"></td>
                        </tr>
                        <tr>
                            <th>Nama Guru Bk : </th>
                            <td id="t-guru"></td>
                        </tr>
                        <tr>
                            <th>Durasi Konseling : </th>
                            <td id="t-duration"></td>
                        </tr>
                        <tr>
                            <th>Deskripsi : </th>
                            <td id="t-deskripsi"></td>
                        </tr>
                        <tr>
                            <th>Jam Mulai : </th>
                            <td id="t-from-time"></td>
                        </tr>
                        <tr>
                            <th>Jam Selesai : </th>
                            <td id="t-to-time"></td>
                        </tr>
                        <tr>
                            <th>Status : </th>
                            <td id="t-status"></td>
                        </tr>
                   </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                {{-- <button type="submit" class="btn btn-primary">Save changes</button> --}}
            </div>
           
        </div>
    </div>
</div>