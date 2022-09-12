

        <!-- Header Layout Content -->
        <div class="mdk-header-layout__content page-content">
            <div class="bg-info pb-lg-64pt py-3">
                <div class="container page__container">
                    <div class="d-flex flex-wrap align-items-end justify-content-end mb-16pt">
                        <h1 class="text-white flex m-0">PHF Ogun Quiz</h1>
                    </div>
                    <?php if($quizinput == 'disabled'): ?>
                    <p class="hero__lead measure-hero-lead text-white-50">
                    You're very much welcome to this week's edition of PHF Ogun Quiz. <b class="text-warning"> The Quiz is currently disabled.</b> <br> Check back by 4pm, Quiz will be <i>live</i>  from <span class="text-monospace"> 4pm to 7pm</span>. <br>
                    Cheers.
                    </p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="container page__container vh-50">
                <ol class="list-group">
                    <li class="list-group-item my-16pt mb-lg-48pt">
                        <div class="page-section">
                            <form action="quiz" method="get" class="text-center">
                                <label for="quiz code">Quiz Code</label>
                                <input <?=$quizinput?> type="text" placeholder="Enter the quiz access code" name="code" class="form-control">
                                <!-- <br> -->
                                <input type="submit" class="mt-3 btn btn-primary" value="Start Quiz">
                            </form>
                        </div>
                    </li>
                </ol>
                </div>
            </div>
        </div>
        <!-- // END Header Layout Content -->

        <div class="js-fix-footer2 bg-white border-top-2">
            <div class="container page__container page-section d-flex flex-column">
                <p class="text-70 brand mb-2pt">
                    <img class="brand-icon" src="assets/images/logo/black-70%402x.jpeg" width="30" alt="Luma" />
                    PHF Ogun
                </p>
                <p class="measure-lead-max text-50 small mr-8pt">
                    PHF Ogun created this quiz platform to engage its member during this
                    period.
                </p>
                <p class="text-50 small mt-n1 mb-0">
                    Copyright 2021 &copy; All rights reserved.
                </p>
            </div>
        </div>
    </div>
    <!-- // END Header Layout -->
