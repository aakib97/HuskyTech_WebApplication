<!-- Widgets Section -->
<section class="py-4 px-3">
    <div class="row">
        <!-- Widget 3 -->
        <div class="col">
            <div class="bg-white shadow roundy px-3 py-3 h-100 d-flex align-items-center justify-content-between">
                <div class="flex-grow-1 d-flex align-items-center">

                </div>
            </div>
        </div>

        <div class="col-sm-4 align-items-center justify-content-between">
            <!-- Callouts Widget -->
            <div class="mb-4 mb-xl-0">
                <div class="bg-white shadow roundy px-4 py-3 h-100 d-flex align-items-center justify-content-between">
                    <div class="flex-grow-1 d-flex align-items-center">
                        <div class="text">
                            <h6 class="widget-title">Callouts</h6>
                            <h2 id="calloutNum" class="widget-info"><?php echo $user->getMyAttendance()['callOuts']; ?></h2>
                        </div>
                    </div>
                    <div>
                        <i id="calloutIco" style="color:#006DF0;" class="fas fa-heart-broken fa-3x"></i>
                    </div>
                </div>
            </div>

            <!-- Pickups Widget -->
            <div class="mb-4 mb-xl-0">
                <div class="bg-white shadow roundy px-4 py-3 h-100 d-flex align-items-center justify-content-between">
                    <div class="flex-grow-1 d-flex align-items-center">
                        <div class="text">
                            <h6 class="widget-title">Pickups</h6>
                            <h2 id="pickupNum" class="widget-info"><?php echo $user->getMyAttendance()['pickUps']; ?></h2>
                        </div>
                    </div>
                    <div><i id="pickuIco" style="color:#006DF0;" class="fas fa-heart fa-3x"></i></div>
                </div>
            </div>

            <!-- Widget 4 -->
            <div class="mb-4 mb-xl-0">
                <div style="margin-bottom: 0px" class="bg-white shadow roundy px-4 py-3 h-100 d-flex align-items-center justify-content-between">
                    <div class="row">
                        <div class="col">
                            <img id="traineeBad" class="img-thumbnail badge mx-auto d-block"
                                 src="Assets/badges/trainee.jpg"
                                 alt="Profile Picture">
                        </div>

                        <?php if ( $user->Role == 'Trainee') : ?>
                            <div class="col">
                                <img id="specialistBad1" class="img-thumbnail badge mx-auto d-block"
                                     src="Assets/badges/shopspecialist.jpg"
                                     alt="Profile Picture">
                                <img id="specialistBad2" class="img-thumbnail badge mx-auto d-block"
                                     src="Assets/badges/callcenterspecialist.jpg"
                                     alt="Profile Picture">
                                <img id="specialistBad3" class="img-thumbnail mx-auto badge d-block"
                                     src="Assets/badges/aitspecialist.jpg"
                                     alt="Profile Picture">
                            </div>

                            <div class="col">
                                <img id="advancedBad1" class="img-thumbnail badge mx-auto d-block"
                                     src="Assets/badges/shopadvanced.jpg"
                                     alt="Profile Picture">
                                <img id="advancedBad2" class="img-thumbnail badge mx-auto d-block"
                                     src="Assets/badges/callcenteradvanced.jpg"
                                     alt="Profile Picture">
                                <img id="advancedBad3" class="img-thumbnail badge mx-auto d-block"
                                     src="Assets/badges/aitadvanced.jpg"
                                     alt="Profile Picture">
                            </div>

                            <div class="col">
                                <img id="leadBad1" class="img-thumbnail badge mx-auto d-block"
                                     src="Assets/badges/shoplead.jpg"
                                     alt="Profile Picture">
                                <img id="leadBad2" class="img-thumbnail badge  mx-auto d-block"
                                     src="Assets/badges/callcenterlead.jpg"
                                     alt="Profile Picture" >
                                <img id="leadBad3" class="img-thumbnail badge mx-auto d-block"
                                     src="Assets/badges/aitlead.jpg"
                                     alt="Profile Picture" >
                            </div>

                        <?php endif; ?>

                        <?php if (strpos($user->Role, 'Shop') !== false): ?>
                            <div class="col">
                                <img id="specialistBad" class="img-thumbnail badge mx-auto d-block"
                                     src="Assets/badges/shopspecialist.jpg"
                                     alt="Profile Picture" >
                            </div>

                            <div class="col">
                                <img id="advancedBad" class="img-thumbnail badge mx-auto d-block"
                                     src="Assets/badges/shopadvanced.jpg"
                                     alt="Profile Picture">
                            </div>

                            <div class="col">
                                <img id="leadBad" class="img-thumbnail badge mx-auto d-block"
                                     src="Assets/badges/shoplead.jpg"
                                     alt="Profile Picture">
                            </div>
                        <?php endif; ?>

                        <?php if (strpos($user->Role, 'Call Center') !== false): ?>
                            <div class="col">
                                <img id="specialistBad" class="img-thumbnail badge mx-auto d-block"
                                     src="Assets/badges/callcenterspecialist.jpg"
                                     alt="Profile Picture">
                            </div>

                            <div class="col">
                                <img id="advancedBad" class="img-thumbnail badge mx-auto d-block"
                                     src="Assets/badges/callcenteradvanced.jpg"
                                     alt="Profile Picture">
                            </div>

                            <div class="col">
                                <img id="leadBad" class="img-thumbnail badge mx-auto d-block"
                                     src="Assets/badges/callcenterlead.jpg"
                                     alt="Profile Picture">
                            </div>
                        <?php endif; ?>

                        <?php if (strpos($user->Role, 'AIT') !== false): ?>
                            <div class="col">
                                <img id="specialistBad" class="img-thumbnail badge mx-auto d-block"
                                     src="Assets/badges/aitspecialist.jpg"
                                     alt="Profile Picture">
                            </div>

                            <div class="col">
                                <img id="advancedBad" class="img-thumbnail badge mx-auto d-block"
                                     src="Assets/badges/aitadvanced.jpg"
                                     alt="Profile Picture">
                            </div>

                            <div class="col">
                                <img id="leadBad" class="img-thumbnail badge mx-auto d-block"
                                     src="Assets/badges/aitlead.jpg"
                                     alt="Profile Picture">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php if (strpos($user->Role, 'Lead') != false || $user->Role == 'FTE') : ?>
    <br>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-11 mb-4 mb-lg-0 pl-lg-0 mx-auto">
                    <div class="card mb-3 shadow">
                        <div class="card-header">
                            <h5 class="card-title" style="color: rgb(0, 109, 240);"><span class="card-title">Callout & Pickup Calendar
                            </h5>
                        </div>
                        <div style="text-align:center" class="card-body">
                            <iframe width="100%" height="650px"
                                    src="https://calendar.google.com/calendar/embed?title=Call%20Out%20and%20Pick%20Up&amp;mode=WEEK&amp;height=890&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=uconn.edu_5f6a8saeb4l8n028nlgl8bd2ks%40group.calendar.google.com&amp;color=%23711616&amp;src=uconn.edu_3hc26mqbnehinpr5lck6shgjkk%40group.calendar.google.com&amp;color=%23125A12&amp;ctz=America%2FNew_York"
                                    frameborder="0">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-11 mb-4 mb-lg-0 pl-lg-0 mx-auto">
                    <div class="card mb-3 shadow">
                        <div class="card-header">
                            <h5 class="card-title"><span class="card-title"><a
                                        href="https://docs.google.com/spreadsheets/d/1voKorilqdFJV3ZmoLH6oxQVsoGYyQoQ5S_AZ71FSmak"
                                        target="_blank">Callout &amp; Pickup Logs</a></span></h5>
                        </div>
                        <div style="text-align:center" class="card-body">
                            <iframe src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQFKkE-Jn6Yr3Ev2O0O1LM1hrCLCBBw1FsfQRP8tAewQxGk2Rt14-BrWlescYyTQsYSuQIVxYxR82YS/pubhtml?gid=299890252&amp;single=true&amp;widget=true&amp;headers=false"
                                    height="750px" width="100%">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>


<!-- Scheduling Tab Dropdown -->
<li id="scheduleDropdown" class="nav-item dropdown">
    <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">
        <i class="fas fa-fw fa-calendar-alt"></i>
        <span class="pl">Scheduling</span>
    </a>
    <div aria-labelledby="schedulingDropdown" class="dropdown-menu animate slideIn">
        <?php if ($user->Role != 'FTE') : ?>
            <a class="dropdown-item" href="schedule.php">Schedule</a>
            <a class="dropdown-item" href="attendance.php">Attendance</a>
            <a class="dropdown-item" href="call_pick.php">Call Out & Pick Up</a>
        <?php endif; ?>

        <?php if ($user->Role == 'FTE' || strpos($user->Role, 'Lead') != false) : ?>
            <a class="dropdown-item" href="hcAttendance.php">Help Center <br> Attendance</a>
        <?php endif; ?>
    </div>
</li>
