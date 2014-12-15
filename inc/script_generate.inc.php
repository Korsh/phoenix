<?php

$scriptGenerateActions = array(
    "RegMale" => array(
        "registerUser",
        "1"
    ),
    "RegFemale" => array(
        "registerUser",
        "2"
    ),
    "RegCouple" => array(
        "registerUser",
        "3"
    ),
    "PayVisa" => array(
        "setPaymentFields",
        "Visa"
    ),
    "PayMaster" => array(
        "setPaymentFields",
        "MasterCard"
    ),
    "PayWrongData" => array(
        "setPaymentFields",
        "WrongDate"
    ),
    "PayWrongCvv" => array(
        "setPaymentFields",
        "WrongCode"
    ),
    "GenerateScreenname" => array(
        "generateScreenname"
    )
);

