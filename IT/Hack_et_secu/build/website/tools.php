<?php



?>


<div class="container-fluid" class="collapse" id="main_sidebar">
    <div class="row">

        <nav class="col-md-2 sidebar" style="background-color: #F6CEF5; min-height: 100vh;">
            <div class="sidebar-sticky">
                <ul class="nav flex-column" style="margin-top: 10%;">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?page=tools.php&tool=encoding">
                            Conversion bases
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="index.php?page=tools.php&tool=url_decode">
                            URL
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=tools.php&tool=file_hexa_visualiser">
                            Voir fichier hexadecimal
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="index.php?page=tools.php&tool=audio_spectrum">
                            Spectre audio
                        </a>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="layers"></span>
                            Integrations
                        </a>
                    </li> -->
                </ul>

                <!-- <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Saved reports</span>
                        <a class="d-flex align-items-center text-muted" href="#">
                            <span data-feather="plus-circle"></span>
                        </a>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Current month
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Last quarter
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Social engagement
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Year-end sale
                        </a>
                    </li>
                </ul> -->
            </div>
        </nav>

        <?php
            if ( isset($_GET["tool"]) && !empty($_GET["tool"]) ) {
                include "tools/".$_GET["tool"].".php";
            }
        ?>

    </div>
</div>

