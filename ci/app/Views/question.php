<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Quiz</title>

    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots" content="noindex" />

    <link href="https://fonts.googleapis.com/css?family=Lato:400,700%7CRoboto:400,500%7CExo+2:600&amp;display=swap" rel="stylesheet" />

    <!-- Perfect Scrollbar -->
    <link type="text/css" href="assets/vendor/perfect-scrollbar.css" rel="stylesheet" />

    <!-- Fix Footer CSS -->
    <link type="text/css" href="assets/vendor/fix-footer.css" rel="stylesheet" />

    <!-- Material Design Icons -->
    <link type="text/css" href="assets/css/material-icons.css" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <link type="text/css" href="assets/css/fontawesome.css" rel="stylesheet" />

    <!-- Preloader -->
    <link type="text/css" href="assets/css/preloader.css" rel="stylesheet" />

    <!-- App CSS -->
    <link type="text/css" href="assets/css/app.css" rel="stylesheet" />
</head>

<body class="layout-sticky-subnav layout-default">
    <div class="preloader">
        <div class="sk-double-bounce">
            <div class="sk-child sk-double-bounce1"></div>
            <div class="sk-child sk-double-bounce2"></div>
        </div>
    </div>

    <!-- Header Layout -->
    <div class="mdk-header-layout js-mdk-header-layout">
        <!-- Header -->

        <div id="header" class="mdk-header js-mdk-header mb-0" data-fixed data-effects="">
            <div class="mdk-header__content">
                <div class="navbar navbar-expand pr-0 navbar-dark-dodger-blue navbar-shadow" id="default-navbar" data-primary>
                    <!-- Navbar toggler -->
                    <button class="navbar-toggler w-auto mr-16pt d-block rounded-0" type="button" data-toggle="sidebar">
                        <span class="material-icons">short_text</span>
                    </button>

                    <!-- Navbar Brand -->
                    <a href="fixed-index.html" class="navbar-brand mr-16pt">
                        <div class="flex align-items-center">
                            <span class="avatar avatar-sm navbar-brand-icon mr-0 mr-lg-8pt">
                                <span class="avatar-title rounded bg-primary"><img src="assets/images/logo/logo.jpeg" alt="logo" class="img-fluid" /></span>
                            </span>
                            <span class="mr-5">PHF Quiz</span>


                            <span class="ml-5 text-white text-monospace h3" id="countdown"></span>
                        </div>


                    </a>

                    <div class="flex"></div>
                </div>
            </div>
        </div>

        <!-- // END Header -->

        <!-- Header Layout Content -->
        <div class="mdk-header-layout__content page-content navbar-fixed">
            <div class="bg-info pb-lg-64pt py-32pt">
                <div class="container page__container">
                    <div class="d-flex flex-wrap align-items-end justify-content-end mb-16pt">
                        <h1 class="text-white flex m-0"><?=$title?></h1>
                    </div>

                    <p class="hero__lead measure-hero-lead text-white-50">
                    <?=$description?>
                    </p>
                </div>
            </div>
<!-- 
            <div class="navbar navbar-expand-md navbar-list navbar-light bg-white border-bottom-2" style="white-space: nowrap;">
                <div class="container page__container">
                    <ul class="nav navbar-nav flex navbar-list__item">
                        <li class="nav-item">
                            <i class="material-icons text-50 mr-8pt">tune</i>
                            Quiz rules, regulations and instruction:
                        </li>
                    </ul>
                </div>
            </div> -->

            <div style="position: fixed; margin-top: 45vh; margin-left: 80vw; color: #fff; background-color: #000; z-index: 100000;">
                <span class="text-monospace" id="coutdown"></span>
            </div>

            <div class="container page__container">
                <form action="quizlet" id="quizlet" method="post">
                    <?php
                    $combo = range(0, 14);
                    $cat = json_decode($questions);
                    ?>
                    <ol class="list-group">
                        <?php foreach ($combo as $key => $random) : ?>
                            <li class="list-group-item my-16pt mb-lg-48pt">
                                <div class="page-section">
                                    <div class="page-separator">
                                        <p class="measure-lead-max text-90 text-black-70">
                                            <?= ((array) $cat[$random])[0] ?>
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" value="a" name="<?= $key . "que" . $random ?>">
                                                    <?= ((array) $cat[$random])[1] ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" value="b" name="<?= $key . "que" . $random ?>">
                                                    <?= ((array) $cat[$random])[2] ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" value="c" name="<?= $key . "que" . $random ?>">
                                                    <?= ((array) $cat[$random])[3] ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input"
                                                    value="d" name="<?= $key . "que" . $random ?>">
                                                    <?= ((array) $cat[$random])[4] ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                            </li>
                        <?php endforeach; ?>
                    </ol>
                    <input type="submit" value="Submit" class="btn btn-block btn-primary mb-3">
                </form>
            </div>
        </div>
    </div>
    <!-- // END Header Layout Content -->

    <div class="js-fix-footer2 bg-white border-top-2">
        <div class="container page__container page-section d-flex flex-column">
            <p class="text-70 brand mb-2pt">
                <img class="brand-icon" src="assets/images/logo/black-70%402x.png" width="30" alt="Luma" />
                PHF Ogun
            </p>
            <p class="measure-lead-max text-50 small mr-8pt">
                PHF Ogun created this quiz platform to engage its member during this
                period.
            </p>
            <p class="text-50 small mt-n1 mb-0">
                Copyright 2020 &copy; All rights reserved.
            </p>
        </div>
    </div>
    </div>
    <!-- // END Header Layout -->

    <!-- jQuery -->
    <script src="assets/vendor/jquery.min.js"></script>
    <script src="assets/vendor/easytimer.js"></script>
    <script>
        var cd = 600;
        var timer = new Timer();
        timer.start({
            countdown: true,
            startValues: {
                seconds: cd
            }
        });
        var tmr = new Timer();
        tmr.start({
            countdown: true,
            startValues: {
                seconds: cd - 10
            }
        });

        $('#countdown').html(timer.getTimeValues().toString());

        timer.addEventListener('secondsUpdated', function(e) {
            $('#countdown').html(timer.getTimeValues().toString());
        });

        timer.addEventListener('targetAchieved', function(e) {
            $('#quizlet').submit();
            $('#countdown').html('Time up!!');
        });
        tmr.addEventListener('targetAchieved', function(e) {
            $('#countdown').addClass('text-danger');
        });
    </script>

    <!-- Bootstrap -->
    <script src="assets/vendor/popper.min.js"></script>
    <script src="assets/vendor/bootstrap.min.js"></script>

    <!-- Perfect Scrollbar -->
    <script src="assets/vendor/perfect-scrollbar.min.js"></script>

    <!-- DOM Factory -->
    <script src="assets/vendor/dom-factory.js"></script>

    <!-- MDK -->
    <script src="assets/vendor/material-design-kit.js"></script>

    <!-- Fix Footer -->
    <script src="assets/vendor/fix-footer.js"></script>

    <!-- App JS -->
    <script src="assets/js/app.js"></script>
</body>

</html>