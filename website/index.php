<?php @session_start();
////////////////////////////////////////////////////////////////////////////////////////////////////////
//
// If you're seeing this page, your web server isn't configured correctly.  (PHP is not enabled.)
//
////////////////////////////////////////////////////////////////////////////////////////////////////////

// Redirects to setup page if the database hasn't yet been set up
require_once('inc/data.inc');
require_once('inc/schema_version.inc');
require_once('inc/banner.inc');
require_once('inc/authorize.inc');

// This first database access is surrounded by a try/catch in order to catch
// broken/corrupt databases (e.g., sqlite pointing to a file that's not actually
// a database).  The pdo may get created OK, but then fail on the first attempt
// to access.
try {
    $schema_version = schema_version();
} catch (PDOException $p) {
    $_SESSION['setting_up'] = 1;
    header('Location: setup.php');
    exit();
}
session_write_close();

$show_voting_button =
        $schema_version >= BALLOTING_SCHEMA &&
        read_single_value('SELECT COUNT(*) FROM BallotAwards') > 0;

?><!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pinewood Derby Race Information</title>
    <?php require('inc/stylesheet.inc'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/modal.js"></script>

    <style>
        body {
            background: #f5f6f8;
        }

        .card-link {
            text-decoration: none;
            color: inherit;
        }

        .dashboard-card {
            transition: .15s;
        }

        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, .15);
        }

        .section-title {
            margin-top: 35px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        :root {
            --bs-primary: #023882;
            --bs-primary-rgb: 2, 56, 130;
        }
    </style>
</head>

<body>
<!-- HEADER -->
<nav class="navbar navbar-dark bg-primary px-3">
    <div class="navbar-brand fw-bold">
        🏎 DerbyNet
    </div>
    <!-- TODO remove - this is fake text that's just here for a mockup -->
    <div class="text-white text-center flex-grow-1 small">
        Pack 234 · Springfield Community Center · April 27, 2024
    </div>
    <?php if (@$_SESSION['role']): ?>
        <div class="dropdown">
            <a class="text-white dropdown-toggle text-decoration-none"
               href="#"
               role="button"
               data-bs-toggle="dropdown"
            >
                Hello, <?php echo $_SESSION['role']; ?>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="login.php?logout">Log Out</a>
                </li>
            </ul>
        </div>
    <?php else: ?>
        <a class="nav-link text-white" href="login.php">Log In</a>
    <?php endif; ?>
</nav>


<div class="container">
    <!-- RACE PREP -->
    <?php if (have_permission(SET_UP_PERMISSION) || have_permission(ASSIGN_RACER_IMAGE_PERMISSION)): ?>
        <h4 class="section-title">Race Prep</h4>
        <div class="row g-3">
            <?php if (have_permission(SET_UP_PERMISSION)): ?>
                <div class="col-md-6 col-lg-4">
                    <a class="card dashboard-card card-link" href="setup.php">
                        <div class="card-body">
                            <h5 class="card-title">⚙️ Set-Up</h5>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
            <?php if (have_permission(ASSIGN_RACER_IMAGE_PERMISSION)): ?>
                <div class="col-md-6 col-lg-4">
                    <a class="card dashboard-card card-link" href="print.php">
                        <div class="card-body">
                            <h5 class="card-title">🖨 Printables</h5>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- CHECK IN -->
    <?php if (have_permission(CHECK_IN_RACERS_PERMISSION) || have_permission(ASSIGN_RACER_IMAGE_PERMISSION)): ?>
        <h4 class="section-title">Check In</h4>
        <div class="row g-3">
            <?php if (have_permission(CHECK_IN_RACERS_PERMISSION)): ?>
                <div class="col-md-6 col-lg-4">
                    <a class="card dashboard-card card-link" href="checkin.php">
                        <div class="card-body">
                            <h5 class="card-title">✅ Race Check-In</h5>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
            <?php if (have_permission(ASSIGN_RACER_IMAGE_PERMISSION)): ?>
                <div class="col-md-6 col-lg-4">
                    <a class="card dashboard-card card-link" href="photo-thumbs.php?repo=head">
                        <div class="card-body">
                            <h5 class="card-title">📷 Racer Photos</h5>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a class="card dashboard-card card-link" href="photo-thumbs.php?repo=car">
                        <div class="card-body">
                            <h5 class="card-title">🚗 Car Photos</h5>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- RACING -->
    <h4 class="section-title">Racing</h4>
    <div class="row g-3">
        <?php if (have_permission(SET_UP_PERMISSION)): ?>
            <div class="col-md-6 col-lg-4">
                <a class="card dashboard-card card-link" href="coordinator.php">
                    <div class="card-body">
                        <h5 class="card-title">🏁 Race Dashboard</h5>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a class="card dashboard-card card-link" href="kiosk-dashboard.php">
                    <div class="card-body">
                        <h5 class="card-title">🖥 Kiosk Dashboard</h5>
                    </div>
                </a>
            </div>
        <?php endif; ?>
        <?php if (have_permission(JUDGING_PERMISSION)): ?>
            <div class="col-md-6 col-lg-4">
                <a class="card dashboard-card card-link" href="judging.php">
                    <div class="card-body">
                        <h5 class="card-title">⭐ Judging</h5>
                    </div>
                </a>
            </div>
        <?php endif; ?>

        <?php if (!have_permission(SET_UP_PERMISSION) && have_permission(VIEW_RACE_RESULTS_PERMISSION)): ?>
            <div class="col-md-6 col-lg-4">
                <a class="card dashboard-card card-link" href="slideshow.php">
                    <div class="card-body">
                        <h5 class="card-title">📽️ Slideshow</h5>
                    </div>
                </a>
            </div>
            <?php if ($show_voting_button): ?>
                <div class="col-md-6 col-lg-4">
                    <a class="card dashboard-card card-link" href="vote.php">
                        <div class="card-body">
                            <h5 class="card-title">🗳️ Vote</h5>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <div class="col-md-6 col-lg-4">
            <a class="card dashboard-card card-link" href="ondeck.php">
                <div class="card-body">
                    <h5 class="card-title">👥 Racers On Deck</h5>
                </div>
            </a>
        </div>
    </div>

    <!-- RESULTS -->
    <h4 class="section-title">Results</h4>
    <div class="row g-3">
        <?php if (have_permission(VIEW_RACE_RESULTS_PERMISSION)): ?>
            <div class="col-md-6 col-lg-4">
                <a class="card dashboard-card card-link" href="racer-results.php">
                    <div class="card-body">
                        <h5 class="card-title">📄 Results By Racer</h5>
                    </div>
                </a>
            </div>
        <?php endif; ?>
        <?php if (have_permission(PRESENT_AWARDS_PERMISSION)): ?>
            <div class="col-md-6 col-lg-4">
                <a class="card dashboard-card card-link" href="awards-presentation.php">
                    <div class="card-body">
                        <h5 class="card-title">🏆 Present Awards</h5>
                    </div>
                </a>
            </div>
        <?php endif; ?>
        <?php if (have_permission(VIEW_AWARDS_PERMISSION)): ?>
            <div class="col-md-6 col-lg-4">
                <a class="card dashboard-card card-link" href="standings.php">
                    <div class="card-body">
                        <h5 class="card-title">📊 Standings</h5>
                    </div>
                </a>
            </div>
        <?php endif; ?>
        <?php if (have_permission(VIEW_RACE_RESULTS_PERMISSION)): ?>
            <div class="col-md-6 col-lg-4">
                <a class="card dashboard-card card-link" href="export.php">
                    <div class="card-body">
                        <h5 class="card-title">⬇ Export Results</h5>
                    </div>
                </a>
            </div>
        <?php endif; ?>
        <?php if (have_permission(SET_UP_PERMISSION)): ?>
            <div class="col-md-6 col-lg-4">
                <a class="card dashboard-card card-link" href="history.php">
                    <div class="card-body">
                        <h5 class="card-title">🔁 Retrospective</h5>
                    </div>
                </a>
            </div>
        <?php endif; ?>
    </div>


    <!-- FOOTER -->

    <footer class="text-center mt-5">
        <div class="mb-2">
            <a class="btn btn-outline-secondary btn-sm me-2" href="https://derbynet.org/builds/docs.php">
                Help
            </a>
            <a class="btn btn-outline-secondary btn-sm" href="about.php">
                About
            </a>
        </div>

        <div class="text-muted small">
            DerbyNet · Open Source Pinewood Derby Race Management
        </div>
    </footer>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
