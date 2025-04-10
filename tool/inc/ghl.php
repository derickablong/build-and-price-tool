<?php

namespace GO_BPT;

trait GO_BPT_GHL
{
    public function capture()
    {
        if (isset($_GET['fname'])) {
            
            $id      = isset($_GET['id']) ? $_GET['id'] : '';
            $fname   = isset($_GET['fname']) ? $_GET['fname'] : '';
            $lname   = isset($_GET['lname']) ? $_GET['lname'] : '';
            $company = isset($_GET['company']) ? $_GET['company'] : '';
            $phone   = isset($_GET['phone']) ? $_GET['phone'] : '';
            $email   = isset($_GET['email']) ? $_GET['email'] : '';            
            
            $address = isset($_GET['address']) ? $_GET['address'] : '';
            $city    = isset($_GET['city']) ? $_GET['city']: '';
            $state   = isset($_GET['state']) ? $_GET['state'] : '';
            $country = isset($_GET['country']) ? $_GET['country'] : '';
            $postal  = isset($_GET['postal']) ? $_GET['postal'] : '';

            $discount = isset($_GET['discount']) ? $_GET['discount'] : '';
            $question = isset($_GET['question']) ? $_GET['question'] : '';
            $about_us = isset($_GET['about_us']) ? $_GET['about_us'] : '';

            $this->update(
                [
                    'shipping_details' => json_encode([
                        'fname'    => $fname,
                        'lname'    => $lname,
                        'company'  => $company,
                        'phone'    => $phone,
                        'address'  => $address,
                        'city'     => $city,
                        'state'    => $state,
                        'country'  => $country,
                        'postal'   => $postal,
                        'email'    => $email,
                        'discount' => $discount,
                        'question' => $question,
                        'about_us' => $about_us
                    ])
                ],
                ['token' => $id],
                ['%s'],
                ['%s']
            );

        }
    }
}