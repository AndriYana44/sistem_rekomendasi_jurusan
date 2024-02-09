<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="index.html">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-heading">MASTER</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('data-siswa') }}">
                <i class="bi bi-person"></i>
                <span>Data Siswa</span>
            </a>
        </li><!-- End Profile Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#soal-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Data Soal</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="soal-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('data-soal-kejuruan') }}">
                        <i class="bi bi-circle"></i><span>Kejuruan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('data-soal-psikotes') }}">
                        <i class="bi bi-circle"></i><span>Psikotes</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#rapot-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Rapot Siswa</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="rapot-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="#">
                        <i class="bi bi-circle"></i><span>Nilai Rapot</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-circle"></i><span>Nilai UN</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-book"></i>
                <span>Hasil Tes</span>
            </a>
        </li>

        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>Users</span>
            </a>
        </li><!-- End Profile Nav -->
    </ul>

</aside><!-- End Sidebar-->