<style type="text/css">
	/*@media print {*/
	/*	.pagebreak {*/
	/*		page-break-before: always;*/
	/*	}*/
	/*}*/
	/*.mark-container {*/
	/*    background: #fff;*/
	/*    width: 1000px;*/
	/*    position: relative;*/
	/*    z-index: 2;*/
	/*    margin: 0 auto;*/
	/*    padding: 20px 30px;*/
	/*}*/
	/*table {*/
	/*    border-collapse: collapse;*/
	/*    width: 100%;*/
	/*    margin: 0 auto;*/
	/*}*/
</style>

<?php

function convertNumberToWord($num = false)
{
    $num = str_replace(array(',', ' '), '' , trim($num));
    if(! $num) {
        return false;
    }
    $num = (int) $num;
    $words = array();
    $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
        'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
    );
    $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
    $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
        'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
        'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
    );
    $num_length = strlen($num);
    $levels = (int) (($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num = substr('00' . $num, -$max_length);
    $num_levels = str_split($num, 3);
    for ($i = 0; $i < count($num_levels); $i++) {
        $levels--;
        $hundreds = (int) ($num_levels[$i] / 100);
        $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
        $tens = (int) ($num_levels[$i] % 100);
        $singles = '';
        if ( $tens < 20 ) {
            $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
        } else {
            $tens = (int)($tens / 10);
            $tens = ' ' . $list2[$tens] . ' ';
            $singles = (int) ($num_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
    } //end for loop
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    return implode(' ', $words);
}

if (count($student_array)) {
	foreach ($student_array as $sc => $studentID) {
		$result = $this->exam_model->getStudentReportCard($studentID, $examID, $sessionID);
		$student = $result['student'];
		$getMarksList = $result['exam'];

		$getExam = $this->db->where(array('id' => $examID))->get('exam')->row_array();
		$getSchool = $this->db->where(array('id' => $getExam['branch_id']))->get('branch')->row_array();
		$schoolYear = get_type_name_by_id('schoolyear', $sessionID, 'school_year');
		?>
		
		<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous" />
    <!-- <link rel="stylesheet" href="./assets/css/main.css" /> -->
    <style>
        .bold {
            font-weight: bold;
        }

        .strip_col {
            background-color: #f4f4f4;
        }

        body {
            background-color: white;
            font-size: 12px;
            box-sizing: border-box;
        }

        .wrapper #logo {
            position: absolute;
        }

        .wrapper .caption {
            text-align: center;
            font-weight: bold;
            caption-side: top;
            color: black;
            text-transform: uppercase;
            padding: 0;
        }

        .wrapper .school-data {
            text-align: center;
        }

        .wrapper .school-data * {
            font-size: 12px;
        }

        .wrapper .school-data .name,
        .wrapper .school-data span,
        .wrapper .school-data .address,
        .wrapper .school-data .motto {
            text-transform: uppercase;
        }

        .wrapper .school-data .name,
        .wrapper .school-data span,
        .wrapper .school-data .motto {
            font-weight: 600;
        }

        .wrapper .school-data span {
            font-size: 14px;
        }

        .wrapper .school-data .name {
            font-size: 18px;
        }

        .wrapper .student-data {
            margin: 2px 0;
        }

        .wrapper .student-data .key {
            display: block;
            text-transform: capitalize;
            font-weight: 600;
        }

        .wrapper .student-data .key .value {
            text-transform: uppercase;
        }

        .wrapper .remark {
            display: flex;
            margin-bottom: 18px;
        }

        .wrapper .remark div {
            height: 185px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            /* width: 50%; */
            border: 1px solid black;
            text-transform: uppercase;
            flex: 2.23;
        }

        .wrapper .remark div:first-child {
            flex: 1;
            border: none;
            display: block;
            text-transform: capitalize;
            font-weight: 600;
        }

        .wrapper .remark div h6 {
            font-size: 10px;
            text-align: center;
            margin: 0;
        }

        .wrapper .remark div span h6:first-child {
            text-align: left;
            width: 120px;
            border-bottom: 1px solid black;
            padding-left: 5px;
        }

        table {
            border-collapse: collapse;
            margin: 0;
            width: 100%;
        }

        table th,
        table td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 2px 8px !important;
            display: table-cell;
            text-transform: capitalize;
        }

        table td {
            vertical-align: middle;
            text-align: center;
        }

        table tr {
            vertical-align: middle;
            display: table-row;
        }

        /*
RIGHT TABLE
*/
        .table-right .vertical {
            text-align: center !important;
            text-transform: capitalize;
            margin: auto;
            font-size: 12px;
            background-color: transparent;
            position: relative;
        }

        .table-right .vertical span {
            -ms-writing-mode: tb-rl;
            -webkit-writing-mode: vertical-rl;
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            white-space: nowrap;
        }

        .table-left td,
        .table-left th {
            padding: 20px;
        }

        /*# sourceMappingURL=main.css.map */

        @media print {
            @page {
                /* size: auto !important */
                size: A3;
                margin-left: 0.5cm;
                margin-right: 0.5cm;
                margin-top: 0.5cm;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="school-data" style="position: relative">
                        <img id="logo" src="./assets/imgs/" alt="" style="
                                    height: 120px;
                                    width: 120px;
                                    border: 1px solid grey;
                                    z-index: 4;
                                    position: absolute;
                                    left: 0;
                                " />
                        <div>
                            <h1 class="name">
                                lina teresa foundation secondary school
                            </h1>
                            <h3 class="address">
                                No. 10 umunnaji street, maryland, enugu
                            </h3>
                            <h4 class="contact">
                                linateresafoundationsec@gmail.com
                            </h4>
                            <h4 class="contact">
                                0803271806, 08064376241, 08062083913
                            </h4>
                            <h1 class="motto">
                                motto: scientia et moribus: knowledge and
                                moralty
                            </h1>
                            <span>annual result</span>
                        </div>
                    </div>
                </div>
                <div class="col-7">
                    <div class="student-data">
                        <span class="key">name of student:
                            <span class="value"><?=$student['first_name'] . " " . $student['last_name']?></span></span>
                        <span class="key">registration number:
                            <span class="value"><?=$student['register_no']?></span></span>
                        <span class="key">gender: <span class="value"><?=ucfirst($student['gender'])?></span></span>
                        <span class="key">date of birth:
                            <span class="value"><?=_d($student['birthday'])?></span></span>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table-right">
                                <tr>
                                    <th colspan="4">Key To Grades</th>
                                    <th colspan="4" rowspan="10" class="vertical">
                                        <span>
                                            first term score
                                            <br />
                                            Max score (100)
                                        </span>
                                    </th>
                                    <th colspan="4" rowspan="10" class="vertical">
                                        <span>
                                            second term Score
                                            <br />
                                            max score(100)
                                        </span>
                                    </th>
                                    <th colspan="4" rowspan="10" class="vertical">
                                        <span>
                                            third term Score
                                            <br />
                                            max score(100)
                                        </span>
                                    </th>
                                    <th colspan="4" rowspan="10" class="vertical">
                                        <span>
                                            total
                                            <br />
                                            max score(100)
                                        </span>
                                    </th>
                                    <th colspan="4" rowspan="10" class="vertical">
                                        <span>
                                            average
                                            <br />
                                            max score(100)
                                        </span>
                                    </th>
                                    <th colspan="4" rowspan="10" class="vertical">
                                        <span> grade </span>
                                    </th>
                                    <th colspan="4" rowspan="10" class="vertical">
                                        <span> subject position </span>
                                    </th>
                                    <th colspan="6" rowspan="10" style="min-width: 100px" class="vertical">
                                        <span> Remark </span>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="4">
                                        A1 (75 - 100) Excellent
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="4">
                                        B2 (70 - 74) Very Good
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="4">B3 (65 - 69) Good</th>
                                </tr>
                                <tr>
                                    <th colspan="4">C4 (60 - 64) Credit</th>
                                </tr>
                                <tr>
                                    <th colspan="4">C5 (55 - 59) Credit</th>
                                </tr>
                                <tr>
                                    <th colspan="4">C6 (50 - 54) Credit</th>
                                </tr>
                                <tr>
                                    <th colspan="4">D7 (45 - 49) Pass</th>
                                </tr>
                                <tr>
                                    <th colspan="4">E8 (40 - 44) Pass</th>
                                </tr>
                                <tr>
                                    <th colspan="4">F9 (0 - 39) Fail</th>
                                </tr>
                                <?php
                        			$colspan = count($markDistribution) + 1;
                        			$total_grade_point = 0;
                        			$grand_obtain_marks = 0;
                        			$grand_full_marks = 0;
                        			$result_status = 1;
                        			foreach ($getMarksList as $i => $row) {
                        			?>
                        				<tr>
                                            <th colspan="4" class="text-uppercase <?= $i%2 == 1 ? 'strip_col' : ''; ?>">
                                                <?=$row['subject_name']?>
                                            </th>
                                            <td colspan="4"></td>
                                            <td colspan="4"></td>
                                            <td colspan="4"></td>
                                            <td colspan="4"></td>
                                            <td colspan="4"></td>
                                            <td colspan="4"></td>
                                            <td colspan="4"></td>
                                            <td colspan="4"></td>
                                        </tr>
                        			<?php } ?>
                            </table>
                        </div>
                        <div class="col-12 mt-3">
                            <table class="table-right">
                                <tr>
                                    <th colspan="15" class="caption">
                                        result summary
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="1">Grades</th>
                                    <td class="bold">a1</td>
                                    <td class="bold">b2</td>
                                    <td class="bold">b3</td>
                                    <td class="bold">c4</td>
                                    <td class="bold">c5</td>
                                    <td class="bold">c6</td>
                                    <td class="bold">d7</td>
                                    <td class="bold">e8</td>
                                    <td class="bold">f9</td>
                                </tr>
                                <tr>
                                    <th colspan="1">Number of subjects</th>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="1">PROMOTED</th>
                                    <td class="bold">YES</td>
                                    <td class="bold">NO</td>
                                </tr>
                                <tr>
                                    <th colspan="1" style="height: 20px"></th>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="remark">
                                <div>
                                    <span class="bold">form teacher's remark</span>
                                </div>
                                <div>
                                    <span>
                                        <h6>mrs. okeke nkiru</h6>
                                        <h6>name</h6>
                                    </span>
                                    <span>
                                        <h6></h6>
                                        <h6>sign/date</h6>
                                    </span>
                                </div>
                            </div>
                            <div class="remark">
                                <div>
                                    <span class="bold">principal's remark</span>
                                </div>
                                <div>
                                    <span>
                                        <h6>mr. ozor stephen</h6>
                                        <h6>name</h6>
                                    </span>
                                    <span>
                                        <h6></h6>
                                        <h6>sign/date</h6>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-5 table-border">
                    <div class="student-data">
                        <span class="key">class:
                            <span class="value"><?=$student['class_name'] . " (" . $student['section_name'] . ")"?></span></span>
                        <span class="key">year:
                            <span class="value">2020/2021</span></span>
                        <span class="key">total score: <span class="value"></span></span>
                        <span class="key">average: <span class="value"></span></span>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table-right" style="width: 100%">
                                <tr>
                                    <th colspan="4">Key To Grades</th>
                                    <th colspan="4" rowspan="10" class="vertical">
                                        <span> Max Score </span>
                                    </th>
                                    <th colspan="4" rowspan="10" class="vertical">
                                        <span> Student's Score </span>
                                    </th>
                                    <th colspan="4" rowspan="10" class="vertical">
                                        <span> Grade </span>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="4">
                                        A1 (75 - 100) Excellent
                                    </th>
                                    <!-- <th  colspan="4" rowspan="3"></th> -->
                                </tr>
                                <tr>
                                    <th colspan="4">
                                        B2 (70 - 74) Very Good
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="4">B3 (65 - 69) Good</th>
                                </tr>
                                <tr>
                                    <th colspan="4">C4 (60 - 64) Credit</th>
                                </tr>
                                <tr>
                                    <th colspan="4">C5 (55 - 59) Credit</th>
                                </tr>
                                <tr>
                                    <th colspan="4">C6 (50 - 54) Credit</th>
                                </tr>
                                <tr>
                                    <th colspan="4">D7 (45 - 49) Pass</th>
                                </tr>
                                <tr>
                                    <th colspan="4">E8 (40 - 44) Pass</th>
                                </tr>
                                <tr>
                                    <th colspan="4">F9 (0 - 39) Fail</th>
                                </tr>
                                <tr>
                                    <th colspan="15" class="caption">
                                        social behaviour
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="7">1. Punctuality</th>
                                    <td>10</td>
                                    <td></td>
                                    <td rowspan="9" colspan="4"></td>
                                </tr>
                                <tr>
                                    <th colspan="7">2. Attendance</th>
                                    <td>10</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="7">3. Attentiveness</th>
                                    <td>20</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="7">4. Creativty</th>
                                    <td>10</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="7">
                                        5. Organizational ability
                                    </th>
                                    <td>10</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="7">
                                        6. carrying out of assignments
                                    </th>
                                    <td>10</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="7">7. politeness</th>
                                    <td>10</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="7">8. neatness</th>
                                    <td>10</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="7">9. honesty</th>
                                    <td>10</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="7" class="caption">
                                        Total
                                    </th>
                                    <td class="bold">100</td>
                                    <td></td>
                                    <td colspan="5"></td>
                                </tr>
                                <tr>
                                    <th colspan="15" class="caption">
                                        academic skills
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="7">1. handwritng</th>
                                    <td>30</td>
                                    <td></td>
                                    <td rowspan="4" colspan="4"></td>
                                </tr>
                                <tr>
                                    <th colspan="7">2. reading</th>
                                    <td>30</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="7">
                                        3. handling of lab tools
                                    </th>
                                    <td>20</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="7">4. public speaking</th>
                                    <td>20</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="7" class="caption">
                                        Total
                                    </th>
                                    <td class="bold">100</td>
                                    <td></td>
                                    <td colspan="5"></td>
                                </tr>
                                <tr>
                                    <th colspan="15" class="caption">
                                        entrepreneurship
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="7">1. first assessment</th>
                                    <td>20</td>
                                    <td></td>
                                    <td rowspan="3" colspan="4"></td>
                                </tr>
                                <tr>
                                    <th colspan="7">
                                        2. second assessment
                                    </th>
                                    <td>20</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="7">3. examination</th>
                                    <td>60</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="7" class="caption">
                                        Total
                                    </th>
                                    <td class="bold">100</td>
                                    <td></td>
                                    <td colspan="5"></td>
                                </tr>
                                <tr>
                                    <th colspan="15" class="caption">
                                        art skills
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="7">1. drawing</th>
                                    <td>20</td>
                                    <td></td>
                                    <td rowspan="6" colspan="4"></td>
                                </tr>
                                <tr>
                                    <th colspan="7">2. painting</th>
                                    <td>20</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="7">3. dancing</th>
                                    <td>20</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="7">4. singing</th>
                                    <td>20</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="7">
                                        5. playing local musical instruments
                                    </th>
                                    <td>10</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="7">
                                        6. conducting band/choir
                                    </th>
                                    <td>10</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="7" class="caption">
                                        Total
                                    </th>
                                    <td class="bold">100</td>
                                    <td></td>
                                    <td colspan="5"></td>
                                </tr>
                                <tr>
                                    <th colspan="15" class="caption">
                                        game/sport skills
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="7">1. skipping</th>
                                    <td>10</td>
                                    <td></td>
                                    <td rowspan="7" colspan="4"></td>
                                </tr>
                                <tr>
                                    <th colspan="7">2. athletics</th>
                                    <td>10</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="7">3. football</th>
                                    <td>20</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="7">4. volleyball</th>
                                    <td>20</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="7">5. basketball</th>
                                    <td>10</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="7">6. table tennis</th>
                                    <td>10</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="7">7. scrabble</th>
                                    <td>20</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="7" class="caption">
                                        Total
                                    </th>
                                    <td class="bold">100</td>
                                    <td></td>
                                    <td colspan="5"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php

    }
} ?>