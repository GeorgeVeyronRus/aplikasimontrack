@extends(backpack_view('blank'))

@section('content')
<style>
.card.h-100 {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card.h-100:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

@media (min-width: 992px) {
    .sidebar-sticky {
        position: sticky;
        top: 90px; /* adjust to your navbar height */
    }
}
</style>

<div class="container py-4">
    <div class="row">
        <div class="col-lg-8">
            <!-- Article Section -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">Belajar Tentang Uang</h2>
                    <p class="text-muted">Dipublikasikan: {{ date('d M Y') }}</p>
                    <p>Mengelola uang dengan bijak sangat penting dalam kehidupan sehari-hari. Dalam artikel ini, kita akan membahas dasar-dasar pengelolaan keuangan, seperti menabung, membuat anggaran, dan menghindari utang yang tidak perlu.</p>
                    <p>Berikut adalah video edukatif untuk membantu Anda memahami lebih lanjut:</p>
                    <div class="ratio ratio-16x9 mb-3">
                        <iframe src="https://www.youtube.com/embed/wda2gHdLcZw?si=Xk5Qz6gxgL8trCM5" title="Video Edukasi Pengelolaan Uang" allowfullscreen loading="lazy"></iframe>
                    </div>
                    <p>Pelajari juga bagaimana investasi sederhana dapat membantu masa depan keuangan Anda. Jangan lewatkan tips-tips keuangan dari para ahli di artikel dan video lainnya.</p>
                </div>
            </div>

            <!-- News or Related Links Section -->
            <h4 class="mb-3">Bacaan Terkait</h4>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('packages/datatables.net-bs4/images/montrack-1.jpg') }}" class="card-img-top fixed-height" alt="Tips Menabung untuk Pelajar" loading="lazy">
                        <div class="card-body">
                            <h5 class="card-title">Tips Menabung untuk Pelajar</h5>
                            <p class="card-text">Cara mudah dan efektif untuk mulai menabung sejak dini.</p>
                            <a href="https://www.cnbc.com/2025/06/07/forgotten-401ks-account-fees-cost-workers-thousands-in-retirement-savings.html" 
                            class="btn btn-outline-primary btn-sm" target="_blank" rel="noopener noreferrer">Baca Selengkapnya</a>

                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('packages/datatables.net-bs4/images/montrack-2.jpg') }}" class="card-img-top fixed-height" alt="Kenapa Penting Punya Anggaran?" loading="lazy">
                        <div class="card-body">
                            <h5 class="card-title">Kenapa Penting Punya Anggaran?</h5>
                            <p class="card-text">Manfaat besar dari membuat dan mengikuti rencana anggaran.</p>
                            <a href="https://www.cnbc.com/2025/06/07/gen-z-asks-whats-the-point-of-saving-money.html" 
                            class="btn btn-outline-primary btn-sm" target="_blank" rel="noopener noreferrer">Baca Selengkapnya</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tips Sidebar Column -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Tips Singkat</h5>
                    <ul class="list-unstyled mb-0">
                        <li><i class="la la-check-circle text-success"></i> Buat anggaran bulanan</li>
                        <li><i class="la la-check-circle text-success"></i> Simpan minimal 10% dari penghasilan</li>
                        <li><i class="la la-check-circle text-success"></i> Hindari utang konsumtif</li>
                        <li><i class="la la-check-circle text-success"></i> Investasikan sisa dana</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-img-top.fixed-height {
        height: 200px;
        object-fit: cover;
        width: 100%;
    }
    @media (max-width: 991.98px) {
        .col-lg-8, .col-lg-4 {
            flex: 0 0 100%;
            max-width: 100%;
            margin-bottom: 1.5rem;
        }
    }
</style>
@endsection
