<?php


namespace UCOM;

interface PaymentsInterface
{
    public function createRecipient();

    public function initiateTransfer();

    public function listenForNotification();
}