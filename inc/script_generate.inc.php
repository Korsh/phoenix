<?php

$script_generate_actions = array(
    "reg_male" => array(
        "registerUser",
        "1"
    ),
    "reg_female" => array(
        "registerUser",
        "2"
    ),
    "reg_couple" => array(
        "registerUser",
        "3"
    ),
    "pay_visa" => array(
        "setPaymentFields",
        "Visa"
    ),
    "pay_master" => array(
        "setPaymentFields",
        "MasterCard"
    ),
    "pay_wrong_data" => array(
        "setPaymentFields",
        "WrongDate"
    ),
    "pay_wrong_cvv" => array(
        "setPaymentFields",
        "WrongCode"
    ),
    "generate_screenname" => array(
        "generateScreenname"
    )
);

