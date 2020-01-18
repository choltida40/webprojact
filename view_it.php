<?php
require_once('./config/dbconf.php');
$conn = newConnect();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Random ITH</title>
    <style>
        th {
            height: 50px;
        }

        th,
        td {
            border-bottom: 1px solid #ddd;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
        }
    </style>
    <script>
        function ramdom() {

        }
    </script>
</head>

<body>
    <div>
        <table style="margin: 0 auto; width: 300px;">
            <?php
            $InspectTestID = null;
            $MasterTestID = $LotNO = $LocID = $TotalQTY = $SampleQTY = $MatLot = null;
            if (isset($_POST["MasterTestID"])) {
                $MasterTestID = $_POST["MasterTestID"];
                $LotNO = $_POST["LotNO"];
                $LocID = $_POST["LocID"];
                $TotalQTY = $_POST["TotalQTY"];
                $SampleQTY = $_POST["SampleQTY"];
                $MatLot = $_POST["MatLot"];
                /* Check database  */
                //$Checkdata = false;
                $SQLCHECK = "SELECT * FROM inspect_test_headers WHERE MasterTestID = $MasterTestID AND TotalQTY = '$TotalQTY' AND LotNO = '$LotNO' AND LocID = $LocID AND SampleQTY = '$SampleQTY' AND MatLotNO = '$MatLot'";
                $resultSQLCHECK = $conn->query($SQLCHECK);
                if ($resultSQLCHECK->num_rows > 0) {
                    $row = $resultSQLCHECK->fetch_assoc();
                    $InspectTestID = $row["InspectTestID"];
                    echo "
                <tr>
                    <td>InspecTestID</td>
                    <td>$InspectTestID</td>
                </tr>
                <tr>
                    <td>MasterTestID</td>
                    <td>" . $row["MasterTestID"] . "</td>
                </tr>
                <tr>
                    <td>LotNO</td>
                    <td>" . $row["LotNO"] . "</td>
                </tr>
                <tr>
                    <td>LocID</td>
                    <td>" . $row["LocID"] . "</td>
                </tr>
                <tr>
                    <td>TotalQTY</td>
                    <td>" . $row["TotalQTY"] . "</td>
                </tr>
                <tr>
                    <td>SampleQTY</td>
                    <td>" . $row["SampleQTY"] . "</td>
                </tr>
                <tr>
                    <td>InspectionDate</td>
                    <td>" . $row["InspectionDate"] . "</td>
                </tr>
                ";
                    //echo "InspectionDate:" . $row["InspectionDate"] . "  MasterTestID:" . $row["MasterTestID"] . "  LotNO:" . $row["LocID"] . "  LocID:" . $row["LocID"] . "  TotalQTY:" . $row["TotalQTY"] . "  SampleQTY:" . $row["SampleQTY"] . "  InspectionDate:" . $row["InspectionDate"];
                } else {
                    /* INSERT data of inspection test headers */
                    $SQL = "INSERT INTO inspect_test_headers (MasterTestID,TotalQTY,LotNO,LocID,SampleQTY,MatLotNO) VALUES ";
                    $SQL .= "($MasterTestID,'$TotalQTY','$LotNO',$LocID,'$SampleQTY','$MatLot')";
                    if ($conn->query($SQL) == TRUE) {
                        $SQLCHECK = "SELECT * FROM inspect_test_headers WHERE MasterTestID = $MasterTestID AND TotalQTY = '$TotalQTY' AND LotNO = '$LotNO' AND LocID = $LocID AND SampleQTY = '$SampleQTY' AND MatLotNO = '$MatLot'";
                        $resultSQLCHECK = $conn->query($SQLCHECK);
                        if ($resultSQLCHECK->num_rows > 0) {
                            $row = $resultSQLCHECK->fetch_assoc();
                            $InspectTestID = $row["InspectTestID"];
                            echo "
                            <tr>
                                <td>InspecTestID</td>
                                <td>$InspectTestID</td>
                            </tr>
                            <tr>
                                <td>MasterTestID</td>
                                <td>" . $row["MasterTestID"] . "</td>
                            </tr>
                            <tr>
                                <td>LotNO</td>
                                <td>" . $row["LotNO"] . "</td>
                            </tr>
                            <tr>
                                <td>LocID</td>
                                <td>" . $row["LocID"] . "</td>
                            </tr>
                            <tr>
                                <td>TotalQTY</td>
                                <td>" . $row["TotalQTY"] . "</td>
                            </tr>
                            <tr>
                                <td>SampleQTY</td>
                                <td>" . $row["SampleQTY"] . "</td>
                            </tr>
                            <tr>
                                <td>InspectionDate</td>
                                <td>" . $row["InspectionDate"] . "</td>
                            </tr>
                            ";
                        }
                    } else {
                        echo "Error: " . $conn->error;
                    }
                }
            }
            ?>
        </table>
        <form action="#" method="post">
            <input type="text" name="MasterTestID" id="" value="<?php echo $MasterTestID; ?>" hidden>
            <input type="text" name="LotNO" id="" value="<?php echo $LotNO; ?>" hidden>
            <input type="text" name="LocID" id="" value="<?php echo $LocID; ?>" hidden>
            <input type="text" name="TotalQTY" id="" value="<?php echo $TotalQTY; ?>" hidden>
            <input type="text" name="SampleQTY" id="" value="<?php echo $SampleQTY; ?>" hidden>
            <input type="text" name="MatLot" id="" value="<?php echo $MatLot; ?>" hidden>
            <input type="text" name="random" id="" value="1" hidden>
            Select Members:
            <select name="userID" id="" required>
                <?php
                $sqlCheckSamples = "SELECT MemberID, Username FROM members";
                $results = $conn->query($sqlCheckSamples);
                if ($results->num_rows > 0) {
                    $NO = 1;
                    while ($row = $results->fetch_assoc()) {
                        echo '<option value="' . $row["MemberID"] . '">' . $row["Username"] . '</option>';
                        $NO++;
                    }
                } else {
                    echo '<option value="0" hidden selected>No have member</option>';
                }
                ?>
            </select>
            , Date Time:<input type="datetime-local" name="datetime" value="" required>
            , % Error Sample:<input type="text" name="percentageError" id="" value="10" required>
            , % Ignore Test Name:<input type="text" name="percentageIgnore" id="" value="10" required>
            <input type="submit" name="submit" value="Random">
        </form>
    </div>

    <?php
    if (isset($_POST["random"])) {
        # $inspectTestID = $data_json["Details"]["InspectTestID"];
        $UserID = $_POST["userID"];
        $datetime = $_POST["datetime"];
        $percentageError = $_POST["percentageError"];
        $percentageIgnore = $_POST["percentageIgnore"];
        $SQL = "SELECT * FROM `inspect_test_headers` NATURAL JOIN master_test_details WHERE InspectTestID=$InspectTestID";
        $results = $conn->query($SQL);
        if ($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) {
                if (mt_rand(1, 100) < (+$percentageIgnore)) continue;
                $SampleQTY = $row["SampleQTY"];
                $Min = $row["MinimumValue"];
                $Max = $row["MaximumValue"];
                $TestType = $row["TestValueTypeID"];
                $MasterTestDetailID = $row["MasterTestDetailID"];
                $sqlSamples = "INSERT INTO inspect_test_details (inspectTestID, MasterTestDetailID, SampleNO, Value, TextValue, IsAccepted, createBy) VALUES ";
                $sqlSamplesUpdate = "INSERT INTO inspect_test_details (InspectTestDetailID, inspectTestID, MasterTestDetailID, SampleNO, Value, TextValue, IsAccepted, updateBy, updateDate) VALUES ";
                $Update = false;
                $sqlCheckSamples = "SELECT InspectTestDetailID FROM inspect_test_details WHERE InspectTestID = $InspectTestID 
                AND MasterTestDetailID = $MasterTestDetailID AND SampleNO = 1";
                $resultCheckSamples = $conn->query($sqlCheckSamples);
                $InspectTestDetailID = 0;
                if ($resultCheckSamples->num_rows > 0) {
                    $Update = true;
                    $rowResults = $resultCheckSamples->fetch_assoc();
                    $InspectTestDetailID = $rowResults["InspectTestDetailID"];
                    $sqlSamples = $sqlSamplesUpdate;
                }
                $i = 1;
                for ($CountSample = 1; $CountSample <= $SampleQTY; $CountSample++) {
                    $AcceptText = ["Y", "N"];
                    $RandomTextValue = "";
                    $RandomValue = 0;
                    if ($TestType == "0") {
                        $Accept = 0;
                        $RandomValue = round(mt_rand($Min * 1000, $Max * 1000) / 1000, 2);
                        if (mt_rand(1, 100) < (+$percentageError)) {
                            $Accept = 1;
                            if (mt_rand(0, 1) === 0) $RandomValue += mt_rand(0.01, $Max - $Min);
                            else $RandomValue -= mt_rand(0.01, $Max - $Min);
                        }
                    } else {
                        $Accept = 0;
                        $TextType = ["OK", "NG"];
                        if (mt_rand(1, 100) < (+$percentageError)) {
                            $Accept = 1;
                        }
                        $RandomTextValue = $TextType[$Accept];
                    }
                    // $format = 'Y-m-d H:i:s';
                    // $FormDateTime = DateTime::createFromFormat($format, $datetime);
                    // $DateTime = $FormDateTime->format('Y-m-d H:i:s');
                    $IsAccepted = $AcceptText[$Accept];
                    $minutes_to_add = mt_rand(1, 5);
                    $time = new DateTime($datetime);
                    $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
                    $DateTime = $time->format('Y-m-d H:i:s');
                    $datetime = $DateTime;
                    if ($Update) $sqlSamples .= "($InspectTestDetailID, $InspectTestID, $MasterTestDetailID,$CountSample,$RandomValue,'$RandomTextValue','$IsAccepted', $UserID, '$DateTime'),";
                    elseif ($RandomTextValue == "") $sqlSamples .= "($InspectTestID, $MasterTestDetailID, $CountSample, $RandomValue, '$RandomTextValue', '$IsAccepted', $UserID),";
                    else $sqlSamples .= "($InspectTestID, $MasterTestDetailID, $CountSample, $RandomValue, '$RandomTextValue', '$IsAccepted', $UserID),";
                    $InspectTestDetailID++;
                }
                $sqlSamples = rtrim($sqlSamples, ',');
                if ($Update) {
                    $sqlSamples .= " ON DUPLICATE KEY UPDATE inspectTestID = VALUES(inspectTestID), MasterTestDetailID = VALUES(MasterTestDetailID), 
                    SampleNO = VALUES(SampleNO), Value = VALUES(Value), TextValue = VALUES(TextValue), IsAccepted = VALUES(IsAccepted), 
                    updateBy = VALUES(updateBy), updateDate = VALUES(updateDate);";
                }
                if ($conn->query($sqlSamples) === TRUE) {
                    $response['error'] = false;
                    $response['message'] = "Saved";
                } else {
                    $response['error'] = true;
                    $response['message'] = "Error: " . $conn->error;
                }
            }
        }
    }
    ?>

    <div>
        <table style="margin: 0 auto; width: 100%;">
            <tr>
                <th>NO</th>
                <th>Inspect Test Detail ID</th>
                <th>Inspect Test ID</th>
                <th>Master Test Detail ID</th>
                <th>Sample NO</th>
                <th>Value</th>
                <th>Text Value</th>
                <th>Is Accepted</th>
                <th>create By</th>
                <th>date Create</th>
                <th>update By</th>
                <th>update Date</th>
            </tr>
            <?php
            if (isset($_POST["MasterTestID"])) {
                $sqlCheckSamples = "SELECT * FROM inspect_test_details WHERE InspectTestID = $InspectTestID";
                $results = $conn->query($sqlCheckSamples);
                if ($results->num_rows > 0) {
                    $NO = 1;
                    while ($row = $results->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>$NO</td>
                            <td>" . $row["InspectTestDetailID"] . "</td>
                            <td>" . $row["InspectTestID"] . "</td>
                            <td>" . $row["MasterTestDetailID"] . "</td>
                            <td>" . $row["SampleNO"] . "</td>
                            <td>" . $row["Value"] . "</td>
                            <td>" . $row["TextValue"] . "</td>
                            <td>" . $row["IsAccepted"] . "</td>
                            <td>" . $row["createBy"] . "</td>
                            <td>" . $row["dateCreate"] . "</td>
                            <td>" . $row["updateBy"] . "</td>
                            <td>" . $row["updateDate"] . "</td>
                        </tr>
                        ";
                        $NO++;
                    }
                } else {
                    echo "
                    <tr>
                        <td colspan=\"12\">Empty!</td>
                    </tr>
                    ";
                }
            }
            ?>
        </table>
    </div>
</body>

</html>