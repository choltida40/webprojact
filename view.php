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
    <title>Generation inspacetion test details</title>
    <style>
        table {
            width: 100%;
        }

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
</head>

<body>
    <table>
        <tr>
            <th>NO</th>
            <th>QC Code</th>
            <th>Master Test ID</th>
            <th>Part NO</th>
            <th>Loc ID</th>
            <th>mis Total QTY</th>
            <th>Lot NO</th>
            <th>Sample QTY</th>
            <th>Mat Lot</th>
            <th>Gen value</th>
        </tr>
        <?php
        //"SELECT * FROM `mistest` NATURAL JOIN `master_test_headers` WHERE `QrCode` = '$id' AND Active = 1 "
        $mistest = $conn->query("SELECT * FROM `mistest` NATURAL JOIN `master_test_headers` WHERE Active = 1 ");
        if ($mistest->num_rows > 0) {
            $NO = 1;
            while ($row = $mistest->fetch_assoc()) {
                echo "
                <tr>
                    <td>$NO</td>
                    <td>" . $row["QrCode"] . "</td>
                    <td>" . $row["MasterTestID"] . "</td>
                    <td>" . $row["PartNO"] . "</td>
                    <td>" . $row["LocID"] . "</td>
                    <td>" . $row["mis_TotalQTY"] . "</td>
                    <td>" . $row["LotNO"] . "</td>
                    <td>" . $row["SampleQTY"] . "</td>
                    <td>" . $row["MatLot"] . "</td>
                    <td>
                        <form action=\"view_it.php\" method=\"post\" target=\"_blank\">
                            <input type=\"text\" name=\"MasterTestID\" id=\"\" value=\"" . $row["MasterTestID"] . "\" hidden>
                            <input type=\"text\" name=\"QrCode\" id=\"\" value=\"" . $row["QrCode"] . "\" hidden>
                            <input type=\"text\" name=\"PartNO\" id=\"\" value=\"" . $row["PartNO"] . "\" hidden>
                            <input type=\"text\" name=\"LocID\" id=\"\" value=\"" . $row["LocID"] . "\" hidden>
                            <input type=\"text\" name=\"TotalQTY\" id=\"\" value=\"" . $row["mis_TotalQTY"] . "\" hidden>
                            <input type=\"text\" name=\"LotNO\" id=\"\" value=\"" . $row["LotNO"] . "\" hidden>
                            <input type=\"text\" name=\"SampleQTY\" id=\"\" value=\"" . $row["SampleQTY"] . "\" hidden>
                            <input type=\"text\" name=\"MatLot\" id=\"\" value=\"" . $row["MatLot"] . "\" hidden>
                            <input type=\"submit\" name=\"submit\" value=\"Random\">
                        </form>
                    </td>
                </tr>
                ";
                $NO++;
            }
        } else {
            echo "
                <tr>
                    <td colspan=\"8\">Empty!</td>
                </tr>
                ";
        }
        ?>

    </table>

</body>

</html>
<?php
// $data = $_POST["data"];
// $data_json = json_decode($data, true);
// $MasterTestID = $data_json["MasterTestID"];
// $LotNO = $data_json["LotNO"];
// $LocID = $data_json["LocID"];
// $TotalQTY = $data_json["TotalQTY"];
// $SampleQTY = $data_json["SampleQTY"];
// $MatLot = $data_json["MatLot"];
// /* Check database  */
// //$Checkdata = false;
// $SQL = "INSERT INTO inspect_test_headers (MasterTestID,TotalQTY,LotNO,LocID,SampleQTY,MatLotNO) VALUES ";
// $SQLCHECK = "SELECT * FROM inspect_test_headers WHERE MasterTestID = $MasterTestID AND TotalQTY = '$TotalQTY' AND LotNO = '$LotNO' AND LocID = $LocID AND SampleQTY = '$SampleQTY' AND MatLotNO = '$MatLot'";
// $resultSQLCHECK = $conn->query($SQLCHECK);
// if ($resultSQLCHECK->num_rows > 0) {
//     while ($row = mysqli_fetch_assoc($resultSQLCHECK)) {
//         $output[] = $row;
//     }
//     //print(json_encode($output)); 
//     $SQL = $SQLCHECK;
// } else {
//     /* INSERT data of inspection test headers */
//     $SQL .= "($MasterTestID,'$TotalQTY','$LotNO',$LocID,'$SampleQTY','$MatLot')";
// }

// if ($conn->query($SQL) == TRUE) {
//     $response['error'] = false;
//     $response['message'] = "Saved";
// } else {
//     $response['error'] = true;
//     $response['message'] = "Error: " . $conn->error;
// }
