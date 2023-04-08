<html>
    <head>
        <title>Table Data Download</title>
        <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet"/>
        <link href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css" rel="stylesheet"/>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    </head>

    <body>

        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Class</th>
                    <th>Age</th>
                    <th>Father</th>
                    <th>City</th>
                    <th>State</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <?php
$con = mysqli_connect('localhost','root','','sagar');

$sql = "SELECT * FROM school";
$result = mysqli_query($con,$sql);

while($data = $result->fetch_assoc()) {
    $name = $data['name']; //echo $name; exit;
    $phone = $data['phone']; //echo $phone; exit;
    $class = $data['class']; //echo $class; exit;
    $age = $data['age']; //echo $age; exit;
    $father = $data['father']; //echo $father; exit;
    $city = $data['city']; //echo $city; exit;
    $state = $data['state']; //echo $state; exit;

?>
                    <td><?php echo $name ?></td>
                    <td><?php echo $phone ?></td>
                    <td><?php echo $class ?></td>
                    <td><?php echo $age ?></td>
                    <td><?php echo $father ?></td>
                    <td><?php echo $city ?></td>
                    <td><?php echo $state ?></td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>Salary</th>
                </tr>
            </tfoot>
        </table>

    </body>
</html>

<script>
    $(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    } );
} );
</script>