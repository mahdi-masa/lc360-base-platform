<?php

namespace App\Http\Controllers\Donate;

use App\Http\Requests\DonationValidation;
use App\Models\Payment;
use App\Models\Donation;
use App\Models\Squad;
use App\Models\User;
use App\Enum\DonationTypeEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Zarinpal\zarinpalTransaction;
use SebastianBergmann\Type\NullType;

class DonationController extends Controller
{

    public function donate(DonationValidation $request, Payment $payment,Donation $donate,Squad $squad,User $user, zarinpalTransaction $zarinpal)
    {
        
        
        $data = $request->validated();
        // get data from person who wants to donate
        $phone = trim($data['phone']);
        $supporterFname = trim($data['fname']);
        $supporterLname = trim($data['lname']);
        $amount = trim($data['amount']);
        $description = "حمایت از $supporterFname $supporterLname";
        $callbackURL = 'http://localhost/api/v1/payment/verify';
        $response = $zarinpal->zarinpalTransaction($amount, $description, $phone, $callbackURL);
        $type = $request->route('type');
        // return response()->json([
        //     "data"=>var_dump($type)
        // ]);
        

        switch ($type) {
            case 'cash':
                $response = $zarinpal->zarinpalTransaction($amount, $description, $phone, $callbackURL, 'App\Models\Donation');
                $donateID = $donate->createDonation(Null, Null, 'cash');
                $payment->paymentCreation($amount,$description,$response,'App\Models\Donation', $donateID);
                return $zarinpal->zarinpalRedirect($response);
                break;
            case 'plant':
                if($data['person']){
                    $supportedPersonFName = trim($data['donated_person_fname']);
                    $supportedPersonLName = trim($data['donated_person_lname']);
                    $supportedPersonPhone = trim($data['donated_person_phone']);
                    
                    $user->checkToCreate($supportedPersonFName, $supportedPersonLName,$supportedPersonPhone);
                    $donatable_id = $user->returnUserID($supportedPersonFName,$supportedPersonLName, $supportedPersonPhone);
                    $donateID = $donate->createDonation('App\Models\User', $donatable_id, 'plant');
                    $payment->paymentCreation($amount,$description,$response,'App\Models\Donation', $donateID);
                    return $zarinpal->zarinpalRedirect($response);
        
                }
                break;
        }
        
       
            
            // elseif($data['group'])
            // {
                
            //     $supportedGroupName = trim($data['donated_group_name']);
            //     $supportedGroupOwner =trim($data['donated_group_owner']) ;
            //     $supportedGroupPhone = trim($data['donated_group_phone']);


            //     $response = $zarinpal->zarinpalTransaction($amount, $description, $phone, $callbackURL, 'App\Models\Donation');
            //     $squad->checkToCreate($supportedGroupName, $supportedGroupOwner, $supportedGroupPhone);
            //     $donatable_id = $squad->returnSquadID($supportedGroupName, $supportedGroupPhone);
            //     $payment->paymentCreation($amount,$description,$response,'App\Models\Donation');
            //     $donate->createDonation('App\Models\Squads', $donatable_id, 'plant');
            //     $payment->paymentCreation($amount,$description,$response,'App\Models\Donation');
                

            // }
    }


    
}
