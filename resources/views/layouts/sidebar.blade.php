<ul class="side-nav">

    <li class="side-nav-title side-nav-item">Navigation</li>
    <li class="side-nav-item">
        <a href="/dashboard" class="side-nav-link">
            <i class="uil-home-alt"></i>
            <span> Dashboards </span>
        </a>
    </li>
    @canany(['view-tahun-periode', 'view-fakultas-prodi', 'view-lembaga-akreditasi', 'view-standar-nasional'])
        @hasanyrole('Admin|Kaprodi|Prodi|Fakultas|Auditor|Audit')
            <li class="side-nav-title side-nav-item">Referensi</li>
        @endhasanyrole
    @endcanany
    <li class="side-nav-item">
        @canany(['view-tahun-periode', 'view-fakultas-prodi', 'view-lembaga-akreditasi', 'view-standar-nasional'])
            @hasanyrole('Admin|Kaprodi|Prodi|Fakultas|Auditor|Audit')
                <a data-bs-toggle="collapse" href="#manajemenReferensi" aria-expanded="false" aria-controls="manajemenReferensi"
                    class="side-nav-link">
                    <i class="uil-clipboard-alt"></i>
                    <span>Manajemen Referensi</span>
                    <span class="menu-arrow"></span>
                </a>
            @endhasanyrole
        @endcanany
        <div class="collapse" id="manajemenReferensi">
            <ul class="side-nav-second-level">
                @can('view-tahun-periode')
                    <li>
                        <a href="/tahun-periodes">Tahun Periode</a>
                    </li>
                @endcan
                @can('view-fakultas-prodi')
                    <li>
                        <a href="/fakultas-prodis">Fakultas/Prodi</a>
                    </li>
                @endcan
                @can('view-lembaga-akreditasi')
                    <li>
                        <a href="/lembaga-akreditasis">Lembaga Akreditasi</a>
                    </li>
                @endcan
                @can('view-standar-nasional')
                    <li>
                        <a href="/standar-nasionals">Standar Nasional</a>
                    </li>
                @endcan
            </ul>
        </div>
    </li>

    @canany(['view-pengaturan-periode', 'view-target-nilai-mutu', 'view-evaluasi-diri'])
        @hasanyrole('Admin|Kaprodi|Prodi|Fakultas|Auditor|Audit')
            <li class="side-nav-title side-nav-item">Manajemen Evalusi Diri</li>
        @endhasanyrole
    @endcanany
    @can('view-pengaturan-periode')
        <li class="side-nav-item">
            <a href="/pengaturan-periodes" class="side-nav-link">
                <i class="uil-box"></i>
                <span>Pengaturan Periode </span>
            </a>
        </li>
    @endcan

    @can('view-target-nilai-mutu')
        <li class="side-nav-item">
            <a href="/target-nilai-mutus" class="side-nav-link">
                <i class="mdi mdi-file-document-multiple"></i>
                <span>Target Nilai Mutu </span>
            </a>
        </li>
    @endcan

    @can('view-evaluasi-diri')
        <li class="side-nav-item">
            <a href="{{ auth()->user()->hasRole('Admin') ? route('evaluasi-diri.index') : route('prodi.evalusi-diri.index') }}"
                class="side-nav-link">
                <i class="dripicons-document"></i>
                <span>Evaluasi Diri </span>
            </a>
        </li>
    @endcan

    @canany(['view-daftar-nilai-mutu', 'view-daftar-standar-mutu'])
        @hasanyrole('Admin|Kaprodi|Prodi|Fakultas|Auditor|Audit')
            <li class="side-nav-title side-nav-item">Manajemen Standar Mutu</li>
        @endhasanyrole

        @can('view-daftar-nilai-mutu')
            <li class="side-nav-item">
                <a href="/daftar-nilai-mutus" class="side-nav-link">
                    <i class="uil-bill"></i>
                    <span>Daftar Nilai Mutu </span>
                </a>
            </li>
        @endcan

        @can('view-daftar-standar-mutu')
            <li class="side-nav-item">
                <a href="/daftar-standar-mutus" class="side-nav-link">
                    <i class="uil-graph-bar"></i>
                    <span>Daftar Standar Mutu </span>
                </a>
            </li>
        @endcan
    @endcanany
    @canany(['view-manajemen-auditor', 'view-rekap-desk-evaluasi', 'view-daftar-temuan', 'view-kategori-dokumen',
        'view-manajemen-dokumen'])
        @hasanyrole('Admin|Kaprodi|Prodi|Fakultas|Auditor|Audit')
            <li class="side-nav-title side-nav-item">Manajemen</li>
        @endhasanyrole
    @endcanany
    @can('view-manajemen-auditor')
        <li class="side-nav-item">
            @canany(['view-manajemen-auditor'])
                @hasanyrole('Admin|Kaprodi|Prodi|Fakultas|Auditor|Audit')
                    <a data-bs-toggle="collapse" href="#manajemenAuditor" aria-expanded="false" aria-controls="manajemenAuditor"
                        class="side-nav-link">
                        <i class="uil-book-reader"></i>
                        <span> Manajemen Auditor </span>
                        <span class="menu-arrow"></span>
                    </a>
                @endhasanyrole
            @endcanany
            <div class="collapse" id="manajemenAuditor">
                <ul class="side-nav-second-level">
                    <li>
                        <a href="/manajemen-auditors">Tambah Auditor</a>
                    </li>
                </ul>
            </div>
        </li>
    @endcan

    <li class="side-nav-item">
        @canany(['view-rekap-desk-evaluasi', 'view-daftar-temuan'])
            @hasanyrole('Admin|Kaprodi|Prodi|Fakultas|Auditor|Audit')
                <a data-bs-toggle="collapse" href="#manajemenMonev" aria-expanded="false" aria-controls="manajemenMonev"
                    class="side-nav-link">
                    <i class="uil-chat-bubble-user"></i>
                    <span> Manajemen Monev </span>
                    <span class="menu-arrow"></span>
                </a>
            @endhasanyrole
        @endcanany
        <div class="collapse" id="manajemenMonev">
            <ul class="side-nav-second-level">
                @can('view-rekap-desk-evaluasi')
                    <li>
                        <a
                            href=" {{ auth()->user()->hasRole('Admin') ? route('rekap-desk-evaluasi.index') : route('prodi.evalusi-diri.index') }}">{{ auth()->user()->hasRole('Admin') ? 'Rekap' : 'Hasil' }}
                            Desk Evaluasi</a>
                    </li>
                @endcan
                @can('view-daftar-temuan')
                    <li>
                        <a
                            href=" {{ auth()->user()->hasRole('Admin') ? route('daftar-temuan.index') : route('prodi.daftar-temuan.index') }}">Daftar
                            Temuan</a>
                    </li>
                @endcan
            </ul>
        </div>
    </li>

    <li class="side-nav-item">
        @canany(['view-kategori-dokumen', 'view-manajemen-dokumen'])
            @hasanyrole('Admin|Kaprodi|Prodi|Fakultas|Auditor|Audit')
                <a data-bs-toggle="collapse" href="#manajemenDokumen" aria-expanded="false" aria-controls="manajemenDokumen"
                    class="side-nav-link">
                    <i class="mdi mdi-file-chart-outline"></i>
                    <span>Manajemen Dokumen</span>
                    <span class="menu-arrow"></span>
                </a>
            @endhasanyrole
        @endcanany
        <div class="collapse" id="manajemenDokumen">
            <ul class="side-nav-second-level">
                @can('view-kategori-dokumen')
                    <li>
                        <a href="/kategori-dokumens">Kategori Dokumen</a>
                    </li>
                @endcan
                @can('view-manajemen-dokumen')
                    <li>
                        <a href="/manajemen-dokumens">Manajemen Dokumen</a>
                    </li>
                @endcan
            </ul>
        </div>
    </li>

    @can('view-user')
        <li class="side-nav-title side-nav-item">Manajemen Akun</li>
        <li class="side-nav-item">
            <a href="/users" class="side-nav-link">
                <i class="dripicons-user-group"></i>
                <span> Users </span>
            </a>
        </li>
    @endcan

    {{-- <li class="side-nav-title side-nav-item">Role & Permission</li> --}}

    @hasanyrole('Admin|Auditor|Audit|LPM|Lembaga Penjaminan Mutu')
        <li class="side-nav-item">
            @canany(['view-desk-evaluation', 'view-visitasi'])
                <a data-bs-toggle="collapse" href="#auditor-desk-evaluating" aria-expanded="false"
                    aria-controls="auditor-desk-evaluating" class="side-nav-link">
                    <i class="mdi mdi-book-edit"></i>
                    <span> Audit </span>
                    <span class="menu-arrow"></span>
                </a>
            @endcanany
            <div class="collapse" id="auditor-desk-evaluating">
                <ul class="side-nav-second-level">
                    @can('view-desk-evaluation')
                        <li>
                            <a href="{{ route('auditor.desk-evaluations.index') }}">Desk Evaluation</a>
                        </li>
                    @endcan
                    @can('view-visitasi')
                        <li>
                            <a href="{{ route('auditor.visitasi.index') }}">Visitasi</a>
                        </li>
                    @endcan
                </ul>
            </div>
        </li>
        <li class="side-nav-item">
            @canany(['view-rekap-daftar-temuan'])
                <a data-bs-toggle="collapse" href="#auditor-rekap-daftar-temuan" aria-expanded="false"
                    aria-controls="auditor-rekap-daftar-temuan" class="side-nav-link">
                    <i class="mdi mdi-book-open"></i>
                    <span> Laporan </span>
                    <span class="menu-arrow"></span>
                </a>
            @endcanany
            <div class="collapse" id="auditor-rekap-daftar-temuan">
                <ul class="side-nav-second-level">
                    @can('view-rekap-daftar-temuan')
                        <li>
                            <a href="{{ route('auditor.rekap-daftar-temuan.index') }}">Rekap Daftar Temuan</a>
                        </li>
                    @endcan
                </ul>
            </div>
        </li>
    @endhasanyrole

    @role('Admin')
        <li class="side-nav-title side-nav-item">Role & Permission</li>

        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#role_permission" aria-expanded="false" aria-controls="role_permission"
                class="side-nav-link">
                <i class="dripicons-gear"></i>
                <span> Setting </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="role_permission">
                <ul class="side-nav-second-level">
                    @can('view-role')
                        <li>
                            <a href="/roles">Role</a>
                        </li>
                    @endcan
                    @can('view-permission')
                        <li>
                            <a href="/permissions">Permission</a>
                        </li>
                    @endcan
                </ul>
            </div>
        </li>
    @endrole

    <li class="side-nav-item mt-4 mb-5">
        <hr>
        <a href="/logout" class="side-nav-link">
            <i class="dripicons-user-group"></i>
            <span> Logout </span>
        </a>
    </li>
</ul>
