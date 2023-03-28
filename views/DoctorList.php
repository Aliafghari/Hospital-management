<?php
$flagButton = true;
$namePart = [];
for ($i = 0, $j = 1; $i < count($data[0]); $i++, $j++) {
    $namePart[] = $data[0][$i]['name'];
    // echo 'hi'.'<br>';
    //var_dump($namePart);
}
//var_dump($data);
//var_dump($namePart);
$correct = array_unique($namePart);
//$correct2 = array_unique($namePart2);
//var_dump($correct);
?>

<form action="/DoctorList/Search" method="POST" class="">
<div class="input-group mb-3 mt-3">
    <input type="text" class="form-control form-control-lg" name="search" placeholder="Search Here...">
    <button type="submit" class="input-group-text btn-success"><i class="bi bi-search me-2"></i> Search</button>
</div>
</form>
<div class="input-group mb-3">
    <form action="/DoctorList/Filter" method="POST" class="">
        <select class="btn btn-outline-success dropdown-toggle" name="filter" data-toggle="dropdown">
            <option  selected disable >filter...</options>
                <?php foreach ($correct as $key => $value) { ?>
            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
        <?php   }

        ?>
        </select>
        <input type="submit" name="submit" value="Go" class="btn btn-outline-success"></input>
    </form>
</div>


<!-- <div class="input-group mb-3">
    <form action="/DoctorList/Filter" method="POST" class="">
        <select class="btn btn-outline-info dropdown-toggle" name="filter" data-toggle="dropdown">
            <option selected disable>Filter by educations</options>

                <?php //foreach ($correct2 as $keys => $values) { ?>
            <option value="<?php //echo $values; ?>"><?php //echo $values; ?></option>
        <?php   //}

        ?>
        </select>
        <input type="submit" name="submit" value="Go" class="btn btn-outline-success"></input>
    </form>
</div> -->


<table class="table table-dark table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Profile</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <!-- <th scope="col">educations</th> -->
            <th scope="col">status</th>
            <th scope="col">Clinic Activity</th>
            <th scope="col">Process</th>
        </tr>
    </thead>
    <tbody>
        <?php for ($i = 0, $j = 1; $i < count($data[0]); $i++, $j++) {
            //var_dump($data[0]);  
        ?>
            <tr>
                <th scope="row"><?php echo $data[0][$i]["id"]; ?></th>
                <td>
                    <img class="img-fluid" src="../uploads/img_profile/avatar7.png" alt="" width="40">
                </td>
                <td><?php echo $data[0][$i]["firstName"]; ?></td>
                <td><?php echo $data[0][$i]['lastName']; ?></td>
                <!-- <td><?php //echo $data[0][$i]['educations']; ?></td> -->
                <td><?php if ($data[0][$i]['statuse'] == 1) {
                        echo "accept";
                    } else {
                        echo "pending";
                        $flagButton = false;
                    }
                    ?></td>
                <td><?php if($data[0][$i]['name']){
                echo $data[0][$i]['name'];}else{
                    echo 'a';
                }
                //var_dump($data[0][$i]['name']) ?></td>
                <td><?php if ($flagButton == false) { ?>

                        <button class="btn btn-danger" disabled>
                            <span class="spinner-border spinner-border-sm"></span>
                            pending..
                        </button><?php } else { ?>
                        <form method="POST" action="/DoctorList/Profile">
                            <input type="submit" class="btn  btn-outline-success" value="select" href="/DoctorList/seeProfile"></input>
                            <input type="text" hidden name="id" value="<?php echo $data[0][$i]['id']; ?>"></input>
                        </form>
                    <?php } ?>
                </td>
            </tr>
        <?php $flagButton = true;
        } ?>


    </tbody>
</table>