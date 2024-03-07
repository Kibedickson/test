<?php
$serverName = "test";
$connectionOptions = array(
    "Database" => "test",
    "Uid" => "sa",
    "PWD" => "Qwerty@123"
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

if (!$conn) {
    die(print_r(sqlsrv_errors(), true));
}

$query = "
select
la.status,
COUNT(*) AS count
from leave_applications la
inner join leave_calenders lc on lc.id = la.leave_calender_id and lc.status = 1 and lc.deleted_at is null
where la.deleted_at is null
group by la.status;";

$result = sqlsrv_query($conn, $query);

if (!$result) {
    die(print_r(sqlsrv_errors(), true));
}

$data = array();
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
}
sqlsrv_close($conn);

echo json_encode($data);
