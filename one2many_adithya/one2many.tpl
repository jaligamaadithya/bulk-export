<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <script src="/public/titanium/js/jquery/1_11_3/jquery-1.11.3.min.js" type="text/javascript"></script>
    <script src="/public/titanium/js/bootstrap/3_3_5/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- $add_headers -->
    <script src="one2many.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/public/titanium/js/bootstrap/3_3_5/css/bootstrap.min.css">
    <style type="text/css">
        .headerSort {
            background: url('assets/images/icon_sort.png') no-repeat right center;
            cursor: pointer;
        }
        
        .headerSortUp {
            background: url('assets/images/icon_sort-up.png') no-repeat right center;
            cursor: pointer;
        }
        
        .headerSortDown {
            background: url('assets/images/icon_sort-down.png') no-repeat right center;
            cursor: pointer;
        }
        
        .canvas-blue {
            background-color: #0096db;
        }
    </style>
    <noscript>
        <p>Javascript must be enabled to proceed.</p>
    </noscript>
</head>

<body>
    <h1>Bulk Export Course Content</h1>
    <h3>Content to Export</h3>
    <div class="row">
        <div class="col-md-2">
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="">ALL CONTENT</label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="">Course Settings</label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="">Syllabus Body</label>
            </div>


        </div>
        <div class="col-md-2">

            <div class="checkbox">
                <label>
                    <input type="checkbox" value="">Modules</label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="">Assignments</label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="">Quizzes</label>
            </div>

        </div>
        <div class="col-md-2">

            <div class="checkbox">
                <label>
                    <input type="checkbox" value="">Question Banks</label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="">Discussion Topics</label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="">Wiki Pages</label>
            </div>


        </div>
        <div class="col-md-2">

            <div class="checkbox">
                <label>
                    <input type="checkbox" value="">External Tools</label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="">Announcements</label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="">Calendar Events</label>
            </div>

        </div>
        <div class="col-md-2">

            <div class="checkbox">
                <label>
                    <input type="checkbox" value="">Rubrics</label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="">Files</label>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-7">

            <div class="checkbox">
                <label>
                    <input type="checkbox" value="">Override duplicate content.</label>
            </div>
        </div>
        <div class="col-md-5">

            <div class="checkbox">
                <label>
                    <input type="checkbox" value="">Adjust events and due dates.</label>
            </div>
        </div>
    </div>
    <hr>
    <div class="container-fluid">
        <h3>Courses Section to Receive Export</h3>
        <form>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="semister" aria-labelledby="Semister dropdown" class="control-label">Semister</label>
                    <select id="semister" class="form-control">
                        <option value="allSemister">All Semisters</option>
                        <option value="201516spwd">201516SPWD</option>
                        <option value="201516spnk">201516SPNK</option>
                        <option value="201516spcl">201516SPCL</option>
                        <option value="201516spup">201516SPUP</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="abbreviation" aria-labelledby="abbreviation dropdown" class="control-label">Abbreviation</label>
                    <select id="abbreviation" class="form-control">
                        <option value="allAbbreviations">All Abbreviations</option>
                        <option value="rhrer">RHRER</option>
                        <option value="rpsych">RPSYCH</option>
                        <option value="racct">RACCT</option>
                        <option value="rcas">RCAS</option>
                    </select>
                </div>
                <div class="form-group col-md-1">
                    <label for="number" class="control-label">Number</label>
                    <input type="text" value='' size="5" id="number" placeholder="number" class="form-control">
                </div>
                <div class="form-group col-md-1">
                    <label for="section" class="control-label">Section</label>
                    <input type="text" value='' size="5" id="section" placeholder="section" class="form-control">
                </div>
                <div class="form-group col-md-2">
                    <label for="title" class="control-label">Title</label>
                    <input type="text" value='' size="8" id="title" placeholder="enter title" class="form-control">
                </div>
                <div class="form-group col-md-2">
                    <label for="export-status" aria-labelledby="export status dropdown" class="control-label">Export Status</label>
                    <select id="export-status" class="target form-control">
                        <option value="noExportsPending">No Exports Pending</option>
                        <option value="exportsPending">Exports Pending</option>
                    </select>
                </div>
                <div class="form-group col-md-2 text-right">
                    <input type="button" class="btn btn-primary canvas-blue" data-target=".js-export-modal" data-toggle="modal" value="Bulk Export" style="margin-top:10px" />
                </div>
            </div>
        </form>
        <!--No-bulk export-pending table-->
        <table class="table table-bordered table-striped" width="100%" id="no-exports-pending-table">
            <colgroup>
                <col width="4%">
                    <col width="37%">
                    <col width="24%">
                    <col width="11%">
                    <col width="15%">
                    <col width="9%">
            </colgroup>
            <thead>
                <tr style="background-color:#E6E6E6">
                    <th>
                        <input type="checkbox" id='select-all'>
                    </th>
                    <th class="headerSort">Title</th>
                    <th class="headerSort">ANGEL ID</th>
                    <th class="headerSort">Schedule #</th>
                    <th class="headerSort">Instructor</th>
                    <th class="headerSort">History</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <input type="checkbox" name="select-course" />
                    </td>
                    <td>HRER_816,Section 2: Labor Market Analysis(SP16)</td>
                    <td>201516SPWD__RHRER_816_002</td>
                    <td>658201</td>
                    <td>Morris,Sonya</td>
                    <td><span>05-07-2016</span></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="select-course" />
                    </td>
                    <td>HRER_825,Section 1:Strategic Business Tool for HRER Professionals(SP16)</td>
                    <td>201516SPWD__RHRER_825_001</td>
                    <td>648022</td>
                    <td>Santella,Michael</td>
                    <td><span>05-07-2016</span></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="select-course" />
                    </td>
                    <td>HRER_825,Section 2:Strategic Business Tool for HRER Professionals(SP16)</td>
                    <td>201516SPWD__RHRER_825_002</td>
                    <td>648019</td>
                    <td>Bennett,Mark</td>
                    <td><span>05-07-2016</span></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="select-course" />
                    </td>
                    <td>HRER_825,Section 3:Strategic Business Tool for HRER Professionals(SP16)</td>
                    <td>201516SPWD__RHRER_825_003</td>
                    <td>658204</td>
                    <td>Morris,Sonya</td>
                    <td><span>05-08-2016</span></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="select-course" />
                    </td>
                    <td>HRER_836,Section 1:Diversity in the Workplace(SP16)</td>
                    <td>201516SPWD__RHRER_836_001</td>
                    <td>648013</td>
                    <td>Bennett,Mark</td>
                    <td><span>08-05-2016</span></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="select-course" />
                    </td>
                    <td>HRER_836,Section 2:Diversity in the Workplace(SP16)</td>
                    <td>201516SPWD__RHRER_836_002</td>
                    <td>648010</td>
                    <td>Morris,Sonya</td>
                    <td><span style='color:#ff0000'>!ERROR</span></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="select-course" />
                    </td>
                    <td>HRER_836,Section 3:Diversity in the Workplace(SP16)</td>
                    <td>201516SPWD__RHRER_836_003</td>
                    <td>648007</td>
                    <td>Ayers,Jeff</td>
                    <td><span>08-05-2016</span></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="select-course" />
                    </td>
                    <td>HRER_860,Section 1:Ethical Decision Making for HR Practitioners(SP16)</td>
                    <td>201516SPWD__RHRER_860_001</td>
                    <td>648004</td>
                    <td>Santella,Michael</td>
                    <td><span style='color:#ff0000'>!ERROR</span></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="select-course" />
                    </td>
                    <td>HRER_860,Section 2:Ethical Decision Making for HR Practitioners(SP16)</td>
                    <td>201516SPWD__RHRER_860_002</td>
                    <td>656140</td>
                    <td>Parker,David</td>
                    <td><span>05-01-2016</span></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="select-course" />
                    </td>
                    <td>HRER_894,Merge Sections 1 and 2: Research Topics(SP16)</td>
                    <td>Mrg-1234-56789 201516SPWD__RHRER_894_001 201516SPWD__RHRER_894_002
                    </td>
                    <td>647704 647701
                    </td>
                    <td>Bennett,Mark</td>
                    <td><span style='color:#ff0000'>!ERROR</span></td>
                </tr>
            </tbody>
        </table>
        <!-----------------No-bulk export-pending table------------------------------->

        <!----------------------bulk-exports-pending-table----------------------------------------------->
        <table class="table table-bordered table-striped hidden" id="exports-pending-table">
            <colgroup>
                <col width="15%">
                    <col width="18%">
                        <col width="25%">
                        <col width="4%">
                        <col width="16%">
                        <col width="7%">
                        <col width="15%">
            </colgroup>
            <thead>
                <tr style="background-color:#E6E6E6">
                    <th class="headerSort">Requested</th>
                    <th class="headerSort">Requested By</th>
                    <th class="headerSort">Title</th>
                    <th class="headerSort">ANGEL ID</th>
                    <th class="headerSort">Schedule #</th>
                    <th class="headerSort">Instructor</th>
                    <th class="headerSort">Progress</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>04-05-2016 at 4:01:03 PM</td>
                    <td>lmd5</td>
                    <td>HRER_825,Section 1:Strategic Business Tool for HRER Professionals(SP16)</td>
                    <td>201516SPWD__RHRER_825_001</td>
                    <td>648022</td>
                    <td>Santella,Michael</td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar canvas-blue" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width:80%">
                                80%
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>04-05-2016 at 4:01:48 PM</td>
                    <td>lmd5</td>
                    <td>HRER_825,Section 2:Strategic Business Tool for HRER Professionals(SP16)</td>
                    <td>201516SPWD__RHRER_825_002</td>
                    <td>648019</td>
                    <td>Bennett,Mark</td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar canvas-blue" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%">
                                70%
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>04-05-2016 at 4:02:13 PM</td>
                    <td>lmd5</td>
                    <td>HRER_825,Section 3:Strategic Business Tool for HRER Professionals(SP16)</td>
                    <td>201516SPWD__RHRER_825_003</td>
                    <td>658204</td>
                    <td>Morris,Sonya</td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar canvas-blue" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width:30%">
                                30%
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>

                    <td>04-05-2016 at 4:02:21 PM</td>
                    <td>lmd5</td>
                    <td>HRER_894,Merge Sections 1 and 2: Research Topics(SP16)</td>
                    <td>Mrg-1234-56789 201516SPWD__RHRER_894_001 201516SPWD__RHRER_894_002
                    </td>
                    <td>647704 647701
                    </td>
                    <td>Bennett,Mark</td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar canvas-blue progress-bar-striped active" role="progressbar" aria-valuenow="99.5" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                                99.5%
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="row">
            <div class="col-md-2">
                <input type="submit" class="btn btn-primary canvas-blue" data-target=".js-export-modal" data-toggle="modal" value="Bulk Export" />
            </div>
            <div class="col-md-10">
                <ul class="pagination pull-right" style="margin:0;">
                    <li class="disabled">
                        <a href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="disabled">
                        <a href="#" aria-label="Previous">
                            <span aria-hidden="true">&#60;</span>
                        </a>
                    </li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">6</a></li>
                    <li><a href="#">7</a></li>
                    <li><a href="#">8</a></li>
                    <li><a href="#">9</a></li>
                    <li><a href="#">10</a></li>
                    <li>
                        <a href="#" aria-label="Next">
                            <span aria-hidden="true">&#62;</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--Bulk-export-modal-->
    <div class="modal fade js-export-modal" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Export in Progress...</h4>
                </div>
                <div class="modal-body">
                    <p>Content is now being exported to the <strong><span>4</span> course sections</strong> you selected.</p>
                    <table class="table table-bordered table-striped">
                        <colgroup>
                            <col width="35%">
                            <col width="20%">
                            <col width="14%">
                            <col width="8%">
                            <col width="23%">
                        </colgroup>
                        <thead>
                            <tr style="background-color:#E6E6E6">
                                <th class="headerSort">Title</th>
                                <th class="headerSort">ANGEL ID</th>
                                <th class="headerSort">Schedule #</th>
                                <th class="headerSort">Instructor</th>
                                <th class="headerSort">Migration Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>HRER_816,Section 2: Labor Market Analysis(SP16)</td>
                                <td>201516SPWD__RHRER_816_002</td>
                                <td>658201</td>
                                <td>Morris,Sonya</td>

                                <td>
                                    <div class="progress">
                                        <div class="progress-bar canvas-blue" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width:80%">
                                            80%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>HRER_825,Section 1:Strategic Business Tool for HRER Professionals(SP16)</td>
                                <td>201516SPWD__RHRER_825_001</td>
                                <td>648022</td>
                                <td>Santella,Michael</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar canvas-blue" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%">
                                            70%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>HRER_825,Section 2:Strategic Business Tool for HRER Professionals(SP16)</td>
                                <td>201516SPWD__RHRER_825_002</td>
                                <td>648019</td>
                                <td>Bennett,Mark</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar canvas-blue" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width:30%">
                                            30%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>HRER_825,Section 3:Strategic Business Tool for HRER Professionals(SP16)</td>
                                <td>201516SPWD__RHRER_825_003</td>
                                <td>658204</td>
                                <td>Morris,Sonya</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar canvas-blue progress-bar-striped active" role="progressbar" aria-valuenow="99.5" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                                            99.5%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p><strong>Note:</strong> Closing this dialog will not cancel migrations.Your courses will still be migrating in the background.</p>
                </div>
                <!-- /.modal-content -->
                <div class="modal-footer">
                </div>
                <!-- /.modal-footer -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    <!--Bulk-export-modal-->
    <script>
        $(document).ready(function () {
            //export table changes while selecting export status dropdown
            $('#export-status').on('change', function (e) {
                var ele = $(this);
                if (ele.val() == 'exportsPending') {
                    $('#exports-pending-table').removeClass('hidden');
                    $('#no-exports-pending-table').addClass('hidden');
                } else if (ele.val() == 'noExportsPending') {
                    $('#no-exports-pending-table').removeClass('hidden');
                    $('#exports-pending-table').addClass('hidden');
                }
            });

            $('#select-all').on('click select', function (e) {
                var ele = $(this);
                $('#no-exports-pending-table > tbody > tr > td:nth-child(1)').find('input[type="checkbox"]').prop('checked', ele.prop('checked'));
            });

            $('#semister').on('change', function (e) {
                var ele = $(this);
                if (ele.val() == '201516spwd') {
                    console.log('201516 spwd called');
                }
                if (ele.val() == '201516spnk') {
                    console.log('201516 spnk called');
                }
                if (ele.val() == '201516spcl') {
                    console.log('201516 spcl called ');
                }
                if (ele.val() == '201516spup') {
                    console.log('201516 spup called');
                }

            });

            $('#abbreviation').on('change', function (e) {
                var ele = $(this);
                if (ele.val() == 'rhrer') {
                    console.log('rhrer called');
                }
                if (ele.val() == 'rpsych') {
                    console.log('rpsych called');
                }
                if (ele.val() == 'racct') {
                    console.log('racct called');
                }
                if (ele.val() == 'rcas') {
                    console.log('rcas called');
                }
            });

            $('#number').on('change', function (e) {
                var ele = $(this);
                console.log('number called');

            });
            $('#section').on('change', function (e) {
                var ele = $(this);
                console.log('section number called');

            });
            $('#title').on('change', function (e) {
                var ele = $(this);
                console.log('title called');
            });

            /*Icon sorting*/
            $('th').on('click select', function (e) {
                var ele = $(this);
                if (ele.hasClass('headerSort')) {
                    ele.removeClass('headerSort').addClass('headerSortUp');
                } else if (ele.hasClass('headerSortUp')) {
                    ele.removeClass('headerSortUp').addClass('headerSortDown');
                } else if (ele.hasClass('headerSortDown')) {
                    ele.removeClass('headerSortDown').addClass('headerSortUp');
                }
            });

        });
    </script>
</body>

</html>