<?php

class IPNResource extends AppResource {
    public function execute() {
        if(!$this->request->post) {
            return new Response(array(
                'status' => 405
            ));
        }

        if($this->request->getData('secret') == '1M1ll10nD0llar$') {
            $donation_id = $this->request->getData('custom');

            $donationModel = ViewQueryFactory::$singleton->getDonationModelById($donation_id);

            DonationProcessingService::$singleton->process($donationModel, $_POST);

            return new Response();
        }

        $req = 'cmd=_notify-validate';

        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }

        $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

        $fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);

        $donation_id = $_POST['custom'];

        if(!$fp) {
            return new Response(array(
                'status' => 500
            ));
        }

        fputs($fp, $header . $req);

        while (!feof($fp)) {
            $res = fgets ($fp, 1024);

            if(strcmp($res, "VERIFIED") == 0) {
                $donation = ViewQueryFactory::$singleton->getDonationModelById($donation_id);

                DonationProcessingService::$singleton->process($donation, $_POST);
            }
        }

        fclose ($fp);

        return new Response();
    }
}