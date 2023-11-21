<?php

namespace App\Http\Controllers;

use App\Http\Requests\DonationValidation;
use App\Models\Payment;
use App\Models\Donation;
use App\Models\Squad;
use App\Models\User;
use Illuminate\Http\Request;
use App\Zarinpal\zarinpalTransaction;
use SebastianBergmann\Type\NullType;

class DonationController extends Controller
{

    public function donate(DonationValidation $request, Payment $payment,Donation $donate,Squad $squad,User $user, String $type)
    {
        $zarinpal = new zarinpalTransaction();
        $data = $request->validated();
        // get data from person who wants to donate
        $phone = trim($data['phone']);
        $supporterFname = trim($data['fname']);
        $supporterLname = trim($data['lname']);
        $amount = trim($data['amount']);
        $description = "حمایت از $supporterFname $supporterLname";
        $callbackURL = 's';
    
        //get data for group or person who are supported
        if($type === 'plant')
        {
            if($data['person']){
                $supportedPerson = true;
                $supportedPersonFName = trim($data['donated_person_fname']);
                $supportedPersonLName = trim($data['donated_person_lname']);
                $supportedPersonPhone = trim($data['donated_person_phone']);
                $response = $zarinpal->zarinpalTransaction($amount, $description, $phone, $callbackURL, 'App\Models\Donation');
                $user->checkToCreate($supportedPersonFName, $supportedPersonLName,$supportedPersonPhone);
                $donatable_id = $user->returnUserID($supportedPersonFName, $supportedPersonPhone);
                $payment->paymentCreation($amount,$description,$response,'App\Models\Donation');
                $donate->createDonation('App\Models\Users', $donatable_id, 'plant');
    
            }elseif($data['group'])
            {
                
                $supportedGroupName = trim($data['donated_group_name']);
                $supportedGroupOwner =trim($data['donated_group_owner']) ;
                $supportedGroupPhone = trim($data['donated_group_phone']);


                $response = $zarinpal->zarinpalTransaction($amount, $description, $phone, $callbackURL, 'App\Models\Donation');
                $squad->checkToCreate($supportedGroupName, $supportedGroupOwner, $supportedGroupPhone);
                $donatable_id = $squad->returnSquadID($supportedGroupName, $supportedGroupPhone);
                $payment->paymentCreation($amount,$description,$response,'App\Models\Donation');
                $donate->createDonation('App\Models\Squads', $donatable_id, 'plant');
                $payment->paymentCreation($amount,$description,$response,'App\Models\Donation');
                

            }else
            {
                $response = $zarinpal->zarinpalTransaction($amount, $description, $phone, $callbackURL, 'App\Models\Donation');
                $payment->paymentCreation($amount,$description,$response,'App\Models\Donation');
                $donate->createDonation(null, null, 'cash');
            }
        }

        $zarinpal->zarinpalRedirect($response);

    }


    
}
