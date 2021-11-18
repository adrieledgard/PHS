<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;

class member extends Model
{
    public $table = 'member';
    public $primaryKey = 'Id_member';
    public $timestamps = false;
    public $fillable = ['Id_member','Username','Email','Phone','Password','Role','Status','Random_code','Referral','First_transaction','Point'];
    public $incrementing = true;


    public function insertdata ($username, $email, $phone, $pass) //cust
    {
        $kodeaff="";
        $Id_member_affiliate=0;
        if(Cookie::has("Affiliate"))   
		{
			$kodeaff  = Cookie::get('Affiliate');

            $dm = member::where('Random_code','=', $kodeaff)
            ->get();

            $Id_member_affiliate = $dm[0]['Id_member'];
		}


        $data  = Cookie::get('username_login');
       
        $du = member::where('Username','=', $username)
                ->orwhere('Email','=',$email)
                ->orwhere('Phone','=',$phone)
                ->get();

        if(count($du)==0)
        {
            member::create(
            [
                // referral
                'Id_member' => null,
                'Username' => strtoupper($username),
                'Email' => strtoupper($email),
                'Phone' => strtoupper($phone),
                'Password' => md5($pass),
                'Role' => "CUST",
                'Status' =>1,
                'Random_code' => uniqid(),
                'Referral' =>  $Id_member_affiliate
                
            ]
            );
            return "sukses";
        }
        else
        {
            return "kembar";
        }


    }


    public function insertdata_teammember ($username, $email, $phone, $pass, $role, $status) //Tim member
    {
       
        $du = member::where('Username','=', $username)
                ->orwhere('Email','=',$email)
                ->orwhere('Phone','=',$phone)
                ->get();

        if(count($du)==0)
        {
            member::create(
            [
                'Id_member' => null,
                'Username' => strtoupper($username),
                'Email' => strtoupper($email),
                'Phone' => strtoupper($phone),
                'Password' => md5($pass),
                'Role' => strtoupper($role),
                'Status' => $status
            ]
            );
            return "sukses";
        }
        else
        {
            return "kembar";
        }


    }

    public function edit_team_member($id,$username,$email ,$phone,$password,$role,$status) //tim member
    {

        $du = member::where('Username','=', $username)
        ->where('Id_member','<>',$id)
        ->get();

        $de = member::where('Email','=', $email)
        ->where('Id_member','<>',$id)
        ->get();

        $dp = member::where('Phone','=', $phone)
        ->where('Id_member','<>',$id)
        ->get();

      
        if(count($du)==0 && count($de)==0 && count($dp)==0)
        {
            if($password=="")
            {
                member::where('Id_member','=',$id)->update(array(
                    'Username' => strtoupper($username),
                    'Email'=>strtoupper($email),
                    'Phone'=>strtoupper($phone),
                    'Status' => $status
                ));
                return "sukses";
            }
            else
            {
                member::where('Id_member','=',$id)->update(array(
                    'Username' => strtoupper($username),
                    'Email'=>strtoupper($email),
                    'Password'=>md5($password),
                    'Phone'=>strtoupper($phone),
                    'Status' => $status
                ));
                return "sukses";
            }
    
        }
        else
        {
            return "failed";
        }

    }

    public function edit_team_member_cust($id,$username,$email ,$phone)
    {
        
        $du = member::where('Username','=', $username)
        ->where('Id_member','<>',$id)
        ->get();

        $de = member::where('Email','=', $email)
        ->where('Id_member','<>',$id)
        ->get();

        $dp = member::where('Phone','=', $phone)
        ->where('Id_member','<>',$id)
        ->get();

      
        if(count($du)==0 && count($de)==0 && count($dp)==0)
        {
            member::where('Id_member','=',$id)->update(array(
                'Username' => strtoupper($username),
                'Email'=>strtoupper($email),
                'Phone'=>$phone,
            ));
            return "sukses";
          
    
        }
        else
        {
            return "failed";
        }
    }


    public function ceklogin ($username_email, $password)
    {
        

        $du = member::where(function($query) use($username_email)
        {
            $query->where('username','=', $username_email);
            $query->orwhere('email','=', $username_email);
        })
        ->where('password', '=', md5($password))
        ->where('status','=',1)
        ->get();
        if(count($du)==0)
        {
            return "failed";
        }
        else
        {
            foreach($du as $row)
            {
                return $row;
            }
        }
    }





    public function getteammember($kodeteam)
    {
        return member::where('Id_member', '=', $kodeteam)
                        ->get();
    }


    public function edit_point($Id_member,$Point)
    {
        member::where('Id_member','=',$Id_member)->update(array(
            'Point' => strtoupper($Point),
        ));
    }
}


