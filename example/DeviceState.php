<?php
include_once "../keyCommon/DeviceState.class.php";

$instance2 = DeviceState::getInstance();
echo $instance2->OS;